<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | GMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Prevent white background on input */
        input {
            background-color: transparent !important;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px rgba(255, 255, 255, 0.1) inset !important;
            box-shadow: 0 0 0 1000px rgba(255, 255, 255, 0.1) inset !important;
            -webkit-text-fill-color: #ffffff !important;
            caret-color: #ffffff;
            transition: background-color 9999s ease-in-out 0s;
        }

        ::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Password strength bar */
        .strength-bar {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="h-screen w-screen flex overflow-hidden">

    <!-- Left Panel -->
    <div class="w-full lg:w-1/2 h-full bg-gradient-to-br from-[#DC5656] via-[#800000] to-[#EB6E6E]
              flex flex-col justify-center items-center rounded-none lg:rounded-r-[60px] shadow-xl px-8 md:px-16 py-12">

        <div class="w-full max-w-[420px]">

            <!-- Card Container -->
            <div class="">

                <!-- Icon -->
                <div class="flex justify-center mb-6">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-semibold text-white mb-2">
                        Set new password
                    </h1>
                    <p class="text-sm text-white opacity-90">
                        Must be at least 8 characters.
                    </p>
                </div>

                <!-- Form -->
                <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                    @csrf
                    <!-- No token needed for OTP reset -->
                    <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-white mb-1.5">Password</label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="••••••••"
                                required
                                oninput="checkPasswordStrength()"
                                class="w-full px-3.5 py-2.5 bg-white bg-opacity-10 border {{ $errors->has('password') ? 'border-red-300' : 'border-white border-opacity-30' }} rounded-lg text-sm text-white placeholder-white placeholder-opacity-60 focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent transition-all">
                            <button type="button" onclick="togglePassword('password', 'eyeIcon1')" class="absolute right-3 top-1/2 -translate-y-1/2 text-white hover:text-gray-200">
                                <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div class="mt-2">
                            <div class="flex gap-1 mb-2">
                                <div id="strength1" class="strength-bar flex-1 bg-white bg-opacity-20"></div>
                                <div id="strength2" class="strength-bar flex-1 bg-white bg-opacity-20"></div>
                                <div id="strength3" class="strength-bar flex-1 bg-white bg-opacity-20"></div>
                                <div id="strength4" class="strength-bar flex-1 bg-white bg-opacity-20"></div>
                            </div>
                            <div class="flex items-center justify-between">
                                <p id="strengthText" class="text-xs text-white opacity-75"></p>
                                <p id="missingRequirement" class="text-xs text-red-300"></p>
                            </div>
                        </div>

                        @error('password')
                        <p class="text-red-300 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Input -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-white mb-1.5">Confirm password</label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="••••••••"
                                required
                                class="w-full px-3.5 py-2.5 bg-white bg-opacity-10 border border-white border-opacity-30 rounded-lg text-sm text-white placeholder-white placeholder-opacity-60 focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent transition-all">
                            <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')" class="absolute right-3 top-1/2 -translate-y-1/2 text-white hover:text-gray-200">
                                <svg id="eyeIcon2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Reset Password Button -->
                    <button
                        type="submit"
                        class="w-full bg-white text-[#800000] font-semibold py-2.5 rounded-full text-sm hover:bg-gray-100 transition-colors duration-200">
                        Reset password
                    </button>

                    <!-- Back to Login -->
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-sm text-white hover:text-blue-200 inline-flex items-center gap-1 transition-colors duration-200">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to log in
                        </a>
                    </div>
                </form>
            </div>

        </div>

        <!-- Footer -->
        <div class="text-center text-white text-sm mt-8 opacity-80">
            Remember your password?
            <a href="{{ route('login') }}" class="text-blue-200 hover:text-white hover:underline font-semibold transition-colors duration-300">Sign in</a>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="hidden lg:flex w-1/2 bg-white h-full flex-col items-center justify-between px-12">
        <div class="flex-1 flex items-center justify-center">
            <img src="{{ asset('images/Login_pic.png') }}"
                alt="Reset Password Illustration"
                class="w-[110%] translate-y-6">
        </div>

        <div class="text-sm text-gray-400 pb-6 text-center tracking-wide">
            © Office of Student Affairs and Services. All Rights Reserved.<br>
            <a href="#" onclick="showTerms(); return false;" class="text-gray-500 hover:text-gray-700">Terms of Use</a> |
            <a href="#" onclick="showPrivacyPolicy(); return false;" class="text-gray-500 hover:text-gray-700">Privacy Policy</a>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function showPrivacyPolicy() {
            window.open('https://www.usep.edu.ph/usep-data-privacy-statement/', '_blank');
        }

        function showTerms() {
            alert('Terms of Use page will be available soon.');
        }

        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            let strength = 0;

            // Check requirements
            const hasLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecial = /[@$!%*#?&_\-]/.test(password);

            // Calculate strength
            if (hasLength) strength++;
            if (hasUppercase) strength++;
            if (hasLowercase) strength++;
            if (hasNumber) strength++;
            if (hasSpecial) strength++;

            // Update strength bars
            const bars = ['strength1', 'strength2', 'strength3', 'strength4'];
            bars.forEach((bar, index) => {
                const element = document.getElementById(bar);
                if (index < strength && strength > 0) {
                    if (strength <= 2) {
                        element.style.backgroundColor = '#ef4444'; // red
                    } else if (strength <= 3) {
                        element.style.backgroundColor = '#f59e0b'; // orange
                    } else if (strength <= 4) {
                        element.style.backgroundColor = '#eab308'; // yellow
                    } else {
                        element.style.backgroundColor = '#22c55e'; // green
                    }
                } else {
                    element.style.backgroundColor = 'rgba(255, 255, 255, 0.2)';
                }
            });

            // Update strength text and show first missing requirement
            const strengthText = document.getElementById('strengthText');
            const missingReq = document.getElementById('missingRequirement');

            if (password.length === 0) {
                strengthText.textContent = '';
                missingReq.textContent = '';
            } else if (strength <= 2) {
                strengthText.textContent = 'Weak password';
                strengthText.style.color = '#ef4444';

                // Show first missing requirement
                if (!hasLength) {
                    missingReq.textContent = 'Need at least 8 characters';
                } else if (!hasUppercase) {
                    missingReq.textContent = 'Need one uppercase letter';
                } else if (!hasLowercase) {
                    missingReq.textContent = 'Need one lowercase letter';
                } else if (!hasNumber) {
                    missingReq.textContent = 'Need one number';
                } else if (!hasSpecial) {
                    missingReq.textContent = 'Need one special character';
                }
            } else if (strength <= 3) {
                strengthText.textContent = 'Fair password';
                strengthText.style.color = '#f59e0b';

                // Show first missing requirement
                if (!hasLength) {
                    missingReq.textContent = 'Need at least 8 characters';
                } else if (!hasUppercase) {
                    missingReq.textContent = 'Need one uppercase letter';
                } else if (!hasLowercase) {
                    missingReq.textContent = 'Need one lowercase letter';
                } else if (!hasNumber) {
                    missingReq.textContent = 'Need one number';
                } else if (!hasSpecial) {
                    missingReq.textContent = 'Need one special character';
                } else {
                    missingReq.textContent = '';
                }
            } else if (strength <= 4) {
                strengthText.textContent = 'Good password';
                strengthText.style.color = '#eab308';

                // Show first missing requirement
                if (!hasLength) {
                    missingReq.textContent = 'Need at least 8 characters';
                } else if (!hasUppercase) {
                    missingReq.textContent = 'Need one uppercase letter';
                } else if (!hasLowercase) {
                    missingReq.textContent = 'Need one lowercase letter';
                } else if (!hasNumber) {
                    missingReq.textContent = 'Need one number';
                } else if (!hasSpecial) {
                    missingReq.textContent = 'Need one special character';
                } else {
                    missingReq.textContent = '';
                }
            } else {
                strengthText.textContent = 'Strong password';
                strengthText.style.color = '#22c55e';
                missingReq.textContent = '';
            }
        }

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