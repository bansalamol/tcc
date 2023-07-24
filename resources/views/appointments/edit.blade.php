<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Appoinments') }}
        </h2>
    </x-slot>
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg px-4 py-4">
                    <x-validation-errors class="mb-4" />
 
                    <form method="POST" action="{{ route('appointments.update', $appoinment ) }}">
                        @csrf
                        @method('PUT')
 
                        <div>
                            <x-label for="code" value="{{ __('Patient Code') }}" />
                            <x-input id="code" class="block mt-1 w-full cursor-not-allowed bg-gray-100" type="text" name="code" :value="" required autofocus autocomplete="code" readonly />
                        </div>

                        <div>
                            <x-label for="name" value="{{ __('Patient Name') }}" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="" required autofocus autocomplete="name" />
                        </div>

                        
 
                        <div class="flex mt-4">
                            <x-button>
                                {{ __('Save Patient') }}
                            </x-button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
