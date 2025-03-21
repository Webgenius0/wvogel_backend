<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ScraperService;
use Illuminate\Http\Request;

class ApiEquibaseTrainerProfileDataController extends Controller
{
    protected $scraperService;

    public function __construct(ScraperService $scraperService)
    {
        $this->scraperService = $scraperService;
    }

    public function scrape()
    {
        // The URL to scrape
        $url = "https://www.equibase.com/profiles/Results.cfm?type=People&searchType=T&eID=950082";

        // Call the scraper service
        $scrapedData = $this->scraperService->scrapeData($url);

        // Debug: Dump the scraped data
        dd($scrapedData);

        // Return the scraped data as JSON
        return response()->json($scrapedData);
    }
}
