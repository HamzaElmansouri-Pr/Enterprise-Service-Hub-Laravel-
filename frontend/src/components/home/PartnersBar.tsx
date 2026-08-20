"use client";

import { motion } from "framer-motion";
import Image from "next/image";
import type { Partner } from "@/lib/types";

interface PartnersBarProps {
  partners: Partner[];
}

export function PartnersBar({ partners }: PartnersBarProps) {
  if (partners.length === 0) return null;

  // Duplicate partners for infinite scroll effect if there are too few
  const scrollItems = [...partners, ...partners, ...partners];

  return (
    <section className="py-20 bg-[var(--bg-darker)] relative overflow-hidden border-y border-white/5">
      {/* Background glow */}
      <div className="absolute inset-0 bg-gradient-to-r from-[var(--bg-darker)] via-[var(--primary)]/5 to-[var(--bg-darker)] opacity-50" />
      
      <div className="max-w-[100vw] mx-auto relative z-10">
        <motion.p 
          initial={{ opacity: 0, y: 10 }} 
          whileInView={{ opacity: 1, y: 0 }} 
          viewport={{ once: true }} 
          className="text-center text-[var(--text-muted)] text-sm font-semibold uppercase tracking-[0.2em] mb-12"
        >
          Trusted by Innovative Teams Worldwide
        </motion.p>
        
        {/* Infinite Marquee Container */}
        <div className="relative flex overflow-hidden">
          {/* Gradient Masks for smooth edge fading */}
          <div className="absolute top-0 bottom-0 left-0 w-32 bg-gradient-to-r from-[var(--bg-darker)] to-transparent z-10 pointer-events-none" />
          <div className="absolute top-0 bottom-0 right-0 w-32 bg-gradient-to-l from-[var(--bg-darker)] to-transparent z-10 pointer-events-none" />
          
          <motion.div 
            className="flex items-center gap-16 md:gap-24 whitespace-nowrap pl-16 md:pl-24"
            animate={{ x: ["0%", "-50%"] }}
            transition={{
              repeat: Infinity,
              ease: "linear",
              duration: 30,
            }}
          >
            {scrollItems.map((partner, i) => (
              <div key={`${partner.id}-${i}`} className="inline-flex items-center justify-center min-w-[150px]">
                {partner.url ? (
                  <a href={partner.url} target="_blank" rel="noopener noreferrer" className="block opacity-40 hover:opacity-100 hover:scale-110 transition-all duration-300 grayscale hover:grayscale-0 drop-shadow-[0_0_15px_rgba(255,255,255,0.1)]">
                    {partner.logo_url ? (
                      <Image src={partner.logo_url} alt={partner.name} width={120} height={48} className="h-12 w-auto object-contain" />
                    ) : (
                      <span className="text-[var(--text-secondary)] font-bold text-xl tracking-tight">{partner.name}</span>
                    )}
                  </a>
                ) : (
                  <div className="opacity-40 hover:opacity-100 hover:scale-110 transition-all duration-300 grayscale hover:grayscale-0 drop-shadow-[0_0_15px_rgba(255,255,255,0.1)]">
                    {partner.logo_url ? (
                      <Image src={partner.logo_url} alt={partner.name} width={120} height={48} className="h-12 w-auto object-contain" />
                    ) : (
                      <span className="text-[var(--text-secondary)] font-bold text-xl tracking-tight">{partner.name}</span>
                    )}
                  </div>
                )}
              </div>
            ))}
          </motion.div>
        </div>
      </div>
    </section>
  );
}
