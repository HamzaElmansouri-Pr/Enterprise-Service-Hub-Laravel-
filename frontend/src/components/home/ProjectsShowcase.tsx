"use client";

import { motion } from "framer-motion";
import Image from "next/image";
import Link from "next/link";
import type { Project } from "@/lib/types";

interface ProjectsShowcaseProps {
  projects: Project[];
  title: string | null;
  subtitle: string | null;
  viewAllText?: string;
}

export function ProjectsShowcase({ projects, title, subtitle, viewAllText = "View All Projects" }: ProjectsShowcaseProps) {
  if (!projects || projects.length === 0) {
    return (
      <section className="section-padding bg-[var(--bg-darker)] flex items-center justify-center min-h-[40vh]">
        <div className="text-center elite-glass p-12 rounded-3xl border border-white/5">
          <h2 className="text-3xl font-bold text-white mb-4">{title || "Featured Work"}</h2>
          <p className="text-[var(--text-muted)] text-lg">No projects to display yet. Check back later!</p>
        </div>
      </section>
    );
  }

  // Take up to 4 projects for the bento grid display
  const displayProjects = projects.slice(0, 4);

  return (
    <section className="section-padding bg-[var(--bg-darker)] relative">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true, margin: "-100px" }}
          transition={{ duration: 0.6, ease: [0.16, 1, 0.3, 1] }}
          className="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-16"
        >
          <div>
            {subtitle && (
              <span className="inline-flex items-center gap-2 px-4 py-2 rounded-full elite-glass text-[var(--accent)] text-sm font-medium mb-6">
                <span className="w-1.5 h-1.5 rounded-full bg-[var(--accent)] animate-pulse" />
                {subtitle}
              </span>
            )}
            <h2 className="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-b from-white to-white/60 tracking-tight">
              {title || "Featured Work"}
            </h2>
          </div>
          
          <Link
            href="/projects"
            className="hidden md:inline-flex items-center gap-3 px-6 py-3 rounded-full elite-glass border border-white/10 hover:border-white/30 text-white font-medium hover:bg-white/5 transition-all duration-300 group"
          >
            {viewAllText}
            <svg className="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
          </Link>
        </motion.div>

        {/* Bento Grid */}
        <div className="grid grid-cols-1 md:grid-cols-12 gap-6 auto-rows-[350px]">
          {displayProjects.map((project, i) => {
            // Asymmetrical grid mapping:
            // Item 1: Span 8 cols
            // Item 2: Span 4 cols
            // Item 3: Span 5 cols
            // Item 4: Span 7 cols
            const spanClass = 
              i === 0 ? "md:col-span-8" : 
              i === 1 ? "md:col-span-4" : 
              i === 2 ? "md:col-span-5" : 
              i === 3 ? "md:col-span-7" : "md:col-span-6";

            return (
              <motion.div
                key={project.id}
                initial={{ opacity: 0, scale: 0.95, y: 20 }}
                whileInView={{ opacity: 1, scale: 1, y: 0 }}
                viewport={{ once: true, margin: "-50px" }}
                transition={{ duration: 0.7, delay: i * 0.1, ease: [0.16, 1, 0.3, 1] }}
                className={`${spanClass} relative rounded-[24px] overflow-hidden group`}
              >
                <Link href={`/projects/${project.slug}`} className="block w-full h-full relative outline-none">
                  {/* Background Image */}
                  <div className="absolute inset-0">
                    {project.image ? (
                      <Image
                        src={project.image}
                        alt={project.title}
                        fill
                        sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw"
                        className="object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out"
                        unoptimized={project.image.includes('localhost') || project.image.includes('127.0.0.1')}
                      />
                    ) : (
                      <div className="w-full h-full bg-[var(--bg-deep)] flex items-center justify-center">
                        <span className="text-6xl opacity-20">📂</span>
                      </div>
                    )}
                  </div>

                  {/* Gradient Overlays */}
                  <div className="absolute inset-0 bg-gradient-to-t from-[var(--bg-abyss)]/90 via-[var(--bg-abyss)]/20 to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-500" />
                  <div className="absolute inset-0 bg-[var(--primary)]/20 mix-blend-overlay opacity-0 group-hover:opacity-100 transition-opacity duration-500" />

                  {/* Content (Bottom Left) */}
                  <div className="absolute inset-x-0 bottom-0 p-8 flex flex-col justify-end">
                    {project.category && (
                      <div className="mb-4">
                        <span className="inline-block px-3 py-1 rounded-lg bg-[var(--primary)] text-white text-xs font-bold tracking-wider uppercase shadow-lg">
                          {project.category}
                        </span>
                      </div>
                    )}
                    
                    <h3 className="text-2xl sm:text-3xl font-bold text-white mb-2 group-hover:text-[var(--primary-light)] transition-colors duration-300">
                      {project.title}
                    </h3>
                    
                    {project.description && (
                      <p className="text-[var(--text-secondary)] text-sm sm:text-base line-clamp-2 max-w-xl group-hover:text-white/90 transition-colors duration-300">
                        {project.description.replace(/<[^>]*>/g, '')}
                      </p>
                    )}
                  </div>

                  {/* Hover Arrow Icon */}
                  <div className="absolute top-8 right-8 w-12 h-12 rounded-full elite-glass flex items-center justify-center text-white opacity-0 transform translate-x-4 -translate-y-4 group-hover:opacity-100 group-hover:translate-x-0 group-hover:translate-y-0 transition-all duration-500 ease-out">
                    <svg className="w-5 h-5 transform -rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                  </div>
                </Link>
              </motion.div>
            );
          })}
        </div>

        {/* Mobile View All Button */}
        <div className="mt-10 text-center md:hidden">
          <Link
            href="/projects"
            className="inline-flex items-center justify-center w-full gap-2 px-8 py-4 rounded-xl bg-gradient-to-r from-[var(--primary)] to-[var(--primary-dark)] text-white font-semibold shadow-lg"
          >
            {viewAllText}
          </Link>
        </div>
      </div>
    </section>
  );
}
