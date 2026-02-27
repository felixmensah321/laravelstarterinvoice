<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;

class MarkOverdueInvoices extends Command
{
    protected $signature = 'invoices:mark-overdue';
    protected $description = 'Mark sent/viewed invoices past due date as overdue';

    public function handle(): int
    {
        $invoices = Invoice::whereIn('status', ['sent', 'viewed'])
            ->where('due_date', '<', now()->startOfDay())
            ->get();

        $count = 0;
        foreach ($invoices as $invoice) {
            $invoice->markAsOverdue();
            $count++;
        }

        $this->info("Marked {$count} invoice(s) as overdue.");

        return self::SUCCESS;
    }
}
