<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function allCategories()
    {
        return response()->json(Category::all());
    }

    /**
     * Show users categories preferences
     */
    public function userCategories()
    {
        $user = Auth::user();

        if ($user) {
            $userCategories = $user->categories;

            if ($userCategories->isEmpty()) {
                return $this->allCategories();
            }

            return response()->json($userCategories);
        }

        return $this->allCategories();
    }

    /**
     * Store users categories preference
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $user->categories()->sync($request->categories);

        return response()->json(true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
