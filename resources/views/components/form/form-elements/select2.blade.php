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
  $baseName = $name ? preg_replace('/\[\]$/', '', $name) : $name;
  $selectedValues = old($baseName, $selected);
  if ($multiple && !is_array($selectedValues)) {
    $selectedValues = $selectedValues !== null && $selectedValues !== '' ? [$selectedValues] : [];
  }

  $fieldName = $multiple && $baseName && !str_ends_with($baseName, '[]') ? $baseName.'[]' : $baseName;
@endphp

<select
  name="{{ $fieldName }}"
  id="{{ $id ?? $baseName }}"
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

@once
  @push('head')
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"
    />
  @endpush
  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
      (function () {
        function initSelect2Like(selectEl) {
          if (!selectEl || selectEl.dataset.choicesInitialized === 'true') return;
          if (typeof Choices === 'undefined') return;

          const isMultiple = selectEl.multiple;
          const placeholder = selectEl.dataset.placeholder || 'Select option';
          const allowClear = selectEl.dataset.allowClear === 'true';

          new Choices(selectEl, {
            allowHTML: false,
            searchEnabled: true,
            shouldSort: false,
            removeItemButton: isMultiple || allowClear,
            placeholder: true,
            placeholderValue: placeholder,
            searchPlaceholderValue: 'Search...',
            itemSelectText: '',
          });

          selectEl.dataset.choicesInitialized = 'true';
        }

        function initAllSelect2Like() {
          document.querySelectorAll('select[data-select2="true"]').forEach(initSelect2Like);
        }

        document.addEventListener('DOMContentLoaded', initAllSelect2Like);
        document.addEventListener('livewire:navigated', initAllSelect2Like);
        document.addEventListener('htmx:afterSwap', initAllSelect2Like);
      })();
    </script>
  @endpush
@endonce
