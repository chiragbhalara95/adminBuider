@props([
  'name' => null,
  'show' => false,
  'maxWidth' => '2xl',
  'closeable' => true,
])

@php
  $maxWidths = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '3xl' => 'sm:max-w-3xl',
    '4xl' => 'sm:max-w-4xl',
    '5xl' => 'sm:max-w-5xl',
    '6xl' => 'sm:max-w-6xl',
    '7xl' => 'sm:max-w-7xl',
  ];
  $maxWidthClass = $maxWidths[$maxWidth] ?? $maxWidths['2xl'];
@endphp

<div
  x-data="{ open: @js($show) }"
  @if($name)
    x-on:open-modal.window="if ($event.detail === '{{ $name }}') open = true"
    x-on:close-modal.window="if ($event.detail === '{{ $name }}') open = false"
  @endif
  x-on:keydown.escape.window="@if($closeable) open = false @endif"
  x-show="open"
  class="fixed inset-0 z-50 overflow-y-auto"
  style="display: none;"
>
  <div class="flex min-h-screen items-end justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0">
    <div
      class="fixed inset-0 bg-gray-900/50 transition-opacity"
      x-show="open"
      x-transition.opacity
      @if($closeable) x-on:click="open = false" @endif
    ></div>

    <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

    <div
      class="inline-block w-full transform overflow-hidden rounded-xl bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:align-middle {{ $maxWidthClass }}"
      x-show="open"
      x-transition
      {{ $attributes }}
    >
      {{ $slot }}
    </div>
  </div>
</div>
