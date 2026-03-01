@extends('layouts.theme')

@section('title', 'SaaS Dashboard')
@section('body_class', 'bg-gray-50 p-6')

@section('content')
  <div class="space-y-6">
    <x-dashboard.page-header title="SaaS Dashboard" subtitle="Subscription growth and customer health metrics (static)." />

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
      @foreach($stats as $stat)
        <x-dashboard.stat-card :label="$stat['label']" :value="$stat['value']" :change="$stat['change']" :tone="$stat['tone']" />
      @endforeach
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
      <x-dashboard.panel title="MRR Growth">
        <div class="grid h-64 grid-cols-12 items-end gap-2">
          @foreach($mrrChart as $point)
            <div class="rounded-t bg-emerald-500/80 dark:bg-emerald-400/80" style="height: {{ $point }}%"></div>
          @endforeach
        </div>
      </x-dashboard.panel>

      <x-dashboard.panel title="Plan Distribution">
        <div class="space-y-3">
          @foreach($plans as $plan)
            <div class="flex items-center justify-between rounded-xl border border-gray-100 p-3 dark:border-gray-800">
              <p class="text-gray-700 dark:text-gray-300">{{ $plan['name'] }}</p>
              <p class="font-semibold text-gray-800 dark:text-white/90">{{ $plan['count'] }}</p>
            </div>
          @endforeach
        </div>
      </x-dashboard.panel>
    </div>
  </div>
@endsection

