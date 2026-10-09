"use client";

import { motion } from "framer-motion";

export default function Loading() {
  return (
    <div className="fixed inset-0 z-[100] bg-[var(--bg-abyss)] flex flex-col items-center justify-center overflow-hidden">
      {/* Static Background Elements — no animation */}
      <div className="absolute top-0 left-0 w-full h-full pointer-events-none">
        <div className="absolute top-[-10%] left-[-10%] w-[30%] h-[30%] rounded-full bg-[var(--primary)]/10 blur-[60px]" />
        <div className="absolute bottom-[-10%] right-[-10%] w-[30%] h-[30%] rounded-full bg-[var(--accent)]/10 blur-[60px]" />
      </div>

      {/* Loader — single CSS spinner instead of 2 framer-motion infinite rotations */}
      <div className="relative">
        <div className="w-24 h-24 rounded-full border-2 border-t-[var(--primary)] border-r-transparent border-b-transparent border-l-transparent animate-spin" />
        
        {/* Central Logo Letter */}
        <div className="absolute inset-0 flex items-center justify-center">
          <span className="text-3xl font-bold text-white tracking-tighter">N</span>
        </div>
      </div>

      {/* Loading Text — simple fade-in, no infinite animations */}
      <motion.div 
        initial={{ opacity: 0, y: 10 }}
        animate={{ opacity: 1, y: 0 }}
        className="mt-10 text-center"
      >
        <p className="text-[var(--text-main)] font-medium tracking-[0.2em] uppercase text-xs mb-3">
          ELMA Core
        </p>
        <div className="flex gap-1.5 justify-center">
          {[0, 1, 2].map((i) => (
            <div
              key={i}
              className="w-1.5 h-1.5 rounded-full bg-[var(--primary-light)] animate-pulse"
              style={{ animationDelay: `${i * 200}ms` }}
            />
          ))}
        </div>
      </motion.div>
      
      {/* Progress Line */}
      <div className="absolute bottom-0 left-0 w-full h-[1px] bg-white/5">
        <motion.div 
          initial={{ width: "0%" }}
          animate={{ width: "100%" }}
          transition={{ duration: 1.5, ease: "easeInOut" }}
          className="h-full bg-gradient-to-r from-transparent via-[var(--primary)] to-transparent"
        />
      </div>
    </div>
  );
}
