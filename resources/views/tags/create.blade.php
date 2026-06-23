@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-6 py-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Create Tag</h1>

    <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
        <form action="{{ route('tags.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Tag Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-gray-900">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Color</label>
                <input type="color" name="color" value="{{ old('color', '#3b82f6') }}"
                    class="w-12 h-10 rounded border border-gray-200 cursor-pointer">
                @error('color')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between pt-2">
                <a href="{{ route('tags.index') }}" class="text-sm text-gray-500 hover:text-gray-900">← Back</a>
                <button type="submit" class="bg-gray-900 hover:bg-black text-white text-sm font-semibold px-5 py-2.5 rounded-lg">
                    Create Tag
                </button>
            </div>
        </form>
    </div>
</div>
@endsection