@extends('layouts.theme')

@section('title', 'Marketing Dashboard')
@section('body_class', 'bg-gray-50 p-6')

@section('content')
  <div class="space-y-6">
    <x-dashboard.page-header
      title="Marketing Dashboard"
      subtitle="Campaign performance and funnel overview with static data."
    />

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
      @foreach($stats as $stat)
        <x-dashboard.stat-card :label="$stat['label']" :value="$stat['value']" :change="$stat['change']" :tone="$stat['tone']" />
      @endforeach
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
      <x-dashboard.panel title="Campaign ROI">
        <div class="space-y-4">
          @foreach($campaigns as $campaign)
            <div class="rounded-xl border border-gray-100 p-4 dark:border-gray-800">
              <div class="flex items-center justify-between">
                <p class="font-medium text-gray-800 dark:text-white/90">{{ $campaign['name'] }}</p>
                <x-ui.badge variant="{{ $campaign['roi'] >= 100 ? 'success' : 'warning' }}">ROI {{ $campaign['roi'] }}%</x-ui.badge>
              </div>
              <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Spend: {{ $campaign['spend'] }} | Revenue: {{ $campaign['revenue'] }}</p>
            </div>
          @endforeach
        </div>
      </x-dashboard.panel>

      <x-dashboard.panel title="Funnel">
        <div class="space-y-3">
          @foreach($funnel as $step)
            <div>
              <div class="mb-1 flex items-center justify-between text-sm">
                <span class="text-gray-700 dark:text-gray-300">{{ $step['name'] }}</span>
                <span class="text-gray-500 dark:text-gray-400">{{ $step['value'] }}</span>
              </div>
              <div class="h-2 rounded-full bg-gray-100 dark:bg-gray-800">
                <div class="h-2 rounded-full bg-blue-500" style="width: {{ $step['percent'] }}%"></div>
              </div>
            </div>
          @endforeach
        </div>
      </x-dashboard.panel>
    </div>
  </div>
@endsection

