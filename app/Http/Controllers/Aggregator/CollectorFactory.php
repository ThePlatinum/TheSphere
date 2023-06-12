<?php

namespace App\Http\Controllers\Aggregator;

use App\Exceptions\CollectorException;
use App\Http\Controllers\Aggregator\CollectorInterface;
use App\Http\Controllers\Aggregator\Collectors\NewsApi;
use App\Http\Controllers\Aggregator\Collectors\NYNews;
use App\Models\Collector;

class CollectorFactory
{

    protected static $collectorClasses = [
        1 => NewsApi::class,
        2 => NYNews::class,
    ];

    /**
     * Get an instance of the collector class to use
     */
    public static function create(Collector $collector): CollectorInterface
    {
        if (isset(self::$collectorClasses[$collector->code])) {
            $collectorClass = self::$collectorClasses[$collector->code];

            return new $collectorClass();
        }

        throw new CollectorException('Unable to Initiate Collector', []);
    }
}
