@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-6 py-10">


    <h1 class="text-2xl font-bold text-gray-900 mb-6 tracking-tight">
        Create Project
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

        <form action="{{ route('projects.update', $project }}" method="POST" class="space-y-6">
        @method('PUT')
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">
                    Project name
                </label>

                <input
                    type="text"
                    name="name"
                    old('name', $project->name)"
                    placeholder="e.g. HR System"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-gray-900
                           focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900"
                >
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">
                    Description
                </label>

                <textarea
                    name="description"
                    rows="4"
                    placeholder="Short description..."
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-gray-900
                           focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 resize-none"
                >{{ old('description') }}</textarea>
            </div>

            <div class="flex items-center justify-between pt-2">

                <a href="{{ route('projects.index') }}"
                   class="text-sm font-medium text-gray-500 hover:text-gray-900 transition">
                    ← Back
                </a>

                <button type="submit"
                        class="bg-gray-900 hover:bg-black text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                    Update project
                </button>
            </div>
        </form>
    </div>
</div>
@endsection