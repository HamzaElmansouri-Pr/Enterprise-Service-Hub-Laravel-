"use client";

import { motion } from "framer-motion";
import Link from "next/link";
import MagneticButton from "@/components/ui/MagneticButton";

interface CTASectionProps {
  cta: { title: string; subtitle: string; description: string; button_text: string } | null;
}

export function CTASection({ cta }: CTASectionProps) {
  if (!cta) return null;

  return (
    <section className="section-padding bg-[var(--bg-abyss)] relative overflow-hidden">
      {/* Decorative Elite Background */}
      <div className="absolute inset-0 bg-gradient-to-br from-[var(--bg-deep)] to-[var(--bg-abyss)]" />
      <div className="absolute inset-0 bg-[url('/noise.png')] opacity-[0.03] mix-blend-overlay" />
      
      {/* Elite Orbs */}
      <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] rounded-full bg-[var(--primary)]/10 blur-[150px] mix-blend-screen pointer-events-none" />
      
      <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <motion.div 
          initial={{ opacity: 0, y: 40, scale: 0.95 }} 
          whileInView={{ opacity: 1, y: 0, scale: 1 }} 
          viewport={{ once: true, margin: "-100px" }}
          transition={{ duration: 0.8, ease: [0.16, 1, 0.3, 1] }}
          className="relative rounded-[40px] elite-glass p-12 md:p-20 border border-white/10 text-center overflow-hidden"
        >
          {/* Subtle inside glow */}
          <div className="absolute inset-0 bg-gradient-to-b from-white/[0.05] to-transparent pointer-events-none" />
          <div className="absolute -top-40 -right-40 w-80 h-80 bg-[var(--accent)]/20 rounded-full blur-[100px] pointer-events-none" />
          <div className="absolute -bottom-40 -left-40 w-80 h-80 bg-[var(--primary)]/20 rounded-full blur-[100px] pointer-events-none" />

          <div className="relative z-10 max-w-3xl mx-auto">
            <span className="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/5 border border-white/10 text-[var(--primary-light)] text-sm font-medium tracking-widest uppercase mb-8 shadow-xl backdrop-blur-md">
              <span className="w-2 h-2 rounded-full bg-[var(--primary-light)] animate-pulse" />
              {cta.subtitle}
            </span>
            
            <h2 className="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-b from-white to-white/70 mb-8 tracking-tight leading-[1.1]">
              {cta.title}
            </h2>
            
            <p className="text-xl sm:text-2xl text-[var(--text-muted)] font-light leading-relaxed mb-12">
              {cta.description}
            </p>
            
            <div className="flex justify-center">
              <div className="animated-border p-[1px] inline-block">
                <MagneticButton intensity={0.4}>
                  <Link 
                    href="/contact" 
                    className="relative flex items-center justify-center gap-3 px-10 py-5 bg-[var(--bg-deep)] hover:bg-[var(--primary)]/20 text-white rounded-[20px] font-bold text-lg transition-all duration-500 group shadow-2xl"
                  >
                    <span className="relative z-10">{cta.button_text}</span>
                    <svg className="w-6 h-6 relative z-10 transform group-hover:translate-x-1.5 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                  </Link>
                </MagneticButton>
              </div>
            </div>
          </div>
        </motion.div>
      </div>
    </section>
  );
}
