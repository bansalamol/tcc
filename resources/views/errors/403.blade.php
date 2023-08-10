<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-6">
                    <div class="text-center">
                        <h1 class="text-3xl font-semi-bold text-red-800 mb-4">403 Forbidden</h1>
                        <p class="text-red-600">You do not have permission to access this page.</p>
                        <!-- You can customize this message further -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
