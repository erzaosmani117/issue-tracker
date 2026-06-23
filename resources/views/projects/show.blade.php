@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">

    
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ $project->name }}</h1>
        <div class="flex gap-3">
            <a href="{{ route('projects.edit', $project) }}" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium">Edit</a>
            <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">Delete</button>
            </form>
        </div>
    </div>

    <p class="text-gray-600 mb-8">{{ $project->description }}</p>

  
    <h2 class="text-xl font-semibold mb-4">Issues</h2>
    @forelse($project->issues as $issue)
        <div class="bg-white border border-gray-100 rounded-lg p-4 mb-3 shadow-sm">
            <a href="{{ route('issues.show', $issue) }}" class="font-medium text-blue-600 hover:underline">{{ $issue->title }}</a>
            <p class="text-sm text-gray-500 mt-1">Status: {{ $issue->status }} · Priority: {{ $issue->priority }}</p>
        </div>
    @empty
        <p class="text-gray-400">No issues yet.</p>
    @endforelse

    <div class="mt-6">
        <a href="{{ route('projects.index') }}" class="text-gray-500 hover:text-gray-700 text-sm">← Back to Projects</a>
    </div>
</div>
@endsection