"use client";

import { useState, useEffect } from "react";
import { getComments, submitComment } from "@/lib/api";
import { MessageSquare, User, Loader2, Send } from "lucide-react";
import { formatDistanceToNow } from "date-fns";

interface Comment {
  id: number;
  author_name: string;
  content: string;
  created_at: string;
  replies?: Comment[];
}

interface CommentSectionProps {
  modelType: string;
  modelId: number;
}

export function CommentSection({ modelType, modelId }: CommentSectionProps) {
  const [comments, setComments] = useState<Comment[]>([]);
  const [isLoading, setIsLoading] = useState(true);
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [content, setContent] = useState("");
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");
  const [replyTo, setReplyTo] = useState<number | null>(null);

  useEffect(() => {
    fetchComments();
  }, [modelType, modelId]);

  const fetchComments = async () => {
    try {
      setIsLoading(true);
      const data = await getComments(modelType, modelId);
      // Ensure we set an array
      setComments(Array.isArray(data.data) ? data.data : Array.isArray(data) ? data : []);
    } catch (err) {
      console.error("Failed to load comments", err);
    } finally {
      setIsLoading(false);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError("");
    setSuccess("");
    setIsSubmitting(true);

    try {
      await submitComment(modelType, modelId, {
        name,
        email,
        content,
        parent_id: replyTo || undefined,
      });
      setSuccess("Your comment has been submitted and is pending approval.");
      setContent("");
      setReplyTo(null);
      // Wait for approval to show it, or reload comments
      fetchComments();
    } catch (err: any) {
      setError(err.message || "Failed to submit comment. Please try again.");
    } finally {
      setIsSubmitting(false);
    }
  };

  const renderComment = (comment: Comment, isReply = false) => (
    <div key={comment.id} className={`flex gap-4 ${isReply ? "ml-8 mt-4 border-l-2 border-white/5 pl-4" : "mt-6"}`}>
      <div className="w-10 h-10 rounded-full bg-gradient-to-br from-[var(--primary)] to-[var(--accent)] flex items-center justify-center shrink-0">
        <User className="w-5 h-5 text-white" />
      </div>
      <div className="flex-1">
        <div className="bg-[var(--bg-deep)] border border-white/5 rounded-2xl p-4">
          <div className="flex items-center justify-between mb-2">
            <h5 className="text-white font-semibold">{comment.author_name}</h5>
            <span className="text-xs text-[var(--text-muted)]">
              {formatDistanceToNow(new Date(comment.created_at), { addSuffix: true })}
            </span>
          </div>
          <p className="text-[var(--text-secondary)] text-sm leading-relaxed whitespace-pre-wrap">
            {comment.content}
          </p>
        </div>
        {!isReply && (
          <button
            onClick={() => setReplyTo(replyTo === comment.id ? null : comment.id)}
            className="text-[var(--primary-light)] text-sm mt-2 ml-4 hover:underline"
          >
            {replyTo === comment.id ? "Cancel Reply" : "Reply"}
          </button>
        )}
        
        {/* Reply Form */}
        {replyTo === comment.id && (
          <div className="mt-4 ml-8">
            <CommentForm isReply />
          </div>
        )}

        {/* Nested Replies */}
        {comment.replies && comment.replies.length > 0 && (
          <div className="mt-2">
            {comment.replies.map(reply => renderComment(reply, true))}
          </div>
        )}
      </div>
    </div>
  );

  const CommentForm = ({ isReply = false }) => (
    <form onSubmit={handleSubmit} className="bg-[var(--bg-deep)] border border-white/5 rounded-2xl p-6 relative group overflow-hidden">
      <div className="absolute inset-0 bg-gradient-to-br from-[var(--primary)]/5 to-[var(--accent)]/5 pointer-events-none" />
      
      <h4 className="text-white font-semibold mb-4 text-lg flex items-center gap-2 relative z-10">
        <MessageSquare className="w-5 h-5 text-[var(--primary)]" />
        {isReply ? "Write a reply" : "Leave a comment"}
      </h4>

      {error && (
        <div className="bg-red-500/10 border border-red-500/20 text-red-400 p-3 rounded-lg text-sm mb-4 relative z-10">
          {error}
        </div>
      )}
      
      {success && (
        <div className="bg-green-500/10 border border-green-500/20 text-green-400 p-3 rounded-lg text-sm mb-4 relative z-10">
          {success}
        </div>
      )}

      <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 relative z-10">
        <div>
          <input
            type="text"
            required
            placeholder="Your Name"
            value={name}
            onChange={(e) => setName(e.target.value)}
            className="w-full bg-[var(--bg-abyss)] border border-white/10 rounded-xl px-4 py-3 text-white placeholder:text-white/30 focus:outline-none focus:border-[var(--primary)] transition-colors"
          />
        </div>
        <div>
          <input
            type="email"
            required
            placeholder="Your Email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            className="w-full bg-[var(--bg-abyss)] border border-white/10 rounded-xl px-4 py-3 text-white placeholder:text-white/30 focus:outline-none focus:border-[var(--primary)] transition-colors"
          />
        </div>
      </div>
      <div className="mb-4 relative z-10">
        <textarea
          required
          rows={4}
          placeholder="Your message..."
          value={content}
          onChange={(e) => setContent(e.target.value)}
          className="w-full bg-[var(--bg-abyss)] border border-white/10 rounded-xl px-4 py-3 text-white placeholder:text-white/30 focus:outline-none focus:border-[var(--primary)] transition-colors resize-none"
        />
      </div>
      <div className="flex justify-end relative z-10">
        <button
          type="submit"
          disabled={isSubmitting}
          className="px-6 py-3 rounded-xl bg-gradient-to-r from-[var(--primary)] to-[var(--accent)] text-white font-semibold flex items-center gap-2 hover:shadow-[0_0_20px_rgba(59,130,246,0.4)] transition-shadow disabled:opacity-50"
        >
          {isSubmitting ? <Loader2 className="w-5 h-5 animate-spin" /> : <Send className="w-5 h-5" />}
          {isSubmitting ? "Submitting..." : "Post Comment"}
        </button>
      </div>
    </form>
  );

  return (
    <div className="mt-16">
      <h3 className="text-2xl font-bold text-white mb-8 border-b border-white/10 pb-4">
        Comments ({comments.length})
      </h3>
      
      {!replyTo && <CommentForm />}

      <div className="mt-12 space-y-2">
        {isLoading ? (
          <div className="flex justify-center py-8">
            <Loader2 className="w-8 h-8 animate-spin text-[var(--primary)]" />
          </div>
        ) : comments.length > 0 ? (
          comments.map(comment => renderComment(comment))
        ) : (
          <p className="text-[var(--text-muted)] text-center py-8">No comments yet. Be the first to share your thoughts!</p>
        )}
      </div>
    </div>
  );
}
