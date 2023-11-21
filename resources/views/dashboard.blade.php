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
                        <div
                            class="text-xl font-semibold text-blue-600">{{$userDetails->name ?? 'No user data found'}}</div>
                        <div class="text-gray-600">Total Leads: {{$totalAppointmentsUser}}</div>
                        <div class="text-gray-600">Appointments: {{$maxVisitedUser}}</div>
                        <div class="text-gray-600">Conversion Rate: {{$visitedRatioUser}}%</div>
                    </div>
                </div>
                @if (auth()->user()->hasRole('Administrator') || auth()->user()->hasRole('Manager'))
                    <div class="m-4 flex">
                        <form method="GET">
                            <label for="user">Select User:</label>
                            <select id="user" name="user" onchange="loadDashboard()">
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>

                        </form>
                    </div>
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

    <script>
        function loadDashboard() {
            var userId = document.getElementById('user').value;
            if (userId) {
                window.location.href = '/dashboard/' + userId;
            } else {
                window.location.href = '/dashboard'; // Update with your default URL
            }
        }

    </script>


</x-app-layout>
