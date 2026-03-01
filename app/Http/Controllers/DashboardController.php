<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function dashboard()
    {
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

        return view('ui-components-demo', [
            'dynamicFields' => $dynamicFields,
            'dynamicValues' => old(),
            'tableColumns' => $tableColumns,
            'tableRowsFallback' => $tableRowsFallback,
        ]);
    }

    public function profile()
    {
        $profile = [
            'name' => 'Musharof Chowdhury',
            'role' => 'Team Manager',
            'location' => 'Arizona, United States',
            'avatar' => 'https://i.pravatar.cc/160?img=12',
            'socials' => ['facebook', 'x', 'linkedin', 'instagram'],
        ];

        $personalInformation = [
            'First Name' => 'Musharof',
            'Last Name' => 'Chowdhury',
            'Email Address' => 'randomuser@pimjo.com',
            'Phone' => '+09 363 398 46',
            'Bio' => 'Team Manager',
        ];

        $address = [
            'Country' => 'United States',
            'City/State' => 'Arizona, United States',
            'Postal Code' => 'ERT 2489',
            'Tax ID' => 'AS4568384',
        ];

        return view('profile', compact('profile', 'personalInformation', 'address'));
    }
}
