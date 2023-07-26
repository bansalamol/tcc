<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg px-4 py-4">
                    <x-validation-errors class="mb-4" />
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <!-- Two-Column Layout -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- First Column -->
                            <div class="col-span-1">

                                <div class="mt-4">
                                    <x-label for="name" value="{{ __('Name') }}" />
                                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                </div>

                                <div class="mt-4">
                                    <x-label for="email" value="{{ __('Email') }}" />
                                    <x-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required autofocus autocomplete="email" />
                                </div>

                                <div class="mt-4">
                                    <x-label for="password" value="{{ __('Password') }}" />
                                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                                </div>

                                <div class="mt-4">
                                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                                </div>

                            </div>

                            <!-- Second Column -->
                            <div class="col-span-1">

                                <div class="mt-4">
                                    <label for="role">Select Role</label>
                                    <select name="role" id="role" class="mt-1 block w-full border-gray-300 rounded-md">
                                        <option value="">Select a Role</option>
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
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
                                        <p class="text-gray-600">This role can manage patients and appointments. It can create and update appointments for other users, and also create, update, and delete its own appointments.</p>
                                    </div>

                                    <div class="mb-4">
                                        <h2 class="text-xl font-semibold mb-2">Presales</h2>
                                        <p class="text-gray-600">This role can manage patients and appointments. It can create and update appointments for other users, and also create, update, and delete its own appointments.</p>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="flex mt-4">
                            <x-button>
                                {{ __('Save user') }}
                            </x-button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>