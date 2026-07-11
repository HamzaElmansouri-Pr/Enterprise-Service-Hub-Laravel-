"use client";

import { motion } from "framer-motion";
import Link from "next/link";

interface BreadcrumbProps {
  title: string;
  image?: string | null;
  items?: { label: string; href?: string }[];
}

export function Breadcrumb({ title, image, items = [] }: BreadcrumbProps) {
  return (
    <section className="relative pt-40 pb-24 overflow-hidden border-b border-white/5 bg-[var(--bg-abyss)]">
      {/* Background with elite gradient mask */}
      {image && (
        <div className="absolute inset-0 z-0">
          <div className="absolute inset-0 bg-cover bg-center opacity-30" style={{ backgroundImage: `url(${image})` }} />
          <div className="absolute inset-0 bg-gradient-to-b from-[var(--bg-abyss)]/80 via-[var(--bg-abyss)]/90 to-[var(--bg-abyss)]" />
        </div>
      )}
      
      {!image && (
        <div className="absolute inset-0 bg-gradient-to-b from-[var(--bg-deep)] to-[var(--bg-abyss)] z-0" />
      )}

      {/* Decorative Elite Orbs */}
      <div className="absolute -top-20 -right-20 w-[600px] h-[600px] rounded-full bg-[var(--primary)]/10 blur-[150px] mix-blend-screen pointer-events-none z-0" />
      <div className="absolute bottom-0 -left-20 w-[400px] h-[400px] rounded-full bg-[var(--accent)]/5 blur-[150px] mix-blend-screen pointer-events-none z-0" />

      <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10 text-center">
        <motion.div 
          initial={{ opacity: 0, y: 30 }} 
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, ease: [0.16, 1, 0.3, 1] }}
          className="flex flex-col items-center"
        >
          {/* Breadcrumb Navigation - Elite Pill */}
          <nav className="inline-flex items-center gap-2 px-5 py-2.5 rounded-full elite-glass border border-white/10 text-sm mb-8 shadow-xl backdrop-blur-md">
            <Link href="/" className="text-[var(--text-muted)] hover:text-white transition-colors flex items-center gap-2">
              <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
              {typeof document !== 'undefined' && document.cookie.includes('NEXT_LOCALE=ar') ? 'الرئيسية' : (typeof document !== 'undefined' && document.cookie.includes('NEXT_LOCALE=fr') ? 'Accueil' : 'Home')}
            </Link>
            {items.map((item, i) => (
              <span key={i} className="flex items-center gap-2">
                <span className="text-white/20">/</span>
                {item.href ? (
                  <Link href={item.href} className="text-[var(--text-muted)] hover:text-white transition-colors">
                    {item.label}
                  </Link>
                ) : (
                  <span className="text-[var(--primary-light)] font-medium">
                    {item.label}
                  </span>
                )}
              </span>
            ))}
          </nav>

          {/* Page Title */}
          <h1 className="text-5xl sm:text-6xl md:text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-b from-white to-white/70 tracking-tight">
            {title}
          </h1>
          
          {/* Decorative bottom line */}
          <motion.div 
            initial={{ width: 0, opacity: 0 }}
            animate={{ width: "100px", opacity: 1 }}
            transition={{ delay: 0.3, duration: 0.8, ease: "easeOut" }}
            className="h-1 bg-gradient-to-r from-transparent via-[var(--primary)] to-transparent mt-10"
          />
        </motion.div>
      </div>
    </section>
  );
}
