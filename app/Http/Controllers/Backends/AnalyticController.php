<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\Sysparam;
use Illuminate\Http\Request;
use DataTables;
use Session;
use DB;
use Redirect;
use Auth;
use Validator;
use AnalyticsService;

class AnalyticController extends Controller
{
    public function index(AnalyticsService $analyticsService)
    {
        $analytics = $analyticsService->fetchDashboardData();

        return view('backend.analytic.index', compact('analytics'));
    }
}
