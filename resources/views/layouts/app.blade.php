<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'Dashboard') | GMS</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet" />
  <!-- Alpine.js for interactive components -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  <style>
    body { font-family: 'Inter', sans-serif; }

    html, body {
      /* overflow: hidden; */    /* Remove scrollbars */
      height: 100%;
    }

    /* Bell shake animation */
    @keyframes bellShake {
      0%, 100% { transform: rotate(0deg); }
      10%, 30%, 50%, 70%, 90% { transform: rotate(-10deg); }
      20%, 40%, 60%, 80% { transform: rotate(10deg); }
    }

    .bell-shake {
      animation: bellShake 0.8s ease-in-out;
    }

    /* Slower pulse animation for badge */
    @keyframes pulse-slow {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.7; }
    }

    .animate-pulse-slow {
      animation: pulse-slow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    /* Smooth transitions for dropdown */
    [x-cloak] { display: none !important; }
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
    <div class="flex items-center space-x-4">
      <!-- Notifications + Avatar ... -->
    </div>
    <div class="flex items-center space-x-4">
          <!-- Notifications -->
      <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" id="btnNotifications" 
                class="relative p-2 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-red-800 transition-all duration-200 group">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
               fill="currentColor" class="w-6 h-6 text-gray-700 group-hover:text-red-800 transition-colors bell-icon">
            <path d="M12 22a2.5 2.5 0 0 0 2.45-2h-4.9A2.5 2.5 0 0 0 12 22zM19 16v-5a7 7 0 1 0-14 0v5l-1.5 1.5a1 1 0 0 0 .7 1.7h16.6a1 1 0 0 0 .7-1.7L19 16z"/>
          </svg>
          <!-- Badge with pulse animation -->
          <span id="notifBadge" class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center
                       text-[10px] font-semibold leading-none px-1.5 h-4 rounded-full bg-red-600 text-white shadow-lg
                       animate-pulse-slow">3</span>
          <!-- Ping effect for new notifications -->
          <span class="absolute -top-0.5 -right-0.5 flex h-4 w-4">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
          </span>
        </button>

        <!-- Dropdown Menu -->
        <div x-show="open" 
             @click.away="open = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
             id="notifDropdown" 
             class="absolute right-0 mt-3 w-96 bg-white rounded-xl shadow-2xl border border-gray-200 z-50 overflow-hidden">
          
          <!-- Header -->
          <div class="px-4 py-3 bg-gradient-to-r from-red-800 to-red-900 border-b border-red-700">
            <div class="flex items-center justify-between">
              <h3 class="text-white font-semibold text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
                Notifications
              </h3>
              <button class="text-xs text-red-100 hover:text-white font-medium hover:underline transition-colors"
                      onclick="markAllAsRead()">
                Mark all as read
              </button>
            </div>
          </div>

          <!-- Notifications List -->
          <div class="max-h-96 overflow-y-auto">
            <div class="divide-y divide-gray-100">
              <!-- Unread Notification -->
              <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-red-50 transition-colors group relative notification-item">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                  <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-semibold text-gray-900 group-hover:text-red-800">New grievance submitted</p>
                  <p class="text-xs text-gray-600 mt-0.5">Student filed a new case regarding academic concerns</p>
                  <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    5 minutes ago
                  </p>
                </div>
                <span class="w-2 h-2 rounded-full bg-red-600 flex-shrink-0 mt-2"></span>
              </a>

              <!-- Unread Notification -->
              <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-green-50 transition-colors group relative notification-item">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                  <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-semibold text-gray-900 group-hover:text-green-800">CASE-2025-003 resolved</p>
                  <p class="text-xs text-gray-600 mt-0.5">Case has been successfully resolved and closed</p>
                  <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    1 hour ago
                  </p>
                </div>
                <span class="w-2 h-2 rounded-full bg-red-600 flex-shrink-0 mt-2"></span>
              </a>

              <!-- Read Notification -->
              <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-blue-50 transition-colors group relative notification-item opacity-75">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                  <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-800 group-hover:text-blue-800">Hearing scheduled for CASE-2025-001</p>
                  <p class="text-xs text-gray-600 mt-0.5">Meeting set for November 25, 2025 at 2:00 PM</p>
                  <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    3 hours ago
                  </p>
                </div>
              </a>

              <!-- Read Notification -->
              <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-purple-50 transition-colors group relative notification-item opacity-75">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                  <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                  </svg>
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-800 group-hover:text-purple-800">New message from Guidance Office</p>
                  <p class="text-xs text-gray-600 mt-0.5">Please review the updated student handbook</p>
                  <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    1 day ago
                  </p>
                </div>
              </a>
            </div>
          </div>

          <!-- Footer -->
          <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
            <a href="#" class="text-sm text-red-800 hover:text-red-900 font-medium hover:underline flex items-center justify-center gap-1 group">
              View all notifications
              <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
            </a>
          </div>
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
  <!-- Global Toast Container (fixed top-right) -->
  <div id="toast-container" class="fixed top-4 right-4 z-[100] space-y-3 flex flex-col items-end"></div>

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
    <main class="flex-1 overflow-y-auto" style="background-color: #F8F8FF;">
      <div class="p-8">
        @yield('content')
      </div>

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
  window.__sessionSuccess = @json(session('success'));
  window.__sessionError = @json(session('error'));
</script>

<script>
  function buildToast(message, variant = 'success') {
    const variants = {
      success: {
        icon: `<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/></svg>`,
        iconWrap: 'text-green-700 bg-green-100',
        sr: 'Success'
      },
      error: {
        icon: `<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>`,
        iconWrap: 'text-red-700 bg-red-100',
        sr: 'Error'
      },
      warning: {
        icon: `<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>`,
        iconWrap: 'text-yellow-700 bg-yellow-100',
        sr: 'Warning'
      },
      info: {
        icon: `<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17v-6m0-4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>`,
        iconWrap: 'text-blue-700 bg-blue-100',
        sr: 'Info'
      }
    };
    const v = variants[variant] || variants.success;
    const el = document.createElement('div');
    // solid card style so it never looks transparent
    el.className = 'flex items-center w-full max-w-sm p-4 bg-white text-gray-800 rounded-lg shadow-lg border border-gray-200';
    el.setAttribute('role','alert');
    el.innerHTML = `
      <div class="inline-flex items-center justify-center shrink-0 w-7 h-7 rounded ${v.iconWrap}">${v.icon}<span class="sr-only">${v.sr} icon</span></div>
      <div class="ms-3 text-sm font-normal">${message}</div>
      <button type="button" class="ms-auto flex items-center justify-center text-gray-600 hover:text-gray-900 bg-transparent rounded h-8 w-8 focus:outline-none" aria-label="Close">\n        <span class="sr-only">Close</span>\n        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>\n      </button>
    `;
    el.querySelector('button').addEventListener('click', () => el.remove());
    return el;
  }
  function pushToast(msg, variant='success') {
    if(!msg) return;
    const c = document.getElementById('toast-container');
    const t = buildToast(msg, variant);
    c.appendChild(t);
    setTimeout(()=> t.remove(), 5000);
  }
  window.pushToast = pushToast;
  document.addEventListener('DOMContentLoaded', ()=> {
    if(window.__sessionSuccess){ pushToast(window.__sessionSuccess,'success'); }
    if(window.__sessionError){ pushToast(window.__sessionError,'error'); }
  });
</script>

<script>
  // Bell shake animation on new notification
  function shakeBell() {
    const bell = document.querySelector('.bell-icon');
    bell.classList.add('bell-shake');
    setTimeout(() => bell.classList.remove('bell-shake'), 800);
  }

  // Mark all notifications as read
  function markAllAsRead() {
    const badge = document.getElementById('notifBadge');
    const items = document.querySelectorAll('.notification-item');
    
    // Hide badge
    badge.style.display = 'none';
    
    // Remove unread indicators (red dots)
    items.forEach(item => {
      const dot = item.querySelector('.bg-red-600');
      if (dot) dot.remove();
      item.classList.remove('opacity-100');
      item.classList.add('opacity-75');
    });

    // Show success toast
    pushToast('All notifications marked as read', 'success');
  }

  // Simulate new notification (for testing)
  function simulateNewNotification() {
    shakeBell();
    const badge = document.getElementById('notifBadge');
    const currentCount = parseInt(badge.textContent);
    badge.textContent = currentCount + 1;
    badge.style.display = 'inline-flex';
  }

  // Trigger bell shake on page load if there are notifications
  document.addEventListener('DOMContentLoaded', () => {
    const badge = document.getElementById('notifBadge');
    if (badge && parseInt(badge.textContent) > 0) {
      setTimeout(shakeBell, 500);
    }
  });
</script>

@stack('scripts')

</body>
</html>