@props([
  'name' => null,
  'id' => null,
  'options' => [],
  'selected' => [],
])

@php
  $selectedValues = old($name, $selected);
  if (!is_array($selectedValues)) {
    $selectedValues = [$selectedValues];
  }

  $fieldName = $name && !str_ends_with($name, '[]') ? $name.'[]' : $name;
@endphp

<select
  name="{{ $fieldName }}"
  id="{{ $id ?? $name }}"
  multiple
  {{ $attributes->merge(['class' => 'min-h-32 w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-500']) }}
>
  @foreach($options as $key => $label)
    <option value="{{ $key }}" @selected(in_array((string) $key, array_map('strval', $selectedValues), true))>{{ $label }}</option>
  @endforeach
</select>
