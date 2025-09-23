<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index()
    {
        // In a real application, this would fetch data from various models
        // For now, we'll just return the view with sample data
        
        return view('dashboard.index');
    }
}
