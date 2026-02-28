@extends('layouts.auth')

@section('title', 'Sign In')

@section('auth-main')
  <div class="flex flex-col flex-1 w-full lg:w-1/2">
    <div class="w-full max-w-md pt-10 mx-auto">
      <a
        href="{{ route('dashboard') }}"
        class="inline-flex items-center text-sm text-gray-500 transition-colors hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
      >
        <svg class="stroke-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
          <path d="M12.7083 5L7.5 10.2083L12.7083 15.4167" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        Back to dashboard
      </a>
    </div>

    <div class="flex flex-col justify-center flex-1 w-full max-w-md mx-auto">
      <div>
        <div class="mb-5 sm:mb-8">
          <h1 class="mb-2 font-semibold text-gray-800 text-title-sm dark:text-white/90 sm:text-title-md">Sign In</h1>
          <p class="text-sm text-gray-500 dark:text-gray-400">Enter your email and password to sign in!</p>
        </div>

        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-5">
          <button type="button" class="inline-flex items-center justify-center gap-3 py-3 text-sm font-normal text-gray-700 transition-colors bg-gray-100 rounded-lg px-7 hover:bg-gray-200 hover:text-gray-800 dark:bg-white/5 dark:text-white/90 dark:hover:bg-white/10">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M18.7511 10.1944C18.7511 9.47495 18.6915 8.94995 18.5626 8.40552H10.1797V11.6527H15.1003C15.0011 12.4597 14.4654 13.675 13.2749 14.4916L13.2582 14.6003L15.9087 16.6126L16.0924 16.6305C17.7788 15.1041 18.7511 12.8583 18.7511 10.1944Z" fill="#4285F4" />
              <path d="M10.1788 18.75C12.5895 18.75 14.6133 17.9722 16.0915 16.6305L13.274 14.4916C12.5201 15.0068 11.5081 15.3666 10.1788 15.3666C7.81773 15.3666 5.81379 13.8402 5.09944 11.7305L4.99473 11.7392L2.23868 13.8295L2.20264 13.9277C3.67087 16.786 6.68674 18.75 10.1788 18.75Z" fill="#34A853" />
              <path d="M5.10014 11.7305C4.91165 11.186 4.80257 10.6027 4.80257 9.99992C4.80257 9.3971 4.91165 8.81379 5.09022 8.26935L5.08523 8.1534L2.29464 6.02954L2.20333 6.0721C1.5982 7.25823 1.25098 8.5902 1.25098 9.99992C1.25098 11.4096 1.5982 12.7415 2.20333 13.9277L5.10014 11.7305Z" fill="#FBBC05" />
              <path d="M10.1789 4.63331C11.8554 4.63331 12.9864 5.34303 13.6312 5.93612L16.1511 3.525C14.6035 2.11528 12.5895 1.25 10.1789 1.25C6.68676 1.25 3.67088 3.21387 2.20264 6.07218L5.08953 8.26943C5.81381 6.15972 7.81776 4.63331 10.1789 4.63331Z" fill="#EB4335" />
            </svg>
            Sign in with Google
          </button>

          <button type="button" class="inline-flex items-center justify-center gap-3 py-3 text-sm font-normal text-gray-700 transition-colors bg-gray-100 rounded-lg px-7 hover:bg-gray-200 hover:text-gray-800 dark:bg-white/5 dark:text-white/90 dark:hover:bg-white/10">
            <svg width="21" class="fill-current" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M15.6705 1.875H18.4272L12.4047 8.75833L19.4897 18.125H13.9422L9.59717 12.4442L4.62554 18.125H1.86721L8.30887 10.7625L1.51221 1.875H7.20054L11.128 7.0675L15.6705 1.875ZM14.703 16.475H16.2305L6.37054 3.43833H4.73137L14.703 16.475Z" />
            </svg>
            Sign in with X
          </button>
        </div>

        <div class="relative py-3 sm:py-5">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-200 dark:border-gray-800"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="p-2 text-gray-400 bg-white dark:bg-gray-900 sm:px-5 sm:py-2">Or</span>
          </div>
        </div>

        @if ($errors->any())
          <div class="mb-4 rounded-lg border border-error-200 bg-error-50 px-4 py-3 text-sm text-error-700">
            {{ $errors->first() }}
          </div>
        @endif

        @if (session('status'))
          <div class="mb-4 rounded-lg border border-success-200 bg-success-50 px-4 py-3 text-sm text-success-700">
            {{ session('status') }}
          </div>
        @endif

        @if (session('unverified_email'))
          <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
            @csrf
            <input type="hidden" name="email" value="{{ session('unverified_email') }}" />
            <button type="submit" class="text-sm font-medium text-brand-500 hover:text-brand-600 dark:text-brand-400">
              Resend verification email
            </button>
          </form>
        @endif

        @php
          $loginFields = [
            [
              'type' => 'email',
              'name' => 'email',
              'label' => 'Email',
              'placeholder' => 'info@gmail.com',
              'required' => true,
              'attributes' => [
                'autocomplete' => 'email',
              ],
              'class' => 'h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800',
            ],
            [
              'type' => 'password',
              'name' => 'password',
              'label' => 'Password',
              'placeholder' => 'Enter your password',
              'required' => true,
              'attributes' => [
                'autocomplete' => 'current-password',
              ],
              'class' => 'h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800',
            ],
          ];
        @endphp

        <x-dynamic-form :action="route('login.submit')" method="POST" :fields="$loginFields" :show-submit="false" class="space-y-5">
          <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-400">
              <input type="checkbox" name="remember" value="1" @checked(old('remember')) class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500/30" />
              Keep me logged in
            </label>

            <a href="{{ route('password.request') }}" class="text-sm text-brand-500 hover:text-brand-600 dark:text-brand-400">Forgot password?</a>
          </div>

          <div>
            <button type="submit" class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
              Sign In
            </button>
          </div>
        </x-dynamic-form>

        <div class="mt-5">
          <p class="text-sm font-normal text-center text-gray-700 dark:text-gray-400 sm:text-start">
            Don't have an account?
            <a href="{{ route('signup') }}" class="text-brand-500 hover:text-brand-600 dark:text-brand-400">Sign Up</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="relative items-center hidden w-full h-full bg-brand-950 dark:bg-white/5 lg:grid lg:w-1/2">
    <div class="flex items-center justify-center z-1">
      <div class="absolute right-0 top-0 -z-1 w-full max-w-[250px] xl:max-w-[450px]">
        <img src="{{ asset('images/shape/grid-01.svg') }}" alt="grid" />
      </div>
      <div class="absolute bottom-0 left-0 -z-1 w-full max-w-[250px] rotate-180 xl:max-w-[450px]">
        <img src="{{ asset('images/shape/grid-01.svg') }}" alt="grid" />
      </div>

      <div class="flex flex-col items-center max-w-xs">
        <a href="{{ route('dashboard') }}" class="block mb-4">
          <img src="{{ asset('images/logo/auth-logo.svg') }}" alt="Logo" />
        </a>
        <p class="text-center text-gray-400 dark:text-white/60">Free and Open-Source Tailwind CSS Admin Dashboard Template</p>
      </div>
    </div>
  </div>
@endsection
