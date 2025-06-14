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
                        <form action="{{ route('appointments.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700 ml-2">Patient Name</label>
                                <input type="text" id="pname" name="pname" value="{{ $name }}" class="mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Enter Patient Name">
                            </div>
                            <div>
                                <label for="mobile" class="block font-medium text-sm text-gray-700 ml-2">Mobile</label>
                                <input type="text" id="mobile" name="mobile" value="{{ $mobile }}" class="mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Enter Mobile">
                            </div>
                            <div>
                                <label for="clinic" class="block font-medium text-sm text-gray-700 ml-2">Clinic</label>
                                <select name="clinic" id="clinic" class="mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select an option</option>
                                    @foreach(config('variables.clinicList') as $value => $label)
                                        <option value="{{ $value }}" {{ $value == $clinic ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="appointment_type" class="block font-medium text-sm text-gray-700 ml-2">Appointment Type</label>
                                <select name="appointment_type" id="appointment_type" class="mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select an option</option>
                                    @foreach(config('variables.appointmentTypes') as $value => $label)
                                    <option value="{{ $value }}" {{ $value == $appointmentType ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div>
                                <label for="status"  class="block font-medium text-sm text-gray-700 ml-2">Current Status</label>
                                <select name="status" id="status" class="mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select an option</option>
                                    @foreach(config('variables.appointmentStatus') as $value => $label)
                                    <option value="{{ $value }}" {{ $value == $currentStatus ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="status"  class="block font-medium text-sm text-gray-700 ml-2">Assigned To</label>
                                <select id="assigned_to" name="assigned_to" class="mt-1 w-full border-gray-300 rounded-md">
                                        <option value="">Select an option</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}"  @if($user->id == $assignedTo) selected @endif >{{ $user->name  }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="status"  class="block font-medium text-sm text-gray-700 ml-2">Created By</label>
                                <select id="created_by" name="created_by" class="mt-1 w-full border-gray-300 rounded-md">
                                        <option value="">Select an option</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}"  @if($user->id == $createdBy) selected @endif >{{ $user->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="cstart_date" class="block font-medium text-sm text-gray-700 ml-2">Visited Date</label>
                                <input type="text" id="v_date" name="v_date" class="mt-1 w-full datepicker rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" value="{{ $vDate }}" placeholder="Select visited Date">
                            </div>
                            <div>
                                <label for="cstart_date" class="block font-medium text-sm text-gray-700 ml-2">Created Date</label>
                                <input type="text" id="cstart_date" name="cstart_date" class="mt-1 w-full datepicker rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" value="{{ $cstartDate }}" placeholder="Select Start Date">
                                <input type="text" id="cend_date" name="cend_date" class="mt-1 w-full datepicker rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" value="{{ $cendDate }}" placeholder="Select End Date">
                            </div>
                            <div>
                                <label for="astart_date" class="block font-medium text-sm text-gray-700 ml-2">Appointment Date</label>
                                <input type="text" id="astart_date" name="astart_date" class="mt-1 w-full datepicker rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" value="{{ $astartDate }}" placeholder="Select Start Date">
                                <input type="text" id="aend_date" name="aend_date" class="mt-1 w-full datepicker rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" value="{{ $aendDate }}" placeholder="Select End Date">
                            </div>
                            <div class="md:col-span-3 flex items-center space-x-2 mt-4">
                                <button type="submit" class="px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-md">Search</button>
                                <a href="{{ route('appointments.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Reset</a>
                            </div>
                        </form>
                    </div>

                    <table class="mt-4 w-full text-sm text-left text-gray-700 bg-white shadow rounded-lg">
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
                                    <a href="{{ route('appointments.index', array_merge(request()->input(), [
                                        'sortField' => 'visited_date',
                                        'sortDirection' => $sortField === 'visited_date' && $sortDirection === 'asc' ? 'desc' : 'asc',
                                        ])) }}">
                                        Visited Date
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Clinic
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
                                        Last Action
                                    </a>
                                </th>

                                @can('manage patients')
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($appointments as $index => $appointment)
                            <?php
                            $healthProblems = [];
                            foreach ($appointment->healthProblems as $healthProblem) {
                                $healthProblems[] = $healthProblem->health_problem;
                            }
                            $appointment->health_problem = implode(", ", $healthProblems);
                            ?>

                            <tr class="bg-white hover:bg-gray-50">
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
                                    {{  $appointment->visited_date ? date('d-M-y H:i', strtotime($appointment->visited_date))  : '--'}}
                                </td>

                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $appointment->clinic }}
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
                                    @if(empty($appointment->assigned->name))
                                        unknown
                                    @else
                                        {{ $appointment->assigned->name }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    @if(empty($appointment->creator->name))
                                        unknown
                                    @else
                                        {{ $appointment->creator->name }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    C:<span id="call_{{$appointment->id}}" >{{ $appointment->last_called_datetime ?? ' -- ' }} </span><br>
                                    M:<span id="sms_{{$appointment->id}}">{{ $appointment->last_messaged_datetime ?? ' -- ' }} </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex space-x-1">
                                        @can('manage patients')
                                        <a class="inline-flex px-1 py-1 text-blue-500" href="{{ route('appointments.edit', $appointment) }}" title="Edit">
                                            <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M21.7312 2.26884C20.706 1.24372 19.044 1.24372 18.0188 2.26884L16.8617 3.42599L20.574 7.1383L21.7312 5.98116C22.7563 4.95603 22.7563 3.29397 21.7312 2.26884Z" fill="currentColor"/>
                                                <path d="M19.5133 8.19896L15.801 4.48665L7.40019 12.8875C6.78341 13.5043 6.33002 14.265 6.081 15.101L5.28122 17.7859C5.2026 18.0498 5.27494 18.3356 5.46967 18.5303C5.6644 18.725 5.95019 18.7974 6.21412 18.7188L8.89901 17.919C9.73498 17.67 10.4957 17.2166 11.1125 16.5998L19.5133 8.19896Z" fill="currentColor"/>
                                                <path d="M5.25 5.25C3.59315 5.25 2.25 6.59315 2.25 8.25V18.75C2.25 20.4069 3.59315 21.75 5.25 21.75H15.75C17.4069 21.75 18.75 20.4069 18.75 18.75V13.5C18.75 13.0858 18.4142 12.75 18 12.75C17.5858 12.75 17.25 13.0858 17.25 13.5V18.75C17.25 19.5784 16.5784 20.25 15.75 20.25H5.25C4.42157 20.25 3.75 19.5784 3.75 18.75V8.25C3.75 7.42157 4.42157 6.75 5.25 6.75H10.5C10.9142 6.75 11.25 6.41421 11.25 6C11.25 5.58579 10.9142 5.25 10.5 5.25H5.25Z" fill="currentColor"/>
                                            </svg>
                                        </a>
                                        @endcan

                                        @if (auth()->user()->hasRole('Administrator') || $appointment->patient->created_by === auth()->user()->id || $appointment->assigned_to === auth()->user()->id)
                                        <a class="inline-flex px-1 py-1 text-blue-500" href="sms:" title="SMS" target="_blank" onclick="openMessage('sms','{{ $appointment->patient->phone_number }}','{{ $appointment->id }}');  return false;">
                                            <svg class="h-5 w-5 text-blue-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.5 8.6691V17.25C1.5 18.9069 2.84315 20.25 4.5 20.25H19.5C21.1569 20.25 22.5 18.9069 22.5 17.25V8.6691L13.5723 14.1631C12.6081 14.7564 11.3919 14.7564 10.4277 14.1631L1.5 8.6691Z" fill="currentColor"/>
                                                <path d="M22.5 6.90783V6.75C22.5 5.09315 21.1569 3.75 19.5 3.75H4.5C2.84315 3.75 1.5 5.09315 1.5 6.75V6.90783L11.2139 12.8856C11.696 13.1823 12.304 13.1823 12.7861 12.8856L22.5 6.90783Z" fill="currentColor"/>
                                            </svg>
                                        </a>
                                        <a class="inline-flex px-1 py-1 text-blue-500" href="https://wa.me/" title="What's App" target="_blank" onclick="openMessage('wa','{{ $appointment->patient->phone_number }}','{{ $appointment->id }}');  return false;">
                                            <svg class="h-5 w-5 text-green-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4.91307 2.65823C6.9877 2.38888 9.10296 2.25 11.2503 2.25C13.3974 2.25 15.5124 2.38885 17.5869 2.65815C19.5091 2.90769 20.8783 4.51937 20.9923 6.38495C20.6665 6.27614 20.3212 6.20396 19.96 6.17399C18.5715 6.05874 17.1673 6 15.75 6C14.3326 6 12.9285 6.05874 11.54 6.17398C9.1817 6.36971 7.5 8.36467 7.5 10.6082V14.8937C7.5 16.5844 8.45468 18.1326 9.9328 18.8779L7.28033 21.5303C7.06583 21.7448 6.74324 21.809 6.46299 21.6929C6.18273 21.5768 6 21.3033 6 21V16.9705C5.63649 16.9316 5.27417 16.8887 4.91308 16.8418C2.90466 16.581 1.5 14.8333 1.5 12.8626V6.63738C1.5 4.66672 2.90466 2.91899 4.91307 2.65823Z" fill="currentColor"/>
                                                <path d="M15.75 7.5C14.3741 7.5 13.0114 7.55702 11.6641 7.66884C10.1248 7.7966 9 9.10282 9 10.6082V14.8937C9 16.4014 10.128 17.7083 11.6692 17.8341C12.9131 17.9357 14.17 17.9912 15.4384 17.999L18.2197 20.7803C18.4342 20.9948 18.7568 21.0592 19.037 20.9429C19.3173 20.8268 19.5 20.5533 19.5 20.25V17.8601C19.6103 17.8518 19.7206 17.8432 19.8307 17.8342C21.372 17.7085 22.5 16.4015 22.5 14.8938V10.6082C22.5 9.10283 21.3752 7.79661 19.836 7.66885C18.4886 7.55702 17.1259 7.5 15.75 7.5Z" fill="currentColor"/>
                                            </svg>
                                        </a>
                                        <a class="inline-flex px-1 py-1 text-blue-500" href="#" target="_blank" title="Call" onclick="openMessage('call','{{ $appointment->patient->phone_number }}','{{ $appointment->id }}'); return false;">
                                            <svg class="h-5 w-5 text-indigo-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M15 3.75C15 3.33579 15.3358 3 15.75 3H20.25C20.6642 3 21 3.33579 21 3.75V8.25C21 8.66421 20.6642 9 20.25 9C19.8358 9 19.5 8.66421 19.5 8.25V5.56066L14.7803 10.2803C14.4874 10.5732 14.0126 10.5732 13.7197 10.2803C13.4268 9.98744 13.4268 9.51256 13.7197 9.21967L18.4393 4.5H15.75C15.3358 4.5 15 4.16421 15 3.75Z" fill="currentColor"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.5 4.5C1.5 2.84315 2.84315 1.5 4.5 1.5H5.87163C6.732 1.5 7.48197 2.08556 7.69064 2.92025L8.79644 7.34343C8.97941 8.0753 8.70594 8.84555 8.10242 9.29818L6.8088 10.2684C6.67447 10.3691 6.64527 10.5167 6.683 10.6197C7.81851 13.7195 10.2805 16.1815 13.3803 17.317C13.4833 17.3547 13.6309 17.3255 13.7316 17.1912L14.7018 15.8976C15.1545 15.2941 15.9247 15.0206 16.6566 15.2036L21.0798 16.3094C21.9144 16.518 22.5 17.268 22.5 18.1284V19.5C22.5 21.1569 21.1569 22.5 19.5 22.5H17.25C8.55151 22.5 1.5 15.4485 1.5 6.75V4.5Z" fill="currentColor"/>
                                            </svg>
                                        </a>

                                        @endif
                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr class="bg-white hover:bg-gray-50">
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

        function openMessage(actionType, contact, apntId) {
            let linkUrl = '';
            let actionTypeName = '';
            if (actionType === 'wa') {
                linkUrl = 'https://wa.me/' + contact;
                actionTypeName = 'sms';
            } else if (actionType === 'sms') {
                linkUrl = 'sms:' + contact;
                actionTypeName = 'sms';
            } else if (actionType === 'call') {
                linkUrl = 'tel:' + contact;
                actionTypeName = 'call';
            }

            if(apntId){
                addActivityLog(apntId,actionType);
                const element = document.getElementById(actionTypeName + '_' + apntId);
                const currentDateTime = getCurrentDateTime();
                if (element) {
                    element.textContent = '';
                    element.textContent = element.textContent + ' ' + currentDateTime;
                }
            }

            if (linkUrl) {
               window.open(linkUrl, '_blank');
            }
        }
        function getCurrentDateTime() {
            const now = new Date();
            const year = now.getFullYear();
            const month = (now.getMonth() + 1).toString().padStart(2, '0');
            const day = now.getDate().toString().padStart(2, '0');
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');

            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }


        function addActivityLog(apntId, activityType){

            const activity = {
                appointment_id: apntId,
                activity_type: activityType
            };
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Send a POST request to log the activity
            fetch('/appointments/addactivitylog', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                     accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken,

                },
                body: JSON.stringify(activity),
            })
            .then(response => {
                return response.json();
            })
            .then(data => {
            console.log('Activity log added successfully:', data.message);
            // You can also perform additional actions or handle the response as needed
        })
        .catch(error => {
            console.error('Error adding activity log:', error);
        });

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


</x-app-layout>
