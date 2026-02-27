<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class InvoiceSent extends Mailable
{
    use Queueable, SerializesModels;

    public string $viewUrl;
    public string $companyName;

    public function __construct(
        public Invoice $invoice
    ) {
        $this->viewUrl = URL::signedRoute('invoices.public.show', $invoice, now()->addDays(30));
        $this->companyName = $invoice->user->setting?->company_name ?? 'Our Company';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Invoice {$this->invoice->invoice_number} from {$this->companyName}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.invoices.sent',
        );
    }

    public function attachments(): array
    {
        if ($this->invoice->pdf_path && Storage::exists($this->invoice->pdf_path)) {
            return [
                Attachment::fromStorage($this->invoice->pdf_path)
                    ->as($this->invoice->invoice_number . '.pdf')
                    ->withMime('application/pdf'),
            ];
        }

        return [];
    }
}
