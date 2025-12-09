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
                            <input type="text" name="student_id" placeholder="Student ID"
                                class="flex-1 border-b border-white/70 focus:border-white focus:outline-none pb-3 text-white/80 bg-transparent placeholder-white/70 text-sm">
                            <!-- <div class="flex gap-4"> -->

                            <!-- Names -->
                            <input type="text" name="last_name" placeholder="Last Name" required
                                class="flex-1 border-b border-white/70 focus:border-white focus:outline-none pb-3 text-white/80 bg-transparent placeholder-white/70 text-sm">
                        </div>

                        <div class="flex gap-4">
                            <input type="text" name="first_name" placeholder="First Name" required
                                class="flex-1 border-b border-white/70 focus:border-white focus:outline-none pb-3 text-white/80 bg-transparent placeholder-white/70 text-sm">
                            <input type="text" name="middle_initial" placeholder="M.I."
                                class="w-20 border-b border-white/70 focus:border-white focus:outline-none pb-3 text-white/80 bg-transparent placeholder-white/70 text-sm">
                            <input type="text" name="suffix" placeholder="Suffix"
                                class="w-24 border-b border-white/70 focus:border-white focus:outline-none pb-3 text-white/80 bg-transparent placeholder-white/70 text-sm">
                        </div>

                        <!-- Phone + College -->
                        <div class="flex gap-4">
                            <input type="tel" name="phone" placeholder="Phone Number"
                                pattern="[0-9]{11}" maxlength="11"
                                class="flex-1 border-b border-white/70 focus:border-white focus:outline-none pb-3 text-white/80 bg-transparent placeholder-white/70 text-sm">

                            <select name="college" required
                                class="flex-1 border-b border-white/70 focus:border-white focus:outline-none pb-3 text-white bg-transparent text-sm appearance-none cursor-pointer pr-8">
                                <option value="" disabled selected class="text-black bg-white">Select College</option>
                                <option value="College of Applied of economics" class="text-black bg-white">College of Applied of economics</option>
                                <option value="College of Arts and Sciences" class="text-black bg-white">College of Arts and Sciences</option>
                                <option value="College of Business Administration" class="text-black bg-white">College of Business Administration</option>
                                <option value="College of Information and Computing" class="text-black bg-white">College of Information and Computing</option>
                                <option value="College of Technology" class="text-black bg-white">College of Technology</option>
                                <option value="College of Education" class="text-black bg-white">College of Education</option>
                                <option value="College of Engineering" class="text-black bg-white">College of Engineering</option>
                            </select>
                        </div>

                        <!-- Program + Year -->
                        <div class="flex gap-4">
                            <input type="text" name="program" placeholder="Program" required
                                class="flex-1 border-b border-white/70 focus:border-white focus:outline-none pb-3 text-white/80 bg-transparent placeholder-white/70 text-sm">

                            <select name="year" required
                                class="flex-1 border-b border-white/70 focus:border-white focus:outline-none pb-3 text-white bg-transparent text-sm appearance-none cursor-pointer">
                                <option value="" disabled selected class="text-black bg-white">Select Year</option>
                                <option value="1st year" class="text-black bg-white">1st year</option>
                                <option value="2nd year" class="text-black bg-white">2nd year</option>
                                <option value="3rd year" class="text-black bg-white">3rd year</option>
                                <option value="4th year" class="text-black bg-white">4th year</option>
                                <option value="5th year" class="text-black bg-white">5th year</option>
                            </select>
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
            <img src="{{ asset('images/LoginSticker.png') }}" alt="Signup Illustration" class="w-[110%] translate-y-6">
        </div>
        <div class="text-sm text-gray-400 pb-6 text-center">
            © Office of Student Affairs and Services. All Rights Reserved.<br>
            <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700">Terms of Use</a> |
            <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700">Privacy Policy</a>
        </div>
    </div>

</body>

</html>