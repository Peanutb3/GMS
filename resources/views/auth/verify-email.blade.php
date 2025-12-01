<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email | GMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="h-screen w-screen flex">
    <!-- Left Panel -->
    <div class="w-1/2 h-full bg-gradient-to-br from-[#DC5656] via-[#800000] to-[#EB6E6E] 
                flex flex-col justify-between rounded-r-[60px] shadow-xl px-14 py-12">
        <div class="flex-1 flex items-center justify-center">
            <div class="w-[75%] max-w-[480px] text-white">
                <!-- Icon -->
                <div class="text-center mb-8">
                    <svg class="w-24 h-24 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <h1 class="text-4xl font-semibold">Verify Your Email</h1>
                    <div class="h-[3px] bg-white mt-5 w-32 mx-auto"></div>
                </div>

                <!-- Message -->
                <div class="text-center space-y-4 mb-8">
                    <p class="text-lg">
                        Thanks for signing up! Before getting started, please verify your email address by clicking the link we sent to:
                    </p>
                    <p class="text-xl font-semibold bg-white/20 py-3 px-4 rounded-lg">
                        {{ Auth::user()->email }}
                    </p>
                    <p class="text-sm opacity-90">
                        If you didn't receive the email, we'll gladly send you another.
                    </p>
                </div>

                @if (session('success'))
                <div class="bg-green-500/20 border-2 border-green-300 text-white px-4 py-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Resend Button -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-white text-[#800000] font-semibold py-3 rounded-full text-base uppercase hover:bg-gray-100 transition mb-4">
                        Resend Verification Email
                    </button>
                </form>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-transparent border-2 border-white text-white font-semibold py-3 rounded-full text-base uppercase hover:bg-white/10 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-white text-sm opacity-75">
            © 2025 Office of Student Affairs and Services. All Rights Reserved.
        </div>
    </div>

    <!-- Right Panel -->
    <div class="w-1/2 bg-white h-full flex flex-col items-center justify-center px-12">
        <img src="{{ asset('images/Login_pic.png') }}"
            alt="Verification Illustration"
            class="w-[80%] max-w-[500px]">
    </div>
</body>

</html>