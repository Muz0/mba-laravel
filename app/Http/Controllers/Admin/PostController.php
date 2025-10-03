<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('author', 'media')->latest()->paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(PostRequest $request)
    {
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'author_id' => auth()->id(),
            'cover_image' => $this->handleCoverImageUpload($request),
        ]);

        $this->handleMediaUploads($request, $post);

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        $post->load('author', 'media');
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $coverImage = $post->cover_image;
        
        if ($request->hasFile('cover_image')) {
            if ($coverImage) {
                Storage::delete('public/uploads/' . $coverImage);
            }
            $coverImage = $this->handleCoverImageUpload($request);
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'cover_image' => $coverImage,
        ]);

        $this->handleMediaUploads($request, $post);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        if ($post->cover_image) {
            Storage::delete('public/uploads/' . $post->cover_image);
        }

        foreach ($post->media as $media) {
            Storage::delete('public/uploads/' . $media->filename);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully!');
    }

    private function handleCoverImageUpload(Request $request)
    {
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_cover_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            return $filename;
        }
        return null;
    }

    private function handleMediaUploads(Request $request, Post $post)
    {
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename);
                
                $type = str_starts_with($file->getMimeType(), 'image/') ? 'image' : 'video';
                
                Media::create([
                    'filename' => $filename,
                    'filepath' => 'uploads/' . $filename,
                    'type' => $type,
                    'uploaded_at' => now(),
                    'post_id' => $post->id,
                ]);
            }
        }
    }
}