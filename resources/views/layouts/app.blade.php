<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | GMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet" />
    <!-- Alpine.js for interactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        html,
        body {
            /* overflow: hidden; */
            /* Remove scrollbars */
            height: 100%;
        }

        /* Smooth transitions for dropdown */
        [x-cloak] {
            display: none !important;
        }
    </style>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="bg-white min-h-screen flex flex-col">
    <!-- <body class="bg-white h-screen w-screen flex flex-col"> -->
    <!-- HEADER -->
    <!-- <header class="flex items-center justify-between bg-white border-b border-gray-200 px-4 h-14 flex-shrink-0"> -->
    <header class="px-6 py-3 border-b border-gray-200 flex items-center justify-between space-x-2 cursor-default relative">
        <div class="flex items-center space-x-3">
            <img src="/images/Logo_GMS.png" alt="GMS Logo" class="h-12">
        </div>
    </header>


    <!-- MAIN WRAPPER (SIDEBAR + CONTENT) -->
    <div class="flex flex-1 overflow-hidden">

        <!-- SIDEBAR -->
        <aside id="sidebar"
            class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between relative transition-all duration-300">

            <!-- Toggle Button -->
            <button id="sidebarToggle" onclick="toggleSidebar()"
                class="absolute top-[28px] -right-3 transform -translate-y-1/2
               bg-white text-red-900 rounded-full shadow p-1 hover:bg-gray-100 transition">

                <!-- Arrow To Right (visible only when collapsed) -->
                <svg id="iconCollapse" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" viewBox="0 0 24 24" class="hidden">
                    <path d="M18 6h2v12h-2zM11.71 17.29 7.41 13H16v-2H7.41l4.3-4.29-1.42-1.42L3.59 12l6.7 6.71z" />
                </svg>

                <!-- Arrow From Left (visible only when expanded) -->
                <svg id="iconExpand" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4 6h2v12H4zM12.29 6.71l4.3 4.29H8v2h8.59l-4.3 4.29 1.42 1.42 6.7-6.71-6.7-6.71z" />
                </svg>
            </button>

            <!-- Dynamic sidebar items -->
            <nav class="flex-grow space-y-3">
                @yield('sidebar')
            </nav>
        </aside>

        <!-- CONTENT AREA -->
        <main class="flex-1 overflow-y-auto" style="background-color: #F8F8FF;">
            <div class="p-8">
                @yield('content')
            </div>

            <!-- Global Toast Notifications (single source) -->
            @if(session('success'))
            <x-toast type="success" :message="session('success')" />
            @endif
            @if(session('status'))
            <x-toast type="success" :message="session('status')" />
            @endif
            @if(session('error'))
            <x-toast type="error" :message="session('error')" />
            @endif

            <!-- Footer -->
            <footer class="w-full text-center py-4 text-sm text-gray-600 border-t border-gray-200" style="background-color: #F5F5F5;">
                <p>
                    © Office of Student Affairs and Services. All Rights Reserved.
                    <a href="#" class="text-blue-600 hover:underline">Terms of Use</a> |
                    <a href="https://www.usep.edu.ph/usep-data-privacy-statement/"
                        target="_blank" rel="noopener noreferrer"
                        class="text-blue-600 hover:underline">
                        Privacy Policy
                    </a>
                </p>
            </footer>
        </main>
    </div>
    <!-- <div class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-40" id="mobile-overlay"></div> -->
    </div>






    <script>
        // Sidebar collapse functionality
        window.sidebarCollapsed = false;

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            const iconCollapse = document.getElementById('iconCollapse');
            const iconExpand = document.getElementById('iconExpand');

            window.sidebarCollapsed = !window.sidebarCollapsed;

            if (sidebar) {
                if (window.sidebarCollapsed) {
                    // Collapse
                    sidebar.classList.add('w-20');
                    sidebar.classList.remove('w-64');
                    sidebarTexts.forEach(text => text.classList.add('hidden'));
                    iconCollapse.classList.add('hidden');
                    iconExpand.classList.remove('hidden');
                } else {
                    // Expand
                    sidebar.classList.remove('w-20');
                    sidebar.classList.add('w-64');
                    sidebarTexts.forEach(text => text.classList.remove('hidden'));
                    iconCollapse.classList.remove('hidden');
                    iconExpand.classList.add('hidden');
                }
            }

            // Save state
            localStorage.setItem('sidebarCollapsed', window.sidebarCollapsed);
        }

        // Restore sidebar state on load
        document.addEventListener('DOMContentLoaded', () => {
            const saved = localStorage.getItem('sidebarCollapsed');
            if (saved === 'true') {
                toggleSidebar();
            }
        });
    </script>

    <script>
        // Sidebar collapse functionality
        window.sidebarCollapsed = false;

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            const iconCollapse = document.getElementById('iconCollapse');
            const iconExpand = document.getElementById('iconExpand');

            window.sidebarCollapsed = !window.sidebarCollapsed;

            if (sidebar) {
                if (window.sidebarCollapsed) {
                    // Collapse
                    sidebar.classList.add('w-20');
                    sidebar.classList.remove('w-64');
                    sidebarTexts.forEach(text => text.classList.add('hidden'));
                    iconCollapse.classList.add('hidden');
                    iconExpand.classList.remove('hidden');
                } else {
                    // Expand
                    sidebar.classList.remove('w-20');
                    sidebar.classList.add('w-64');
                    sidebarTexts.forEach(text => text.classList.remove('hidden'));
                    iconCollapse.classList.remove('hidden');
                    iconExpand.classList.add('hidden');
                }
            }

            // Save state
            localStorage.setItem('sidebarCollapsed', window.sidebarCollapsed);
        }

        // Restore sidebar state on load
        document.addEventListener('DOMContentLoaded', () => {
            const saved = localStorage.getItem('sidebarCollapsed');
            if (saved === 'true') {
                toggleSidebar();
            }
        });
    </script>

    @stack('scripts')
</body>

</html>