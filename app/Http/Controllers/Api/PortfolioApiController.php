<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PortfolioSetting;
use Illuminate\Http\JsonResponse;

class PortfolioApiController extends Controller
{
    public function show(): JsonResponse
    {
        $portfolio = PortfolioSetting::singleton();

        return response()->json([
            'success' => true,
            'data' => [
                'site_title' => $portfolio->site_title,
                'person_name' => $portfolio->person_name,
                'hero_title' => $portfolio->hero_title,
                'hero_subtitle' => $portfolio->hero_subtitle,
                'availability' => $portfolio->availability,
                'location' => $portfolio->location,
                'avatar_url' => $portfolio->avatar_url,
                'contact_email' => $portfolio->contact_email,
                'popup_message' => $portfolio->popup_message,
                'badges' => $portfolio->badges ?? [],
                'stats' => $portfolio->stats ?? [],
                'about_cards' => $portfolio->about_cards ?? [],
                'projects' => $portfolio->projects ?? [],
                'skills' => $portfolio->skills ?? [],
                'experiences' => $portfolio->experiences ?? [],
                'socials' => $portfolio->socials ?? [],
                'graph_points' => $portfolio->graph_points ?? [],
                'upcoming_projects' => $portfolio->upcoming_projects ?? [],
                'updates_feed' => $portfolio->updates_feed ?? [],
            ],
        ]);
    }
}
