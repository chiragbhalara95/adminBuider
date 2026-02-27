<header
  x-data="{ notificationOpen: false, notifying: true }"
  @click.outside="notificationOpen = false"
  class="sticky top-0 z-99999 flex w-full border-b border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900"
>
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

    <div class="flex items-center gap-2 sm:gap-3">
      <div class="relative">
        <button
          class="relative flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
          @click.prevent="notificationOpen = !notificationOpen; notifying = false"
        >
          <span
            :class="notifying ? 'flex' : 'hidden'"
            class="absolute right-2 top-2 h-2 w-2 rounded-full bg-orange-400"
          ></span>
          <svg class="fill-current" width="18" height="18" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 1.75a.75.75 0 0 1 .75.75v.39a6.25 6.25 0 0 1 5 6.11v4.71h.92a.75.75 0 1 1 0 1.5H3.33a.75.75 0 0 1 0-1.5h.92V9a6.25 6.25 0 0 1 5-6.11V2.5a.75.75 0 0 1 .75-.75Zm4.25 11.96V9a4.75 4.75 0 1 0-9.5 0v4.71h9.5Zm-5.9 2.5a.75.75 0 0 1 .75.75.9.9 0 1 0 1.8 0 .75.75 0 1 1 1.5 0 2.4 2.4 0 1 1-4.8 0 .75.75 0 0 1 .75-.75Z"/>
          </svg>
        </button>

        <div
          x-show="notificationOpen"
          x-transition
          class="absolute right-0 mt-2 w-72 rounded-xl border border-gray-200 bg-white p-3 shadow-lg dark:border-gray-800 dark:bg-gray-900"
          style="display: none;"
        >
          <p class="text-sm font-medium text-gray-800 dark:text-white/90">Notifications</p>
          <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">No new notifications.</p>
        </div>
      </div>

      <button
        class="flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
        @click.prevent="darkMode = !darkMode"
      >
        <svg
          class="hidden dark:block"
          width="18"
          height="18"
          viewBox="0 0 20 20"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path d="M10 3a.75.75 0 0 1 .75.75V5a.75.75 0 0 1-1.5 0V3.75A.75.75 0 0 1 10 3Zm0 10.25A3.25 3.25 0 1 0 10 6.75a3.25 3.25 0 0 0 0 6.5Zm0 1.5a4.75 4.75 0 1 1 0-9.5 4.75 4.75 0 0 1 0 9.5ZM4.7 5.76a.75.75 0 1 1 1.06-1.06l.89.88a.75.75 0 1 1-1.06 1.06l-.9-.88Zm8.64 8.64a.75.75 0 0 1 1.06 0l.89.9a.75.75 0 0 1-1.06 1.05l-.89-.88a.75.75 0 0 1 0-1.07ZM3 10a.75.75 0 0 1 .75-.75H5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 10Zm11.25 0a.75.75 0 0 1 .75-.75h1.25a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75ZM5.76 15.3a.75.75 0 1 1-1.06-1.06l.88-.89a.75.75 0 1 1 1.06 1.06l-.88.89Zm8.64-8.64a.75.75 0 0 1-1.06-1.06l.88-.89a.75.75 0 0 1 1.06 1.06l-.88.89ZM10 15a.75.75 0 0 1 .75.75V17a.75.75 0 0 1-1.5 0v-1.25A.75.75 0 0 1 10 15Z" fill="currentColor"/>
        </svg>
        <svg
          class="dark:hidden"
          width="18"
          height="18"
          viewBox="0 0 20 20"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path d="M17.05 11.58a.75.75 0 0 1 .2.76 7.95 7.95 0 1 1-9.59-9.59.75.75 0 0 1 .8 1.15A6.45 6.45 0 1 0 16.1 11.2a.75.75 0 0 1 .95.37Z" fill="currentColor"/>
        </svg>
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
