<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoicePublicController extends Controller
{
    public function show(Request $request, Invoice $invoice)
    {
        abort_unless($request->hasValidSignature(), 403, 'Invalid or expired link.');

        $invoice->load(['client', 'items', 'user.setting']);

        if ($invoice->status === 'sent') {
            $invoice->markAsViewed();
        }

        $html = view('invoices.templates.default', [
            'invoice' => $invoice,
            'client' => $invoice->client,
            'items' => $invoice->items,
            'settings' => $invoice->user->setting,
        ])->render();

        return view('invoices-public.show', compact('invoice', 'html'));
    }
}
