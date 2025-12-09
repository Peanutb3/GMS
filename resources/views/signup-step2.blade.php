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

        /* Transparent inputs (prevent white fill when typing/autofill) */
        input,
        select,
        textarea {
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
    <div class="w-full lg:w-1/2 min-h-screen bg-gradient-to-br from-[#DC5656] via-[#800000] to-[#EB6E6E]
              flex flex-col justify-between rounded-none lg:rounded-r-[60px] shadow-xl px-6 md:px-14 py-8">

        <div class="flex-1 flex items-center justify-center">
            <div class="w-full max-w-[420px]">

                <!-- Title -->
                <div class="text-left mb-10">
                    <h1 class="text-xl font-semibold text-white inline-block relative">
                        <span class="block">Create account</span>
                        <span class="block h-[2px] bg-white mt-2 w-full"></span>
                    </h1>
                </div>

                <!-- Step 2 Form -->
                <form action="{{ route('signup.step2.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!--Email -->
                    <div class="w-full">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required
                            class="w-full border-b border-white/70 focus:border-white focus:outline-none pb-3
                     text-white/80 bg-transparent placeholder-white/70 text-sm">
                        @error('email')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="relative w-full">
                        <input type="password" id="password" name="password" placeholder="Password" required
                            class="w-full border-b border-white/70 focus:border-white focus:outline-none pb-3
                     text-white/80 bg-transparent placeholder-white/70 text-sm pr-10"
                            oninput="checkPasswordStrength(this.value)">
                        <button type="button" onclick="togglePassword('password','eyeIcon')"
                            class="absolute right-0 top-2 text-white/80">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5
                      c4.477 0 8.268 2.943 9.542 7
                      -1.274 4.057-5.065 7-9.542 7
                      -4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                        <div class="mt-2 h-1 w-full bg-white/30 rounded-full overflow-hidden">
                            <div id="passwordStrengthBar" class="h-full w-0 bg-red-500 transition-all duration-300"></div>
                        </div>
                        <p id="passwordStrengthText" class="text-xs text-white/80 mt-1"></p>
                        @error('password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="relative w-full">
                        <input type="password" id="confirmPassword" name="password_confirmation" placeholder="Confirm Password" required
                            class="w-full border-b border-white/70 focus:border-white focus:outline-none pb-3
                     text-white/80 bg-transparent placeholder-white/70 text-sm pr-10">
                        <button type="button" onclick="togglePassword('confirmPassword','confirmEyeIcon')"
                            class="absolute right-0 top-2 text-white/80">
                            <svg id="confirmEyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5
                      c4.477 0 8.268 2.943 9.542 7
                      -1.274 4.057-5.065 7-9.542 7
                      -4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Data Privacy Consent -->
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3 text-white/90 text-xs">
                            <input type="checkbox" name="agree_privacy" required
                                class="w-5 h-5 mt-0.5 flex-shrink-0">
                            <span>I consent to the collection and processing of my personal information in accordance with the
                                <a href="https://www.usep.edu.ph/usep-data-privacy-statement/" target="_blank" class="text-blue-300 hover:underline font-semibold">University of Southeastern Philippines' Data Privacy Statement</a>
                                and Republic Act No. 10173 (Data Privacy Act of 2012).</span>
                        </div>
                        <div class="flex items-start space-x-3 text-white/90 text-xs">
                            <input type="checkbox" name="agree_terms" required
                                class="w-5 h-5 mt-0.5 flex-shrink-0">
                            <span>I agree to the Terms & Conditions of the OSAS Grievance Management System.</span>
                        </div>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-white text-black font-semibold py-3 rounded-full
                   text-sm uppercase hover:bg-gray-100 transition">
                        SIGN UP
                    </button>
                </form>

                <!-- Footer -->
                <div class="text-center text-white text-sm mt-6 md:mb-6">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-blue-300 hover:underline font-semibold">Sign in</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="hidden lg:flex w-1/2 bg-white h-full flex-col items-center justify-between px-12">
        <div class="flex-1 flex items-center justify-center">
            <img src="{{ asset('images/LoginSticker.png') }}"
                alt="Login Illustration"
                class="w-[100%] translate-y-6">
        </div>

        <div class="text-sm text-gray-400 pb-6 text-center tracking-wide">
            © Office of Student Affairs and Services. All Rights Reserved.<br>
            <a href="#" onclick="showTerms(); return false;" class="text-gray-500 hover:text-gray-700">Terms of Use</a> |
            <a href="#" onclick="showPrivacyModal(); return false;" class="text-gray-500 hover:text-gray-700">Privacy Policy</a>
        </div>
    </div>

    <!-- Data Privacy Modal -->
    <div id="privacyModalSignup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-11/12 max-w-2xl max-h-[90vh] overflow-hidden">
            <div class="bg-gradient-to-r from-[#DC5656] to-[#800000] px-6 py-4 flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white">Data Privacy Notice</h3>
                <button onclick="closePrivacyModal()" class="text-white hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6 overflow-y-auto max-h-[70vh] text-gray-700 space-y-4">
        <div class="flex justify-center mb-4">
          <img src="{{ asset('images/LoginSticker.png') }}" alt="Privacy" class="w-64">
        </div>                <p class="font-semibold text-lg text-center text-[#800000]">University of Southeastern Philippines<br>Data Privacy Statement</p>

                <p class="text-sm">The University of Southeastern Philippines (USeP) is committed to protecting your personal information in compliance with <strong>Republic Act No. 10173 (Data Privacy Act of 2012)</strong>.</p>

                <div class="space-y-3 text-sm">
                    <div>
                        <p class="font-semibold text-[#800000]">What Information We Collect:</p>
                        <ul class="list-disc ml-6 mt-1">
                            <li>Personal details (name, student ID, contact information)</li>
                            <li>Academic information (program, year level, college)</li>
                            <li>Request details for certificates and services</li>
                        </ul>
                    </div>

                    <div>
                        <p class="font-semibold text-[#800000]">How We Use Your Information:</p>
                        <ul class="list-disc ml-6 mt-1">
                            <li>Processing certificate requests and other student services</li>
                            <li>Maintaining accurate student records</li>
                            <li>Communication regarding your requests</li>
                            <li>Compliance with university policies and legal requirements</li>
                        </ul>
                    </div>

                    <div>
                        <p class="font-semibold text-[#800000]">Your Rights:</p>
                        <ul class="list-disc ml-6 mt-1">
                            <li>Right to be informed about data collection and processing</li>
                            <li>Right to access your personal information</li>
                            <li>Right to request correction of inaccurate data</li>
                            <li>Right to object to data processing in certain circumstances</li>
                        </ul>
                    </div>

                    <div>
                        <p class="font-semibold text-[#800000]">Data Security:</p>
                        <p class="mt-1">We implement appropriate security measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction.</p>
                    </div>
                </div>

                <p class="text-xs text-gray-500 mt-4 text-center">For questions or concerns about your data privacy, contact the Office of Student Affairs and Services.</p>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex justify-end">
                <button onclick="closePrivacyModal()" class="bg-[#800000] text-white px-6 py-2 rounded-lg hover:bg-[#DC5656] transition">Close</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function showPrivacyModal() {
            document.getElementById('privacyModalSignup').classList.remove('hidden');
        }

        function closePrivacyModal() {
            document.getElementById('privacyModalSignup').classList.add('hidden');
        }

        function showTerms() {
            alert('Terms of Use page will be available soon.');
        }

        // Toggle password visibility
        function togglePassword(id, iconId) {
            const pwd = document.getElementById(id);
            const eye = document.getElementById(iconId);
            const openEye = `
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M2.458 12C3.732 7.943 7.523 5 12 5
              c4.477 0 8.268 2.943 9.542 7
              -1.274 4.057-5.065 7-9.542 7
              -4.477 0-8.268-2.943-9.542-7z" />`;
            const closedEye = `
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7
              a9.97 9.97 0 012.224-3.592M9.88 9.88A3 3 0 0114.12 14.12M6.1 6.1l11.8 11.8" />`;
            if (pwd.type === "password") {
                pwd.type = "text";
                eye.innerHTML = openEye; // open eye shows password
            } else {
                pwd.type = "password";
                eye.innerHTML = closedEye; // slashed eye hides password
            }
        }

        // Password strength checker
        function checkPasswordStrength(password) {
            const bar = document.getElementById('passwordStrengthBar');
            const text = document.getElementById('passwordStrengthText');
            let strength = 0;

            if (password.length >= 6) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^A-Za-z0-9]/)) strength++;

            switch (strength) {
                case 0:
                case 1:
                    bar.style.width = '20%';
                    bar.style.backgroundColor = '#ef4444';
                    text.textContent = 'Weak';
                    break;
                case 2:
                case 3:
                    bar.style.width = '60%';
                    bar.style.backgroundColor = '#f59e0b';
                    text.textContent = 'Moderate';
                    break;
                case 4:
                case 5:
                    bar.style.width = '100%';
                    bar.style.backgroundColor = '#22c55e';
                    text.textContent = 'Strong';
                    break;
            }
        }
    </script>
</body>

</html>
