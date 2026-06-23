@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">

    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                {{ $project->name }}
            </h1>

            <p class="mt-3 text-gray-600 max-w-3xl">
                {{ $project->description }}
            </p>
        </div>

        <div class="flex gap-4">
            <a href="{{ route('projects.edit', $project) }}"
               class="font-semibold text-gray-700 hover:text-black">
                Edit
            </a>

            <form action="{{ route('projects.destroy', $project) }}"
                  method="POST"
                  onsubmit="return confirm('Delete this project?')">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="font-semibold text-red-600 hover:text-red-700">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 mb-10">

        <div class="border rounded-xl p-5">
            <p class="text-sm text-gray-500">Total Issues</p>
            <p class="text-3xl font-bold mt-2">
                {{ $project->issues->count() }}
            </p>
        </div>

        <div class="border rounded-xl p-5">
            <p class="text-sm text-gray-500">Open</p>
            <p class="text-3xl font-bold mt-2">
                {{ $project->issues->where('status', 'open')->count() }}
            </p>
        </div>

        <div class="border rounded-xl p-5">
            <p class="text-sm text-gray-500">Closed</p>
            <p class="text-3xl font-bold mt-2">
                {{ $project->issues->where('status', 'closed')->count() }}
            </p>
        </div>

    </div>

    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-bold text-gray-900">
            Issues
        </h2>

        <a href="{{ route('issues.create') }}"
           class="text-sm font-semibold text-gray-700 hover:text-black">
            + New Issue
        </a>
    </div>

    <div class="space-y-3">

        @forelse($project->issues as $issue)

            <div class="border rounded-xl p-5 hover:border-gray-400 transition">

                <div class="flex items-center justify-between">

                    <div>
                        <a href="{{ route('issues.show', $issue) }}"
                           class="font-semibold text-lg text-gray-900 hover:underline">
                            {{ $issue->title }}
                        </a>

                        <p class="text-sm text-gray-500 mt-1">
                            Due:
                            {{ $issue->due_date ? \Carbon\Carbon::parse($issue->due_date)->format('d M Y') : 'No deadline' }}
                        </p>
                    </div>

                    <div class="flex gap-2">

                        <span class="px-3 py-1 text-xs font-semibold rounded-full border">
                            {{ strtoupper($issue->priority) }}
                        </span>

                        <span class="px-3 py-1 text-xs font-semibold rounded-full border">
                            {{ strtoupper(str_replace('_', ' ', $issue->status)) }}
                        </span>

                    </div>

                </div>

            </div>

        @empty

            <div class="border rounded-xl p-8 text-center text-gray-500">
                No issues found for this project.
            </div>

        @endforelse

    </div>

    <div class="mt-8">
        <a href="{{ route('projects.index') }}"
           class="text-sm text-gray-500 hover:text-gray-900">
            ← Back to Projects
        </a>
    </div>

</div>
@endsection