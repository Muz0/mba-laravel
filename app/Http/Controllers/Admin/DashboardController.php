<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Media;

class DashboardController extends Controller
{
    public function index()
    {
        $posts = Post::with('author', 'media')->latest()->paginate(10);
        $media = Media::latest()->take(5)->get();
        $totalPosts = Post::count();
        $totalMedia = Media::count();

        return view('admin.dashboard', compact('posts', 'media', 'totalPosts', 'totalMedia'));
    }
}