<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\JobCategory;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::all();
        return inertia('News',[
            'news' => $news
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = JobCategory::all();
        return inertia('Admin/PostNews',['categories' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'news_title' => 'required|string|max:255',
            'category' => 'nullable|string|max:225',
            'publish_date' => 'required|date',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('images/news', 'public')
            : null;

        News::create([
            'news_title' => $validated['news_title'],
            'category' => $validated['category'],
            'publish_date' => $validated['publish_date'],
            'image_path' => $imagePath,
            'tags' => $validated['tags'],
            'content' => $validated['content']
        ]);

        return back()->with('success', 'Successfully posted news.');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        //
    }
}
