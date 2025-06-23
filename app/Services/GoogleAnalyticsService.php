<?php

namespace App\Services;

use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\RunReportRequest;

class GoogleAnalyticsService
{
    protected $propertyId;

    public function __construct()
    {
        $this->propertyId = config('services.analytics.property_id');
    }

    public function runReport(array $dimensions, array $metrics, string $startDate = '30daysAgo', string $endDate = 'today')
    {
        $client = new BetaAnalyticsDataClient();

        $request = new RunReportRequest([
            'property' => 'properties/' . $this->propertyId,
            'date_ranges' => [
                new DateRange(['start_date' => $startDate, 'end_date' => $endDate]),
            ],
            'dimensions' => array_map(fn($d) => new Dimension(['name' => $d]), $dimensions),
            'metrics' => array_map(fn($m) => new Metric(['name' => $m]), $metrics),
        ]);

        return $client->runReport($request);
    }
}
