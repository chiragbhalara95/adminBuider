@props([
  'field' => [],
  'value' => null,
])

@php
  $type = $field['type'] ?? 'text';
  $name = $field['name'] ?? null;
  $id = $field['id'] ?? $name;

  $label = $field['label'] ?? ($name ? \Illuminate\Support\Str::headline(str_replace('_', ' ', $name)) : 'Field');
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
  $rules = $field['rules'] ?? null;
  $errorKey = $field['error_key'] ?? $name;
  $startErrorKey = $field['start_error_key'] ?? $startName;
  $endErrorKey = $field['end_error_key'] ?? $endName;
  $baseErrorKey = $errorKey ? preg_replace('/\[\]$/', '', $errorKey) : null;

  $validation = is_array($field['validation'] ?? null) ? $field['validation'] : [];

  foreach (['required', 'min', 'max', 'minlength', 'maxlength', 'pattern', 'step', 'accept', 'extensions', 'max_size_kb', 'max_size_mb', 'title'] as $ruleKey) {
    if (array_key_exists($ruleKey, $field) && !array_key_exists($ruleKey, $validation)) {
      $validation[$ruleKey] = $field[$ruleKey];
    }
  }

  if (is_string($rules) && trim($rules) !== '') {
    foreach (explode('|', $rules) as $ruleChunk) {
      $ruleChunk = trim($ruleChunk);
      if ($ruleChunk === '') {
        continue;
      }

      [$ruleName, $ruleValue] = array_pad(explode(':', $ruleChunk, 2), 2, null);
      $ruleName = strtolower(trim($ruleName));
      $ruleValue = $ruleValue !== null ? trim($ruleValue) : null;

      switch ($ruleName) {
        case 'required':
          $validation['required'] = true;
          break;
        case 'min':
          if (in_array($type, ['number', 'range', 'date', 'datetime-local', 'time'], true)) {
            $validation['min'] = $ruleValue;
          } else {
            $validation['minlength'] = $ruleValue;
          }
          break;
        case 'max':
          if (in_array($type, ['file', 'dropzone'], true)) {
            $validation['max_size_kb'] = $ruleValue;
          } elseif (in_array($type, ['number', 'range', 'date', 'datetime-local', 'time'], true)) {
            $validation['max'] = $ruleValue;
          } else {
            $validation['maxlength'] = $ruleValue;
          }
          break;
        case 'size':
          if (in_array($type, ['file', 'dropzone'], true)) {
            $validation['max_size_kb'] = $ruleValue;
          } else {
            $validation['maxlength'] = $ruleValue;
          }
          break;
        case 'mimes':
        case 'extensions':
          $validation['extensions'] = array_filter(array_map('trim', explode(',', (string) $ruleValue)));
          break;
        case 'regex':
          if ($ruleValue !== null && str_starts_with($ruleValue, '/') && str_ends_with($ruleValue, '/')) {
            $ruleValue = trim($ruleValue, '/');
          }
          $validation['pattern'] = $ruleValue;
          break;
      }
    }
  }

  $required = (bool) ($validation['required'] ?? ($field['required'] ?? false));
  $validationAttrs = [];

  if ($required) {
    $validationAttrs['required'] = true;
  }
  if (isset($validation['min'])) {
    $validationAttrs['min'] = $validation['min'];
  }
  if (isset($validation['max'])) {
    $validationAttrs['max'] = $validation['max'];
  }
  if (isset($validation['minlength'])) {
    $validationAttrs['minlength'] = $validation['minlength'];
  }
  if (isset($validation['maxlength'])) {
    $validationAttrs['maxlength'] = $validation['maxlength'];
  }
  if (isset($validation['pattern'])) {
    $validationAttrs['pattern'] = $validation['pattern'];
  }
  if (isset($validation['step'])) {
    $validationAttrs['step'] = $validation['step'];
  }
  if (isset($validation['title'])) {
    $validationAttrs['title'] = $validation['title'];
  }

  $extensions = $validation['extensions'] ?? [];
  if (is_string($extensions)) {
    $extensions = array_filter(array_map('trim', explode(',', $extensions)));
  }

  if (in_array($type, ['file', 'dropzone'], true)) {
    if (isset($validation['max_size_mb']) && !isset($validation['max_size_kb'])) {
      $validation['max_size_kb'] = (int) round(((float) $validation['max_size_mb']) * 1024);
    }
    if (isset($validation['max_size_kb'])) {
      $validationAttrs['data-max-size-kb'] = (int) $validation['max_size_kb'];
    }
    if (!empty($extensions)) {
      $validationAttrs['data-extensions'] = implode(',', $extensions);
    }
    if (!$accept && !empty($extensions)) {
      $accept = implode(',', array_map(fn ($ext) => '.'.ltrim((string) $ext, '.'), $extensions));
    }
  }

  $attrs = new \Illuminate\View\ComponentAttributeBag(array_merge($field['attributes'] ?? [], $validationAttrs));
  $fieldAttrs = $attrs->class([$fieldClass]);
@endphp

@if($name || $type === 'daterange')
  <div class="{{ $wrapperClass }}">
    @if(!in_array($type, ['checkbox', 'switch', 'dropzone'], true))
      <x-ui.label :for="$id" :required="$required">{{ $label }}</x-ui.label>
    @endif

    @if($type === 'input')
      <x-ui.input
        :name="$name"
        :id="$id"
        :value="$value ?? ($field['value'] ?? null)"
        placeholder="{{ $placeholder }}"
        :attributes="$fieldAttrs"
      />
    @elseif($type === 'input-group')
      <x-ui.input-group
        :name="$name"
        :id="$id"
        :value="$value ?? ($field['value'] ?? null)"
        :type="$field['input_type'] ?? 'text'"
        :prepend="$prepend"
        :append="$append"
        placeholder="{{ $placeholder }}"
        :attributes="$fieldAttrs"
      />
    @elseif($type === 'radio')
      <div class="flex flex-wrap gap-4">
        @foreach($options as $optionKey => $optionLabel)
          <x-ui.radio
            :name="$name"
            :id="$id.'_'.preg_replace('/[^A-Za-z0-9\-_]/', '_', (string) $optionKey)"
            :value="$optionKey"
            :label="$optionLabel"
            :checked="(string) ($value ?? ($field['value'] ?? '')) === (string) $optionKey"
            :attributes="$fieldAttrs"
          />
        @endforeach
      </div>
    @elseif($type === 'select')
      <x-ui.select
        :name="$name"
        :id="$id"
        :options="$options"
        :selected="$value ?? ($field['value'] ?? null)"
        :placeholder="$placeholder ?: 'Select option'"
        :attributes="$fieldAttrs"
      />
    @elseif($type === 'select2')
      <x-ui.select2
        :name="$name"
        :id="$id"
        :options="$options"
        :selected="$value ?? ($field['value'] ?? null)"
        :placeholder="$placeholder ?: 'Select option'"
        :multiple="$multiple"
        :attributes="$fieldAttrs"
      />
    @elseif(in_array($type, ['multi-select', 'muti-select'], true))
      <x-ui.multi-select
        :name="$name"
        :id="$id"
        :options="$options"
        :selected="$value ?? ($field['value'] ?? [])"
        :attributes="$fieldAttrs"
      />
    @elseif($type === 'textarea')
      <x-ui.textarea
        :name="$name"
        :id="$id"
        :rows="$rows"
        :value="$value ?? ($field['value'] ?? null)"
        placeholder="{{ $placeholder }}"
        :attributes="$fieldAttrs"
      />
    @elseif($type === 'editor')
      <x-ui.editor
        :name="$name"
        :id="$id"
        :value="$value ?? ($field['value'] ?? null)"
        :min-height="$minHeight"
        :attributes="$fieldAttrs"
      />
    @elseif($type === 'file')
      <x-ui.file
        :name="$name"
        :id="$id"
        :accept="$accept"
        :attributes="$fieldAttrs"
      />
    @elseif($type === 'dropzone')
      <x-ui.dropzone
        :name="$name"
        :id="$id"
        :accept="$accept"
        :multiple="$multiple"
        :label="$label"
        :attributes="$fieldAttrs"
      />
    @elseif($type === 'date')
      <x-ui.date
        :name="$name"
        :id="$id"
        :value="$value ?? ($field['value'] ?? null)"
        :attributes="$fieldAttrs"
      />
    @elseif($type === 'daterange')
      @php
        $rangeValue = is_array($value) ? $value : [];
      @endphp
      <x-ui.daterange
        :start-name="$startName"
        :end-name="$endName"
        :start-id="$field['start_id'] ?? $startName"
        :end-id="$field['end_id'] ?? $endName"
        :start-value="$rangeValue[$startName] ?? $startValue"
        :end-value="$rangeValue[$endName] ?? $endValue"
        :attributes="$fieldAttrs"
      />
    @elseif($type === 'url')
      <x-ui.url
        :name="$name"
        :id="$id"
        :value="$value ?? ($field['value'] ?? null)"
        :placeholder="$placeholder ?: 'https://example.com'"
        :attributes="$fieldAttrs"
      />
    @elseif($type === 'timepicker')
      <x-ui.timepicker
        :name="$name"
        :id="$id"
        :value="$value ?? ($field['value'] ?? null)"
        :attributes="$fieldAttrs"
      />
    @elseif($type === 'checkbox')
      <x-ui.checkbox
        :name="$name"
        :id="$id"
        :label="$label"
        :checked="$value ?? $checked"
        :attributes="$fieldAttrs"
      />
    @elseif($type === 'switch')
      <x-ui.switch
        :name="$name"
        :id="$id"
        :label="$label"
        :checked="$value ?? $checked"
        :attributes="$fieldAttrs"
      />
    @else
      <x-ui.input
        :type="$type"
        :name="$name"
        :id="$id"
        :value="$value ?? ($field['value'] ?? null)"
        placeholder="{{ $placeholder }}"
        :attributes="$fieldAttrs"
      />
    @endif

    @if($type === 'daterange')
      @error($startErrorKey)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
      @enderror
      @error($endErrorKey)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
      @enderror
    @elseif($baseErrorKey)
      @error($baseErrorKey)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
      @enderror
      @if($errors->has($baseErrorKey.'.*'))
        <p class="mt-1 text-xs text-red-600">{{ $errors->first($baseErrorKey.'.*') }}</p>
      @endif
    @endif
  </div>
@endif




