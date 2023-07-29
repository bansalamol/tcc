<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Patient') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg px-4 py-4">
                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('patients.update', $patient ) }}">
                        @csrf
                        @method('PUT')
                        <!-- Two-Column Layout -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- First Column -->
                            <div class="col-span-1">
                                <div class="mt-4">
                                    <x-label for="code" value="{{ __('Patient Code') }}" />
                                    <x-input id="code" class="block mt-1 w-full cursor-not-allowed bg-gray-100" type="text" name="code" :value="$patient->code" required autofocus autocomplete="code" readonly />
                                </div>

                                <div class="mt-4">
                                    <x-label for="name" value="{{ __('Patient Name') }}" />
                                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$patient->name" required autofocus autocomplete="name" />
                                </div>

                                <div class="mt-4">
                                    <x-label for="phone_number" value="{{ __('Patient Phone Number') }}" />
                                    <x-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="$patient->phone_number" required autofocus autocomplete="phone_number" />
                                </div>

                                <div class="mt-4">
                                    <x-select-field name="sex" :options="['Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other']" selected="{{$patient->sex}}">
                                        Select {{ __('Sex') }}
                                    </x-select-field>
                                </div>
                                <div class="mt-4">
                                    <x-label for="profession" value="{{ __('Profession') }}" />
                                    <x-input id="profession" class="block mt-1 w-full" type="text" name="profession" :value="$patient->profession" required autofocus autocomplete="profession" />
                                </div>
                            </div>
                            <!-- Second Column -->
                            <div class="col-span-1">
                                <div class="mt-4">
                                    <x-label for="age" value="{{ __('Age') }}" />
                                    <x-input id="age" class="block mt-1 w-full cursor-not-allowed bg-gray-100" type="text" name="age" :value="$patient->age" required autofocus autocomplete="age" />
                                </div>
                                <div class="mt-4">
                                    <x-label for="birth_date" value="{{ __('Birth Date') }}" />
                                    <x-input id="birth_date" class="block mt-1 w-full cursor-not-allowed bg-gray-100" type="text" name="birth_date" :value="$patient->birth_date" readonly required autofocus autocomplete="birth_date" />
                                </div>

                                <div class="mt-4">
                                    <x-label for="alternate_phone_number" value="{{ __('Alternate Phone Number') }}" />
                                    <x-input id="alternate_phone_number" class="block mt-1 w-full" type="text" name="alternate_phone_number" :value="$patient->alternate_phone_number" required autofocus autocomplete="alternate_phone_number" />
                                </div>

                                <div class="mt-4">
                                    <x-label for="email" value="{{ __('Email') }}" />
                                    <x-input id="email" class="block mt-1 w-full" type="text" name="email" :value="$patient->email" required autofocus autocomplete="email" />
                                </div>
                                <div class="mt-4">
                                    <x-label for="address" value="{{ __('Address') }}" />
                                    <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="$patient->address" required autofocus autocomplete="address" />
                                </div>
                                <div class="mt-4">
                                    <x-select-field name="do_not_contact" :options="[1 => 'Yes', 0 => 'No']" selected="{{$patient->do_not_contact}}">
                                        Select {{ __('Do Not Contact') }}
                                    </x-select-field>
                                </div>
                            </div>
                        </div>
                        <div class="flex mt-4">
                            <x-button>
                                {{ __('Update Patient') }}
                            </x-button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>