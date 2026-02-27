@extends('layouts.theme')

@section('title', 'UI Components Demo')
@section('body_class', 'bg-gray-50 p-6')

@section('content')
  @php
    $dynamicFields = [
      [
        'type' => 'input',
        'name' => 'full_name',
        'label' => 'Full Name',
        'placeholder' => 'Enter full name',
        'rules' => 'required|min:3|max:50|regex:/^[A-Za-z ]+$/',
        'validation' => [
          'title' => 'Only alphabets and spaces allowed.',
        ],
      ],
      [
        'type' => 'email',
        'name' => 'email',
        'label' => 'Email',
        'placeholder' => 'you@example.com',
        'rules' => 'required|email',
      ],
      [
        'type' => 'select2',
        'name' => 'role',
        'label' => 'Role',
        'options' => [
          'admin' => 'Admin',
          'editor' => 'Editor',
          'viewer' => 'Viewer',
        ],
        'rules' => 'required',
        'placeholder' => 'Select role',
      ],
      [
        'type' => 'select2',
        'name' => 'skills',
        'label' => 'Skills',
        'multiple' => true,
        'placeholder' => 'Select skills',
        'options' => [
          'php' => 'PHP',
          'laravel' => 'Laravel',
          'vue' => 'Vue',
          'react' => 'React',
          'devops' => 'DevOps',
        ],
        'validation' => [
          'required' => true,
        ],
      ],
      [
        'type' => 'url',
        'name' => 'portfolio_url',
        'label' => 'Portfolio URL',
        'placeholder' => 'https://example.com',
        'validation' => [
          'maxlength' => 200,
        ],
      ],
      [
        'type' => 'number',
        'name' => 'age',
        'label' => 'Age',
        'placeholder' => '18',
        'validation' => [
          'required' => true,
          'min' => 18,
          'max' => 65,
          'step' => 1,
        ],
      ],
      [
        'type' => 'timepicker',
        'name' => 'appointment_time',
        'label' => 'Appointment Time',
        'rules' => 'required',
      ],
      [
        'type' => 'file',
        'name' => 'avatar',
        'label' => 'Avatar / Resume',
        'validation' => [
          'extensions' => ['jpg', 'jpeg', 'png', 'webp', 'pdf'],
          'max_size_kb' => 2048,
        ],
      ],
      [
        'type' => 'textarea',
        'name' => 'bio',
        'label' => 'Bio',
        'placeholder' => 'Write short bio',
        'rows' => 4,
        'rules' => 'max:300',
        'wrapper_class' => 'md:col-span-2',
      ],
      [
        'type' => 'checkbox',
        'name' => 'terms',
        'label' => 'I accept terms and conditions',
        'rules' => 'required',
      ],
      [
        'type' => 'switch',
        'name' => 'notifications',
        'label' => 'Enable notifications',
        'checked' => true,
      ],
      [
        'type' => 'input-group',
        'name' => 'salary',
        'label' => 'Expected Salary',
        'input_type' => 'number',
        'prepend' => '$',
        'append' => 'USD',
        'validation' => [
          'min' => 1000,
          'max' => 50000,
        ],
        'placeholder' => '5000',
      ],
    ];

    $dynamicValues = old();

    $tableColumns = [
      ['key' => 'id', 'label' => 'ID'],
      ['key' => 'name', 'label' => 'Name'],
      ['key' => 'email', 'label' => 'Email'],
      ['key' => 'role', 'label' => 'Role'],
      [
        'key' => 'status',
        'label' => 'Status',
        'type' => 'badge',
        'badge_map' => [
          'Active' => 'bg-emerald-100 text-emerald-700',
          'Pending' => 'bg-amber-100 text-amber-700',
          'Blocked' => 'bg-red-100 text-red-700',
        ],
      ],
    ];

    $tableRowsFallback = [
      ['id' => 1, 'name' => 'Jane Doe', 'email' => 'jane@example.com', 'role' => 'Admin', 'status' => 'Active'],
      ['id' => 2, 'name' => 'John Smith', 'email' => 'john@example.com', 'role' => 'Editor', 'status' => 'Pending'],
      ['id' => 3, 'name' => 'Aisha Khan', 'email' => 'aisha@example.com', 'role' => 'Viewer', 'status' => 'Blocked'],
    ];
  @endphp

  <div class="mx-auto max-w-7xl space-y-6">
    <div class="rounded-2xl bg-white p-6 shadow">
      <h1 class="text-2xl font-semibold text-gray-900">UI Components Demo</h1>
      <p class="mt-1 text-sm text-gray-600">Dynamic fields, dynamic form validation, select2, and AJAX datatable.</p>

      @if(session('demo_success'))
        <x-ui.alert variant="success" class="mt-4">{{ session('demo_success') }}</x-ui.alert>
      @endif
    </div>

    <div class="rounded-2xl bg-white p-6 shadow">
      <h2 class="text-lg font-semibold text-gray-900">Dynamic Form With Validation</h2>
      <p class="mt-1 text-sm text-gray-600">Rules include required, min/max, minlength/maxlength, pattern, URL, and file extension/size checks.</p>

      <x-dynamic-form
        :action="route('demo.form.submit')"
        method="POST"
        :fields="$dynamicFields"
        :values="$dynamicValues"
        :columns="2"
        submitLabel="Validate and Submit"
      />
    </div>

    <div class="rounded-2xl bg-white p-6 shadow">
      <h2 class="text-lg font-semibold text-gray-900">DataTable With AJAX, Search, Sort, Filters, Pagination</h2>
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
@endsection
