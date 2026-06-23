@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Issues</h1>

        <a href="{{ route('issues.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
            + Add Issue
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($issues as $issue)
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-5 hover:shadow-lg transition">
  
            <h2 class="text-lg font-semibold text-gray-900 mb-2">
               <a href="{{ route('issues.show', $issue) }}" class="text-lg font-semibold text-gray-900 hover:text-blue-600 mb-2 block">
             {{ $issue->title }}
          </a>
            </h2>
    
            <p class="text-gray-600 text-sm mb-4">
                {{ Str::limit($issue->description, 120) }}
            </p>

            <div class="flex items-center justify-between">
                <a href="{{ route('issues.edit', $issue) }}"
                   class="text-sm text-yellow-600 hover:text-yellow-700 font-medium">
                    Edit
                </a>

                <form action="{{ route('issues.destroy', $issue->id) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this issue?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="text-sm text-red-600 hover:text-red-700 font-medium">
                        Delete
                    </button>
                </form>
            </div>
        </div>
        @endforeach
        @if($issues->isEmpty())
     <div class="text-center py-16 text-gray-400">
        <p class="text-lg">No projects yet.</p>
        <a href="{{ route('issues.create') }}" class="text-blue-500 hover:underline mt-2 inline-block">Create your first issue</a>
    </div>
   @endif   
    </div>
</div>
@endsection