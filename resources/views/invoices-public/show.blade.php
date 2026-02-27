<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f3f4f6; color: #111827; min-height: 100vh; display: flex; flex-direction: column; }
        .header { background-color: #ffffff; border-bottom: 1px solid #e5e7eb; padding: 20px 0; }
        .header-inner { max-width: 900px; margin: 0 auto; padding: 0 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
        .header h1 { font-size: 20px; font-weight: 600; color: #111827; }
        .header .invoice-number { font-size: 14px; color: #6b7280; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 9999px; font-size: 13px; font-weight: 500; }
        .status-draft { background-color: #f3f4f6; color: #374151; }
        .status-sent { background-color: #dbeafe; color: #1e40af; }
        .status-viewed { background-color: #fef3c7; color: #92400e; }
        .status-paid { background-color: #d1fae5; color: #065f46; }
        .status-overdue { background-color: #fee2e2; color: #991b1b; }
        .status-cancelled { background-color: #f3f4f6; color: #6b7280; }
        .main { flex: 1; max-width: 900px; width: 100%; margin: 0 auto; padding: 32px 24px; }
        .invoice-container { background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden; }
        .invoice-body { padding: 32px; }
        .footer { background-color: #ffffff; border-top: 1px solid #e5e7eb; padding: 20px 0; text-align: center; }
        .footer p { font-size: 13px; color: #9ca3af; }
        @media print {
            body { background-color: #ffffff; }
            .header, .footer { display: none; }
            .main { padding: 0; max-width: 100%; }
            .invoice-container { border: none; box-shadow: none; border-radius: 0; }
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-inner">
            <div>
                <h1>Invoice</h1>
                <span class="invoice-number">{{ $invoice->invoice_number }}</span>
            </div>
            <div>
                @php
                    $statusClass = match($invoice->status) {
                        'draft' => 'status-draft',
                        'sent' => 'status-sent',
                        'viewed' => 'status-viewed',
                        'paid' => 'status-paid',
                        'overdue' => 'status-overdue',
                        'cancelled' => 'status-cancelled',
                        default => 'status-draft',
                    };
                @endphp
                <span class="status-badge {{ $statusClass }}">{{ ucfirst($invoice->status) }}</span>
            </div>
        </div>
    </div>

    <div class="main">
        <div class="invoice-container">
            <div class="invoice-body">
                {!! $html !!}
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} All rights reserved.</p>
    </div>

</body>
</html>
