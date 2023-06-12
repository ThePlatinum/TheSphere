<?php

namespace App\Traits;

use App\Models\Feed;
use App\Models\Source;

trait NewsTrait
{
    function createSource($source_name): Source
    {
        return Source::updateOrCreate([
            'name' => $source_name
        ]);
    }

    function storeFeed(array $feed): Feed {
        $attributes = [
            'url' => $feed['url'],
            'title' => $feed['title']
        ];

        return Feed::updateOrCreate($attributes, $feed);
    }
}
