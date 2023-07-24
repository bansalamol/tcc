<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Patient') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg px-4 py-4">
                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('patients.store') }}">
                        @csrf

                        <div>
                            <x-label for="code" value="{{ __('Patient Code') }}" />
                            <x-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code')" required autofocus autocomplete="code" />
                        </div>

                        <div>
                            <x-label for="name" value="{{ __('Patient Name') }}" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        </div>

                        <div>
                            <x-label for="phone_number" value="{{ __('Patient Phone Number') }}" />
                            <x-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required autofocus autocomplete="phone_number" />
                        </div>

                        <div>
                            <x-select-field name="sex" :options="['Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other']" selected="">
                                Select {{ __('Sex') }}
                            </x-select-field>
                        </div>

                        <div>
                            <x-label for="birth_date" value="{{ __('Birth Date') }}" />
                            <x-input id="birth_date" class="block mt-1 w-full" type="text" name="birth_date" :value="old('birth_date')" required autofocus autocomplete="birth_date" />
                        </div>

                        <div>
                            <x-label for="age" value="{{ __('Age') }}" />
                            <x-input id="age" class="block mt-1 w-full" type="text" name="age" :value="old('age')" required autofocus autocomplete="age" />
                        </div>

                        <div>
                            <x-label for="profession" value="{{ __('Profession') }}" />
                            <x-input id="profession" class="block mt-1 w-full" type="text" name="profession" :value="old('profession')" required autofocus autocomplete="profession" />
                        </div>

                        <div>
                            <x-label for="alternate_phone_number" value="{{ __('Alternate Phone Number') }}" />
                            <x-input id="alternate_phone_number" class="block mt-1 w-full" type="text" name="alternate_phone_number" :value="old('alternate_phone_number')" required autofocus autocomplete="alternate_phone_number" />
                        </div>

                        <div>
                            <x-label for="email" value="{{ __('Email') }}" />
                            <x-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required autofocus autocomplete="email" />
                        </div>
                        <div>
                            <x-label for="address" value="{{ __('Address') }}" />
                            <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autofocus autocomplete="address" />
                        </div>
                        <div>                           
                            <x-select-field name="do_not_contact" :options="['1' => 'Yes', '0' => 'No']" selected="0">
                                Select {{ __('Do Not Contact') }}
                            </x-select-field>
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