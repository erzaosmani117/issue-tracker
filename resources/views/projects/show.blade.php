@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">

   
    <div class="flex items-start justify-between mb-8">
        <div>
            <a href="{{ route('projects.index') }}"
               class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700 font-medium mb-3 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Projects
            </a>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $project->name }}</h1>
            <p class="mt-1.5 text-slate-500 text-sm max-w-2xl leading-relaxed">{{ $project->description }}</p>
        </div>

        <div class="flex items-center gap-3 mt-1 shrink-0">
            <a href="{{ route('projects.edit', $project) }}"
               class="inline-flex items-center gap-1.5 text-sm text-yellow-600 hover:text-yellow-700 font-medium transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-1.414.586H9v-1.414a2 2 0 01.586-1.414z"/>
                </svg>
                Edit
            </a>

            <form action="{{ route('projects.destroy', $project) }}"
                  method="POST"
                  onsubmit="return confirm('Delete this project?')">
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

    
    <div class="grid grid-cols-3 gap-4 mb-10">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-2">Total Issues</p>
            <p class="text-3xl font-bold text-slate-900">{{ $project->issues->count() }}</p>
        </div>

        <div class="bg-white rounded-xl border border-blue-100 shadow-sm p-5">
            <p class="text-xs font-semibold uppercase tracking-wide text-blue-400 mb-2">Open</p>
            <p class="text-3xl font-bold text-blue-600">{{ $project->issues->where('status', 'open')->count() }}</p>
        </div>

        <div class="bg-white rounded-xl border border-green-100 shadow-sm p-5">
            <p class="text-xs font-semibold uppercase tracking-wide text-green-500 mb-2">Closed</p>
            <p class="text-3xl font-bold text-green-600">{{ $project->issues->where('status', 'closed')->count() }}</p>
        </div>
    </div>

   
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-base font-semibold text-slate-900">Issues</h2>

        <a href="{{ route('issues.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            New Issue
        </a>
    </div>

    
    <div class="space-y-3">
        @forelse($project->issues as $issue)
        <div class="bg-white rounded-xl border border-slate-200 hover:border-blue-300 hover:shadow-sm transition-all duration-200 p-5">
            <div class="flex items-center justify-between gap-4">

                <div class="min-w-0">
                    <a href="{{ route('issues.show', $issue) }}"
                       class="font-semibold text-slate-900 hover:text-blue-600 transition-colors">
                        {{ $issue->title }}
                    </a>

                    <div class="flex items-center gap-1.5 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-xs text-slate-400">
                            {{ $issue->due_date ? \Carbon\Carbon::parse($issue->due_date)->format('d M Y') : 'No deadline' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    
                    @php
                        $priorityClass = match($issue->priority) {
                            'high'   => 'bg-red-50 text-red-600 border-red-200',
                            'medium' => 'bg-yellow-50 text-yellow-600 border-yellow-200',
                            'low'    => 'bg-green-50 text-green-600 border-green-200',
                            default  => 'bg-slate-100 text-slate-500 border-slate-200',
                        };
                    @endphp
                    <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full border {{ $priorityClass }}">
                        {{ strtoupper($issue->priority) }}
                    </span>

                    @php
                        $statusClass = match($issue->status) {
                            'open'        => 'bg-blue-50 text-blue-600 border-blue-200',
                            'closed'      => 'bg-green-50 text-green-600 border-green-200',
                            'in_progress' => 'bg-yellow-50 text-yellow-600 border-yellow-200',
                            default       => 'bg-slate-100 text-slate-500 border-slate-200',
                        };
                    @endphp
                    <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full border {{ $statusClass }}">
                        {{ strtoupper(str_replace('_', ' ', $issue->status)) }}
                    </span>
                </div>

            </div>
        </div>

        @empty
        <div class="flex flex-col items-center justify-center py-16 border border-dashed border-slate-200 rounded-xl text-center">
            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-900 mb-1">No issues yet</p>
            <p class="text-xs text-slate-400">Create your first issue for this project.</p>
        </div>
        @endforelse
    </div>

</div>
@endsection