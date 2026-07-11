import type { Metadata } from "next";
import { getBlog } from "@/lib/api";
import { Breadcrumb } from "@/components/ui/Breadcrumb";
import { CommentSection } from "@/components/blog/CommentSection";
import Link from "next/link";

interface Props { params: Promise<{ slug: string }> }

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { slug } = await params;
  const data = await getBlog(slug);
  return {
    title: data.blog.meta_title || data.blog.title,
    description: data.blog.meta_description || data.blog.excerpt || "",
    openGraph: data.blog.og_image ? { images: [{ url: data.blog.og_image }] } : undefined,
  };
}

export default async function BlogDetailPage({ params }: Props) {
  const { slug } = await params;
  const { blog, recent_blogs } = await getBlog(slug);

  return (
    <>
      <Breadcrumb title={blog.title} items={[{ label: "Blog", href: "/blog" }, { label: blog.title }]} />

      <section className="section-padding bg-[var(--bg-dark)]">
        <div className="max-w-7xl mx-auto">
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <article className="lg:col-span-2">
              {blog.image && <div className="rounded-2xl overflow-hidden mb-8"><img src={blog.image} alt={blog.title} className="w-full h-auto" /></div>}

              <div className="flex flex-wrap items-center gap-4 mb-8">
                {blog.published_at && <span className="text-[var(--text-muted)] text-sm">{new Date(blog.published_at).toLocaleDateString("en-US", { month: "long", day: "numeric", year: "numeric" })}</span>}
                {blog.category && <span className="px-3 py-1 rounded-full bg-[var(--accent)]/10 text-[var(--accent)] text-xs font-medium">{blog.category}</span>}
                {blog.author && <span className="text-[var(--text-muted)] text-sm">by {blog.author.name}</span>}
              </div>

              <div className="prose prose-invert prose-lg max-w-none" dangerouslySetInnerHTML={{ __html: blog.content || "" }} />

              <CommentSection modelType="blog" modelId={blog.id} />
            </article>

            <aside className="lg:col-span-1">
              <div className="glass-card p-6 sticky top-28">
                <h3 className="text-lg font-bold text-white mb-6">Recent Posts</h3>
                <div className="space-y-4">
                  {recent_blogs.map((rb) => (
                    <Link key={rb.id} href={`/blog/${rb.slug}`} className="group flex gap-4 items-start">
                      <div className="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 bg-[var(--bg-card)]">
                        {rb.image ? <img src={rb.image} alt="" className="w-full h-full object-cover" /> : <div className="w-full h-full bg-gradient-to-br from-[var(--primary)]/20 to-[var(--accent)]/10" />}
                      </div>
                      <div>
                        <h4 className="text-sm font-medium text-white group-hover:text-[var(--primary-light)] transition-colors line-clamp-2">{rb.title}</h4>
                        {rb.published_at && <p className="text-[var(--text-muted)] text-xs mt-1">{new Date(rb.published_at).toLocaleDateString("en-US", { month: "short", day: "numeric" })}</p>}
                      </div>
                    </Link>
                  ))}
                </div>
              </div>
            </aside>
          </div>
        </div>
      </section>
    </>
  );
}
