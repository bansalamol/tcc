<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patient History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg px-4 py-4">

                    <!-- Two-Column Layout -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- First Column -->
                        <div class="col-span-1">
                            <div class="mt-4">
                                <x-label for="name" value="{{ __('Patient Name') }}" />
                                <x-input id="name" class="block mt-1 w-full bg-gray-50" type="text" name="name" :value="$patient->name" disabled autocomplete="name" />
                            </div>
                            <div class="mt-4">
                                <x-label for="age" value="{{ __('Age') }}" />
                                <x-input id="age" class="block mt-1 w-full bg-gray-50" type="text" name="age" :value="$patient->age" disabled autocomplete="age" />
                            </div>
                        </div>
                        <!-- Second Column -->
                        <div class="col-span-1">
                            <div class="mt-4">
                                <x-label for="code" value="{{ __('Patient Code') }}" />
                                <x-input id="code" class="block mt-1 w-full bg-gray-50" type="text" name="code" :value="$patient->code" autocomplete="code" readonly />
                            </div>
                            <div class="mt-4">
                                <x-select-field name="sex" :options="config('variables.sex')" selected="{{$patient->sex}}" disabled class="bg-gray-50">
                                    Select {{ __('Sex') }}
                                </x-select-field>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <h3><strong>History</strong></h3>
                            <ul>
                                @foreach($appointments as $appointment)
                                <li>
                                    <div class="mt-5 bg-gray-100 border border-gray-300 rounded-lg p-4 shadow-xl">
                                        <div class="mb-4">
                                            <strong class="text-gray-700">Appointment Date:</strong>
                                            <p class="text-sm italic text-gray-600">{{ date('d-M-y H:i', strtotime($appointment->appointment_time)) }} | Created by: {{$appointment->creator->name}} | Created at: {{ date('d-M-y H:i', strtotime($appointment->created_at))}}</p>
                                        </div>
                                        <div class="mb-4">
                                            <strong class="text-gray-700">Activity Log:</strong>
                                            <ul class="ml-6 list-disc">

                                                @if(!$appointment->activity->isEmpty())
                                                    @foreach($appointment->activity as $log)
                                                        <li class="text-sm text-gray-600">{{date('d-M-y H:i', strtotime($log->created_at))}} | {{ $log->activity_description }} </li>
                                                    @endforeach
                                                @else
                                                    <li class="text-sm text-gray-600"> No action taken on Appointment</li>
                                                @endif
                                            </ul>
                                        </div>
                                        @if(!$appointment->healthProblems->isEmpty())
                                        <div class="mb-4">
                                            <strong class="text-gray-700">Health Problems:</strong>
                                            <ul class="ml-6 list-disc">
                                                @foreach($appointment->healthProblems as $hp)
                                                    <li class="text-sm text-gray-600">{{$hp->health_problem}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div>
                                            <strong class="text-gray-700">Comments:</strong>
                                            <p class="ml-6 text-sm text-gray-600">{{$hp->comments}}</p>
                                        </div>
                                        @endif

                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                    <!-- End Two-Column Layout -->


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
