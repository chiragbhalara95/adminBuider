@props([
  'type' => 'button',
  'variant' => 'primary',
])

@php
  $base = 'inline-flex items-center justify-center rounded-lg px-4 py-2.5 text-sm font-medium transition focus:outline-none focus:ring-2 focus:ring-offset-2';
  $variants = [
    'primary' => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500',
    'secondary' => 'border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 focus:ring-gray-400',
    'success' => 'bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-emerald-500',
    'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
  ];
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $base.' '.($variants[$variant] ?? $variants['primary'])]) }}>
  {{ $slot }}
</button>
