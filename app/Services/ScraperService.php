<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ScraperService
{
    public function scrapeData($url)
    {
        // Initialize Guzzle client for ProxyCrawl API
        $client = new Client();

        // Build the ProxyCrawl API URL, which includes the target URL
        $proxyCrawlUrl = "https://proxycrawl-crawling.p.rapidapi.com/?url=" . urlencode($url);

        // dd($proxyCrawlUrl);

        try {
            // Make a GET request to ProxyCrawl API
            $response = $client->request('GET', $proxyCrawlUrl, [
                'headers' => [
                    'x-rapidapi-host' => 'proxycrawl-crawling.p.rapidapi.com',
                    'x-rapidapi-key' => '356575d26emsha427970e1d3e4efp1dfaf7jsncdc6fc01bbbf',  // Your API Key
                ],
            ]);



            // Get the raw HTML content from ProxyCrawl
            $htmlContent = (string) $response->getBody();


            // Initialize the Crawler to parse the HTML content
            $crawler = new Crawler($htmlContent);




            // Look for the div with id 'peopleProfileRightDiv' in the page content
            $profileDiv = $crawler->filter('#peopleProfileRightDiv');

            // Check if the div exists in the HTML
            if ($profileDiv->count() === 0) {
                return ['error' => 'Profile div not found'];
            }

            // Extract the tables inside the div
            $table1 = $profileDiv->filter('table.table-compressed')->eq(0); // First table
            $table2 = $profileDiv->filter('table.table-compressed')->eq(1); // Second table

            // Extract data from each table
            $table1Data = $this->extractTableData($table1);
            $table2Data = $this->extractTableData($table2);

            // Return the data as an array
            return [
                '2025_Statistics' => $table1Data,
                'Career_Statistics' => $table2Data
            ];

        } catch (\Exception $e) {
            // Handle any exceptions that might occur during the request
            return ['error' => 'Request failed: ' . $e->getMessage()];
        }
    }

    // Helper method to extract data from a table
    private function extractTableData(Crawler $table)
    {
        $tableData = [];
        $rows = $table->filter('tbody tr'); // Get all rows inside the table body

        // Iterate through each row and extract column data
        $rows->each(function (Crawler $row) use (&$tableData) {
            $columns = $row->filter('td'); // Get all columns in the row
            $rowData = [];

            // Extract text from each column and assign appropriate keys
            $columns->each(function (Crawler $column, $index) use (&$rowData) {
                $columnText = trim($column->text()); // Get clean text
                $rowData[$this->getColumnHeader($index)] = $columnText;
            });

            $tableData[] = $rowData;
        });

        return $tableData;
    }

    // Helper method to map column index to header
    private function getColumnHeader($index)
    {
        $headers = ['Starts', 'Firsts', 'Seconds', 'Thirds', 'Earnings'];
        return $headers[$index] ?? 'Unknown';
    }
}
