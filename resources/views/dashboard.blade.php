<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-gray-800 text-3xl font-bold mb-6">Welcome to your Techclinic Lead Tracker!!</h2>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center">
                            <span class="text-gray-700 text-lg font-semibold mb-2">Total Active Leads</span>
                            <p class="text-blue-600 text-3xl font-bold">{{$activeLeads}}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center">
                            <span class="text-gray-700 text-lg font-semibold mb-2">Converted Leads</span>
                            <p class="text-green-600 text-3xl font-bold">{{$convertedLeads}}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center">
                            <span class="text-gray-700 text-lg font-semibold mb-2">Not Converted Leads</span>
                            <p class="text-red-600 text-3xl font-bold">{{$nonConvertedLeads}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>