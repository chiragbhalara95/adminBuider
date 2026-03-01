@extends('layouts.theme')

@section('title', 'Logistics Dashboard')
@section('body_class', 'bg-gray-50 p-6')

@section('content')
  <div class="space-y-6">
    <x-dashboard.page-header title="Logistics Dashboard" subtitle="Fleet, shipments, and warehouse metrics with static data." />

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
      @foreach($stats as $stat)
        <x-dashboard.stat-card :label="$stat['label']" :value="$stat['value']" :change="$stat['change']" :tone="$stat['tone']" />
      @endforeach
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
      <div class="xl:col-span-2">
        <x-dashboard.panel title="Shipment Status">
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            @foreach($shipments as $shipment)
              <div class="rounded-xl border border-gray-100 p-4 dark:border-gray-800">
                <p class="text-sm text-gray-500 dark:text-gray-400">Tracking #{{ $shipment['id'] }}</p>
                <p class="mt-1 font-semibold text-gray-800 dark:text-white/90">{{ $shipment['route'] }}</p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">ETA: {{ $shipment['eta'] }}</p>
                <div class="mt-3 h-2 rounded-full bg-gray-100 dark:bg-gray-800">
                  <div class="h-2 rounded-full bg-cyan-500" style="width: {{ $shipment['progress'] }}%"></div>
                </div>
              </div>
            @endforeach
          </div>
        </x-dashboard.panel>
      </div>

      <x-dashboard.panel title="Warehouse Utilization">
        <div class="space-y-4">
          @foreach($warehouses as $warehouse)
            <div>
              <div class="mb-1 flex justify-between text-sm">
                <span class="text-gray-700 dark:text-gray-300">{{ $warehouse['name'] }}</span>
                <span class="text-gray-500 dark:text-gray-400">{{ $warehouse['load'] }}%</span>
              </div>
              <div class="h-2 rounded-full bg-gray-100 dark:bg-gray-800">
                <div class="h-2 rounded-full bg-orange-500" style="width: {{ $warehouse['load'] }}%"></div>
              </div>
            </div>
          @endforeach
        </div>
      </x-dashboard.panel>
    </div>
  </div>
@endsection

