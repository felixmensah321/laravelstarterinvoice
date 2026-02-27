<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $client->name }}
            </h2>
            <div class="flex items-center gap-2">
                <a href="{{ route('clients.edit', $client) }}">
                    <x-primary-button type="button">
                        {{ __('Edit') }}
                    </x-primary-button>
                </a>
                <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this client? This action cannot be undone.') }}');">
                    @csrf
                    @method('DELETE')
                    <x-danger-button>
                        {{ __('Delete') }}
                    </x-danger-button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
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

            <!-- Client Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Client Information') }}</h3>

                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Name') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $client->name }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Company') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $client->company ?? '-' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Email') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="mailto:{{ $client->email }}" class="text-indigo-600 hover:text-indigo-900">{{ $client->email }}</a>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Phone') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $client->phone ?? '-' }}</dd>
                        </div>

                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">{{ __('Address') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($client->address_line_1 || $client->address_line_2 || $client->city || $client->state || $client->postal_code || $client->country)
                                    {{ $client->address_line_1 }}
                                    @if($client->address_line_2)<br>{{ $client->address_line_2 }}@endif
                                    @if($client->city || $client->state || $client->postal_code)
                                        <br>{{ collect([$client->city, $client->state, $client->postal_code])->filter()->implode(', ') }}
                                    @endif
                                    @if($client->country)<br>{{ $client->country }}@endif
                                @else
                                    -
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Tax ID') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $client->tax_id ?? '-' }}</dd>
                        </div>

                        @if($client->notes)
                            <div class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">{{ __('Notes') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $client->notes }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Recurring Invoice Settings -->
            @if($client->recurring_enabled)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Recurring Invoices') }}</h3>
                        <dl class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('Frequency') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @switch($client->recurring_frequency)
                                        @case('monthly') {{ __('Monthly') }} @break
                                        @case('quarterly') {{ __('Every 3 Months') }} @break
                                        @case('semi_annual') {{ __('Every 6 Months') }} @break
                                        @case('annual') {{ __('Every 12 Months') }} @break
                                    @endswitch
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('Business Start Date') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $client->business_start_date?->format('M d, Y') ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('Next Invoice Date') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $client->next_invoice_date?->format('M d, Y') ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            @endif

            <!-- Recent Invoices -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Recent Invoices') }}</h3>

                    @if($client->invoices->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Invoice Number') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Issue Date') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Status') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Total') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($client->invoices as $invoice)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $invoice->invoice_number }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $invoice->issue_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <x-status-badge :status="$invoice->status" />
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                                {{ number_format($invoice->total, 2) }} {{ $invoice->currency }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">{{ __('No invoices yet.') }}</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
