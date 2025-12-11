<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | GMS</title>
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .forgot-left-panel {
                border-radius: 0;
            }

            .forgot-right-panel {
                display: none;
            }
        }
    </style>
</head>

<body class="h-screen w-screen flex overflow-hidden">

    <!-- Left Panel -->
    <div class="forgot-left-panel w-full lg:w-1/2 h-full bg-gradient-to-br from-[#DC5656] via-[#800000] to-[#EB6E6E]
              flex flex-col justify-center items-center rounded-none lg:rounded-r-[60px] shadow-xl px-8 md:px-16 py-12">

        <div class="w-full max-w-[420px]">

            <!-- Title Section -->
            <div class="text-center mb-10">
                <div class="flex justify-center mb-4">
                    <svg class="w-20 h-20 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-semibold text-white mb-3">
                    Forgot Password?
                </h1>
                <p class="text-white text-sm md:text-base opacity-90 leading-relaxed">
                    No worries! Enter your email address and we'll send you a link to reset your password.
                </p>
            </div>

            <!-- Success Message -->
            @if (session('status'))
            <div class="mb-6 p-4 bg-green-500 bg-opacity-25 border-2 border-green-300 rounded-xl text-white text-sm md:text-base text-center animate-pulse">
                <svg class="w-6 h-6 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('status') }}
            </div>
            @endif

            <!-- Form -->
            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email Input -->
                <div class="w-full">
                    <div class="relative">
                        <span class="absolute left-0 top-3 text-white opacity-70">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <input type="email" name="email" placeholder="Enter your email address" required
                            value="{{ old('email') }}"
                            class="w-full border-b-2 pb-3 pl-8 bg-transparent text-base text-white placeholder-white focus:outline-none transition-colors duration-300 {{ $errors->has('email') ? 'border-red-400 focus:border-red-400' : 'border-white/50 focus:border-white' }}">
                    </div>
                    @error('email')
                    <p class="text-red-300 text-xs mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Send Reset Link Button -->
                <button type="submit"
                    class="w-full bg-white text-[#800000] font-semibold py-3.5 rounded-full text-base uppercase hover:bg-gray-100 hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                    Send Reset Link
                </button>

                <!-- Back to Login -->
                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" class="text-blue-200 hover:text-white hover:underline text-sm md:text-base inline-flex items-center transition-colors duration-300">
                        <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Login
                    </a>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center text-white text-sm mt-12 opacity-80">
            Remember your password?
            <a href="{{ route('login') }}" class="text-blue-200 hover:text-white hover:underline font-semibold transition-colors duration-300">Sign in</a>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="forgot-right-panel hidden lg:flex w-1/2 bg-white h-full flex-col items-center justify-between px-12">
        <div class="flex-1 flex items-center justify-center">
            <img src="{{ asset('images/Login_pic.png') }}"
                alt="Forgot Password Illustration"
                class="w-[100%] max-w-lg">
        </div>

        <div class="text-sm text-gray-400 pb-6 text-center tracking-wide">
            © 2025 Office of Student Affairs and Services. All Rights Reserved.
        </div>
    </div>

</body>

</html>
