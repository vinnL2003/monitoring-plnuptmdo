<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataSource;
use App\Models\NavigationItem;
use App\Models\ProgressItem;
use App\Models\Section;
use App\Models\SiteSetting;
use App\Models\StatCard;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'sections_count' => Section::count(),
            'visible_sections_count' => Section::where('is_visible', true)->count(),
            'stat_cards_count' => StatCard::count(),
            'progress_items_count' => ProgressItem::count(),
            'data_sources_count' => DataSource::count(),
            'nav_items_count' => NavigationItem::count(),
        ];

        $recentSections = Section::orderBy('order')->take(7)->get();
        $dataSources = DataSource::all();

        return view('admin.dashboard', compact('stats', 'recentSections', 'dataSources'));
    }
}
