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
                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$patient->name" disabled autocomplete="name" />
                            </div>
                            <div class="mt-4">
                                <x-label for="age" value="{{ __('Age') }}" />
                                <x-input id="age" class="block mt-1 w-full" type="text" name="age" :value="$patient->age" disabled autocomplete="age" />
                            </div>
                        </div>
                        <!-- Second Column -->
                        <div class="col-span-1">
                            <div class="mt-4">
                                <x-label for="code" value="{{ __('Patient Code') }}" />
                                <x-input id="code" class="block mt-1 w-full" type="text" name="code" :value="$patient->code" autocomplete="code" readonly />
                            </div>
                            <div class="mt-4">
                                <x-select-field name="sex" :options="config('variables.sex')" selected="{{$patient->sex}}" disabled>
                                    Select {{ __('Sex') }}
                                </x-select-field>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <h3><strong>History</strong></h3>
                            <ul>
                                @foreach($appointments as $appointment)
                                <li>
                                    <div class="mt-5 bg-gray overflow-hidden shadow-xl sm:rounded-lg">
                                        <div class="pt-8 pl-4 pr-4 pb-4 bg-gray"><strong>Appointment Date:</strong> {{ date('d-M-y H:i', strtotime($appointment->appointment_time)) }}</div>
                                        <div class="pt-4 pl-4 pr-4 pb-4 bg-gray">
                                            <strong>Health Problems:</strong>
                                            @foreach($appointment->healthProblems as $hp)
                                            <div class="mt-2 ml-5">- {{$hp->health_problem}}</div>
                                            @endforeach
                                        </div>
                                        <div class="pt-4 pl-4 pr-4 pb-4 bg-gray">
                                            <strong>Comments:</strong>
                                            <div class="mt-2 ml-5">{{$hp->comments}}</div>
                                        </div>
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
