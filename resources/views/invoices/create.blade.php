<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Invoice') }}
            </h2>
            <a href="{{ route('invoices.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                {{ __('Back to Invoices') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('invoices.store') }}">
                        @csrf

                        @include('invoices._form')

                        <div class="mt-6 flex items-center justify-end gap-4">
                            <a href="{{ route('invoices.index') }}">
                                <x-secondary-button type="button">
                                    {{ __('Cancel') }}
                                </x-secondary-button>
                            </a>
                            <x-primary-button>
                                {{ __('Create Invoice') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
