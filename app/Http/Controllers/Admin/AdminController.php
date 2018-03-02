<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscription;
use App\Models\User;
use App\Models\VideoGenerated;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        $allUsers = User::count();
        $totalShares = User::sum('number_of_shares');
        $payingUsers = Subscription::count();
        $videosCreated = VideoGenerated::count();
        return view('admin.index', compact('allUsers', 'payingUsers', 'videosCreated', 'totalShares'));
    }
}
