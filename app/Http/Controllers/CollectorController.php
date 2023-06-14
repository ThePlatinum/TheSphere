<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Aggregator\CollectorFactory;
use App\Jobs\ProcessNewsCollectors;
use App\Models\Category;
use App\Models\Collector;
use App\Traits\NewsTrait;
use Illuminate\Http\Request;

class CollectorController extends Controller
{
    use NewsTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ProcessNewsCollectors::dispatch();

        return "Good, Fetching news... Pleas, start the queue work if you have not";
    }

    /**
     * Display the specified resource.
     */
    public function show(Collector $collector)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Collector $collector)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Collector $collector)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collector $collector)
    {
        //
    }
}
