<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->has('nochildren') && request()->has('noparent'))
        {
            return Category::all();
        }
        else if(request()->has('nochildren'))
        {
            return Category::with('parent')->get();
        }
        else if(request()->has('noparent'))
        {
            return Category::with('children')->get();
        }
        else
        {
            return Category::with('parent', 'children')->get();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = Category::create($request->all());
        $category->metadata()->create($request['metadata']);
        return $category;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
        if($category->metadata)
        {
            $category->metadata()->save($request['metadata']);
        }
        else
        {
            $category->metadata()->create($request['metadata']);
        }

        return $category->fresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response(['OK'], 200);
    }
}
