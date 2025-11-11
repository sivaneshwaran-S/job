<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'employers' => 12,
            'employees' => 45,
            'jobs' => 20
        ]);
    }
}
