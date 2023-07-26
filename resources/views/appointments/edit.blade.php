@props(['callTimeOptions' => "{dateFormat:'Y-m-d H:i', enableTime:true, defaultDate: '$appointment->last_called_datetime', maxDate: 'today'}"])
@props(['messageTimeOptions' => "{dateFormat:'Y-m-d H:i', enableTime:true, defaultDate: '$appointment->last_messaged_datetime', maxDate: 'today'}"])
@props(['appointmentTimeOptions' => "{dateFormat:'Y-m-d H:i', enableTime:true, defaultDate: '$appointment->appointment_time', minDate: 'today'}"])
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg px-4 py-4">
                    <x-validation-errors class="mb-4" />
                    <form method="POST" action="{{ route('appointments.update', $appointment ) }}">
                        @csrf
                        @method('PUT')

                        <!-- Two-Column Layout -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- First Column -->
                            <div class="col-span-1">
                                <div class="mt-4">
                                    <x-label for="name" value="{{ __('Patient Name') }}" />
                                    <x-input id="name" class="cursor-not-allowed opacity-50 block mt-1 w-full" type="text" name="name" :value="$appointment->patient->name" placeholder="Enter Patient Name" readonly />
                                </div>
                                <div class="mt-4">
                                    <x-label for="clinic" value="{{__('Clinic')}}" />
                                    <x-input id="clinic" class="block mt-1 w-full" type="text" name="clinic" :value="$appointment->clinic" required placeholder="Enter Clinic" />
                                </div>
                                <div class="mt-4">
                                    <x-label for="lead_interest_score" value="{{__('Lead Interest Score')}}" />
                                    <x-input id="lead_interest_score" class="block mt-1 w-full" type="text" name="lead_interest_score" :value="$appointment->lead_interest_score" required placeholder="Enter Lead Interest Score" />
                                </div>
                                <div class="mt-4">
                                    <x-label for="current_status" value="{{ __('Current Status') }}" />
                                    <x-select-field name="current_status" :selected="$appointment->current_status" :options="config('variables.appointmentStatus')" required>
                                    </x-select-field>
                                </div>
                                <div class="mt-4">
                                    <x-label for="assigned_to" value="{{__('Assigned To')}}" />
                                    <select id="assigned_to" name="assigned_to" class="mt-1 block w-full border-gray-300 rounded-md">
                                        <option value="">Select an option</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}"  @if($appointment->assigned_to == $user->id) selected @endif >{{ $user->name .' '. $user->email }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <x-label for="reference_id" value="{{__('Reference ID')}}" />
                                    <select id="reference_id" name="reference_id" class="mt-1 block w-full border-gray-300 rounded-md">
                                        <option value="">Select an option</option>
                                        @foreach($appointments as $app)
                                        <option value="{{ $app->id }}"  @if($appointment->reference_id == $app->id) selected @endif>{{ $app->patient_code .' '. $app->created_at }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <x-label for="active" value="{{__('Active')}}" />
                                    <x-select-field name="active" :selected="$appointment->active" :options="config('variables.yesNo')" required>
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
                                    <x-label for="patient_code" value="{{ __('Patient Code') }}" />
                                    <x-input id="patient_code" class="cursor-not-allowed opacity-50 block mt-1 w-full" type="text" name="patient_code" :value="$appointment->patient_code" placeholder="Patient Code" readonly />
                                </div>
                                <div class="mt-4">
                                    <x-label for="appointment_type" value="{{ __('Appointment Type') }}" />
                                    <x-select-field name="appointment_type" :selected="$appointment->appointment_type" :options="config('variables.appointmentTypes')" required>
                                    </x-select-field>
                                </div>
                                <div class="mt-4">
                                    <x-label for="appointment_time" value="{{__('Appointment Time')}}" />
                                    <input id="appointment_time" name="appointment_time" x-data x-init="flatpickr($refs.input, {{ $appointmentTimeOptions }} );" x-ref="input" type="text" placeholder="Select Time" data-input {{ $attributes->merge(['class' => 'mt-1 block w-full disabled:bg-gray-200 p-2 border border-gray-300 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 sm:text-sm sm:leading-5']) }} />
                                </div>
                                <div class="mt-4">
                                    <x-label value="{{ __('Health Problem') }}" />
                                    <div style="min-height:45px;">
                                        @foreach(config('variables.healthProblems') as $option)
                                        <div style="width: 100px; float:left;">
                                            <input id="chk-hp-{{ $option }}" type="checkbox" @if(in_array($option, explode(', ', $appointment->health_problem))) checked @endif name="health_problem[]" value="{{ $option }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                                            <label for="chk-hp-{{ $option }}"> {{ $option }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <x-label for="comments" value="{{__('Comments')}}" />
                                    <x-input id="comments" class="block mt-1 w-full" type="text" name="comments" :value="$appointment->comments" required placeholder="Enter Comments" />
                                </div>
                                <div class="mt-4">
                                    <x-label for="cancelation_reason" value="{{__('Cancelation Reason')}}" />
                                    <x-input id="cancelation_reason" class="block mt-1 w-full" type="text" name="cancelation_reason" :value="$appointment->cancelation_reason" placeholder="Enter Cancelation Reason" />
                                </div>
                                <div class="mt-4">
                                    <x-label for="missed_appointment_executive_id" value="{{__('Missed Appointment Executive')}}" />
                                    <select id="missed_appointment_executive_id" name="missed_appointment_executive_id" class="mt-1 block w-full border-gray-300 rounded-md">
                                        <option value="">Select an option</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}" @if($appointment->missed_appointment_executive_id == $user->id) selected @endif >{{ $user->name .' '. $user->email }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <x-label for="visited" value="{{__('Visited')}}" />
                                    <x-select-field name="visited" :selected="$appointment->visited" :options="config('variables.yesNo')" required>
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
    <script>
        function updatePatientCodeView(selectElement) {
            var selectedValue = selectElement.value;
            document.getElementById('patient_code_view').value = selectedValue;
        }
    </script>

</x-app-layout>
