@props([
  'name' => null,
  'id' => null,
  'options' => [],
  'selected' => [],
  'size' => 5,
])

@php
  $baseName = $name ? preg_replace('/\[\]$/', '', $name) : $name;
  $selectedValues = old($baseName, $selected);
  if (!is_array($selectedValues)) {
    $selectedValues = $selectedValues !== null && $selectedValues !== '' ? [$selectedValues] : [];
  }

  $fieldName = $baseName && !str_ends_with($baseName, '[]') ? $baseName.'[]' : $baseName;
@endphp

<select
  name="{{ $fieldName }}"
  id="{{ $id ?? $baseName }}"
  multiple
  size="{{ (int) $size > 0 ? (int) $size : 5 }}"
  {{ $attributes->merge(['class' => 'min-h-32 w-full rounded-lg border border-gray-300 bg-white dark:border-gray-700 dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-500 dark:disabled:bg-gray-800 dark:disabled:text-gray-500']) }}
>
  @foreach($options as $key => $label)
    <option value="{{ $key }}" @selected(in_array((string) $key, array_map('strval', $selectedValues), true))>{{ $label }}</option>
  @endforeach
</select>

