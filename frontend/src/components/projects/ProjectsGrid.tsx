import Link from "next/link";
import { ProjectCardMedia } from "@/components/projects/ProjectCardMedia";
import type { Pagination, Project } from "@/lib/types";

type ProjectsGridProps = {
  projects: Project[];
  categories: string[];
  activeCategory?: string;
  search?: string;
  pagination: Pagination;
  labels: {
    all: string;
    viewProject: string;
    empty: string;
    previous: string;
    next: string;
    page: string;
    categoriesNavigation: string;
    paginationNavigation: string;
  };
};

function projectsUrl({ category, search, page }: { category?: string; search?: string; page?: number }) {
  const params = new URLSearchParams();

  if (category) params.set("category", category);
  if (search) params.set("search", search);
  if (page && page > 1) params.set("page", String(page));

  const query = params.toString();
  return query ? `/projects?${query}` : "/projects";
}

function summary(value: string | null) {
  return (value || "").replace(/<[^>]*>/g, " ").replace(/\s+/g, " ").trim();
}

export function ProjectsGrid({ projects, categories, activeCategory, search, pagination, labels }: ProjectsGridProps) {
  const hasMultiplePages = pagination.last_page > 1;

  return (
    <>
      {categories.length > 0 && (
        <nav aria-label={labels.categoriesNavigation} className="mb-7 flex flex-wrap gap-2 sm:mb-8">
          <Link
            href={projectsUrl({ search })}
            aria-current={!activeCategory ? "page" : undefined}
            className={`inline-flex min-h-10 items-center rounded border px-4 text-sm font-bold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--blue)] ${!activeCategory ? "border-[var(--blue)] bg-[var(--blue)] text-white shadow-[0_6px_14px_rgba(21,88,255,.18)]" : "border-slate-300 bg-white text-[var(--ink)] hover:border-[var(--blue)] hover:text-[var(--blue)]"}`}
          >
            {labels.all}
          </Link>
          {categories.map((category) => {
            const isActive = activeCategory === category;

            return (
              <Link
                key={category}
                href={projectsUrl({ category, search })}
                aria-current={isActive ? "page" : undefined}
                className={`inline-flex min-h-10 items-center rounded border px-4 text-sm font-bold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--blue)] ${isActive ? "border-[var(--blue)] bg-[var(--blue)] text-white shadow-[0_6px_14px_rgba(21,88,255,.18)]" : "border-slate-300 bg-white text-[var(--ink)] hover:border-[var(--blue)] hover:text-[var(--blue)]"}`}
              >
                {category}
              </Link>
            );
          })}
        </nav>
      )}

      {projects.length > 0 ? (
        <div className="grid gap-5 md:grid-cols-2 md:gap-6">
          {projects.map((project, index) => {
            const description = summary(project.description);

            return (
              <Link
                key={project.id}
                href={`/projects/${project.slug}`}
                className="group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-[0_8px_28px_rgba(24,58,108,.07)] transition duration-200 hover:-translate-y-1 hover:border-[#a7c3ff] hover:shadow-[0_18px_42px_rgba(24,58,108,.12)] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[var(--blue)] motion-reduce:transform-none motion-reduce:transition-none"
              >
                <article className="flex h-full flex-col">
                  <div className="relative aspect-[8/5] overflow-hidden bg-[#e8f1ff]">
                    <ProjectCardMedia image={project.image} title={project.title} index={index} />
                  </div>
                  <div className="flex min-h-[154px] flex-1 flex-col p-5 sm:p-6">
                    {project.category && <p className="text-[.66rem] font-extrabold uppercase tracking-[.14em] text-[var(--blue)]">{project.category}</p>}
                    <div className="mt-1 flex min-w-0 items-start justify-between gap-4">
                      <h2 className="min-w-0 text-[1.3rem] font-extrabold leading-tight tracking-[-.04em] text-[var(--ink)] sm:text-[1.4rem]">{project.title}</h2>
                      <span aria-hidden="true" className="mt-1 shrink-0 text-lg text-[var(--blue)] transition-transform duration-200 group-hover:translate-x-1 motion-reduce:transition-none">→</span>
                    </div>
                    {description && <p className="mt-2 line-clamp-2 text-sm leading-5 text-[var(--muted)]">{description}</p>}
                    <span className="mt-auto pt-5 text-sm font-extrabold text-[var(--blue)]">
                      {labels.viewProject} <span aria-hidden="true" className="ms-2 inline-block transition-transform duration-200 group-hover:translate-x-1 motion-reduce:transition-none">→</span>
                    </span>
                  </div>
                </article>
              </Link>
            );
          })}
        </div>
      ) : (
        <p role="status" className="rounded-xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center text-[var(--muted)]">{labels.empty}</p>
      )}

      {hasMultiplePages && (
        <nav aria-label={labels.paginationNavigation} className="mt-10 flex flex-wrap items-center justify-center gap-2">
          {pagination.current_page > 1 && (
            <Link href={projectsUrl({ category: activeCategory, search, page: pagination.current_page - 1 })} className="inline-flex min-h-10 items-center rounded border border-slate-300 bg-white px-4 text-sm font-bold text-[var(--ink)] transition hover:border-[var(--blue)] hover:text-[var(--blue)] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--blue)]">
              {labels.previous}
            </Link>
          )}
          {Array.from({ length: pagination.last_page }, (_, index) => index + 1).map((page) => {
            const isCurrent = page === pagination.current_page;

            return (
              <Link
                key={page}
                href={projectsUrl({ category: activeCategory, search, page })}
                aria-current={isCurrent ? "page" : undefined}
                aria-label={`${labels.page} ${page}`}
                className={`inline-flex h-10 min-w-10 items-center justify-center rounded border text-sm font-bold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--blue)] ${isCurrent ? "border-[var(--blue)] bg-[var(--blue)] text-white" : "border-slate-300 bg-white text-[var(--ink)] hover:border-[var(--blue)] hover:text-[var(--blue)]"}`}
              >
                {page}
              </Link>
            );
          })}
          {pagination.current_page < pagination.last_page && (
            <Link href={projectsUrl({ category: activeCategory, search, page: pagination.current_page + 1 })} className="inline-flex min-h-10 items-center rounded border border-slate-300 bg-white px-4 text-sm font-bold text-[var(--ink)] transition hover:border-[var(--blue)] hover:text-[var(--blue)] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--blue)]">
              {labels.next}
            </Link>
          )}
        </nav>
      )}
    </>
  );
}
