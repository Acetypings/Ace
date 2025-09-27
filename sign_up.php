<!-- LOGIN FORM -->
<form id="login-form" class="card-transition">
  <div class="space-y-4">
    <!-- Social Login Buttons -->
    <button type="button" class="w-full inline-flex items-center justify-center py-2.5 rounded-xl border border-blue-200 bg-white text-slate-700 hover:bg-blue-50 focus-ring transition-colors duration-200">
      <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google icon" class="w-5 h-5 mr-3">
      Sign in with Google
    </button>
    <button type="button" class="w-full inline-flex items-center justify-center py-2.5 rounded-xl border border-blue-200 bg-white text-slate-700 hover:bg-blue-50 focus-ring transition-colors duration-200">
      <img src="https://upload.wikimedia.org/wikipedia/commons/0/05/Facebook_Logo_%282019%29.png" alt="Facebook icon" class="w-5 h-5 mr-3">
      Sign in with Facebook
    </button>

    <div class="relative flex items-center justify-center py-2">
      <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t border-blue-100"></div>
      </div>
      <div class="relative bg-white px-4 text-sm text-slate-500">Or continue with</div>
    </div>

    <label class="block">
      <span class="text-sm text-slate-700">Email</span>
      <input type="email" required class="mt-1 block w-full rounded-xl border border-blue-200 px-4 py-2 bg-white focus:ring focus:ring-blue-200 focus:border-blue-400" placeholder="you@company.com" />
    </label>

    <label class="block">
      <span class="text-sm text-slate-700">Password</span>
      <div class="input-wrapper relative">
        <input id="login-password" type="password" required class="block w-full rounded-xl border border-blue-200 px-4 py-2 pr-10 bg-white focus:ring focus:ring-blue-200 focus:border-blue-400" placeholder="••••••••" />
        <button type="button" class="icon-btn absolute right-2 top-1/2 -translate-y-1/2" data-toggle-target="#login-password">
          <i class="fa-solid fa-eye-slash"></i>
        </button>
      </div>
    </label>

    <div class="flex items-center justify-between text-sm">
      <a href="#" class="text-blue-600 hover:underline">Forgot Password?</a>
    </div>

    <button type="submit" class="w-full mt-2 inline-block py-2.5 rounded-xl text-white bg-blue-600 btn-blue focus-ring">Log In</button>

    <div class="mt-5 text-sm text-center text-slate-600">
      Don’t have an account?
      <button type="button" id="to-signup" class="text-blue-600 font-medium hover:underline">Sign Up</button>
    </div>
  </div>
</form>

<!-- SIGNUP FORM -->
<form id="signup-form" class="card-transition hidden">
  <div class="space-y-4">

    <!-- Custom Dropdown for Customer / Staff -->
    <label class="block">
      <span class="text-sm text-slate-700">Register as</span>
      <div class="relative mt-1">
        <!-- Dropdown button -->
        <button id="role-dropdown-btn" type="button"
          class="w-full flex justify-between items-center rounded-xl border border-blue-200 px-4 py-2 bg-white text-slate-700 focus:ring focus:ring-blue-200 focus:border-blue-400">
          <span id="role-dropdown-label">Select role</span>
          <i class="fa-solid fa-chevron-down text-slate-400 ml-2"></i>
        </button>

        <!-- Dropdown menu -->
        <div id="role-dropdown-menu" class="absolute z-10 mt-1 w-full bg-white border border-blue-200 rounded-xl shadow-lg hidden">
          <button type="button" data-value="customer"
            class="w-full text-left px-4 py-2 hover:bg-blue-50 text-slate-700">Customer</button>
          <button type="button" data-value="staff"
            class="w-full text-left px-4 py-2 hover:bg-blue-50 text-slate-700">Staff</button>
        </div>
      </div>
      <!-- Hidden input to store selection -->
      <input type="hidden" name="role" id="role-input" required>
    </label>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <label class="block">
        <span class="text-sm text-slate-700">First Name</span>
        <input type="text" name="first" required class="mt-1 block w-full rounded-xl border border-blue-200 px-4 py-2 bg-white focus:ring focus:ring-blue-200 focus:border-blue-400" placeholder="Jane" />
      </label>
      <label class="block">
        <span class="text-sm text-slate-700">Last Name</span>
        <input type="text" name="last" required class="mt-1 block w-full rounded-xl border border-blue-200 px-4 py-2 bg-white focus:ring focus:ring-blue-200 focus:border-blue-400" placeholder="Doe" />
      </label>
    </div>

    <label class="block">
      <span class="text-sm text-slate-700">Email</span>
      <input type="email" name="email" required class="mt-1 block w-full rounded-xl border border-blue-200 px-4 py-2 bg-white focus:ring focus:ring-blue-200 focus:border-blue-400" placeholder="you@company.com" />
    </label>

    <label class="block">
      <span class="text-sm text-slate-700">Username</span>
      <input type="text" name="username" required class="mt-1 block w-full rounded-xl border border-blue-200 px-4 py-2 bg-white focus:ring focus:ring-blue-200 focus:border-blue-400" placeholder="janedoe" />
    </label>

    <label class="block">
      <span class="text-sm text-slate-700">Password</span>
      <div class="input-wrapper">
        <input id="signup-password" type="password" name="password" required class="block w-full rounded-xl border border-blue-200 px-4 py-2 pr-10 bg-white focus:ring focus:ring-blue-200 focus:border-blue-400" placeholder="Create a password" />
        <button type="button" class="icon-btn" data-toggle-target="#signup-password">
          <i class="fa-solid fa-eye-slash"></i>
        </button>
      </div>
    </label>

    <label class="block">
      <span class="text-sm text-slate-700">Confirm Password</span>
      <div class="input-wrapper">
        <input id="signup-confirm" type="password" name="confirm" required class="block w-full rounded-xl border border-blue-200 px-4 py-2 pr-10 bg-white focus:ring focus:ring-blue-200 focus:border-blue-400" placeholder="Confirm password" />
        <button type="button" class="icon-btn" data-toggle-target="#signup-confirm">
          <i class="fa-solid fa-eye-slash"></i>
        </button>
      </div>
    </label>

    <label class="block">
      <span class="text-sm text-slate-700">Contact Number</span>
      <input type="tel" name="contact" class="mt-1 block w-full rounded-xl border border-blue-200 px-4 py-2 bg-white focus:ring focus:ring-blue-200 focus:border-blue-400" placeholder="+1 (555) 555-5555" />
    </label>

    <button type="submit" class="w-full mt-2 inline-block py-2.5 rounded-xl text-white bg-blue-600 btn-blue focus-ring">Sign Up</button>

    <div class="mt-5 text-sm text-center text-slate-600">
      Already have an account?
      <button type="button" id="to-login" class="text-blue-600 font-medium hover:underline">Login</button>
    </div>
  </div>
</form>
