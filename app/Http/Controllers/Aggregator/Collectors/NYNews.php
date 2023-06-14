<?php

namespace App\Http\Controllers\Aggregator\Collectors;

use App\Exceptions\CollectorException;
use App\Http\Controllers\Aggregator\CollectorInterface;
use App\Models\Collector;
use App\Traits\NewsTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class NYNews implements CollectorInterface
{
    use NewsTrait;

    private const FETCH_URL = 'https://api.nytimes.com/svc/search/v2/articlesearch.json';
    private const ID = 2;
    private const IMAGE_HOST = "https://static01.nyt.com/";

    private $collectorInstance;

    public function __constructor()
    {
        $instance = Collector::find(self::ID);

        $this->collectorInstance = $instance;
    }

    /**
     * Get News into an Array
     */
    public function getNews(string $category): array
    {

        try {
            $response = Http::get(
                self::FETCH_URL,
                [
                    'api-key' => config('collector.NYNEWS_SECRET_KEY'),
                    'q' => $category,
                    'begin_date' => now()->subDay()->format('Ymd')
                ]
            );

            if ($response->successful()) {
                $newsData = $response->json()['response']['docs'];

                return $newsData;
            }
        } catch (\Throwable $th) {
            throw new CollectorException($th, []);
        }

        return [];
    }

    /**
     * Normalise News
     */
    public function normalizeNews($news): ?array
    {
        if ($news['type_of_material'] == "News" && isset($news['multimedia'][0])) {
            $source = $this->createSource($news['source']);

            return [
                'url' => $news['web_url'],
                'title' => $news['headline']['main'],
                'source_id' => $source->id,
                'collector_id' => self::ID,
                'image_url' => self::IMAGE_HOST . $news['multimedia'][0]['url'],
                'description' => $this->handleEncodedCharacters($news['lead_paragraph']),
                'published_at' =>  Carbon::parse($news['pub_date'])->toDateTimeString(),
            ];
        }

        return [];
    }

    /**
     * Notify End of operation
     */
    public function broadcastEnd()
    {
    }
}
