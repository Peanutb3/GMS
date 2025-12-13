<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code | GMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .code-input {
            width: 60px;
            height: 80px;
            font-size: 32px;
            text-align: center;
            font-weight: bold;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s;
        }

        .code-input:focus {
            outline: none;
            border-color: white;
            background: rgba(255, 255, 255, 0.15);
        }

        .code-input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>

<body class="h-screen w-screen flex overflow-hidden">

    <!-- Left Panel -->
    <div class="w-full lg:w-1/2 h-full bg-gradient-to-br from-[#DC5656] via-[#800000] to-[#EB6E6E]
              flex flex-col justify-center items-center rounded-none lg:rounded-r-[60px] shadow-xl px-8 md:px-16 py-12">

        <div class="w-full max-w-[420px]">

            <div class="">

                <!-- Icon -->
                <div class="flex justify-center mb-6">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-semibold text-white mb-2">
                        Password reset
                    </h1>
                    <p class="text-sm text-white opacity-90">
                        We sent a code to <strong>{{ session('email') }}</strong>
                    </p>
                </div>

                <!-- Form -->
                <form action="{{ route('password.verify') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('email') }}">

                    <!-- Code Inputs -->
                    <div class="flex justify-center gap-2 mb-6">
                        <input type="text" maxlength="1" class="code-input" id="code1" name="code[]" required autofocus>
                        <input type="text" maxlength="1" class="code-input" id="code2" name="code[]" required>
                        <input type="text" maxlength="1" class="code-input" id="code3" name="code[]" required>
                        <input type="text" maxlength="1" class="code-input" id="code4" name="code[]" required>
                        <input type="text" maxlength="1" class="code-input" id="code5" name="code[]" required>
                        <input type="text" maxlength="1" class="code-input" id="code6" name="code[]" required>
                    </div>

                    <!-- Hidden full code input -->
                    <input type="hidden" name="code" id="fullCode">

                    @error('code')
                    <p class="text-red-300 text-sm text-center mb-4">{{ $message }}</p>
                    @enderror

                    <!-- Continue Button -->
                    <button
                        type="submit"
                        class="w-full bg-white text-[#800000] font-semibold py-2.5 rounded-full text-sm hover:bg-gray-100 transition-colors duration-200">
                        Continue
                    </button>

                    <!-- Resend -->
                    <div class="text-center">
                        <p class="text-sm text-white">
                            Didn't receive the email?
                            <a href="{{ route('password.request') }}" class="text-blue-200 hover:text-white hover:underline font-semibold">Click to resend</a>
                        </p>
                    </div>

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

    </div>

    <!-- Right Panel -->
    <div class="hidden lg:flex w-1/2 bg-white h-full flex-col items-center justify-between px-12">
        <div class="flex-1 flex items-center justify-center">
            <img src="{{ asset('images/Login_pic.png') }}"
                alt="Verification Illustration"
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
        // Auto-focus next input
        const inputs = document.querySelectorAll('.code-input');
        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }

                // Combine all digits into hidden input
                const code = Array.from(inputs).map(i => i.value).join('');
                document.getElementById('fullCode').value = code;
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });

            // Only allow numbers
            input.addEventListener('keypress', (e) => {
                if (!/[0-9]/.test(e.key)) {
                    e.preventDefault();
                }
            });
        });

        function showPrivacyPolicy() {
            window.open('https://www.usep.edu.ph/usep-data-privacy-statement/', '_blank');
        }

        function showTerms() {
            alert('Terms of Use page will be available soon.');
        }
    </script>

</body>

</html>