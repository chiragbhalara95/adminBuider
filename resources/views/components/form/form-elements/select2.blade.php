@props([
  'name' => null,
  'id' => null,
  'options' => [],
  'selected' => null,
  'placeholder' => 'Select option',
  'multiple' => false,
  'allowClear' => true,
  'dropdownParent' => null,
])

@php
  $selectedValues = old($name, $selected);
  if ($multiple && !is_array($selectedValues)) {
    $selectedValues = $selectedValues !== null ? [$selectedValues] : [];
  }

  $fieldName = $multiple && $name && !str_ends_with($name, '[]') ? $name.'[]' : $name;
@endphp

<select
  name="{{ $fieldName }}"
  id="{{ $id ?? $name }}"
  data-select2="true"
  data-placeholder="{{ $placeholder }}"
  data-allow-clear="{{ $allowClear ? 'true' : 'false' }}"
  @if($dropdownParent) data-dropdown-parent="{{ $dropdownParent }}" @endif
  @if($multiple) multiple @endif
  {{ $attributes->merge(['class' => 'h-11 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200']) }}
>
  @unless($multiple)
    <option value="">{{ $placeholder }}</option>
  @endunless

  @foreach($options as $key => $label)
    @if($multiple)
      <option value="{{ $key }}" @selected(in_array((string) $key, array_map('strval', $selectedValues ?? []), true))>{{ $label }}</option>
    @else
      <option value="{{ $key }}" @selected((string) $selectedValues === (string) $key)>{{ $label }}</option>
    @endif
  @endforeach
</select>
