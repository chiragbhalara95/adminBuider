@props([
  'name' => null,
  'id' => null,
  'rows' => 4,
  'value' => null,
])

<textarea
  name="{{ $name }}"
  id="{{ $id ?? $name }}"
  rows="{{ $rows }}"
  {{ $attributes->merge(['class' => 'w-full rounded-lg border border-gray-300 bg-white dark:border-gray-700 dark:bg-gray-900 px-4 py-3 text-sm text-gray-900 placeholder:text-gray-400 dark:text-white/90 dark:placeholder:text-white/30 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-500 dark:disabled:bg-gray-800 dark:disabled:text-gray-500']) }}
>{{ old($name, $value) }}</textarea>

