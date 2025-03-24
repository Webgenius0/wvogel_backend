<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CareerStatistics;
use App\Models\CurrentStatistics;
use App\Services\ScraperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiEquibaseTrainerProfileDataController extends Controller
{
    protected $scraperService;

    public function __construct(ScraperService $scraperService)
    {
        $this->scraperService = $scraperService;
    }

    public function scrape()
    {
        Log::info('Starting scrape');
        // The URL to scrape
        $url = "https://www.equibase.com/profiles/Results.cfm?type=People&searchType=T&eID=950082";

        // Call the scraper service
        $scrapedData = $this->scraperService->scrapeData($url);

        // Debug: Dump the scraped data

        Log::info('Scraped data:', $scrapedData);
           $this->scrapedDataUpdate($scrapedData);

        // Return the scraped data as JSON
        return response()->json($scrapedData);
    }

    public function scrapedDataUpdate($scrapedData)
{
    // Saving the current statistics data
    if (isset($scrapedData['2025_Statistics']) && count($scrapedData['2025_Statistics']) > 0) {
        foreach ($scrapedData['2025_Statistics'] as $data) {
            CurrentStatistics::updateOrCreate(
                ['id' => 1], // Assuming you're updating a single record. Adjust as needed
                [
                    'starts' => $data['Starts'],
                    'firsts' => $data['Firsts'],
                    'seconds' => $data['Seconds'],
                    'thirds' => $data['Thirds'],
                    'earnings' => $data['Earnings']
                ]
            );
        }
    }

    // Saving the career statistics data
    if (isset($scrapedData['Career_Statistics']) && count($scrapedData['Career_Statistics']) > 0) {
        foreach ($scrapedData['Career_Statistics'] as $data) {
            CareerStatistics::updateOrCreate(
                ['id' => 1], // Assuming you're updating a single record. Adjust as needed
                [
                    'starts' => $data['Starts'],
                    'firsts' => $data['Firsts'],
                    'seconds' => $data['Seconds'],
                    'thirds' => $data['Thirds'],
                    'earnings' => $data['Earnings']
                ]
            );
        }
    }
}

public function getScapingdata() {

try {
    $data = CurrentStatistics::first();
    $careerData = CareerStatistics::first();

    return response()->json([
       'status' =>'success',
       'message' => 'Scraping data fetched successfully',
        'data' => [
            'current_statistics' => $data,
            'career_statistics' => $careerData
        ]
    ], 200);
} catch (\Exception $e) {
    return response()->json([
        'status' => 'error',
        'message' => 'Failed to fetch scraping data',
        'error' => $e->getMessage()
    ], 500);
}
}

}
