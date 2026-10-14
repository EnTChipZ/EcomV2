<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Enums\UserStatus;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'pendingCount' => User::query()->where('status', UserStatus::PendingApproval)->count(),
            'figma' => '01_Admin_Dashboard 1',
        ]);
    }

    public function cms(): View
    {
        return view('admin.stub', ['figma' => 'Admin 2', 'title' => 'Marketplace CMS']);
    }

    public function users(): View
    {
        return view('admin.stub', ['figma' => 'Admin 3', 'title' => 'Users']);
    }

    public function disputes(): View
    {
        return view('admin.stub', ['figma' => 'Disputes_Admin', 'title' => 'Disputes']);
    }

    public function reports(): View
    {
        return view('admin.stub', ['figma' => '13_Reports_Analytics 1', 'title' => 'Reports']);
    }
}
