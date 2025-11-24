<aside id="sidebar" 
       class="bg-white border-r border-gray-200 transition-all duration-300 ease-in-out relative flex flex-col"
       :class="sidebarOpen ? 'w-64' : 'w-16'">
    
    <!-- Toggle Button -->
    <button @click="sidebarOpen = !sidebarOpen"
            class="absolute -right-3 top-4 bg-white border border-gray-200 rounded-full p-1 shadow-md hover:shadow-lg transition-shadow z-10">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" 
             class="w-4 h-4 text-red-900 transition-transform duration-300"
             :class="sidebarOpen ? 'rotate-0' : 'rotate-180'">
            <path d="M11.7 15.3L7.4 11H16V9H7.4l4.3-4.3l-1.4-1.4L3.6 10l6.7 6.7z"/>
        </svg>
    </button>

    <div class="flex flex-col h-full">
        <nav class="flex flex-col gap-0 flex-1">
            <!-- Dashboard -->
            <a href="{{ route('osas-du.dashboard') }}"
               class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('osas-du.dashboard') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0">
                    <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                </svg>
                <span class="sidebar-text text-small transition-all duration-300" 
                      :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Dashboard</span>
            </a>

            <!-- Grievances -->
            <a href="{{ route('osas-du.grievances') }}"
               class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('osas-du.grievances*') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke="currentColor" fill="none" stroke-width="2"/>
                </svg>
                <span class="sidebar-text text-small transition-all duration-300" 
                      :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Grievances</span>
            </a>

            <!-- File Grievances -->
            <a href="{{ route('osas-du.file-grievances') }}"
               class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('osas-du.file-grievances') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm4 18H6V4h7v5h5v11zm-3-7v2h-2v2h-2v-2H9v-2h2v-2h2v2h2z"/>
                </svg>
                <span class="sidebar-text text-small transition-all duration-300" 
                      :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">File Grievances</span>
            </a>

            <!-- View Requests (Read Only) -->
            <a href="{{ route('osas-du.requests') }}"
               class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('osas-du.requests') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                <span class="sidebar-text text-small transition-all duration-300" 
                      :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">View Requests</span>
            </a>

            <!-- Audit Logs -->
            <a href="{{ route('osas-du.audit.index') }}"
               class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('osas-du.audit.index') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                    <path d="M21 11.11V5a2 2 0 0 0-2-2h-4.18C14.4 1.84 13.3 1 12 1s-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14a2 2 0 0 0 2 2h6.11c1.26 1.24 2.98 2 4.89 2c3.87 0 7-3.13 7-7c0-1.91-.76-3.63-2-4.89M12 3c.55 0 1 .45 1 1s-.45 1-1 1s-1-.45-1-1s.45-1 1-1M6 7h12v2H6zm3.08 10H6v-2h3.08c-.05.33-.08.66-.08 1s.03.67.08 1M6 13v-2h5.11c-.61.57-1.07 1.25-1.43 2zm10 8c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5m.5-4.75l2.86 1.69l-.75 1.22L15 17v-5h1.5z"/>
                </svg>
                <span class="sidebar-text text-small transition-all duration-300" 
                      :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Audit Logs</span>
            </a>

            <!-- Profile -->
            <a href="{{ route('osas-du.profile') }}"
               class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer {{ request()->routeIs('osas-du.profile*') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }} transition-colors rounded-r-lg w-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                    <path fill-rule="evenodd" d="M256 42.667A213.333 213.333 0 0 1 469.334 256c0 117.821-95.513 213.334-213.334 213.334c-117.82 0-213.333-95.513-213.333-213.334C42.667 138.18 138.18 42.667 256 42.667m21.334 234.667h-42.667c-52.815 0-98.158 31.987-117.715 77.648c30.944 43.391 81.692 71.685 139.048 71.685s108.104-28.294 139.049-71.688c-19.557-45.658-64.9-77.645-117.715-77.645M256 106.667c-35.346 0-64 28.654-64 64s28.654 64 64 64s64-28.654 64-64s-28.653-64-64-64"/>
                </svg>
                <span class="sidebar-text text-small transition-all duration-300" 
                      :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Profile</span>
            </a>
        </nav>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" class="mt-auto border-t border-red-200">
            @csrf
            <button type="submit" class="flex items-center gap-3 px-6 py-4 font-medium cursor-pointer text-red-900 hover:bg-red-800 hover:text-white transition-colors rounded-r-lg w-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-6 h-6 flex-shrink-0" fill="currentColor">
                    <path d="M160 256a16 16 0 0 1 16-16h144V136c0-32-33.79-56-64-56H104a56.06 56.06 0 0 0-56 56v240a56.06 56.06 0 0 0 56 56h160a56.06 56.06 0 0 0 56-56V272H176a16 16 0 0 1-16-16m299.31-11.31l-80-80a16 16 0 0 0-22.62 22.62L409.37 240H320v32h89.37l-52.68 52.69a16 16 0 1 0 22.62 22.62l80-80a16 16 0 0 0 0-22.62"/>
                </svg>
                <span class="sidebar-text text-base transition-all duration-300" 
                      :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Log out</span>
            </button>
        </form>
    </div>
</aside>
