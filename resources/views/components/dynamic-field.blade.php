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
  $multiple = (bool) ($field['multiple'] ?? false);
  $accept = $field['accept'] ?? null;
  $prepend = $field['prepend'] ?? null;
  $append = $field['append'] ?? null;
  $startName = $field['start_name'] ?? 'start_date';
  $endName = $field['end_name'] ?? 'end_date';
  $startValue = $field['start_value'] ?? null;
  $endValue = $field['end_value'] ?? null;
  $minHeight = $field['min_height'] ?? '160px';

  $attrs = new \Illuminate\View\ComponentAttributeBag($field['attributes'] ?? []);
  $fieldAttrs = $attrs->class([$fieldClass]);
@endphp

@if($name || $type === 'daterange')
  <div class="{{ $wrapperClass }}">
    @if(!in_array($type, ['checkbox', 'switch', 'dropzone'], true))
      <x-ui.label :for="$id" :required="$required">{{ $label }}</x-ui.label>
    @endif

    @switch($type)
      @case('input')
        <x-form.form-elements.input
          :name="$name"
          :id="$id"
          :value="$value ?? ($field['value'] ?? null)"
          placeholder="{{ $placeholder }}"
          {{ $fieldAttrs }}
        />
        @break

      @case('input-group')
        <x-form.form-elements.input-group
          :name="$name"
          :id="$id"
          :value="$value ?? ($field['value'] ?? null)"
          :type="$field['input_type'] ?? 'text'"
          :prepend="$prepend"
          :append="$append"
          placeholder="{{ $placeholder }}"
          {{ $fieldAttrs }}
        />
        @break

      @case('radio')
        <div class="flex flex-wrap gap-4">
          @foreach($options as $optionKey => $optionLabel)
            <x-form.form-elements.radio
              :name="$name"
              :id="$id.'_'.preg_replace('/[^A-Za-z0-9\-_]/', '_', (string) $optionKey)"
              :value="$optionKey"
              :label="$optionLabel"
              :checked="(string) ($value ?? ($field['value'] ?? '')) === (string) $optionKey"
              {{ $fieldAttrs }}
            />
          @endforeach
        </div>
        @break

      @case('select')
        <x-form.form-elements.select
          :name="$name"
          :id="$id"
          :options="$options"
          :selected="$value ?? ($field['value'] ?? null)"
          :placeholder="$placeholder ?: 'Select option'"
          {{ $fieldAttrs }}
        />
        @break

      @case('select2')
        <x-form.form-elements.select2
          :name="$name"
          :id="$id"
          :options="$options"
          :selected="$value ?? ($field['value'] ?? null)"
          :placeholder="$placeholder ?: 'Select option'"
          :multiple="$multiple"
          {{ $fieldAttrs }}
        />
        @break

      @case('multi-select')
      @case('muti-select')
        <x-form.form-elements.multi-select
          :name="$name"
          :id="$id"
          :options="$options"
          :selected="$value ?? ($field['value'] ?? [])"
          {{ $fieldAttrs }}
        />
        @break

      @case('textarea')
        <x-form.form-elements.textarea
          :name="$name"
          :id="$id"
          :rows="$rows"
          :value="$value ?? ($field['value'] ?? null)"
          placeholder="{{ $placeholder }}"
          {{ $fieldAttrs }}
        />
        @break

      @case('editor')
        <x-form.form-elements.editor
          :name="$name"
          :id="$id"
          :value="$value ?? ($field['value'] ?? null)"
          :min-height="$minHeight"
          {{ $fieldAttrs }}
        />
        @break

      @case('file')
        <x-form.form-elements.file
          :name="$name"
          :id="$id"
          :accept="$accept"
          {{ $fieldAttrs }}
        />
        @break

      @case('dropzone')
        <x-form.form-elements.dropzone
          :name="$name"
          :id="$id"
          :accept="$accept"
          :multiple="$multiple"
          :label="$label"
          {{ $fieldAttrs }}
        />
        @break

      @case('date')
        <x-form.form-elements.date
          :name="$name"
          :id="$id"
          :value="$value ?? ($field['value'] ?? null)"
          {{ $fieldAttrs }}
        />
        @break

      @case('daterange')
        @php
          $rangeValue = is_array($value) ? $value : [];
        @endphp
        <x-form.form-elements.daterange
          :start-name="$startName"
          :end-name="$endName"
          :start-id="$field['start_id'] ?? $startName"
          :end-id="$field['end_id'] ?? $endName"
          :start-value="$rangeValue[$startName] ?? $startValue"
          :end-value="$rangeValue[$endName] ?? $endValue"
          {{ $fieldAttrs }}
        />
        @break

      @case('url')
        <x-form.form-elements.url
          :name="$name"
          :id="$id"
          :value="$value ?? ($field['value'] ?? null)"
          :placeholder="$placeholder ?: 'https://example.com'"
          {{ $fieldAttrs }}
        />
        @break

      @case('timepicker')
        <x-form.form-elements.timepicker
          :name="$name"
          :id="$id"
          :value="$value ?? ($field['value'] ?? null)"
          {{ $fieldAttrs }}
        />
        @break

      @case('checkbox')
        <x-form.form-elements.checkbox
          :name="$name"
          :id="$id"
          :label="$label"
          :checked="$value ?? $checked"
          {{ $fieldAttrs }}
        />
        @break

      @case('switch')
        <x-form.form-elements.switch
          :name="$name"
          :id="$id"
          :label="$label"
          :checked="$value ?? $checked"
          {{ $fieldAttrs }}
        />
        @break

      @default
        <x-form.form-elements.input
          :type="$type"
          :name="$name"
          :id="$id"
          :value="$value ?? ($field['value'] ?? null)"
          placeholder="{{ $placeholder }}"
          {{ $fieldAttrs }}
        />
    @endswitch
  </div>
@endif
