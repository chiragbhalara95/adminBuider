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
  {{ $attributes->merge(['class' => 'block w-full cursor-pointer rounded-lg border border-gray-300 bg-white text-sm text-gray-700 file:mr-4 file:h-11 file:border-0 file:bg-indigo-50 file:px-4 file:text-sm file:font-medium file:text-indigo-700 hover:file:bg-indigo-100 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200']) }}
/>
