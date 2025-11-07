<div class="flex flex-col h-full">
    <nav class="flex flex-col gap-0 flex-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                     class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.dashboard') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0">
                            <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" class="{{ isset($sidebarCollapsed) && $sidebarCollapsed ? 'w-8 h-8' : 'w-6 h-6' }} flex-shrink-0"/>
                        </svg>
                        <span class="sidebar-text text-small">Dashboard</span>
                </a>
        <!-- Manage Staff -->
        <a href="{{ route('admin.manage-staff') }}"
           class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.manage-staff') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ isset($sidebarCollapsed) && $sidebarCollapsed ? 'w-8 h-8' : 'w-6 h-6' }} flex-shrink-0"><circle cx="12" cy="6" r="4" fill="currentColor"/><path fill="currentColor" d="M20 17.5c0 2.485 0 4.5-8 4.5s-8-2.015-8-4.5S7.582 13 12 13s8 2.015 8 4.5"/></svg>
            <span class="sidebar-text text-small">Manage Staff</span>
        </a>
        <!-- Manage Students -->
        <a href="{{ route('admin.manage-students') }}"
           class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.manage-students') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ isset($sidebarCollapsed) && $sidebarCollapsed ? 'w-8 h-8' : 'w-6 h-6' }} flex-shrink-0"><path fill="currentColor" d="M16 8c0 2.21-1.79 4-4 4s-4-1.79-4-4l.11-.94L5 5.5L12 2l7 3.5v5h-1V6l-2.11 1.06zm-4 6c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4"/></svg>
            <span class="sidebar-text text-small">Manage Students</span>
        </a>
        <!-- All Grievance Reports -->
        <a href="{{ route('admin.all-grievances-reports') }}"
            class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.all-grievances-reports') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="{{ isset($sidebarCollapsed) && $sidebarCollapsed ? 'w-8 h-8' : 'w-6 h-6' }} flex-shrink-0"><defs><mask id="SVGWVB6RddW"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#fff" stroke="#fff" d="M5 7a3 3 0 0 1 3-3h24a3 3 0 0 1 3 3v37H8a3 3 0 0 1-3-3z"/><path stroke="#fff" d="M35 24a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v17a3 3 0 0 1-3 3h-5z"/><path stroke="#000" stroke-linecap="round" d="M11 12h8m-8 7h12"/></g></mask></defs><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#SVGWVB6RddW)"/></svg>
            <span class="sidebar-text text-small">All Grievance Reports</span>
        </a>
        <!-- Action History -->
        <a href="{{ route('admin.action-history') }}"
           class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.action-history') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ isset($sidebarCollapsed) && $sidebarCollapsed ? 'w-8 h-8' : 'w-6 h-6' }} flex-shrink-0"><path fill="currentColor" d="M21 11.11V5a2 2 0 0 0-2-2h-4.18C14.4 1.84 13.3 1 12 1s-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14a2 2 0 0 0 2 2h6.11c1.26 1.24 2.98 2 4.89 2c3.87 0 7-3.13 7-7c0-1.91-.76-3.63-2-4.89M12 3c.55 0 1 .45 1 1s-.45 1-1 1s-1-.45-1-1s.45-1 1-1M6 7h12v2H6zm3.08 10H6v-2h3.08c-.05.33-.08.66-.08 1s.03.67.08 1M6 13v-2h5.11c-.61.57-1.07 1.25-1.43 2zm10 8c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5m.5-4.75l2.86 1.69l-.75 1.22L15 17v-5h1.5z"/></svg>
            <span class="sidebar-text text-small">Action History</span>
        </a>
        <!-- Profile -->
        <a href="{{ route('admin.profile') }}"
           class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.profile') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="{{ isset($sidebarCollapsed) && $sidebarCollapsed ? 'w-8 h-8' : 'w-6 h-6' }} flex-shrink-0"><path fill="currentColor" fill-rule="evenodd" d="M256 42.667A213.333 213.333 0 0 1 469.334 256c0 117.821-95.513 213.334-213.334 213.334c-117.82 0-213.333-95.513-213.333-213.334C42.667 138.18 138.18 42.667 256 42.667m21.334 234.667h-42.667c-52.815 0-98.158 31.987-117.715 77.648c30.944 43.391 81.692 71.685 139.048 71.685s108.104-28.294 139.049-71.688c-19.557-45.658-64.9-77.645-117.715-77.645M256 106.667c-35.346 0-64 28.654-64 64s28.654 64 64 64s64-28.654 64-64s-28.653-64-64-64"/></svg>
            <span class="sidebar-text text-small">Profile</span>
        </a>
        <!-- Settings -->
        <a href="{{ route('admin.settings') }}"
           class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.settings') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="{{ isset($sidebarCollapsed) && $sidebarCollapsed ? 'w-8 h-8' : 'w-6 h-6' }} flex-shrink-0"><path fill="currentColor" d="M21.66 6.423L12 .845L2.34 6.423v11.154L12 23.155l9.66-5.578zM12 16a4 4 0 1 1 0-8a4 4 0 0 1 0 8"/></svg>
            <span class="sidebar-text text-small">Setting</span>
        </a>
    </nav>
    <form method="POST" action="{{ route('logout') }}" class="mt-auto">
        @csrf
        <button type="submit" class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('admin.settings') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-6 h-6 flex-shrink-0">
                            <path fill="currentColor" d="M160 256a16 16 0 0 1 16-16h144V136c0-32-33.79-56-64-56H104a56.06 56.06 0 0 0-56 56v240a56.06 56.06 0 0 0 56 56h160a56.06 56.06 0 0 0 56-56V272H176a16 16 0 0 1-16-16m299.31-11.31l-80-80a16 16 0 0 0-22.62 22.62L409.37 240H320v32h89.37l-52.68 52.69a16 16 0 1 0 22.62 22.62l80-80a16 16 0 0 0 0-22.62"/>
                        </svg>
            </svg>
            <span class="sidebar-text text-base">Log out</span>
        </button>
    </form>
</div>
