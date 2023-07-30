<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patients') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                    @can('manage patients')
                    <div class="float-right">
                        <x-link href="{{ route('patients.create') }}" class="m-4">Add new Patient</x-link>
                    </div>
                    @endcan
                    <div class="m-4 flex">
                        <form action="{{ route('patient.search') }}" method="GET">
                                <input type="search" id="q" name="q"  placeholder="Search by name, code, or phone number" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600" >Search</button>
                        </form>
                    </div>

                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
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
                        <tbody>
                            @forelse ($patients as $index => $patient)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
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

                                    @if (auth()->user()->hasRole('Manager') && $patient->created_by !== auth()->user()->id)
                                    +91******
                                    @else
                                    {{ $patient->phone_number }}
                                    @endif

                                </td>

                                @can('manage patients')
                                <td class="px-6 py-4">
                                    <x-link href="{{ route('patients.history', $patient) }}">History</x-link>

                                    @if (auth()->user()->hasRole('Administrator') || $patient->created_by === auth()->user()->id)
                                    <x-link href="{{ route('patients.edit', $patient) }}">Edit</x-link>
                                    <form method="POST" action="{{ route('patients.destroy', $patient) }}" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button type="submit" onclick="return confirm('Are you sure?')">Delete</x-danger-button>
                                    </form>
                                    @endif
                                </td>
                                @endcan
                            </tr>
                            @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="2" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ __('No patients found') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Pagination links -->
                    <div class="m-4">
                        {{ $patients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>