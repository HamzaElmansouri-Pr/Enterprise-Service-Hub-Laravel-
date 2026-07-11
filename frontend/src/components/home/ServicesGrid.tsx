"use client";

import { motion } from "framer-motion";
import Link from "next/link";
import { getOptimizedImageUrl } from "@/lib/cloudinary";
import type { Service } from "@/lib/types";

interface ServicesGridProps {
  services: Service[];
  title: string | null;
  subtitle: string | null;
}

const serviceIcons: Record<string, string> = {
  default: "⚡",
  web: "🌐",
  mobile: "📱",
  cloud: "☁️",
  security: "🔒",
  consulting: "💡",
  data: "📊",
  design: "🎨",
};

function getIcon(icon: string | null) {
  if (!icon) return serviceIcons.default;
  if (icon.length <= 4) return icon;
  if (icon.includes("setting")) return "⚙️";
  if (icon.includes("web") || icon.includes("globe")) return "🌐";
  if (icon.includes("cloud")) return "☁️";
  if (icon.includes("shield") || icon.includes("security")) return "🔒";
  if (icon.includes("code")) return "💻";
  if (icon.includes("chart") || icon.includes("data")) return "📊";
  if (icon.includes("design") || icon.includes("paint")) return "🎨";
  if (icon.includes("mobile") || icon.includes("phone")) return "📱";
  return serviceIcons.default;
}

export function ServicesGrid({ services, title, subtitle }: ServicesGridProps) {
  return (
    <section className="section-padding bg-[var(--bg-abyss)] relative overflow-hidden">
      {/* Decorative Orbs */}
      <div className="absolute top-0 right-0 w-[500px] h-[500px] rounded-full bg-[var(--primary)]/5 blur-[150px] mix-blend-screen pointer-events-none" />
      <div className="absolute bottom-0 left-0 w-[600px] h-[600px] rounded-full bg-[var(--accent)]/5 blur-[150px] mix-blend-screen pointer-events-none" />

      <div className="max-w-7xl mx-auto relative z-10">
        {/* Header */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true, margin: "-100px" }}
          transition={{ duration: 0.6, ease: [0.16, 1, 0.3, 1] }}
          className="text-center mb-20"
        >
          {subtitle && (
            <span className="inline-flex items-center gap-2 px-4 py-2 rounded-full elite-glass text-[var(--primary-light)] text-sm font-medium mb-6">
              <span className="w-1.5 h-1.5 rounded-full bg-[var(--primary-light)] animate-pulse" />
              {subtitle}
            </span>
          )}
          <h2 className="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-b from-white to-white/60 tracking-tight">
            {title || "Our Expertise"}
          </h2>
        </motion.div>

        {/* Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {services.map((service, i) => (
            <motion.div
              key={service.id}
              initial={{ opacity: 0, y: 40 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true, margin: "-50px" }}
              transition={{ duration: 0.7, delay: i * 0.1, ease: [0.16, 1, 0.3, 1] }}
            >
              <Link
                href={`/services/${service.slug}`}
                className="group relative block h-full outline-none"
              >
                {/* Glow Behind Card */}
                <div className="absolute inset-0 bg-gradient-to-br from-[var(--primary)]/20 to-[var(--accent)]/20 rounded-[24px] blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500" />
                
                {/* Elite Glass Card */}
                <div className="relative h-full p-8 rounded-[24px] elite-glass border border-white/5 group-hover:border-white/10 transition-all duration-500 overflow-hidden">
                  
                  {/* Subtle Hover Gradient Inside */}
                  <div className="absolute inset-0 bg-gradient-to-br from-white/[0.03] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500" />

                  {/* Icon */}
                  <div className="relative w-16 h-16 rounded-2xl bg-[var(--bg-deep)] border border-white/10 flex items-center justify-center text-3xl mb-8 group-hover:scale-110 group-hover:border-[var(--primary)]/30 transition-all duration-500 shadow-xl">
                    <div className="absolute inset-0 bg-[var(--primary)]/10 rounded-2xl blur-md opacity-0 group-hover:opacity-100 transition-opacity duration-500" />
                    <span className="relative z-10 drop-shadow-lg">
                      {service.image ? (
                        <img src={getOptimizedImageUrl(service.image, { width: 64, height: 64, crop: 'fit' })} alt="" className="w-8 h-8 object-contain" />
                      ) : (
                        getIcon(service.icon)
                      )}
                    </span>
                  </div>

                  {/* Content */}
                  <h3 className="text-2xl font-bold text-white mb-4 group-hover:text-[var(--primary-light)] transition-colors duration-300 tracking-tight">
                    {service.title}
                  </h3>
                  
                  {service.subtitle && (
                    <p
                      className="text-[var(--text-muted)] text-base leading-relaxed line-clamp-3 mb-8"
                      dangerouslySetInnerHTML={{ __html: service.subtitle }}
                    />
                  )}

                  {/* Floating Arrow */}
                  <div className="absolute bottom-8 right-8 w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white group-hover:bg-[var(--primary)] group-hover:border-[var(--primary)] group-hover:text-white transition-all duration-300 transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 shadow-[0_0_20px_rgba(0,0,0,0.5)]">
                    <svg className="w-4 h-4 transform -rotate-45 group-hover:rotate-0 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                  </div>
                </div>
              </Link>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
}
