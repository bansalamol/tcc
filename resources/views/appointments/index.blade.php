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

                                    <a class="inline-flex px-4 py-2 text-blue-500" href="sms:" target="_blank" onclick="openMessage(event);">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" style="color: #9146ff" viewBox="0 0 24 24">
                                            <path d="M2.149 0l-1.612 4.119v16.836h5.731v3.045h3.224l3.045-3.045h4.657l6.269-6.269v-14.686h-21.314zm19.164 13.612l-3.582 3.582h-5.731l-3.045 3.045v-3.045h-4.836v-15.045h17.194v11.463zm-3.582-7.343v6.262h-2.149v-6.262h2.149zm-5.731 0v6.262h-2.149v-6.262h2.149z" fill-rule="evenodd" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <a class="inline-flex px-4 py-2 text-blue-500" href="https://wa.me/" target="_blank" onclick="openMessage(event);">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" style="color: #128c7e" viewBox="0 0 24 24">
                                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                        </svg>
                                    </a>

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

        function openMessage(mobile) {
            event.preventDefault();
            const linkUrl = event.target.getAttribute('href') + mobile;
            window.open(linkUrl, '_blank');
        }
    </script>
</x-app-layout>