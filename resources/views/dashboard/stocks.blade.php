@extends('layouts.theme')

@section('title', 'Stocks Dashboard')
@section('body_class', 'bg-gray-50 p-6')

@section('content')
  <div class="space-y-6">
    <x-dashboard.page-header title="Stocks Dashboard" subtitle="Watchlist and portfolio summary with static market data." />

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
      @foreach($stats as $stat)
        <x-dashboard.stat-card :label="$stat['label']" :value="$stat['value']" :change="$stat['change']" :tone="$stat['tone']" />
      @endforeach
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
      <div class="xl:col-span-2">
        <x-dashboard.panel title="Watchlist">
          <div class="overflow-x-auto">
            <table class="w-full min-w-[560px]">
              <thead>
                <tr class="border-b border-gray-100 text-left text-xs uppercase text-gray-500 dark:border-gray-800 dark:text-gray-400">
                  <th class="pb-3">Symbol</th>
                  <th class="pb-3">Company</th>
                  <th class="pb-3">Price</th>
                  <th class="pb-3">Change</th>
                </tr>
              </thead>
              <tbody>
                @foreach($watchlist as $stock)
                  <tr class="border-b border-gray-100 last:border-0 dark:border-gray-800">
                    <td class="py-3 font-semibold text-gray-800 dark:text-white/90">{{ $stock['symbol'] }}</td>
                    <td class="py-3 text-sm text-gray-600 dark:text-gray-300">{{ $stock['name'] }}</td>
                    <td class="py-3 text-sm text-gray-800 dark:text-gray-200">{{ $stock['price'] }}</td>
                    <td class="py-3 text-sm {{ $stock['up'] ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">{{ $stock['change'] }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </x-dashboard.panel>
      </div>

      <x-dashboard.panel title="Portfolio Allocation">
        <div class="space-y-4">
          @foreach($allocation as $item)
            <div>
              <div class="mb-1 flex justify-between text-sm">
                <span class="text-gray-700 dark:text-gray-300">{{ $item['sector'] }}</span>
                <span class="text-gray-500 dark:text-gray-400">{{ $item['value'] }}%</span>
              </div>
              <div class="h-2 rounded-full bg-gray-100 dark:bg-gray-800">
                <div class="h-2 rounded-full bg-violet-500" style="width: {{ $item['value'] }}%"></div>
              </div>
            </div>
          @endforeach
        </div>
      </x-dashboard.panel>
    </div>
  </div>
@endsection

