@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
                <i class="fas fa-file-alt text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Total Posts</h3>
                <p class="text-2xl font-bold text-blue-600">{{ $totalPosts }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
                <i class="fas fa-images text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Total Media</h3>
                <p class="text-2xl font-bold text-green-600">{{ $totalMedia }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-purple-100 rounded-lg">
                <i class="fas fa-user text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Welcome</h3>
                <p class="text-lg font-bold text-purple-600">{{ auth()->user()->username }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Recent Posts</h3>
                <a href="{{ route('admin.posts.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-plus mr-2"></i>New Post
                </a>
            </div>
        </div>
        <div class="p-6">
            @forelse($posts->take(5) as $post)
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                    <div>
                        <h4 class="font-medium text-gray-900">{{ $post->title }}</h4>
                        <p class="text-sm text-gray-500">{{ $post->created_at->format('M d, Y') }}</p>
                    </div>
                    <a href="{{ route('admin.posts.edit', $post) }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">No posts found.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Recent Media</h3>
                <a href="{{ route('admin.media.index') }}" class="text-blue-600 hover:text-blue-800">View All</a>
            </div>
        </div>
        <div class="p-6">
            @forelse($media as $item)
                <div class="flex items-center py-3 border-b border-gray-100 last:border-b-0">
                    <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center mr-4">
                        @if($item->type === 'image')
                            <i class="fas fa-image text-gray-500"></i>
                        @else
                            <i class="fas fa-video text-gray-500"></i>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-900 text-sm">{{ $item->filename }}</h4>
                        <p class="text-xs text-gray-500">{{ $item->uploaded_at->format('M d, Y') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">No media found.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection