<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6 text-blue-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 12c2.485 0 4.5-2.015 4.5-4.5S14.485 3 12 3 7.5 5.015 7.5 7.5 9.515 12 12 12zM3 21a9 9 0 0118 0H3z" fill="currentColor"/>
            </svg>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Patients') }}</h2>
        </div>
        <x-breadcrumb current="Patients" />
    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                    @can('manage patients')
                    <div class="float-right m-4 space-x-2">
                        <x-button type="button" onclick="window.location='{{ route('patients.create') }}'">Add new Patient</x-button>
                    </div>
                    @endcan
                    <div class="m-4">
                        <livewire:search-form route-name="patient.search" placeholder="Search by name, code, or phone number" />
                    </div>

                    <table class="w-full text-sm text-left text-gray-700 bg-white shadow rounded-lg">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Patient Code
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Patient Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Age
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    Phone Number
                                </th>
                                @can('manage patients')
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($patients as $index => $patient)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $patient->code }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $patient->name }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $patient->age }}
                                </td>

                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">

                                @if (auth()->user()->hasRole('Administrator') || $appointment->patient->created_by === auth()->user()->id)
                                    {{ $patient->phone_number }}
                                @else
                                    +91******
                                @endif

                                </td>

                                @can('manage patients')
                                <td class="px-6 py-4 flex">
                                    <?php /* ?><x-link href="{{ route('patients.history', $patient) }}">History</x-link><?php */ ?>

                                    @if (auth()->user()->hasRole('Administrator') || $patient->created_by === auth()->user()->id)
                                    <a href="{{ route('patients.edit', $patient) }}">
                                        <svg class="h-6 w-6 text-gray-500"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />  <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />  <line x1="16" y1="5" x2="19" y2="8" /></svg>
                                    </a>
                                    <form method="POST" action="{{ route('patients.destroy', $patient) }}" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <a type="submit" onclick="return confirm('Are you sure?')">
                                            <svg class="h-6 w-6 text-red-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />  <line x1="9" y1="9" x2="15" y2="15" />  <line x1="15" y1="9" x2="9" y2="15" /></svg>
                                        </a>
                                    </form>
                                    @endif
                                </td>
                                @endcan
                            </tr>
                            @empty
                            <tr class="bg-white hover:bg-gray-50">
                                <td colspan="2" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ __('No patients found') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Pagination links -->
                    <div class="m-4">
                        {{ $patients->appends(['q' => request()->input('q')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
