<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $banner = Banner::where('status','1')->get();
        return Inertia::render('Welcome', ['banner' => $banner]);
    }
}
