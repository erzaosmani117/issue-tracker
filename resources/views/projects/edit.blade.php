@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-6 py-10">

    <div class="mb-8">
        <a href="{{ route('projects.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700 font-medium mb-4 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Projects
        </a>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Edit Project</h1>
        <p class="text-sm text-slate-500 mt-0.5">Update the details for this project</p>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 rounded-xl border border-red-200 bg-red-50 text-red-700 text-sm">
        <ul class="space-y-1">
            @foreach($errors->all() as $error)
                <li class="flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/>
                    </svg>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
        <form action="{{ route('projects.update', $project) }}" method="POST" class="space-y-5">
            @method('PUT')
            @csrf

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Project name
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $project->name) }}"
                    placeholder="e.g. HR System"
                    class="w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                />
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Description
                </label>
                <textarea
                    name="description"
                    rows="4"
                    placeholder="Short description..."
                    class="w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-none"
                >{{ old('description', $project->description) }}</textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                <a href="{{ route('projects.index') }}"
                   class="text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Project
                </button>
            </div>
        </form>
    </div>

</div>
@endsection