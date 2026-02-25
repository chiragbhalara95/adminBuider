<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Dashboard')</title>
  <link rel="icon" href="{{ asset('favicon.ico') }}" />

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  @stack('head')
</head>
<body
  x-data="{ page: 'dashboard', loaded: true, darkMode: false, sidebarToggle: false }"
  x-init="darkMode = JSON.parse(localStorage.getItem('darkMode')); $watch('darkMode', v => localStorage.setItem('darkMode', JSON.stringify(v)))"
  :class="{ 'dark bg-gray-900': darkMode === true }"
>
  @include('layouts.partials.preloader')

  <div class="flex h-screen overflow-hidden bg-gray-50 dark:bg-gray-900">
    @include('layouts.partials.sidebar')

    <div class="relative flex flex-1 flex-col overflow-x-hidden overflow-y-auto">
      @include('layouts.partials.overlay')
      @include('layouts.partials.header')

      <main>
        <div class="mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6">
          @yield('content')
        </div>
      </main>
    </div>
  </div>

  @stack('scripts')
</body>
</html>
