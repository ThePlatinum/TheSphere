<?php

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function allSources()
    {
        return response()->json(Source::all());
    }

    /**
     * Show users Sources preferences
     */
    public function userSources()
    {
        $user = Auth::user();

        if ($user) {
            $userSources = $user->sources;

            if ($userSources->isEmpty()) {
                return $this->allSources();
            }

            return response()->json($userSources);
        }

        return $this->allSources();
    }

    /**
     * Store users Sources preference
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $user->sources()->sync($request->sources);

        return response()->json(true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Source $source)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Source $source)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Source $source)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Source $source)
    {
        //
    }
}
