<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account | GMS</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; }
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
            @error('username')
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

          <!-- Terms -->
          <div class="flex items-center space-x-2 text-white/80 text-xs">
            <input type="checkbox" name="agree_terms" required class="w-5 h-5">
            <span>I Agree To The Terms & Conditions</span>
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
    // Toggle password visibility
    function togglePassword(id, iconId) {
      const pwd = document.getElementById(id);
      const eye = document.getElementById(iconId);
      if (pwd.type === "password") {
        pwd.type = "text";
        eye.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7
          a9.97 9.97 0 012.224-3.592M9.88 9.88A3 3 0 0114.12 14.12M6.1 6.1l11.8 11.8" />`;
      } else {
        pwd.type = "password";
        eye.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M2.458 12C3.732 7.943 7.523 5 12 5
          c4.477 0 8.268 2.943 9.542 7
          -1.274 4.057-5.065 7-9.542 7
          -4.477 0-8.268-2.943-9.542-7z" />`;
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
