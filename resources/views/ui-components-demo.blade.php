<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>UI Components Demo</title>
  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @else
    <script src="https://cdn.tailwindcss.com"></script>
  @endif
</head>
<body class="bg-gray-50 p-6">
  @php
    $dynamicFields = [
      [
        'type' => 'text',
        'name' => 'full_name',
        'label' => 'Full Name',
        'placeholder' => 'Enter full name',
        'required' => true,
      ],
      [
        'type' => 'email',
        'name' => 'email',
        'label' => 'Email',
        'placeholder' => 'you@example.com',
      ],
      [
        'type' => 'select',
        'name' => 'role',
        'label' => 'Role',
        'options' => [
          'admin' => 'Admin',
          'editor' => 'Editor',
          'viewer' => 'Viewer',
        ],
        'placeholder' => 'Select role',
      ],
      [
        'type' => 'textarea',
        'name' => 'bio',
        'label' => 'Bio',
        'placeholder' => 'Write short bio',
        'rows' => 4,
        'wrapper_class' => 'md:col-span-2',
      ],
      [
        'type' => 'checkbox',
        'name' => 'terms',
        'label' => 'Accept terms',
        'checked' => true,
      ],
      [
        'type' => 'switch',
        'name' => 'notifications',
        'label' => 'Enable notifications',
        'checked' => true,
      ],
    ];

    $dynamicValues = [
      'full_name' => 'Jane Doe',
      'role' => 'editor',
    ];
  @endphp

  <div class="mx-auto max-w-3xl space-y-6 rounded-2xl bg-white p-6 shadow">
    <h1 class="text-xl font-semibold text-gray-900">Laravel UI Components</h1>

    <div>
      <x-ui.label for="name" required>Name</x-ui.label>
      <x-ui.input name="name" id="name" placeholder="Enter name" />
    </div>

    <div>
      <x-ui.label for="role">Role</x-ui.label>
      <x-ui.select name="role" :options="['admin' => 'Admin', 'editor' => 'Editor', 'viewer' => 'Viewer']" selected="editor" />
    </div>

    <div>
      <x-ui.label for="bio">Bio</x-ui.label>
      <x-ui.textarea name="bio" id="bio" rows="4" placeholder="Write something..."></x-ui.textarea>
    </div>

    <div class="space-y-3">
      <x-ui.checkbox name="terms" label="Accept terms" :checked="true" />
      <x-ui.switch name="notify" label="Enable notifications" :checked="true" />
    </div>

    <div class="flex flex-wrap gap-3">
      <x-ui.button>Primary</x-ui.button>
      <x-ui.button variant="secondary">Secondary</x-ui.button>
      <x-ui.button variant="success">Success</x-ui.button>
      <x-ui.button variant="danger">Danger</x-ui.button>
    </div>

    <div class="space-y-3 border-t border-gray-200 pt-6">
      <h2 class="text-lg font-semibold text-gray-900">Dynamic Fields (Array Driven)</h2>
      <x-ui.dynamic-fields :fields="$dynamicFields" :values="$dynamicValues" :columns="2" />
    </div>
  </div>
</body>
</html>

