@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Issues</h1>
            <p class="text-sm text-slate-500 mt-0.5">Browse and manage all issues</p>
        </div>

        <a href="{{ route('issues.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            New Issue
        </a>
    </div>

    <form action="{{ route('issues.index') }}" method="GET"
          class="flex flex-wrap items-center gap-3 mb-8 p-4 bg-white border border-slate-200 rounded-xl shadow-sm">
        <select name="status"
                class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            <option value="">All Statuses</option>
            <option value="open"        {{ request('status') == 'open'        ? 'selected' : '' }}>Open</option>
            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="closed"      {{ request('status') == 'closed'      ? 'selected' : '' }}>Closed</option>
        </select>

        <select name="priority"
                class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            <option value="">All Priorities</option>
            <option value="low"    {{ request('priority') == 'low'    ? 'selected' : '' }}>Low</option>
            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
            <option value="high"   {{ request('priority') == 'high'   ? 'selected' : '' }}>High</option>
        </select>

        <select name="tag"
                class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            <option value="">All Tags</option>
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>{{ $tag->name }}</option>
            @endforeach
        </select>

        <div class="flex items-center gap-2 ml-auto">
            <a href="{{ route('issues.index') }}"
               class="text-sm font-medium text-slate-500 hover:text-slate-700 px-3 py-2 transition-colors">
                Reset
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-1.5 bg-slate-900 hover:bg-black text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
                Filter
            </button>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($issues as $issue)
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all duration-200 p-6 flex flex-col">

            <a href="{{ route('issues.show', $issue) }}"
               class="text-base font-semibold text-slate-900 hover:text-blue-600 leading-snug transition-colors mb-2">
                {{ $issue->title }}
            </a>

            <p class="text-slate-500 text-sm leading-relaxed mb-6 flex-1">
                {{ Str::limit($issue->description, 120) }}
            </p>

            <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                <a href="{{ route('issues.edit', $issue) }}"
                   class="inline-flex items-center gap-1.5 text-sm text-yellow-600 hover:text-yellow-700 font-medium transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-1.414.586H9v-1.414a2 2 0 01.586-1.414z"/>
                    </svg>
                    Edit
                </a>

                <form action="{{ route('issues.destroy', $issue->id) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this issue?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 text-sm text-red-500 hover:text-red-600 font-medium transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0a1 1 0 00-1-1h-4a1 1 0 00-1 1H5"/>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
        @endforeach

        @if($issues->isEmpty())
        <div class="col-span-full flex flex-col items-center justify-center py-20 border border-dashed border-slate-200 rounded-xl text-center">
            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-900 mb-1">No issues found</p>
            <p class="text-xs text-slate-400 mb-4">Try adjusting your filters or create a new issue.</p>
            <a href="{{ route('issues.create') }}"
               class="text-blue-600 hover:text-blue-700 text-sm font-semibold transition-colors">
                Create your first issue →
            </a>
        </div>
        @endif
    </div>

</div>
@endsection