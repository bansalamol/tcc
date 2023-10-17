@props(['callTimeOptions' => "{dateFormat:'Y-m-d H:i', enableTime:true, defaultDate: 'today', maxDate: 'today'}"])
@props(['messageTimeOptions' => "{dateFormat:'Y-m-d H:i', enableTime:true, defaultDate: 'today', maxDate: 'today'}"])
@props(['appointmentTimeOptions' => "{dateFormat:'Y-m-d H:i', enableTime:true, defaultDate: 'today', minDate: 'today'}"])

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
                    @if (session('success'))
                    <div class="bg-green-200 p-4 rounded-md mb-4">
                        {!! session('success') !!}
                    </div>
                    @endif

                    <!-- Your form and search results here -->

                    <form method="POST" id="appointment_create" action="{{ route('appointments.store') }}">
                        @csrf

                        <!-- Two-Column Layout -->
                        <div class="grid grid-cols-1 gap-4">
                            <!-- First Column -->
                            <div class="col-span-1">

                                <div class="mt-4">
                                    <x-label for="phone_number" value="{{ __('Select Patient') }}" />
                                    <input id="phone_number" class="block mt-1 w-full  border-gray-300 rounded-md" x-data type="text" name="phone_number" value="{{ $mobile }}" required autofocus autocomplete="phone_number" x-on:input="searchPatients()" placeholder="Search Patient by Phone Number" />
                                    <!-- Search Results Dropdown -->
                                    <ul id="search-results"></ul>


                                    <!-- "Create New Patient" Link -->
                                    <p id="no-patient-found" style="display: none; color:red">No patient found with the given phone number.</p>
                                    <a href="#" onclick="return createPatient(event);" id="create-patient-link" style="color:blue">Create New Patient</a>

                                </div>


                                <div class="mt-4">
                                    <x-label for="patient_code" value="{{ __('Patient Code') }}" />
                                    <x-input id="patient_code" class="cursor-not-allowed opacity-50 block mt-1 w-full" type="text" name="patient_code" :value="old('patient_code')" placeholder="Patient Code" readonly />
                                </div>
                                <div class="mt-4">
                                    <x-label for="appointment_type" value="{{ __('Appointment Type') }}" />
                                    <x-select-field name="appointment_type" :options="config('variables.appointmentTypes')" required>
                                    </x-select-field>
                                </div>
                                <div class="mt-4">
                                    <x-label for="clinic" value="{{__('Clinic')}}" />
                                    <x-select-field name="clinic" :options="config('variables.clinicList')" required>
                                    </x-select-field>
                                </div>
                                <div class="mt-4">
                                    <x-label for="lead_source" value="{{__('Lead Source')}}" />
                                    <x-select-field name="lead_source" :options="config('variables.leadType')" required >
                                    </x-select-field>
                                </div>
                                <div class="mt-4">
                                    <x-label for="lead_interest_score" value="{{__('Lead Interest Score')}}" />
                                    <x-select-field name="lead_interest_score" :options="config('variables.interestScore')" required selected="1">
                                    </x-select-field>
                                </div>
                                <div class="mt-4">
                                    <x-label for="current_status" value="{{ __('Current Status') }}" />
                                    <x-select-field name="current_status" :options="config('variables.appointmentStatus')" required selected="Appointment Scheduled">
                                    </x-select-field>
                                </div>

                            </div>

                            <!-- Second Column -->
                            <div class="col-span-1">

                                <div class="mt-4">
                                    <x-label for="appointment_time" value="{{__('Appointment Time')}}" />
                                    <input id="appointment_time" name="appointment_time" x-data x-init="flatpickr($refs.input, {{ $appointmentTimeOptions }} );" x-ref="input" type="text" placeholder="Select Time" data-input {{ $attributes->merge(['class' => 'mt-1 block w-full disabled:bg-gray-200 p-2 border border-gray-300 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 sm:text-sm sm:leading-5']) }} />
                                </div>
                                <div class="mt-4">
                                    <x-label value="{{ __('Health Problem') }}" />
                                    <div style="min-height:45px;">
                                        @foreach(config('variables.healthProblems') as $option)
                                        <div class="ml-5 mt-1" style="width:auto; float:left;">
                                            <input id="chk-hp-{{ $option }}" type="checkbox" name="health_problem[]" value="{{ $option }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                                            <label for="chk-hp-{{ $option }}"> {{ $option }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="">
                                    <x-label for="comments" value="{{__('Comments')}}" />
                                    <x-input id="comments" class="block mt-1 w-full" type="text" name="comments" placeholder="Enter Comments" />
                                </div>

                            </div>
                        </div>
                        <!-- End Two-Column Layout -->
                        <div class="flex mt-4">
                            <x-button :id="'createAptSbtm'">
                                {{ __('Save Appointment') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div style="display:none;">
        <span id="mobile"></span>
    </div>

    <script>
        function createPatient(event) {
            const url = "{{ route('patients.create.mobile', '') }}";
            const selectedMobile = document.getElementById('mobile').textContent;
            const enteredPhone = document.getElementById('phone_number').value;
            let slug = '';
            if (selectedMobile.length === 10) {
                slug = selectedMobile;
            } else if (enteredPhone.length === 10) {
                slug = enteredPhone;
            }
            event.preventDefault();
            window.location.href = url + '/' + slug;
        }

        function searchPatients() {

            const searchResults = document.getElementById('search-results');
            const noPatientFound = document.getElementById('no-patient-found');
            const phone = document.getElementById('phone_number').value;
            // Clear the previous search results
            searchResults.innerHTML = '';
            noPatientFound.style.display = 'none';
            document.getElementById('mobile').textContent = "";


            // Perform the search only if the phone number has exactly 10 digits
            if (phone.length === 10) {
                fetch(`/patient/searchbyphone?phone=${phone}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            data.forEach(patient => {
                                const li = document.createElement('li');
                                li.textContent = `${patient.name} (${patient.phone_number})`;
                                li.addEventListener('click', () => selectPatient(li.textContent, patient.code, patient.phone_number));
                                searchResults.appendChild(li);
                            });
                            //searchResults.appendChild()
                        } else {
                            noPatientFound.style.display = 'block';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching patients:', error);
                    });
            }

        }

        function selectPatient(selectedItem, patientId, mobile) {
            document.getElementById('mobile').textContent = mobile;
            document.getElementById('patient_code').value = patientId;
            document.getElementById('phone_number').value = selectedItem;
            document.getElementById('search-results').innerHTML = '';
            document.getElementById('no-patient-found').style.display = 'none';
        }
        searchPatients();

        let buttonClicked = false;

        document.getElementById('createAptSbtm').addEventListener('click', function() {
            alert("event started");
            if (buttonClicked) return;

            buttonClicked = true;
            // Your form submission logic here

            setTimeout(function() {
                alert("setting enable");
                buttonClicked = false;
            }, 3000); // Allow the button to be clicked again after 1 second
        });

    </script>


    <style>
        #search-results li {
            min-height: 30px;
            border-radius: 5px;
            padding: 5px;
            margin: 1px;
            background-color: #edf3f7;
            padding-left: 20px;
        }

        #search-results li:nth-child(even) {
            background-color: #f9f9f9;
        }

        #search-results li:nth-child(odd) {
            background-color: #edf3f7;
        }

        #search-results li:hover {
            background-color: #f5cb85;
        }
    </style>

</x-app-layout>
