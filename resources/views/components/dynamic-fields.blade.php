@props([
  'fields' => [],
  'values' => [],
  'columns' => 1,
])

@php
  $columns = (int) $columns;
  $gridClass = match ($columns) {
    3 => 'grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3',
    2 => 'grid grid-cols-1 gap-5 md:grid-cols-2',
    default => 'grid grid-cols-1 gap-5',
  };
@endphp

<div class="{{ $gridClass }}">
  @foreach($fields as $field)
    @php
      $name = $field['name'] ?? null;
      $currentValue = $name ? ($values[$name] ?? null) : null;
    @endphp

    <x-dynamic-field :field="$field" :value="$currentValue" />
  @endforeach
</div>
