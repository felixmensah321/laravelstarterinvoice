<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Client') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('clients.update', $client) }}">
                        @csrf
                        @method('PUT')

                        @include('clients._form', ['client' => $client])

                        <div class="mt-6 flex items-center gap-4">
                            <x-primary-button>
                                {{ __('Update Client') }}
                            </x-primary-button>

                            <a href="{{ route('clients.show', $client) }}">
                                <x-secondary-button type="button">
                                    {{ __('Cancel') }}
                                </x-secondary-button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
