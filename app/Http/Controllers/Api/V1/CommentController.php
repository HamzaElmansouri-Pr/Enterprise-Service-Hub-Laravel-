<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCommentRequest;

class CommentController extends Controller
{
    /**
     * Fetch approved comments for a specific blog post.
     * We load the threaded replies recursively.
     */
    public function index(string $slug): JsonResponse
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        // Only fetch top-level comments (parent_id is null) that are approved, 
        // and eagerly load their approved replies.
        $comments = $blog->approvedComments()
            ->whereNull('parent_id')
            ->with(['replies' => function ($query) {
                $query->where('status', 'approved')->with(['replies' => function ($q) {
                    $q->where('status', 'approved');
                }]);
            }])
            ->latest()
            ->get();

        return response()->json([
            'comments' => $comments
        ]);
    }

    /**
     * Submit a new comment (or reply) on a blog post.
     */
    public function store(StoreCommentRequest $request, string $slug): JsonResponse
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        $validated = $request->validated();

        // If parent_id is provided, ensure it belongs to the same blog
        if (!empty($validated['parent_id'])) {
            $parent = Comment::findOrFail($validated['parent_id']);
            if ($parent->blog_id !== $blog->id) {
                return response()->json(['message' => 'Invalid parent comment.'], 422);
            }
        }

        $comment = $blog->comments()->create([
            'parent_id' => $validated['parent_id'] ?? null,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'content' => purify_html($validated['content']),
            'status' => 'pending', // Moderation queue
        ]);

        // Dispatch real-time admin panel notification to all admin/editor users
        $admins = \App\Models\User::whereIn('role', ['admin', 'editor'])->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\AdminAlertNotification(
            'comment',
            'New Blog Comment',
            'New comment pending approval from ' . ($comment->name ?? 'Unknown'),
            route('admin.comments.index', ['status' => 'pending']),
        ));

        return response()->json([
            'message' => 'Comment submitted successfully. It will appear once approved by a moderator.',
            'comment' => $comment,
        ], 201);
    }
}
