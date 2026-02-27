{{-- Invoice Form partial - used by create and edit views --}}
<div class="space-y-6">
    {{-- Client --}}
    <div>
        <x-input-label for="client_id" :value="__('Client')" />
        <select
            id="client_id"
            name="client_id"
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
            required
        >
            <option value="">{{ __('Select a client') }}</option>
            @foreach ($clients as $client)
                <option
                    value="{{ $client->id }}"
                    {{ old('client_id', isset($invoice) ? $invoice->client_id : '') == $client->id ? 'selected' : '' }}
                >
                    {{ $client->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('client_id')" class="mt-2" />
    </div>

    {{-- Dates --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div>
            <x-input-label for="issue_date" :value="__('Issue Date')" />
            <x-text-input
                id="issue_date"
                name="issue_date"
                type="date"
                class="mt-1 block w-full"
                :value="old('issue_date', isset($invoice) ? $invoice->issue_date?->format('Y-m-d') : now()->format('Y-m-d'))"
                required
            />
            <x-input-error :messages="$errors->get('issue_date')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="due_date" :value="__('Due Date')" />
            <x-text-input
                id="due_date"
                name="due_date"
                type="date"
                class="mt-1 block w-full"
                :value="old('due_date', isset($invoice) ? $invoice->due_date?->format('Y-m-d') : now()->addDays(30)->format('Y-m-d'))"
                required
            />
            <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
        </div>
    </div>

    {{-- Tax, Discount, Currency --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div>
            <x-input-label for="tax_rate" :value="__('Tax Rate (%)')" />
            <x-text-input
                id="tax_rate"
                name="tax_rate"
                type="number"
                class="mt-1 block w-full"
                :value="old('tax_rate', isset($invoice) ? $invoice->tax_rate : ($settings->default_tax_rate ?? 0))"
                min="0"
                step="0.01"
            />
            <x-input-error :messages="$errors->get('tax_rate')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="discount_amount" :value="__('Discount Amount')" />
            <x-text-input
                id="discount_amount"
                name="discount_amount"
                type="number"
                class="mt-1 block w-full"
                :value="old('discount_amount', isset($invoice) ? $invoice->discount_amount : 0)"
                min="0"
                step="0.01"
            />
            <x-input-error :messages="$errors->get('discount_amount')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="currency" :value="__('Currency')" />
            <x-text-input
                id="currency"
                name="currency"
                type="text"
                class="mt-1 block w-full"
                :value="old('currency', isset($invoice) ? $invoice->currency : ($settings->default_currency ?? 'USD'))"
            />
            <x-input-error :messages="$errors->get('currency')" class="mt-2" />
        </div>
    </div>

    {{-- Line Items --}}
    <div class="p-4 sm:p-6 bg-white border border-gray-200 rounded-lg">
        @include('invoices._line-items')
    </div>

    {{-- Notes and Terms --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div>
            <x-input-label for="notes" :value="__('Notes')" />
            <textarea
                id="notes"
                name="notes"
                rows="4"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                placeholder="{{ __('Notes visible to the client') }}"
            >{{ old('notes', isset($invoice) ? $invoice->notes : ($settings->default_notes ?? '')) }}</textarea>
            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="terms" :value="__('Terms & Conditions')" />
            <textarea
                id="terms"
                name="terms"
                rows="4"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                placeholder="{{ __('Payment terms and conditions') }}"
            >{{ old('terms', isset($invoice) ? $invoice->terms : ($settings->default_terms ?? '')) }}</textarea>
            <x-input-error :messages="$errors->get('terms')" class="mt-2" />
        </div>
    </div>
</div>
