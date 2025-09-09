<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Grievance Monitoring System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <div class="flex flex-1 overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between">
            <div>
                <div class="px-6 py-4 border-b border-gray-200 flex items-center space-x-2 cursor-default">
                    <img src="path-to-logo.png" alt="Logo" class="h-12 w-12 rounded-full" />
                    <div>
                        <h1 class="text-red-900 font-serif tracking-wide text-xl" style="letter-spacing: -0.03em;">GR!EVANCE</h1>
                        <p class="text-red-900 text-xs font-thin uppercase tracking-wide">MONITORING SYSTEM</p>
                    </div>
                </div>
                <nav class="mt-6">
                    <ul>
                        <!-- Dashboard (active) -->
                        <li class="bg-red-900 text-white rounded-r-lg">
                            <a href="#" class="flex items-center gap-3 px-6 py-4 font-semibold cursor-pointer">
                                <!-- Dashboard Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3h7v7H3V3zM14 3h7v7h-7V3zM3 14h7v7H3v-7zM14 14h7v7h-7v-7z" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <!-- Manage Staff -->
                        <li>
                            <a href="#" class="flex items-center gap-3 px-6 py-4 hover:bg-gray-100 cursor-pointer">
                                <!-- User Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                                    viewBox="0 0 24 24" stroke="none">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM6 20v-2c0-2.21 3.58-4 6-4s6 1.79 6 4v2H6z" />
                                </svg>
                                Manage Staff
                            </a>
                        </li>
                        <!-- Manage Students -->
                        <li>
                            <a href="#" class="flex items-center gap-3 px-6 py-4 hover:bg-gray-100 cursor-pointer">
                                <!-- Graduation Cap Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 14l6.16-3.422A12.083 12.083 0 0121 14c0 6-9 9-9 9s-9-3-9-9a12.083 12.083 0 012.84-3.422L12 14z" />
                                </svg>
                                Manage Students
                            </a>
                        </li>
                        <!-- All Grievance Reports -->
                        <li>
                            <a href="#" class="flex items-center gap-3 px-6 py-4 hover:bg-gray-100 cursor-pointer">
                                <!-- Book Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path d="M19 4H6a2 2 0 00-2 2v12a2 2 0 002 2h13a1 1 0 001-1V5a1 1 0 00-1-1zM8 18H6v-2h2v2zm8-4h-6v-2h6v2z" />
                                </svg>
                                All Grievance Reports
                            </a>
                        </li>
                        <!-- Action History -->
                        <li>
                            <a href="#" class="flex items-center gap-3 px-6 py-4 hover:bg-gray-100 cursor-pointer">
                                <!-- Clipboard Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h6M9 16h6M9 8h6M9 4H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2v-4" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 2h6a2 2 0 012 2v2H9V2z" />
                                </svg>
                                Action History
                            </a>
                        </li>
                        <!-- Profile -->
                        <li>
                            <a href="#" class="flex items-center gap-3 px-6 py-4 hover:bg-gray-100 cursor-pointer">
                                <!-- User Circle Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM4 20v-1a4 4 0 014-4h8a4 4 0 014 4v1H4z" />
                                </svg>
                                Profile
                            </a>
                        </li>
                        <!-- Setting -->
                        <li>
                            <a href="#" class="flex items-center gap-3 px-6 py-4 hover:bg-gray-100 cursor-pointer">
                                <!-- Cog Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.325 4.317a1 1 0 011.35 0l.834.834a1 1 0 001.414 0l.834-.834a1 1 0 011.35 0l1.846 1.847a1 1 0 010 1.414l-.834.834a1 1 0 000 1.414l.834.834a1 1 0 010 1.414l-1.847 1.846a1 1 0 01-1.414 0l-.834-.834a1 1 0 00-1.414 0l-.834.834a1 1 0 01-1.35 0l-1.85-1.85a1 1 0 010-1.414l.834-.834a1 1 0 000-1.414l-.834-.834a1 1 0 010-1.414l1.85-1.85z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Setting
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Logout -->
            <div class="border-t border-gray-200 p-4">
                <a href="#" class="flex items-center gap-3 text-gray-700 hover:text-red-900 cursor-pointer">
                    <!-- Logout Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1m0-10V5a2 2 0 114 0v1" />
                    </svg>
                    Log out
                </a>
            </div>
        </aside>

        <!-- Main content -->
        <main class="flex-1 flex flex-col overflow-y-auto p-6 space-y-6">
            <!-- Topbar -->
            <header class="flex justify-between items-center border-b border-gray-200 pb-2">
                <div class="hidden md:flex items-center space-x-6">
                    <!-- The logo and title are already in sidebar; omit here -->
                </div>

                <div class="flex items-center space-x-6">
                    <!-- Notification Bell -->
                    <button title="Notifications" class="relative focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700 hover:text-red-900"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-5-5.917V5a1 1 0 10-2 0v.083A6 6 0 006 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a3 3 0 11-6 0h6z" />
                        </svg>
                        <span
                            class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-600 rounded-full border-2 border-white"></span>
                    </button>

                    <!-- User avatar -->
                    <div class="relative flex-shrink-0">
                        <button class="block w-10 h-10 overflow-hidden rounded-full bg-red-300">
                            <svg class="h-full w-full text-red-900" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM2 20v-1a6 6 0 0112 0v1H2z" />
                            </svg>
                        </button>
                        <span
                            class="absolute bottom-0 right-0 block w-3 h-3 bg-white border-2 border-red-900 rounded-full"></span>
                    </div>
                </div>
            </header>

            <!-- Welcome Banner -->
            <section
                class="bg-red-900 rounded-lg flex items-center justify-between p-8 shadow-md text-white min-h-[160px]">
                <div>
                    <p class="mb-2 text-sm">September 4, 2025</p>
                    <h2 class="text-3xl font-bold">Welcome back, Rona!</h2>
                    <p class="mt-1 max-w-md">Keep track of your grievance history and make sure your record stays clean.</p>
                </div>
                <!-- Placeholder for illustration -->
                <div class="w-40 h-40 relative ml-6">
                    <img src="/images/Sticker.png" alt="Admin Illustration" class="absolute inset-0 w-full h-full object-contain" />
                </div>
            </section>

            <!-- Summary and Profile -->
            <section class="flex flex-col lg:flex-row gap-6">
                <!-- Summary -->
                <div class="flex-1 space-y-4">
                    <h3 class="text-sm font-semibold mb-2">Summary</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Total Cases -->
                        <div class="rounded-lg bg-white shadow p-6">
                            <div class="flex items-center space-x-2 mb-1">
                                <p class="text-sm text-gray-600">Total Cases</p>
                                <span class="w-2 h-2 rounded-full bg-cyan-500 inline-block"></span>
                            </div>
                            <p class="text-5xl font-semibold text-red-900">2</p>
                        </div>
                        <!-- Active Cases -->
                        <div class="rounded-lg bg-white shadow p-6">
                            <div class="flex items-center space-x-2 mb-1">
                                <p class="text-sm text-gray-600">Active Cases</p>
                                <span class="w-2 h-2 rounded-full bg-orange-400 inline-block"></span>
                            </div>
                            <p class="text-5xl font-semibold text-black">1</p>
                        </div>
                        <!-- Resolved Cases -->
                        <div class="rounded-lg bg-white shadow p-6">
                            <div class="flex items-center space-x-2 mb-1">
                                <p class="text-sm text-gray-600">Resolved Cases</p>
                                <span class="w-2 h-2 rounded-full bg-green-400 inline-block"></span>
                            </div>
                            <p class="text-5xl font-semibold text-red-900">1</p>
                        </div>
                    </div>

                    <!-- My Grievances Table -->
                    <h3 class="text-sm font-semibold mt-8 mb-2">My Grievances</h3>
                    <div class="overflow-auto rounded-lg shadow">
                        <table class="min-w-full whitespace-nowrap divide-y divide-gray-200 table-fixed">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-700 cursor-pointer select-none">
                                        Case ID
                                    </th>
                                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-700 cursor-pointer select-none">
                                        Type
                                    </th>
                                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-700 cursor-pointer select-none">
                                        Status
                                    </th>
                                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-700 cursor-pointer select-none">
                                        Date
                                    </th>
                                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-700 cursor-pointer select-none">
                                        Remarks
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr class="bg-gray-50">
                                    <td class="py-3 px-4 text-sm font-mono">CASE-2025-003</td>
                                    <td class="py-3 px-4 text-sm">Spot Report</td>
                                    <td class="py-3 px-4 text-sm">
                                        <span
                                            class="px-2 py-1 text-xs bg-green-100 text-green-600 rounded-full font-semibold">Resolved</span>
                                    </td>
                                    <td class="py-3 px-4 text-sm">13/05/2025</td>
                                    <td class="py-3 px-4 text-sm whitespace-normal">Warning issued</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 text-sm font-mono">CASE-2025-002</td>
                                    <td class="py-3 px-4 text-sm">ARF</td>
                                    <td class="py-3 px-4 text-sm">
                                        <span
                                            class="px-2 py-1 text-xs bg-orange-100 text-orange-600 rounded-full font-semibold">Open</span>
                                    </td>
                                    <td class="py-3 px-4 text-sm">22/05/2025</td>
                                    <td class="py-3 px-4 text-sm whitespace-normal">Warning issued</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="py-3 px-4 text-sm font-mono">CASE-2025-001</td>
                                    <td class="py-3 px-4 text-sm">Spot Report</td>
                                    <td class="py-3 px-4 text-sm">
                                        <span
                                            class="px-2 py-1 text-xs bg-green-100 text-green-600 rounded-full font-semibold">Resolved</span>
                                    </td>
                                    <td class="py-3 px-4 text-sm">15/06/2025</td>
                                    <td class="py-3 px-4 text-sm whitespace-normal">For investigation</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 text-sm font-mono">CASE-2025-000</td>
                                    <td class="py-3 px-4 text-sm">Spot Report</td>
                                    <td class="py-3 px-4 text-sm">
                                        <span
                                            class="px-2 py-1 text-xs bg-green-100 text-green-600 rounded-full font-semibold">Resolved</span>
                                    </td>
                                    <td class="py-3 px-4 text-sm">06/09/2025</td>
                                    <td class="py-3 px-4 text-sm whitespace-normal">For investigation</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Profile -->
                <aside class="w-full max-w-sm rounded-lg bg-white shadow p-6 relative">
                    <!-- Top left and right red circles -->
                    <span
                        class="absolute w-3 h-3 bg-red-900 rounded-full top-4 left-4"
                        aria-hidden="true"></span>
                    <span
                        class="absolute w-3 h-3 bg-red-900 rounded-full top-4 right-4"
                        aria-hidden="true"></span>

                    <div class="flex flex-col items-center space-y-3">
                        <!-- Avatar with small icon bottom right -->
                        <div class="relative">
                            <div class="w-24 h-24 rounded-full bg-red-300 flex items-center justify-center overflow-hidden">
                                <svg class="w-20 h-20 text-red-900" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM10 15a4 4 0 00-4 4v1h8v-1a4 4 0 00-4-4z" />
                                </svg>
                            </div>
                            <div class="absolute bottom-0 right-0 bg-white rounded-full p-1 border border-gray-300">
                                <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15A7.9 7.9 0 0112 20a7.9 7.9 0 01-7.4-5"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="text-center">
                            <h4 class="font-semibold text-sm text-gray-900">Rona Arbe B. Limbago</h4>
                            <p class="text-xs text-gray-600">Student</p>
                        </div>

                        <div class="w-full border-t border-gray-200 pt-4 text-xs text-gray-700 space-y-4">
                            <div>
                                <p class="text-gray-500">Student ID</p>
                                <p class="text-red-900 font-mono text-sm">2022-00270</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Email address</p>
                                <p>rablimbago00270@usep.edu.ph</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Program</p>
                                <p>BSIT-IS</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Good Moral Status</p>
                                <p>--</p>
                            </div>
                        </div>
                    </div>

                    <a href="#"
                        class="block mt-6 text-xs text-red-900 font-semibold text-right hover:underline cursor-pointer">
                        Edit Profile &nbsp;&gt;
                    </a>
                </aside>
            </section>
        </main>
    </div>
</body>
</html>
