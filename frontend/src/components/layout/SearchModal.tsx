"use client";

import { useState, useEffect, useRef } from "react";
import { motion, AnimatePresence } from "framer-motion";
import { Search, X, Loader2 } from "lucide-react";
import Link from "next/link";
import { searchGlobal } from "@/lib/api";
import { getDictionary } from "@/lib/dictionary";

interface SearchResult {
  id: string;
  title: string;
  excerpt?: string;
  type: string;
  url: string;
}

interface SearchModalProps {
  isOpen: boolean;
  onClose: () => void;
  locale?: string;
}

export function SearchModal({ isOpen, onClose, locale = "en" }: SearchModalProps) {
  const t = getDictionary(locale).searchModal;
  const [query, setQuery] = useState("");
  const [results, setResults] = useState<SearchResult[]>([]);
  const [isSearching, setIsSearching] = useState(false);
  const inputRef = useRef<HTMLInputElement>(null);

  // Focus input when modal opens
  useEffect(() => {
    if (isOpen) {
      setTimeout(() => inputRef.current?.focus(), 100);
    } else {
      setQuery("");
      setResults([]);
    }
  }, [isOpen]);

  // Handle escape key to close
  useEffect(() => {
    const handleKeyDown = (e: KeyboardEvent) => {
      if (e.key === "Escape") onClose();
    };
    window.addEventListener("keydown", handleKeyDown);
    return () => window.removeEventListener("keydown", handleKeyDown);
  }, [onClose]);

  // Debounced search
  useEffect(() => {
    const fetchResults = async () => {
      if (!query.trim()) {
        setResults([]);
        return;
      }

      setIsSearching(true);
      try {
        const res = await searchGlobal(query);
        // Assuming the backend returns { data: [...] } or just an array
        setResults(res.data || res.results || res || []);
      } catch (error) {
        console.error("Search failed:", error);
        setResults([]);
      } finally {
        setIsSearching(false);
      }
    };

    const timer = setTimeout(fetchResults, 300);
    return () => clearTimeout(timer);
  }, [query]);

  return (
    <AnimatePresence>
      {isOpen && (
        <>
          {/* Backdrop */}
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            onClick={onClose}
            className="fixed inset-0 z-[100] bg-black/60 backdrop-blur-sm"
          />

          {/* Modal Container */}
          <div className="fixed inset-0 z-[101] flex items-start justify-center pt-[10vh] px-4 pointer-events-none">
            <motion.div
              initial={{ opacity: 0, scale: 0.95, y: -20 }}
              animate={{ opacity: 1, scale: 1, y: 0 }}
              exit={{ opacity: 0, scale: 0.95, y: -20 }}
              transition={{ duration: 0.2, ease: "easeOut" }}
              className="w-full max-w-2xl bg-[var(--bg-card)] border border-white/10 shadow-2xl rounded-2xl overflow-hidden pointer-events-auto flex flex-col"
            >
              {/* Search Header */}
              <div className="relative flex items-center p-4 border-b border-white/10">
                <Search className="w-5 h-5 text-[var(--text-muted)] absolute left-6" />
                <input
                  ref={inputRef}
                  type="text"
                  placeholder={t.placeholder}
                  value={query}
                  onChange={(e) => setQuery(e.target.value)}
                  className="w-full bg-transparent border-none focus:outline-none focus:ring-0 text-white placeholder-[var(--text-muted)] pl-10 pr-10 text-lg"
                />
                <button
                  onClick={onClose}
                  className="absolute right-4 p-2 text-[var(--text-muted)] hover:text-white rounded-lg hover:bg-white/5 transition-colors"
                >
                  <X className="w-5 h-5" />
                </button>
              </div>

              {/* Search Results */}
              <div className="max-h-[60vh] overflow-y-auto p-2">
                {isSearching ? (
                  <div className="flex flex-col items-center justify-center py-12 text-[var(--text-muted)]">
                    <Loader2 className="w-8 h-8 animate-spin mb-4 text-[var(--primary)]" />
                    <p>Searching...</p>
                  </div>
                ) : results.length > 0 ? (
                  <div className="space-y-1">
                    {results.map((result) => (
                      <Link
                        key={`${result.type}-${result.id}`}
                        href={result.url}
                        onClick={onClose}
                        className="flex items-start gap-4 p-4 rounded-xl hover:bg-white/5 transition-colors group"
                      >
                        <div className="mt-1">
                          {result.type === "service" && (
                            <span className="px-2 py-1 text-[10px] uppercase font-bold bg-teal-500/20 text-teal-400 rounded">Service</span>
                          )}
                          {result.type === "project" && (
                            <span className="px-2 py-1 text-[10px] uppercase font-bold bg-blue-500/20 text-blue-400 rounded">Project</span>
                          )}
                          {result.type === "blog" && (
                            <span className="px-2 py-1 text-[10px] uppercase font-bold bg-orange-500/20 text-orange-400 rounded">Blog</span>
                          )}
                        </div>
                        <div>
                          <h4 className="text-white font-medium group-hover:text-[var(--primary-light)] transition-colors">
                            {result.title}
                          </h4>
                          {result.excerpt && (
                            <p className="text-sm text-[var(--text-muted)] mt-1 line-clamp-1">
                              {result.excerpt}
                            </p>
                          )}
                        </div>
                      </Link>
                    ))}
                  </div>
                ) : query.trim() ? (
                  <div className="py-12 text-center text-[var(--text-muted)]">
                    <Search className="w-12 h-12 mx-auto mb-4 opacity-20" />
                    <p>No results found for "{query}"</p>
                  </div>
                ) : (
                  <div className="py-12 text-center text-[var(--text-muted)]">
                    <p>Type to start searching...</p>
                  </div>
                )}
              </div>
            </motion.div>
          </div>
        </>
      )}
    </AnimatePresence>
  );
}
