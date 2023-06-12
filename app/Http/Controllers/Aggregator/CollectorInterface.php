<?php

namespace App\Http\Controllers\Aggregator;

interface CollectorInterface
{
    /**
     * Get News into an Array
     */
    public function getNews(string $category): array;

    /**
     * Normalise News
     */
    public function normalizeNews($news): array;

    /**
     * Notify End of operation
     */
    public function broadcastEnd();
}
