"use client";

import { useState, useRef, useEffect } from "react";
import { motion, AnimatePresence } from "framer-motion";
import { MessageCircle, X, Send, Loader2 } from "lucide-react";
import { submitChat } from "@/lib/api";

interface ChatMessage {
  role: "user" | "bot";
  content: string;
}

export function ChatWidget() {
  const [isOpen, setIsOpen] = useState(false);
  const [messages, setMessages] = useState<ChatMessage[]>([
    { role: "bot", content: "Hello! I am Nova, your AI assistant. How can I help you today?" }
  ]);
  const [input, setInput] = useState("");
  const [isLoading, setIsLoading] = useState(false);
  const messagesEndRef = useRef<HTMLDivElement>(null);

  // Auto-scroll to bottom
  useEffect(() => {
    messagesEndRef.current?.scrollIntoView({ behavior: "smooth" });
  }, [messages, isLoading]);

  const handleSend = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!input.trim() || isLoading) return;

    const userMessage = input.trim();
    setMessages((prev) => [...prev, { role: "user", content: userMessage }]);
    setInput("");
    setIsLoading(true);

    try {
      const res = await submitChat(userMessage);
      setMessages((prev) => [
        ...prev,
        { role: "bot", content: res.reply || "Sorry, I could not understand that." }
      ]);
    } catch (error) {
      setMessages((prev) => [
        ...prev,
        { role: "bot", content: "I encountered an error trying to respond. Please try again later." }
      ]);
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <>
      {/* Floating Button */}
      <motion.button
        initial={{ scale: 0 }}
        animate={{ scale: isOpen ? 0 : 1 }}
        whileHover={{ scale: 1.1 }}
        whileTap={{ scale: 0.9 }}
        onClick={() => setIsOpen(true)}
        className="fixed bottom-6 right-6 w-14 h-14 rounded-full bg-gradient-to-r from-[var(--primary)] to-[var(--accent)] text-white shadow-xl flex items-center justify-center z-50 hover:shadow-[0_0_20px_rgba(59,130,246,0.6)] transition-shadow"
      >
        <MessageCircle className="w-6 h-6" />
      </motion.button>

      {/* Chat Window */}
      <AnimatePresence>
        {isOpen && (
          <motion.div
            initial={{ opacity: 0, y: 50, scale: 0.9 }}
            animate={{ opacity: 1, y: 0, scale: 1 }}
            exit={{ opacity: 0, y: 50, scale: 0.9 }}
            transition={{ type: "spring", stiffness: 300, damping: 25 }}
            className="fixed bottom-6 right-6 w-80 sm:w-96 bg-[var(--bg-card)] border border-white/10 shadow-2xl rounded-2xl z-50 flex flex-col overflow-hidden"
            style={{ maxHeight: "calc(100vh - 100px)", height: "500px" }}
          >
            {/* Header */}
            <div className="flex items-center justify-between p-4 bg-gradient-to-r from-[var(--primary)] to-[var(--accent)]">
              <div className="flex items-center gap-2">
                <div className="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                  <span className="text-white font-bold">N</span>
                </div>
                <h3 className="text-white font-semibold">Nova Assistant</h3>
              </div>
              <button
                onClick={() => setIsOpen(false)}
                className="text-white/80 hover:text-white p-1 rounded hover:bg-white/10 transition-colors"
              >
                <X className="w-5 h-5" />
              </button>
            </div>

            {/* Messages */}
            <div className="flex-1 overflow-y-auto p-4 space-y-4 bg-[var(--bg-deep)]">
              {messages.map((msg, idx) => (
                <div
                  key={idx}
                  className={`flex ${msg.role === "user" ? "justify-end" : "justify-start"}`}
                >
                  <div
                    className={`max-w-[80%] rounded-2xl px-4 py-2 text-sm ${
                      msg.role === "user"
                        ? "bg-[var(--primary)] text-white rounded-br-none"
                        : "bg-[var(--bg-card)] border border-white/5 text-[var(--text-secondary)] rounded-bl-none"
                    }`}
                  >
                    {msg.content}
                  </div>
                </div>
              ))}
              {isLoading && (
                <div className="flex justify-start">
                  <div className="bg-[var(--bg-card)] border border-white/5 rounded-2xl rounded-bl-none px-4 py-3 flex items-center gap-2 text-[var(--text-muted)]">
                    <Loader2 className="w-4 h-4 animate-spin" />
                    <span className="text-xs">Typing...</span>
                  </div>
                </div>
              )}
              <div ref={messagesEndRef} />
            </div>

            {/* Input Form */}
            <div className="p-3 border-t border-white/10 bg-[var(--bg-card)]">
              <form onSubmit={handleSend} className="relative flex items-center">
                <input
                  type="text"
                  value={input}
                  onChange={(e) => setInput(e.target.value)}
                  placeholder="Type a message..."
                  disabled={isLoading}
                  className="w-full bg-[var(--bg-deep)] border border-white/10 rounded-full px-4 py-3 text-sm text-white placeholder-[var(--text-muted)] focus:outline-none focus:border-[var(--primary)] transition-colors pr-12 disabled:opacity-50"
                />
                <button
                  type="submit"
                  disabled={!input.trim() || isLoading}
                  className="absolute right-2 w-8 h-8 rounded-full bg-[var(--primary)] flex items-center justify-center text-white disabled:opacity-50 hover:bg-[var(--primary-dark)] transition-colors"
                >
                  <Send className="w-4 h-4 ml-0.5" />
                </button>
              </form>
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </>
  );
}
