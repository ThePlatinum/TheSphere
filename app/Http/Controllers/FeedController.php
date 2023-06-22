<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\User;
use App\Traits\PaginateTrait;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    use PaginateTrait;

    function userFeeds()
    {
        $user = Auth::user();

        $preferredCategories = $user->categories->pluck('id')->toArray();
        $preferredSources = $user->sources->pluck('id')->toArray();

        $feeds = Feed::with('source', 'categories')->whereHas('categories', function ($query) use ($preferredCategories) {
            $query->whereIn('category_id', $preferredCategories);
        })
            ->get()
            ->sortByDesc(function ($feed) use ($preferredSources) {
                return in_array($feed->source_id, $preferredSources) ? 1 : 0;
            })
            ->values()
            ->toArray();

        $feeds = collect($feeds);

        if ($feeds->isEmpty()) {
            $feeds = Feed::with('source', 'categories')->get();
        }

        return $feeds;
    }

    public  function useSearch($query)
    {
        $words = explode(' ', $query);
        $words = array_filter($words);

        $feeds = Feed::with('source', 'categories');

        foreach ($words as $word) {
            $feeds
                ->orWhere('title', 'like', '%' . $word . '%')
                ->orWhere('description', 'like', '%' . $word . '%');
        }

        return $feeds->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function all()
    {
        $perPage = 100;
        $page = request()->get('page', 1);

        // Is there a search query?
        $query = request()->get('query');

        if ($query) $feeds = $this->useSearch($query);

        else if (Auth::check()) $feeds = $this->userFeeds();

        else $feeds = Feed::with('source', 'categories')->get();

        // TODO: Use cache for improvement
        $paginatedFeeds = $this->paginate($feeds, $perPage, $page);

        return $paginatedFeeds;
    }

    /**
     * Get the most popular Feed
     */
    public function popular()
    {
        if (Auth::check()) $feeds = $this->userFeeds();

        else $feeds = Feed::with('source', 'categories')->get();

        $feedWithHighestViews = $feeds->sortByDesc('views')->first();

        return response()->json($feedWithHighestViews);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $feed = Feed::where('slug', $slug)->first();

        // Increase view count
        // TODO: only count for each user once per minute
        $feed->update([
            'views' => $feed->views + 1
        ]);

        return redirect()->away($feed->url);
    }
}
