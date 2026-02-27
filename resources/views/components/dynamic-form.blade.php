@props([
  'action' => '',
  'method' => 'POST',
  'fields' => [],
  'values' => [],
  'columns' => 1,
  'id' => null,
  'class' => '',
  'enctype' => null,
  'showSubmit' => true,
  'submitLabel' => 'Submit',
  'submitClass' => '',
  'novalidate' => false,
])

@php
  $httpMethod = strtoupper((string) $method);
  $formMethod = in_array($httpMethod, ['GET', 'POST'], true) ? $httpMethod : 'POST';

  $hasFileInput = false;
  foreach ($fields as $f) {
    if (in_array($f['type'] ?? null, ['file', 'dropzone'], true)) {
      $hasFileInput = true;
      break;
    }
  }

  $resolvedEnctype = $enctype ?? ($hasFileInput ? 'multipart/form-data' : null);
@endphp

<form
  action="{{ $action }}"
  method="{{ strtolower($formMethod) }}"
  @if($id) id="{{ $id }}" @endif
  @if($resolvedEnctype) enctype="{{ $resolvedEnctype }}" @endif
  @if($novalidate) novalidate @endif
  {{ $attributes->class(['space-y-5', $class]) }}
>
  @if($formMethod !== 'GET')
    @csrf
  @endif

  @if(!in_array($httpMethod, ['GET', 'POST'], true))
    @method($httpMethod)
  @endif

  <x-dynamic-fields :fields="$fields" :values="$values" :columns="$columns" />

  {{ $slot }}

  @if($showSubmit)
    <div class="flex items-center justify-end">
      <x-ui.button type="submit" class="{{ $submitClass }}">{{ $submitLabel }}</x-ui.button>
    </div>
  @endif
</form>

@once
  @push('scripts')
    <script>
      (function () {
        function normalizeExt(ext) {
          return String(ext || '').trim().replace(/^\./, '').toLowerCase();
        }

        function parseExtList(raw) {
          return String(raw || '')
            .split(',')
            .map(normalizeExt)
            .filter(Boolean);
        }

        function validateFileInput(input) {
          if (!(input instanceof HTMLInputElement) || input.type !== 'file') return;

          const maxSizeKb = Number(input.dataset.maxSizeKb || 0);
          const allowedExt = parseExtList(input.dataset.extensions);
          const files = Array.from(input.files || []);

          input.setCustomValidity('');

          if (maxSizeKb > 0) {
            const tooLarge = files.find((file) => file.size > (maxSizeKb * 1024));
            if (tooLarge) {
              input.setCustomValidity(`File too large. Max allowed size is ${maxSizeKb} KB.`);
              return;
            }
          }

          if (allowedExt.length > 0) {
            const invalid = files.find((file) => {
              const ext = normalizeExt((file.name.split('.').pop() || ''));
              return !allowedExt.includes(ext);
            });

            if (invalid) {
              input.setCustomValidity(`Invalid file type. Allowed: ${allowedExt.join(', ')}.`);
            }
          }
        }

        document.addEventListener('change', function (event) {
          const target = event.target;
          if (target instanceof HTMLInputElement && target.type === 'file') {
            validateFileInput(target);
            target.reportValidity();
          }
        });

        document.addEventListener('submit', function (event) {
          const form = event.target;
          if (!(form instanceof HTMLFormElement)) return;

          // Ensure required multi-select/select2 fields are validated reliably.
          form.querySelectorAll('select[data-select2=\"true\"], select[multiple][required]').forEach((selectEl) => {
            const isSelect2Required = selectEl.dataset.select2 === 'true' && selectEl.dataset.required === 'true';
            const isNativeRequired = selectEl.required;
            if (!isSelect2Required && !isNativeRequired) {
              selectEl.setCustomValidity('');
              return;
            }

            const hasValue = Array.from(selectEl.selectedOptions || []).some((opt) => String(opt.value || '').trim() !== '');
            if (!hasValue) {
              selectEl.setCustomValidity('Please select at least one option.');
            } else {
              selectEl.setCustomValidity('');
            }
          });

          // Re-check file inputs in case user submits directly without change event.
          form.querySelectorAll('input[type=\"file\"]').forEach(validateFileInput);

          if (!form.checkValidity()) {
            event.preventDefault();
            form.reportValidity();
          }
        }, true);
      })();
    </script>
  @endpush
@endonce
