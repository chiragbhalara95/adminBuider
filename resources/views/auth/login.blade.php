<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign In</title>
  <link rel="icon" href="{{ asset('favicon.ico') }}" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body
  x-data="{ loaded: true, darkMode: false }"
  x-init="darkMode = JSON.parse(localStorage.getItem('darkMode')); $watch('darkMode', v => localStorage.setItem('darkMode', JSON.stringify(v)))"
  :class="{ 'dark bg-gray-900': darkMode === true }"
>
  <div class="relative p-6 bg-white z-1 dark:bg-gray-900 sm:p-0">
    <div class="relative flex flex-col justify-center w-full h-screen dark:bg-gray-900 sm:p-0 lg:flex-row">
      <div class="flex flex-col flex-1 w-full lg:w-1/2">
        <div class="w-full max-w-md pt-10 mx-auto">
          <a href="#" class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400">TailAdmin Theme</a>
        </div>

        <div class="flex flex-col justify-center flex-1 w-full max-w-md mx-auto">
          <div class="mb-5 sm:mb-8">
            <h1 class="mb-2 font-semibold text-gray-800 text-title-sm dark:text-white/90 sm:text-title-md">Sign In</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Enter your email and password to sign in.</p>
          </div>

          @if ($errors->any())
            <div class="mb-4 rounded-lg border border-error-200 bg-error-50 px-4 py-3 text-sm text-error-700">
              {{ $errors->first() }}
            </div>
          @endif

          <form method="POST" action="{{ route('login.submit') }}" class="space-y-5">
            @csrf
            <div>
              <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Email</label>
              <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="email"
                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                placeholder="info@gmail.com"
              />
            </div>

            <div>
              <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Password</label>
              <input
                type="password"
                name="password"
                required
                autocomplete="current-password"
                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                placeholder="Enter your password"
              />
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-400">
              <input type="checkbox" name="remember" class="h-4 w-4" />
              Keep me logged in
            </label>

            <button type="submit" class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
              Sign In
            </button>
          </form>
        </div>
      </div>

      <div class="relative hidden w-full h-full bg-brand-950 lg:grid lg:w-1/2">
        <div class="flex items-center justify-center z-1">
          <div class="max-w-xs">
            <img src="{{ asset('images/logo/logo.svg') }}" class="mx-auto mb-8" alt="Logo" />
            <p class="text-center text-gray-300">TailAdmin layout integrated into Laravel after login.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
