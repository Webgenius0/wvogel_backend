<?php

namespace App\Services;

use GuzzleHttp\Client;
use DiDom\Document;

class WebScraperService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false, // Disable SSL verification if needed
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36'
            ]
        ]);
    }

     
    public function scrapeEntriesResults()
    {
        try {
            $url = "https://www.equibase.com/profiles/Results.cfm?type=People&searchType=T&eID=950082";

            // Send HTTP GET request
            $response = $this->client->get($url);
            $html = (string) $response->getBody(); // Convert response to string

            // Parse HTML
            $document = new Document($html);
// dd($document);
             // Extract 2025 Statistics
             $stats2025 = $document->first('#peopleProfileRightDiv table:nth-of-type(1) tbody tr');
             $careerStats = $document->first('#peopleProfileRightDiv table:nth-of-type(2) tbody tr');

             $data = [
                 '2025_statistics' => [
                     'starts' => $stats2025->first('td[data-label="Starts"]')->text(),
                     'firsts' => $stats2025->first('td[data-label="Firsts"]')->text(),
                     'seconds' => $stats2025->first('td[data-label="Seconds"]')->text(),
                     'thirds' => $stats2025->first('td[data-label="Thirds"]')->text(),
                     'earnings' => $stats2025->first('td[data-label="Tot. Earnings"]')->text(),
                 ],
                 'career_statistics' => [
                     'starts' => $careerStats->first('td[data-label="Starts"]')->text(),
                     'firsts' => $careerStats->first('td[data-label="Firsts"]')->text(),
                     'seconds' => $careerStats->first('td[data-label="Seconds"]')->text(),
                     'thirds' => $careerStats->first('td[data-label="Thirds"]')->text(),
                     'earnings' => $careerStats->first('td[data-label="Tot. Earnings"]')->text(),
                 ]
             ];

            return $data;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
