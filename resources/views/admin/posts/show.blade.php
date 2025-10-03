@extends('layouts.admin')

@section('title', $post->title)
@section('page-title', $post->title)

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex space-x-3">
                <a href="{{ route('admin.posts.edit', $post) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-200">
                        <i class="fas fa-trash mr-2"></i>Delete
                    </button>
                </form>
            </div>
            <a href="{{ route('admin.posts.index') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left mr-2"></i>Back to Posts
            </a>
        </div>

        @if($post->cover_image)
            <div class="mb-6">
                <img src="{{ asset('uploads/' . $post->cover_image) }}" alt="Cover Image" class="w-full h-64 object-cover rounded-lg">
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="prose max-w-none">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>

            <div>
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-3">Post Details</h3>
                    <div class="space-y-2 text-sm">
                        <div>
                            <span class="text-gray-600">Author:</span>
                            <span class="font-medium">{{ $post->author->username }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Slug:</span>
                            <span class="font-medium">{{ $post->slug }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Created:</span>
                            <span class="font-medium">{{ $post->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Updated:</span>
                            <span class="font-medium">{{ $post->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                @if($post->media->count() > 0)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 mb-3">Media Files ({{ $post->media->count() }})</h3>
                        <div class="space-y-2">
                            @foreach($post->media as $media)
                                <div class="flex items-center justify-between bg-white p-2 rounded">
                                    <div class="flex items-center">
                                        @if($media->type === 'image')
                                            <i class="fas fa-image text-blue-500 mr-2"></i>
                                        @else
                                            <i class="fas fa-video text-green-500 mr-2"></i>
                                        @endif
                                        <span class="text-xs text-gray-700">{{ $media->filename }}</span>
                                    </div>
                                    <a href="{{ asset('uploads/' . $media->filename) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-external-link-alt text-xs"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection