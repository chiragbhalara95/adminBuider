@props([
  'name' => null,
  'id' => null,
  'label' => null,
  'checked' => false,
])

<label class="inline-flex items-center gap-2 text-sm text-gray-700">
  <input
    type="checkbox"
    name="{{ $name }}"
    id="{{ $id ?? $name }}"
    value="1"
    @checked(old($name, $checked))
    {{ $attributes->merge(['class' => 'h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500']) }}
  />
  <span>{{ $label ?? $slot }}</span>
</label>
