@extends('admin.layouts.app')

@section('title', 'Blog Comments')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-comments text-primary me-2"></i> Blog Comments
                    </h3>
                </div>
                
                <div class="card-body">
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'pending' ? 'active' : '' }}" href="{{ route('admin.comments.index', ['status' => 'pending']) }}">
                                Pending <span class="badge bg-warning text-dark">{{ \App\Models\Comment::where('status', 'pending')->count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'approved' ? 'active' : '' }}" href="{{ route('admin.comments.index', ['status' => 'approved']) }}">
                                Approved
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'rejected' ? 'active' : '' }}" href="{{ route('admin.comments.index', ['status' => 'rejected']) }}">
                                Rejected
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'spam' ? 'active' : '' }}" href="{{ route('admin.comments.index', ['status' => 'spam']) }}">
                                Spam
                            </a>
                        </li>
                    </ul>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Author</th>
                                    <th>Blog Post</th>
                                    <th>Comment</th>
                                    <th>Submitted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($comments as $comment)
                                    <tr>
                                        <td>
                                            <strong>{{ $comment->name }}</strong><br>
                                            <small class="text-muted">{{ $comment->email }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.blogs.show', $comment->blog) }}" target="_blank">
                                                {{ Str::limit($comment->blog->title, 30) }}
                                            </a>
                                            @if($comment->parent_id)
                                                <br><span class="badge bg-info">Reply to #{{ $comment->parent_id }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div style="max-width: 300px; white-space: pre-wrap;">{{ Str::limit($comment->content, 100) }}</div>
                                        </td>
                                        <td>
                                            {{ $comment->created_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                @if($status !== 'approved')
                                                <form action="{{ route('admin.comments.update-status', $comment) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                @endif

                                                @if($status !== 'rejected')
                                                <form action="{{ route('admin.comments.update-status', $comment) }}" method="POST" class="d-inline ms-1">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="btn btn-sm btn-warning" title="Reject">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                                @endif
                                                
                                                @if($status !== 'spam')
                                                <form action="{{ route('admin.comments.update-status', $comment) }}" method="POST" class="d-inline ms-1">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="spam">
                                                    <button type="submit" class="btn btn-sm btn-secondary" title="Mark as Spam">
                                                        <i class="fas fa-spider"></i>
                                                    </button>
                                                </form>
                                                @endif

                                                <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Delete this comment? It will be moved to trash.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No {{ $status }} comments found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $comments->appends(['status' => $status])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
