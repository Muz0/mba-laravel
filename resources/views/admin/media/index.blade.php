@extends('layouts.admin')

@section('title', 'Media')
@section('page-title', 'Media Library')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">All Media</h3>
            <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm" class="flex items-center">
                @csrf
                <input type="file" id="files" name="files[]" multiple accept="image/*,video/*" style="display: none;">
                <button type="button" onclick="document.getElementById('files').click()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-upload mr-2"></i>Upload Media
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 p-6">
        @forelse($media as $item)
            <div class="bg-gray-50 rounded-lg overflow-hidden">
                <div class="aspect-square bg-gray-100 flex items-center justify-center">
                    @if($item->type === 'image')
                        <img src="{{ asset('uploads/' . $item->filename) }}" alt="{{ $item->filename }}" class="w-full h-full object-cover">
                    @else
                        <div class="text-center">
                            <i class="fas fa-video text-gray-400 text-2xl mb-2"></i>
                            <p class="text-xs text-gray-500">Video</p>
                        </div>
                    @endif
                </div>
                <div class="p-3">
                    <p class="text-xs text-gray-900 font-medium truncate">{{ $item->filename }}</p>
                    <p class="text-xs text-gray-500">{{ $item->uploaded_at->format('M d, Y') }}</p>
                    @if($item->post)
                        <p class="text-xs text-blue-600">{{ $item->post->title }}</p>
                    @endif
                    <div class="flex items-center justify-between mt-2">
                        <a href="{{ asset('uploads/' . $item->filename) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-xs">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        <form action="{{ route('admin.media.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-xs">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-images text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-500">No media files found.</p>
                <p class="text-sm text-gray-400">Upload some images or videos to get started.</p>
            </div>
        @endforelse
    </div>

    @if($media->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $media->links() }}
        </div>
    @endif
</div>

<script>
document.getElementById('files').addEventListener('change', function() {
    if (this.files.length > 0) {
        document.getElementById('uploadForm').submit();
    }
});
</script>
@endsection