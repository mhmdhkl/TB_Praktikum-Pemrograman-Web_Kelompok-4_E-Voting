<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Candidate;

class DashboardController extends Controller
{
    public function index()
    {


        return view('dashboard.index', [
            'title' => 'E-Voting | Dashboard'
        ]);
    }
}
