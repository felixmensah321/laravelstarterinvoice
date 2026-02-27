<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Mail\InvoiceSent;
use App\Models\Invoice;
use App\Services\InvoicePdfGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = $request->user()->invoices()
            ->with('client')
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->when($request->search, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('invoice_number', 'like', "%{$search}%")
                      ->orWhereHas('client', fn ($q) => $q->where('name', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('invoices.index', compact('invoices'));
    }

    public function create(Request $request)
    {
        $clients = $request->user()->clients()->orderBy('name')->get();
        $settings = $request->user()->getOrCreateSetting();

        return view('invoices.create', compact('clients', 'settings'));
    }

    public function store(StoreInvoiceRequest $request)
    {
        $settings = $request->user()->getOrCreateSetting();
        $invoiceNumber = $settings->generateInvoiceNumber();

        $invoice = $request->user()->invoices()->create([
            'client_id' => $request->client_id,
            'invoice_number' => $invoiceNumber,
            'issue_date' => $request->issue_date,
            'due_date' => $request->due_date,
            'tax_rate' => $request->tax_rate ?? $settings->default_tax_rate,
            'discount_amount' => $request->discount_amount ?? 0,
            'currency' => $request->currency ?? $settings->default_currency,
            'notes' => $request->notes,
            'terms' => $request->terms ?? $settings->default_terms,
        ]);

        foreach ($request->items as $index => $item) {
            $invoice->items()->create([
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'sort_order' => $index,
            ]);
        }

        $invoice->recalculateTotals();
        $invoice->logActivity('created', null, 'draft', 'Invoice created');

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        $this->authorizeInvoice($invoice);

        $invoice->load(['client', 'items', 'activities']);

        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice, Request $request)
    {
        $this->authorizeInvoice($invoice);
        abort_unless($invoice->isDraft(), 403, 'Only draft invoices can be edited.');

        $invoice->load('items');
        $clients = $request->user()->clients()->orderBy('name')->get();
        $settings = $request->user()->getOrCreateSetting();

        return view('invoices.edit', compact('invoice', 'clients', 'settings'));
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $this->authorizeInvoice($invoice);
        abort_unless($invoice->isDraft(), 403, 'Only draft invoices can be edited.');

        $invoice->update([
            'client_id' => $request->client_id,
            'issue_date' => $request->issue_date,
            'due_date' => $request->due_date,
            'tax_rate' => $request->tax_rate ?? 0,
            'discount_amount' => $request->discount_amount ?? 0,
            'currency' => $request->currency ?? 'USD',
            'notes' => $request->notes,
            'terms' => $request->terms,
        ]);

        $invoice->items()->delete();
        foreach ($request->items as $index => $item) {
            $invoice->items()->create([
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'sort_order' => $index,
            ]);
        }

        $invoice->recalculateTotals();

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        $this->authorizeInvoice($invoice);

        $invoice->delete();

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }

    public function send(Invoice $invoice, InvoicePdfGenerator $pdfGenerator)
    {
        $this->authorizeInvoice($invoice);

        $pdfGenerator->generate($invoice);
        $invoice->markAsSent();

        Mail::to($invoice->client->email)->send(new InvoiceSent($invoice));

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice sent successfully.');
    }

    public function markPaid(Invoice $invoice)
    {
        $this->authorizeInvoice($invoice);

        $invoice->markAsPaid();

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice marked as paid.');
    }

    public function duplicate(Invoice $invoice, Request $request)
    {
        $this->authorizeInvoice($invoice);

        $settings = $request->user()->getOrCreateSetting();
        $newInvoice = $invoice->replicate(['invoice_number', 'status', 'pdf_path', 'sent_at', 'viewed_at', 'paid_at']);
        $newInvoice->invoice_number = $settings->generateInvoiceNumber();
        $newInvoice->status = 'draft';
        $newInvoice->issue_date = now();
        $newInvoice->due_date = now()->addDays(30);
        $newInvoice->save();

        foreach ($invoice->items as $item) {
            $newItem = $item->replicate();
            $newItem->invoice_id = $newInvoice->id;
            $newItem->save();
        }

        $newInvoice->logActivity('created', null, 'draft', "Duplicated from {$invoice->invoice_number}");

        return redirect()->route('invoices.edit', $newInvoice)
            ->with('success', 'Invoice duplicated successfully.');
    }

    public function downloadPdf(Invoice $invoice, InvoicePdfGenerator $pdfGenerator)
    {
        $this->authorizeInvoice($invoice);

        if (!$invoice->pdf_path || !Storage::exists($invoice->pdf_path)) {
            $pdfGenerator->generate($invoice);
            $invoice->refresh();
        }

        return Storage::download($invoice->pdf_path, $invoice->invoice_number . '.pdf');
    }

    public function preview(Invoice $invoice)
    {
        $this->authorizeInvoice($invoice);

        $invoice->load(['client', 'items', 'user.setting']);

        $html = view('invoices.templates.default', [
            'invoice' => $invoice,
            'client' => $invoice->client,
            'items' => $invoice->items,
            'settings' => $invoice->user->setting,
        ])->render();

        return view('invoices.preview', compact('html'));
    }

    protected function authorizeInvoice(Invoice $invoice): void
    {
        abort_unless($invoice->user_id === auth()->id(), 403);
    }
}
