<div class="flex flex-col h-full">
    <nav class="flex flex-col gap-0 flex-1">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.dashboard') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0">
                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" />
            </svg>
            <span class="sidebar-text text-small">Dashboard</span>
        </a>

        <!-- Grievances -->
        <a href="{{ route('admin.grievances') }}"
            class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.grievances*') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
            </svg>
            <span class="sidebar-text text-small">Grievances</span>
        </a>

        <!-- Requests -->
        <details class="group">
            <summary class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.requests*') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full list-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                    <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" />
                    <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
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
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                    <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157l.001.003Z" />
                </svg>
                <span class="sidebar-text text-small flex-1">Manage Users</span>
                <svg class="sidebar-text w-4 h-4 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </summary>
            <div class="sidebar-text bg-red-50 bg-opacity-10">
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
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                <path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                <path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
            </svg>
            <span class="sidebar-text text-small">Colleges & Programs</span>
        </a>

        <!-- Audit Logs -->
        <a href="{{ route('admin.audit-logs') }}"
            class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.audit-logs') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd" />
            </svg>
            <span class="sidebar-text text-small">Audit Logs</span>
        </a>

        <!-- System Settings -->
        <a href="{{ route('admin.settings') }}"
            class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.settings') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd" />
            </svg>
            <span class="sidebar-text text-small">Settings</span>
        </a>

        <!-- Profile -->
        <a href="{{ route('admin.profile') }}"
            class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.profile') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
            </svg>
            <span class="sidebar-text text-small">Profile</span>
        </a>
    </nav>

    <!-- Logout Button -->
    <form method="POST" action="{{ route('logout') }}" class="mt-auto border-t border-red-200">
        @csrf
        <button type="submit" class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer text-red-900 hover:bg-red-800 hover:text-white transition-colors rounded-r-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm10.72 4.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1 0 1.06l-3 3a.75.75 0 1 1-1.06-1.06l1.72-1.72H9a.75.75 0 0 1 0-1.5h10.94l-1.72-1.72a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
            </svg>
            <span class="sidebar-text text-base">Log out</span>
        </button>
    </form>
</div>
