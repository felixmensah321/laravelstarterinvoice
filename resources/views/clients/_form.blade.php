<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Name -->
    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $client->name ?? '')" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <!-- Company -->
    <div>
        <x-input-label for="company" :value="__('Company')" />
        <x-text-input id="company" name="company" type="text" class="mt-1 block w-full" :value="old('company', $client->company ?? '')" />
        <x-input-error class="mt-2" :messages="$errors->get('company')" />
    </div>

    <!-- Email -->
    <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $client->email ?? '')" required />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>

    <!-- Phone -->
    <div>
        <x-input-label for="phone" :value="__('Phone')" />
        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $client->phone ?? '')" />
        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
    </div>

    <!-- Address Line 1 -->
    <div>
        <x-input-label for="address_line_1" :value="__('Address Line 1')" />
        <x-text-input id="address_line_1" name="address_line_1" type="text" class="mt-1 block w-full" :value="old('address_line_1', $client->address_line_1 ?? '')" />
        <x-input-error class="mt-2" :messages="$errors->get('address_line_1')" />
    </div>

    <!-- Address Line 2 -->
    <div>
        <x-input-label for="address_line_2" :value="__('Address Line 2')" />
        <x-text-input id="address_line_2" name="address_line_2" type="text" class="mt-1 block w-full" :value="old('address_line_2', $client->address_line_2 ?? '')" />
        <x-input-error class="mt-2" :messages="$errors->get('address_line_2')" />
    </div>

    <!-- City -->
    <div>
        <x-input-label for="city" :value="__('City')" />
        <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $client->city ?? '')" />
        <x-input-error class="mt-2" :messages="$errors->get('city')" />
    </div>

    <!-- State -->
    <div>
        <x-input-label for="state" :value="__('State')" />
        <x-text-input id="state" name="state" type="text" class="mt-1 block w-full" :value="old('state', $client->state ?? '')" />
        <x-input-error class="mt-2" :messages="$errors->get('state')" />
    </div>

    <!-- Postal Code -->
    <div>
        <x-input-label for="postal_code" :value="__('Postal Code')" />
        <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" :value="old('postal_code', $client->postal_code ?? '')" />
        <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
    </div>

    <!-- Country -->
    <div>
        <x-input-label for="country" :value="__('Country')" />
        <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $client->country ?? '')" />
        <x-input-error class="mt-2" :messages="$errors->get('country')" />
    </div>

    <!-- Tax ID -->
    <div>
        <x-input-label for="tax_id" :value="__('Tax ID')" />
        <x-text-input id="tax_id" name="tax_id" type="text" class="mt-1 block w-full" :value="old('tax_id', $client->tax_id ?? '')" />
        <x-input-error class="mt-2" :messages="$errors->get('tax_id')" />
    </div>

    <!-- Notes -->
    <div class="md:col-span-2">
        <x-input-label for="notes" :value="__('Notes')" />
        <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes', $client->notes ?? '') }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('notes')" />
    </div>
</div>

<!-- Recurring Invoice Section -->
<div class="mt-8 border-t border-gray-200 pt-6" x-data="{ recurringEnabled: {{ old('recurring_enabled', ($client->recurring_enabled ?? false)) ? 'true' : 'false' }} }">
    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Recurring Invoices') }}</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Enable Recurring -->
        <div class="md:col-span-2">
            <label class="inline-flex items-center">
                <input type="hidden" name="recurring_enabled" value="0">
                <input type="checkbox" name="recurring_enabled" value="1" x-model="recurringEnabled"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    {{ old('recurring_enabled', ($client->recurring_enabled ?? false)) ? 'checked' : '' }}>
                <span class="ml-2 text-sm text-gray-600">{{ __('Enable recurring invoices for this client') }}</span>
            </label>
        </div>

        <div x-show="recurringEnabled" x-cloak>
            <x-input-label for="recurring_frequency" :value="__('Frequency')" />
            <select id="recurring_frequency" name="recurring_frequency" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">{{ __('Select frequency') }}</option>
                <option value="monthly" {{ old('recurring_frequency', $client->recurring_frequency ?? '') === 'monthly' ? 'selected' : '' }}>{{ __('Monthly') }}</option>
                <option value="quarterly" {{ old('recurring_frequency', $client->recurring_frequency ?? '') === 'quarterly' ? 'selected' : '' }}>{{ __('Every 3 Months') }}</option>
                <option value="semi_annual" {{ old('recurring_frequency', $client->recurring_frequency ?? '') === 'semi_annual' ? 'selected' : '' }}>{{ __('Every 6 Months') }}</option>
                <option value="annual" {{ old('recurring_frequency', $client->recurring_frequency ?? '') === 'annual' ? 'selected' : '' }}>{{ __('Every 12 Months') }}</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('recurring_frequency')" />
        </div>

        <div x-show="recurringEnabled" x-cloak>
            <x-input-label for="business_start_date" :value="__('Business Start Date')" />
            <x-text-input id="business_start_date" name="business_start_date" type="date" class="mt-1 block w-full"
                :value="old('business_start_date', isset($client->business_start_date) ? $client->business_start_date->format('Y-m-d') : '')" />
            <x-input-error class="mt-2" :messages="$errors->get('business_start_date')" />
        </div>
    </div>
</div>
