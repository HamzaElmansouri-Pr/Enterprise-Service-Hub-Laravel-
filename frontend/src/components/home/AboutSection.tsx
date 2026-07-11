"use client";

import { motion } from "framer-motion";
import Image from "next/image";
import { getOptimizedImageUrl } from "@/lib/cloudinary";
import AnimatedCounter from "@/components/ui/AnimatedCounter";

interface AboutSectionProps {
  about: { title: string; subtitle: string; description: string; image: string; meta_data?: { features: string[] } } | null;
}

export function AboutSection({ about }: AboutSectionProps) {
  if (!about) return null;

  // Optimized image URL for the about section
  const optimizedImage = getOptimizedImageUrl(about.image, { width: 800, height: 1000, crop: 'fill' });

  return (
    <section className="section-padding bg-[var(--bg-abyss)] relative overflow-hidden">
      {/* Decorative Elite Orbs */}
      <div className="absolute top-0 left-0 w-[500px] h-[500px] rounded-full bg-[var(--primary)]/5 blur-[150px] mix-blend-screen pointer-events-none" />
      <div className="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-[var(--accent)]/5 blur-[150px] mix-blend-screen pointer-events-none" />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 xl:gap-24 items-center">
          {/* Image Side */}
          <motion.div 
            initial={{ opacity: 0, x: -40 }} 
            whileInView={{ opacity: 1, x: 0 }} 
            viewport={{ once: true, margin: "-100px" }}
            transition={{ duration: 0.8, ease: [0.16, 1, 0.3, 1] }}
            className="relative"
          >
            {/* Elite Image Frame */}
            <div className="relative rounded-[32px] overflow-hidden aspect-[4/5] sm:aspect-square lg:aspect-[4/5] elite-glass p-2 border border-white/5 shadow-2xl">
              <div className="relative w-full h-full rounded-[24px] overflow-hidden bg-[var(--bg-deep)]">
                <Image 
                  src={optimizedImage} 
                  alt="About Us" 
                  fill
                  className="object-cover opacity-90 hover:opacity-100 hover:scale-105 transition-all duration-700"
                  sizes="(max-width: 768px) 100vw, 50vw"
                  priority
                />
                <div className="absolute inset-0 bg-gradient-to-t from-[var(--bg-abyss)] via-transparent to-transparent opacity-80" />
              </div>
            </div>

            {/* Floating Experience Badge */}
            <motion.div 
              animate={{ y: [-10, 10, -10] }} 
              transition={{ repeat: Infinity, duration: 4, ease: "easeInOut" }}
              className="absolute -bottom-8 -right-8 sm:-bottom-12 sm:-right-12 w-40 h-40 rounded-[32px] bg-gradient-to-br from-[var(--primary)] to-[var(--accent)] p-[1px] shadow-[0_0_30px_rgba(59,130,246,0.3)] z-20"
            >
              <div className="w-full h-full rounded-[31px] bg-[var(--bg-deep)] flex flex-col items-center justify-center relative overflow-hidden">
                <div className="absolute inset-0 bg-gradient-to-br from-[var(--primary)]/20 to-[var(--accent)]/20" />
                <span className="relative z-10 block text-4xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-b from-white to-white/70 mb-1">
                  <AnimatedCounter value={10} />+
                </span>
                <span className="relative z-10 text-[var(--primary-light)] text-sm font-semibold tracking-wider uppercase">Years</span>
              </div>
            </motion.div>
          </motion.div>

          {/* Content Side */}
          <motion.div 
            initial={{ opacity: 0, x: 40 }} 
            whileInView={{ opacity: 1, x: 0 }} 
            viewport={{ once: true, margin: "-100px" }}
            transition={{ duration: 0.8, delay: 0.2, ease: [0.16, 1, 0.3, 1] }}
          >
            <span className="inline-flex items-center gap-2 px-4 py-2 rounded-full elite-glass text-[var(--accent)] text-sm font-medium mb-6">
              <span className="w-1.5 h-1.5 rounded-full bg-[var(--accent)] animate-pulse" />
              {about.subtitle}
            </span>
            
            <h2 className="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-b from-white to-white/60 tracking-tight leading-[1.1] mb-8">
              {about.title}
            </h2>
            
            <p className="text-lg sm:text-xl text-[var(--text-secondary)] leading-relaxed mb-10 font-light max-w-2xl">
              {about.description}
            </p>

            {/* Features List */}
            {about.meta_data?.features && about.meta_data.features.length > 0 && (
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-8 pt-8 border-t border-white/5">
                {about.meta_data.features.map((feature: string | { title: string; description?: string }, i: number) => (
                  <div key={i} className="flex gap-4 group">
                    <div className="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center flex-shrink-0 group-hover:bg-[var(--primary)]/20 group-hover:border-[var(--primary)]/30 transition-all duration-300">
                      <svg className="w-5 h-5 text-[var(--primary-light)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M5 13l4 4L19 7" />
                      </svg>
                    </div>
                    <div className="flex flex-col justify-center">
                      <h4 className="text-white font-semibold text-base mb-1">{typeof feature === 'string' ? feature : feature.title}</h4>
                      {typeof feature !== 'string' && feature.description && (
                        <p className="text-[var(--text-muted)] text-sm leading-relaxed">{feature.description}</p>
                      )}
                    </div>
                  </div>
                ))}
              </div>
            )}
          </motion.div>
        </div>
      </div>
    </section>
  );
}
