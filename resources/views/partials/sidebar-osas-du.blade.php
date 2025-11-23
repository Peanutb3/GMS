<aside id="sidebar"
    class="fixed top-0 left-0 h-screen bg-white border-r border-gray-200 transition-all duration-300 ease-in-out z-40 flex flex-col"
    :class="sidebarOpen ? 'w-64' : 'w-16'">

    <!-- Logo Section -->
    <div class="h-16 flex items-center justify-center border-b border-gray-200 bg-white relative z-10">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="transition-all duration-300"
            :class="sidebarOpen ? 'h-10' : 'h-8'">
    </div>

    <!-- Navigation Links (flex-1 to push logout to bottom) -->
    <nav class="flex-1 overflow-y-auto py-4">
        <!-- Dashboard -->
        <a href="{{ route('osas-du.dashboard') }}"
            class="flex items-center px-4 py-3 text-gray-700 transition-colors duration-200 {{ request()->routeIs('osas-du.dashboard') ? 'bg-red-900 text-white border-r-4 border-red-900' : 'hover:bg-gray-100' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="ml-3 transition-all duration-300" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0'">
                Dashboard
            </span>
        </a>

        <!-- File Grievances -->
        <a href="{{ route('osas-du.file-grievances') }}"
            class="flex items-center px-4 py-3 text-gray-700 transition-colors duration-200 {{ request()->routeIs('osas-du.file-grievances') ? 'bg-red-900 text-white border-r-4 border-red-900' : 'hover:bg-gray-100' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="ml-3 transition-all duration-300" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0'">
                File Grievances
            </span>
        </a>

        <!-- Grievances -->
        <a href="{{ route('osas-du.grievances') }}"
            class="flex items-center px-4 py-3 text-gray-700 transition-colors duration-200 {{ request()->routeIs('osas-du.grievances') ? 'bg-red-900 text-white border-r-4 border-red-900' : 'hover:bg-gray-100' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span class="ml-3 transition-all duration-300" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0'">
                Grievances
            </span>
        </a>

        <!-- Requests (View Only) -->
        <a href="{{ route('osas-du.requests') }}"
            class="flex items-center px-4 py-3 text-gray-700 transition-colors duration-200 {{ request()->routeIs('osas-du.requests*') ? 'bg-red-900 text-white border-r-4 border-red-900' : 'hover:bg-gray-100' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <span class="ml-3 transition-all duration-300" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0'">
                View Requests
            </span>
        </a>

        <!-- Logs -->
        <a href="{{ route('osas-du.audit.index') }}"
            class="flex items-center px-4 py-3 text-gray-700 transition-colors duration-200 {{ request()->routeIs('osas-du.audit.*') ? 'bg-red-900 text-white border-r-4 border-red-900' : 'hover:bg-gray-100' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="ml-3 transition-all duration-300" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0'">
                Logs
            </span>
        </a>

        <!-- Profile -->
        <a href="{{ route('osas-du.profile') }}"
            class="flex items-center px-4 py-3 text-gray-700 transition-colors duration-200 {{ request()->routeIs('osas-du.profile') ? 'bg-red-900 text-white border-r-4 border-red-900' : 'hover:bg-gray-100' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="ml-3 transition-all duration-300" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0'">
                Profile
            </span>
        </a>
    </nav>

    <!-- Logout Button (at the bottom) -->
    <div class="border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center w-full px-4 py-3 text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="ml-3 transition-all duration-300" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0'">
                    Log out
                </span>
            </button>
        </form>
    </div>
</aside>
