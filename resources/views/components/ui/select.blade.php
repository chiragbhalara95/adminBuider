@props([
  'name' => null,
  'id' => null,
  'options' => [],
  'selected' => null,
  'placeholder' => 'Select option',
])

<select
  name="{{ $name }}"
  id="{{ $id ?? $name }}"
  {{ $attributes->merge(['class' => 'h-11 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 pr-10 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-500']) }}
>
  <option value="">{{ $placeholder }}</option>
  @foreach($options as $key => $label)
    <option value="{{ $key }}" @selected((string) old($name, $selected) === (string) $key)>
      {{ $label }}
    </option>
  @endforeach
</select>
