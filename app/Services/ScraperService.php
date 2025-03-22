<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ScraperService
{
    public function scrapeData($url)
    {
        // Initialize the Guzzle client
        $client = new Client();

        // Set the headers to simulate a real browser
        $headers = [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Connection' => 'keep-alive',
            'Upgrade-Insecure-Requests' => '1',
        ];

        // Send a GET request to the page with headers
        $response = $client->get($url, [
            'headers' => $headers,
        ]);

        // Get the raw HTML content of the page
        $htmlContent = (string) $response->getBody();

        dd($htmlContent);


        // Initialize the Crawler to parse the HTML content
        $crawler = new Crawler($htmlContent);


        // Look for the div with id 'peopleProfileRightDiv'
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
