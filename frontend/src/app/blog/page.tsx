import type { Metadata } from "next";
import Image from "next/image";
import { getBlogs } from "@/lib/api";
import { Breadcrumb } from "@/components/ui/Breadcrumb";
import TiltCard from "@/components/ui/TiltCard";
import Link from "next/link";

import { cookies } from "next/headers";
import { getDictionary } from "@/lib/dictionary";

export async function generateMetadata(): Promise<Metadata> {
  const cookieStore = await cookies();
  const locale = cookieStore.get("NEXT_LOCALE")?.value || "en";
  const data = await getBlogs();
  return {
    title: data.page.meta_title || "Blog",
    description: data.page.meta_description || "Latest news, insights, and updates from our team",
  };
}

export default async function BlogPage({ searchParams }: { searchParams: Promise<{ page?: string }> }) {
  const sp = await searchParams;
  const currentPage = Number(sp.page) || 1;
  const cookieStore = await cookies();
  const locale = cookieStore.get("NEXT_LOCALE")?.value || "en";
  const t = getDictionary(locale);
  const data = await getBlogs(currentPage);

  return (
    <>
      <Breadcrumb title={data.page.title} image={data.page.image} items={[{ label: t.nav.blog }]} />

      <section className="section-padding bg-[var(--bg-dark)]">
        <div className="max-w-7xl mx-auto">
          {(!data.blogs || data.blogs.length === 0) ? (
            <div className="text-center elite-glass p-12 rounded-3xl border border-white/5 min-h-[40vh] flex flex-col justify-center items-center">
              <h2 className="text-3xl font-bold text-white mb-4">No Posts Found</h2>
              <p className="text-[var(--text-muted)] text-lg">There are currently no blog posts available. Check back soon!</p>
            </div>
          ) : (
            <>
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {data.blogs.map((blog) => (
                  <TiltCard key={blog.id}>
                    <Link href={`/blog/${blog.slug}`} className="group block rounded-2xl overflow-hidden bg-[var(--bg-card)] hover:shadow-[var(--shadow-hover)] transition-all duration-300">
                      <div className="relative h-48 overflow-hidden">
                        {blog.image ? <Image src={blog.image} alt={blog.title} fill sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw" className="object-cover group-hover:scale-110 transition-transform duration-500" /> : <div className="w-full h-full bg-gradient-to-br from-[var(--primary)]/20 to-[var(--accent)]/10 flex items-center justify-center"><span className="text-5xl opacity-30">📰</span></div>}
                        {blog.category && <span className="absolute top-4 left-4 px-3 py-1 rounded-full bg-[var(--accent)]/80 text-white text-xs font-medium backdrop-blur-sm">{blog.category}</span>}
                      </div>
                      <div className="p-6">
                        {blog.published_at && <p className="text-[var(--text-muted)] text-xs mb-3">{new Date(blog.published_at).toLocaleDateString(locale === "ar" ? "ar-EG" : (locale === "fr" ? "fr-FR" : "en-US"), { month: "long", day: "numeric", year: "numeric" })}</p>}
                        <h3 className="text-lg font-bold text-white mb-2 group-hover:text-[var(--primary-light)] transition-colors line-clamp-2">{blog.title}</h3>
                        {blog.excerpt && <p className="text-[var(--text-secondary)] text-sm line-clamp-2">{blog.excerpt}</p>}
                        {blog.author && <div className="mt-4 flex items-center gap-2"><div className="w-6 h-6 rounded-full bg-[var(--primary)]/20 flex items-center justify-center text-xs text-[var(--primary-light)]">{blog.author.name?.[0]}</div><span className="text-[var(--text-muted)] text-xs">{blog.author.name}</span></div>}
                      </div>
                    </Link>
                  </TiltCard>
                ))}
              </div>

              {/* Pagination */}
              {data.pagination.last_page > 1 && (
                <div className="flex justify-center gap-2 mt-12">
                  {Array.from({ length: data.pagination.last_page }, (_, i) => i + 1).map((p) => (
                    <Link key={p} href={`/blog?page=${p}`} className={`w-10 h-10 rounded-lg flex items-center justify-center text-sm font-medium transition-all ${p === currentPage ? "bg-[var(--primary)] text-white" : "bg-white/5 text-[var(--text-secondary)] hover:bg-white/10"}`}>{p}</Link>
                  ))}
                </div>
              )}
            </>
          )}
        </div>
      </section>
    </>
  );
}
