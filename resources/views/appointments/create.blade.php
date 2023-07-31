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
                    <form method="POST" action="{{ route('appointments.store') }}">
                        @csrf

                        <!-- Two-Column Layout -->
                        <div class="grid grid-cols-1 gap-4">
                            <!-- First Column -->
                            <div class="col-span-1">
                                <!--
                                <div class="mt-4">
                                    <x-label for="patient_code" value="{{ __('Patient Name') }}" />
                                    <select onchange="updatePatientCodeView(this)" id="patient_code" name="patient_code" class="mt-1 block w-full border-gray-300 rounded-md">
                                        <option value="">Select an option</option>
                                        @foreach($patients as $patient)
                                        <option value="{{ $patient->code }}">{{ $patient->name .' '. $patient->email .' '. $patient->phone_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                -->
                                <div class="mt-4">
                                    <x-label for="phone_number" value="{{ __('Select Patient') }}" />
                                    <input id="phone_number" class="block mt-1 w-full  border-gray-300 rounded-md" x-data type="text" name="phone_number" required autofocus autocomplete="phone_number" x-on:input="searchPatients()" placeholder="Search Patient by Phone Number" />
                                    <!-- Search Results Dropdown -->
                                    <ul id="search-results"></ul>
                                    <span style="float: right;">
                                        <a class="ml-2 text-blue-500" href="sms:" target="_blank" onclick="openMessage(event);">SMS</a>
                                        <a class="ml-2 text-blue-500" href="https://wa.me/" target="_blank" onclick="openMessage(event);">WhatsApp</a>
                                    </span>

                                    <!-- "Create New Patient" Link -->
                                    <p id="no-patient-found" style="display: none; color:red">No patient found with the given phone number.</p>
                                    <a href="{{ route('patients.create') }}" id="create-patient-link" style="display: none;color:blue">Create New Patient</a>

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
                                    <x-input id="clinic" class="block mt-1 w-full" type="text" name="clinic" required placeholder="Enter Clinic" />
                                </div>
                                <div class="mt-4">
                                    <x-label for="lead_interest_score" value="{{__('Lead Interest Score')}}" />
                                    <x-input id="lead_interest_score" class="block mt-1 w-full" type="text" name="lead_interest_score" required placeholder="Enter Lead Interest Score" />
                                </div>
                                <div class="mt-4">
                                    <x-label for="current_status" value="{{ __('Current Status') }}" />
                                    <x-select-field name="current_status" :options="config('variables.appointmentStatus')" required>
                                    </x-select-field>
                                </div>
                                <div class="mt-4">
                                    <x-label for="assigned_to" value="{{__('Assigned To')}}" />
                                    <select id="assigned_to" name="assigned_to" class="mt-1 block w-full border-gray-300 rounded-md">
                                        <option value="">Select an option</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name .' '. $user->email }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <x-label for="reference_id" value="{{__('Reference ID')}}" />
                                    <select id="reference_id" name="reference_id" class="mt-1 block w-full border-gray-300 rounded-md">
                                        <option value="">Select an option</option>
                                        @foreach($appointments as $appointment)
                                        <option value="{{ $appointment->id }}">{{ $appointment->patient_code .' '. $appointment->created_at }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <x-label for="active" value="{{__('Active')}}" />
                                    <x-select-field name="active" :options="config('variables.yesNo')" required>
                                    </x-select-field>
                                </div>
                                <div class="mt-4">
                                    <x-label for="last_called_datetime" value="{{__('Last Called Time')}}" />
                                    <input id="last_called_datetime" name="last_called_datetime" x-data x-init="flatpickr($refs.input, {{ $callTimeOptions }} );" x-ref="input" type="text" placeholder="Select Time" data-input {{ $attributes->merge(['class' => 'block w-full disabled:bg-gray-200 p-2 border border-gray-300 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 sm:text-sm sm:leading-5']) }} />
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
                                    <x-input id="comments" class="block mt-1 w-full" type="text" name="comments" required placeholder="Enter Comments" />
                                </div>
                                <div class="mt-4">
                                    <x-label for="cancelation_reason" value="{{__('Cancelation Reason')}}" />
                                    <x-input id="cancelation_reason" class="block mt-1 w-full" type="text" name="cancelation_reason" placeholder="Enter Cancelation Reason" />
                                </div>
                                <div class="mt-4">
                                    <x-label for="missed_appointment_executive_id" value="{{__('Missed Appointment Executive')}}" />
                                    <select id="missed_appointment_executive_id" name="missed_appointment_executive_id" class="mt-1 block w-full border-gray-300 rounded-md">
                                        <option value="">Select an option</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name .' '. $user->email }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <x-label for="visited" value="{{__('Visited')}}" />
                                    <x-select-field name="visited" :options="config('variables.visited')" required>
                                    </x-select-field>
                                </div>
                                <div class="mt-4">
                                    <x-label for="last_messaged_datetime" value="{{__('Last Messaged Time')}}" />
                                    <input id="last_messaged_datetime" name="last_messaged_datetime" x-data x-init="flatpickr($refs.input, {{ $messageTimeOptions }} );" x-ref="input" type="text" placeholder="Select Time" data-input {{ $attributes->merge(['class' => 'block w-full disabled:bg-gray-200 p-2 border border-gray-300 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 sm:text-sm sm:leading-5']) }} />
                                </div>
                            </div>
                        </div>
                        <!-- End Two-Column Layout -->
                        <div class="flex mt-4">
                            <x-button>
                                {{ __('Save Appointment') }}
                            </x-button>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div style="display:none;">
        <span id="mobile"></span>
    </div>

    <script>
        /*
        function updatePatientCodeView(selectElement) {
            var selectedValue = selectElement.value;
            document.getElementById('patient_code_view').value = selectedValue;
        }
        */
        function searchPatients() {

            const searchResults = document.getElementById('search-results');
            const noPatientFound = document.getElementById('no-patient-found');
            const createPatientLink = document.getElementById('create-patient-link');
            const phone = document.getElementById('phone_number').value;
            // Clear the previous search results
            searchResults.innerHTML = '';
            noPatientFound.style.display = 'none';
            createPatientLink.style.display = 'none';
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
                        } else {
                            noPatientFound.style.display = 'block';
                            createPatientLink.style.display = 'block';
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
            document.getElementById('create-patient-link').style.display = 'none';
        }

        function openMessage(event) {
            event.preventDefault();
            const mobile = document.getElementById('mobile').textContent;
            if (mobile.length == 0) {
                alert('Please select the Patient!');
            } else {
                const linkUrl = event.target.getAttribute('href') + mobile;
                window.open(linkUrl, '_blank');
            }
        }
    </script>

    <style>
        #search-results li {
            min-height: 30px;
            border-radius: 5px;
            padding: 5px;
            margin: 1px;
            background-color: #edf3f7;
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
