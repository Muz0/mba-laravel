<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::with('post')->latest()->paginate(20);
        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpg,jpeg,png,gif,webp,mp4,webm|max:20480',
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename);
                
                $type = str_starts_with($file->getMimeType(), 'image/') ? 'image' : 'video';
                
                Media::create([
                    'filename' => $filename,
                    'filepath' => 'uploads/' . $filename,
                    'type' => $type,
                    'uploaded_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.media.index')->with('success', 'Media uploaded successfully!');
    }

    public function destroy(Media $media)
    {
        Storage::delete('public/uploads/' . $media->filename);
        $media->delete();

        return redirect()->route('admin.media.index')->with('success', 'Media deleted successfully!');
    }
}