@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-6 py-10">
    <h1 class="text-2xl font-bold text-gray-900 mb-6 tracking-tight">
        Create Issue
    </h1>

    @if($errors->any())
        <div class="mb-5 p-4 rounded-lg border border-red-200 bg-red-50 text-red-700 text-sm">
            <ul class="space-y-1">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm">

    <form action="{{ route('issues.store') }}" method="POST" class="space-y-6">
    @csrf

    <div>
        <label class="block text-sm font-semibold text-gray-800 mb-2">
            Title
        </label>

        <input
            type="text"
            name="title"
            value="{{ old('title') }}"
            placeholder="e.g. Login page bug"
            class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900"
        >
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-800 mb-2">
            Description
        </label>

        <textarea
            name="description"
            rows="4"
            placeholder="Describe the issue..."
            class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 resize-none"
        >{{ old('description') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-800 mb-2">
            Project
        </label>

        <select
            name="project_id"
            class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900"
        >
            <option value="">Select project</option>

            @foreach($projects as $project)
                <option
                    value="{{ $project->id }}"
                    {{ old('project_id') == $project->id ? 'selected' : '' }}
                >
                    {{ $project->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <label class="block text-sm font-semibold text-gray-800 mb-2">
                Status
            </label>

            <select
                name="status"
                class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900"
            >
                <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-800 mb-2">
                Priority
            </label>

            <select
                name="priority"
                class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900"
            >
                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
            </select>
        </div>

    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-800 mb-2">
            Due Date
        </label>

        <input
            type="date"
            name="due_date"
            value="{{ old('due_date') }}"
            class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900"
        >
    </div>

    <div class="flex items-center justify-between pt-2">
        <a href="{{ route('issues.index') }}"
           class="text-sm font-medium text-gray-500 hover:text-gray-900 transition">
            ← Back
        </a>

        <button type="submit"
                class="bg-gray-900 hover:bg-black text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
            Create Issue
        </button>
    </div>
</form>

    </div>
</div>
@endsection