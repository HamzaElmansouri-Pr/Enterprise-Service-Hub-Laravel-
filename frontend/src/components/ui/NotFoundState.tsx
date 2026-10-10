"use client";

import React, { useState } from 'react';
import Link from 'next/link';
import { motion } from 'framer-motion';
import { useRouter } from 'next/navigation';

interface NotFoundStateProps {
  title?: string;
  message?: string;
  returnLink?: string;
  returnLabel?: string;
  locale?: string;
}

export function NotFoundState({ 
  title = "Page Not Found", 
  message = "We're sorry, the page you requested could not be found. It may have been moved or deleted.",
  returnLink = "/",
  returnLabel = "Return to Homepage"
}: NotFoundStateProps) {
  const [searchQuery, setSearchQuery] = useState("");
  const router = useRouter();

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    if (searchQuery.trim()) {
      router.push(`/blog?search=${encodeURIComponent(searchQuery)}`);
    }
  };

  return (
    <div className="flex flex-col items-center justify-center min-h-[70vh] p-8 text-center relative overflow-hidden">
      {/* Abstract Background Elements */}
      <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-[var(--accent)]/5 rounded-full blur-[100px] pointer-events-none -z-10" />
      
      <motion.div 
        initial={{ y: -20, opacity: 0 }}
        animate={{ y: 0, opacity: 1 }}
        transition={{ duration: 0.6 }}
        className="relative"
      >
        <motion.div 
          animate={{ y: [0, -10, 0] }}
          transition={{ repeat: Infinity, duration: 4, ease: "easeInOut" }}
          className="text-[150px] md:text-[200px] font-black leading-none tracking-tighter text-transparent bg-clip-text bg-gradient-to-b from-white/20 to-white/5 select-none"
        >
          404
        </motion.div>
        
        {/* Floating elements around 404 */}
        <motion.div 
          animate={{ rotate: 360 }}
          transition={{ repeat: Infinity, duration: 20, ease: "linear" }}
          className="absolute -top-10 -right-10 w-24 h-24 border border-white/10 rounded-full border-dashed"
        />
        <motion.div 
          animate={{ rotate: -360 }}
          transition={{ repeat: Infinity, duration: 15, ease: "linear" }}
          className="absolute -bottom-5 -left-5 w-16 h-16 border-2 border-[var(--accent)]/20 rounded-lg"
        />
      </motion.div>

      <motion.div
        initial={{ y: 20, opacity: 0 }}
        animate={{ y: 0, opacity: 1 }}
        transition={{ duration: 0.6, delay: 0.2 }}
        className="z-10 mt-[-20px] max-w-2xl mx-auto"
      >
        <h1 className="text-3xl md:text-5xl font-bold text-white mb-6 tracking-tight">{title}</h1>
        <p className="text-lg text-[var(--text-secondary)] mb-10">{message}</p>
        
        {/* Search Bar */}
        <form onSubmit={handleSearch} className="relative max-w-md mx-auto mb-12 group">
          <div className="absolute -inset-1 bg-gradient-to-r from-[var(--accent)]/30 to-[var(--primary)]/30 rounded-2xl blur opacity-25 group-focus-within:opacity-50 transition duration-500"></div>
          <div className="relative flex items-center elite-glass rounded-2xl p-2 border border-white/10">
            <svg className="w-6 h-6 text-white/40 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input 
              type="text" 
              placeholder="Search for something else..." 
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              className="w-full bg-transparent border-none text-white px-4 py-2 focus:outline-none focus:ring-0 placeholder:text-white/30"
            />
            <button type="submit" className="px-6 py-2 bg-[var(--accent)] hover:bg-[var(--accent)]/90 text-white rounded-xl font-medium transition-colors">
              Search
            </button>
          </div>
        </form>

        {/* Suggested Pages & Actions */}
        <div className="flex flex-col sm:flex-row items-center justify-center gap-4 mt-8">
          <Link 
            href={returnLink} 
            className="w-full sm:w-auto px-8 py-3.5 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-medium rounded-xl transition-colors flex items-center justify-center"
          >
            <svg className="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            {returnLabel}
          </Link>
          
          <Link 
            href="/services" 
            className="w-full sm:w-auto px-8 py-3.5 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-medium rounded-xl transition-colors flex items-center justify-center"
          >
            <svg className="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            Our Services
          </Link>

          <Link 
            href="/contact" 
            className="w-full sm:w-auto px-8 py-3.5 bg-white/5 hover:bg-white/10 border border-white/10 text-[var(--accent)] font-medium rounded-xl transition-colors flex items-center justify-center"
          >
            <svg className="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Report an Issue
          </Link>
        </div>
      </motion.div>
    </div>
  );
}
