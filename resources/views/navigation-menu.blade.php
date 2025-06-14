<nav x-data="{ open: false }">
    <!-- Mobile Navigation -->
    <div class="bg-white border-b border-gray-200 shadow md:hidden">
        <div class="flex justify-between h-16 px-4">
            <a href="{{ route('dashboard') }}" class="flex items-center">
                <x-application-mark class="block h-9 w-auto" />
            </a>
            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div x-show="open" class="pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('appointments.index') }}" :active="request()->routeIs('appointments.*')">
                {{ __('Appointments') }}
            </x-responsive-nav-link>
            @role('Administrator')
            <x-responsive-nav-link href="{{ route('patients.index') }}" :active="request()->routeIs('patients.*')">
                {{ __('Patients') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.*')">
                {{ __('Users') }}
            </x-responsive-nav-link>
            @endrole
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>

    <!-- Desktop Sidebar -->
    <div class="hidden md:fixed md:inset-y-0 md:flex md:flex-col md:w-64 md:h-screen md:border-r md:border-gray-200 md:bg-white">
        <div class="h-16 flex items-center justify-center space-x-2 border-b">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                <x-application-logo class="block h-10 w-auto" />
                <span class="text-lg font-semibold">{{ config('app.name', 'TCC') }}</span>
            </a>
        </div>
        <div class="flex-1 overflow-y-auto px-4 py-6 space-y-1">
            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2.25L3 9.75V21a.75.75 0 00.75.75H9v-6h6v6h5.25A.75.75 0 0021 21V9.75L12 2.25z" fill="currentColor"/>
                </svg>
                <span>Dashboard</span>
            </x-nav-link>
            <x-nav-link href="{{ route('appointments.index') }}" :active="request()->routeIs('appointments.*')">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3a.75.75 0 011.5 0V4.5h.75A2.25 2.25 0 0121 6.75v11.25A2.25 2.25 0 0118.75 20.25H5.25A2.25 2.25 0 013 18V6.75A2.25 2.25 0 015.25 4.5H6V3a.75.75 0 01.75-.75zM20.25 9.75H3.75v8.25c0 .621.504 1.125 1.125 1.125h15.75c.621 0 1.125-.504 1.125-1.125V9.75z" fill="currentColor"/>
                </svg>
                <span>Appointments</span>
            </x-nav-link>
            @role('Administrator')
            <x-nav-link href="{{ route('patients.index') }}" :active="request()->routeIs('patients.*')">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 12c2.485 0 4.5-2.015 4.5-4.5S14.485 3 12 3 7.5 5.015 7.5 7.5 9.515 12 12 12zM3 21a9 9 0 0118 0H3z" fill="currentColor"/>
                </svg>
                <span>Patients</span>
            </x-nav-link>
            <x-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.*')">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 12a3 3 0 10-6 0 3 3 0 006 0zM6 21v-2.25A2.25 2.25 0 018.25 16.5h7.5A2.25 2.25 0 0118 18.75V21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Users</span>
            </x-nav-link>
            @endrole
        </div>
        <div class="mt-auto border-t">
            <div class="px-4 py-4 flex items-center">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <img class="h-8 w-8 rounded-full object-cover mr-3" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                @endif
                <div>
                    <div class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <a href="{{ route('profile.show') }}" class="text-xs text-blue-600 hover:underline">Profile</a>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="px-4 pb-4" x-data>
                @csrf
                <x-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.75 9V5.25A2.25 2.25 0 0013.5 3H5.25A2.25 2.25 0 003 5.25v13.5A2.25 2.25 0 005.25 21H13.5a2.25 2.25 0 002.25-2.25V15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18 12H9m0 0l3-3m-3 3l3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>{{ __('Log Out') }}</span>
                </x-nav-link>
            </form>
        </div>
    </div>
</nav>
