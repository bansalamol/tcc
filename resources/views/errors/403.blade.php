<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6 text-blue-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 12c2.485 0 4.5-2.015 4.5-4.5S14.485 3 12 3 7.5 5.015 7.5 7.5 9.515 12 12 12zM3 21a9 9 0 0118 0H3z" fill="currentColor"/>
            </svg>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Forbidden') }}</h2>
        </div>
        <x-breadcrumb current="Forbidden" />
    </x-slot>

    <div class="py-6">
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
