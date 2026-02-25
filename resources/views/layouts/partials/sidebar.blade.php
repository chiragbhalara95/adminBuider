<aside
  :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
  class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
>
  <div :class="sidebarToggle ? 'justify-center' : 'justify-between'" class="flex items-center gap-2 pt-8 pb-7">
    <a href="{{ route('dashboard') }}">
      <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
        <img class="dark:hidden" src="{{ asset('images/logo/logo.svg') }}" alt="Logo" />
        <img class="hidden dark:block" src="{{ asset('images/logo/logo-dark.svg') }}" alt="Logo" />
      </span>
      <img class="logo-icon" :class="sidebarToggle ? 'lg:block' : 'hidden'" src="{{ asset('images/logo/logo-icon.svg') }}" alt="Logo" />
    </a>
  </div>

  <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
    <nav>
      <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
          <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">MENU</span>
        </h3>

        <ul class="mb-6 flex flex-col gap-2">
          <li>
            <a href="{{ route('dashboard') }}" class="menu-item group menu-item-active">
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Dashboard</span>
            </a>
          </li>
        </ul>

        <form method="POST" action="{{ route('logout') }}" class="mt-6">
          @csrf
          <button type="submit" class="menu-item group menu-item-inactive w-full text-left">
            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Logout</span>
          </button>
        </form>
      </div>
    </nav>
  </div>
</aside>
