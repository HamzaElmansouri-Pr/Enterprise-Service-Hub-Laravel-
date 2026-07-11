"use client";

import { motion } from "framer-motion";

export default function Loading() {
  return (
    <div className="fixed inset-0 z-[100] bg-[var(--bg-abyss)] flex flex-col items-center justify-center overflow-hidden">
      {/* Dynamic Background Elements */}
      <div className="absolute top-0 left-0 w-full h-full pointer-events-none">
        <div className="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-[var(--primary)]/10 blur-[120px] animate-pulse" />
        <div className="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-[var(--accent)]/10 blur-[120px] animate-pulse" style={{ animationDelay: '1s' }} />
      </div>

      {/* Elite Loader Core */}
      <div className="relative">
        {/* Rotating Outer Rings */}
        <motion.div
          animate={{ rotate: 360 }}
          transition={{ duration: 3, repeat: Infinity, ease: "linear" }}
          className="w-32 h-32 rounded-full border-2 border-t-[var(--primary)] border-r-transparent border-b-transparent border-l-transparent"
        />
        <motion.div
          animate={{ rotate: -360 }}
          transition={{ duration: 2, repeat: Infinity, ease: "linear" }}
          className="absolute inset-2 rounded-full border-2 border-r-[var(--accent)] border-t-transparent border-b-transparent border-l-transparent"
        />
        
        {/* Central Logo Letter */}
        <div className="absolute inset-0 flex items-center justify-center">
          <motion.div
            animate={{ 
              scale: [1, 1.2, 1],
              opacity: [0.5, 1, 0.5]
            }}
            transition={{ duration: 2, repeat: Infinity, ease: "easeInOut" }}
            className="text-4xl font-bold text-white tracking-tighter"
          >
            N
          </motion.div>
        </div>
      </div>

      {/* Loading Text */}
      <motion.div 
        initial={{ opacity: 0, y: 10 }}
        animate={{ opacity: 1, y: 0 }}
        className="mt-12 text-center"
      >
        <p className="text-[var(--text-main)] font-medium tracking-[0.2em] uppercase text-xs mb-2">
          Nova Agency
        </p>
        <div className="flex gap-1 justify-center">
          {[0, 1, 2].map((i) => (
            <motion.div
              key={i}
              animate={{ 
                scale: [1, 1.5, 1],
                opacity: [0.3, 1, 0.3]
              }}
              transition={{ 
                duration: 1, 
                repeat: Infinity, 
                delay: i * 0.2 
              }}
              className="w-1.5 h-1.5 rounded-full bg-[var(--primary-light)]"
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
