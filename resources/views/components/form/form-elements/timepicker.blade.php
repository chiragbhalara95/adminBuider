@props([
  'name' => null,
  'id' => null,
  'value' => null,
])

<input
  type="time"
  name="{{ $name }}"
  id="{{ $id ?? $name }}"
  value="{{ old($name, $value) }}"
  {{ $attributes->merge(['class' => 'h-11 w-full rounded-lg border border-gray-300 bg-white dark:border-gray-700 dark:bg-gray-900 px-4 py-2.5 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-500 dark:disabled:bg-gray-800 dark:disabled:text-gray-500']) }}
/>

