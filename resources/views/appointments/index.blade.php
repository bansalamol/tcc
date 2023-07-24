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


                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Patient Code
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Patient Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Appointment Type
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Appointment Date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Health Problem
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Current Status
                                </th>
                                @can('manage patients')
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($appointments as $appointment)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    TC-2023-100010
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    Amol
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    Fix Appointment.
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    2023-07-1 1:30PM
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                    Knee
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                   Active
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>