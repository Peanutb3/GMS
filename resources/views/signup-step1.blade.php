<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | GMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        input,
        select {
            background-color: transparent !important;
        }

        /* Program suggestions dropdown */
        .program-suggestions {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .program-suggestions::-webkit-scrollbar {
            width: 6px;
        }

        .program-suggestions::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .program-suggestions::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .program-suggestions::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .suggestion-item {
            padding: 10px 16px;
            color: #1f2937;
            cursor: pointer;
            transition: background-color 0.2s;
            font-size: 0.875rem;
        }

        .suggestion-item:hover {
            background-color: #f3f4f6;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active,
        select:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px transparent inset !important;
            box-shadow: 0 0 0 1000px transparent inset !important;
            -webkit-text-fill-color: #ffffff !important;
            caret-color: #ffffff;
            transition: background-color 9999s ease-in-out 0s;
        }

        input:-moz-autofill,
        select:-moz-autofill {
            box-shadow: 0 0 0 1000px transparent inset !important;
            -moz-text-fill-color: #ffffff !important;
        }

        ::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
    </style>
</head>

<body class="h-screen w-screen flex">

    <!-- Left Panel -->
    <div class="w-full lg:w-1/2 min-h-screen bg-gradient-to-br from-[#DC5656] via-[#800000] to-[#EB6E6E] flex flex-col justify-between rounded-none lg:rounded-r-[60px] shadow-xl px-6 md:px-14 py-10">

        <div class="flex-1 flex items-center justify-center">
            <div class="w-full max-w-[480px]">

                <!-- Title -->
                <div class="text-left mb-10">
                    <h1 class="text-2xl font-semibold text-white inline-block relative">
                        <span class="block">Create account</span>
                        <span class="block h-[2px] bg-white mt-2 w-40"></span>
                    </h1>
                </div>

                <!-- @if ($errors->any())
  <div class="bg-red-600 text-white p-3 rounded mb-4">
    <ul class="list-disc list-inside">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif -->
                <!-- Step 1 Form -->
                <form action="{{ route('signup.step1.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Hidden Account Type (Student only) -->
                    <input type="hidden" name="account_type" value="student">

                    <!-- Student Fields -->
                    <div id="studentFields" class="space-y-6">
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <input type="text" name="student_id" placeholder="Student ID" required value="{{ old('student_id') }}"
                                    class="w-full border-b @error('student_id') border-red-400 @else border-white/70 @enderror focus:border-white focus:outline-none pb-3 text-white/80 bg-transparent placeholder-white/70 text-sm">
                                @error('student_id')
                                <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex-1">
                                <input type="text" name="last_name" placeholder="Last Name" required value="{{ old('last_name') }}"
                                    class="w-full border-b @error('last_name') border-red-400 @else border-white/70 @enderror focus:border-white focus:outline-none pb-3 text-white/80 bg-transparent placeholder-white/70 text-sm">
                                @error('last_name')
                                <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex-1">
                                <input type="text" name="first_name" placeholder="First Name" required value="{{ old('first_name') }}"
                                    class="w-full border-b @error('first_name') border-red-400 @else border-white/70 @enderror focus:border-white focus:outline-none pb-3 text-white/80 bg-transparent placeholder-white/70 text-sm">
                                @error('first_name')
                                <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="w-20">
                                <input type="text" name="middle_initial" placeholder="M.I." value="{{ old('middle_initial') }}"
                                    class="w-full border-b @error('middle_initial') border-red-400 @else border-white/70 @enderror focus:border-white focus:outline-none pb-3 text-white/80 bg-transparent placeholder-white/70 text-sm">
                                @error('middle_initial')
                                <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="w-24">
                                <input type="text" name="suffix" placeholder="Suffix" value="{{ old('suffix') }}"
                                    class="w-full border-b @error('suffix') border-red-400 @else border-white/70 @enderror focus:border-white focus:outline-none pb-3 text-white/80 bg-transparent placeholder-white/70 text-sm">
                                @error('suffix')
                                <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone + College -->
                        <div class="flex gap-4">
                            <div class="w-32">
                                <input type="tel" name="phone" placeholder="Phone Number" required value="{{ old('phone') }}"
                                    pattern="[0-9]{11}" maxlength="11"
                                    class="w-full border-b @error('phone') border-red-400 @else border-white/70 @enderror focus:border-white focus:outline-none pb-3 text-white/80 bg-transparent placeholder-white/70 text-sm">
                                @error('phone')
                                <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="relative flex-1">
                                <select name="college" id="collegeSelect" required
                                    class="w-full border-b @error('college') border-red-400 @else border-white/70 @enderror focus:border-white focus:outline-none pb-3 text-white bg-transparent text-sm appearance-none cursor-pointer pr-8">
                                    <option value="" disabled selected class="text-black bg-white">Select college here</option>
                                    @foreach($colleges as $college)
                                    <option value="{{ $college->id }}" {{ old('college') == $college->id ? 'selected' : '' }} class="text-black bg-white">{{ $college->name }}</option>
                                    @endforeach
                                </select>
                                <span class="absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                                @error('college')
                                <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Program + Year -->
                        <div class="flex gap-4">
                            <div class="flex-[2] relative">
                                <select name="program" id="programSelect" required
                                    class="w-full border-b @error('program') border-red-400 @else border-white/70 @enderror focus:border-white focus:outline-none pb-3 text-white bg-transparent text-sm appearance-none cursor-pointer pr-8">
                                    <option value="" disabled selected class="text-black bg-white">Select program</option>
                                </select>
                                <span class="absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                                @error('program')
                                <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const collegeSelect = document.getElementById('collegeSelect');
                                    const programSelect = document.getElementById('programSelect');

                                    if (!collegeSelect || !programSelect) return;

                                    collegeSelect.addEventListener('change', function() {
                                        const collegeId = this.value;

                                        // Clear program dropdown
                                        programSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';

                                        if (collegeId) {
                                            // Fetch programs from database
                                            fetch(`/api/colleges/${collegeId}/programs`)
                                                .then(response => response.json())
                                                .then(programs => {
                                                    programSelect.innerHTML = '<option value="" disabled selected>Select program</option>';
                                                    programs.forEach(function(program) {
                                                        const opt = document.createElement('option');
                                                        opt.value = program.name;
                                                        opt.textContent = program.name;
                                                        opt.style.color = '#111827';
                                                        opt.style.backgroundColor = '#ffffff';
                                                        programSelect.appendChild(opt);
                                                    });
                                                })
                                                .catch(error => {
                                                    console.error('Error fetching programs:', error);
                                                    programSelect.innerHTML = '<option value="" disabled selected>Error loading programs</option>';
                                                });
                                        }
                                    });

                                    // Phone number validation - numbers only
                                    const phoneInput = document.querySelector('input[name="phone"]');
                                    if (phoneInput) {
                                        phoneInput.addEventListener('input', function(e) {
                                            this.value = this.value.replace(/[^0-9]/g, '');
                                        });
                                    }
                                });
                            </script>

                            <div class="w-32 relative">
                                <select name="year" required
                                    class="w-full border-b @error('year') border-red-400 @else border-white/70 @enderror focus:border-white focus:outline-none pb-3 text-white bg-transparent text-sm appearance-none cursor-pointer pr-8">
                                    <option value="" disabled selected class="text-black bg-white">Select Year</option>
                                    <option value="1st year" {{ old('year') == '1st year' ? 'selected' : '' }} class="text-black bg-white">1st year</option>
                                    <option value="2nd year" {{ old('year') == '2nd year' ? 'selected' : '' }} class="text-black bg-white">2nd year</option>
                                    <option value="3rd year" {{ old('year') == '3rd year' ? 'selected' : '' }} class="text-black bg-white">3rd year</option>
                                    <option value="4th year" {{ old('year') == '4th year' ? 'selected' : '' }} class="text-black bg-white">4th year</option>
                                    <option value="5th year" {{ old('year') == '5th year' ? 'selected' : '' }} class="text-black bg-white">5th year</option>
                                </select>
                                <span class="absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                                @error('year')
                                <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Next Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="w-12 h-12 bg-white text-[#DC5656] rounded-full flex items-center justify-center hover:bg-gray-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer with Sign in link -->
        <div class="text-center text-white text-sm mt-6 md:mb-6">
            Don't have an account?
            <a href="{{ route('login') }}" class="text-blue-300 hover:underline font-semibold">Sign in</a>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="w-1/2 bg-white h-full flex flex-col items-center justify-between px-12">
        <div class="flex-1 flex items-center justify-center">
            <img src="{{ asset('images/Login_pic.png') }}" alt="Signup Illustration" class="w-[110%] translate-y-6">
        </div>
        <div class="text-sm text-gray-400 pb-6 text-center">
            © Office of Student Affairs and Services. All Rights Reserved.<br>
            <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700">Terms of Use</a> |
            <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700">Privacy Policy</a>
        </div>
    </div>

    <!-- Program autocomplete removed: program is now a dependent select populated by college selection -->

</body>

</html>
