<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP | GMS</title>
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
                    <h1 class="text-4xl font-semibold text-white inline-block relative">
                        <span class="block">Verify OTP</span>
                        <span class="block h-[3px] bg-white mt-5 w-full"></span>
                    </h1>
                    <p class="text-white/80 text-sm mt-4">We've sent a 6-digit code to your email</p>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                <div class="bg-green-500 text-white px-4 py-3 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Testing Code Display (REMOVE IN PRODUCTION) -->
                @if(session('2fa:test:code'))
                <div class="bg-yellow-500 text-black px-4 py-3 rounded mb-4 text-sm font-bold text-center">
                    TEST CODE: {{ session('2fa:test:code') }}
                </div>
                @endif

                <!-- Error Messages -->
                @if($errors->any())
                <div class="bg-red-500 text-white px-4 py-3 rounded mb-4 text-sm">
                    @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <!-- Form -->
                <form action="{{ route('2fa.verify') }}" method="POST">
                    @csrf

                    <!-- OTP Input -->
                    <div class="mb-6">
                        <input type="text"
                            name="code"
                            placeholder="Enter 6-digit code"
                            required
                            maxlength="6"
                            pattern="[0-9]{6}"
                            class="w-full border-b pb-3 bg-transparent text-center text-3xl tracking-widest mx-auto text-white placeholder-white/60 focus:outline-none border-white focus:border-white">
                    </div>

                    <!-- Verify Button -->
                    <button type="submit"
                        class="w-full bg-white text-black font-semibold py-3 rounded-full text-base uppercase hover:bg-gray-100 transition mb-4">
                        VERIFY
                    </button>

                    <!-- Resend Link -->
                    <div class="text-center">
                        <p class="text-white/80 text-sm">
                            Didn't receive the code?
                            <button type="button" onclick="document.getElementById('resendForm').submit()"
                                class="text-blue-300 hover:underline font-semibold">
                                Resend
                            </button>
                        </p>
                    </div>
                </form>

                <!-- Hidden Resend Form -->
                <form id="resendForm" action="{{ route('2fa.resend') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Back to login -->
        <div class="text-center text-white text-sm mb-6">
            <a href="{{ route('login') }}" class="text-blue-300 hover:underline">Back to Login</a>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="w-1/2 bg-white h-full flex flex-col items-center justify-center px-12">
        <div class="flex-1 flex items-center justify-center">
            <img src="{{ asset('images/LoginSticker.png') }}"
                alt="Security Illustration"
                class="w-[100%] translate-y-6">
        </div>

        <div class="text-sm text-gray-400 pb-6 text-center tracking-wide">
            © Office of Student Affairs and Services. All Rights Reserved.
        </div>
    </div>

</body>

</html>