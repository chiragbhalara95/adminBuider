@props([
  'for' => null,
  'required' => false,
])

<label {{ $attributes->merge(['for' => $for, 'class' => 'mb-1.5 block text-sm font-medium text-gray-700']) }}>
  {{ $slot }}
  @if($required)
    <span class="text-red-500">*</span>
  @endif
</label>
