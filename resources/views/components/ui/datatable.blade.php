@props([
  'id' => 'datatable-'.\Illuminate\Support\Str::lower(\Illuminate\Support\Str::random(8)),
  'columns' => [],
  'rows' => [],
  'url' => null,
  'method' => 'GET',
  'filters' => [],
  'showIndex' => false,
  'perPage' => 10,
  'perPageOptions' => [10, 25, 50],
  'searchPlaceholder' => 'Search...',
  'emptyText' => 'No records found.',
  'initialSortBy' => null,
  'initialSortDir' => 'asc',
  'queryParams' => [
    'search' => 'search',
    'sortBy' => 'sort_by',
    'sortDir' => 'sort_dir',
    'page' => 'page',
    'perPage' => 'per_page',
  ],
])

<div
  x-data="uiDatatable({
    columns: @js($columns),
    initialRows: @js($rows),
    url: @js($url),
    method: @js($method),
    filters: @js($filters),
    showIndex: @js($showIndex),
    perPage: @js((int) $perPage),
    perPageOptions: @js($perPageOptions),
    searchPlaceholder: @js($searchPlaceholder),
    emptyText: @js($emptyText),
    initialSortBy: @js($initialSortBy),
    initialSortDir: @js($initialSortDir),
    queryParams: @js($queryParams),
  })"
  x-init="init()"
  id="{{ $id }}"
  class="space-y-4 rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900"
>
  <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
    <div class="flex w-full flex-col gap-3 sm:flex-row sm:items-center">
      <input
        type="search"
        x-model="search"
        @input="onSearchInput"
        class="h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white/90 dark:placeholder:text-white/30"
        :placeholder="searchPlaceholder"
      />

      <template x-for="filter in filters" :key="filter.key">
        <select
          class="h-10 min-w-40 rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white/90"
          x-model="filterValues[filter.key]"
          @change="applyFilters"
        >
          <option value="" x-text="`All ${filter.label}`"></option>
          <template x-for="option in normalizedFilterOptions(filter)" :key="option.value">
            <option :value="option.value" x-text="option.label"></option>
          </template>
        </select>
      </template>
    </div>

    <div class="flex items-center gap-2 text-sm">
      <span class="text-gray-600 dark:text-gray-400">Show</span>
      <select
        x-model.number="perPage"
        @change="changePerPage"
        class="h-10 rounded-lg border border-gray-300 bg-white px-2 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white/90"
      >
        <template x-for="size in perPageOptions" :key="size">
          <option :value="size" x-text="size"></option>
        </template>
      </select>
    </div>
  </div>

  <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-800">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
      <thead class="bg-gray-50 dark:bg-gray-800/50">
        <tr>
          <th
            x-show="showIndex"
            class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"
          >#</th>
          <template x-for="col in columns" :key="col.key">
            <th
              class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"
              :class="isSortable(col) ? 'cursor-pointer select-none' : ''"
              @click="toggleSort(col)"
            >
              <div class="inline-flex items-center gap-1">
                <span x-text="col.label || col.key"></span>
                <span x-show="isSortable(col) && sortBy === col.key && sortDir === 'asc'">^</span>
                <span x-show="isSortable(col) && sortBy === col.key && sortDir === 'desc'">v</span>
              </div>
            </th>
          </template>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-800 dark:bg-gray-900">
        <template x-if="loading">
          <tr>
            <td
              class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400"
              :colspan="columns.length + (showIndex ? 1 : 0)"
            >Loading...</td>
          </tr>
        </template>

        <template x-if="!loading && error">
          <tr>
            <td
              class="px-4 py-8 text-center text-sm text-red-600 dark:text-red-400"
              :colspan="columns.length + (showIndex ? 1 : 0)"
              x-text="error"
            ></td>
          </tr>
        </template>

        <template x-if="!loading && !error && displayedRows.length === 0">
          <tr>
            <td
              class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400"
              :colspan="columns.length + (showIndex ? 1 : 0)"
              x-text="emptyText"
            ></td>
          </tr>
        </template>

        <template x-for="(row, rowIndex) in displayedRows" :key="row.id ?? rowIndex">
          <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
            <td x-show="showIndex" class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300" x-text="rowNumber(rowIndex)"></td>
            <template x-for="col in columns" :key="col.key">
              <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                <template x-if="col.type === 'badge'">
                  <span
                    class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium"
                    :class="badgeClass(col, cellValue(row, col))"
                    x-text="cellValue(row, col)"
                  ></span>
                </template>
                <template x-if="col.type !== 'badge'">
                  <span x-text="cellValue(row, col)"></span>
                </template>
              </td>
            </template>
          </tr>
        </template>
      </tbody>
    </table>
  </div>

  <div class="flex flex-col gap-3 text-sm text-gray-600 dark:text-gray-400 sm:flex-row sm:items-center sm:justify-between">
    <p x-text="paginationText()"></p>

    <div class="flex items-center gap-1">
      <button
        type="button"
        class="rounded-lg border border-gray-300 px-3 py-1.5 text-gray-700 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800"
        @click="prevPage"
        :disabled="currentPage <= 1 || loading"
      >Prev</button>

      <template x-for="page in pageButtons()" :key="page">
        <button
          type="button"
          class="rounded-lg border px-3 py-1.5"
          :class="page === currentPage ? 'border-indigo-600 bg-indigo-600 text-white' : 'border-gray-300 text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800'"
          @click="goToPage(page)"
          :disabled="loading"
          x-text="page"
        ></button>
      </template>

      <button
        type="button"
        class="rounded-lg border border-gray-300 px-3 py-1.5 text-gray-700 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800"
        @click="nextPage"
        :disabled="currentPage >= lastPage || loading"
      >Next</button>
    </div>
  </div>
</div>

@once
  @push('scripts')
    <script>
      function uiDatatable(config) {
        return {
          columns: config.columns || [],
          baseRows: config.initialRows || [],
          displayedRows: [],
          url: config.url || null,
          method: (config.method || 'GET').toUpperCase(),
          filters: config.filters || [],
          filterValues: {},
          showIndex: !!config.showIndex,
          search: '',
          searchPlaceholder: config.searchPlaceholder || 'Search...',
          emptyText: config.emptyText || 'No records found.',
          sortBy: config.initialSortBy || null,
          sortDir: config.initialSortDir === 'desc' ? 'desc' : 'asc',
          perPage: Number(config.perPage || 10),
          perPageOptions: config.perPageOptions || [10, 25, 50],
          currentPage: 1,
          lastPage: 1,
          total: 0,
          loading: false,
          error: '',
          searchTimer: null,
          queryParams: Object.assign({
            search: 'search',
            sortBy: 'sort_by',
            sortDir: 'sort_dir',
            page: 'page',
            perPage: 'per_page'
          }, config.queryParams || {}),

          init() {
            this.filters.forEach((f) => {
              this.filterValues[f.key] = '';
            });

            if (this.url) {
              this.fetchData();
            } else {
              this.refreshClientData();
            }
          },

          onSearchInput() {
            clearTimeout(this.searchTimer);
            this.searchTimer = setTimeout(() => {
              this.currentPage = 1;
              this.url ? this.fetchData() : this.refreshClientData();
            }, 300);
          },

          applyFilters() {
            this.currentPage = 1;
            this.url ? this.fetchData() : this.refreshClientData();
          },

          changePerPage() {
            this.currentPage = 1;
            this.url ? this.fetchData() : this.refreshClientData();
          },

          toggleSort(col) {
            if (!this.isSortable(col)) return;

            if (this.sortBy === col.key) {
              this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
            } else {
              this.sortBy = col.key;
              this.sortDir = 'asc';
            }

            this.currentPage = 1;
            this.url ? this.fetchData() : this.refreshClientData();
          },

          isSortable(col) {
            return col.sortable !== false;
          },

          goToPage(page) {
            if (page < 1 || page > this.lastPage || page === this.currentPage) return;
            this.currentPage = page;
            this.url ? this.fetchData() : this.refreshClientData();
          },

          prevPage() {
            this.goToPage(this.currentPage - 1);
          },

          nextPage() {
            this.goToPage(this.currentPage + 1);
          },

          rowNumber(rowIndex) {
            return (this.currentPage - 1) * this.perPage + rowIndex + 1;
          },

          pageButtons() {
            const maxButtons = 7;
            const pages = [];

            if (this.lastPage <= maxButtons) {
              for (let i = 1; i <= this.lastPage; i++) pages.push(i);
              return pages;
            }

            let start = Math.max(1, this.currentPage - 3);
            let end = Math.min(this.lastPage, start + maxButtons - 1);
            start = Math.max(1, end - maxButtons + 1);

            for (let i = start; i <= end; i++) pages.push(i);
            return pages;
          },

          paginationText() {
            if (this.total === 0) return 'Showing 0 results';
            const start = (this.currentPage - 1) * this.perPage + 1;
            const end = Math.min(this.currentPage * this.perPage, this.total);
            return `Showing ${start}-${end} of ${this.total} results`;
          },

          normalizedFilterOptions(filter) {
            if (Array.isArray(filter.options)) {
              return filter.options.map((opt) => typeof opt === 'object'
                ? { value: String(opt.value ?? ''), label: opt.label ?? opt.value ?? '' }
                : { value: String(opt), label: String(opt) });
            }

            if (filter.options && typeof filter.options === 'object') {
              return Object.keys(filter.options).map((k) => ({
                value: String(k),
                label: String(filter.options[k]),
              }));
            }

            return [];
          },

          cellValue(row, col) {
            const key = col.key || '';
            if (!key) return '';

            if (!key.includes('.')) {
              const value = row[key];
              return value === null || value === undefined ? '' : value;
            }

            return key.split('.').reduce((carry, part) => {
              if (carry === null || carry === undefined) return '';
              return carry[part];
            }, row) ?? '';
          },

          badgeClass(col, value) {
            if (col.badge_map && col.badge_map[value]) return col.badge_map[value];
            return 'bg-gray-100 text-gray-700';
          },

          refreshClientData() {
            let data = [...this.baseRows];

            if (this.search) {
              const q = this.search.toLowerCase();
              data = data.filter((row) => this.columns.some((col) =>
                String(this.cellValue(row, col)).toLowerCase().includes(q)
              ));
            }

            this.filters.forEach((filter) => {
              const val = this.filterValues[filter.key];
              if (val !== '' && val !== null && val !== undefined) {
                data = data.filter((row) => String(row[filter.key] ?? '') === String(val));
              }
            });

            if (this.sortBy) {
              data.sort((a, b) => {
                const av = String(this.cellValue(a, { key: this.sortBy })).toLowerCase();
                const bv = String(this.cellValue(b, { key: this.sortBy })).toLowerCase();
                if (av < bv) return this.sortDir === 'asc' ? -1 : 1;
                if (av > bv) return this.sortDir === 'asc' ? 1 : -1;
                return 0;
              });
            }

            this.total = data.length;
            this.lastPage = Math.max(1, Math.ceil(this.total / this.perPage));
            this.currentPage = Math.min(this.currentPage, this.lastPage);

            const start = (this.currentPage - 1) * this.perPage;
            this.displayedRows = data.slice(start, start + this.perPage);
          },

          buildQueryParams() {
            const query = new URLSearchParams();
            query.set(this.queryParams.search, this.search || '');
            query.set(this.queryParams.page, String(this.currentPage));
            query.set(this.queryParams.perPage, String(this.perPage));

            if (this.sortBy) {
              query.set(this.queryParams.sortBy, this.sortBy);
              query.set(this.queryParams.sortDir, this.sortDir);
            }

            Object.keys(this.filterValues).forEach((key) => {
              const val = this.filterValues[key];
              if (val !== '' && val !== null && val !== undefined) {
                query.set(key, String(val));
              }
            });

            return query;
          },

          normalizeResponse(payload) {
            if (Array.isArray(payload)) {
              return {
                rows: payload,
                total: payload.length,
                currentPage: this.currentPage,
                lastPage: Math.max(1, Math.ceil(payload.length / this.perPage)),
              };
            }

            const rows = payload.data || payload.rows || payload.items || [];
            const total = Number(payload.total ?? payload.meta?.total ?? rows.length);
            const currentPage = Number(payload.current_page ?? payload.meta?.current_page ?? this.currentPage);
            const lastPage = Number(payload.last_page ?? payload.meta?.last_page ?? Math.max(1, Math.ceil(total / this.perPage)));

            return { rows, total, currentPage, lastPage };
          },

          async fetchData() {
            if (!this.url) return;

            this.loading = true;
            this.error = '';

            try {
              const query = this.buildQueryParams().toString();
              const endpoint = this.url.includes('?') ? `${this.url}&${query}` : `${this.url}?${query}`;
              const response = await fetch(endpoint, {
                method: this.method,
                headers: {
                  'Accept': 'application/json',
                  'X-Requested-With': 'XMLHttpRequest',
                },
              });

              if (!response.ok) {
                throw new Error(`Failed to fetch table data (${response.status})`);
              }

              const payload = await response.json();
              const normalized = this.normalizeResponse(payload);
              this.displayedRows = normalized.rows || [];
              this.total = normalized.total || 0;
              this.currentPage = normalized.currentPage || 1;
              this.lastPage = normalized.lastPage || 1;
            } catch (e) {
              this.displayedRows = [];
              this.total = 0;
              this.currentPage = 1;
              this.lastPage = 1;
              this.error = e?.message || 'Unable to load data.';
            } finally {
              this.loading = false;
            }
          },
        };
      }
    </script>
  @endpush
@endonce
