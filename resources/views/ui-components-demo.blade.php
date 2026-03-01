@extends('layouts.theme')

@section('title', 'Dashboard')
@section('body_class', 'bg-gray-50 p-6')

@section('content')
  <div class="space-y-6">
    <x-dashboard.page-header
      title="Dashboard"
      subtitle="Overview dashboard using static data and shared UI components."
    />

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
      @foreach($stats as $stat)
        <x-dashboard.stat-card
          :label="$stat['label']"
          :value="$stat['value']"
          :change="$stat['change']"
          :tone="$stat['tone']"
        />
      @endforeach
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
      <div class="xl:col-span-2">
        <x-dashboard.panel title="Revenue Overview" subtitle="Monthly trend">
          <div class="grid h-64 grid-cols-12 items-end gap-2">
            @foreach($revenueChart as $value)
              <div class="rounded-t bg-indigo-500/80 dark:bg-indigo-400/80" style="height: {{ $value }}%"></div>
            @endforeach
          </div>
        </x-dashboard.panel>
      </div>

      <x-dashboard.panel title="Traffic Sources">
        <div class="space-y-4">
          @foreach($sources as $source)
            <div>
              <div class="mb-1 flex items-center justify-between text-sm">
                <span class="text-gray-700 dark:text-gray-300">{{ $source['name'] }}</span>
                <span class="text-gray-500 dark:text-gray-400">{{ $source['value'] }}%</span>
              </div>
              <div class="h-2 rounded-full bg-gray-100 dark:bg-gray-800">
                <div class="h-2 rounded-full bg-blue-500" style="width: {{ $source['value'] }}%"></div>
              </div>
            </div>
          @endforeach
        </div>
      </x-dashboard.panel>
    </div>

    <x-dashboard.panel title="Recent Activity">
      <div class="space-y-3">
        @foreach($activities as $activity)
          <div class="rounded-xl border border-gray-100 p-4 dark:border-gray-800">
            <div class="flex items-center justify-between">
              <p class="font-medium text-gray-800 dark:text-white/90">{{ $activity['title'] }}</p>
              <x-ui.badge variant="{{ $activity['badge'] }}">{{ $activity['tag'] }}</x-ui.badge>
            </div>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $activity['time'] }}</p>
          </div>
        @endforeach
      </div>
    </x-dashboard.panel>
  </div>
@endsection

