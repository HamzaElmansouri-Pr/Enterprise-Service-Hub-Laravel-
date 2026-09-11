"use client";

import { useState, useEffect } from "react";
import { motion, AnimatePresence } from "framer-motion";
import Image from "next/image";
import type { Review } from "@/lib/types";

interface TestimonialsProps {
  reviews: Review[];
  title: string | null;
  subtitle: string | null;
}

export function Testimonials({ reviews, title, subtitle }: TestimonialsProps) {
  const [active, setActive] = useState(0);
  useEffect(() => {
    if (reviews.length <= 1) return;
    const timer = setInterval(() => {
      setActive((prev) => (prev + 1) % reviews.length);
    }, 8000);
    return () => clearInterval(timer);
  }, [reviews.length]);

  if (reviews.length === 0) return null;

  return (
    <section className="section-padding bg-[var(--bg-abyss)] relative overflow-hidden">
      {/* Decorative Elite Orbs */}
      <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-gradient-to-r from-[var(--primary)]/5 to-[var(--accent)]/5 blur-[80px] mix-blend-screen pointer-events-none" />
      
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <motion.div initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }} transition={{ duration: 0.6 }} className="text-center mb-20">
          {subtitle && (
            <span className="inline-flex items-center gap-2 px-4 py-2 rounded-full elite-glass text-[var(--accent)] text-sm font-medium mb-6">
              <span className="w-1.5 h-1.5 rounded-full bg-[var(--accent)] animate-pulse" />
              {subtitle}
            </span>
          )}
          <h2 className="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-b from-white to-white/60 tracking-tight">
            {title || "Client Success"}
          </h2>
        </motion.div>

        <div className="relative">
          {/* Main Card */}
          <div className="relative elite-glass rounded-[32px] p-8 sm:p-16 border border-white/5 overflow-hidden">
            {/* Background Glow */}
            <div className="absolute inset-0 bg-gradient-to-br from-[var(--primary)]/10 to-transparent opacity-50" />
            
            {/* Quote Icon */}
            <div className="absolute -top-6 -left-6 sm:top-12 sm:left-12 w-24 h-24 sm:w-32 sm:h-32 text-[var(--primary)]/10 opacity-50 pointer-events-none">
              <svg fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" /></svg>
            </div>

            <AnimatePresence mode="wait">
              <motion.div 
                key={active} 
                initial={{ opacity: 0, y: 20 }} 
                animate={{ opacity: 1, y: 0 }} 
                exit={{ opacity: 0, y: -20 }} 
                transition={{ duration: 0.4, ease: [0.16, 1, 0.3, 1] }}
                className="relative z-10 flex flex-col items-center text-center"
              >
                {/* Rating */}
                <div className="flex gap-1.5 mb-8">
                  {Array.from({ length: 5 }, (_, i) => (
                    <svg key={i} className={`w-6 h-6 ${i < (reviews[active].rating || 5) ? "text-[var(--accent)] drop-shadow-[0_0_8px_rgba(20,184,166,0.5)]" : "text-white/10"}`} fill="currentColor" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                  ))}
                </div>

                {/* Review Text */}
                <p className="text-xl sm:text-2xl md:text-3xl text-white font-light leading-relaxed mb-12 max-w-4xl mx-auto">
                  &quot;{reviews[active].review_text}&quot;
                </p>

                {/* Client Info */}
                <div className="flex flex-col items-center gap-4">
                  <div className="w-16 h-16 rounded-full bg-gradient-to-br from-[var(--primary)] to-[var(--accent)] p-[2px] shadow-[0_0_20px_rgba(59,130,246,0.3)]">
                    <div className="w-full h-full rounded-full overflow-hidden bg-[var(--bg-deep)] relative">
                      {reviews[active].client_image ? (
                        <Image 
                          src={reviews[active].client_image} 
                          alt={reviews[active].client_name} 
                          fill 
                          sizes="64px" 
                          className="object-cover" 
                          unoptimized={reviews[active].client_image.includes('localhost') || reviews[active].client_image.includes('127.0.0.1')}
                        />
                      ) : (
                        <div className="w-full h-full flex items-center justify-center text-white font-bold text-xl">
                          {reviews[active].client_name?.[0] || "?"}
                        </div>
                      )}
                    </div>
                  </div>
                  <div>
                    <h4 className="text-white font-bold text-lg">{reviews[active].client_name}</h4>
                    <p className="text-[var(--primary-light)] text-sm font-medium">{reviews[active].client_position}{reviews[active].client_company && ` @ ${reviews[active].client_company}`}</p>
                  </div>
                </div>
              </motion.div>
            </AnimatePresence>
          </div>

          {/* Elite Slider Controls */}
          {reviews.length > 1 && (
            <div className="flex justify-center gap-3 mt-12">
              {reviews.map((_, i) => (
                <button 
                  key={i} 
                  onClick={() => setActive(i)} 
                  className={`relative h-1.5 rounded-full transition-all duration-500 overflow-hidden ${i === active ? "w-16 bg-white/20" : "w-8 bg-white/10 hover:bg-white/30"}`} 
                  aria-label={`View testimonial ${i + 1}`}
                >
                  {i === active && (
                    <motion.div
                      className="absolute inset-y-0 left-0 bg-[var(--primary-light)]"
                      initial={{ width: "0%" }}
                      animate={{ width: "100%" }}
                      transition={{ duration: 8, ease: "linear" }}
                    />
                  )}
                </button>
              ))}
            </div>
          )}
        </div>
      </div>
    </section>
  );
}
