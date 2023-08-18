<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg px-4 py-4">
                    <x-validation-errors class="mb-4" />
                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        <!-- Two-Column Layout -->
                        <div class="grid grid-cols-1 gap-4">
                            <!-- First Column -->
                            <div class="col-span-1">

                                <div class="mt-4">
                                    <x-label for="name" value="{{ __('Name') }}" />
                                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$user->name" required autofocus autocomplete="name" />
                                </div>

                                <div class="mt-4">
                                    <x-label for="email" value="{{ __('Email') }}" />
                                    <x-input id="email" class="block mt-1 w-full" type="text" name="email" :value="$user->email" required autofocus autocomplete="email" />
                                </div>
                                <div class="mt-4">
                                    <x-label for="password" value="{{ __('Password') }}" />
                                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
                                </div>

                                <div class="mt-4">
                                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password" />
                                </div>
                                <div class="mt-4">
                                    <x-label for="phone_number" value="{{ __('Phone Number') }}" />
                                    <x-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="$user->phone_number" required autocomplete="phone_number" />
                                </div>
                                <div class="mt-4">
                                    <x-label for="daily_lead_limit" value="{{ __('Daily Lead Limit') }}" />
                                    <x-input id="daily_lead_limit" class="block mt-1 w-full" type="text" name="daily_lead_limit" :value="$user->daily_lead_limit" required autocomplete="daily_lead_limit" />
                                </div>

                                <div class="mt-4">
                                    <x-select-field name="type" :options="config('variables.leadType')" selected="{{$user->type}}">
                                        Select {{ __('Lead Type') }}
                                    </x-select-field>
                                </div>

                                <div class="mt-4">
                                    <x-label for="manager_id" value="{{ __('Manager') }}" />
                                    <select id="manager_id" name="manager_id" class="mt-1 block w-full border-gray-300 rounded-md" >
                                        <option value="">Select Manager</option>
                                        @foreach ($managers as $manager)
                                        <option value="{{ $manager->id }}" @if($user->manager_id == $manager->id) selected @endif > {{ $manager->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mt-4">
                                    <x-label for="comment" value="{{__('Comment')}}" />
                                    <x-input id="comment" class="block mt-1 w-full" type="text" name="comment" :value="$user->comment" required placeholder="Enter Comments" />
                                </div>

                            </div>

                            <!-- Second Column -->
                            <div class="col-span-1">
                                <div class="mt-4">
                                    <label for="role">Select Role</label>
                                    <select name="role" id="role" class="mt-1 block w-full border-gray-300 rounded-md">
                                        <option value="">Select a Role</option>
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" @if ($user->hasRole($role->name)) selected @endif>{{ $role->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="container mx-auto p-4">
                                    <h1 class="text-2xl font-bold mb-4">Role Details</h1>

                                    <div class="mb-4">
                                        <h2 class="text-xl font-semibold mb-2">Administrator</h2>
                                        <p class="text-gray-600">This role has full access to all functionalities.</p>
                                    </div>

                                    <div class="mb-4">
                                        <h2 class="text-xl font-semibold mb-2">Manager</h2>
                                        <p class="text-gray-600">This role has the ability to create both patients and appointments. Additionally, they can access and assign appointments to presales, as well as create and update their own appointments.</p>
                                    </div>

                                    <div class="mb-4">
                                        <h2 class="text-xl font-semibold mb-2">Presales</h2>
                                        <p class="text-gray-600">This role has the ability to create patient records and book appointments. Additionally, they modify their own appointment only.</p>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="flex mt-4">
                            <x-button>
                                {{ __('Update user') }}
                            </x-button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
