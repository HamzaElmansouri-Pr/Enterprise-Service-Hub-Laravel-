"use client";

import React from 'react';
import Link from 'next/link';
import { motion } from 'framer-motion';
import { getDictionary } from "@/lib/dictionary";

interface ErrorStateProps {
  title?: string;
  message?: string;
  reset?: () => void;
  locale?: string;
}

export function ErrorState({ 
  title = "Something went wrong!", 
  message = "An unexpected error occurred. We've been notified and are looking into it.",
  reset 
}: ErrorStateProps) {
  
  // Optional: Add some slight random glitch effect to the error page
  const glitchAnimation = {
    x: [0, -5, 5, -5, 0],
    transition: { duration: 0.5, repeat: Infinity, repeatType: "mirror" as const, repeatDelay: 3 }
  };

  return (
    <div className="flex flex-col items-center justify-center min-h-[70vh] p-8 text-center relative overflow-hidden">
      {/* Abstract Background Elements */}
      <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-red-500/5 rounded-full blur-[100px] pointer-events-none -z-10" />
      
      <motion.div 
        initial={{ scale: 0.8, opacity: 0 }}
        animate={{ scale: 1, opacity: 1 }}
        transition={{ duration: 0.5, type: "spring", bounce: 0.5 }}
        className="relative mb-8"
      >
        <div className="w-32 h-32 bg-red-500/10 rounded-full flex items-center justify-center relative z-10 border border-red-500/20 backdrop-blur-sm">
          <motion.svg 
            animate={glitchAnimation}
            className="w-16 h-16 text-red-500" 
            fill="none" 
            viewBox="0 0 24 24" 
            stroke="currentColor"
          >
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
          </motion.svg>
        </div>
        
        {/* Ripples */}
        <motion.div 
          animate={{ scale: [1, 1.5], opacity: [0.5, 0] }}
          transition={{ duration: 2, repeat: Infinity }}
          className="absolute inset-0 bg-red-500/20 rounded-full -z-10"
        />
        <motion.div 
          animate={{ scale: [1, 2], opacity: [0.3, 0] }}
          transition={{ duration: 2, repeat: Infinity, delay: 0.5 }}
          className="absolute inset-0 bg-red-500/10 rounded-full -z-10"
        />
      </motion.div>

      <motion.div
        initial={{ y: 20, opacity: 0 }}
        animate={{ y: 0, opacity: 1 }}
        transition={{ duration: 0.6, delay: 0.2 }}
        className="z-10 max-w-xl mx-auto"
      >
        <h2 className="text-3xl md:text-4xl font-bold text-white mb-4 tracking-tight">{title}</h2>
        <p className="text-lg text-[var(--text-secondary)] mb-10">{message}</p>
        
        <div className="flex flex-col sm:flex-row items-center justify-center gap-4">
          {reset && (
            <button
              onClick={() => reset()}
              className="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-500 hover:to-red-400 text-white font-medium rounded-xl transition-all shadow-[0_0_20px_rgba(239,68,68,0.3)] flex items-center justify-center group"
            >
              <svg className="w-5 h-5 mr-2 group-hover:-rotate-180 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
              </svg>
              Try Again
            </button>
          )}
          
          <Link 
            href="/" 
            className="w-full sm:w-auto px-8 py-3.5 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-medium rounded-xl transition-colors flex items-center justify-center"
          >
            <svg className="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Return Home
          </Link>

          <Link 
            href="/contact" 
            className="w-full sm:w-auto px-8 py-3.5 bg-white/5 hover:bg-white/10 border border-white/10 text-[var(--accent)] font-medium rounded-xl transition-colors flex items-center justify-center"
          >
            <svg className="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Report Issue
          </Link>
        </div>
      </motion.div>
    </div>
  );
}
