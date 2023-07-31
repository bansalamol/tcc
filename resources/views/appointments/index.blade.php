<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Appointments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                    @can('manage patients')
                    <div class="float-right">
                        <x-link href="{{ route('appointments.create') }}" class="m-4">Book Appointment</x-link>
                        <x-link href="{{ route('patients.create') }}" class="m-4">Add new Patient</x-link>
                    </div>
                    @endcan
                    <div class="m-4 flex">
                        <form action="{{ route('appointments.index') }}" method="GET">
                            <input type="search" id="q" name="q" value="{{$searchTerm}}" placeholder="Search by name, code, or phone number" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Search</button>
                        </form>
                    </div>


                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ route('appointments.index', [
                                        'sortField' => 'patient_code',
                                        'sortDirection' => $sortField === 'patient_code' && $sortDirection === 'asc' ? 'desc' : 'asc',
                                        'q' => request()->input('q'),
                                        ]) }}">
                                        Patient Code
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ route('appointments.index', [
                                        'sortField' => 'name',
                                        'sortDirection' => $sortField === 'name' && $sortDirection === 'asc' ? 'desc' : 'asc',
                                        'q' => request()->input('q'),
                                        ]) }}">
                                        Patient Name
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ route('appointments.index', [
                                        'sortField' => 'appointment_type',
                                        'sortDirection' => $sortField === 'appointment_type' && $sortDirection === 'asc' ? 'desc' : 'asc',
                                        'q' => request()->input('q'),
                                        ]) }}">
                                        Appointment Type
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ route('appointments.index', [
                                        'sortField' => 'appointment_time',
                                        'sortDirection' => $sortField === 'appointment_time' && $sortDirection === 'asc' ? 'desc' : 'asc',
                                        'q' => request()->input('q'),
                                        ]) }}">
                                        Appointment Date
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Health Problem
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <a href="{{ route('appointments.index', [
                                        'sortField' => 'current_status',
                                        'sortDirection' => $sortField === 'current_status' && $sortDirection === 'asc' ? 'desc' : 'asc',
                                        'q' => request()->input('q'),
                                        ]) }}">
                                        Current Status
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
                                    <span id="health_problem_{{ $appointment->id }}_short">{{ substr($appointment->health_problem, 0, 10) }}...</span>
                                    <span id="health_problem_{{ $appointment->id }}" class="hidden">{{ $appointment->health_problem }}</span>
                                    <a href="#" class="text-blue-500 ml-1" onclick="showFullContent(event, this, 'health_problem_{{ $appointment->id }}')">more</a>
                                    @else
                                    <span>{{ $appointment->health_problem }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $appointment->current_status }}
                                </td>

                                @can('manage patients')
                                <td class="px-6 py-4">
                                    <x-link href="{{ route('appointments.edit', $appointment) }}">Edit</x-link>
                                    <form method="POST" action="{{ route('appointments.destroy', $appointment) }}" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button type="submit" onclick="return confirm('Are you sure?')">Delete</x-danger-button>
                                    </form>
                                </td>
                                @endcan
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
                        {{ $appointments->appends(['q' => request()->input('q'),'sortField' => request()->input('sortField'),'sortDirection' => request()->input('sortDirection')])->links() }}
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
    </script>
</x-app-layout>
