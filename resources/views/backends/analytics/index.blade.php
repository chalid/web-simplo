<!-- resources/views/dashboard/analytics.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-6">Website Analytics Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Pageviews -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold">Pageviews</h3>
            <div id="chart-pageviews"></div>
        </div>

        <!-- Avg Time on Site -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold">Avg Time on Site</h3>
            <div id="chart-time"></div>
        </div>

        <!-- Bounce Rate -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold">Bounce Rate</h3>
            <div id="chart-bounce"></div>
        </div>

        <!-- New Sessions -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold">New Sessions</h3>
            <div id="chart-new-sessions"></div>
        </div>

        <!-- Users by Country -->
        <div class="bg-white p-4 rounded shadow col-span-1 md:col-span-2">
            <h3 class="text-lg font-semibold">Users by Country</h3>
            <div id="chart-countries"></div>
        </div>

        <!-- Top Landing Pages -->
        <div class="bg-white p-4 rounded shadow col-span-1 md:col-span-2">
            <h3 class="text-lg font-semibold">Top Landing Pages</h3>
            <div id="chart-landing-pages"></div>
        </div>

        <!-- Traffic Sources -->
        <div class="bg-white p-4 rounded shadow col-span-1 md:col-span-2">
            <h3 class="text-lg font-semibold">Traffic Sources</h3>
            <div id="chart-sources"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    async function fetchData(url) {
        const res = await fetch(url);
        return await res.json();
    }

    document.addEventListener('DOMContentLoaded', async function () {
        const base = '/api/analytics';

        // Pageviews
        const pageviews = await fetchData(`${base}/pageviews`);
        new ApexCharts(document.querySelector("#chart-pageviews"), {
            chart: { type: 'bar', height: 100 },
            series: [{ name: 'Pageviews', data: [parseInt(pageviews.pageviews)] }],
            xaxis: { categories: ['Total'] }
        }).render();

        // Avg Time on Site
        const time = await fetchData(`${base}/avg-time-on-site`);
        document.querySelector("#chart-time").innerText = time.avg_time_on_site;

        // Bounce Rate
        const bounce = await fetchData(`${base}/bounce-rate`);
        document.querySelector("#chart-bounce").innerText = bounce.bounce_rate + "%";

        // New Sessions
        const newSessions = await fetchData(`${base}/new-sessions`);
        document.querySelector("#chart-new-sessions").innerText = newSessions.new_sessions_percentage + "%";

        // Users by Country
        const countries = await fetchData(`${base}/users-by-country`);
        new ApexCharts(document.querySelector("#chart-countries"), {
            chart: { type: 'bar', height: 300 },
            series: [{ name: 'Sessions', data: countries.map(c => parseInt(c.sessions)) }],
            xaxis: { categories: countries.map(c => c.country) }
        }).render();

        // Landing Pages
        const landing = await fetchData(`${base}/landing-pages`);
        new ApexCharts(document.querySelector("#chart-landing-pages"), {
            chart: { type: 'bar', height: 300 },
            series: [{ name: 'Sessions', data: landing.map(p => parseInt(p.sessions)) }],
            xaxis: { categories: landing.map(p => p.page) }
        }).render();

        // Traffic Sources
        const sources = await fetchData(`${base}/traffic-sources`);
        new ApexCharts(document.querySelector("#chart-sources"), {
            chart: { type: 'bar', height: 300 },
            series: [{ name: 'Sessions', data: sources.map(s => parseInt(s.sessions)) }],
            xaxis: { categories: sources.map(s => s.source) }
        }).render();
    });
</script>
@endsection
