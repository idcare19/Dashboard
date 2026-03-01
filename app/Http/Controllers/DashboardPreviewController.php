<?php

namespace App\Http\Controllers;

use App\Models\PortfolioSetting;
use Illuminate\View\View;

class DashboardPreviewController extends Controller
{
    public function index(): View
    {
        $portfolio = PortfolioSetting::singleton();

        return view('portfolio.preview', compact('portfolio'));
    }
}
