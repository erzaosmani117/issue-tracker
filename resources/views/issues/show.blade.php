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
    <div class="flex gap-2 mt-4">
    <select id="tag-select" class="border rounded-lg px-3 py-1 text-sm">
        <option value="">Select tag...</option>
        @foreach($tags as $tag)
            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
        @endforeach
    </select>
   <button data-issue="{{ $issue->id }}" onclick="attachTag(this.dataset.issue)"
   
        class="bg-gray-900 text-white px-4 py-1 rounded-lg text-sm">
        Attach
    </button>
</div>
<div id="tags-list" class="flex flex-wrap gap-2 mt-3">
    @foreach($issue->tags as $tag)
        <span class="px-3 py-1 rounded-full text-sm font-medium border border-gray-300 bg-gray-50 flex items-center gap-1" 
      id="tag-{{ $tag->id }}"
      data-issue="{{ $issue->id }}">
    {{ $tag->name }}
    <button onclick="detachTag(this.closest('span').dataset.issue, this.dataset.tag)" 
            data-tag="{{ $tag->id }}" 
            class="text-red-400 hover:text-red-600 ml-1">✕</button>
</span>
    @endforeach
</div>
    <div>
        <h2 class="text-xl font-bold text-gray-900 mb-4">
            Comments
        </h2>
       <div id="comments-list">
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
            </div>

        @empty
            <div class="border rounded-xl p-6 text-center text-gray-500">
                No comments yet.
            </div>
        @endforelse
    </div>
    <div class="mt-6" id="comment-form">
    <h3 class="text-lg font-semibold mb-3">Add Comment</h3>
    <input type="hidden" id="issue-id" value="{{ $issue->id }}">
    <input type="text" id="author-name" placeholder="Your name"
        class="w-full border rounded-lg px-4 py-2 mb-3">
    <p class="text-red-500 text-sm hidden" id="author-error"></p>
    <textarea id="comment-body" rows="3" placeholder="Write a comment..."
        class="w-full border rounded-lg px-4 py-2 mb-3"></textarea>
    <p class="text-red-500 text-sm hidden" id="body-error"></p>
    <button onclick="submitComment()"
        class="bg-gray-900 text-white px-5 py-2 rounded-lg hover:bg-black">
        Add Comment
    </button>
</div>

    <div class="mt-8">
        <a href="{{ route('issues.index') }}"
           class="text-sm text-gray-500 hover:text-gray-900">
            ← Back to Issues
        </a>
    </div>

</div>


<script>
function submitComment() {
    const issueId = document.getElementById('issue-id').value;
    const authorName = document.getElementById('author-name').value;
    const body = document.getElementById('comment-body').value;

    document.getElementById('author-error').classList.add('hidden');
    document.getElementById('body-error').classList.add('hidden');

    fetch('/comments', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            issue_id: issueId,
            author_name: authorName,
            body: body
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.errors) {
            if (data.errors.author_name) {
                document.getElementById('author-error').textContent = data.errors.author_name[0];
                document.getElementById('author-error').classList.remove('hidden');
            }
            if (data.errors.body) {
                document.getElementById('body-error').textContent = data.errors.body[0];
                document.getElementById('body-error').classList.remove('hidden');
            }
            return;
        }

        const list = document.getElementById('comments-list');
        const div = document.createElement('div');
        div.className = 'border rounded-xl p-4 mb-3';
        div.innerHTML = `
            <div class="flex justify-between items-center mb-2">
                <p class="font-semibold">${data.author_name}</p>
                <p class="text-sm text-gray-500">${data.created_at}</p>
            </div>
            <p class="text-gray-700">${data.body}</p>
        `;
        list.prepend(div);

        // Clear forma
        document.getElementById('author-name').value = '';
        document.getElementById('comment-body').value = '';
    });
}


function attachTag(issueId) {
    const tagId = document.getElementById('tag-select').value;
    if (!tagId) return;

    fetch(`/issues/${issueId}/tags/${tagId}/attach`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const list = document.getElementById('tags-list');
            const span = document.createElement('span');
            span.id = `tag-${data.tag.id}`;
            span.className = 'px-3 py-1 rounded-full text-sm font-medium border border-gray-300 bg-gray-50 flex items-center gap-1';
            span.innerHTML = `${data.tag.name} <button onclick="detachTag(${issueId}, ${data.tag.id})" class="text-red-400 hover:text-red-600 ml-1">✕</button>`;
            list.appendChild(span);
        }
    });
}

function detachTag(issueId, tagId) {
    fetch(`/issues/${issueId}/tags/${tagId}/detach`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`tag-${tagId}`).remove();
        }
    });
}
</script>
@endsection