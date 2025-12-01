<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | GMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        input {
            background-color: transparent !important;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px transparent inset !important;
            box-shadow: 0 0 0 1000px transparent inset !important;
            -webkit-text-fill-color: #ffffff !important;
            caret-color: #ffffff;
            transition: background-color 9999s ease-in-out 0s;
        }

        ::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
    </style>
</head>

<body class="h-screen w-screen flex">

    <!-- Left Panel -->
    <div class="w-1/2 h-full bg-gradient-to-br from-[#DC5656] via-[#800000] to-[#EB6E6E] 
              flex flex-col justify-between rounded-r-[60px] shadow-xl px-14 py-12">

        <div class="flex-1 flex items-center justify-center">
            <div class="w-[75%] max-w-[380px]">

                <!-- Title -->
                <div class="text-center mb-8">
                    <h1 class="text-5xl font-semibold text-white inline-block relative">
                        <span class="block">Reset Password</span>
                        <span class="block h-[3px] bg-white mt-5 w-full"></span>
                    </h1>
                    <p class="text-white text-sm mt-4 opacity-90">Enter your new password below.</p>
                </div>

                <!-- Form -->
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

                    <!-- Email (readonly) -->
                    <div class="mb-4">
                        <div class="flex justify-center mb-4">
                            <input type="email" name="email" placeholder="Email" readonly
                                value="{{ $email ?? old('email') }}"
                                class="w-[380px] border-b pb-3 bg-transparent text-base mx-auto text-white placeholder-white focus:outline-none border-white opacity-70">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <div class="relative flex justify-center mb-2">
                            <input type="password" id="password" name="password" placeholder="New Password" required
                                class="w-[380px] border-b pb-3 bg-transparent text-base pr-10 mx-auto text-white placeholder-white focus:outline-none {{ $errors->has('password') ? 'border-red-500 focus:border-red-500' : 'border-white focus:border-white' }}">
                            <button type="button" onclick="togglePassword('password', 'eyeIcon1')" class="absolute right-[0%] top-1 text-white">
                                <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                        <p class="text-red-300 text-xs mb-2 text-left">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <div class="relative flex justify-center mb-2">
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required
                                class="w-[380px] border-b pb-3 bg-transparent text-base pr-10 mx-auto text-white placeholder-white focus:outline-none border-white focus:border-white">
                            <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')" class="absolute right-[0%] top-1 text-white">
                                <svg id="eyeIcon2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Reset Password Button -->
                    <button type="submit"
                        class="w-full bg-white text-black font-semibold py-3 rounded-full text-base uppercase hover:bg-gray-100 transition">
                        Reset Password
                    </button>

                    <!-- Back to Login -->
                    <div class="text-center mt-6">
                        <a href="{{ route('login') }}" class="text-blue-300 hover:underline text-sm">
                            ← Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-white text-sm mb-6">
            Remember your password?
            <a href="{{ route('login') }}" class="text-blue-300 hover:underline font-semibold">Sign in</a>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="w-1/2 bg-white h-full flex flex-col items-center justify-between px-12">
        <div class="flex-1 flex items-center justify-center">
            <img src="{{ asset('images/Login_pic.png') }}"
                alt="Reset Password Illustration"
                class="w-[100%] translate-y-6">
        </div>

        <div class="text-sm text-gray-400 pb-6 text-center tracking-wide">
            © 2025 Office of Student Affairs and Services. All Rights Reserved.
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function togglePassword(inputId, eyeIconId) {
            const pwd = document.getElementById(inputId);
            const eye = document.getElementById(eyeIconId);
            const openEye = `
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            const closedEye = `
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.224-3.592M9.88 9.88A3 3 0 0114.12 14.12M6.1 6.1l11.8 11.8" />`;
            if (pwd.type === "password") {
                pwd.type = "text";
                eye.innerHTML = openEye;
            } else {
                pwd.type = "password";
                eye.innerHTML = closedEye;
            }
        }
    </script>

</body>

</html>