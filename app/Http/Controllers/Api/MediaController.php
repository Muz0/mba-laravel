<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Media;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::with('post')->latest()->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $media->items()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'filename' => $item->filename,
                    'type' => $item->type,
                    'url' => $item->file_url,
                    'uploaded_at' => $item->uploaded_at,
                    'post' => $item->post ? [
                        'id' => $item->post->id,
                        'title' => $item->post->title,
                        'slug' => $item->post->slug,
                    ] : null
                ];
            }),
            'pagination' => [
                'current_page' => $media->currentPage(),
                'last_page' => $media->lastPage(),
                'per_page' => $media->perPage(),
                'total' => $media->total(),
            ]
        ]);
    }
}