<div x-data="{ open: false, notifying: true }" class="relative" @click.outside="open = false">
  <button
    class="hover:text-dark-900 relative flex h-11 w-11 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
    @click.prevent="open = !open; notifying = false"
  >
    <span
      :class="notifying ? 'flex' : 'hidden'"
      class="absolute top-0.5 right-0 z-1 h-2 w-2 rounded-full bg-orange-400"
    >
      <span class="absolute -z-1 inline-flex h-full w-full animate-ping rounded-full bg-orange-400 opacity-75"></span>
    </span>

    <svg class="fill-current" width="18" height="18" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
      <path d="M10 1.75a.75.75 0 0 1 .75.75v.39a6.25 6.25 0 0 1 5 6.11v4.71h.92a.75.75 0 1 1 0 1.5H3.33a.75.75 0 0 1 0-1.5h.92V9a6.25 6.25 0 0 1 5-6.11V2.5a.75.75 0 0 1 .75-.75Zm4.25 11.96V9a4.75 4.75 0 1 0-9.5 0v4.71h9.5Zm-5.9 2.5a.75.75 0 0 1 .75.75.9.9 0 1 0 1.8 0 .75.75 0 1 1 1.5 0 2.4 2.4 0 1 1-4.8 0 .75.75 0 0 1 .75-.75Z"/>
    </svg>
  </button>

  <div
    x-show="open"
    x-transition
    class="shadow-theme-lg dark:bg-gray-dark absolute -right-[240px] mt-[17px] flex h-[480px] w-[350px] flex-col rounded-2xl border border-gray-200 bg-white p-3 sm:w-[361px] lg:right-0 dark:border-gray-800"
    style="display: none;"
  >
    <div class="mb-3 flex items-center justify-between border-b border-gray-100 pb-3 dark:border-gray-800">
      <h5 class="text-lg font-semibold text-gray-800 dark:text-white/90">Notification</h5>
      <button class="text-theme-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white">Mark all as read</button>
    </div>

    <ul class="custom-scrollbar flex h-auto flex-col overflow-y-auto rounded-xl">
      <x-header.notification-item
        :avatar="asset('images/user/user-02.jpg')"
        name="Nora Stone"
        message="requested access for new dashboard layout."
        category="Project"
        time="5 min ago"
      />
      <x-header.notification-item
        :avatar="asset('images/user/user-03.jpg')"
        name="Dev Team"
        message="deployed a new release to production."
        category="System"
        time="20 min ago"
      />
      <x-header.notification-item
        :avatar="asset('images/user/user-04.jpg')"
        name="Security"
        message="updated password policy settings."
        category="Alert"
        time="1 hour ago"
      />
    </ul>

    <a
      href="#"
      class="text-theme-sm shadow-theme-xs mt-3 flex justify-center rounded-lg border border-gray-300 bg-white p-3 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
    >
      View All Notification
    </a>
  </div>
</div>
