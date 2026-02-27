{{-- Line Items partial powered by Alpine.js --}}
<div
    x-data="{
        items: {{ isset($invoice) && $invoice->items ? json_encode($invoice->items->map(fn($item) => ['description' => $item->description, 'quantity' => $item->quantity, 'unit_price' => $item->unit_price])->toArray()) : json_encode([['description' => '', 'quantity' => 1, 'unit_price' => 0]]) }},
        addItem() {
            this.items.push({ description: '', quantity: 1, unit_price: 0 });
        },
        removeItem(index) {
            this.items.splice(index, 1);
        },
        itemTotal(item) {
            return (parseFloat(item.quantity) * parseFloat(item.unit_price)).toFixed(2);
        },
        get subtotal() {
            return this.items.reduce((sum, item) => sum + parseFloat(item.quantity) * parseFloat(item.unit_price), 0).toFixed(2);
        }
    }"
>
    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Line Items') }}</h3>

    {{-- Header Row --}}
    <div class="hidden sm:grid sm:grid-cols-12 gap-4 mb-2">
        <div class="col-span-5">
            <span class="block font-medium text-sm text-gray-700">{{ __('Description') }}</span>
        </div>
        <div class="col-span-2">
            <span class="block font-medium text-sm text-gray-700">{{ __('Quantity') }}</span>
        </div>
        <div class="col-span-2">
            <span class="block font-medium text-sm text-gray-700">{{ __('Unit Price') }}</span>
        </div>
        <div class="col-span-2">
            <span class="block font-medium text-sm text-gray-700">{{ __('Total') }}</span>
        </div>
        <div class="col-span-1"></div>
    </div>

    {{-- Item Rows --}}
    <template x-for="(item, index) in items" :key="index">
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 mb-3 p-4 sm:p-0 bg-gray-50 sm:bg-transparent rounded-lg sm:rounded-none">
            {{-- Description --}}
            <div class="sm:col-span-5">
                <x-input-label class="sm:hidden" :value="__('Description')" />
                <x-text-input
                    type="text"
                    class="block w-full"
                    x-model="item.description"
                    x-bind:name="'items[' + index + '][description]'"
                    placeholder="Item description"
                    required
                />
            </div>

            {{-- Quantity --}}
            <div class="sm:col-span-2">
                <x-input-label class="sm:hidden" :value="__('Quantity')" />
                <x-text-input
                    type="number"
                    class="block w-full"
                    x-model="item.quantity"
                    x-bind:name="'items[' + index + '][quantity]'"
                    min="1"
                    step="1"
                    required
                />
            </div>

            {{-- Unit Price --}}
            <div class="sm:col-span-2">
                <x-input-label class="sm:hidden" :value="__('Unit Price')" />
                <x-text-input
                    type="number"
                    class="block w-full"
                    x-model="item.unit_price"
                    x-bind:name="'items[' + index + '][unit_price]'"
                    min="0"
                    step="0.01"
                    required
                />
            </div>

            {{-- Calculated Total --}}
            <div class="sm:col-span-2 flex items-center">
                <x-input-label class="sm:hidden mr-2" :value="__('Total:')" />
                <span class="text-sm font-medium text-gray-900" x-text="itemTotal(item)"></span>
            </div>

            {{-- Remove Button --}}
            <div class="sm:col-span-1 flex items-center">
                <button
                    type="button"
                    class="text-red-600 hover:text-red-800 text-sm font-medium"
                    x-on:click="removeItem(index)"
                    x-show="items.length > 1"
                >
                    {{ __('Remove') }}
                </button>
            </div>
        </div>
    </template>

    {{-- Validation errors for items --}}
    <x-input-error :messages="$errors->get('items')" class="mt-1" />
    <x-input-error :messages="$errors->get('items.*')" class="mt-1" />

    {{-- Add Item Button --}}
    <div class="mt-4">
        <x-secondary-button type="button" x-on:click="addItem()">
            {{ __('+ Add Item') }}
        </x-secondary-button>
    </div>

    {{-- Subtotal --}}
    <div class="mt-6 flex justify-end">
        <div class="text-right">
            <span class="text-sm font-medium text-gray-700">{{ __('Subtotal:') }}</span>
            <span class="ml-2 text-lg font-semibold text-gray-900" x-text="subtotal"></span>
        </div>
    </div>
</div>
