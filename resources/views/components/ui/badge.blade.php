@props([
  'variant' => 'default',
  'size' => 'md',
])

@php
  $base = 'inline-flex items-center rounded-full font-medium';
  $sizes = [
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-2.5 py-0.5 text-xs',
    'lg' => 'px-3 py-1 text-sm',
  ];
  $variants = [
    'default' => 'bg-gray-100 text-gray-800',
    'primary' => 'bg-indigo-100 text-indigo-800',
    'success' => 'bg-emerald-100 text-emerald-800',
    'warning' => 'bg-amber-100 text-amber-800',
    'danger' => 'bg-red-100 text-red-800',
  ];
@endphp

<span {{ $attributes->merge(['class' => $base.' '.($sizes[$size] ?? $sizes['md']).' '.($variants[$variant] ?? $variants['default'])]) }}>
  {{ $slot }}
</span>
