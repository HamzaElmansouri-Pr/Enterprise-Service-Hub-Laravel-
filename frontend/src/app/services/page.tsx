import type { Metadata } from "next";
import { getServices } from "@/lib/api";
import { Breadcrumb } from "@/components/ui/Breadcrumb";
import Link from "next/link";

import { cookies } from "next/headers";
import { getDictionary } from "@/lib/dictionary";

export async function generateMetadata(): Promise<Metadata> {
  const cookieStore = await cookies();
  const locale = cookieStore.get("NEXT_LOCALE")?.value || "en";
  const data = await getServices();
  return {
    title: data.page.meta_title || "Our Services",
    description: data.page.meta_description || "Professional IT services and technology solutions",
  };
}

export default async function ServicesPage() {
  const cookieStore = await cookies();
  const locale = cookieStore.get("NEXT_LOCALE")?.value || "en";
  const t = getDictionary(locale);
  const data = await getServices();

  return (
    <>
      <Breadcrumb title={data.page.title} image={data.page.image} items={[{ label: t.nav.services }]} />

      <section className="section-padding bg-[var(--bg-dark)]">
        <div className="max-w-7xl mx-auto">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {data.services.map((service) => (
              <Link key={service.id} href={`/services/${service.slug}`} className="group glass-card p-8 hover:bg-[var(--bg-card-hover)] transition-all duration-300 hover:shadow-[var(--shadow-hover)] hover:-translate-y-1">
                <div className="w-14 h-14 rounded-2xl bg-gradient-to-br from-[var(--primary)]/20 to-[var(--primary)]/5 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform duration-300">
                  {service.image ? <img src={service.image} alt="" className="w-8 h-8 object-contain" /> : "⚡"}
                </div>
                <h3 className="text-xl font-bold text-white mb-3 group-hover:text-[var(--primary-light)] transition-colors">{service.title}</h3>
                {service.subtitle && <p className="text-[var(--text-secondary)] text-sm leading-relaxed line-clamp-3" dangerouslySetInnerHTML={{ __html: service.subtitle }} />}
                <div className={`mt-6 flex items-center gap-2 text-[var(--primary-light)] text-sm font-medium opacity-0 group-hover:opacity-100 transition-opacity ${locale === 'ar' ? 'flex-row-reverse' : ''}`}>
                  {locale === 'ar' ? 'معرفة المزيد ←' : (locale === 'fr' ? 'En savoir plus →' : 'Learn more →')}
                </div>
              </Link>
            ))}
          </div>
        </div>
      </section>
    </>
  );
}
