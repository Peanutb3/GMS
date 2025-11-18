<div class="flex flex-col h-full">
    <nav class="flex flex-col gap-0 flex-1">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.dashboard') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0">
                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
            </svg>
            <span class="sidebar-text text-small">Dashboard</span>
        </a>

        <!-- Grievances -->
        <a href="{{ route('admin.grievances') }}"
           class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.grievances*') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke="currentColor" fill="none" stroke-width="2"/>
            </svg>
            <span class="sidebar-text text-small">Grievances</span>
        </a>

        <!-- Requests -->
        <details class="group">
            <summary class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.requests*') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full list-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                </svg>
                <span class="sidebar-text text-small flex-1">Requests</span>
                <svg class="w-4 h-4 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </summary>
            <div class="bg-red-50 bg-opacity-10">
                <a href="{{ route('admin.requests.good-moral') }}" class="flex items-center gap-3 px-10 py-3 text-sm {{ request()->routeIs('admin.requests.good-moral') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors">
                    <span class="w-1 h-1 bg-current rounded-full"></span>
                    Good Moral Requests
                </a>
                <a href="{{ route('admin.requests.safe-loan') }}" class="flex items-center gap-3 px-10 py-3 text-sm {{ request()->routeIs('admin.requests.safe-loan') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors">
                    <span class="w-1 h-1 bg-current rounded-full"></span>
                    Safe Loan Requests
                </a>
            </div>
        </details>

        <!-- Manage Users -->
        <details class="group">
            <summary class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.manage*') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full list-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
                <span class="sidebar-text text-small flex-1">Manage Users</span>
                <svg class="w-4 h-4 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </summary>
            <div class="bg-red-50 bg-opacity-10">
                <a href="{{ route('admin.manage-students') }}" class="flex items-center gap-3 px-10 py-3 text-sm {{ request()->routeIs('admin.manage-students') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors">
                    <span class="w-1 h-1 bg-current rounded-full"></span>
                    Students
                </a>
                <a href="{{ route('admin.manage-staff') }}" class="flex items-center gap-3 px-10 py-3 text-sm {{ request()->routeIs('admin.manage-staff') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors">
                    <span class="w-1 h-1 bg-current rounded-full"></span>
                    Staff
                </a>
                <a href="{{ route('admin.manage-admins') }}" class="flex items-center gap-3 px-10 py-3 text-sm {{ request()->routeIs('admin.manage-admins') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors">
                    <span class="w-1 h-1 bg-current rounded-full"></span>
                    Admins
                </a>
            </div>
        </details>

        <!-- Audit Logs -->
        <a href="{{ route('admin.audit-logs') }}"
           class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.audit-logs') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                <path d="M21 11.11V5a2 2 0 0 0-2-2h-4.18C14.4 1.84 13.3 1 12 1s-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14a2 2 0 0 0 2 2h6.11c1.26 1.24 2.98 2 4.89 2c3.87 0 7-3.13 7-7c0-1.91-.76-3.63-2-4.89M12 3c.55 0 1 .45 1 1s-.45 1-1 1s-1-.45-1-1s.45-1 1-1M6 7h12v2H6zm3.08 10H6v-2h3.08c-.05.33-.08.66-.08 1s.03.67.08 1M6 13v-2h5.11c-.61.57-1.07 1.25-1.43 2zm10 8c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5m.5-4.75l2.86 1.69l-.75 1.22L15 17v-5h1.5z"/>
            </svg>
            <span class="sidebar-text text-small">Audit Logs</span>
        </a>

        <!-- System Settings -->
        <a href="{{ route('admin.settings') }}"
           class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.settings') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                <path d="M19.14 12.94c.04-.3.06-.61.06-.94c0-.32-.02-.64-.07-.94l2.03-1.58a.49.49 0 00.12-.61l-1.92-3.32a.488.488 0 00-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54a.484.484 0 00-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58a.49.49 0 00-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6s3.6 1.62 3.6 3.6s-1.62 3.6-3.6 3.6z"/>
            </svg>
            <span class="sidebar-text text-small">Settings</span>
        </a>

        <!-- Profile -->
        <a href="{{ route('admin.profile') }}"
           class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.profile') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                <path fill-rule="evenodd" d="M256 42.667A213.333 213.333 0 0 1 469.334 256c0 117.821-95.513 213.334-213.334 213.334c-117.82 0-213.333-95.513-213.333-213.334C42.667 138.18 138.18 42.667 256 42.667m21.334 234.667h-42.667c-52.815 0-98.158 31.987-117.715 77.648c30.944 43.391 81.692 71.685 139.048 71.685s108.104-28.294 139.049-71.688c-19.557-45.658-64.9-77.645-117.715-77.645M256 106.667c-35.346 0-64 28.654-64 64s28.654 64 64 64s64-28.654 64-64s-28.653-64-64-64"/>
            </svg>
            <span class="sidebar-text text-small">Profile</span>
        </a>
    </nav>

    <!-- Logout Button -->
    <form method="POST" action="{{ route('logout') }}" class="mt-auto border-t border-red-200">
        @csrf
        <button type="submit" class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer text-red-900 hover:bg-red-800 hover:text-white transition-colors rounded-r-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                <path d="M160 256a16 16 0 0 1 16-16h144V136c0-32-33.79-56-64-56H104a56.06 56.06 0 0 0-56 56v240a56.06 56.06 0 0 0 56 56h160a56.06 56.06 0 0 0 56-56V272H176a16 16 0 0 1-16-16m299.31-11.31l-80-80a16 16 0 0 0-22.62 22.62L409.37 240H320v32h89.37l-52.68 52.69a16 16 0 1 0 22.62 22.62l80-80a16 16 0 0 0 0-22.62"/>
            </svg>
            <span class="sidebar-text text-base">Log out</span>
        </button>
    </form>
</div>
