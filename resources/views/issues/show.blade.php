@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">

    <div class="flex items-start justify-between mb-8">
        <div>
            <a href="{{ route('issues.index') }}"
               class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700 font-medium mb-3 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Issues
            </a>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $issue->title }}</h1>
            <p class="text-slate-500 text-sm mt-1.5 max-w-2xl leading-relaxed">{{ $issue->description }}</p>
        </div>

        <div class="flex items-center gap-3 mt-1 shrink-0">
            <a href="{{ route('issues.edit', $issue) }}"
               class="inline-flex items-center gap-1.5 text-sm text-yellow-600 hover:text-yellow-700 font-medium transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-1.414.586H9v-1.414a2 2 0 01.586-1.414z"/>
                </svg>
                Edit
            </a>

            <form action="{{ route('issues.destroy', $issue) }}" method="POST" onsubmit="return confirm('Delete this issue?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-1.5 text-sm text-red-500 hover:text-red-600 font-medium transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0a1 1 0 00-1-1h-4a1 1 0 00-1 1H5"/>
                    </svg>
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-2">Project</p>
            <p class="text-sm font-semibold text-slate-900">{{ $issue->project->name }}</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-2">Status</p>
            @php
                $statusClass = match($issue->status) {
                    'open'        => 'text-blue-600',
                    'closed'      => 'text-green-600',
                    'in_progress' => 'text-yellow-600',
                    default       => 'text-slate-600',
                };
            @endphp
            <p class="text-sm font-semibold {{ $statusClass }}">{{ strtoupper(str_replace('_', ' ', $issue->status)) }}</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-2">Priority</p>
            @php
                $priorityClass = match($issue->priority) {
                    'high'   => 'text-red-600',
                    'medium' => 'text-yellow-600',
                    'low'    => 'text-green-600',
                    default  => 'text-slate-600',
                };
            @endphp
            <p class="text-sm font-semibold {{ $priorityClass }}">{{ strtoupper($issue->priority) }}</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-2">Due Date</p>
            <p class="text-sm font-semibold text-slate-900">
                {{ $issue->due_date ? \Carbon\Carbon::parse($issue->due_date)->format('d M Y') : 'No deadline' }}
            </p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-6">
        <h2 class="text-sm font-semibold text-slate-900 mb-4">Tags</h2>

        <div id="tags-list" class="flex flex-wrap gap-2 mb-4">
            @foreach($issue->tags as $tag)
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200"
                      id="tag-{{ $tag->id }}"
                      data-issue="{{ $issue->id }}">
                    {{ $tag->name }}
                    <button onclick="detachTag(this.closest('span').dataset.issue, this.dataset.tag)"
                            data-tag="{{ $tag->id }}"
                            class="text-slate-400 hover:text-red-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </span>
            @endforeach
        </div>

        <div class="flex items-center gap-2">
            <select id="tag-select"
                    class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <option value="">Select tag...</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>

            <button data-issue="{{ $issue->id }}" onclick="attachTag(this.dataset.issue)"
                    class="inline-flex items-center gap-1.5 bg-slate-900 hover:bg-black text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                Attach
            </button>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h2 class="text-sm font-semibold text-slate-900 mb-4">Comments</h2>

        <div id="comments-list" class="space-y-3 mb-4">
            <p class="text-slate-400 text-sm" id="comments-loading">Loading comments...</p>
        </div>

        <div class="mt-2 text-center">
            <button id="load-more"
                    class="text-sm text-blue-600 hover:text-blue-700 font-medium hidden transition-colors">
                Load more
            </button>
        </div>

        <div class="mt-6 pt-6 border-t border-slate-100" id="comment-form">
            <h3 class="text-sm font-semibold text-slate-900 mb-4">Add Comment</h3>

            <input type="hidden" id="issue-id" value="{{ $issue->id }}">

            <div class="space-y-3">
                <div>
                    <input type="text" id="author-name" placeholder="Your name"
                           class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <p class="text-red-500 text-xs mt-1 hidden" id="author-error"></p>
                </div>

                <div>
                    <textarea id="comment-body" rows="3" placeholder="Write a comment..."
                              class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400
                                     focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-none"></textarea>
                    <p class="text-red-500 text-xs mt-1 hidden" id="body-error"></p>
                </div>

                <div class="flex justify-end">
                    <button onclick="submitComment()"
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Add Comment
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
function attachTag(issueId) {
    const tagId = document.getElementById('tag-select').value;
    if (!tagId) return;

    fetch(`/issues/${issueId}/tags/${tagId}/attach`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const list = document.getElementById('tags-list');
            const span = document.createElement('span');
            span.id = `tag-${data.tag.id}`;
            span.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200';
            span.dataset.issue = issueId;
            span.innerHTML = `${data.tag.name}
                <button onclick="detachTag(${issueId}, ${data.tag.id})" class="text-slate-400 hover:text-red-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>`;
            list.appendChild(span);
        }
    });
}

function detachTag(issueId, tagId) {
    fetch(`/issues/${issueId}/tags/${tagId}/detach`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) document.getElementById(`tag-${tagId}`).remove();
    });
}

let commentsPage = 1;
let allLoaded = false;

function loadComments(page = 1) {
    fetch(`/comments?issue_id={{ $issue->id }}&page=${page}`)
    .then(res => res.json())
    .then(data => {
        const loading = document.getElementById('comments-loading');
        if (loading) loading.remove();

        data.data.forEach(comment => {
            appendCommentToList(comment.author_name, comment.body, comment.created_at);
        });

        if (data.next_page_url) {
            document.getElementById('load-more').classList.remove('hidden');
        } else {
            document.getElementById('load-more').classList.add('hidden');
            allLoaded = true;
        }
    });
}

function appendCommentToList(authorName, body, createdAt, prepend = false) {
    const list = document.getElementById('comments-list');
    const div = document.createElement('div');
    div.className = 'rounded-xl border border-slate-200 bg-slate-50 p-4';
    div.innerHTML = `
        <div class="flex justify-between items-center mb-2">
            <p class="text-sm font-semibold text-slate-900">${authorName}</p>
            <p class="text-xs text-slate-400">${createdAt}</p>
        </div>
        <p class="text-sm text-slate-600 leading-relaxed">${body}</p>
    `;
    if (prepend) list.prepend(div);
    else list.appendChild(div);
}

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
        body: JSON.stringify({ issue_id: issueId, author_name: authorName, body: body })
    })
    .then(res => res.json().then(data => ({ status: res.status, data })))
    .then(({ status, data }) => {
        if (status === 422) {
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
        appendCommentToList(data.author_name, data.body, data.created_at, true);
        document.getElementById('author-name').value = '';
        document.getElementById('comment-body').value = '';
    });
}

document.getElementById('load-more').addEventListener('click', () => {
    commentsPage++;
    loadComments(commentsPage);
});

loadComments();
</script>
@endsection