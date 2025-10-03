@extends('layouts.admin')

@section('title', 'Edit Post')
@section('page-title', 'Edit Post: ' . $post->title)

@section('content')
<div class="bg-white rounded-lg shadow">
    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                    <textarea id="content" name="content" rows="12" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <div class="mb-6">
                    <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">Cover Image</label>
                    @if($post->cover_image)
                        <div class="mb-3">
                            <img src="{{ asset('uploads/' . $post->cover_image) }}" alt="Current cover" class="w-full h-32 object-cover rounded">
                            <p class="text-xs text-gray-500 mt-1">Current cover image</p>
                        </div>
                    @endif
                    <input type="file" id="cover_image" name="cover_image" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('cover_image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Upload new image to replace current one</p>
                </div>

                <div class="mb-6">
                    <label for="media" class="block text-sm font-medium text-gray-700 mb-2">Additional Media</label>
                    <input type="file" id="media" name="media[]" multiple accept="image/*,video/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('media.*')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Add more media files to this post</p>
                </div>

                @if($post->media->count() > 0)
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Current Media</h4>
                        <div class="space-y-2">
                            @foreach($post->media as $media)
                                <div class="flex items-center justify-between bg-gray-50 p-2 rounded">
                                    <div class="flex items-center">
                                        @if($media->type === 'image')
                                            <i class="fas fa-image text-gray-500 mr-2"></i>
                                        @else
                                            <i class="fas fa-video text-gray-500 mr-2"></i>
                                        @endif
                                        <span class="text-xs text-gray-700">{{ $media->filename }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <a href="{{ route('admin.posts.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition duration-200">
                Cancel
            </a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition duration-200">
                Update Post
            </button>
        </div>
    </form>
</div>
@endsection