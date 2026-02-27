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
      })();
    </script>
  @endpush
@endonce
