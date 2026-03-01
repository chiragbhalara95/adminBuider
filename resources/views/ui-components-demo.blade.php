@extends('layouts.theme')

@section('title', 'UI Components Demo')
@section('body_class', 'bg-gray-50 p-6')

@section('content')
  <div class="space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="px-5 py-4 sm:px-6 sm:py-5">
        <h1 class="text-xl font-semibold text-gray-900 dark:text-white/90">Form Elements</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Rendering similar to TailAdmin form-elements layout with dynamic configuration.</p>
      </div>
      @if(session('demo_success'))
        <div class="border-t border-gray-100 px-5 py-4 sm:px-6 dark:border-gray-800">
          <x-ui.alert variant="success">{{ session('demo_success') }}</x-ui.alert>
        </div>
      @endif
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
      <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
          <div class="px-5 py-4 sm:px-6 sm:py-5">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Dynamic Form With Validation</h3>
          </div>
          <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
            <p class="text-sm text-gray-600 dark:text-gray-400">Rules: required, min/max, minlength/maxlength, pattern, URL, file extension/size.</p>

            @if($errors->any())
              <x-ui.alert variant="danger">
                <strong class="block">Please fix the following errors:</strong>
                <ul class="mt-2 list-disc pl-5">
                  @foreach($errors->all() as $message)
                    <li>{{ $message }}</li>
                  @endforeach
                </ul>
              </x-ui.alert>
            @endif

            <x-dynamic-form
              :action="route('demo.form.submit')"
              method="POST"
              :fields="$dynamicFields"
              :values="$dynamicValues"
              :columns="2"
              submitLabel="Validate and Submit"
            />
          </div>
        </div>
      </div>

      <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
          <div class="px-5 py-4 sm:px-6 sm:py-5">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Static Input Preview</h3>
          </div>
          <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
            <div>
              <x-ui.label for="preview_name">Input</x-ui.label>
              <x-ui.input id="preview_name" name="preview_name" placeholder="Enter value" />
            </div>
            <div>
              <x-ui.label for="preview_email">Input with Placeholder</x-ui.label>
              <x-ui.input id="preview_email" name="preview_email" type="email" placeholder="info@gmail.com" />
            </div>
            <div>
              <x-ui.label for="preview_select">Select Input</x-ui.label>
              <x-ui.select id="preview_select" name="preview_select" :options="['marketing' => 'Marketing', 'template' => 'Template', 'development' => 'Development']" />
            </div>
            <div>
              <x-ui.label for="preview_date">Date Picker Input</x-ui.label>
              <x-ui.date id="preview_date" name="preview_date" />
            </div>
            <div>
              <x-ui.label for="preview_time">Time Select Input</x-ui.label>
              <x-ui.timepicker id="preview_time" name="preview_time" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="px-5 py-4 sm:px-6 sm:py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">DataTable With AJAX, Search, Sorting, Filters</h3>
      </div>
      <div class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
        <x-ui.datatable
          id="users-table-demo"
          :columns="$tableColumns"
          :url="route('demo.users.ajax')"
          :rows="$tableRowsFallback"
          :filters="[
            ['key' => 'status', 'label' => 'Status', 'options' => ['Active' => 'Active', 'Pending' => 'Pending', 'Blocked' => 'Blocked']],
          ]"
          :showIndex="true"
          :perPage="5"
          :perPageOptions="[5, 10, 25]"
          initialSortBy="id"
          initialSortDir="asc"
        />
      </div>
    </div>
  </div>
@endsection
