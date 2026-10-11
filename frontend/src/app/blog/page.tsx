import type { Metadata } from "next";
import Image from "next/image";
import Link from "next/link";
import { cookies } from "next/headers";
import { BlogsGrid } from "@/components/blog/BlogsGrid";
import { getBlogs } from "@/lib/api";
import { getDictionary } from "@/lib/dictionary";

export const dynamic = "force-dynamic";

type BlogSearchParams = Promise<{
  category?: string;
  search?: string;
  page?: string;
}>;

function configuredValue(value: string | null | undefined, configured: boolean, fallback: string) {
  const normalized = value?.trim() || "";
  return configured ? normalized : fallback;
}

function pageNumber(value?: string) {
  const parsed = Number(value);
  return Number.isSafeInteger(parsed) && parsed > 0 ? parsed : 1;
}

export async function generateMetadata(): Promise<Metadata> {
  const data = await getBlogs();

  return {
    title: data.page.meta_title || data.page.title || "Our Insights",
    description: data.page.meta_description || data.page.description || "Explore our latest articles, insights and updates",
  };
}

export default async function BlogPage({ searchParams }: { searchParams: BlogSearchParams }) {
  const [sp, cookieStore] = await Promise.all([searchParams, cookies()]);
  const data = await getBlogs({
    category: sp.category,
    search: sp.search,
    page: pageNumber(sp.page),
  });
  const locale = cookieStore.get("NEXT_LOCALE")?.value || "en";
  const dictionary = getDictionary(locale);
  const t = dictionary.blogPage;
  const configuredFields = new Set(data.page.configured_fields || []);
  const isConfigured = (field: string) => configuredFields.has(field);

  const title = configuredValue(data.page.title, isConfigured("title"), t.heroTitle) || t.heroTitle;
  const breadcrumb = configuredValue(data.page.breadcrumb_title, isConfigured("breadcrumb_title"), dictionary.nav.blog) || dictionary.nav.blog;
  const eyebrow = configuredValue(data.page.eyebrow, isConfigured("eyebrow"), t.eyebrow);
  const description = configuredValue(data.page.description, isConfigured("description"), t.heroDescription);
  const gridTitle = configuredValue(data.page.grid_title, isConfigured("grid_title"), t.gridTitle) || t.gridTitle;
  const gridDescription = configuredValue(data.page.grid_description, isConfigured("grid_description"), t.gridDescription);
  const ctaLabel = configuredValue(data.page.button_text, isConfigured("button_text"), t.primaryAction);
  const ctaUrl = configuredValue(data.page.button_url, isConfigured("button_url"), "/contact") || "/contact";
  const heroImage = data.page.image || "/assets/img/breadcrumb-bg.jpg";

  return (
    <>
      <section className="relative isolate min-h-[500px] overflow-hidden bg-[#06162d] pb-16 pt-28 text-white sm:min-h-[540px] sm:pb-20 sm:pt-32">
        {heroImage && (
          <Image
            src={heroImage}
            alt=""
            fill
            priority
            sizes="100vw"
            className="-z-30 object-cover object-[68%_center]"
            unoptimized={heroImage.includes("localhost") || heroImage.includes("127.0.0.1")}
          />
        )}
        <div aria-hidden="true" className="absolute inset-0 -z-20 bg-[linear-gradient(90deg,#06162d_0%,rgba(6,22,45,.97)_38%,rgba(6,22,45,.7)_62%,rgba(6,22,45,.3)_100%)]" />
        <div aria-hidden="true" className="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_76%_28%,rgba(21,88,255,.3),transparent_31%)]" />

        <div className="site-container">
          <nav aria-label="Breadcrumb" className="flex flex-wrap items-center gap-2 text-sm font-semibold text-slate-300">
            <Link href="/" className="transition hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white">{dictionary.nav.home}</Link>
            <span aria-hidden="true" className="text-slate-500">/</span>
            <span className="text-[#9bc0ff]">{breadcrumb}</span>
          </nav>

          <div className="mt-10 max-w-[720px]">
            {eyebrow && <span className="eyebrow eyebrow--light">{eyebrow}</span>}
            <h1 className="max-w-[690px] text-[clamp(2.8rem,5.2vw,4rem)] font-extrabold leading-[.98] tracking-[-.065em] text-white">{title}</h1>
            {description && <p className="mt-6 max-w-xl text-[1.05rem] leading-7 text-slate-300 sm:text-[1.12rem]">{description}</p>}
          </div>
        </div>
      </section>

      <section className="bg-[#f4f8fd] py-14 sm:py-16 lg:py-20">
        <div className="site-container">
          <div className="border-b border-slate-200 pb-8 sm:pb-9">
            <h2 className="max-w-3xl text-[clamp(2.15rem,3.6vw,3.55rem)] font-extrabold leading-[1.02] tracking-[-.055em] text-[var(--ink)]">{gridTitle}</h2>
            {gridDescription && <p className="mt-3 max-w-2xl text-[.98rem] leading-7 text-[var(--muted)]">{gridDescription}</p>}
          </div>

          <div className="mt-7 sm:mt-8">
            <BlogsGrid
              blogs={data.blogs}
              categories={data.categories}
              activeCategory={sp.category}
              search={sp.search}
              pagination={data.pagination}
              labels={{
                all: t.all,
                readArticle: t.readArticle,
                empty: t.empty,
                previous: t.previous,
                next: t.next,
                page: t.page,
                categoriesNavigation: t.categoriesNavigation,
                paginationNavigation: t.paginationNavigation,
              }}
            />
          </div>
        </div>
      </section>

      <section className="relative overflow-hidden bg-[var(--blue)] py-12 text-white sm:py-14">
        <div aria-hidden="true" className="absolute -right-8 -top-32 h-80 w-80 rounded-full border-[52px] border-white/10" />
        <div className="site-container relative flex flex-col gap-7 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h2 className="text-[clamp(2rem,3.2vw,3rem)] font-extrabold leading-none tracking-[-.055em]">{t.ctaTitle}</h2>
            <p className="mt-3 text-[1.04rem] text-white/90">{t.ctaDescription}</p>
          </div>
          {ctaLabel && <Link href={ctaUrl} className="inline-flex min-h-12 shrink-0 items-center justify-center gap-3 rounded bg-white px-6 text-sm font-extrabold text-[var(--ink)] transition hover:-translate-y-0.5 hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white motion-reduce:transform-none">{ctaLabel} <span aria-hidden="true">→</span></Link>}
        </div>
      </section>
    </>
  );
}
