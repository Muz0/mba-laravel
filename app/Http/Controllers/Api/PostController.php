<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['author', 'media'])
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $posts->items(),
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
            ]
        ]);
    }

    public function show(Post $post)
    {
        $post->load(['author', 'media']);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'content' => $post->content,
                'cover_image' => $post->cover_image_url,
                'author' => $post->author->username,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
                'media' => $post->media->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'filename' => $media->filename,
                        'type' => $media->type,
                        'url' => $media->file_url,
                        'uploaded_at' => $media->uploaded_at,
                    ];
                })
            ]
        ]);
    }
}