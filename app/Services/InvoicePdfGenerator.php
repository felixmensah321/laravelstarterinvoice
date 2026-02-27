<?php

namespace App\Services;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class InvoicePdfGenerator
{
    public function generate(Invoice $invoice): string
    {
        $invoice->load(['client', 'items', 'user.setting']);

        $html = view('invoices.templates.default', [
            'invoice' => $invoice,
            'client' => $invoice->client,
            'items' => $invoice->items,
            'settings' => $invoice->user->setting,
        ])->render();

        $pdf = Pdf::loadHTML($html)->setPaper('a4');

        $path = 'invoices/pdf/' . $invoice->invoice_number . '.pdf';
        Storage::put($path, $pdf->output());

        $invoice->update(['pdf_path' => $path]);

        return $path;
    }
}
