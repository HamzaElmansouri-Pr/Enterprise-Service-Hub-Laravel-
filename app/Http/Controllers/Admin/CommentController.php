<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateCommentStatusRequest;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        $comments = Comment::with('blog')
            ->where('status', $status)
            ->latest()
            ->paginate(15);
            
        return view('admin.comments.index', compact('comments', 'status'));
    }

    public function updateStatus(UpdateCommentStatusRequest $request, Comment $comment)
    {
        $validated = $request->validated();

        $comment->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Comment status updated successfully.');
    }

    public function destroy(Comment $comment)
    {
        // Triggers soft delete since we added SoftDeletes
        $comment->delete();
        
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
