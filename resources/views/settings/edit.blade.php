<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Business Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.06l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Company Information --}}
                <div class="overflow-hidden rounded-lg bg-white shadow mb-8">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h3 class="text-base font-semibold leading-6 text-gray-900">Company Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Your business details that appear on invoices.</p>
                    </div>
                    <div class="px-6 py-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Company Name -->
                            <div>
                                <x-input-label for="company_name" :value="__('Company Name')" />
                                <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full" :value="old('company_name', $settings->company_name ?? '')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('company_name')" />
                            </div>

                            <!-- Company Email -->
                            <div>
                                <x-input-label for="company_email" :value="__('Company Email')" />
                                <x-text-input id="company_email" name="company_email" type="email" class="mt-1 block w-full" :value="old('company_email', $settings->company_email ?? '')" />
                                <x-input-error class="mt-2" :messages="$errors->get('company_email')" />
                            </div>

                            <!-- Company Phone -->
                            <div>
                                <x-input-label for="company_phone" :value="__('Company Phone')" />
                                <x-text-input id="company_phone" name="company_phone" type="text" class="mt-1 block w-full" :value="old('company_phone', $settings->company_phone ?? '')" />
                                <x-input-error class="mt-2" :messages="$errors->get('company_phone')" />
                            </div>

                            <!-- Company Address -->
                            <div>
                                <x-input-label for="company_address" :value="__('Company Address')" />
                                <textarea id="company_address" name="company_address" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('company_address', $settings->company_address ?? '') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('company_address')" />
                            </div>

                            <!-- Company Logo -->
                            <div class="md:col-span-2">
                                <x-input-label for="company_logo" :value="__('Company Logo')" />
                                @if (!empty($settings->company_logo_path))
                                    <div class="mt-2 mb-3">
                                        <img src="{{ Storage::url($settings->company_logo_path) }}" alt="Company Logo" class="h-16 w-auto rounded border border-gray-200" />
                                        <p class="mt-1 text-xs text-gray-500">Current logo. Upload a new file to replace it.</p>
                                    </div>
                                @endif
                                <div class="mt-1">
                                    <input type="file" id="company_logo" name="company_logo" accept="image/*"
                                           class="block w-full text-sm text-gray-500
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-md file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-indigo-50 file:text-indigo-700
                                                  hover:file:bg-indigo-100" />
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('company_logo')" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Invoice Defaults --}}
                <div class="overflow-hidden rounded-lg bg-white shadow mb-8">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h3 class="text-base font-semibold leading-6 text-gray-900">Invoice Defaults</h3>
                        <p class="mt-1 text-sm text-gray-500">Default values applied to new invoices.</p>
                    </div>
                    <div class="px-6 py-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Default Currency -->
                            <div>
                                <x-input-label for="default_currency" :value="__('Default Currency')" />
                                <x-text-input id="default_currency" name="default_currency" type="text" class="mt-1 block w-full" :value="old('default_currency', $settings->default_currency ?? 'USD')" placeholder="USD" />
                                <x-input-error class="mt-2" :messages="$errors->get('default_currency')" />
                            </div>

                            <!-- Default Tax Rate -->
                            <div>
                                <x-input-label for="default_tax_rate" :value="__('Default Tax Rate (%)')" />
                                <x-text-input id="default_tax_rate" name="default_tax_rate" type="number" step="0.01" min="0" max="100" class="mt-1 block w-full" :value="old('default_tax_rate', $settings->default_tax_rate ?? '0')" />
                                <x-input-error class="mt-2" :messages="$errors->get('default_tax_rate')" />
                            </div>

                            <!-- Invoice Prefix -->
                            <div>
                                <x-input-label for="invoice_prefix" :value="__('Invoice Prefix')" />
                                <x-text-input id="invoice_prefix" name="invoice_prefix" type="text" class="mt-1 block w-full" :value="old('invoice_prefix', $settings->invoice_prefix ?? 'INV-')" placeholder="INV-" />
                                <x-input-error class="mt-2" :messages="$errors->get('invoice_prefix')" />
                            </div>

                            <!-- Default Terms -->
                            <div class="md:col-span-3">
                                <x-input-label for="default_terms" :value="__('Default Terms & Conditions')" />
                                <textarea id="default_terms" name="default_terms" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Payment is due within 30 days of the invoice date...">{{ old('default_terms', $settings->default_terms ?? '') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('default_terms')" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Save Button --}}
                <div class="flex items-center justify-end">
                    <x-primary-button>
                        Save Settings
                    </x-primary-button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
