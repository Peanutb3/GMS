<div class="flex flex-col h-full">
    <nav class="flex flex-col gap-0 flex-1">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.dashboard') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-6 h-6 flex-shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="sidebar-text text-small">Dashboard</span>
        </a>

        <!-- Grievances -->
        <a href="{{ route('admin.grievances') }}"
            class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.grievances*') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-6 h-6 flex-shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="sidebar-text text-small">Grievances</span>
        </a>

        <!-- Requests -->
        <details class="group">
            <summary class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.requests*') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full list-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-6 h-6 flex-shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <span class="sidebar-text text-small flex-1">Requests</span>
                <svg class="sidebar-text w-4 h-4 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </summary>
            <div class="sidebar-text bg-red-50 bg-opacity-10">
                <a href="{{ route('admin.requests.good-moral') }}" class="flex items-center py-3 pl-[60px] pr-6 text-sm {{ request()->routeIs('admin.requests.good-moral') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors">
                    Good Moral Requests
                </a>
                <a href="{{ route('admin.requests.safe-loan') }}" class="flex items-center py-3 pl-[60px] pr-6 text-sm {{ request()->routeIs('admin.requests.safe-loan') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors">
                    Safe Loan Requests
                </a>
            </div>
        </details>

        <!-- Manage Users -->
        <details class="group">
            <summary class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.manage*') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full list-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-6 h-6 flex-shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="sidebar-text text-small flex-1">Manage Users</span>
                <svg class="sidebar-text w-4 h-4 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </summary>
            <div class="sidebar-text bg-red-50 bg-opacity-10">
                <a href="{{ route('admin.user-approvals') }}" class="flex items-center py-3 pl-[60px] pr-6 text-sm {{ request()->routeIs('admin.user-approvals') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors">
                    Pending Approvals
                </a>
                <a href="{{ route('admin.manage-students') }}" class="flex items-center py-3 pl-[60px] pr-6 text-sm {{ request()->routeIs('admin.manage-students') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors">
                    Students
                </a>
                <a href="{{ route('admin.manage-staff') }}" class="flex items-center py-3 pl-[60px] pr-6 text-sm {{ request()->routeIs('admin.manage-staff') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors">
                    Staff
                </a>
                <a href="{{ route('admin.manage-admins') }}" class="flex items-center py-3 pl-[60px] pr-6 text-sm {{ request()->routeIs('admin.manage-admins') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors">
                    Admins
                </a>
            </div>
        </details>

        <!-- Colleges & Programs -->
        <a href="{{ route('admin.colleges-programs') }}"
            class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.colleges-programs') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-6 h-6 flex-shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
            </svg>
            <span class="sidebar-text text-small">Colleges & Programs</span>
        </a>

        <!-- Audit Logs -->
        <a href="{{ route('admin.audit-logs') }}"
            class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.audit-logs') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-6 h-6 flex-shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            <span class="sidebar-text text-small">Audit Logs</span>
        </a>

        <!-- System Settings -->
        {{-- <a href="{{ route('admin.settings') }}"
        class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.settings') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-6 h-6 flex-shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="sidebar-text text-small">Settings</span>
        </a> --}}

        <!-- Profile -->
        <a href="{{ route('admin.profile') }}"
            class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.profile') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-6 h-6 flex-shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="sidebar-text text-small">Profile</span>
        </a>
    </nav>

    <!-- Logout Button -->
    <form method="POST" action="{{ route('logout') }}" class="mt-auto border-t border-red-200">
        @csrf
        <button type="submit" class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer text-red-900 hover:bg-red-800 hover:text-white transition-colors rounded-r-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-6 h-6 flex-shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span class="sidebar-text text-base">Log out</span>
        </button>
    </form>
</div>