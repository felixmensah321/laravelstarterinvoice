<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice from {{ $companyName }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f5f7; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f5f7;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">

                    {{-- Header --}}
                    <tr>
                        <td style="background-color: #4f46e5; padding: 32px 40px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 600;">{{ $companyName }}</h1>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 40px;">
                            <p style="margin: 0 0 16px; color: #1f2937; font-size: 16px; line-height: 1.6;">
                                Hello {{ $invoice->client->name }},
                            </p>

                            <p style="margin: 0 0 24px; color: #4b5563; font-size: 15px; line-height: 1.6;">
                                A new invoice has been created for you. Please find the details below.
                            </p>

                            {{-- Invoice Details Box --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 6px; margin-bottom: 32px;">
                                <tr>
                                    <td style="padding: 24px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding: 6px 0; color: #6b7280; font-size: 14px;">Invoice Number</td>
                                                <td style="padding: 6px 0; color: #111827; font-size: 14px; font-weight: 600; text-align: right;">{{ $invoice->invoice_number }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 6px 0; color: #6b7280; font-size: 14px;">Amount Due</td>
                                                <td style="padding: 6px 0; color: #111827; font-size: 14px; font-weight: 600; text-align: right;">${{ number_format($invoice->total, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 6px 0; color: #6b7280; font-size: 14px;">Due Date</td>
                                                <td style="padding: 6px 0; color: #111827; font-size: 14px; font-weight: 600; text-align: right;">{{ $invoice->due_date->format('F j, Y') }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            {{-- CTA Button --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $viewUrl }}" style="display: inline-block; background-color: #4f46e5; color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; padding: 14px 32px; border-radius: 6px;">
                                            View Invoice
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 32px 0 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
                                If you have any questions about this invoice, please do not hesitate to reach out.
                            </p>

                            <p style="margin: 24px 0 0; color: #4b5563; font-size: 14px; line-height: 1.6;">
                                Thank you for your business.
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color: #f9fafb; padding: 24px 40px; border-top: 1px solid #e5e7eb; text-align: center;">
                            <p style="margin: 0; color: #9ca3af; font-size: 13px;">
                                &copy; {{ date('Y') }} {{ $companyName }}. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
