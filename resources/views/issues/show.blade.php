@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">

    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                {{ $issue->title }}
            </h1>
            <p class="text-gray-600 mt-3 max-w-3xl">
                {{ $issue->description }}
            </p>
        </div>

        <div class="flex gap-4">
            <a href="{{ route('issues.edit', $issue) }}"
               class="font-semibold text-gray-700 hover:text-black">
                Edit
            </a>

            <form action="{{ route('issues.destroy', $issue) }}"
                  method="POST"
                  onsubmit="return confirm('Delete this issue?')">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="font-semibold text-red-600 hover:text-red-700">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <div class="border rounded-xl p-4">
            <p class="text-xs text-gray-500 uppercase">Project</p>
            <p class="font-semibold mt-2">
                {{ $issue->project->name }}
            </p>
        </div>

        <div class="border rounded-xl p-4">
            <p class="text-xs text-gray-500 uppercase">Status</p>
            <p class="font-semibold mt-2">
                {{ strtoupper(str_replace('_', ' ', $issue->status)) }}
            </p>
        </div>

        <div class="border rounded-xl p-4">
            <p class="text-xs text-gray-500 uppercase">Priority</p>
            <p class="font-semibold mt-2">
                {{ strtoupper($issue->priority) }}
            </p>
        </div>

        <div class="border rounded-xl p-4">
            <p class="text-xs text-gray-500 uppercase">Due Date</p>
            <p class="font-semibold mt-2">
                {{ $issue->due_date ? \Carbon\Carbon::parse($issue->due_date)->format('d M Y') : 'No deadline' }}
            </p>
        </div>
    </div>

    <div class="mb-10">
        <h2 class="text-xl font-bold text-gray-900 mb-4">
            Tags
        </h2>
        @if($issue->tags->count())
            <div class="flex flex-wrap gap-2">
               @foreach($issue->tags as $tag)
    <span class="px-3 py-1 rounded-full text-sm font-medium border border-gray-300 bg-gray-50">
        {{ $tag->name }}
    </span>
@endforeach
            </div>
        @else

            <p class="text-gray-500">
                No tags assigned.
            </p>
        @endif

    </div>

    <div>
        <h2 class="text-xl font-bold text-gray-900 mb-4">
            Comments
        </h2>
        @forelse($issue->comments as $comment)
            <div class="border rounded-xl p-4 mb-3">
                <div class="flex justify-between items-center mb-2">
                    <p class="font-semibold">
                        {{ $comment->author_name }}
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ $comment->created_at->format('d M Y H:i') }}
                    </p>
                </div>
                <p class="text-gray-700">
                    {{ $comment->body }}
                </p>

            </div>

        @empty

            <div class="border rounded-xl p-6 text-center text-gray-500">
                No comments yet.
            </div>

        @endforelse

    </div>

    <div class="mt-8">
        <a href="{{ route('issues.index') }}"
           class="text-sm text-gray-500 hover:text-gray-900">
            ← Back to Issues
        </a>
    </div>

</div>
@endsection