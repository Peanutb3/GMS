<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | GMS</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

    input[type="checkbox"] {
      appearance: none;
      width: 22px;
      height: 22px;
      border: 2px solid #fff;
      border-radius: 4px;
      background: transparent;
      cursor: pointer;
      position: relative;
    }

    /* input[type="checkbox"]:checked::after {
      content: '✔';
      position: absolute;
      top: -2px;
      left: 3px;
      font-size: 16px;
      color: white;
    } */
    /* Remove white/yellow background added by browser autofill or focus states */
    input,
    select,
    textarea {
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

    /* Firefox (uses :-moz-autofill) */
    input:-moz-autofill {
      box-shadow: 0 0 0 1000px transparent inset !important;
      -moz-text-fill-color: #ffffff !important;
    }

    /* Ensure placeholder stays dim and no white flash */
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
            <span class="block">Login</span>
            <span class="block h-[3px] bg-white mt-5 w-full"></span>
          </h1>
        </div>

        <!-- Form -->
        <form id="loginForm" action="{{ route('login.submit') }}" method="POST">
          @csrf

          <!-- Email -->
          <div>
            <div class="flex justify-center mb-4">
              <input type="text" name="email" placeholder="Email" required
                value="{{ old('email') }}"
                class="w-[380px] border-b pb-3 bg-transparent text-base mx-auto text-white placeholder-white focus:outline-none {{ $errors->has('email') ? 'border-red-500 focus:border-red-500' : 'border-white focus:border-white' }}">
            </div>
            @error('email')
            <p class="text-red-300 text-xs text-left">{{ $message }}</p>
            @enderror
          </div>

          <!-- Password -->
          <div>
            <div class="relative flex justify-center mb-2">
              <input type="password" id="password" name="password" placeholder="Password" required
                class="w-[380px] border-b pb-3 bg-transparent text-base pr-10 mx-auto text-white placeholder-white focus:outline-none {{ $errors->has('password') ? 'border-red-500 focus:border-red-500' : 'border-white focus:border-white' }}">
              <button type="button" onclick="togglePassword()" class="absolute right-[0%] top-1 text-white">
                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </button>
            </div>
            @error('password')
            <p class="text-red-300 text-xs mb-2 text-left">{{ $message }}</p>
            @enderror
          </div>

          <!-- Remember me + Forgot password -->
          <div class="flex justify-between items-center text-white text-sm mb-6">
            <label class="flex items-center space-x-2 cursor-pointer select-none">
              <!-- Custom checkbox container -->
              <div class="w-4 h-4 border-2 border-white rounded flex items-center justify-center bg-transparent">
                <!-- Check icon, hidden by default -->
                <svg class="w-3 h-3 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <span>Remember me</span>
            </label>
            <a href="{{ route('password.request') }}" class="text-blue-300 hover:underline">Forgot password?</a>
          </div>


          <!-- Login Button -->
          <button type="submit"
            class="w-full bg-white text-black font-semibold py-3 rounded-full text-base uppercase hover:bg-gray-100 transition">
            LOGIN
          </button>

          <!-- Divider -->
          <div class="flex items-center my-4">
            <hr class="flex-grow border-t border-white">
            <span class="mx-3 text-white text-sm">or</span>
            <hr class="flex-grow border-t border-white">
          </div>

          <!-- Google Sign-in -->
          <button type="button" onclick="signInWithGoogle()"
            class="w-full bg-white text-black font-medium py-3 rounded-full text-base flex items-center justify-center gap-3 hover:bg-gray-100 transition">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google Logo" class="w-6 h-6">
            Sign in with Google
          </button>
        </form>
      </div>
    </div>

    <!-- Signup link -->
    <div class="text-center text-white text-sm mb-6">
      Don't have an account?
      <a href="{{ route('signup.step1') }}" class="text-blue-300 hover:underline font-semibold">Sign up</a>
    </div>
  </div>

  <!-- Right Panel -->
  <div class="w-1/2 bg-white h-full flex flex-col items-center justify-between px-12">
    <div class="flex-1 flex items-center justify-center">
      <img src="{{ asset('images/Login_pic.png') }}"
        alt="Login Illustration"
        class="w-[100%] translate-y-6">
    </div>

    <div class="text-sm text-gray-400 pb-6 text-center tracking-wide">
      © 2025 Office of Student Affairs and Services. All Rights Reserved.
    </div>
  </div>

  <!-- Scripts -->
  <script>
    function signInWithGoogle() {
      alert("Google Sign-in will be integrated later.");
    }

    function togglePassword() {
      const pwd = document.getElementById("password");
      const eye = document.getElementById("eyeIcon");
      const openEye = `
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
      const closedEye = `
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.224-3.592M9.88 9.88A3 3 0 0114.12 14.12M6.1 6.1l11.8 11.8" />`;
      if (pwd.type === "password") {
        pwd.type = "text";
        eye.innerHTML = openEye; // show password -> open eye
      } else {
        pwd.type = "password";
        eye.innerHTML = closedEye; // hide password -> slashed eye
      }
    }

    // Toggle custom checkbox
    document.querySelectorAll('label').forEach(label => {
      const checkboxIcon = label.querySelector('div');
      const check = checkboxIcon.querySelector('svg');

      label.addEventListener('click', () => {
        check.classList.toggle('hidden'); // show/hide checkmark
      });
    });
  </script>

</body>

</html>