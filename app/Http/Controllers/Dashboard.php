<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobCategory;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Dashboard extends Controller
{
    public function users()
    {
        $user = User::where('role','user')->get();
        return inertia('Admin/Users',[
            'users' => $user
        ]);
    }

    public function showNews()
    {
        $news = News::latest()->take(5)->get();
        $users = User::where('role', 'user')->get();
        $categories = JobCategory::all();
        $jobs = Job::all();

        return inertia('Admin/Dashboard', [
            'news' => $news,
            'users' => $users,
            'categories' => $categories,
            'jobs' => $jobs
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'news_title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'publish_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Correct field name for image validation
            'tags' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        // Retrieve the news item
        $news = News::findOrFail($id);

        // Check if a new image is uploaded and store it
        if ($request->hasFile('image')) {
            // Delete the old image if a new one is uploaded
            if ($news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            }
            $imagePath = $request->file('image')->store('images/news', 'public');
        } else {
            $imagePath = $news->image_path; // Keep the existing image path if no new image is uploaded
        }

        // Update the news item with validated data
        $news->update([
            'news_title' => $validated['news_title'],
            'category_id' => $validated['category_id'],
            'publish_date' => $validated['publish_date'],
            'image_path' => $imagePath,
            'tags' => $validated['tags'],
            'content' => $validated['content']
        ]);

        // Redirect back with a success message
        return back()->with('success', 'News successfully updated.');
    }

    public function delete($id)
{
    // Find the news item
    $news = News::findOrFail($id);

    // Check if the news has an associated image
    if ($news->image_path) {
        // Delete the image from storage
        Storage::disk('public')->delete($news->image_path);
    }

    // Delete the news item from the database
    $news->delete();

    // Return success response
    return back();
}

}
