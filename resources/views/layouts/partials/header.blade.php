<header class="sticky top-0 z-99999 flex w-full border-b border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
  <div class="flex grow items-center justify-between px-4 py-3 lg:px-6 lg:py-4">
    <div class="flex items-center gap-3">
      <button
        :class="sidebarToggle ? 'bg-gray-100 dark:bg-gray-800' : ''"
        class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 text-gray-500 dark:border-gray-800 dark:text-gray-400"
        @click.stop="sidebarToggle = !sidebarToggle"
      >
        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path d="M2.5 5.5h15M2.5 10h15M2.5 14.5h10" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
        </svg>
      </button>

      <div class="hidden lg:block">
        <input
          type="text"
          placeholder="Search..."
          class="h-10 w-[300px] rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white/90"
        />
      </div>
    </div>

    <div class="flex items-center gap-3">
      <button
        class="flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 dark:border-gray-800 dark:text-gray-400 dark:hover:bg-gray-800"
        @click.prevent="darkMode = !darkMode"
      >
        <span class="text-sm">DM</span>
      </button>

      <div class="flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-2 dark:border-gray-800">
        <img src="{{ asset('images/user/owner.jpg') }}" alt="User" class="h-8 w-8 rounded-full object-cover" />
        <div class="text-sm leading-tight">
          <p class="font-medium text-gray-800 dark:text-white/90">{{ auth()->user()->name ?? 'User' }}</p>
          <p class="text-gray-500 dark:text-gray-400">Admin</p>
        </div>
      </div>
    </div>
  </div>
</header>
