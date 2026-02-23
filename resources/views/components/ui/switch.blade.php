@props([
  'name' => null,
  'id' => null,
  'label' => null,
  'checked' => false,
])

<label class="inline-flex items-center gap-3">
  <span class="text-sm text-gray-700">{{ $label ?? $slot }}</span>
  <input
    type="checkbox"
    name="{{ $name }}"
    id="{{ $id ?? $name }}"
    value="1"
    class="peer sr-only"
    @checked(old($name, $checked))
    {{ $attributes->except('class') }}
  />
  <span class="relative h-6 w-11 rounded-full bg-gray-300 transition peer-checked:bg-indigo-600 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all peer-checked:after:translate-x-5"></span>
</label>
