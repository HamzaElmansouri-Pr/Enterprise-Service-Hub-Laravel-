import type { Metadata } from "next";
import { getProject } from "@/lib/api";
import { Breadcrumb } from "@/components/ui/Breadcrumb";
import Link from "next/link";

interface Props { params: Promise<{ slug: string }> }

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { slug } = await params;
  const data = await getProject(slug);
  return {
    title: data.project.meta_title || data.project.title,
    description: data.project.meta_description || data.project.description?.replace(/<[^>]*>/g, '').slice(0, 160) || "",
    openGraph: data.project.og_image ? { images: [{ url: data.project.og_image }] } : undefined,
  };
}

export default async function ProjectDetailPage({ params }: Props) {
  const { slug } = await params;
  const { project, related_projects } = await getProject(slug);

  return (
    <>
      <Breadcrumb title={project.title} items={[{ label: "Projects", href: "/projects" }, { label: project.title }]} />

      <section className="section-padding bg-[var(--bg-dark)]">
        <div className="max-w-5xl mx-auto">
          {project.image && <div className="rounded-2xl overflow-hidden mb-10"><img src={project.image} alt={project.title} className="w-full h-auto" /></div>}

          <div className="flex flex-wrap gap-4 mb-8">
            {project.category && <span className="px-4 py-1.5 rounded-full bg-[var(--primary)]/10 text-[var(--primary-light)] text-sm">{project.category}</span>}
            {project.client && <span className="px-4 py-1.5 rounded-full bg-white/5 text-[var(--text-secondary)] text-sm">Client: {project.client}</span>}
            {project.completion_date && <span className="px-4 py-1.5 rounded-full bg-white/5 text-[var(--text-secondary)] text-sm">{new Date(project.completion_date).toLocaleDateString("en-US", { month: "long", year: "numeric" })}</span>}
          </div>

          <div className="prose prose-invert prose-lg max-w-none" dangerouslySetInnerHTML={{ __html: project.description || "" }} />
        </div>
      </section>

      {/* Related projects */}
      {related_projects.length > 0 && (
        <section className="section-padding bg-[var(--bg-darker)]">
          <div className="max-w-7xl mx-auto">
            <h2 className="text-2xl font-bold text-white mb-8">Related Projects</h2>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
              {related_projects.map((rp) => (
                <Link key={rp.id} href={`/projects/${rp.slug}`} className="group block rounded-2xl overflow-hidden bg-[var(--bg-card)] hover:shadow-[var(--shadow-hover)] transition-all">
                  <div className="h-48 overflow-hidden">{rp.image ? <img src={rp.image} alt={rp.title} className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" /> : <div className="w-full h-full bg-gradient-to-br from-[var(--primary)]/20 to-[var(--accent)]/10" />}</div>
                  <div className="p-5"><h3 className="font-bold text-white group-hover:text-[var(--primary-light)] transition-colors">{rp.title}</h3></div>
                </Link>
              ))}
            </div>
          </div>
        </section>
      )}
    </>
  );
}
