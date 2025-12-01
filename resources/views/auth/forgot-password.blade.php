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
                        <span class="block">Forgot Password</span>
                        <span class="block h-[3px] bg-white mt-5 w-full"></span>
                    </h1>
                    <p class="text-white text-sm mt-4 opacity-90">Enter your email address and we'll send you a link to reset your password.</p>
                </div>

                <!-- Success Message -->
                @if (session('status'))
                <div class="mb-4 p-4 bg-green-500 bg-opacity-20 border border-green-300 rounded-lg text-white text-sm">
                    {{ session('status') }}
                </div>
                @endif

                <!-- Form -->
                <form action="{{ route('password.email') }}" method="POST">
                    @csrf

                    <!-- Email -->
                    <div class="mb-6">
                        <div class="flex justify-center mb-4">
                            <input type="email" name="email" placeholder="Email" required
                                value="{{ old('email') }}"
                                class="w-[380px] border-b pb-3 bg-transparent text-base mx-auto text-white placeholder-white focus:outline-none {{ $errors->has('email') ? 'border-red-500 focus:border-red-500' : 'border-white focus:border-white' }}">
                        </div>
                        @error('email')
                        <p class="text-red-300 text-xs text-left">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Send Reset Link Button -->
                    <button type="submit"
                        class="w-full bg-white text-black font-semibold py-3 rounded-full text-base uppercase hover:bg-gray-100 transition">
                        Send Reset Link
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
                alt="Forgot Password Illustration"
                class="w-[100%] translate-y-6">
        </div>

        <div class="text-sm text-gray-400 pb-6 text-center tracking-wide">
            © 2025 Office of Student Affairs and Services. All Rights Reserved.
        </div>
    </div>

</body>

</html>