@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Projects</h1>
            <p class="text-sm text-slate-500 mt-0.5">Manage and track all your projects</p>
        </div>

        <a href="{{ route('projects.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            New Project
        </a>
    </div>

    {{-- Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($projects as $project)
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 hover:border-blue-300 hover:shadow-md transition-all duration-200 p-6 flex flex-col">

            {{-- Title + badge --}}
            <div class="flex items-start justify-between gap-3 mb-2">
                <a href="{{ route('projects.show', $project) }}"
                   class="text-base font-semibold text-slate-900 hover:text-blue-600 leading-snug transition-colors">
                    {{ $project->name }}
                </a>

                @if(isset($project->issues_count))
                <span class="shrink-0 inline-flex items-center text-xs font-medium bg-slate-100 text-slate-600 rounded-full px-2.5 py-0.5">
                    {{ $project->issues_count }} {{ Str::plural('issue', $project->issues_count) }}
                </span>
                @endif
            </div>

            {{-- Description --}}
            <p class="text-slate-500 text-sm leading-relaxed mb-6 flex-1">
                {{ Str::limit($project->description, 120) }}
            </p>

            {{-- Footer --}}
            <div class="flex items-center justify-between pt-4 border-t border-slate-100">

                <a href="{{ route('projects.edit', $project) }}"
                   class="inline-flex items-center gap-1.5 text-sm text-yellow-600 hover:text-yellow-700 font-medium transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-1.414.586H9v-1.414a2 2 0 01.586-1.414z"/>
                    </svg>
                    Edit
                </a>

                <form action="{{ route('projects.destroy', $project->id) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this project?')">
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

        {{-- Empty state --}}
        @if($projects->isEmpty())
        <div class="col-span-full flex flex-col items-center justify-center py-20 border border-dashed border-slate-200 rounded-xl text-center">
            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"/>
                </svg>
            </div>
            <p class="text-slate-900 text-sm font-semibold mb-1">No projects yet</p>
            <p class="text-slate-500 text-sm mb-4">Get started by creating your first project.</p>
            <a href="{{ route('projects.create') }}"
               class="text-blue-600 hover:text-blue-700 text-sm font-semibold transition-colors">
                Create your first project →
            </a>
        </div>
        @endif

    </div>
</div>
@endsection