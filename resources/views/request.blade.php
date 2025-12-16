<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>OSAS Request System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite('resources/css/app.css')
    <style>
        /* Maroon theme colors */
        .focus-maroon:focus {
            border-color: #8B0000 !important;
        }

        .radio-maroon:checked {
            background-color: #8B0000;
            border-color: #8B0000;
        }

        .hover-maroon:hover {
            color: #8B0000;
        }

        /* Hide date input placeholder - keep it blank until date is selected */
        input[type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0;
            position: absolute;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        input[type="date"]::-webkit-datetime-edit-text,
        input[type="date"]::-webkit-datetime-edit-month-field,
        input[type="date"]::-webkit-datetime-edit-day-field,
        input[type="date"]::-webkit-datetime-edit-year-field {
            display: none;
        }

        input[type="date"]::-webkit-datetime-edit {
            display: none;
        }

        /* Show date value when it has been selected */
        input[type="date"]:valid::-webkit-datetime-edit {
            display: block;
        }

        input[type="date"]:valid::-webkit-datetime-edit-text,
        input[type="date"]:valid::-webkit-datetime-edit-month-field,
        input[type="date"]:valid::-webkit-datetime-edit-day-field,
        input[type="date"]:valid::-webkit-datetime-edit-year-field {
            display: inline;
            color: #111827;
        }

        /* Smooth floating label transitions */
        input.peer,
        textarea.peer {
            transition: border-color 300ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        label {
            transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        .error-border {
            border-color: #dc2626 !important;
        }

        .error-msg {
            font-size: 12px;
            color: #dc2626;
            margin-top: 4px;
            display: none;
            position: absolute;
            bottom: -20px;
            left: 0;
        }

        /* Ensure parent container has space for error message */
        .form-field-wrapper {
            position: relative;
            margin-bottom: 28px;
        }

        /* Add padding to form step containers to prevent error message cutoff */
        .form-step .relative {
            margin-bottom: 28px;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

    <header class="px-4 sm:px-6 bg-gray-50 border-b border-gray-300 flex flex-col sm:flex-row items-center justify-center sm:justify-between cursor-default gap-2 sm:gap-4 py-2">
        <img src="{{ asset('images/osas_logo.png') }}" alt="OSAS Logo" class="h-10 sm:h-14">
        <span class="text-gray-700 font-semibold text-base sm:text-lg text-center sm:text-left">
            Office of Student Affairs and Services
        </span>
    </header>

    <main class="flex-1 mt-12 mb-48 px-6">
        <!-- Removed container wrapper to place cards directly on the page background -->
        <div class="mb-9 text-center">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800">Welcome to OSAS Request System</h1>
            <p class="mt-2 text-sm sm:text-base text-gray-600">Streamline your requests for certificates and loans with our easy-to-use platform. Choose your option below to get started.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-4 max-w-4xl mx-auto">
            <!-- Good Moral -->
            <div class="option-card w-full p-6 rounded-xl text-center cursor-pointer transition transform bg-red-50 shadow hover:-translate-y-1 hover:shadow-lg hover:bg-red-100"
                style="border:2px solid #8B0000;" data-option="good-moral" tabindex="0" role="button" aria-pressed="false">
                <i class="fas fa-award text-5xl mb-3" style="color:#8B0000;"></i>
                <h3 class="text-xl font-bold mb-2" style="color:#8B0000;">Good Moral Certificate</h3>
                <p class="text-sm text-gray-600">Obtain an official certificate of good conduct for your academic or professional needs.</p>
                <span class="inline-block mt-4 px-2 py-0.5 text-xs font-semibold text-white rounded-full" style="background-color:#8B0000;">Quick Process</span>
            </div>

            <!-- Safe Loan -->
            <div class="option-card w-full p-6 rounded-xl text-center cursor-pointer transition transform bg-red-50 shadow hover:-translate-y-1 hover:shadow-lg hover:bg-red-100"
                style="border:2px solid #8B0000;" data-option="safe-loan-form" tabindex="0" role="button" aria-pressed="false">
                <i class="fas fa-hand-holding-usd text-5xl mb-3" style="color:#8B0000;"></i>
                <h3 class="text-xl font-bold mb-2" style="color:#8B0000;">Safe Loan Payment</h3>
                <p class="text-sm text-gray-600">Apply for a student loan with flexible terms and easy approval process.</p>
                <span class="inline-block mt-4 px-2 py-0.5 text-xs font-semibold text-white rounded-full" style="background-color:#8B0000;">Financial Aid</span>
            </div>
        </div>
        <footer class="fixed bottom-0 left-0 w-full bg-gray-100 text-center py-3 border-t border-gray-300 text-sm text-gray-600 z-50">
            <p>© 2025 Office of the Student Affairs and Services. All rights reserved.</p>
            <p>For inquiries, contact: <span style="color:#8B0000;">osas@usep.edu.ph</span></p>
        </footer>

        <!-- Form Modal (Multi-Step) -->
        <div id="good-moral-modal" class="modal fixed inset-0 hidden bg-black/50 z-50 items-center justify-center p-4">
            <div class="modal-content bg-white rounded-2xl p-8 shadow-2xl max-w-2xl w-full relative overflow-y-auto max-h-[90vh]">
                <button class="close-btn absolute top-4 right-4 text-2xl text-gray-400 hover:text-gray-600">&times;</button>

                <!-- Step Progress Indicator -->
                <div class="mb-8">
                    <div class="flex items-center justify-between max-w-md mx-auto">
                        <div class="step-indicator flex flex-col items-center" data-step="1">
                            <div class="step-circle w-10 h-10 rounded-full text-white flex items-center justify-center text-sm font-semibold mb-2" style="background-color: #8B0000;">1</div>
                            <span class="text-xs font-medium" style="color: #8B0000;">Step 1</span>
                        </div>
                        <div class="step-line flex-1 h-1 bg-gray-300 mx-2"></div>
                        <div class="step-indicator flex flex-col items-center" data-step="2">
                            <div class="step-circle w-10 h-10 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center text-sm font-semibold mb-2 text-gray-400">2</div>
                            <span class="text-xs font-medium text-gray-400">Step 2</span>
                        </div>
                        <div class="step-line flex-1 h-1 bg-gray-300 mx-2"></div>
                        <div class="step-indicator flex flex-col items-center" data-step="3">
                            <div class="step-circle w-10 h-10 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center text-sm font-semibold mb-2 text-gray-400">3</div>
                            <span class="text-xs font-medium text-gray-400">Step 3</span>
                        </div>
                    </div>
                </div>

                <form id="moral-form" class="space-y-6">
                    <!-- Step 1: Personal Information -->
                    <div class="form-step" data-step="1">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Personal Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-3 gap-y-3">
                            <div class="relative">
                                <input type="text" id="lastName" name="lastName" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="Last name" required>
                                <label for="lastName" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">Last name</label>
                            </div>

                            <div class="relative">
                                <input type="text" id="firstName" name="firstName" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="First name" required>
                                <label for="firstName" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">First name</label>
                            </div>

                            <div class="relative">
                                <input type="text" id="middleName" name="middleName" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="Middle name">
                                <label for="middleName" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">Middle name</label>
                            </div>

                            <div class="relative">
                                <input type="tel" id="contact" name="contact" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="Contact number" pattern="[0-9]{11}" maxlength="11" required>
                                <label for="contact" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">Contact number</label>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block mb-3 text-sm text-gray-600">Gender</label>
                                <div class="flex gap-x-6">
                                    <div class="flex">
                                        <input type="radio" name="gender" value="Female" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none" id="hs-radio-group-1" checked>
                                        <label for="hs-radio-group-1" class="text-sm text-gray-500 ms-2">Female</label>
                                    </div>

                                    <div class="flex">
                                        <input type="radio" name="gender" value="Male" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none" id="hs-radio-group-2">
                                        <label for="hs-radio-group-2" class="text-sm text-gray-500 ms-2">Male</label>
                                    </div>

                                    <div class="flex">
                                        <input type="radio" name="gender" value="Prefer not to say" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none" id="hs-radio-group-3">
                                        <label for="hs-radio-group-3" class="text-sm text-gray-500 ms-2">Prefer not to Say</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Academic Information -->
                    <div class="form-step hidden" data-step="2">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Academic Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-3 gap-y-3">

                            <div class="relative">
                                <!-- <input type="date" id="date" name="date" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 peer-valid:pt-6 peer-valid:pb-2 cursor-pointer" required> -->
                                <input type="date" id="date" name="date" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="Select date">
                                <label for="date" class="absolute top-0 start-0 p-4 h-full text-sm text-gray-500 truncate pointer-events-none transition ease-in-out duration-100 origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-400 peer-valid:scale-90 peer-valid:translate-x-0.5 peer-valid:-translate-y-1.5 peer-valid:text-gray-400">Select date</label>
                                <div class="absolute inset-y-0 end-0 flex items-center pe-4 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                                    </svg>
                                </div>
                            </div>

                            <div class="md:col-span-1 relative">
                                <select id="studentStatus" name="studentStatus" class="peer appearance-none p-4 pr-10 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2 peer-valid:text-gray-900 bg-white" onchange="toggleLastSemInput(this.value === 'not-enrolled')" required>
                                    <option value=""></option>
                                    <option value="currently-enrolled">Currently Enrolled</option>
                                    <option value="not-enrolled">Not Enrolled</option>
                                </select>
                                <label for="studentStatus" class="absolute top-0 start-0 p-4 h-full text-sm text-gray-500 truncate pointer-events-none transition ease-in-out duration-100 origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-400 peer-valid:scale-90 peer-valid:translate-x-0.5 peer-valid:-translate-y-1.5 peer-valid:text-gray-400">Student's Status</label>
                                <div class="absolute inset-y-0 end-0 flex items-center pe-4 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>

                            <!-- College Dropdown -->
                            <div class="md:col-span-1 relative">
                                <select id="college" name="college" class="peer appearance-none p-4 pr-10 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2 peer-valid:text-gray-900 bg-white" required>
                                    <option value=""></option>
                                    <!-- Dynamically loaded from database -->
                                </select>
                                <label for="college" class="absolute top-0 start-0 p-4 h-full text-sm text-gray-500 truncate pointer-events-none transition ease-in-out duration-100 origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-400 peer-valid:scale-90 peer-valid:translate-x-0.5 peer-valid:-translate-y-1.5 peer-valid:text-gray-400">College</label>
                                <div class="absolute inset-y-0 end-0 flex items-center pe-4 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Program -->
                            <div class="md:col-span-1 relative">
                                <select id="program" name="program" class="peer appearance-none p-4 pr-10 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2 peer-valid:text-gray-900 bg-white" required disabled>
                                    <option value=""></option>
                                </select>
                                <label for="program" class="absolute top-0 start-0 p-4 h-full text-sm text-gray-500 truncate pointer-events-none transition ease-in-out duration-100 origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-400 peer-valid:scale-90 peer-valid:translate-x-0.5 peer-valid:-translate-y-1.5 peer-valid:text-gray-400">Program</label>
                                <div class="absolute inset-y-0 end-0 flex items-center pe-4 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Year Level Dropdown -->
                            <div class="md:col-span-1 relative">
                                <select id="year" name="year" class="peer appearance-none p-4 pr-10 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2 peer-valid:text-gray-900 bg-white" required>
                                    <option value=""></option>
                                    <option value="1st Year">1st Year</option>
                                    <option value="2nd Year">2nd Year</option>
                                    <option value="3rd Year">3rd Year</option>
                                    <option value="4th Year">4th Year</option>
                                    <option value="5th Year">5th Year</option>
                                </select>
                                <label for="year" class="absolute top-0 start-0 p-4 h-full text-sm text-gray-500 truncate pointer-events-none transition ease-in-out duration-100 origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-400 peer-valid:scale-90 peer-valid:translate-x-0.5 peer-valid:-translate-y-1.5 peer-valid:text-gray-400">Year</label>
                                <div class="absolute inset-y-0 end-0 flex items-center pe-4 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Year Graduated -->
                            <div class="md:col-span-1 relative">
                                <input type="text" id="yearGraduated" name="yearGraduated" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="Year Graduated">
                                <label for="yearGraduated" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">Year Graduated</label>
                            </div>

                            <!-- Not Enrolled details: nested 3-column grid -->
                            <div class="md:col-span-2">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-3 gap-y-3">
                                    <!-- Last Sem (for Not Enrolled students) -->
                                    <div id="lastSemContainer" class="relative hidden">
                                        <input type="text" id="lastSem" name="lastSem" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="Last Sem">
                                        <label for="lastSem" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">Last Sem</label>
                                    </div>

                                    <!-- From SY (for Not Enrolled students) -->
                                    <div id="fromSYContainer" class="relative hidden">
                                        <input type="text" id="fromSY" name="fromSY" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="From SY">
                                        <label for="fromSY" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">From SY</label>
                                    </div>

                                    <!-- To SY (for Not Enrolled students) -->
                                    <div id="toSYContainer" class="relative hidden">
                                        <input type="text" id="toSY" name="toSY" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="To SY">
                                        <label for="toSY" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">To SY</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Contact & Purpose -->
                    <div class="form-step hidden" data-step="3">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Additional Information</h2>
                        <div class="space-y-3">
                            <div class="relative">
                                <input type="email" id="email" name="email" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="Email address" required>
                                <label for="email" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">Email address</label>
                            </div>

                            <div class="relative">
                                <textarea id="purpose" name="purpose" rows="4" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2 resize-none" placeholder="Purpose of request"></textarea>
                                <label for="purpose" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">Purpose of request</label>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between mt-6 pt-3">
                        <button type="button" id="prev-btn" class="px-8 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-all duration-200 hidden">
                            Back
                        </button>
                        <button type="button" id="next-btn" class="ml-auto px-16 py-3 text-white font-semibold rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105" style="background-color: #8B0000;">
                            Continue
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Payment Slip Modal (Good Moral) -->
        <div id="payment-slip-modal" class="modal fixed inset-0 hidden bg-black/50 z-50 items-center justify-center p-4">
            <div class="modal-content bg-gray-50 rounded-xl p-6 shadow-xl max-w-lg w-2/3 relative overflow-y-auto max-h-[80vh]">
                <button class="close-btn absolute top-3 right-3 text-xl text-gray-400 hover:text-red-600">&times;</button>
                <h2 class="text-lg font-bold mb-4 text-center" style="color:#8B0000;">Payment Slip</h2>
                <form id="payment-form" class="text-sm space-y-4">
                    <table class="w-full border border-gray-300 text-center text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border px-2 py-1">Description</th>
                                <th class="border px-2 py-1">Quantity</th>
                                <th class="border px-2 py-1">Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border px-2 py-1">Certificate of Good Moral Character (₱70.00/copy)</td>
                                <td class="border px-2 py-1">
                                    <input type="number" id="gm-qty" name="gm_qty" min="1" value="1" class="w-16 text-center border rounded">
                                </td>
                                <td class="border px-2 py-1" id="gm-cost">₱70.00</td>
                            </tr>
                            <tr>
                                <td class="border px-2 py-1">Safe Loan</td>
                                <td class="border px-2 py-1">-</td>
                                <td class="border px-2 py-1">₱0.00</td>
                            </tr>
                            <tr>
                                <td class="border px-2 py-1 font-semibold" colspan="2">Total Amount</td>
                                <td class="border px-2 py-1 font-bold" id="total-amount">₱70.00</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="flex justify-between mt-6">
                        <button type="button" id="back-btn" class="px-4 py-2 border font-semibold rounded-md shadow hover:bg-red-800 transition">
                            Back
                        </button>
                        <button type="submit" class="px-4 py-2 border font-semibold rounded-md shadow hover:bg-red-800 transition">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Hidden form to POST Good Moral request to backend -->
        <form id="gm-submit-form" action="{{ route('goodmoral.store') }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="date_needed" id="gm-date_needed">
            <input type="hidden" name="email" id="gm-email">
            <input type="hidden" name="contact" id="gm-contact">
            <input type="hidden" name="first_name" id="gm-first_name">
            <input type="hidden" name="middle_name" id="gm-middle_name">
            <input type="hidden" name="last_name" id="gm-last_name">
            <input type="hidden" name="gender" id="gm-gender">
            <input type="hidden" name="college" id="gm-college">
            <input type="hidden" name="program" id="gm-program">
            <input type="hidden" name="year" id="gm-year">
            <input type="hidden" name="student_status" id="gm-student_status">
            <input type="hidden" name="last_semester" id="gm-last_semester">
            <input type="hidden" name="from_sy" id="gm-from_sy">
            <input type="hidden" name="to_sy" id="gm-to_sy">
            <input type="hidden" name="year_graduated" id="gm-year_graduated">
            <input type="hidden" name="purpose" id="gm-purpose">
            <input type="hidden" name="copies" id="gm-copies" value="1">
        </form>

        <!-- Hidden form to POST Safe Loan request -->
        <form id="loan-submit-form" action="{{ route('safeloan.store') }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="date_needed" id="loan-date_needed">
            <input type="hidden" name="email" id="loan-email_hidden">
            <input type="hidden" name="contact" id="loan-contact_hidden">
            <input type="hidden" name="first_name" id="loan-first_name_hidden">
            <input type="hidden" name="middle_name" id="loan-middle_name_hidden">
            <input type="hidden" name="last_name" id="loan-last_name_hidden">
            <input type="hidden" name="gender" id="loan-gender_hidden">
            <input type="hidden" name="college" id="loan-college_hidden">
            <input type="hidden" name="program" id="loan-program_hidden">
            <input type="hidden" name="year" id="loan-year_hidden">
            <input type="hidden" name="student_status" id="loan-student_status_hidden">
            <input type="hidden" name="last_semester" id="loan-last_semester_hidden">
            <input type="hidden" name="from_sy" id="loan-from_sy_hidden">
            <input type="hidden" name="to_sy" id="loan-to_sy_hidden">
            <input type="hidden" name="year_graduated" id="loan-year_graduated_hidden">
            <input type="hidden" name="purpose" id="loan-purpose_hidden">
            <input type="hidden" name="loan_amount" id="loan-loan_amount_hidden" value="0">
        </form>

        <!-- Payment Slip Modal (Safe Loan) -->
        <div id="payment-slip-loan-modal" class="modal fixed inset-0 hidden bg-black/50 z-50 items-center justify-center p-4">
            <div class="modal-content bg-gray-50 rounded-xl p-6 shadow-xl max-w-lg w-2/3 relative overflow-y-auto max-h-[80vh]">
                <button class="close-btn absolute top-3 right-3 text-xl text-gray-400 hover:text-red-600">&times;</button>
                <h2 class="text-lg font-bold mb-4 text-center" style="color:#8B0000;">Payment Slip</h2>
                <form id="payment-loan-form" class="text-sm space-y-4">
                    <table class="w-full border border-gray-300 text-center text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border px-2 py-1">Description</th>
                                <th class="border px-2 py-1">Quantity</th>
                                <th class="border px-2 py-1">Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border px-2 py-1">Certificate of Good Moral Character (₱70.00/copy)</td>
                                <td class="border px-2 py-1">-</td>
                                <td class="border px-2 py-1">₱0.00</td>
                            </tr>
                            <tr>
                                <td class="border px-2 py-1">Safe Loan</td>
                                <td class="border px-2 py-1">-</td>
                                <td class="border px-2 py-1">
                                    <input type="number" id="loan-amount" name="loan_amount" min="0" value="0" class="w-24 text-center border rounded" step="0.01">
                                </td>
                            </tr>
                            <tr>
                                <td class="border px-2 py-1 font-semibold" colspan="2">Total Amount</td>
                                <td class="border px-2 py-1 font-bold" id="loan-total-amount">₱0.00</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="flex justify-between mt-6">
                        <button type="button" id="loan-back-btn" class="px-4 py-2 border font-semibold rounded-md shadow hover:bg-red-800 transition">
                            Back
                        </button>
                        <button type="submit" class="px-4 py-2 border font-semibold rounded-md shadow hover:bg-red-800 transition">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>



        <!-- Safe Loan Instructions Modal -->
        <div id="safe-loan-instructions-modal" class="modal fixed inset-0 hidden bg-black/50 z-50 items-center justify-center p-4">
            <div class="modal-content bg-gray-50 rounded-xl p-6 shadow-xl max-w-2xl w-2/3 relative overflow-y-auto max-h-[80vh]">
                <button class="close-btn absolute top-3 right-3 text-xl text-gray-400 hover:text-red-600">&times;</button>
                <h2 class="text-lg font-bold mb-6 text-center" style="color:#8B0000;">Loan Instructions</h2>
                <div class="text-sm text-gray-700 px-2 sm:px-6">
                    <p class="text-center font-medium mb-6">
                        Please be advised that the Safe Loan Application is processed through the OSAS office. Kindly follow the steps below:
                    </p>
                    <ol class="list-decimal list-inside space-y-4">
                        <li>The applicant/student should apply directly to the Office of Student Services (Obrero Campus).</li>
                        <li>The applicant must submit a formal letter to the Screening and Scholarship Committee, which will assess eligibility and grant the loan if qualified.</li>
                        <li>
                            The Screening and Scholarship Committee shall consider the following documents to be submitted by the applicant/student:
                            <ul class="list-disc list-inside ml-6 mt-3 space-y-2">
                                <li>Medical Certificate</li>
                                <li>Grades of the previous semester</li>
                                <li>Income Tax return of Parents / Affidavit of No Income</li>
                                <li>Recommendation from the adviser/teacher</li>
                                <li>Recommendation from the guidance counselor</li>
                            </ul>
                        </li>
                    </ol>
                    <p class="mt-6 text-left font-bold" style="color:#8B0000;">
                        Reminder: APPLICANTS WITH INCOMPLETE REQUIREMENTS CAN'T PROCEED WITH THE APPLICATION.
                    </p>
                </div>
                <div class="flex justify-end mt-8">
                    <button type="button" id="open-loan-form-btn" class="px-6 py-2 border font-semibold rounded-md shadow hover:bg-red-800 transition" style="background-color:#8B0000; color:white; border-color:#8B0000;">
                        Proceed to Form
                    </button>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div id="success-modal" class="modal fixed inset-0 hidden bg-black/50 z-50 items-center justify-center p-4">
            <div class="modal-content bg-white rounded-2xl p-8 shadow-2xl max-w-md w-full relative text-center">
                <button class="close-btn absolute top-4 right-4 text-2xl text-gray-400 hover:text-gray-600">&times;</button>

                <!-- Success Icon -->
                <div class="mb-6 flex justify-center">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-green-500">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>

                <!-- Success Message -->
                <h2 class="text-2xl font-bold mb-3 text-gray-800">Request Submitted!</h2>
                <p class="text-gray-600 mb-6">
                    Thank you for your request. Our staff will review and process it shortly.
                    Please wait for confirmation from the Office of Student Affairs and Services.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <button type="button" id="view-slip-btn" class="px-6 py-2.5 font-semibold rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5" style="background-color:#8B0000; color:white;">
                        <i class="fas fa-file-alt mr-2"></i>View Receipt
                    </button>
                    <button type="button" class="close-btn px-6 py-2.5 bg-gray-200 text-gray-700 font-semibold rounded-lg shadow-md hover:bg-gray-300 transition">
                        Close
                    </button>
                </div>
            </div>
        </div>

        <!-- Safe Loan Modal (Form) -->
        <div id="safe-loan-form-modal" class="modal fixed inset-0 hidden bg-black/50 z-50 items-center justify-center p-4">
            <div class="modal-content bg-gray-50 rounded-xl p-6 shadow-xl max-w-2xl w-2/3 relative overflow-y-auto max-h-[80vh]">
                <button class="close-btn absolute top-3 right-3 text-xl text-gray-400 hover:text-red-600">&times;</button>
                <h2 class="text-lg font-bold mb-4 text-center" style="color:#8B0000;">Safe Loan Payment</h2>
                <!-- Step Progress Indicator (Loan) -->
                <div class="mb-8">
                    <div class="flex items-center justify-between max-w-md mx-auto">
                        <div class="loan-step-indicator flex flex-col items-center" data-step="1">
                            <div class="loan-step-circle w-10 h-10 rounded-full text-white flex items-center justify-center text-sm font-semibold mb-2" style="background-color: #8B0000;">1</div>
                            <span class="text-xs font-medium" style="color: #8B0000;">Step 1</span>
                        </div>
                        <div class="loan-step-line flex-1 h-1 bg-gray-300 mx-2"></div>
                        <div class="loan-step-indicator flex flex-col items-center" data-step="2">
                            <div class="loan-step-circle w-10 h-10 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center text-sm font-semibold mb-2 text-gray-400">2</div>
                            <span class="text-xs font-medium text-gray-400">Step 2</span>
                        </div>
                        <div class="loan-step-line flex-1 h-1 bg-gray-300 mx-2"></div>
                        <div class="loan-step-indicator flex flex-col items-center" data-step="3">
                            <div class="loan-step-circle w-10 h-10 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center text-sm font-semibold mb-2 text-gray-400">3</div>
                            <span class="text-xs font-medium text-gray-400">Step 3</span>
                        </div>
                    </div>
                </div>

                <form id="safe-loan-form" class="space-y-6">
                    <!-- Loan Step 1: Personal Information -->
                    <div class="loan-form-step" data-step="1">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Personal Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-3 gap-y-3">
                            <div class="relative">
                                <input type="text" id="loanLastName" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="Last name" required>
                                <label for="loanLastName" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">Last name</label>
                            </div>
                            <div class="relative">
                                <input type="text" id="loanFirstName" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="First name" required>
                                <label for="loanFirstName" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">First name</label>
                            </div>
                            <div class="relative">
                                <input type="text" id="loanMiddleName" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="Middle name">
                                <label for="loanMiddleName" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">Middle name</label>
                            </div>
                            <div class="relative">
                                <input type="tel" id="loanContact" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="Contact number" pattern="[0-9]{11}" maxlength="11" required>
                                <label for="loanContact" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">Contact number</label>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block mb-3 text-sm text-gray-600">Gender</label>
                                <div class="flex gap-x-6">
                                    <div class="flex">
                                        <input type="radio" name="loanGender" value="Female" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500" id="loan-radio-group-1" checked>
                                        <label for="loan-radio-group-1" class="text-sm text-gray-500 ms-2">Female</label>
                                    </div>
                                    <div class="flex">
                                        <input type="radio" name="loanGender" value="Male" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500" id="loan-radio-group-2">
                                        <label for="loan-radio-group-2" class="text-sm text-gray-500 ms-2">Male</label>
                                    </div>
                                    <div class="flex">
                                        <input type="radio" name="loanGender" value="Prefer not to say" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500" id="loan-radio-group-3">
                                        <label for="loan-radio-group-3" class="text-sm text-gray-500 ms-2">Prefer not to Say</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Loan Step 2: Academic Information -->
                    <div class="loan-form-step hidden" data-step="2">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Academic Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-3 gap-y-3">
                            <div class="relative">
                                <input type="date" id="loanDate" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="Select date">
                                <label for="loanDate" class="absolute top-0 start-0 p-4 h-full text-sm text-gray-500 truncate pointer-events-none transition ease-in-out duration-100 origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-400 peer-valid:scale-90 peer-valid:translate-x-0.5 peer-valid:-translate-y-1.5 peer-valid:text-gray-400">Select date</label>
                                <div class="absolute inset-y-0 end-0 flex items-center pe-4 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                                    </svg>
                                </div>
                            </div>

                            <div class="md:col-span-1 relative">
                                <select id="loanStudentStatus" class="peer appearance-none p-4 pr-10 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2 peer-valid:text-gray-900 bg-white" onchange="toggleLoanLastSemInput(this.value === 'not-enrolled')" required>
                                    <option value=""></option>
                                    <option value="currently-enrolled">Currently Enrolled</option>
                                    <option value="not-enrolled">Not Enrolled</option>
                                </select>
                                <label for="loanStudentStatus" class="absolute top-0 start-0 p-4 h-full text-sm text-gray-500 truncate pointer-events-none transition ease-in-out duration-100 origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-400 peer-valid:scale-90 peer-valid:translate-x-0.5 peer-valid:-translate-y-1.5 peer-valid:text-gray-400">Student's Status</label>
                                <div class="absolute inset-y-0 end-0 flex items-center pe-4 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>

                            <!-- College Dropdown -->
                            <div class="md:col-span-1 relative">
                                <select id="loanCollege" class="peer appearance-none p-4 pr-10 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2 peer-valid:text-gray-900 bg-white" required>
                                    <option value=""></option>
                                    <!-- Dynamically loaded from database -->
                                </select>
                                <label for="loanCollege" class="absolute top-0 start-0 p-4 h-full text-sm text-gray-500 truncate pointer-events-none transition ease-in-out duration-100 origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-400 peer-valid:scale-90 peer-valid:translate-x-0.5 peer-valid:-translate-y-1.5 peer-valid:text-gray-400">College</label>
                                <div class="absolute inset-y-0 end-0 flex items-center pe-4 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Program -->
                            <div class="md:col-span-1 relative">
                                <select id="loanProgram" class="peer appearance-none p-4 pr-10 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2 peer-valid:text-gray-900 bg-white" required disabled>
                                    <option value=""></option>
                                </select>
                                <label for="loanProgram" class="absolute top-0 start-0 p-4 h-full text-sm text-gray-500 truncate pointer-events-none transition ease-in-out duration-100 origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-400 peer-valid:scale-90 peer-valid:translate-x-0.5 peer-valid:-translate-y-1.5 peer-valid:text-gray-400">Program</label>
                                <div class="absolute inset-y-0 end-0 flex items-center pe-4 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Year Level Dropdown -->
                            <div class="md:col-span-1 relative">
                                <select id="loanYear" class="peer appearance-none p-4 pr-10 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2 peer-valid:text-gray-900 bg-white" required>
                                    <option value=""></option>
                                    <option value="1st Year">1st Year</option>
                                    <option value="2nd Year">2nd Year</option>
                                    <option value="3rd Year">3rd Year</option>
                                    <option value="4th Year">4th Year</option>
                                    <option value="5th Year">5th Year</option>
                                </select>
                                <label for="loanYear" class="absolute top-0 start-0 p-4 h-full text-sm text-gray-500 truncate pointer-events-none transition ease-in-out duration-100 origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-400 peer-valid:scale-90 peer-valid:translate-x-0.5 peer-valid:-translate-y-1.5 peer-valid:text-gray-400">Year</label>
                                <div class="absolute inset-y-0 end-0 flex items-center pe-4 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Year Graduated -->
                            <div class="md:col-span-1 relative">
                                <input type="text" id="loanYearGraduated" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="Year Graduated">
                                <label for="loanYearGraduated" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">Year Graduated</label>
                            </div>

                            <!-- Not Enrolled details: nested 3-column grid -->
                            <div class="md:col-span-2">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-3 gap-y-3">
                                    <!-- Last Sem (for Not Enrolled students) -->
                                    <div id="loanLastSemContainer" class="relative hidden">
                                        <input type="text" id="loanLastSem" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="Last Sem">
                                        <label for="loanLastSem" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">Last Sem</label>
                                    </div>

                                    <!-- From SY (for Not Enrolled students) -->
                                    <div id="loanFromSYContainer" class="relative hidden">
                                        <input type="text" id="loanFromSY" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="From SY">
                                        <label for="loanFromSY" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">From SY</label>
                                    </div>

                                    <!-- To SY (for Not Enrolled students) -->
                                    <div id="loanToSYContainer" class="relative hidden">
                                        <input type="text" id="loanToSY" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="To SY">
                                        <label for="loanToSY" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">To SY</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Loan Step 3: Additional Information -->
                    <div class="loan-form-step hidden" data-step="3">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Additional Information</h2>
                        <div class="space-y-3">
                            <div class="relative">
                                <input type="email" id="loanEmail" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2" placeholder="Email address" required>
                                <label for="loanEmail" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">Email address</label>
                            </div>
                            <div class="relative">
                                <textarea id="loanPurpose" rows="4" class="peer p-4 block w-full border border-gray-300 rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-0 focus:outline-none focus:pt-6 focus:pb-2 [&:not(:placeholder-shown)]:pt-6 [&:not(:placeholder-shown)]:pb-2 resize-none" placeholder="Purpose of request"></textarea>
                                <label for="loanPurpose" class="absolute top-0 start-0 p-4 h-full text-gray-500 text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent origin-[0_0] peer-focus:scale-90 peer-focus:translate-x-0.5 peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:scale-90 peer-[:not(:placeholder-shown)]:translate-x-0.5 peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500">Purpose of request</label>
                            </div>
                        </div>
                    </div>
                    <!-- Loan Navigation Buttons -->
                    <div class="flex justify-between mt-6 pt-3">
                        <button type="button" id="loan-prev-btn" class="px-8 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-all duration-200 hidden">Back</button>
                        <button type="button" id="loan-next-btn" class="ml-auto px-16 py-3 text-white font-semibold rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105" style="background-color: #8B0000;">Continue</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Track which type of request was submitted for view slip button
                let lastSubmittedType = null;

                // Check for success message from Laravel session
                @if(session('success'))
                window.lastPdfUrl = @json(session('pdf_url'));
                lastSubmittedType = @json(session('success'));
                // Show success modal
                const successModal = document.getElementById('success-modal');
                if (successModal) {
                    successModal.classList.remove('hidden');
                    successModal.classList.add('flex');
                }
                @endif

                // Prevent non-numeric input in contact fields
                const contactInputs = document.querySelectorAll('#contact, #loanContact');
                contactInputs.forEach(input => {
                    input.addEventListener('input', function(e) {
                        // Remove any non-numeric characters
                        this.value = this.value.replace(/[^0-9]/g, '');
                        // Limit to 11 digits
                        if (this.value.length > 11) {
                            this.value = this.value.slice(0, 11);
                        }
                    });
                    // Prevent pasting non-numeric content
                    input.addEventListener('paste', function(e) {
                        e.preventDefault();
                        const pastedText = (e.clipboardData || window.clipboardData).getData('text');
                        const numericOnly = pastedText.replace(/[^0-9]/g, '').slice(0, 11);
                        this.value = numericOnly;
                    });
                });

                const optionCards = document.querySelectorAll('.option-card');
                const modals = {
                    'good-moral': document.getElementById('good-moral-modal'),
                    'safe-loan-instructions': document.getElementById('safe-loan-instructions-modal'),
                    'safe-loan-form': document.getElementById('safe-loan-form-modal'),
                    'payment-slip': document.getElementById('payment-slip-modal'),
                    'payment-slip-loan': document.getElementById('payment-slip-loan-modal'),
                    'success': document.getElementById('success-modal')
                };

                // Set default date to today for both forms
                const today = new Date().toISOString().split('T')[0];
                document.getElementById('date').value = today;
                document.getElementById('loanDate').value = today;

                // Dynamic College and Program Loading
                const collegeSelect = document.getElementById('college');
                const programSelect = document.getElementById('program');

                // Load colleges on page load
                async function loadColleges() {
                    try {
                        const response = await fetch('/api/colleges');
                        const colleges = await response.json();

                        collegeSelect.innerHTML = '<option value=""></option>';
                        colleges.forEach(college => {
                            const option = document.createElement('option');
                            option.value = college.name;
                            option.dataset.collegeId = college.id;
                            option.textContent = college.name;
                            collegeSelect.appendChild(option);
                        });
                    } catch (error) {
                        console.error('Error loading colleges:', error);
                    }
                }

                // Load programs when college is selected
                collegeSelect.addEventListener('change', async function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const collegeId = selectedOption.dataset.collegeId;

                    if (!collegeId) {
                        programSelect.innerHTML = '<option value=""></option>';
                        programSelect.disabled = true;
                        return;
                    }

                    try {
                        const response = await fetch(`/api/programs/${collegeId}`);
                        const programs = await response.json();

                        programSelect.innerHTML = '<option value=""></option>';
                        programs.forEach(program => {
                            const option = document.createElement('option');
                            option.value = program.name;
                            option.textContent = program.name;
                            programSelect.appendChild(option);
                        });
                        programSelect.disabled = false;
                    } catch (error) {
                        console.error('Error loading programs:', error);
                        programSelect.innerHTML = '<option value="">Error loading programs</option>';
                    }
                });

                // Initialize colleges on load
                loadColleges();

                // Dynamic College and Program Loading for Loan Form
                const loanCollegeSelect = document.getElementById('loanCollege');
                const loanProgramSelect = document.getElementById('loanProgram');

                // Load colleges for loan form (shares same data source)
                async function loadLoanColleges() {
                    try {
                        const response = await fetch('/api/colleges');
                        const colleges = await response.json();

                        loanCollegeSelect.innerHTML = '<option value=""></option>';
                        colleges.forEach(college => {
                            const option = document.createElement('option');
                            option.value = college.name;
                            option.dataset.collegeId = college.id;
                            option.textContent = college.name;
                            loanCollegeSelect.appendChild(option);
                        });
                    } catch (error) {
                        console.error('Error loading colleges:', error);
                    }
                }

                // Load programs when college is selected (loan form)
                loanCollegeSelect.addEventListener('change', async function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const collegeId = selectedOption.dataset.collegeId;

                    if (!collegeId) {
                        loanProgramSelect.innerHTML = '<option value=""></option>';
                        loanProgramSelect.disabled = true;
                        return;
                    }

                    try {
                        const response = await fetch(`/api/programs/${collegeId}`);
                        const programs = await response.json();

                        loanProgramSelect.innerHTML = '<option value=""></option>';
                        programs.forEach(program => {
                            const option = document.createElement('option');
                            option.value = program.name;
                            option.textContent = program.name;
                            loanProgramSelect.appendChild(option);
                        });
                        loanProgramSelect.disabled = false;
                    } catch (error) {
                        console.error('Error loading programs:', error);
                        loanProgramSelect.innerHTML = '<option value="">Error loading programs</option>';
                    }
                });

                // Initialize loan colleges on load
                loadLoanColleges();

                // Toggle Last Sem input based on student status
                window.toggleLastSemInput = function(show) {
                    const lastSemContainer = document.getElementById('lastSemContainer');
                    const fromSYContainer = document.getElementById('fromSYContainer');
                    const toSYContainer = document.getElementById('toSYContainer');
                    const lastSemInput = document.getElementById('lastSem');
                    const fromSYInput = document.getElementById('fromSY');
                    const toSYInput = document.getElementById('toSY');

                    if (show) {
                        lastSemContainer.classList.remove('hidden');
                        fromSYContainer.classList.remove('hidden');
                        toSYContainer.classList.remove('hidden');
                        lastSemInput.required = true;
                        fromSYInput.required = true;
                        toSYInput.required = true;
                    } else {
                        lastSemContainer.classList.add('hidden');
                        fromSYContainer.classList.add('hidden');
                        toSYContainer.classList.add('hidden');
                        lastSemInput.required = false;
                        fromSYInput.required = false;
                        toSYInput.required = false;
                        lastSemInput.value = '';
                        fromSYInput.value = '';
                        toSYInput.value = '';
                    }
                };

                // Multi-step form navigation
                let currentStep = 1;
                const totalSteps = 3;

                function updateStepDisplay() {
                    // Hide all steps
                    document.querySelectorAll('.form-step').forEach(step => {
                        step.classList.add('hidden');
                    });

                    // Show current step
                    const currentStepEl = document.querySelector(`.form-step[data-step="${currentStep}"]`);
                    if (currentStepEl) {
                        currentStepEl.classList.remove('hidden');
                    }

                    // Update progress indicators
                    document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
                        const stepNum = index + 1;
                        const circle = indicator.querySelector('.step-circle');
                        const label = indicator.querySelector('span');
                        const line = indicator.nextElementSibling;

                        if (stepNum < currentStep) {
                            // Completed step
                            circle.classList.remove('border-2', 'border-gray-300', 'bg-white', 'text-gray-400');
                            circle.classList.add('text-white');
                            circle.style.backgroundColor = '#8B0000';
                            circle.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                            label.classList.remove('text-gray-400');
                            label.style.color = '#8B0000';
                            if (line && line.classList.contains('step-line')) {
                                line.style.backgroundColor = '#8B0000';
                            }
                        } else if (stepNum === currentStep) {
                            // Current step
                            circle.classList.remove('border-gray-300', 'text-gray-400');
                            circle.classList.add('text-white');
                            circle.style.backgroundColor = '#8B0000';
                            circle.style.borderColor = '#8B0000';
                            circle.textContent = stepNum;
                            label.classList.remove('text-gray-400');
                            label.style.color = '#8B0000';
                        } else {
                            // Future step
                            circle.classList.remove('text-white');
                            circle.classList.add('border-2', 'border-gray-300', 'bg-white', 'text-gray-400');
                            circle.style.backgroundColor = '';
                            circle.style.borderColor = '';
                            circle.textContent = stepNum;
                            label.classList.add('text-gray-400');
                            label.style.color = '';
                            if (line && line.classList.contains('step-line')) {
                                line.style.backgroundColor = '';
                            }
                        }
                    });

                    // Update buttons
                    const prevBtn = document.getElementById('prev-btn');
                    const nextBtn = document.getElementById('next-btn');

                    if (currentStep === 1) {
                        prevBtn.classList.add('hidden');
                    } else {
                        prevBtn.classList.remove('hidden');
                    }

                    if (currentStep === totalSteps) {
                        nextBtn.textContent = 'Submit';
                    } else {
                        nextBtn.textContent = 'Continue';
                    }

                    // Attach field listeners for validation on input
                    attachStepFieldListeners();
                }

                function showFieldError(input, msg) {
                    input.classList.add('error-border');
                    let em = input.parentElement.querySelector('.error-msg');
                    if (!em) {
                        em = document.createElement('div');
                        em.className = 'error-msg';
                        input.parentElement.appendChild(em);
                    }
                    em.textContent = msg;
                    em.style.display = 'block';
                }

                function clearFieldError(input) {
                    input.classList.remove('error-border');
                    const em = input.parentElement.querySelector('.error-msg');
                    if (em) em.style.display = 'none';
                }

                function validateCurrentStep() {
                    let valid = true;
                    const stepEl = document.querySelector(`.form-step[data-step="${currentStep}"]`);
                    if (!stepEl) return true;
                    const requiredInputs = stepEl.querySelectorAll('input[required], select[required], textarea[required]');
                    requiredInputs.forEach(inp => {
                        // Skip radio buttons in this loop - check them separately
                        if (inp.type === 'radio') return;

                        if (!inp.value || inp.value.trim() === '') {
                            valid = false;
                        }
                    });

                    // Check radio button groups separately
                    const radioGroups = {};
                    stepEl.querySelectorAll('input[type="radio"]').forEach(radio => {
                        if (!radioGroups[radio.name]) {
                            radioGroups[radio.name] = stepEl.querySelector(`input[name="${radio.name}"]:checked`);
                        }
                    });

                    // If any radio group exists and none is checked, invalid
                    for (const groupName in radioGroups) {
                        if (!radioGroups[groupName]) {
                            valid = false;
                            break;
                        }
                    }

                    // Special case: if student status is not-enrolled ensure lastSem when step 2
                    if (currentStep === 2) {
                        const status = document.getElementById('studentStatus').value;
                        if (status === 'not-enrolled') {
                            const lastSem = document.getElementById('lastSem');
                            if (!lastSem.value.trim()) {
                                valid = false;
                            }
                        }
                    }
                    return valid;
                }

                function showValidationErrors() {
                    const stepEl = document.querySelector(`.form-step[data-step="${currentStep}"]`);
                    if (!stepEl) return;
                    const requiredInputs = stepEl.querySelectorAll('input[required], select[required], textarea[required]');
                    requiredInputs.forEach(inp => {
                        clearFieldError(inp);
                        if (!inp.value || (inp.type === 'radio' && !stepEl.querySelector(`input[name="${inp.name}"]:checked`))) {
                            showFieldError(inp, 'Required');
                        }
                    });
                    if (currentStep === 2) {
                        const status = document.getElementById('studentStatus').value;
                        if (status === 'not-enrolled') {
                            const lastSem = document.getElementById('lastSem');
                            clearFieldError(lastSem);
                            if (!lastSem.value.trim()) {
                                showFieldError(lastSem, 'Required');
                            }
                        }
                    }
                }

                function attachStepFieldListeners() {
                    const stepEl = document.querySelector(`.form-step[data-step="${currentStep}"]`);
                    if (!stepEl) return;
                    // Attach to ALL inputs, not just required ones
                    const allInputs = stepEl.querySelectorAll('input, select, textarea');
                    allInputs.forEach(inp => {
                        if (!inp.dataset.listenerAttached) {
                            const evt = (inp.tagName === 'SELECT' || inp.type === 'radio') ? 'change' : 'input';
                            inp.addEventListener(evt, () => {
                                clearFieldError(inp); // remove error when user types
                            });
                            inp.dataset.listenerAttached = '1';
                        }
                    });
                }

                // Next button
                document.getElementById('next-btn').addEventListener('click', function() {
                    if (!validateCurrentStep()) {
                        showValidationErrors(); // Only show errors when user tries to proceed
                        return;
                    }
                    if (currentStep < totalSteps) {
                        currentStep++;
                        updateStepDisplay();
                    } else {
                        // On last step, proceed to payment
                        closeModal(modals['good-moral']);
                        openModal('payment-slip');
                    }
                });

                // Previous button
                document.getElementById('prev-btn').addEventListener('click', function() {
                    if (currentStep > 1) {
                        currentStep--;
                        updateStepDisplay();
                    }
                });

                // Reset step when modal opens
                optionCards.forEach(card => {
                    if (card.dataset.option === 'safe-loan-form') {
                        card.addEventListener('click', () => openModal('safe-loan-instructions'));
                    } else if (card.dataset.option === 'good-moral') {
                        card.addEventListener('click', () => {
                            currentStep = 1;
                            updateStepDisplay();
                            openModal('good-moral');
                        });
                    } else {
                        card.addEventListener('click', () => openModal(card.dataset.option));
                    }
                });

                // Safe Loan: Proceed to Application button
                document.getElementById('open-loan-form-btn').addEventListener('click', () => {
                    closeModal(modals['safe-loan-instructions']);
                    currentLoanStep = 1;
                    updateLoanStepDisplay();
                    openModal('safe-loan-form');
                });

                document.querySelectorAll('.close-btn').forEach(btn => {
                    btn.addEventListener('click', () => closeModal(btn.closest('.modal')));
                });

                document.querySelectorAll('.ok-btn').forEach(btn => {
                    btn.addEventListener('click', () => closeModal(btn.closest('.modal')));
                });

                // Removed click-outside-to-close feature to prevent accidental closing
                // Users must use the X button or Back button to close modals

                // Good Moral Payment Slip: Back button
                document.getElementById('back-btn').addEventListener('click', () => {
                    closeModal(modals['payment-slip']);
                    currentStep = totalSteps; // Return to last step of form
                    updateStepDisplay();
                    openModal('good-moral');
                });

                // Safe Loan: Proceed to Payment Slip after form
                // Loan multi-step navigation
                let currentLoanStep = 1;
                const totalLoanSteps = 3;

                function updateLoanStepDisplay() {
                    document.querySelectorAll('.loan-form-step').forEach(step => step.classList.add('hidden'));
                    const currentLoanStepEl = document.querySelector(`.loan-form-step[data-step="${currentLoanStep}"]`);
                    if (currentLoanStepEl) currentLoanStepEl.classList.remove('hidden');

                    document.querySelectorAll('.loan-step-indicator').forEach((indicator, index) => {
                        const stepNum = index + 1;
                        const circle = indicator.querySelector('.loan-step-circle');
                        const label = indicator.querySelector('span');
                        const line = indicator.nextElementSibling;
                        if (stepNum < currentLoanStep) {
                            circle.classList.remove('border-2', 'border-gray-300', 'bg-white', 'text-gray-400');
                            circle.classList.add('text-white');
                            circle.style.backgroundColor = '#8B0000';
                            circle.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
                            label.classList.remove('text-gray-400');
                            label.style.color = '#8B0000';
                            if (line && line.classList.contains('loan-step-line')) line.style.backgroundColor = '#8B0000';
                        } else if (stepNum === currentLoanStep) {
                            circle.classList.remove('border-gray-300', 'text-gray-400');
                            circle.classList.add('text-white');
                            circle.style.backgroundColor = '#8B0000';
                            circle.style.borderColor = '#8B0000';
                            circle.textContent = stepNum;
                            label.classList.remove('text-gray-400');
                            label.style.color = '#8B0000';
                        } else {
                            circle.classList.remove('text-white');
                            circle.classList.add('border-2', 'border-gray-300', 'bg-white', 'text-gray-400');
                            circle.style.backgroundColor = '';
                            circle.style.borderColor = '';
                            circle.textContent = stepNum;
                            label.classList.add('text-gray-400');
                            label.style.color = '';
                            if (line && line.classList.contains('loan-step-line')) line.style.backgroundColor = '';
                        }
                    });

                    const loanPrevBtn = document.getElementById('loan-prev-btn');
                    const loanNextBtn = document.getElementById('loan-next-btn');
                    if (currentLoanStep === 1) loanPrevBtn.classList.add('hidden');
                    else loanPrevBtn.classList.remove('hidden');
                    loanNextBtn.textContent = currentLoanStep === totalLoanSteps ? 'Submit' : 'Continue';
                    attachLoanStepFieldListeners();
                }

                function validateLoanCurrentStep() {
                    let valid = true;
                    const stepEl = document.querySelector(`.loan-form-step[data-step="${currentLoanStep}"]`);
                    if (!stepEl) return true;
                    const requiredInputs = stepEl.querySelectorAll('input[required], select[required], textarea[required]');
                    requiredInputs.forEach(inp => {
                        if (!inp.value) {
                            valid = false;
                        }
                    });
                    if (currentLoanStep === 2) {
                        const status = document.getElementById('loanStudentStatus').value;
                        if (status === 'not-enrolled') {
                            const lastSem = document.getElementById('loanLastSem');
                            if (!lastSem.value.trim()) {
                                valid = false;
                            }
                        }
                    }
                    return valid;
                }

                function showLoanValidationErrors() {
                    const stepEl = document.querySelector(`.loan-form-step[data-step="${currentLoanStep}"]`);
                    if (!stepEl) return;
                    const requiredInputs = stepEl.querySelectorAll('input[required], select[required], textarea[required]');
                    requiredInputs.forEach(inp => {
                        inp.classList.remove('error-border');
                        let em = inp.parentElement.querySelector('.error-msg');
                        if (em) em.style.display = 'none';
                        if (!inp.value) {
                            inp.classList.add('error-border');
                            if (!em) {
                                em = document.createElement('div');
                                em.className = 'error-msg';
                                inp.parentElement.appendChild(em);
                            }
                            em.textContent = 'Required';
                            em.style.display = 'block';
                        }
                    });
                    if (currentLoanStep === 2) {
                        const status = document.getElementById('loanStudentStatus').value;
                        if (status === 'not-enrolled') {
                            const lastSem = document.getElementById('loanLastSem');
                            lastSem.classList.remove('error-border');
                            let em = lastSem.parentElement.querySelector('.error-msg');
                            if (em) em.style.display = 'none';
                            if (!lastSem.value.trim()) {
                                lastSem.classList.add('error-border');
                                if (!em) {
                                    em = document.createElement('div');
                                    em.className = 'error-msg';
                                    lastSem.parentElement.appendChild(em);
                                }
                                em.textContent = 'Required';
                                em.style.display = 'block';
                            }
                        }
                    }
                }

                function attachLoanStepFieldListeners() {
                    const stepEl = document.querySelector(`.loan-form-step[data-step="${currentLoanStep}"]`);
                    if (!stepEl) return;
                    const requiredInputs = stepEl.querySelectorAll('input[required], select[required], textarea[required]');
                    requiredInputs.forEach(inp => {
                        if (!inp.dataset.listenerAttached) {
                            const evt = inp.tagName === 'SELECT' ? 'change' : 'input';
                            inp.addEventListener(evt, () => {
                                // clear error when user types
                                inp.classList.remove('error-border');
                                const em = inp.parentElement.querySelector('.error-msg');
                                if (em) em.style.display = 'none';
                            });
                            inp.dataset.listenerAttached = '1';
                        }
                    });
                }

                document.getElementById('loan-next-btn').addEventListener('click', () => {
                    if (!validateLoanCurrentStep()) {
                        showLoanValidationErrors(); // Only show errors when user tries to proceed
                        return;
                    }
                    if (currentLoanStep < totalLoanSteps) {
                        currentLoanStep++;
                        updateLoanStepDisplay();
                    } else {
                        // On submit open payment slip
                        closeModal(modals['safe-loan-form']);
                        openModal('payment-slip-loan');
                    }
                });

                document.getElementById('loan-prev-btn').addEventListener('click', () => {
                    if (currentLoanStep > 1) {
                        currentLoanStep--;
                        updateLoanStepDisplay();
                    }
                });

                // Toggle Last Sem for loan
                window.toggleLoanLastSemInput = function(show) {
                    const lastSemContainer = document.getElementById('loanLastSemContainer');
                    const fromSYContainer = document.getElementById('loanFromSYContainer');
                    const toSYContainer = document.getElementById('loanToSYContainer');
                    const lastSemInput = document.getElementById('loanLastSem');
                    const fromSYInput = document.getElementById('loanFromSY');
                    const toSYInput = document.getElementById('loanToSY');

                    if (show) {
                        lastSemContainer.classList.remove('hidden');
                        fromSYContainer.classList.remove('hidden');
                        toSYContainer.classList.remove('hidden');
                        lastSemInput.required = false;
                        fromSYInput.required = false;
                        toSYInput.required = false;
                    } else {
                        lastSemContainer.classList.add('hidden');
                        fromSYContainer.classList.add('hidden');
                        toSYContainer.classList.add('hidden');
                        lastSemInput.required = false;
                        fromSYInput.required = false;
                        toSYInput.required = false;
                        lastSemInput.value = '';
                        fromSYInput.value = '';
                        toSYInput.value = '';
                    }
                };

                // Loan Payment Slip: Back button
                document.getElementById('loan-back-btn').addEventListener('click', () => {
                    closeModal(modals['payment-slip-loan']);
                    openModal('safe-loan-form');
                });

                // Loan Payment Slip: Update total when amount changes
                const loanAmountInput = document.getElementById('loan-amount');
                const loanTotalAmount = document.getElementById('loan-total-amount');

                function updateLoanTotal() {
                    const amt = parseFloat(loanAmountInput.value) || 0;
                    loanTotalAmount.textContent = `₱${amt.toFixed(2)}`;
                }
                loanAmountInput.addEventListener('input', updateLoanTotal);
                updateLoanTotal();

                loanAmountInput.addEventListener('input', updateLoanTotal);
                updateLoanTotal();

                // Good Moral quantity update
                const gmQty = document.getElementById('gm-qty');
                const gmCost = document.getElementById('gm-cost');
                const totalAmount = document.getElementById('total-amount');

                function updateCost() {
                    const qty = parseInt(gmQty.value) || 1;
                    const cost = qty * 70;
                    gmCost.textContent = `₱${cost.toFixed(2)}`;
                    totalAmount.textContent = `₱${cost.toFixed(2)}`;
                }

                gmQty.addEventListener('input', updateCost);
                updateCost();

                // Submit payment form -> map fields -> submit hidden POST form
                const paymentForm = document.getElementById('payment-form');
                paymentForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const submitBtn = paymentForm.querySelector('button[type="submit"]');
                    if (submitBtn.dataset.loading === '1') return; // prevent double submit
                    submitBtn.dataset.loading = '1';
                    submitBtn.textContent = 'Submitting...';
                    submitBtn.classList.add('btn-disabled');
                    // Gather values from wizard
                    const firstName = document.getElementById('firstName').value.trim();
                    const lastName = document.getElementById('lastName').value.trim();
                    const middleName = document.getElementById('middleName').value.trim();
                    const contact = document.getElementById('contact').value.trim();
                    const dateNeeded = document.getElementById('date').value; // yyyy-mm-dd
                    const statusRaw = document.getElementById('studentStatus').value; // currently-enrolled | not-enrolled
                    const lastSem = document.getElementById('lastSem').value.trim();
                    const college = document.getElementById('college').value.trim();
                    const program = document.getElementById('program').value.trim();
                    const year = document.getElementById('year').value.trim();
                    const fromSy = document.getElementById('fromSY').value.trim();
                    const toSy = document.getElementById('toSY').value.trim();
                    const yearGraduated = document.getElementById('yearGraduated').value.trim();
                    const email = document.getElementById('email').value.trim();
                    const purpose = document.getElementById('purpose').value.trim();
                    const genderEl = document.querySelector('input[name="gender"]:checked');
                    const gender = genderEl ? genderEl.value : '';
                    const copies = parseInt(gmQty.value) || 1;

                    // Map to hidden form fields
                    document.getElementById('gm-first_name').value = firstName;
                    document.getElementById('gm-last_name').value = lastName;
                    document.getElementById('gm-middle_name').value = middleName;
                    document.getElementById('gm-contact').value = contact;
                    document.getElementById('gm-date_needed').value = dateNeeded;
                    document.getElementById('gm-student_status').value = statusRaw.replace('-', '_');
                    document.getElementById('gm-last_semester').value = lastSem;
                    document.getElementById('gm-college').value = college;
                    document.getElementById('gm-program').value = program;
                    document.getElementById('gm-year').value = year;
                    document.getElementById('gm-from_sy').value = fromSy;
                    document.getElementById('gm-to_sy').value = toSy;
                    document.getElementById('gm-year_graduated').value = yearGraduated;
                    document.getElementById('gm-email').value = email;
                    document.getElementById('gm-purpose').value = purpose;
                    document.getElementById('gm-gender').value = gender;
                    document.getElementById('gm-copies').value = copies;

                    // Submit the form normally (will show browser loading spinner)
                    document.getElementById('gm-submit-form').submit();
                });

                // Safe Loan payment slip submit mapping
                const paymentLoanForm = document.getElementById('payment-loan-form');
                paymentLoanForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const submitBtn = paymentLoanForm.querySelector('button[type="submit"]');
                    if (submitBtn.dataset.loading === '1') return;
                    submitBtn.dataset.loading = '1';
                    submitBtn.textContent = 'Submitting...';
                    submitBtn.classList.add('btn-disabled');
                    // Gather from loan wizard
                    const firstName = document.getElementById('loanFirstName').value.trim();
                    const lastName = document.getElementById('loanLastName').value.trim();
                    const middleName = document.getElementById('loanMiddleName').value.trim();
                    const contact = document.getElementById('loanContact').value.trim();
                    const dateNeeded = document.getElementById('loanDate').value;
                    const studentStatusRaw = document.getElementById('loanStudentStatus').value; // currently-enrolled | not-enrolled
                    const lastSem = document.getElementById('loanLastSem').value.trim();
                    const college = document.getElementById('loanCollege').value.trim();
                    const program = document.getElementById('loanProgram').value.trim();
                    const year = document.getElementById('loanYear').value.trim();
                    const fromSy = document.getElementById('loanFromSY').value.trim();
                    const toSy = document.getElementById('loanToSY').value.trim();
                    const yearGraduated = document.getElementById('loanYearGraduated').value.trim();
                    const email = document.getElementById('loanEmail').value.trim();
                    const purpose = document.getElementById('loanPurpose').value.trim();
                    const genderEl = document.querySelector('input[name="loanGender"]:checked');
                    const gender = genderEl ? genderEl.value : '';
                    const loanAmt = parseFloat(document.getElementById('loan-amount').value) || 0;

                    // Map
                    document.getElementById('loan-first_name_hidden').value = firstName;
                    document.getElementById('loan-last_name_hidden').value = lastName;
                    document.getElementById('loan-middle_name_hidden').value = middleName;
                    document.getElementById('loan-contact_hidden').value = contact;
                    document.getElementById('loan-date_needed').value = dateNeeded;
                    document.getElementById('loan-student_status_hidden').value = studentStatusRaw.replace('-', '_');
                    document.getElementById('loan-last_semester_hidden').value = lastSem;
                    document.getElementById('loan-college_hidden').value = college;
                    document.getElementById('loan-program_hidden').value = program;
                    document.getElementById('loan-year_hidden').value = year;
                    document.getElementById('loan-from_sy_hidden').value = fromSy;
                    document.getElementById('loan-to_sy_hidden').value = toSy;
                    document.getElementById('loan-year_graduated_hidden').value = yearGraduated;
                    document.getElementById('loan-email_hidden').value = email;
                    document.getElementById('loan-purpose_hidden').value = purpose;
                    document.getElementById('loan-gender_hidden').value = gender;
                    document.getElementById('loan-loan_amount_hidden').value = loanAmt.toFixed(2);

                    // Store the reference for PDF viewing later
                    const formData = new FormData(document.getElementById('loan-submit-form'));
                    const loanSubmitUrl = @json(route('safeloan.store'));

                    fetch(loanSubmitUrl, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(response => {
                        if (response.redirected) {
                            // Store the show page URL, we'll need to get print URL from it
                            window.lastShowUrl = response.url;
                            lastSubmittedType = 'safe-loan';

                            // Reset button and show modal
                            submitBtn.dataset.loading = '0';
                            submitBtn.textContent = 'Submit Request';
                            submitBtn.classList.remove('btn-disabled');
                            closeModal(modals['payment-slip-loan']);
                            openModal('success');
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                        submitBtn.dataset.loading = '0';
                        submitBtn.textContent = 'Submit Request';
                        submitBtn.classList.remove('btn-disabled');
                    });
                });

                // View slip button in success modal
                document.getElementById('view-slip-btn').addEventListener('click', () => {
                    // Open PDF in new window based on stored URL
                    if (window.lastPdfUrl) {
                        window.open(window.lastPdfUrl, '_blank');
                    } else if (window.lastShowUrl) {
                        // For safe loan, construct the print URL from show URL
                        const printUrl = window.lastShowUrl.replace('/requests/safe-loan/', '/requests/safe-loan/') + '/print';
                        window.open(printUrl, '_blank');
                    }
                }); // Helper functions
                function openModal(option) {
                    if (modals[option]) {
                        modals[option].classList.remove('hidden');
                        modals[option].classList.add('flex');
                        // focus first input for accessibility
                        const firstInput = modals[option].querySelector('input, select, textarea, button');
                        if (firstInput) firstInput.focus();
                    }
                }

                function closeModal(modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }

                // Flowbite-style floating labels use the peer classes on inputs and no JS is required.

                // ESC key closes top-most open modal
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        const open = Array.from(document.querySelectorAll('.modal.flex'));
                        if (open.length) {
                            closeModal(open[open.length - 1]);
                        }
                    }
                });

                // Initial validation state
                updateStepDisplay();
                updateLoanStepDisplay();
            });
        </script>
</body>

</html>