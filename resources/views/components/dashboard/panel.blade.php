@props([
  'title',
  'subtitle' => null,
])

<section class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
  <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 sm:px-6 sm:py-5">
    <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">{{ $title }}</h3>
    @if($subtitle)
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $subtitle }}</p>
    @endif
  </div>
  <div class="p-5 sm:p-6">
    {{ $slot }}
  </div>
</section>

