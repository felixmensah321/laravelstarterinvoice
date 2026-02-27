<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoice') }} {{ $invoice->invoice_number }}
            </h2>
            <a href="{{ route('invoices.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                {{ __('Back to Invoices') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Message --}}
            @if (session('success'))
                <div class="rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Invoice Header Info --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $invoice->invoice_number }}</h3>
                            <div class="mt-1">
                                <x-status-badge :status="$invoice->status" />
                            </div>
                        </div>
                        <div class="text-sm text-gray-500 sm:text-right space-y-1">
                            <p><span class="font-medium text-gray-700">{{ __('Issue Date:') }}</span> {{ $invoice->issue_date?->format('M d, Y') }}</p>
                            <p><span class="font-medium text-gray-700">{{ __('Due Date:') }}</span> {{ $invoice->due_date?->format('M d, Y') }}</p>
                            <p><span class="font-medium text-gray-700">{{ __('Currency:') }}</span> {{ $invoice->currency }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Client Info --}}
            @if ($invoice->client)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">{{ __('Bill To') }}</h4>
                        <div class="text-sm text-gray-900">
                            <p class="font-semibold text-lg">{{ $invoice->client->name }}</p>
                            @if ($invoice->client->email)
                                <p class="text-gray-600">{{ $invoice->client->email }}</p>
                            @endif
                            @if ($invoice->client->phone)
                                <p class="text-gray-600">{{ $invoice->client->phone }}</p>
                            @endif
                            @if ($invoice->client->address)
                                <p class="text-gray-600 mt-1 whitespace-pre-line">{{ $invoice->client->address }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- Line Items Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">{{ __('Line Items') }}</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Description') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Quantity') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Unit Price') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Total') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($invoice->items as $item)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $item->description }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                            {{ number_format($item->unit_price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                            {{ number_format($item->quantity * $item->unit_price, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-sm text-gray-500 text-center">
                                            {{ __('No line items.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Totals Section --}}
                    <div class="mt-6 flex justify-end">
                        <div class="w-full sm:w-72 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">{{ __('Subtotal') }}</span>
                                <span class="text-gray-900">{{ number_format($invoice->subtotal, 2) }}</span>
                            </div>
                            @if ($invoice->tax_rate > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">{{ __('Tax') }} ({{ $invoice->tax_rate }}%)</span>
                                    <span class="text-gray-900">{{ number_format($invoice->tax_amount, 2) }}</span>
                                </div>
                            @endif
                            @if ($invoice->discount_amount > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">{{ __('Discount') }}</span>
                                    <span class="text-red-600">-{{ number_format($invoice->discount_amount, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between text-base font-semibold border-t border-gray-200 pt-2">
                                <span class="text-gray-900">{{ __('Total') }}</span>
                                <span class="text-gray-900">{{ $invoice->currency }} {{ number_format($invoice->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notes and Terms --}}
            @if ($invoice->notes || $invoice->terms)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @if ($invoice->notes)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">{{ __('Notes') }}</h4>
                                <p class="text-sm text-gray-700 whitespace-pre-line">{{ $invoice->notes }}</p>
                            </div>
                        @endif
                        @if ($invoice->terms)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">{{ __('Terms & Conditions') }}</h4>
                                <p class="text-sm text-gray-700 whitespace-pre-line">{{ $invoice->terms }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Action Buttons --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">{{ __('Actions') }}</h4>
                    <div class="flex flex-wrap gap-3">
                        @if ($invoice->status === 'draft')
                            <a href="{{ route('invoices.edit', $invoice) }}">
                                <x-primary-button type="button">
                                    {{ __('Edit') }}
                                </x-primary-button>
                            </a>

                            <form method="POST" action="{{ route('invoices.send', $invoice) }}">
                                @csrf
                                <x-primary-button onclick="return confirm('{{ __('Send this invoice to the client?') }}')">
                                    {{ __('Send') }}
                                </x-primary-button>
                            </form>

                            <a href="{{ route('invoices.preview', $invoice) }}">
                                <x-secondary-button type="button">
                                    {{ __('Preview') }}
                                </x-secondary-button>
                            </a>

                            <form method="POST" action="{{ route('invoices.destroy', $invoice) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this invoice?') }}');">
                                @csrf
                                @method('DELETE')
                                <x-danger-button>
                                    {{ __('Delete') }}
                                </x-danger-button>
                            </form>
                        @endif

                        @if (in_array($invoice->status, ['sent', 'viewed', 'overdue']))
                            <form method="POST" action="{{ route('invoices.markPaid', $invoice) }}">
                                @csrf
                                <x-primary-button onclick="return confirm('{{ __('Mark this invoice as paid?') }}')">
                                    {{ __('Mark as Paid') }}
                                </x-primary-button>
                            </form>

                            <a href="{{ route('invoices.preview', $invoice) }}">
                                <x-secondary-button type="button">
                                    {{ __('Preview') }}
                                </x-secondary-button>
                            </a>

                            <a href="{{ route('invoices.pdf', $invoice) }}">
                                <x-secondary-button type="button">
                                    {{ __('Download PDF') }}
                                </x-secondary-button>
                            </a>

                            <form method="POST" action="{{ route('invoices.duplicate', $invoice) }}">
                                @csrf
                                <x-secondary-button type="submit">
                                    {{ __('Duplicate') }}
                                </x-secondary-button>
                            </form>
                        @endif

                        @if ($invoice->status === 'paid')
                            <a href="{{ route('invoices.preview', $invoice) }}">
                                <x-secondary-button type="button">
                                    {{ __('Preview') }}
                                </x-secondary-button>
                            </a>

                            <a href="{{ route('invoices.pdf', $invoice) }}">
                                <x-secondary-button type="button">
                                    {{ __('Download PDF') }}
                                </x-secondary-button>
                            </a>

                            <form method="POST" action="{{ route('invoices.duplicate', $invoice) }}">
                                @csrf
                                <x-secondary-button type="submit">
                                    {{ __('Duplicate') }}
                                </x-secondary-button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Activity Log --}}
            @if (isset($invoice->activities) && $invoice->activities->count())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">{{ __('Activity Log') }}</h4>
                        <div class="flow-root">
                            <ul role="list" class="-mb-8">
                                @foreach ($invoice->activities as $activity)
                                    <li>
                                        <div class="relative pb-8">
                                            @if (!$loop->last)
                                                <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center ring-8 ring-white">
                                                        <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                    <div>
                                                        <p class="text-sm text-gray-700">{{ $activity->description }}</p>
                                                    </div>
                                                    <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                        <time datetime="{{ $activity->created_at->toIso8601String() }}">
                                                            {{ $activity->created_at->diffForHumans() }}
                                                        </time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
