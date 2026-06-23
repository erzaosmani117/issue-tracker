@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tags</h1>
        <a href="{{ route('tags.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">+ Add Tag</a>
    </div>

    <div class="flex flex-wrap gap-3">
        @forelse($tags as $tag)
            <div class="flex items-center gap-2 bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm">
                @if($tag->color)
                    <span class="w-3 h-3 rounded-full"  {{ $tag->color }}"></span>
                @endif
                <span class="text-sm font-medium text-gray-700">{{ $tag->name }}</span>
                <form action="{{ route('tags.destroy', $tag) }}" method="POST" onsubmit="return confirm('Delete tag?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-400 hover:text-red-600 text-xs ml-1">✕</button>
                </form>
            </div>
        @empty
            <p class="text-gray-400">No tags yet.</p>
        @endforelse
    </div>
</div>
@endsection