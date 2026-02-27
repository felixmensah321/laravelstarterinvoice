<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Client') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('clients.store') }}">
                        @csrf

                        @include('clients._form', ['client' => new \App\Models\Client()])

                        <div class="mt-6 flex items-center gap-4">
                            <x-primary-button>
                                {{ __('Create Client') }}
                            </x-primary-button>

                            <a href="{{ route('clients.index') }}">
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
