<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('ui-components-demo');
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
