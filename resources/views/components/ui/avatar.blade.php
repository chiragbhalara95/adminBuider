@props([
  'src' => null,
  'alt' => 'Avatar',
  'size' => 'md',
  'name' => null,
])

@php
  $sizes = [
    'xs' => 'h-6 w-6 text-xs',
    'sm' => 'h-8 w-8 text-xs',
    'md' => 'h-10 w-10 text-sm',
    'lg' => 'h-12 w-12 text-base',
    'xl' => 'h-16 w-16 text-lg',
  ];
  $sizeClass = $sizes[$size] ?? $sizes['md'];
  $initial = $name ? mb_substr(trim($name), 0, 1) : '?';
@endphp

@if ($src)
  <img src="{{ $src }}" alt="{{ $alt }}" {{ $attributes->merge(['class' => 'inline-flex shrink-0 rounded-full object-cover '.$sizeClass]) }}>
@else
  <span {{ $attributes->merge(['class' => 'inline-flex shrink-0 items-center justify-center rounded-full bg-gray-100 font-medium text-gray-700 '.$sizeClass]) }}>
    {{ strtoupper($initial) }}
  </span>
@endif
