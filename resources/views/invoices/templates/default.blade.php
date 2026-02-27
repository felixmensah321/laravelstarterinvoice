<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style type="text/css">
        /* Reset */
        body, h1, h2, h3, p, table, td, th { margin: 0; padding: 0; }
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #333333;
            line-height: 1.5;
            background-color: #ffffff;
        }
        table { border-collapse: collapse; }
        .page-wrap {
            width: 100%;
            max-width: 750px;
            margin: 0 auto;
            padding: 40px 30px;
        }

        /* Header */
        .company-header td { vertical-align: top; }
        .company-name {
            font-size: 22px;
            font-weight: bold;
            color: #2d3748;
        }
        .company-details {
            font-size: 12px;
            color: #718096;
            line-height: 1.6;
        }
        .invoice-title {
            font-size: 32px;
            font-weight: bold;
            color: #4f46e5;
            text-align: right;
            letter-spacing: 2px;
        }

        /* Invoice Meta */
        .meta-table td {
            padding: 3px 0;
            font-size: 12px;
        }
        .meta-label {
            color: #718096;
            padding-right: 12px;
        }
        .meta-value {
            color: #2d3748;
            font-weight: 600;
        }

        /* Billing */
        .section-label {
            font-size: 10px;
            font-weight: bold;
            color: #4f46e5;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .client-name {
            font-size: 15px;
            font-weight: bold;
            color: #2d3748;
        }
        .client-details {
            font-size: 12px;
            color: #718096;
            line-height: 1.6;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-draft { background-color: #edf2f7; color: #4a5568; }
        .status-sent { background-color: #ebf4ff; color: #2b6cb0; }
        .status-paid { background-color: #f0fff4; color: #276749; }
        .status-overdue { background-color: #fff5f5; color: #c53030; }
        .status-viewed { background-color: #fffff0; color: #975a16; }
        .status-cancelled { background-color: #edf2f7; color: #a0aec0; }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
        }
        .items-table th {
            background-color: #4f46e5;
            color: #ffffff;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 12px;
            text-align: left;
        }
        .items-table th.text-right { text-align: right; }
        .items-table td {
            padding: 10px 12px;
            font-size: 12px;
            color: #4a5568;
            border-bottom: 1px solid #e2e8f0;
        }
        .items-table td.text-right { text-align: right; }
        .items-table tr:last-child td { border-bottom: none; }

        /* Totals */
        .totals-table {
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 5px 12px;
            font-size: 12px;
        }
        .totals-label {
            color: #718096;
            text-align: right;
        }
        .totals-value {
            color: #2d3748;
            text-align: right;
            font-weight: 600;
            min-width: 100px;
        }
        .grand-total td {
            padding-top: 10px;
            border-top: 2px solid #4f46e5;
            font-size: 16px;
            font-weight: bold;
        }
        .grand-total .totals-label { color: #2d3748; }
        .grand-total .totals-value { color: #4f46e5; }

        /* Footer Notes */
        .notes-section {
            font-size: 12px;
            color: #718096;
            line-height: 1.6;
        }
        .notes-title {
            font-size: 11px;
            font-weight: bold;
            color: #4a5568;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 24px 0;
        }
    </style>
</head>
<body>
    <div class="page-wrap">

        {{-- Company Header --}}
        <table class="company-header" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td width="60%" style="vertical-align: top;">
                    <div class="company-name">{{ $settings->company_name ?? 'Company Name' }}</div>
                    <div class="company-details" style="margin-top: 6px;">
                        @if (!empty($settings->company_address))
                            {{ $settings->company_address }}<br>
                        @endif
                        @if (!empty($settings->company_email))
                            {{ $settings->company_email }}<br>
                        @endif
                        @if (!empty($settings->company_phone))
                            {{ $settings->company_phone }}
                        @endif
                    </div>
                </td>
                <td width="40%" style="vertical-align: top;">
                    <div class="invoice-title">INVOICE</div>
                </td>
            </tr>
        </table>

        <hr class="divider">

        {{-- Invoice Details & Billing --}}
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td width="50%" style="vertical-align: top;">
                    <div class="section-label">Bill To</div>
                    <div class="client-name">{{ $client->name }}</div>
                    <div class="client-details">
                        @if (!empty($client->company))
                            {{ $client->company }}<br>
                        @endif
                        @if (!empty($client->address_line_1))
                            {{ $client->address_line_1 }}<br>
                        @endif
                        @if (!empty($client->address_line_2))
                            {{ $client->address_line_2 }}<br>
                        @endif
                        @if (!empty($client->city) || !empty($client->state) || !empty($client->postal_code))
                            {{ implode(', ', array_filter([$client->city, $client->state, $client->postal_code])) }}<br>
                        @endif
                        @if (!empty($client->email))
                            {{ $client->email }}
                        @endif
                    </div>
                </td>
                <td width="50%" style="vertical-align: top; text-align: right;">
                    <table class="meta-table" cellpadding="0" cellspacing="0" style="margin-left: auto;">
                        <tr>
                            <td class="meta-label">Invoice Number:</td>
                            <td class="meta-value">{{ $invoice->invoice_number }}</td>
                        </tr>
                        <tr>
                            <td class="meta-label">Issue Date:</td>
                            <td class="meta-value">{{ $invoice->issue_date->format('F j, Y') }}</td>
                        </tr>
                        <tr>
                            <td class="meta-label">Due Date:</td>
                            <td class="meta-value">{{ $invoice->due_date->format('F j, Y') }}</td>
                        </tr>
                        <tr>
                            <td class="meta-label">Status:</td>
                            <td class="meta-value">
                                @php
                                    $statusClass = match($invoice->status) {
                                        'draft' => 'status-draft',
                                        'sent' => 'status-sent',
                                        'paid' => 'status-paid',
                                        'overdue' => 'status-overdue',
                                        'viewed' => 'status-viewed',
                                        'cancelled' => 'status-cancelled',
                                        default => 'status-draft',
                                    };
                                @endphp
                                <span class="status-badge {{ $statusClass }}">{{ ucfirst($invoice->status) }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- Spacer --}}
        <div style="height: 30px;"></div>

        {{-- Items Table --}}
        <table class="items-table" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th style="width: 45%;">Description</th>
                    <th class="text-right" style="width: 15%;">Quantity</th>
                    <th class="text-right" style="width: 20%;">Unit Price</th>
                    <th class="text-right" style="width: 20%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right">{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <div style="height: 16px;"></div>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td width="55%"></td>
                <td width="45%">
                    <table class="totals-table" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="totals-label">Subtotal</td>
                            <td class="totals-value">{{ number_format($invoice->subtotal, 2) }}</td>
                        </tr>
                        @if ($invoice->tax_amount > 0)
                            <tr>
                                <td class="totals-label">Tax</td>
                                <td class="totals-value">{{ number_format($invoice->tax_amount, 2) }}</td>
                            </tr>
                        @endif
                        @if ($invoice->discount_amount > 0)
                            <tr>
                                <td class="totals-label">Discount</td>
                                <td class="totals-value">-{{ number_format($invoice->discount_amount, 2) }}</td>
                            </tr>
                        @endif
                        <tr class="grand-total">
                            <td class="totals-label">Total</td>
                            <td class="totals-value">{{ number_format($invoice->total, 2) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- Notes & Terms --}}
        @if (!empty($invoice->notes) || !empty($settings->default_terms))
            <hr class="divider">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    @if (!empty($invoice->notes))
                        <td width="{{ !empty($settings->default_terms) ? '50%' : '100%' }}" style="vertical-align: top; padding-right: 16px;">
                            <div class="notes-section">
                                <div class="notes-title">Notes</div>
                                <p>{{ $invoice->notes }}</p>
                            </div>
                        </td>
                    @endif
                    @if (!empty($settings->default_terms))
                        <td width="{{ !empty($invoice->notes) ? '50%' : '100%' }}" style="vertical-align: top;">
                            <div class="notes-section">
                                <div class="notes-title">Terms & Conditions</div>
                                <p>{{ $settings->default_terms }}</p>
                            </div>
                        </td>
                    @endif
                </tr>
            </table>
        @endif

    </div>
</body>
</html>
