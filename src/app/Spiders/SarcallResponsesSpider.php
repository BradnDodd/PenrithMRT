<?php

namespace App\Spiders;

use Generator;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;
use Symfony\Component\DomCrawler\Crawler;

class SarcallResponsesSpider extends BasicSpider
{
    public array $startUrls;

    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
    ];

    public array $spiderMiddleware = [
        //
    ];

    public array $itemProcessors = [
        //
    ];

    public array $extensions = [
        LoggerExtension::class,
        StatsCollectorExtension::class,
    ];

    public int $concurrency = 2;

    public int $requestDelay = 1;

    public function __construct()
    {
        $this->startUrls = [
            env('SARCALL_RESPONSE_URL'),
        ];
        parent::__construct();
    }
    /**
     * @return Generator<ParseResult>
     */
    public function parse(Response $response): Generator
    {
        $table = $response->filter('table')->eq(2);
        $keys = [];
        $data = [];
        // Get the table headings
        $table->filter('tr > th > font')->each(function (Crawler $th, $i) use (&$keys) {
            $keys[] = $th->text();
        });

        $table->filter('tr')->slice(1)->each(function (Crawler $row) use (&$data, $keys) {
            $rowData = [];
            // Get the row data
            $row->filter('td > b > font')->each(function (Crawler $cell, $i) use (&$rowData, $keys) {
                $rowData[$keys[$i]] = $cell->text();
            });

            // Try work out the SAR A,L,N from the background colour
            $availability = $row->filter('td')->eq(0)->attr('bgcolor');
            switch ($availability) {
                case 'limegreen':
                    $rowData['Availability'] = 'A';
                break;
                case 'yellow':
                    $rowData['Availability'] = 'L';
                break;
                case 'red':
                    $rowData['Availability'] = 'N';
                break;
                default:
                    $rowData['Availability'] = 'None';
            }

            $data[] = $rowData;
        });

        yield $this->item($data);
    }
}
