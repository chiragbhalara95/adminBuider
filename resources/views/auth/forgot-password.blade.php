@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('auth-main')
  <div class="flex flex-col flex-1 w-full lg:w-1/2">
    <div class="w-full max-w-md pt-10 mx-auto">
      <a
        href="{{ route('login') }}"
        class="inline-flex items-center text-sm text-gray-500 transition-colors hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
      >
        <svg class="stroke-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
          <path d="M12.7083 5L7.5 10.2083L12.7083 15.4167" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        Back to sign in
      </a>
    </div>

    <div class="flex flex-col justify-center flex-1 w-full max-w-md mx-auto">
      <div class="mb-5 sm:mb-8">
        <h1 class="mb-2 font-semibold text-gray-800 text-title-sm dark:text-white/90 sm:text-title-md">Forgot Password</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Enter your email and we will send you a reset link.</p>
      </div>

      @if (session('status'))
        <div class="mb-4 rounded-lg border border-success-200 bg-success-50 px-4 py-3 text-sm text-success-700">
          {{ session('status') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="mb-4 rounded-lg border border-error-200 bg-error-50 px-4 py-3 text-sm text-error-700">
          {{ $errors->first() }}
        </div>
      @endif

      @php
        $forgotFields = [
          [
            'type' => 'email',
            'name' => 'email',
            'label' => 'Email',
            'placeholder' => 'info@gmail.com',
            'required' => true,
            'class' => 'h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800',
          ],
        ];
      @endphp

      <x-dynamic-form :action="route('password.email')" method="POST" :fields="$forgotFields" :show-submit="false" class="space-y-5">
        <button type="submit" class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
          Send Reset Link
        </button>
      </x-dynamic-form>
    </div>
  </div>

  <div class="relative items-center hidden w-full h-full bg-brand-950 dark:bg-white/5 lg:grid lg:w-1/2">
    <div class="flex items-center justify-center z-1">
      <div class="absolute right-0 top-0 -z-1 w-full max-w-[250px] xl:max-w-[450px]"><img src="{{ asset('images/shape/grid-01.svg') }}" alt="grid" /></div>
      <div class="absolute bottom-0 left-0 -z-1 w-full max-w-[250px] rotate-180 xl:max-w-[450px]"><img src="{{ asset('images/shape/grid-01.svg') }}" alt="grid" /></div>
      <div class="flex flex-col items-center max-w-xs">
        <a href="{{ route('dashboard') }}" class="block mb-4"><img src="{{ asset('images/logo/auth-logo.svg') }}" alt="Logo" /></a>
        <p class="text-center text-gray-400 dark:text-white/60">Free and Open-Source Tailwind CSS Admin Dashboard Template</p>
      </div>
    </div>
  </div>
@endsection
