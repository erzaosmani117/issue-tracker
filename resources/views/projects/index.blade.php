@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Projects</h1>

        <a href="{{ route('projects.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
            + Add Project
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($projects as $project)
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-5 hover:shadow-lg transition">
  
            <h2 class="text-lg font-semibold text-gray-900 mb-2">
               <a href="{{ route('projects.show', $project) }}" class="text-lg font-semibold text-gray-900 hover:text-blue-600 mb-2 block">
             {{ $project->name }}
          </a>
            </h2>
    
            <p class="text-gray-600 text-sm mb-4">
                {{ Str::limit($project->description, 120) }}
            </p>

            <div class="flex items-center justify-between">
                <a href="{{ route('projects.edit', $project) }}"
                   class="text-sm text-yellow-600 hover:text-yellow-700 font-medium">
                    Edit
                </a>

                <form action="{{ route('projects.destroy', $project->id) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this project?')">
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
        @if($projects->isEmpty())
     <div class="text-center py-16 text-gray-400">
        <p class="text-lg">No projects yet.</p>
        <a href="{{ route('projects.create') }}" class="text-blue-500 hover:underline mt-2 inline-block">Create your first project</a>
    </div>
   @endif   
    </div>
</div>
@endsection