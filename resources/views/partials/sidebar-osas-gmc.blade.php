<div class="flex flex-col h-full">
    <nav class="flex flex-col gap-0 flex-1">
        <!-- Dashboard -->
        <a href="{{ route('osas-gmc.dashboard') }}"
            class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('osas-gmc.dashboard') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0">
                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" class="{{ isset($sidebarCollapsed) && $sidebarCollapsed ? 'w-8 h-8' : 'w-6 h-6' }} flex-shrink-0"/></svg>
            <span class="sidebar-text text-small">Dashboard</span>
        </a>
        
        <!-- Grievances -->
        <a href="{{ route('osas-gmc.grievances') }}"
            class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('osas-gmc.grievances') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="{{ isset($sidebarCollapsed) && $sidebarCollapsed ? 'w-8 h-8' : 'w-6 h-6' }} flex-shrink-0"><defs><mask id="SVGWVB6RddW"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#fff" stroke="#fff" d="M5 7a3 3 0 0 1 3-3h24a3 3 0 0 1 3 3v37H8a3 3 0 0 1-3-3z"/>
                <path stroke="#fff" d="M35 24a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v17a3 3 0 0 1-3 3h-5z"/><path stroke="#000" stroke-linecap="round" d="M11 12h8m-8 7h12"/></g></mask></defs><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#SVGWVB6RddW)"/></svg>
            <span class="sidebar-text text-small">Grievances</span>
        </a>

        <!-- Requests (Good Moral & Safe Loan) -->
        <a href="{{ route('osas-gmc.requests') }}"
            class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('osas-gmc.requests') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="{{ isset($sidebarCollapsed) && $sidebarCollapsed ? 'w-8 h-8' : 'w-6 h-6' }} flex-shrink-0" fill="currentColor">
                    <path fill="currentColor" d="M16.5 23.5a2 2 0 1 0 0-4a2 2 0 0 0 0 4m2 9a2 2 0 1 1-4 0a2 2 0 0 1 4 0M6 12.25A6.25 6.25 0 0 1 12.25 6h23.5A6.25 6.25 0 0 1 42 12.25v11.794a12.9 12.9 0 0 0-6.033-2.009q.033-.137.033-.285c0-.69-.56-1.25-1.25-1.25h-10.5a1.25 1.25 0 1 0 0 2.5h5.741C25.298 24.961 22 29.596 22 35c0 2.577.75 4.98 2.044 7H12.25A6.25 6.25 0 0 1 6 35.75zm15 9.25a4.5 4.5 0 1 0-9 0a4.5 4.5 0 0 0 9 0M16.5 37a4.5 4.5 0 1 0 0-9a4.5 4.5 0 0 0 0 9m-3.25-26a1.25 1.25 0 1 0 0 2.5h21.5a1.25 1.25 0 1 0 0-2.5zM46 35c0 6.075-4.925 11-11 11s-11-4.925-11-11s4.925-11 11-11s11 4.925 11 11m-10-7a1 1 0 1 0-2 0v6h-6a1 1 0 1 0 0 2h6v6a1 1 0 1 0 2 0v-6h6a1 1 0 1 0 0-2h-6z"/>
                </svg>
            <span class="sidebar-text text-small">Requests</span>
        </a>

        <!-- Logs -->
        <a href="#"
            class="flex items-center gap-3 px-6 py-4 font-medium opacity-50 cursor-not-allowed transition-colors rounded-r-lg w-full"
            title="Audit Logs not available for GMC role">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="{{ isset($sidebarCollapsed) && $sidebarCollapsed ? 'w-8 h-8' : 'w-6 h-6' }} flex-shrink-0"><path d="M3 5a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2zm9 0a2 2 0 0 1 2-2h5a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2zm0 8a2 2 0 0 1 2-2h5a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2z"/></svg>
            <span class="sidebar-text text-small">Logs</span>
        </a>

        <!-- Profile -->
    <a href="{{ route('osas-gmc.profile') }}"
       class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('osas-gmc.profile') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="{{ isset($sidebarCollapsed) && $sidebarCollapsed ? 'w-8 h-8' : 'w-6 h-6' }} flex-shrink-0">
                <path fill="currentColor" fill-rule="evenodd" d="M256 42.667A213.333 213.333 0 0 1 469.334 256c0 117.821-95.513 213.334-213.334 213.334c-117.82 0-213.333-95.513-213.333-213.334C42.667 138.18 138.18 42.667 256 42.667m21.334 234.667h-42.667c-52.815 0-98.158 31.987-117.715 77.648c30.944 43.391 81.692 71.685 139.048 71.685s108.104-28.294 139.049-71.688c-19.557-45.658-64.9-77.645-117.715-77.645M256 106.667c-35.346 0-64 28.654-64 64s28.654 64 64 64s64-28.654 64-64s-28.653-64-64-64"/></svg>
            <span class="sidebar-text text-small">Profile</span>
        </a>
    </nav>
    
    <form method="POST" action="{{ route('logout') }}" class="mt-auto">
        @csrf
        <button type="submit" class="flex items-center gap-3 px-6 py-4 font-medium text-red-900 hover:bg-red-800 hover:text-white transition-colors rounded-r-lg w-full">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0">
                <path d="M16 13v-2H7V8l-5 4 5 4v-3h9zm3-10H5c-1.1 0-2 .9-2 2v4h2V5h14v14H5v-4H3v4c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
            </svg>
            <span class="sidebar-text text-base">Log out</span>
        </button>
    </form>
</div>
