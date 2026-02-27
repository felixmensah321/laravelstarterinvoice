<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoices') }}
            </h2>
            <a href="{{ route('invoices.create') }}">
                <x-primary-button type="button">
                    {{ __('New Invoice') }}
                </x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash Message --}}
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Status Filter Tabs --}}
                    <div class="mb-6 border-b border-gray-200">
                        <nav class="-mb-px flex space-x-6 overflow-x-auto" aria-label="Status filter">
                            @php
                                $statuses = [
                                    '' => 'All',
                                    'draft' => 'Draft',
                                    'sent' => 'Sent',
                                    'viewed' => 'Viewed',
                                    'paid' => 'Paid',
                                    'overdue' => 'Overdue',
                                ];
                                $currentStatus = request('status', '');
                            @endphp

                            @foreach ($statuses as $value => $label)
                                <a
                                    href="{{ route('invoices.index', array_merge(request()->except('status', 'page'), $value ? ['status' => $value] : [])) }}"
                                    class="whitespace-nowrap border-b-2 py-3 px-1 text-sm font-medium {{ $currentStatus === $value ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}"
                                >
                                    {{ __($label) }}
                                </a>
                            @endforeach
                        </nav>
                    </div>

                    {{-- Search --}}
                    <div class="mb-6">
                        <form method="GET" action="{{ route('invoices.index') }}" class="flex items-center gap-4">
                            @if (request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif
                            <div class="flex-1 max-w-sm">
                                <x-text-input
                                    type="search"
                                    name="search"
                                    class="block w-full"
                                    :value="request('search')"
                                    placeholder="{{ __('Search invoices...') }}"
                                />
                            </div>
                            <x-primary-button>
                                {{ __('Search') }}
                            </x-primary-button>
                            @if (request('search'))
                                <a href="{{ route('invoices.index', request()->only('status')) }}" class="text-sm text-gray-500 hover:text-gray-700">
                                    {{ __('Clear') }}
                                </a>
                            @endif
                        </form>
                    </div>

                    {{-- Invoices Table --}}
                    @if ($invoices->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Invoice #') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Client') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Issue Date') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Due Date') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Total') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Status') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($invoices as $invoice)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <a href="{{ route('invoices.show', $invoice) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    {{ $invoice->invoice_number }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $invoice->client->name ?? __('N/A') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $invoice->issue_date?->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $invoice->due_date?->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                                {{ number_format($invoice->total, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <x-status-badge :status="$invoice->status" />
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                                <a href="{{ route('invoices.show', $invoice) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    {{ __('View') }}
                                                </a>
                                                <a href="{{ route('invoices.edit', $invoice) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    {{ __('Edit') }}
                                                </a>
                                                <form method="POST" action="{{ route('invoices.destroy', $invoice) }}" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this invoice?') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-6">
                            {{ $invoices->withQueryString()->links() }}
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('No invoices') }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ __('Get started by creating a new invoice.') }}</p>
                            <div class="mt-6">
                                <a href="{{ route('invoices.create') }}">
                                    <x-primary-button type="button">
                                        {{ __('New Invoice') }}
                                    </x-primary-button>
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
