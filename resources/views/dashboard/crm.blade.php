@extends('layouts.theme')

@section('title', 'CRM Dashboard')
@section('body_class', 'bg-gray-50 p-6')

@section('content')
  <div class="space-y-6">
    <x-dashboard.page-header title="CRM Dashboard" subtitle="Lead pipeline and team performance with static data." />

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
      @foreach($stats as $stat)
        <x-dashboard.stat-card :label="$stat['label']" :value="$stat['value']" :change="$stat['change']" :tone="$stat['tone']" />
      @endforeach
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
      <div class="xl:col-span-2">
        <x-dashboard.panel title="Pipeline Stages">
          <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @foreach($pipeline as $stage)
              <div class="rounded-xl border border-gray-100 p-4 dark:border-gray-800">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $stage['name'] }}</p>
                <p class="mt-1 text-xl font-semibold text-gray-800 dark:text-white/90">{{ $stage['count'] }}</p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Value: {{ $stage['value'] }}</p>
              </div>
            @endforeach
          </div>
        </x-dashboard.panel>
      </div>

      <x-dashboard.panel title="Top Sales Reps">
        <div class="space-y-3">
          @foreach($salesReps as $rep)
            <div class="flex items-center justify-between rounded-xl border border-gray-100 p-3 dark:border-gray-800">
              <div>
                <p class="font-medium text-gray-800 dark:text-white/90">{{ $rep['name'] }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $rep['deals'] }} deals</p>
              </div>
              <p class="font-semibold text-gray-700 dark:text-gray-300">{{ $rep['amount'] }}</p>
            </div>
          @endforeach
        </div>
      </x-dashboard.panel>
    </div>
  </div>
@endsection

