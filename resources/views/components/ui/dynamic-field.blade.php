@props([
  'field' => [],
  'value' => null,
])

@php
  $type = $field['type'] ?? 'text';
  $name = $field['name'] ?? null;
  $id = $field['id'] ?? $name;

  $label = $field['label'] ?? ($name ? \Illuminate\Support\Str::headline(str_replace('_', ' ', $name)) : 'Field');
  $required = (bool) ($field['required'] ?? false);
  $placeholder = $field['placeholder'] ?? '';
  $options = $field['options'] ?? [];
  $rows = (int) ($field['rows'] ?? 4);
  $wrapperClass = $field['wrapper_class'] ?? '';
  $fieldClass = $field['class'] ?? '';
  $checked = $field['checked'] ?? false;

  $attrs = new \Illuminate\View\ComponentAttributeBag($field['attributes'] ?? []);
@endphp

@if($name)
  <div class="{{ $wrapperClass }}">
    @if(!in_array($type, ['checkbox', 'switch'], true))
      <x-ui.label :for="$id" :required="$required">{{ $label }}</x-ui.label>
    @endif

    @switch($type)
      @case('select')
        <x-ui.select
          :name="$name"
          :id="$id"
          :options="$options"
          :selected="$value ?? ($field['value'] ?? null)"
          :placeholder="$placeholder ?: 'Select option'"
          class="{{ $fieldClass }}"
          {{ $attrs }}
        />
        @break

      @case('textarea')
        <x-ui.textarea
          :name="$name"
          :id="$id"
          :rows="$rows"
          :value="$value ?? ($field['value'] ?? null)"
          placeholder="{{ $placeholder }}"
          class="{{ $fieldClass }}"
          {{ $attrs }}
        />
        @break

      @case('checkbox')
        <x-ui.checkbox
          :name="$name"
          :id="$id"
          :label="$label"
          :checked="$value ?? $checked"
          class="{{ $fieldClass }}"
          {{ $attrs }}
        />
        @break

      @case('switch')
        <x-ui.switch
          :name="$name"
          :id="$id"
          :label="$label"
          :checked="$value ?? $checked"
          {{ $attrs }}
        />
        @break

      @default
        <x-ui.input
          :type="$type"
          :name="$name"
          :id="$id"
          :value="$value ?? ($field['value'] ?? null)"
          placeholder="{{ $placeholder }}"
          class="{{ $fieldClass }}"
          {{ $attrs }}
        />
    @endswitch
  </div>
@endif
