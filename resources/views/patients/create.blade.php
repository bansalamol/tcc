@props(['birtDateOptions' => "{dateFormat:'Y-m-d', enableTime:false, defaultDate: 'today', maxDate: 'today'}"])
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
                        <!-- Two-Column Layout -->
                        <div class="grid grid-cols-1 gap-4">
                            <!-- First Column -->
                            <div class="col-span-1">
                                <div class="mt-4">
                                    <x-label for="code" value="{{ __('Patient Code') }}" />
                                    <x-input id="code" class="block mt-1 w-full cursor-not-allowed bg-gray-100" type="text" readonly name="code" :value="old('code')" required autofocus autocomplete="code" />
                                </div>

                                <div class="mt-4">
                                    <x-label for="name" value="{{ __('Patient Name') }}" />
                                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                </div>

                                <div class="mt-4">
                                    <x-label for="phone_number" value="{{ __('Patient Phone Number') }}" />
                                    <x-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required autofocus autocomplete="phone_number" />
                                </div>

                                <div class="mt-4">
                                    <x-select-field name="sex" :options="config('variables.sex')" selected="">
                                        Select {{ __('Sex') }}
                                    </x-select-field>
                                </div>

                                <div class="mt-4">
                                    <x-label for="profession" value="{{ __('Profession') }}" />
                                    <x-input id="profession" class="block mt-1 w-full" type="text" name="profession" :value="old('profession')" required autofocus autocomplete="profession" />
                                </div>

                            </div>

                            <!-- Second Column -->
                            <div class="col-span-1">

                                <div class="mt-4">
                                    <x-label for="age" value="{{ __('Age') }}" />
                                    <input id="age" class="block mt-1 w-full  border-gray-300 rounded-md" x-data  type="text" name="age"  required autofocus autocomplete="age" x-on:input="calculateBirthdateOrAge()"  />
                                </div class="mt-4">

                                <div class="mt-4">
                                    <x-label for="birth_date" value="{{ __('Birth Date') }}" />
                                   <!-- <x-input id="birth_date" class="block mt-1 w-full" type="text" name="birth_date" :value="old('birth_date')" required autofocus autocomplete="birth_date" /> -->
                                   <input id="birth_date" name="birth_date" x-data x-init="flatpickr($refs.input, {{ $birtDateOptions }} );" x-on:input="calculateAgeOrBirthdate()" x-ref="input" type="text" placeholder="Select Time" data-input {{ $attributes->merge(['class' => 'mt-1 block w-full disabled:bg-gray-200 p-2 border border-gray-300 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 sm:text-sm sm:leading-5']) }} />
                                </div>

                                <div class="mt-4">
                                    <x-label for="alternate_phone_number" value="{{ __('Alternate Phone Number') }}" />
                                    <x-input id="alternate_phone_number" class="block mt-1 w-full" type="text" name="alternate_phone_number" :value="old('alternate_phone_number')" required autofocus autocomplete="alternate_phone_number" />
                                </div>

                                <div class="mt-4">
                                    <x-label for="email" value="{{ __('Email') }}" />
                                    <x-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required autofocus autocomplete="email" />
                                </div>
                                <div class="mt-4">
                                    <x-label for="address" value="{{ __('Address') }}" />
                                    <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autofocus autocomplete="address" />
                                </div>
                                <div class="mt-4">
                                    <x-select-field name="do_not_contact" :options="config('variables.yesNo')" selected="No">
                                        Select {{ __('Do Not Contact') }}
                                    </x-select-field>
                                </div>
                            </div>
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
    <script>
    //TODO: Move this to custom js file.
  function calculateBirthdateOrAge() {
    const age = document.getElementById('age').value;
    const birthdateInput = document.getElementById('birth_date');
    if (age) {
      const now = new Date();
      const birthdate = new Date(now.getFullYear() - age, now.getMonth(), now.getDate());
      const formattedBirthdate = formatDate(birthdate);
      birthdateInput.value = formattedBirthdate;
    } else {
      birthdateInput.value = '';
    }
  }

  function calculateAgeOrBirthdate() {
    const birthdate = document.getElementById('birth_date').value;
    const ageInput = document.getElementById('age');
    if (birthdate) {
      const now = new Date();
      const birthdateDate = new Date(birthdate);
      const age = now.getFullYear() - birthdateDate.getFullYear();
      ageInput.value = age;
    } else {
      ageInput.value = '';
    }
  }

  function formatDate(date) {
    const year = date.getFullYear();
    let month = 6; //date.getMonth() + 1;
    let day = 1; //date.getDate();
    // Add leading zeros if needed
    month =  month < 10 ? `0${month}` : month;
    day = day < 10 ? `0${day}` : day;
    return `${year}-${month}-${day}`;
  }
  function generateRandomCode(length) {
        const characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        let code = '';
        const now = new Date();
        for (let i = 0; i < length; i++) {
            code += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        return "P"+now.getFullYear()+"-"+code;
    }
    // Call the function to generate a random code with a length of 6 characters
    const randomCode = generateRandomCode(6);
    // Insert the generated code into the HTML
    document.getElementById('code').value = randomCode;
</script>


</x-app-layout>