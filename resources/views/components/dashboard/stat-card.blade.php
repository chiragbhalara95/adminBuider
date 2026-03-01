@props([
  'label',
  'value',
  'change' => null,
  'tone' => 'neutral',
])

@php
  $toneMap = [
    'success' => 'text-emerald-600 dark:text-emerald-400',
    'danger' => 'text-red-600 dark:text-red-400',
    'warning' => 'text-amber-600 dark:text-amber-400',
    'info' => 'text-blue-600 dark:text-blue-400',
    'neutral' => 'text-gray-500 dark:text-gray-400',
  ];
@endphp

<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
  <p class="text-sm text-gray-500 dark:text-gray-400">{{ $label }}</p>
  <p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white/90">{{ $value }}</p>
  @if($change)
    <p class="mt-2 text-sm {{ $toneMap[$tone] ?? $toneMap['neutral'] }}">{{ $change }}</p>
  @endif
</div>

