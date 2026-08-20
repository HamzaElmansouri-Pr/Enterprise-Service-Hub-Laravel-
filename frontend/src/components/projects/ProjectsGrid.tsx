"use client";

import { motion } from "framer-motion";
import Image from "next/image";
import Link from "next/link";
import { useRouter } from "next/navigation";
import TiltCard from "@/components/ui/TiltCard";
import type { Project } from "@/lib/types";

interface ProjectsGridProps {
  projects: Project[];
  categories: string[];
  activeCategory?: string;
}

export function ProjectsGrid({ projects, categories, activeCategory }: ProjectsGridProps) {
  const router = useRouter();

  return (
    <section className="section-padding bg-[var(--bg-dark)]">
      <div className="max-w-7xl mx-auto">
        {/* Category filter */}
        {categories.length > 0 && (
          <div className="flex flex-wrap gap-2 mb-12 justify-center">
            <button onClick={() => router.push("/projects")} className={`px-5 py-2 rounded-full text-sm font-medium transition-all ${!activeCategory ? "bg-[var(--primary)] text-white" : "bg-white/5 text-[var(--text-secondary)] hover:bg-white/10 hover:text-white"}`}>All</button>
            {categories.map((cat) => (
              <button key={cat} onClick={() => router.push(`/projects?category=${cat}`)} className={`px-5 py-2 rounded-full text-sm font-medium transition-all ${activeCategory === cat ? "bg-[var(--primary)] text-white" : "bg-white/5 text-[var(--text-secondary)] hover:bg-white/10 hover:text-white"}`}>{cat}</button>
            ))}
          </div>
        )}

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {projects.map((project, i) => (
            <motion.div key={project.id} initial={{ opacity: 0, y: 30 }} animate={{ opacity: 1, y: 0 }} transition={{ delay: i * 0.05 }}>
              <TiltCard>
                <Link href={`/projects/${project.slug}`} className="group block rounded-2xl overflow-hidden bg-[var(--bg-card)] hover:shadow-[var(--shadow-hover)] transition-all duration-300">
                  <div className="relative h-56 overflow-hidden">
                    {project.image ? <Image src={project.image} alt={project.title} fill sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw" className="object-cover group-hover:scale-110 transition-transform duration-500" /> : <div className="w-full h-full bg-gradient-to-br from-[var(--primary)]/20 to-[var(--accent)]/10 flex items-center justify-center"><span className="text-5xl opacity-30">📁</span></div>}
                    {project.category && <span className="absolute top-4 left-4 px-3 py-1 rounded-full bg-[var(--primary)]/80 text-white text-xs font-medium backdrop-blur-sm">{project.category}</span>}
                  </div>
                  <div className="p-6">
                    <h3 className="text-lg font-bold text-white mb-2 group-hover:text-[var(--primary-light)] transition-colors">{project.title}</h3>
                    {project.client && <p className="text-[var(--text-muted)] text-sm">Client: {project.client}</p>}
                  </div>
                </Link>
              </TiltCard>
            </motion.div>
          ))}
        </div>

        {projects.length === 0 && (
          <div className="text-center py-20">
            <p className="text-[var(--text-muted)] text-lg">No projects found.</p>
          </div>
        )}
      </div>
    </section>
  );
}
