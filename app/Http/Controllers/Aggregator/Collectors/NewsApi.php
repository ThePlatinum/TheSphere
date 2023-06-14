<?php

namespace App\Http\Controllers\Aggregator\Collectors;

use App\Exceptions\CollectorException;
use App\Http\Controllers\Aggregator\CollectorInterface;
use App\Models\Collector;
use App\Traits\NewsTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class NewsApi implements CollectorInterface
{
    use NewsTrait;

    private const FETCH_URL = 'https://newsapi.org/v2/everything';
    private const ID = 1;

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
            $response = Http::withToken(config('collector.NEWSAPI_SECRET_KEY'), 'Bearer')
                ->get(
                    self::FETCH_URL,
                    [
                        'q' => $category,
                        'from' => now()->addDay(-1),
                        // 'to' =>
                        // TODO: Monitor last_fetch
                    ]
                );
            if ($response->successful()) {
                $newsData = $response->json()['articles'];

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
        $source = $this->createSource($news['source']['name']);

        return [
            'url' => $news['url'],
            'title' => $news['title'],
            'source_id' => $source->id,
            'collector_id' => self::ID,
            'image_url' => $news['urlToImage'],
            'description' => substr(strip_tags($news['description']), 0, 250),
            'published_at' =>  Carbon::parse($news['publishedAt'])->toDateTimeString(),
            // 'collector_identifier' => $news['id'] ?? null
        ];
    }

    /**
     * Notify End of operation
     */
    public function broadcastEnd()
    {
    }
}
