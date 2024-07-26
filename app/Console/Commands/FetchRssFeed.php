<?php
//php artisan fetch:rssfeed
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\RssFeed;
use App\Models\RssFeedEndpoint;
use Carbon\Carbon;

class FetchRssFeed extends Command
{
    protected $signature = 'fetch:rssfeed';
    protected $description = 'Fetch and store RSS feed data from all configured endpoints';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get all RSS feed endpoints
        $endpoints = RssFeedEndpoint::all();

        foreach ($endpoints as $endpoint) {
            $url = $this->buildUrl($endpoint);

            // Fetch the RSS feed
            $response = Http::get($url);

            $statusCode = $response->status(); // Get the HTTP status code

            if ($response->successful()) {
                $rssFeed = simplexml_load_string($response->body());

                if ($rssFeed === false) {
                    $this->error("Failed to parse the RSS feed from URL: $url");
                    $this->updateEndpoint($endpoint, $statusCode);
                    continue;
                }

                $this->storeRssFeed($rssFeed, $endpoint);
                $this->info("RSS feed fetched and stored successfully from URL: $url");
                $this->updateEndpoint($endpoint, $statusCode);
            } else {
                $this->error("Failed to fetch the RSS feed from URL: $url. Status code: $statusCode");
                $this->updateEndpoint($endpoint, $statusCode);
            }
        }
    }

    protected function buildUrl($endpoint)
    {
        return rtrim($endpoint->publication_url, '/') . '/' . ltrim($endpoint->endpoint, '/'); // Ensure no double slashes
    }

    protected function storeRssFeed($rssFeed, $endpoint)
    {
        foreach ($rssFeed->channel->item as $item) {
            RssFeed::updateOrCreate(
                ['link' => (string)$item->link], // Use 'link' as the unique identifier
                [
                    'rss_feed_endpoint_id' => $endpoint->rss_feed_endpoint_id,
                    'title' => (string)$item->title,
                    'link' => (string)$item->link,
                    'description' => (string)$item->description,
                    'category' => json_encode((array)$item->category),
                    'guid' => (string)$item->guid,
                    'pub_date' => date('Y-m-d H:i:s', strtotime((string)$item->pubDate)),
                    'is_processed' => false,
                ]
            );
        }
    }

    protected function updateEndpoint($endpoint, $statusCode)
    {
        $endpoint->last_fetched = Carbon::now();
        $endpoint->last_fetched_status = $statusCode; // Store the HTTP status code
        $endpoint->save();
    }
}
