import type { Metadata } from "next";
import { getService } from "@/lib/api";
import { Breadcrumb } from "@/components/ui/Breadcrumb";
import Link from "next/link";

interface Props { params: Promise<{ slug: string }> }

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { slug } = await params;
  const data = await getService(slug);
  return {
    title: data.service.meta_title || data.service.title,
    description: data.service.meta_description || data.service.subtitle || "",
    openGraph: data.service.og_image ? { images: [{ url: data.service.og_image }] } : undefined,
  };
}

export default async function ServiceDetailPage({ params }: Props) {
  const { slug } = await params;
  const data = await getService(slug);
  const { service, all_services } = data;

  return (
    <>
      <Breadcrumb title={service.title} items={[{ label: "Services", href: "/services" }, { label: service.title }]} />

      <section className="section-padding bg-[var(--bg-dark)]">
        <div className="max-w-7xl mx-auto">
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
            {/* Main content */}
            <div className="lg:col-span-2">
              {service.image && (
                <div className="rounded-2xl overflow-hidden mb-8">
                  <img src={service.image} alt={service.title} className="w-full h-auto object-cover" />
                </div>
              )}
              <div className="prose prose-invert prose-lg max-w-none" dangerouslySetInnerHTML={{ __html: service.description || "" }} />
            </div>

            {/* Sidebar */}
            <aside className="lg:col-span-1">
              <div className="glass-card p-6 sticky top-28">
                <h3 className="text-lg font-bold text-white mb-6">All Services</h3>
                <nav className="space-y-2">
                  {all_services.map((s) => (
                    <Link key={s.id} href={`/services/${s.slug}`} className={`block px-4 py-3 rounded-xl text-sm font-medium transition-all ${s.slug === slug ? "bg-[var(--primary)]/15 text-[var(--primary-light)] border border-[var(--primary)]/30" : "text-[var(--text-secondary)] hover:bg-white/5 hover:text-white"}`}>
                      {s.title}
                    </Link>
                  ))}
                </nav>
              </div>
            </aside>
          </div>
        </div>
      </section>
    </>
  );
}
