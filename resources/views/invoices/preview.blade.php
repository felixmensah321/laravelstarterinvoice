<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoice Preview') }}
            </h2>
            <a href="{{ url()->previous() }}" class="text-sm text-gray-600 hover:text-gray-900">
                {{ __('Back') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2">
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                        <iframe
                            id="preview-frame"
                            class="w-full border-0"
                            style="min-height: 800px;"
                            sandbox="allow-same-origin allow-scripts"
                        ></iframe>
                        <script>
                            const iframe = document.getElementById('preview-frame');
                            const html = @json($html);
                            iframe.srcdoc = html;
                            iframe.onload = function() {
                                this.style.height = this.contentWindow.document.documentElement.scrollHeight + 'px';
                            };
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
