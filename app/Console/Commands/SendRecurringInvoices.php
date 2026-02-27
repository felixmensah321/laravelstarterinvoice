<?php

namespace App\Console\Commands;

use App\Mail\InvoiceSent;
use App\Models\Client;
use App\Services\InvoicePdfGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendRecurringInvoices extends Command
{
    protected $signature = 'invoices:send-recurring';
    protected $description = 'Generate and send recurring invoices for eligible clients';

    public function handle(InvoicePdfGenerator $pdfGenerator): int
    {
        $clients = Client::where('recurring_enabled', true)
            ->whereNotNull('next_invoice_date')
            ->where('next_invoice_date', '<=', now()->toDateString())
            ->get();

        if ($clients->isEmpty()) {
            $this->info('No recurring invoices to process.');
            return self::SUCCESS;
        }

        $sent = 0;
        $skipped = 0;

        foreach ($clients as $client) {
            $latestInvoice = $client->invoices()->latest()->first();

            if (!$latestInvoice) {
                $this->warn("Client '{$client->name}' (ID: {$client->id}) has no previous invoice to clone. Skipping.");
                Log::warning("Recurring invoice skipped for client {$client->id}: no previous invoice.");
                $skipped++;
                continue;
            }

            $settings = $client->user->getOrCreateSetting();
            $invoiceNumber = $settings->generateInvoiceNumber();

            $newInvoice = $latestInvoice->replicate([
                'invoice_number', 'status', 'pdf_path', 'sent_at', 'viewed_at', 'paid_at',
            ]);
            $newInvoice->invoice_number = $invoiceNumber;
            $newInvoice->status = 'draft';
            $newInvoice->issue_date = now();
            $newInvoice->due_date = now()->addDays(30);
            $newInvoice->save();

            foreach ($latestInvoice->items as $item) {
                $newItem = $item->replicate();
                $newItem->invoice_id = $newInvoice->id;
                $newItem->save();
            }

            $newInvoice->recalculateTotals();

            $pdfGenerator->generate($newInvoice);
            $newInvoice->markAsSent();

            Mail::to($client->email)->send(new InvoiceSent($newInvoice));

            $newInvoice->logActivity('created', null, 'sent', 'Recurring invoice generated and sent');

            $client->update([
                'next_invoice_date' => $client->next_invoice_date->addMonths($client->recurring_frequency_months),
            ]);

            $this->info("Invoice {$invoiceNumber} created and sent to {$client->name}.");
            $sent++;
        }

        $this->info("Done. Sent: {$sent}, Skipped: {$skipped}.");

        return self::SUCCESS;
    }
}
