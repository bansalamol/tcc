<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto  sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-white rounded-lg shadow-md p-4 ">
                    <div class="text-lg font-semibold text-gray-800">Performer of the Week</div>
                    <div class="mt-4">
                        <div class="text-xl font-semibold text-blue-600">{{$userDetails->name ?? 'No user data found'}}</div>
                        <div class="text-gray-600">Total Leads: {{$totalAppointmentsUser}}</div>
                        <div class="text-gray-600">Appointments: {{$maxVisitedUser}}</div>
                        <div class="text-gray-600">Conversion Rate: {{$visitedRatioUser}}%</div>
                    </div>
                    <div class="bg-white p-8 rounded shadow-md w-full sm:w-96">

                    <h2 class="text-2xl font-semibold mb-6">User Search</h2>

                    <form action="#" method="get">

                        <!-- User Select Dropdown -->
                        <div class="mb-4">
                            <label for="user" class="block text-gray-600 text-sm font-medium mb-2">Select User</label>
                            <select id="user" name="user" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                                <option value="">Select User</option>
                                <!-- Replace the options dynamically with your users -->
                                <option value="1">User 1</option>
                                <option value="2">User 2</option>
                                <option value="3">User 3</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
                            Load Dashboard
                        </button>

                    </form>

                </div>

            </div>


                @if (!is_null($searchTerm))
                    <p>Search results for: <strong>{{ $searchTerm }}</strong></p>
                @endif


                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="text-lg font-semibold text-blue-600">Today</div>
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center">
                            <span class="text-gray-700 text-lg font-semibold mb-2">Leads/Calls</span>
                            <p class="text-blue-600 text-3xl font-bold">{{$leadsCallsToday}}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center">
                            <span class="text-gray-700 text-lg font-semibold mb-2">Enquiry</span>
                            <p class="text-green-600 text-3xl font-bold">{{$enquiryToday}}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center">
                            <span class="text-gray-700 text-lg font-semibold mb-2">Appointments</span>
                            <p class="text-red-600 text-3xl font-bold">{{$appointmentsToday}}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center">
                            <span class="text-gray-700 text-lg font-semibold mb-2">Visited Ratio</span>
                            <p class="text-purple-600 text-3xl font-bold">{{$visitedRatioToday}}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="text-lg font-semibold text-blue-600">3 days</div>
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center">
                        <span class="text-gray-700 text-lg font-semibold mb-2">Leads/Calls</span>
                        <p class="text-blue-600 text-3xl font-bold">{{$leadsCalls3Days}}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center">
                        <span class="text-gray-700 text-lg font-semibold mb-2">Enquiry</span>
                        <p class="text-green-600 text-3xl font-bold">{{$enquiry3Days}}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center">
                        <span class="text-gray-700 text-lg font-semibold mb-2">Appointments</span>
                        <p class="text-red-600 text-3xl font-bold">{{$appointments3Days}}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center">
                        <span class="text-gray-700 text-lg font-semibold mb-2">Visited Ratio</span>
                        <p class="text-purple-600 text-3xl font-bold">{{$visitedRatio3Days}}</p>
                    </div>
                </div>
            </div>

                <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="text-lg font-semibold text-blue-600">7 days</div>
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center">
                        <span class="text-gray-700 text-lg font-semibold mb-2">Leads/Calls</span>
                        <p class="text-blue-600 text-3xl font-bold">{{$leadsCalls7Days}}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center">
                        <span class="text-gray-700 text-lg font-semibold mb-2">Enquiry</span>
                        <p class="text-green-600 text-3xl font-bold">{{$enquiry7Days}}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center">
                        <span class="text-gray-700 text-lg font-semibold mb-2">Appointments</span>
                        <p class="text-red-600 text-3xl font-bold">{{$appointments7Days}}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center">
                        <span class="text-gray-700 text-lg font-semibold mb-2">Visited Ratio</span>
                        <p class="text-purple-600 text-3xl font-bold">{{$visitedRatio7Days}}</p>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>




</x-app-layout>
