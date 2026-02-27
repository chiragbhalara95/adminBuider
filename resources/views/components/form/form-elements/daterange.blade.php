@props([
  'startName' => 'start_date',
  'endName' => 'end_date',
  'startId' => null,
  'endId' => null,
  'startValue' => null,
  'endValue' => null,
])

<div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
  <input
    type="date"
    name="{{ $startName }}"
    id="{{ $startId ?? $startName }}"
    value="{{ old($startName, $startValue) }}"
    class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-500"
  />

  <input
    type="date"
    name="{{ $endName }}"
    id="{{ $endId ?? $endName }}"
    value="{{ old($endName, $endValue) }}"
    class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-500"
  />
</div>
