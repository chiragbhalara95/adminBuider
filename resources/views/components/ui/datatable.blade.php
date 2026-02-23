@props([
  'id' => 'datatable',
  'columns' => [],
  'rows' => [],
  'filters' => [],
  'emptyText' => 'No records found.',
  'striped' => true,
  'hoverable' => true,
  'showIndex' => false,
  'searchable' => true,
  'searchPlaceholder' => 'Search...',
  'pagination' => true,
  'perPage' => 10,
  'perPageOptions' => [5, 10, 25, 50],
  'defaultSort' => null,
  'defaultDirection' => 'asc',
  'queryPrefix' => null,
])

@php
  use Illuminate\Support\Arr;
  use Illuminate\Support\Str;
  use Illuminate\Pagination\LengthAwarePaginator;

  $request = request();
  $rowsCollection = collect($rows);
  $normalizedColumns = collect($columns)->map(function ($column) {
    if (!is_array($column)) {
      return [
        'key' => $column,
        'label' => Str::headline((string) $column),
      ];
    }
    return $column;
  })->values();

  $prefix = $queryPrefix ?: Str::snake((string) $id);
  $searchKey = "{$prefix}_search";
  $sortKeyParam = "{$prefix}_sort";
  $dirKeyParam = "{$prefix}_dir";
  $pageKeyParam = "{$prefix}_page";
  $perPageKeyParam = "{$prefix}_per_page";

  $filterDefs = collect($filters)->map(function ($filter) use ($rowsCollection, $prefix) {
    $key = $filter['key'] ?? null;
    if (!$key) {
      return null;
    }

    $options = $filter['options'] ?? $rowsCollection->pluck($key)->filter(fn ($v) => $v !== null && $v !== '')->unique()->sort()->values()->all();
    $normalizedOptions = [];
    foreach ((array) $options as $optionKey => $optionLabel) {
      if (is_int($optionKey)) {
        $normalizedOptions[(string) $optionLabel] = (string) $optionLabel;
      } else {
        $normalizedOptions[(string) $optionKey] = (string) $optionLabel;
      }
    }

    return [
      'key' => $key,
      'label' => $filter['label'] ?? Str::headline((string) $key),
      'query_key' => $filter['query_key'] ?? ($prefix . '_filter_' . $key),
      'options' => $normalizedOptions,
    ];
  })->filter()->values();

  $ownedKeys = collect([$searchKey, $sortKeyParam, $dirKeyParam, $pageKeyParam, $perPageKeyParam])
    ->merge($filterDefs->pluck('query_key'))
    ->values()
    ->all();

  $currentSearch = trim((string) $request->query($searchKey, ''));
  $currentSort = (string) $request->query($sortKeyParam, $defaultSort ?? '');
  $currentDir = strtolower((string) $request->query($dirKeyParam, $defaultDirection));
  $currentDir = $currentDir === 'desc' ? 'desc' : 'asc';
  $perPageOptions = collect($perPageOptions)->map(fn ($n) => (int) $n)->filter(fn ($n) => $n > 0)->unique()->sort()->values()->all();
  if (empty($perPageOptions)) {
    $perPageOptions = [10, 25, 50];
  }
  $currentPerPage = (int) $request->query($perPageKeyParam, $perPage);
  if (!in_array($currentPerPage, $perPageOptions, true)) {
    $currentPerPage = (int) $perPageOptions[0];
  }

  $searchableKeys = $normalizedColumns
    ->filter(fn ($c) => ($c['searchable'] ?? true) !== false && !empty($c['key']))
    ->pluck('key')
    ->values()
    ->all();

  if ($searchable && $currentSearch !== '' && !empty($searchableKeys)) {
    $needle = Str::lower($currentSearch);
    $rowsCollection = $rowsCollection->filter(function ($row) use ($searchableKeys, $needle) {
      foreach ($searchableKeys as $key) {
        $value = Arr::get($row, $key, '');
        if (Str::contains(Str::lower((string) $value), $needle)) {
          return true;
        }
      }
      return false;
    })->values();
  }

  foreach ($filterDefs as $filterDef) {
    $selectedFilterValue = (string) $request->query($filterDef['query_key'], '');
    if ($selectedFilterValue !== '') {
      $rowsCollection = $rowsCollection->filter(function ($row) use ($filterDef, $selectedFilterValue) {
        return (string) Arr::get($row, $filterDef['key']) === $selectedFilterValue;
      })->values();
    }
  }

  $sortableKeys = $normalizedColumns
    ->filter(fn ($c) => ($c['sortable'] ?? true) !== false && !empty($c['key']))
    ->pluck('key')
    ->values()
    ->all();

  if ($currentSort && in_array($currentSort, $sortableKeys, true)) {
    if ($currentDir === 'desc') {
      $rowsCollection = $rowsCollection->sortByDesc(fn ($row) => Arr::get($row, $currentSort))->values();
    } else {
      $rowsCollection = $rowsCollection->sortBy(fn ($row) => Arr::get($row, $currentSort))->values();
    }
  }

  $totalRows = $rowsCollection->count();
  $currentPage = max(1, (int) $request->query($pageKeyParam, 1));

  if ($pagination) {
    $pageRows = $rowsCollection->forPage($currentPage, $currentPerPage)->values();
    $paginator = new LengthAwarePaginator(
      $pageRows,
      $totalRows,
      $currentPerPage,
      $currentPage,
      [
        'path' => url()->current(),
        'pageName' => $pageKeyParam,
        'query' => $request->query(),
      ]
    );
  } else {
    $pageRows = $rowsCollection->values();
    $paginator = null;
  }
@endphp

<div class="space-y-4">
  <form method="GET" action="{{ url()->current() }}" class="grid grid-cols-1 gap-3 md:grid-cols-4">
    @foreach($request->query() as $queryKey => $queryValue)
      @if(!in_array($queryKey, $ownedKeys, true))
        @if(is_array($queryValue))
          @foreach($queryValue as $v)
            <input type="hidden" name="{{ $queryKey }}[]" value="{{ $v }}">
          @endforeach
        @else
          <input type="hidden" name="{{ $queryKey }}" value="{{ $queryValue }}">
        @endif
      @endif
    @endforeach

    @if($searchable)
      <div class="md:col-span-2">
        <input
          type="text"
          name="{{ $searchKey }}"
          value="{{ $currentSearch }}"
          placeholder="{{ $searchPlaceholder }}"
          class="h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
        />
      </div>
    @endif

    @if($pagination)
      <div>
        <select
          name="{{ $perPageKeyParam }}"
          class="h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
        >
          @foreach($perPageOptions as $option)
            <option value="{{ $option }}" @selected($currentPerPage === (int) $option)>{{ $option }} / page</option>
          @endforeach
        </select>
      </div>
    @endif

    <div class="flex gap-2">
      <button type="submit" class="inline-flex h-10 items-center justify-center rounded-lg bg-indigo-600 px-4 text-sm font-medium text-white hover:bg-indigo-700">Apply</button>
      <a
        href="{{ url()->current().(count(array_diff_key($request->query(), array_flip($ownedKeys))) ? ('?'.http_build_query(array_diff_key($request->query(), array_flip($ownedKeys)))) : '') }}"
        class="inline-flex h-10 items-center justify-center rounded-lg border border-gray-300 px-4 text-sm font-medium text-gray-700 hover:bg-gray-50"
      >
        Reset
      </a>
    </div>

    @foreach($filterDefs as $filterDef)
      <div>
        <label class="mb-1 block text-xs font-medium text-gray-500">{{ $filterDef['label'] }}</label>
        <select
          name="{{ $filterDef['query_key'] }}"
          class="h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
        >
          <option value="">All</option>
          @foreach($filterDef['options'] as $optKey => $optLabel)
            <option value="{{ $optKey }}" @selected((string) $request->query($filterDef['query_key'], '') === (string) $optKey)>
              {{ $optLabel }}
            </option>
          @endforeach
        </select>
      </div>
    @endforeach
  </form>

  <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
          <tr>
            @if($showIndex)
              <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">#</th>
            @endif

            @foreach($normalizedColumns as $column)
              @php
                $key = $column['key'] ?? null;
                $sortable = ($column['sortable'] ?? true) !== false && $key;
                $isActiveSort = $sortable && $currentSort === $key;
                $nextDir = $isActiveSort && $currentDir === 'asc' ? 'desc' : 'asc';
                $sortUrl = $sortable
                  ? request()->fullUrlWithQuery([
                    $sortKeyParam => $key,
                    $dirKeyParam => $nextDir,
                    $pageKeyParam => 1,
                  ])
                  : null;
                $headerClass = $column['header_class'] ?? 'px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500';
                $label = $column['label'] ?? Str::headline((string) $key);
              @endphp

              <th class="{{ $headerClass }}">
                @if($sortable)
                  <a href="{{ $sortUrl }}" class="inline-flex items-center gap-1 hover:text-gray-900">
                    <span>{{ $label }}</span>
                    <span class="text-[10px]">
                      @if($isActiveSort)
                        {{ $currentDir === 'asc' ? '^' : 'v' }}
                      @else
                        {{ '<->' }}
                      @endif
                    </span>
                  </a>
                @else
                  {{ $label }}
                @endif
              </th>
            @endforeach
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">
          @forelse($pageRows as $index => $row)
            <tr class="{{ $striped && ($index % 2 === 1) ? 'bg-gray-50/60' : 'bg-white' }} {{ $hoverable ? 'hover:bg-indigo-50/40' : '' }}">
              @if($showIndex)
                <td class="px-4 py-3 text-gray-500">
                  {{ $pagination ? (($currentPage - 1) * $currentPerPage + $index + 1) : ($index + 1) }}
                </td>
              @endif

              @foreach($normalizedColumns as $column)
                @php
                  $key = $column['key'] ?? null;
                  $value = $key ? Arr::get($row, $key, '-') : '-';
                  $cellClass = $column['cell_class'] ?? 'px-4 py-3 text-gray-700';
                @endphp

                <td class="{{ $cellClass }}">
                  @if(($column['type'] ?? null) === 'badge')
                    @php
                      $badgeMap = $column['badge_map'] ?? [];
                      $badgeClass = $badgeMap[$value] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $badgeClass }}">{{ $value }}</span>
                  @else
                    {{ $value }}
                  @endif
                </td>
              @endforeach
            </tr>
          @empty
            <tr>
              <td colspan="{{ count($normalizedColumns) + ($showIndex ? 1 : 0) }}" class="px-4 py-8 text-center text-sm text-gray-500">
                {{ $emptyText }}
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  @if($pagination && $paginator && $paginator->lastPage() > 1)
    <div class="flex flex-col items-start justify-between gap-3 text-sm text-gray-600 md:flex-row md:items-center">
      <p>
        Showing
        <span class="font-medium">{{ ($currentPage - 1) * $currentPerPage + 1 }}</span>
        to
        <span class="font-medium">{{ min($currentPage * $currentPerPage, $totalRows) }}</span>
        of
        <span class="font-medium">{{ $totalRows }}</span>
        results
      </p>

      <div class="flex items-center gap-1">
        @if($paginator->onFirstPage())
          <span class="rounded border border-gray-200 px-3 py-1.5 text-gray-400">Prev</span>
        @else
          <a href="{{ $paginator->previousPageUrl() }}" class="rounded border border-gray-300 px-3 py-1.5 hover:bg-gray-50">Prev</a>
        @endif

        @for($p = 1; $p <= $paginator->lastPage(); $p++)
          <a
            href="{{ $paginator->url($p) }}"
            class="rounded px-3 py-1.5 {{ $p === $currentPage ? 'bg-indigo-600 text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50' }}"
          >
            {{ $p }}
          </a>
        @endfor

        @if($paginator->hasMorePages())
          <a href="{{ $paginator->nextPageUrl() }}" class="rounded border border-gray-300 px-3 py-1.5 hover:bg-gray-50">Next</a>
        @else
          <span class="rounded border border-gray-200 px-3 py-1.5 text-gray-400">Next</span>
        @endif
      </div>
    </div>
  @endif
</div>
