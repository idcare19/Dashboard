<?php

namespace App\Http\Controllers;

use App\Models\PortfolioSetting;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $portfolio = PortfolioSetting::singleton();

        return view('portfolio.show', compact('portfolio'));
    }
}
