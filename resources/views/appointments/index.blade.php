<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Appointments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    @if (session('success'))
                    <div class="bg-green-200 p-4 rounded-md m-4">
                        {!! session('success') !!}
                    </div>
                    @endif

                    @can('manage patients')
                    <div class="float-right m-3">
                        <x-link href="{{ route('appointments.create') }}" class="m-4">Book Appointment</x-link>
                        <x-link href="{{ route('patients.create') }}" class="m-4">Add new Patient</x-link>
                    </div>
                    @endcan
                    <div class="m-3 flex items-center space-x-4">
                        <button id="advanceSearchBtn" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Advance Search</button>
                    </div>
                    <div id="searchContainer" class="ml-4 hidden">
                        <form action="{{ route('appointments.index') }}" method="GET">
                            <div class="space-x-2 mt-4">
                                <label for="name" class="block font-medium text-sm text-gray-700 ml-2">Patient Name</label>
                                <input type="text" id="pname" name="pname" value="{{ $name }}" class="mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Enter Patient Name">
                            </div>
                            <div class="space-x-2 mt-4">
                                <label for="mobile" class="block font-medium text-sm text-gray-700 ml-2">Mobile</label>
                                <input type="text" id="mobile" name="mobile" value="{{ $mobile }}" class="mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Enter Mobile">
                            </div>
                            <div class="space-x-2 mt-4">
                                <label for="appointment_type" class="block font-medium text-sm text-gray-700 ml-2">Appointment Type</label>
                                <select name="appointment_type" id="appointment_type" class="mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select an option</option>
                                    @foreach(config('variables.appointmentTypes') as $value => $label)
                                    <option value="{{ $value }}" {{ $value == $appointmentType ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                            <div class="space-x-2 mt-4">
                                <label for="status"  class="block font-medium text-sm text-gray-700 ml-2">Current Status</label>
                                <select name="status" id="status" class="mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select an option</option>
                                    @foreach(config('variables.appointmentStatus') as $value => $label)
                                    <option value="{{ $value }}" {{ $value == $currentStatus ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-x-2 mt-4">
                                <label for="cstart_date" class="block font-medium text-sm text-gray-700 ml-2">Created Date</label>
                                <input type="text" id="cstart_date" name="cstart_date" class="mt-1 datepicker rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" value="{{ $cstartDate }}" placeholder="Select Start Date">
                                <input type="text" id="cend_date" name="cend_date" class="mt-1 datepicker rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" value="{{ $cendDate }}" placeholder="Select End Date">
                            </div>
                            <div class="space-x-2 mt-4">
                                <label for="astart_date" class="block font-medium text-sm text-gray-700 ml-2">Appointment Date</label>
                                <input type="text" id="astart_date" name="astart_date" class="mt-1 datepicker rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" value="{{ $astartDate }}" placeholder="Select Start Date">
                                <input type="text" id="aend_date" name="aend_date" class="mt-1 datepicker rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" value="{{ $aendDate }}" placeholder="Select End Date">
                            </div>
                            <div class="space-x-2 mt-4">
                                <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Search</button>
                                <a href="{{ route('appointments.index') }}" class="mt-4 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:bg-gray-400">Reset</a>
                            </div>
                        </form>
                    </div>

                    <table class="mt-4 w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ route('appointments.index', array_merge(request()->input(), [
                                        'sortField' => 'patient_code',
                                        'sortDirection' => $sortField === 'patient_code' && $sortDirection === 'asc' ? 'desc' : 'asc',
                                        ])) }}">
                                        Patient Code
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ route('appointments.index', array_merge(request()->input(), [
                                        'sortField' => 'name',
                                        'sortDirection' => $sortField === 'name' && $sortDirection === 'asc' ? 'desc' : 'asc',
                                        ])) }}">
                                        Patient Name
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ route('appointments.index', array_merge(request()->input(), [
                                        'sortField' => 'appointment_type',
                                        'sortDirection' => $sortField === 'appointment_type' && $sortDirection === 'asc' ? 'desc' : 'asc',
                                        ])) }}">
                                        Appointment Type
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ route('appointments.index', array_merge(request()->input(), [
                                        'sortField' => 'appointment_time',
                                        'sortDirection' => $sortField === 'appointment_time' && $sortDirection === 'asc' ? 'desc' : 'asc',
                                        ])) }}">
                                        Appointment Date
                                    </a>
                                </th>
                                
                                <th scope="col" class="px-6 py-3">
                                    Health Problem
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ route('appointments.index', array_merge(request()->input(), [
                                        'sortField' => 'current_status',
                                        'sortDirection' => $sortField === 'current_status' && $sortDirection === 'asc' ? 'desc' : 'asc',
                                        ])) }}">
                                        Current Status
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ route('appointments.index', array_merge(request()->input(), [
                                        'sortField' => 'created_at',
                                        'sortDirection' => $sortField === 'created_at' && $sortDirection === 'asc' ? 'desc' : 'asc',
                                        ])) }}">
                                        Created date
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ route('appointments.index', array_merge(request()->input(), [
                                        'sortField' => 'assigned_to',
                                        'sortDirection' => $sortField === 'assigned_to' && $sortDirection === 'asc' ? 'desc' : 'asc',
                                        ])) }}">
                                        Assigned To
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ route('appointments.index', array_merge(request()->input(), [
                                        'sortField' => 'created_by',
                                        'sortDirection' => $sortField === 'created_by' && $sortDirection === 'asc' ? 'desc' : 'asc',
                                        ])) }}">
                                        Created By
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ route('appointments.index', array_merge(request()->input(), [
                                        'sortField' => 'last_called_datetime',
                                        'sortDirection' => $sortField === 'last_called_datetime' && $sortDirection === 'asc' ? 'desc' : 'asc',
                                        ])) }}">
                                        Last Called Date Time
                                    </a>
                                </th>
                                
                                @can('manage patients')
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($appointments as $index => $appointment)
                            <?php
                            $healthProblems = [];
                            foreach ($appointment->healthProblems as $healthProblem) {
                                $healthProblems[] = $healthProblem->health_problem;
                            }
                            $appointment->health_problem = implode(", ", $healthProblems);
                            ?>

                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    <a class="text-blue-500" href="{{ route('patient.history', ['id' => $appointment->patient->id]) }}">
                                        {{ $appointment->patient_code }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $appointment->patient->name }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $appointment->appointment_type }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ date('d-M-y H:i', strtotime($appointment->appointment_time)) }}
                                </td>
                               
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    @if(strlen($appointment->health_problem) > 10)
                                    <span id="health_problem_{{ $appointment->id }}_short">{{ substr($appointment->health_problem, 0, 5) }}...</span>
                                    <span id="health_problem_{{ $appointment->id }}" class="hidden">{{ $appointment->health_problem }}</span>
                                    <a href="#" class="text-blue-500 ml-1" onclick="showFullContent(event, this, 'health_problem_{{ $appointment->id }}')">more</a>
                                    @else
                                    <span>{{ $appointment->health_problem }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $appointment->current_status }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ date('d-M-y H:i', strtotime($appointment->created_at)) }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $appointment->assigned->name }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $appointment->creator->name }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $appointment->last_called_datetime }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex space-x-1">
                                        @can('manage patients')
                                        <a class="inline-flex px-1 py-1 text-blue-500" href="{{ route('appointments.edit', $appointment) }}" title="Edit">
                                            <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" />
                                                <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                                <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                                                <line x1="16" y1="5" x2="19" y2="8" />
                                            </svg>
                                        </a>
                                        @endcan
                                        
                                        @if (auth()->user()->hasRole('Administrator') || $appointment->patient->created_by === auth()->user()->id || $appointment->assigned_to === auth()->user()->id)
                                        <a class="inline-flex px-1 py-1 text-blue-500" href="sms:" title="SMS" target="_blank" onclick="openMessage('sms','{{ $appointment->patient->phone_number }}');">
                                            <svg class="h-5 w-5 text-blue-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" />
                                                <path d="M4 21v-13a3 3 0 0 1 3 -3h10a3 3 0 0 1 3 3v6a3 3 0 0 1 -3 3h-9l-4 4" />
                                                <line x1="8" y1="9" x2="16" y2="9" />
                                                <line x1="8" y1="13" x2="14" y2="13" />
                                            </svg>
                                        </a>
                                        <a class="inline-flex px-1 py-1 text-blue-500" href="https://wa.me/" title="What's App" target="_blank" onclick="openMessage('wa','{{ $appointment->patient->phone_number }}');">
                                            <svg class="h-5 w-5 text-green-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                                            </svg>
                                        </a>
                                        <a class="inline-flex px-1 py-1 text-blue-500" href="#" target="_blank" title="Call" onclick="openMessage('call','{{ $appointment->patient->phone_number }}'); return false;">
                                            <svg class="h-5 w-5 text-indigo-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" />
                                                <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                            </svg>
                                        </a>

                                        @endif
                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="2" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ __('No Appointment found') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Pagination links -->
                    <div class="m-4">
                        {{ $appointments->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showFullContent(event, element, elementId) {
            event.preventDefault();
            element.innerText = (element.innerText == 'more') ? 'less' : 'more';
            const contentElement = document.getElementById(elementId);
            contentElement.classList.toggle('hidden');
            const contentElementShort = document.getElementById(elementId + '_short');
            contentElementShort.classList.toggle('hidden');
        }

        function openMessage(actionType, contact) {
            let linkUrl = '';

            if (actionType === 'wa') {
                linkUrl = 'https://wa.me/' + contact;
            } else if (actionType === 'sms') {
                linkUrl = 'sms:' + contact;
            } else if (actionType === 'call') {
                linkUrl = 'tel:' + contact;
            }

            if (linkUrl) {
                window.open(linkUrl, '_blank');
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".datepicker", {
                dateFormat: "Y-m-d", // Customize the date format
                placeholder: "YYYY-MM-DD", // Customize the placeholder
            });
        });
    </script>
    <script>
        function updateSearchFields() {
            const searchContainer = document.getElementById('searchContainer');
            if (searchContainer.style.display == 'block') {
                searchContainer.style.display = 'none';
            } else {
                searchContainer.style.display = 'block';
            }
        }

        // Call the function when the search filter changes
        const searchFilter = document.getElementById('advanceSearchBtn');
        searchFilter.addEventListener('click', updateSearchFields);
    </script>
    <style>
        .w-custom {
            width: 32% !important;
        }
    </style>

</x-app-layout>
