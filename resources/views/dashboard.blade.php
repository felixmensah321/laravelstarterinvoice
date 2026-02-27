<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="flex items-center space-x-3">
                <a href="{{ route('invoices.create') }}"
                   class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <svg class="-ml-0.5 mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    New Invoice
                </a>
                <a href="{{ route('clients.create') }}"
                   class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    <svg class="-ml-0.5 mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-9-1.5a3 3 0 1 1 0-6 3 3 0 0 1 0 6Zm-3 9a6 6 0 0 1 12 0v.75a.75.75 0 0 1-.75.75H3.75a.75.75 0 0 1-.75-.75V16.5Z" />
                    </svg>
                    New Client
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-5">
                {{-- Total Invoices --}}
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="truncate text-sm font-medium text-gray-500">Total Invoices</dt>
                                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $totalInvoices }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Outstanding Amount --}}
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="truncate text-sm font-medium text-gray-500">Outstanding</dt>
                                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">${{ number_format($outstandingAmount, 2) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Overdue Count --}}
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="truncate text-sm font-medium text-gray-500">Overdue</dt>
                                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-red-600">{{ $overdueCount }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Paid Amount --}}
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="truncate text-sm font-medium text-gray-500">Paid</dt>
                                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-green-600">${{ number_format($paidAmount, 2) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Clients --}}
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="truncate text-sm font-medium text-gray-500">Total Clients</dt>
                                    <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $totalClients }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Invoices & Recent Activity --}}
            <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-3">

                {{-- Recent Invoices Table --}}
                <div class="lg:col-span-2">
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="border-b border-gray-200 px-6 py-4">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Recent Invoices</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Invoice</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Client</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Amount</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @forelse ($recentInvoices as $invoice)
                                        <tr class="hover:bg-gray-50">
                                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-indigo-600">
                                                <a href="{{ route('invoices.show', $invoice) }}" class="hover:underline">
                                                    {{ $invoice->invoice_number }}
                                                </a>
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                                {{ $invoice->client->name }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                                {{ $invoice->currency ?? '$' }}{{ number_format($invoice->total, 2) }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                <x-status-badge :status="$invoice->status" />
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                                {{ $invoice->created_at->format('M d, Y') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500">
                                                No invoices yet. <a href="{{ route('invoices.create') }}" class="font-medium text-indigo-600 hover:underline">Create your first invoice</a>.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Recent Activity --}}
                <div class="lg:col-span-1">
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="border-b border-gray-200 px-6 py-4">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Recent Activity</h3>
                        </div>
                        <div class="px-6 py-4">
                            <ul role="list" class="-mb-4 space-y-6">
                                @forelse ($recentActivities as $activity)
                                    <li class="relative pb-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                        <div class="flex space-x-3">
                                            <div class="flex-shrink-0">
                                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-100">
                                                    <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm text-gray-900">{{ $activity->description }}</p>
                                                @if ($activity->invoice)
                                                    <p class="mt-0.5 text-sm text-indigo-600">
                                                        <a href="{{ route('invoices.show', $activity->invoice) }}" class="hover:underline">
                                                            {{ $activity->invoice->invoice_number }}
                                                        </a>
                                                    </p>
                                                @endif
                                                <p class="mt-1 text-xs text-gray-400">{{ $activity->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <li class="py-6 text-center text-sm text-gray-500">
                                        No recent activity.
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
