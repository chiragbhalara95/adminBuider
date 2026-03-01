@extends('layouts.theme')

@section('title', 'Analytics Dashboard')
@section('body_class', 'bg-gray-50 p-6')

@section('content')
  <div class="space-y-6">
    <x-dashboard.page-header
      title="Analytics Dashboard"
      subtitle="Traffic, behavior, and conversion metrics with static sample data."
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
        <x-dashboard.panel title="Sessions Trend" subtitle="Last 30 days">
          <div class="grid h-64 grid-cols-12 items-end gap-2">
            @foreach($sessionsChart as $point)
              <div class="rounded-t bg-blue-500/80 dark:bg-blue-400/80" style="height: {{ $point }}%"></div>
            @endforeach
          </div>
        </x-dashboard.panel>
      </div>

      <x-dashboard.panel title="Top Channels">
        <div class="space-y-4">
          @foreach($channels as $channel)
            <div>
              <div class="mb-1 flex items-center justify-between text-sm">
                <span class="text-gray-700 dark:text-gray-300">{{ $channel['name'] }}</span>
                <span class="text-gray-500 dark:text-gray-400">{{ $channel['value'] }}%</span>
              </div>
              <div class="h-2 rounded-full bg-gray-100 dark:bg-gray-800">
                <div class="h-2 rounded-full bg-indigo-500" style="width: {{ $channel['value'] }}%"></div>
              </div>
            </div>
          @endforeach
        </div>
      </x-dashboard.panel>
    </div>
  </div>
@endsection

