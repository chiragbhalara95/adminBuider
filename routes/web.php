<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [LoginController::class, 'sendResetPasswordEmail'])->name('password.email');
    Route::get('/reset-password', function (Request $request) {
        $token = (string) $request->query('token', '');
        $email = (string) $request->query('email', '');

        if ($token === '') {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Invalid or expired password reset link.']);
        }

        return redirect()->route('password.reset', [
            'token' => $token,
            'email' => $email,
        ]);
    });
    Route::get('/reset-password/{token}', [LoginController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('password.update');

    Route::get('/signup', [LoginController::class, 'showSignupForm'])->name('signup');
    Route::post('/signup', [LoginController::class, 'signup'])->name('signup.submit');

    Route::post('/email/verification-notification', [LoginController::class, 'resendVerificationEmail'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('/email/verify/{id}/{hash}', [LoginController::class, 'verifyEmail'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
});

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/analytics', [DashboardController::class, 'analytics'])->name('dashboard.analytics');
    Route::get('/dashboard/marketing', [DashboardController::class, 'marketing'])->name('dashboard.marketing');
    Route::get('/dashboard/crm', [DashboardController::class, 'crm'])->name('dashboard.crm');
    Route::get('/dashboard/stocks', [DashboardController::class, 'stocks'])->name('dashboard.stocks');
    Route::get('/dashboard/saas', [DashboardController::class, 'saas'])->name('dashboard.saas');
    Route::get('/dashboard/logistics', [DashboardController::class, 'logistics'])->name('dashboard.logistics');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

    Route::post('/dashboard/demo-form', function (Request $request) {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'min:3', 'max:50', 'regex:/^[A-Za-z ]+$/'],
            'email' => ['required', 'email'],
            'role' => ['required', 'in:admin,editor,viewer'],
            'skills' => ['required', 'array', 'min:1'],
            'skills.*' => ['in:php,laravel,vue,react,devops'],
            'portfolio_url' => ['nullable', 'url'],
            'age' => ['required', 'integer', 'min:18', 'max:65'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'avatar' => ['nullable', 'file', 'max:2048', 'mimes:jpg,jpeg,png,webp,pdf'],
            'bio' => ['nullable', 'string', 'max:300'],
            'terms' => ['accepted'],
        ]);

        return back()->withInput()->with('demo_success', 'Dynamic form validation passed.');
    })->name('demo.form.submit');

    Route::get('/dashboard/demo-users', function (Request $request) {
        $rows = collect([
            ['id' => 1, 'name' => 'Jane Doe', 'email' => 'jane@example.com', 'role' => 'Admin', 'status' => 'Active'],
            ['id' => 2, 'name' => 'John Smith', 'email' => 'john@example.com', 'role' => 'Editor', 'status' => 'Pending'],
            ['id' => 3, 'name' => 'Aisha Khan', 'email' => 'aisha@example.com', 'role' => 'Viewer', 'status' => 'Blocked'],
            ['id' => 4, 'name' => 'Liam Wong', 'email' => 'liam@example.com', 'role' => 'Admin', 'status' => 'Active'],
            ['id' => 5, 'name' => 'Sophia Lee', 'email' => 'sophia@example.com', 'role' => 'Editor', 'status' => 'Pending'],
            ['id' => 6, 'name' => 'Noah Brown', 'email' => 'noah@example.com', 'role' => 'Viewer', 'status' => 'Active'],
            ['id' => 7, 'name' => 'Emma Wilson', 'email' => 'emma@example.com', 'role' => 'Editor', 'status' => 'Blocked'],
        ]);

        $search = trim((string) $request->query('search', ''));
        $sortBy = (string) $request->query('sort_by', 'id');
        $sortDir = strtolower((string) $request->query('sort_dir', 'asc')) === 'desc' ? 'desc' : 'asc';
        $perPage = max(1, min((int) $request->query('per_page', 5), 100));
        $status = trim((string) $request->query('status', ''));

        if ($search !== '') {
            $rows = $rows->filter(function (array $row) use ($search) {
                $needle = strtolower($search);
                return str_contains(strtolower($row['name']), $needle)
                    || str_contains(strtolower($row['email']), $needle)
                    || str_contains(strtolower($row['role']), $needle)
                    || str_contains(strtolower($row['status']), $needle);
            });
        }

        if ($status !== '') {
            $rows = $rows->where('status', $status);
        }

        $allowedSorts = ['id', 'name', 'email', 'role', 'status'];
        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'id';
        }

        $rows = $sortDir === 'desc'
            ? $rows->sortByDesc($sortBy)->values()
            : $rows->sortBy($sortBy)->values();

        $currentPage = max((int) $request->query('page', 1), 1);
        $total = $rows->count();
        $lastPage = max(1, (int) ceil($total / $perPage));
        $currentPage = min($currentPage, $lastPage);
        $pageRows = $rows->forPage($currentPage, $perPage)->values();

        return response()->json([
            'data' => $pageRows,
            'total' => $total,
            'current_page' => $currentPage,
            'last_page' => $lastPage,
        ]);
    })->name('demo.users.ajax');
});
