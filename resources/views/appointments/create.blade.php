<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg px-4 py-4">
                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('appointments.store') }}">
                        @csrf

                        <div>
                            <x-label for="name" value="{{ __('Patient Name') }}" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        </div>

                        <div>
                            <x-label for="code" value="{{ __('Patient Code') }}" />
                            <x-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code')" required autofocus autocomplete="code" />
                        </div>

                        <div>
                        <x-label for="clinic" value="{{__('Clinic')}}" />
                        <x-input id="clinic" class="block mt-1 w-full" type="text" name="clinic" required />
                        </div>

                        <div>
                            <x-select-field name="sex" :options="['Fix Appointment' => 'Fix Appointment', 'Tentative Appointment' => 'Tentative Appointment', 'Prospective lead' => 'Prospective lead', 'Interested Lead'=>'Interested Lead', 'Non interested'=>'Non interested']" >
                                Select {{ __('Appointment Type') }}
                            </x-select-field>
                        </div>

                        <div class="flex mt-4">
                            <x-button>
                                {{ __('Save Appointment') }}
                            </x-button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>