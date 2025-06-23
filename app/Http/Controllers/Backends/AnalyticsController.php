<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GoogleAnalyticsService;

class AnalyticsController extends Controller
{
    protected $analytics;

    public function __construct(GoogleAnalyticsService $analytics)
    {
        $this->analytics = $analytics;
    }

    public function index()
    {

        return view('backend.analytics.index');
    }

    public function deviceSessions()
    {
        $report = $this->analytics->runReport(
            ['deviceCategory'],
            ['sessions']
        );

        $data = collect($report->getRows())->map(fn($row) => [
            'device' => $row->getDimensionValues()[0]->getValue(),
            'sessions' => $row->getMetricValues()[0]->getValue(),
        ]);

        return response()->json($data);
    }

    public function pageviews()
    {
        $report = $this->analytics->runReport(
            [],
            ['screenPageViews']
        );

        return response()->json([
            'pageviews' => $report->getRows()[0]->getMetricValues()[0]->getValue()
        ]);
    }

    public function avgTimeOnSite()
    {
        $report = $this->analytics->runReport(
            [],
            ['userEngagementDuration', 'sessions']
        );

        $duration = $report->getRows()[0]->getMetricValues()[0]->getValue();
        $sessions = $report->getRows()[0]->getMetricValues()[1]->getValue();
        $avgTime = $sessions ? (int)$duration / (int)$sessions : 0;

        return response()->json([
            'avg_time_on_site' => gmdate('H:i:s', (int)$avgTime)
        ]);
    }

    public function bounceRate()
    {
        $report = $this->analytics->runReport(
            [],
            ['bounceRate']
        );

        return response()->json([
            'bounce_rate' => $report->getRows()[0]->getMetricValues()[0]->getValue()
        ]);
    }

    public function newSessions()
    {
        $report = $this->analytics->runReport(
            [],
            ['newUsers', 'sessions']
        );

        $newUsers = $report->getRows()[0]->getMetricValues()[0]->getValue();
        $sessions = $report->getRows()[0]->getMetricValues()[1]->getValue();
        $percentage = $sessions ? ((int)$newUsers / (int)$sessions) * 100 : 0;

        return response()->json([
            'new_sessions_percentage' => round($percentage, 2)
        ]);
    }

    public function usersByCountry()
    {
        $report = $this->analytics->runReport(
            ['country'],
            ['sessions']
        );

        $data = collect($report->getRows())->map(fn($row) => [
            'country' => $row->getDimensionValues()[0]->getValue(),
            'sessions' => $row->getMetricValues()[0]->getValue(),
        ]);

        return response()->json($data);
    }

    public function landingPages()
    {
        $report = $this->analytics->runReport(
            ['landingPage'],
            ['sessions']
        );

        $data = collect($report->getRows())->map(fn($row) => [
            'page' => $row->getDimensionValues()[0]->getValue(),
            'sessions' => $row->getMetricValues()[0]->getValue(),
        ]);

        return response()->json($data);
    }

    public function trafficSources()
    {
        $report = $this->analytics->runReport(
            ['sessionSource'],
            ['sessions']
        );

        $data = collect($report->getRows())->map(fn($row) => [
            'source' => $row->getDimensionValues()[0]->getValue(),
            'sessions' => $row->getMetricValues()[0]->getValue(),
        ]);

        return response()->json($data);
    }


}
