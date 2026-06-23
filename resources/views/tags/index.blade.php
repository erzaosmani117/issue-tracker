@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Tags</h1>
            <p class="text-sm text-slate-500 mt-0.5">Manage tags used to categorize issues</p>
        </div>

        <a href="{{ route('tags.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            New Tag
        </a>
    </div>

    @if($tags->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 border border-dashed border-slate-200 rounded-xl text-center">
            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5a1.99 1.99 0 011.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-900 mb-1">No tags yet</p>
            <p class="text-xs text-slate-400 mb-4">Create tags to organize and filter your issues.</p>
            <a href="{{ route('tags.create') }}"
               class="text-blue-600 hover:text-blue-700 text-sm font-semibold transition-colors">
                Create your first tag →
            </a>
        </div>
    @else
        <div class="flex flex-wrap gap-3">
           @foreach($tags as $tag)
    <div class="inline-flex items-center gap-2 bg-white border border-slate-200 hover:border-slate-300 hover:shadow-sm rounded-full px-4 py-2 shadow-sm transition-all duration-200">
        <span class="w-2.5 h-2.5 rounded-full shrink-0 bg-slate-400"></span>

                    <span class="text-sm font-medium text-slate-700">{{ $tag->name }}</span>

                    <form action="{{ route('tags.destroy', $tag) }}" method="POST" onsubmit="return confirm('Delete tag?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-slate-300 hover:text-red-500 transition-colors ml-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection