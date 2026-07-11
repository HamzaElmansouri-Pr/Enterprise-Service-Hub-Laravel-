"use client";

import { useState, useEffect, useCallback } from "react";
import { motion, AnimatePresence, useScroll, useTransform } from "framer-motion";
import { getOptimizedImageUrl } from "@/lib/cloudinary";
import Link from "next/link";
import type { Slider } from "@/lib/types";

interface HeroSliderProps {
  sliders: Slider[];
  cms: {
    heroTitle: string | null;
    heroSubtitle: string | null;
    heroButtonText: string | null;
    heroImage: string | null;
  };
}

export function HeroSlider({ sliders, cms }: HeroSliderProps) {
  const [current, setCurrent] = useState(0);
  const items = sliders.length > 0 ? sliders : null;
  
  const { scrollY } = useScroll();
  const y1 = useTransform(scrollY, [0, 1000], [0, 300]);
  const y2 = useTransform(scrollY, [0, 1000], [0, -200]);
  const opacity = useTransform(scrollY, [0, 500], [1, 0]);

  const next = useCallback(() => {
    if (items) setCurrent((prev) => (prev + 1) % items.length);
  }, [items]);

  useEffect(() => {
    if (!items || items.length <= 1) return;
    const timer = setInterval(next, 7000);
    return () => clearInterval(timer);
  }, [next, items]);

  const slide = items?.[current];
  
  // Optimized hero background image
  const heroImgUrl = slide?.image || cms.heroImage || "/placeholder-hero.jpg";
  const optimizedHeroImg = getOptimizedImageUrl(heroImgUrl, { width: 1920, quality: 'auto', format: 'auto' });

  return (
    <section className="relative h-screen min-h-[800px] flex items-center justify-center overflow-hidden bg-[var(--bg-abyss)]">
      {/* Background Image & Overlay */}
      <AnimatePresence mode="wait">
        <motion.div
          key={current}
          initial={{ opacity: 0, scale: 1.05 }}
          animate={{ opacity: 1, scale: 1 }}
          exit={{ opacity: 0, transition: { duration: 0.8 } }}
          transition={{ duration: 1.5, ease: "easeOut" }}
          className="absolute inset-0"
        >
          <div
            className="absolute inset-0 bg-cover bg-center"
            style={{
              backgroundImage: `url(${optimizedHeroImg})`,
            }}
          />
          {/* Elite Gradient Overlay */}
          <div className="absolute inset-0 bg-gradient-to-b from-[var(--bg-abyss)]/60 via-[var(--bg-abyss)]/80 to-[var(--bg-abyss)]" />
        </motion.div>
      </AnimatePresence>

      {/* Animated Glowing Orbs */}
      <motion.div style={{ y: y1 }} className="absolute top-1/4 left-1/4 w-[40vw] h-[40vw] rounded-full bg-[var(--primary)]/10 blur-[120px] mix-blend-screen pointer-events-none" />
      <motion.div style={{ y: y2 }} className="absolute bottom-1/4 right-1/4 w-[30vw] h-[30vw] rounded-full bg-[var(--accent)]/10 blur-[100px] mix-blend-screen pointer-events-none" />

      {/* Content */}
      <motion.div style={{ opacity }} className="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-20">
        <AnimatePresence mode="wait">
          <motion.div
            key={current}
            initial={{ opacity: 0, y: 40 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -20, transition: { duration: 0.4 } }}
            transition={{ duration: 0.8, ease: [0.16, 1, 0.3, 1] }}
            className={`max-w-4xl ${
              slide?.alignment === "center" ? "mx-auto text-center" : slide?.alignment === "right" ? "ml-auto text-right" : ""
            }`}
          >
            {/* Elite Badge */}
            {(slide?.badge_text || cms.heroSubtitle) && (
              <motion.div
                initial={{ opacity: 0, scale: 0.9 }}
                animate={{ opacity: 1, scale: 1 }}
                transition={{ delay: 0.3, duration: 0.5 }}
                className="inline-flex items-center gap-3 px-5 py-2.5 rounded-full elite-glass mb-8"
              >
                <span className="relative flex h-3 w-3">
                  <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-[var(--primary-light)] opacity-75" />
                  <span className="relative inline-flex rounded-full h-3 w-3 bg-[var(--primary)]" />
                </span>
                <span className="text-[var(--text-main)] text-sm font-medium tracking-wide uppercase">
                  {slide?.badge_text || cms.heroSubtitle}
                </span>
              </motion.div>
            )}

            {/* Typography */}
            <h1 className="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-extrabold tracking-tight leading-[1.1] mb-8">
              <span className="text-transparent bg-clip-text bg-gradient-to-b from-white to-white/70">
                {slide?.title || cms.heroTitle || "Next Generation"}
              </span>
            </h1>

            {/* Description */}
            {slide?.description && (
              <p className="text-lg sm:text-xl md:text-2xl text-[var(--text-muted)] leading-relaxed mb-10 max-w-2xl font-light">
                {slide.description}
              </p>
            )}

            {/* Elite Actions */}
            <div className={`flex flex-wrap gap-6 ${slide?.alignment === "center" ? "justify-center" : slide?.alignment === "right" ? "justify-end" : ""}`}>
              <div className="animated-border p-[1px]">
                <Link
                  href={slide?.button_url || "/services"}
                  className="relative flex items-center justify-center gap-3 px-8 py-4 bg-[var(--bg-deep)] hover:bg-[var(--primary)]/10 text-white rounded-[15px] font-semibold transition-all duration-300 group"
                >
                  <span className="relative z-10">{slide?.button_text || cms.heroButtonText || "Get Started"}</span>
                  <svg className="w-5 h-5 relative z-10 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                  </svg>
                </Link>
              </div>

              {slide?.secondary_button_text && (
                <Link
                  href={slide.secondary_button_url || "/contact"}
                  className="inline-flex items-center justify-center px-8 py-4 rounded-2xl border border-white/10 hover:border-white/30 text-white font-medium hover:bg-white/5 transition-all duration-300"
                >
                  {slide.secondary_button_text}
                </Link>
              )}
            </div>
          </motion.div>
        </AnimatePresence>
      </motion.div>

      {/* Elite Slider Controls */}
      {items && items.length > 1 && (
        <div className="absolute bottom-12 right-12 flex gap-3 z-20">
          {items.map((_, i) => (
            <button
              key={i}
              onClick={() => setCurrent(i)}
              className={`relative h-1.5 rounded-full transition-all duration-500 overflow-hidden ${
                i === current ? "w-16 bg-white/20" : "w-8 bg-white/10 hover:bg-white/30"
              }`}
              aria-label={`Go to slide ${i + 1}`}
            >
              {i === current && (
                <motion.div
                  className="absolute inset-y-0 left-0 bg-[var(--primary-light)]"
                  initial={{ width: "0%" }}
                  animate={{ width: "100%" }}
                  transition={{ duration: 7, ease: "linear" }}
                />
              )}
            </button>
          ))}
        </div>
      )}
    </section>
  );
}
