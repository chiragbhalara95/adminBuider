@props([
  'title',
  'subtitle' => null,
])

<div class="rounded-2xl border border-gray-200 bg-white px-5 py-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:py-5">
  <h1 class="text-xl font-semibold text-gray-900 dark:text-white/90">{{ $title }}</h1>
  @if($subtitle)
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $subtitle }}</p>
  @endif
</div>

