@props([
  'name' => null,
  'id' => null,
  'value' => null,
  'type' => 'text',
  'prepend' => null,
  'append' => null,
])

<div class="flex w-full overflow-hidden rounded-lg border border-gray-300 bg-white dark:border-gray-700 dark:bg-gray-900 focus-within:border-indigo-500 focus-within:ring-2 focus-within:ring-indigo-200">
  @if($prepend)
    <span class="inline-flex items-center border-r border-gray-300 bg-gray-50 px-3 text-sm text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
      {{ $prepend }}
    </span>
  @endif

  <input
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $id ?? $name }}"
    value="{{ old($name, $value) }}"
    {{ $attributes->merge(['class' => 'h-11 w-full border-0 bg-transparent px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 dark:text-white/90 dark:placeholder:text-white/30 focus:outline-none focus:ring-0 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-500 dark:disabled:bg-gray-800 dark:disabled:text-gray-500']) }}
  />

  @if($append)
    <span class="inline-flex items-center border-l border-gray-300 bg-gray-50 px-3 text-sm text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
      {{ $append }}
    </span>
  @endif
</div>

