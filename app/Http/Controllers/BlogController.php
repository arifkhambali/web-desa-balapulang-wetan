<?php

namespace App\Http\Controllers;

use Firefly\FilamentBlog\Models\Post;
use Firefly\FilamentBlog\Models\Category;
use App\Models\Galeri;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::where('status', 'published')
            ->where('published_at', '<=', now())
            ->with(['categories', 'user'])
            ->orderBy('published_at', 'desc');

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $posts = $query->paginate(9);
        $categories = Category::withCount('posts')->get();

        // Get Gallery items for "Kabar Desa"
        $galleries = Galeri::latest()->limit(8)->get();

        return view('blog', compact('posts', 'categories', 'galleries'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->with(['categories', 'user'])
            ->firstOrFail();

        // Get related posts (same category)
        $relatedPosts = Post::where('status', 'published')
            ->where('published_at', '<=', now())
            ->where('id', '!=', $post->id)
            ->whereHas('categories', function ($q) use ($post) {
                $q->whereIn('fblog_categories.id', $post->categories->pluck('id'));
            })
            ->with(['categories', 'user'])
            ->limit(3)
            ->get();

        return view('blog-detail', compact('post', 'relatedPosts'));
    }
}
