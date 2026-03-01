@extends('layouts.theme')

@section('title', 'Profile')
@section('body_class', 'bg-gray-50 p-6')

@section('content')
  <div class="mx-auto max-w-6xl space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="px-5 py-4 sm:px-6 sm:py-5">
        <h1 class="text-xl font-semibold text-gray-900 dark:text-white/90">Profile</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">TailAdmin profile page integrated into Blade view.</p>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
      <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-7">Profile</h3>

      <div class="mb-6 rounded-2xl border border-gray-200 p-5 dark:border-gray-800 lg:p-6">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
          <div class="flex w-full flex-col items-center gap-6 xl:flex-row">
            <div class="h-20 w-20 overflow-hidden rounded-full border border-gray-200 dark:border-gray-800">
              <img class="h-full w-full object-cover" src="{{ $profile['avatar'] }}" alt="Profile avatar" />
            </div>

            <div class="order-3 xl:order-2">
              <h4 class="mb-2 text-center text-lg font-semibold text-gray-800 dark:text-white/90 xl:text-left">{{ $profile['name'] }}</h4>
              <div class="flex flex-col items-center gap-1 text-center xl:flex-row xl:gap-3 xl:text-left">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $profile['role'] }}</p>
                <div class="hidden h-3.5 w-px bg-gray-300 dark:bg-gray-700 xl:block"></div>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $profile['location'] }}</p>
              </div>
            </div>

            <div class="order-2 flex grow items-center gap-2 xl:order-3 xl:justify-end">
              @foreach($profile['socials'] as $social)
                <button type="button" class="flex h-11 w-11 items-center justify-center rounded-full border border-gray-300 bg-white text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">{{ $social }}</button>
              @endforeach
            </div>
          </div>

          <button type="button" class="flex w-full items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 lg:inline-flex lg:w-auto">Edit</button>
        </div>
      </div>

      <div class="mb-6 rounded-2xl border border-gray-200 p-5 dark:border-gray-800 lg:p-6">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
          <div>
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">Personal Information</h4>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7 2xl:gap-x-32">
              @foreach($personalInformation as $label => $value)
                <div>
                  <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">{{ $label }}</p>
                  <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $value }}</p>
                </div>
              @endforeach
            </div>
          </div>

          <button type="button" class="flex w-full items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 lg:inline-flex lg:w-auto">Edit</button>
        </div>
      </div>

      <div class="rounded-2xl border border-gray-200 p-5 dark:border-gray-800 lg:p-6">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
          <div>
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">Address</h4>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7 2xl:gap-x-32">
              @foreach($address as $label => $value)
                <div>
                  <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">{{ $label }}</p>
                  <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $value }}</p>
                </div>
              @endforeach
            </div>
          </div>

          <button type="button" class="flex w-full items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 lg:inline-flex lg:w-auto">Edit</button>
        </div>
      </div>
    </div>
  </div>
@endsection
