<?php

namespace App\Http\Services;

use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\Dimension;

class AnalyticsService
{
    protected $client;
    protected $propertyId;

    public function __construct()
    {
        $this->propertyId = config('services.google_analytics.property_id');
        $this->client = new BetaAnalyticsDataClient([
            'credentials' => config('services.google_analytics.credentials_json'),
        ]);
    }

    public function fetchDashboardData()
    {
        $response = $this->client->runReport([
            'property' => 'properties/' . $this->propertyId,
            'dateRanges' => [
                new DateRange([
                    'start_date' => '28daysAgo',
                    'end_date' => 'today',
                ]),
            ],
            'metrics' => [
                new Metric(['name' => 'sessions']),
                new Metric(['name' => 'averageSessionDuration']),
                new Metric(['name' => 'bounceRate']),
                new Metric(['name' => 'newUsers']),
                new Metric(['name' => 'screenPageViews']),
            ],
            'dimensions' => [
                new Dimension(['name' => 'country']),
            ]
        ]);

        return $response;
    }
}
