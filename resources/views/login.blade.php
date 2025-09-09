<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | GMS</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; }
    /* Transparent custom checkbox style */
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
    input[type="checkbox"]:checked::after {
      content: '✔';
      position: absolute;
      top: -2px;
      left: 3px;
      font-size: 16px;
      color: white;
    }
  </style>
</head>
<body class="h-screen w-screen flex">

  <!-- Left Panel -->
  <div class="w-1/2 h-full bg-gradient-to-br from-[#DC5656] via-[#800000] to-[#EB6E6E] 
              flex flex-col justify-between rounded-r-[140px] shadow-xl px-16 py-12">

    <div class="flex-1 flex items-center justify-center">
      <div class="w-[85%] max-w-[480px]">

        <!-- Title -->
        <div class="text-center mb-8">
          <h1 class="text-6xl font-medium text-white inline-block relative">
            <span class="block">Login</span>
            <span class="block h-[4px] bg-white mt-6 w-full"></span>
          </h1>
        </div>

        <!-- Form -->
        <form id="loginForm" action="/login" method="POST" class="space-y-6">
          @csrf

          <!-- Username -->
          <input type="text" name="email" placeholder="Username" required
                 class="w-full border-b-2 border-white focus:border-white focus:outline-none pb-3 text-white bg-transparent placeholder-white text-xl font-medium">

          <!-- Password with Eye Icon -->
          <div class="relative w-full">
            <input type="password" id="password" name="password" placeholder="Password" required
                   class="w-full border-b-2 border-white focus:border-white focus:outline-none pb-3 text-white bg-transparent placeholder-white text-xl font-medium pr-12">
            <button type="button" onclick="togglePassword()" 
                    class="absolute right-2 top-2 text-white">
              <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" 
                   fill="none" viewBox="0 0 24 24" stroke="currentColor" 
                   class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>

          <!-- Remember me + Forgot password -->
          <div class="flex justify-between items-center text-white text-lg">
            <label class="flex items-center space-x-3">
              <input type="checkbox" name="remember">
              <span>Remember me</span>
            </label>
            <a href="#" class="hover:underline">Forgot password?</a>
          </div>

          <!-- Login Button -->
          <button type="submit"
                  class="w-full bg-white text-black font-bold py-4 rounded-full text-xl uppercase hover:bg-gray-100 transition">
            LOGIN
          </button>

          <!-- Divider -->
          <div class="flex items-center my-4">
            <hr class="flex-grow border-t border-white">
            <span class="mx-4 text-white text-lg">or</span>
            <hr class="flex-grow border-t border-white">
          </div>

          <!-- Google Sign-in -->
          <button type="button" onclick="signInWithGoogle()"
                  class="w-full bg-white text-black font-medium py-4 rounded-full text-xl flex items-center justify-center gap-4 hover:bg-gray-100 transition">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google Logo" class="w-7 h-7">
            Sign in with Google
          </button>
        </form>
      </div>
    </div>

    <!-- Signup link -->
    <div class="text-center text-white text-lg mb-6">
      Don’t have an account? 
      <a href="#" class="text-blue-300 hover:underline font-semibold">Sign up</a>
    </div>
  </div>

  <!-- Right Panel -->
  <div class="w-1/2 bg-white h-full flex flex-col items-center justify-between px-12">
    <div class="flex-1 flex items-center justify-center">
      <img src="{{ asset('images/Login_pic.png') }}" 
           alt="Login Illustration" 
           class="h-[820px] w-auto object-contain translate-y-6"> 
    </div>

    <div class="text-sm text-gray-400 pb-6 text-center tracking-wide">
      © 2025 Office of Student Affairs and Services. All Rights Reserved.
    </div>
  </div>

  <script>
    function signInWithGoogle() {
      alert("Google Sign-in will be integrated later.");
    }

    function togglePassword() {
      const pwd = document.getElementById("password");
      const eye = document.getElementById("eyeIcon");

      if (pwd.type === "password") {
        pwd.type = "text";
        eye.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.224-3.592M9.88 9.88A3 3 0 0114.12 14.12M6.1 6.1l11.8 11.8" />`;
      } else {
        pwd.type = "password";
        eye.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
      }
    }
  </script>

</body>
</html>
