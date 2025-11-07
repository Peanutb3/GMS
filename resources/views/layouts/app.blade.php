<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'Dashboard') | GMS</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet" />
  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  <style>
    body { font-family: 'Inter', sans-serif; }

    html, body {
      /* overflow: hidden; */    /* Remove scrollbars */
      height: 100%;
    }
  </style>

   @vite('resources/css/app.css')
   @vite('resources/js/app.js')  
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
<!-- <body class="bg-white h-screen w-screen flex flex-col"> -->
  <!-- HEADER -->
  <!-- <header class="flex items-center justify-between bg-white border-b border-gray-200 px-4 h-14 flex-shrink-0"> -->
    <header class="px-6 py-3 border-b border-gray-200 flex items-center justify-between space-x-2 cursor-default">
    <div class="flex items-center space-x-3">
      <img src="/images/Logo_GMS.png" alt="GMS Logo" class="h-12">
    </div>
    <div class="flex items-center space-x-4">
      <!-- Notifications + Avatar ... -->
    </div>
    <div class="flex items-center space-x-4">
          <!-- Notifications -->
      <div class="relative">
        <button id="btnNotifications" class="relative p-2 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-red-800">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
               fill="currentColor" class="w-6 h-6 text-gray-700">
            <path d="M12 22a2.5 2.5 0 0 0 2.45-2h-4.9A2.5 2.5 0 0 0 12 22zM19 16v-5a7 7 0 1 0-14 0v5l-1.5 1.5a1 1 0 0 0 .7 1.7h16.6a1 1 0 0 0 .7-1.7L19 16z"/>
          </svg>
          <span id="notifBadge" class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center
                       text-[10px] leading-none px-1.5 h-4 rounded-full bg-red-800 text-white">3</span>
        </button>
        <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-72 bg-white shadow-lg rounded-lg border border-gray-200 z-50">
          <ul class="divide-y divide-gray-100">
            <li class="flex items-center gap-3 px-4 py-2 hover:bg-gray-50"><span class="text-sm text-gray-800">New grievance submitted</span></li>
            <li class="flex items-center gap-3 px-4 py-2 hover:bg-gray-50"><span class="text-sm text-gray-800">CASE-2025-003 resolved</span></li>
            <li class="flex items-center gap-3 px-4 py-2 hover:bg-gray-50"><span class="text-sm text-gray-800">Hearing set for CASE-2025-001</span></li>
            <li class="flex items-center gap-3 px-4 py-2 hover:bg-gray-50"><span class="text-sm text-gray-800">New message from Guidance</span></li>
          </ul>
        </div>
      </div>
          <!-- Avatar -->
      <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" 
           class="w-8 h-8 rounded-full border text-gray-600">
        <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 
                 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z"/>
      </svg> -->
    </div>
  </header>

  <!-- MAIN WRAPPER (SIDEBAR + CONTENT) -->
  <div class="flex flex-1 overflow-hidden">
  
<!-- SIDEBAR -->
<aside id="sidebar" 
       class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between relative transition-all duration-300">

<!-- Toggle Button -->
<button id="sidebarToggle" 
        class="absolute top-[28px] -right-3 transform -translate-y-1/2 
               bg-white text-red-900 rounded-full shadow p-1 hover:bg-gray-100 transition">

  <!-- Arrow To Right (visible only when collapsed) -->
  <svg id="iconExpand" xmlns="http://www.w3.org/2000/svg" width="16" height="16"  
       fill="currentColor" viewBox="0 0 24 24" class="hidden">
    <path d="M18 6h2v12h-2zM11.71 17.29 7.41 13H16v-2H7.41l4.3-4.29-1.42-1.42L3.59 12l6.7 6.71z"/>
  </svg>

  <!-- Arrow From Left (visible only when expanded) -->
  <svg id="iconCollapse" xmlns="http://www.w3.org/2000/svg" width="16" height="16"  
       fill="currentColor" viewBox="0 0 24 24">
    <path d="M4 6h2v12H4zM12.29 6.71l4.3 4.29H8v2h8.59l-4.3 4.29 1.42 1.42 6.7-6.71-6.7-6.71z"/>
  </svg>
</button>

  <!-- Dynamic sidebar items -->
  <nav class="flex-grow space-y-3">
    @yield('sidebar')
  </nav>
</aside>

  <!-- CONTENT AREA -->
    <main class="flex-1 bg-white flex flex-col">
      <div class="flex-grow p-8 overflow-y-auto">
        @yield('content')
      </div>

      <!-- Footer -->
      <footer class="w-full text-center py-4 text-sm text-gray-600 bg-white border-t border-gray-200">
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

@stack('scripts')

</body>
</html>