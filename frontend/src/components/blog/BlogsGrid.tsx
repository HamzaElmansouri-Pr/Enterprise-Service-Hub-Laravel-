import Image from "next/image";
import Link from "next/link";
import type { Blog, Pagination } from "@/lib/types";

type BlogsGridProps = {
  blogs: Blog[];
  categories: string[];
  activeCategory?: string;
  search?: string;
  pagination: Pagination;
  labels: {
    all: string;
    readArticle: string;
    empty: string;
    previous: string;
    next: string;
    page: string;
    categoriesNavigation: string;
    paginationNavigation: string;
  };
};

function blogsUrl({ category, search, page }: { category?: string; search?: string; page?: number }) {
  const params = new URLSearchParams();

  if (category) params.set("category", category);
  if (search) params.set("search", search);
  if (page && page > 1) params.set("page", String(page));

  const query = params.toString();
  return query ? `/blog?${query}` : "/blog";
}

function summary(value: string | null) {
  return (value || "").replace(/<[^>]*>/g, " ").replace(/\s+/g, " ").trim();
}

export function BlogsGrid({ blogs, categories, activeCategory, search, pagination, labels }: BlogsGridProps) {
  const hasMultiplePages = pagination.last_page > 1;

  return (
    <>
      {categories.length > 0 && (
        <nav aria-label={labels.categoriesNavigation} className="mb-7 flex flex-wrap gap-2 sm:mb-8">
          <Link
            href={blogsUrl({ search })}
            aria-current={!activeCategory ? "page" : undefined}
            className={`inline-flex min-h-10 items-center rounded border px-4 text-sm font-bold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--blue)] ${
              !activeCategory
                ? "border-[var(--blue)] bg-[var(--blue)] text-white shadow-[0_6px_14px_rgba(21,88,255,.18)]"
                : "border-slate-300 bg-white text-[var(--ink)] hover:border-[var(--blue)] hover:text-[var(--blue)]"
            }`}
          >
            {labels.all}
          </Link>
          {categories.map((category) => {
            const isActive = activeCategory === category;

            return (
              <Link
                key={category}
                href={blogsUrl({ category, search })}
                aria-current={isActive ? "page" : undefined}
                className={`inline-flex min-h-10 items-center rounded border px-4 text-sm font-bold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--blue)] ${
                  isActive
                    ? "border-[var(--blue)] bg-[var(--blue)] text-white shadow-[0_6px_14px_rgba(21,88,255,.18)]"
                    : "border-slate-300 bg-white text-[var(--ink)] hover:border-[var(--blue)] hover:text-[var(--blue)]"
                }`}
              >
                {category}
              </Link>
            );
          })}
        </nav>
      )}

      {blogs.length > 0 ? (
        <div className="grid gap-7 md:grid-cols-2 lg:grid-cols-3">
          {blogs.map((blog) => {
            const excerpt = summary(blog.excerpt);

            return (
              <Link
                key={blog.id}
                href={`/blog/${blog.slug}`}
                className="group flex flex-col overflow-hidden rounded-xl border border-slate-200 bg-white shadow-[0_8px_28px_rgba(24,58,108,.07)] transition duration-200 hover:-translate-y-1 hover:border-[#a7c3ff] hover:shadow-[0_18px_42px_rgba(24,58,108,.12)] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[var(--blue)] motion-reduce:transform-none motion-reduce:transition-none"
              >
                <article className="flex h-full flex-col">
                  <div className="relative aspect-[16/10] overflow-hidden bg-slate-200">
                    {blog.image ? (
                      <Image
                        src={blog.image}
                        alt={blog.title}
                        fill
                        sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw"
                        className="object-cover transition duration-500 group-hover:scale-105"
                        unoptimized={blog.image.includes("localhost") || blog.image.includes("127.0.0.1")}
                      />
                    ) : (
                      <div className="absolute inset-0 bg-[linear-gradient(135deg,#ccdcef,#819abc)]" />
                    )}
                  </div>
                  <div className="flex flex-1 flex-col p-5 sm:p-6">
                    <p className="text-[.64rem] font-extrabold uppercase tracking-[.14em] text-[var(--blue)]">
                      {blog.category || "Insight"}
                    </p>
                    <h2 className="mt-1.5 text-lg font-extrabold tracking-[-.04em] text-[var(--ink)] sm:text-xl">
                      {blog.title}
                    </h2>
                    {excerpt && (
                      <p className="mt-2 line-clamp-2 text-sm leading-6 text-[var(--muted)]">
                        {excerpt}
                      </p>
                    )}
                    <div className="mt-auto pt-5">
                      <span className="arrow-link text-xs font-bold text-[var(--blue)]">
                        {labels.readArticle} <span aria-hidden="true" className="ms-1 inline-block transition-transform duration-200 group-hover:translate-x-1 motion-reduce:transition-none">→</span>
                      </span>
                    </div>
                  </div>
                </article>
              </Link>
            );
          })}
        </div>
      ) : (
        <p role="status" className="rounded-xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center text-[var(--muted)]">
          {labels.empty}
        </p>
      )}

      {hasMultiplePages && (
        <nav aria-label={labels.paginationNavigation} className="mt-12 flex flex-wrap items-center justify-center gap-2">
          {pagination.current_page > 1 && (
            <Link
              href={blogsUrl({ category: activeCategory, search, page: pagination.current_page - 1 })}
              className="inline-flex min-h-10 items-center rounded border border-slate-300 bg-white px-4 text-sm font-bold text-[var(--ink)] transition hover:border-[var(--blue)] hover:text-[var(--blue)] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--blue)]"
            >
              {labels.previous}
            </Link>
          )}
          {Array.from({ length: pagination.last_page }, (_, index) => index + 1).map((page) => {
            const isCurrent = page === pagination.current_page;

            return (
              <Link
                key={page}
                href={blogsUrl({ category: activeCategory, search, page })}
                aria-current={isCurrent ? "page" : undefined}
                aria-label={`${labels.page} ${page}`}
                className={`inline-flex h-10 min-w-10 items-center justify-center rounded border text-sm font-bold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--blue)] ${
                  isCurrent
                    ? "border-[var(--blue)] bg-[var(--blue)] text-white"
                    : "border-slate-300 bg-white text-[var(--ink)] hover:border-[var(--blue)] hover:text-[var(--blue)]"
                }`}
              >
                {page}
              </Link>
            );
          })}
          {pagination.current_page < pagination.last_page && (
            <Link
              href={blogsUrl({ category: activeCategory, search, page: pagination.current_page + 1 })}
              className="inline-flex min-h-10 items-center rounded border border-slate-300 bg-white px-4 text-sm font-bold text-[var(--ink)] transition hover:border-[var(--blue)] hover:text-[var(--blue)] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--blue)]"
            >
              {labels.next}
            </Link>
          )}
        </nav>
      )}
    </>
  );
}
