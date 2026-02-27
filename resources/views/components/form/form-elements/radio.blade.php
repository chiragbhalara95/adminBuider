@props([
  'name' => null,
  'id' => null,
  'value' => 1,
  'label' => null,
  'checked' => false,
])

<label class="inline-flex items-center gap-2 text-sm text-gray-700">
  <input
    type="radio"
    name="{{ $name }}"
    id="{{ $id ?? ($name ? $name.'_'.$value : null) }}"
    value="{{ $value }}"
    @checked((string) old($name, $checked ? $value : null) === (string) $value)
    {{ $attributes->merge(['class' => 'h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500']) }}
  />
  <span>{{ $label ?? $slot }}</span>
</label>
