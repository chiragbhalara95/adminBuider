@props([
  'name' => null,
  'id' => null,
  'accept' => null,
  'multiple' => false,
  'label' => 'Drop files here or click to browse',
])

<label
  for="{{ $id ?? $name }}"
  class="group flex w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 dark:border-gray-700 dark:bg-gray-900 px-6 py-10 text-center transition hover:border-indigo-400 hover:bg-indigo-50 dark:hover:border-indigo-500 dark:hover:bg-gray-800"
>
  <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-indigo-700">{{ $label }}</span>
  <span class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maximum upload size depends on server settings.</span>

  <input
    type="file"
    name="{{ $multiple ? ($name && !str_ends_with($name, '[]') ? $name.'[]' : $name) : $name }}"
    id="{{ $id ?? $name }}"
    class="sr-only"
    @if($accept) accept="{{ $accept }}" @endif
    @if($multiple) multiple @endif
    {{ $attributes }}
  />
</label>

