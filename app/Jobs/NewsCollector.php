<?php

namespace App\Jobs;

use App\Http\Controllers\Aggregator\CollectorFactory;
use App\Models\Category;
use App\Traits\NewsTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NewsCollector implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, NewsTrait;

    private $collector;

    /**
     * Create a new job instance.
     */
    public function __construct($collector)
    {
        $this->collector = $collector;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $collector = $this->collector;

        // Get the collector class instance
        $collectorClassInstance = CollectorFactory::create($collector);

        // Get categories
        $categories = Category::all();

        foreach ($categories as $category) {
            // TODO: Split each categories in seperate jobs and
            // queue with delays for previous categories
            
            // For each category, call the getNews and get the news
            $arrayOfNews = $collectorClassInstance->getNews($category->name);

            foreach ($arrayOfNews as $news) {
                // For each news,
                $readyNewsFeed = $collectorClassInstance->normalizeNews($news);

                // Check if all keys have values and are not null
                if (count(array_filter($readyNewsFeed)) === count($readyNewsFeed)) {
                    // Check if news exists before or store News
                    $feed = $this->storeFeed($readyNewsFeed);
                    $feed->categories()->attach($category);
                }
            }
        }
    }
}
