@props([
  'name' => null,
  'id' => null,
  'accept' => null,
])

<input
  type="file"
  name="{{ $name }}"
  id="{{ $id ?? $name }}"
  @if($accept) accept="{{ $accept }}" @endif
  {{ $attributes->merge(['class' => 'block w-full cursor-pointer rounded-lg border border-gray-300 bg-white text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 file:mr-3 file:rounded-md file:border file:border-gray-300 dark:file:border-gray-600 file:bg-gray-100 dark:file:bg-gray-800 file:px-4 file:py-2 file:text-sm file:font-medium file:text-gray-700 dark:file:text-gray-200 hover:file:bg-gray-200 dark:hover:file:bg-gray-700 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200']) }}
/>

