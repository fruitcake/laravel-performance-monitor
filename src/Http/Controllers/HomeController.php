<?php

namespace Fruitcake\PerformanceMonitor\Http\Controllers;

use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('performance-monitor::home');
    }
}
