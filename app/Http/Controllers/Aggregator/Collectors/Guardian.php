<?php

namespace App\Http\Controllers\Aggregator\Collectors;

use App\Exceptions\CollectorException;
use App\Http\Controllers\Aggregator\CollectorInterface;
use App\Models\Collector;
use App\Traits\NewsTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Guardian implements CollectorInterface
{
    use NewsTrait;

    private const FETCH_URL = "https://content.guardianapis.com/search";
    private const ID = 3;

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
                    'api-key' => config('collector.GUARDIAN_SECRET_KEY'),
                    'q' => $category,
                    'from-date' => now()->subDay()->format('Y-m-d'),
                    'order-by' => 'relevance',
                    'show-fields' => 'thumbnail,body',
                    'page-size' => '30'
                ]
            );

            if ($response->successful()) {
                $newsData = $response->json()['response']['results'];

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
        if (isset($news['fields']['body']) && isset($news['fields']['thumbnail'])) {
            $source = $this->createSource("The Guardian");

            return [
                'url' => $news['webUrl'],
                'title' => $news['webTitle'],
                'source_id' => $source->id,
                'collector_id' => self::ID,
                'image_url' => $news['fields']['thumbnail'],
                'description' => $this->handleEncodedCharacters($news['fields']['body']),
                'published_at' =>  Carbon::parse($news['webPublicationDate'])->toDateTimeString(),
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
