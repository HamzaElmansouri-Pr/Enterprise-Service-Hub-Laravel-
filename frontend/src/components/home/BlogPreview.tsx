"use client";

import { motion } from "framer-motion";
import Link from "next/link";
import type { Blog } from "@/lib/types";

interface BlogPreviewProps {
  blogs: Blog[];
  title: string | null;
  subtitle: string | null;
}

export function BlogPreview({ blogs, title, subtitle }: BlogPreviewProps) {
  if (blogs.length === 0) return null;

  return (
    <section className="section-padding bg-[var(--bg-abyss)] relative overflow-hidden">
      {/* Decorative Elite Orbs */}
      <div className="absolute top-0 right-0 w-[600px] h-[600px] rounded-full bg-[var(--primary)]/5 blur-[150px] mix-blend-screen pointer-events-none" />
      <div className="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full bg-[var(--accent)]/5 blur-[150px] mix-blend-screen pointer-events-none" />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <motion.div initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }} transition={{ duration: 0.6 }} className="text-center mb-20">
          {subtitle && (
            <span className="inline-flex items-center gap-2 px-4 py-2 rounded-full elite-glass text-[var(--primary-light)] text-sm font-medium mb-6">
              <span className="w-1.5 h-1.5 rounded-full bg-[var(--primary-light)] animate-pulse" />
              {subtitle}
            </span>
          )}
          <h2 className="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-b from-white to-white/60 tracking-tight">
            {title || "Latest Insights"}
          </h2>
        </motion.div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {blogs.map((blog, i) => (
            <motion.div key={blog.id} initial={{ opacity: 0, y: 40 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true, margin: "-50px" }} transition={{ duration: 0.7, delay: i * 0.1, ease: [0.16, 1, 0.3, 1] }}>
              <Link href={`/blog/${blog.slug}`} className="group relative block h-full outline-none">
                {/* Glow Behind Card */}
                <div className="absolute inset-0 bg-gradient-to-br from-[var(--primary)]/20 to-transparent rounded-[24px] blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500" />
                
                {/* Elite Glass Card */}
                <div className="relative h-full flex flex-col rounded-[24px] elite-glass border border-white/5 group-hover:border-white/10 transition-all duration-500 overflow-hidden">
                  
                  <div className="relative h-56 overflow-hidden">
                    {blog.image ? (
                      <img src={blog.image} alt={blog.title} className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out" />
                    ) : (
                      <div className="w-full h-full bg-[var(--bg-deep)] flex items-center justify-center"><span className="text-5xl opacity-20">📰</span></div>
                    )}
                    <div className="absolute inset-0 bg-gradient-to-t from-[var(--bg-abyss)] to-transparent opacity-60" />
                    
                    {blog.category && (
                      <span className="absolute top-4 left-4 px-4 py-1.5 rounded-full bg-[var(--bg-abyss)]/80 border border-white/10 text-white text-xs font-semibold tracking-wide backdrop-blur-md shadow-lg">
                        {blog.category}
                      </span>
                    )}
                  </div>
                  
                  <div className="p-8 flex-1 flex flex-col relative">
                    <div className="absolute inset-0 bg-gradient-to-br from-white/[0.03] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none" />
                    
                    {blog.published_at && (
                      <p className="text-[var(--primary-light)] font-medium text-xs mb-4 uppercase tracking-wider">
                        {new Date(blog.published_at).toLocaleDateString("en-US", { month: "short", day: "numeric", year: "numeric" })}
                      </p>
                    )}
                    
                    <h3 className="text-xl sm:text-2xl font-bold text-white mb-4 group-hover:text-[var(--primary-light)] transition-colors duration-300 line-clamp-2 tracking-tight">
                      {blog.title}
                    </h3>
                    
                    {blog.excerpt && (
                      <p className="text-[var(--text-muted)] text-sm leading-relaxed line-clamp-3 mb-6 flex-1">
                        {blog.excerpt}
                      </p>
                    )}
                    
                    <div className="mt-auto flex items-center justify-between pt-6 border-t border-white/5 group-hover:border-white/10 transition-colors duration-500">
                      {blog.author && (
                        <div className="flex items-center gap-3">
                          <div className="w-8 h-8 rounded-full bg-gradient-to-br from-[var(--primary)] to-[var(--accent)] p-[1px]">
                            <div className="w-full h-full bg-[var(--bg-deep)] rounded-full flex items-center justify-center text-xs font-bold text-white">
                              {blog.author.name?.[0]}
                            </div>
                          </div>
                          <span className="text-white text-sm font-medium">{blog.author.name}</span>
                        </div>
                      )}
                      
                      {/* Arrow */}
                      <div className="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-white group-hover:bg-[var(--primary)] transition-colors duration-300">
                        <svg className="w-4 h-4 transform -rotate-45 group-hover:rotate-0 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                      </div>
                    </div>
                  </div>
                </div>
              </Link>
            </motion.div>
          ))}
        </div>

        <motion.div initial={{ opacity: 0 }} whileInView={{ opacity: 1 }} viewport={{ once: true }} className="text-center mt-16">
          <Link href="/blog" className="inline-flex items-center gap-3 px-8 py-4 rounded-xl elite-glass border border-white/10 hover:border-white/30 text-white font-medium hover:bg-white/5 transition-all duration-300 group">
            View All Posts
            <svg className="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
          </Link>
        </motion.div>
      </div>
    </section>
  );
}
