@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-6 py-10">

    <div class="mb-8">
        <a href="{{ route('tags.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700 font-medium mb-4 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Tags
        </a>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Create Tag</h1>
        <p class="text-sm text-slate-500 mt-0.5">Add a new tag to categorize issues</p>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
        <form action="{{ route('tags.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tag Name</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="e.g. Bug, Feature, Urgent"
                    class="w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                >
                @error('name')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Color</label>
                <div class="flex items-center gap-3">
                    <input
                        type="color"
                        name="color"
                        value="{{ old('color', '#3b82f6') }}"
                        class="w-10 h-10 rounded-lg border border-slate-200 cursor-pointer p-0.5"
                    >
                    <p class="text-xs text-slate-400">Pick a color to identify this tag</p>
                </div>
                @error('color')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                <a href="{{ route('tags.index') }}"
                   class="text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Tag
                </button>
            </div>

        </form>
    </div>

</div>
@endsection