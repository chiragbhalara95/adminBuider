@props([
  'avatar' => null,
  'name' => 'System',
  'message' => '',
  'category' => 'Update',
  'time' => 'Just now',
  'href' => '#',
])

<li>
  <a
    href="{{ $href }}"
    class="flex gap-3 rounded-lg border-b border-gray-100 px-4.5 py-3 hover:bg-gray-100 dark:border-gray-800 dark:hover:bg-white/5"
  >
    <span class="relative z-1 block h-10 w-full max-w-10 rounded-full">
      @if ($avatar)
        <img src="{{ $avatar }}" alt="{{ $name }}" class="overflow-hidden rounded-full" />
      @else
        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-100 text-brand-600 dark:bg-brand-500/20 dark:text-brand-400">
          {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($name, 0, 1)) }}
        </span>
      @endif
      <span class="bg-success-500 absolute right-0 bottom-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-gray-900"></span>
    </span>

    <span class="block">
      <span class="text-theme-sm mb-1.5 block text-gray-500 dark:text-gray-400">
        <span class="font-medium text-gray-800 dark:text-white/90">{{ $name }}</span>
        {{ $message }}
      </span>

      <span class="text-theme-xs flex items-center gap-2 text-gray-500 dark:text-gray-400">
        <span>{{ $category }}</span>
        <span class="h-1 w-1 rounded-full bg-gray-400"></span>
        <span>{{ $time }}</span>
      </span>
    </span>
  </a>
</li>
