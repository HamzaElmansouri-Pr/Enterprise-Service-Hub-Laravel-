import type { Metadata } from "next";
import Image from "next/image";
import { getServices } from "@/lib/api";
import { Breadcrumb } from "@/components/ui/Breadcrumb";
import Link from "next/link";
import DOMPurify from "isomorphic-dompurify";

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
              <Link key={service.id} href={`/services/${service.slug}`} className="group relative block h-full outline-none">
                {/* Glow Behind Card */}
                <div className="absolute inset-0 bg-gradient-to-br from-[var(--primary)]/20 to-[var(--accent)]/20 rounded-[24px] blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500" />
                
                {/* Elite Glass Card */}
                <div className="relative h-full p-8 rounded-[24px] elite-glass border border-white/5 group-hover:border-white/10 transition-all duration-500 overflow-hidden">
                  
                  {/* Subtle Hover Gradient Inside */}
                  <div className="absolute inset-0 bg-gradient-to-br from-white/[0.03] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500" />

                  {/* Icon */}
                  <div className="relative w-16 h-16 rounded-2xl bg-[var(--bg-deep)] border border-white/10 flex items-center justify-center text-3xl mb-8 group-hover:scale-110 group-hover:border-[var(--primary)]/30 transition-all duration-500 shadow-xl">
                    <div className="absolute inset-0 bg-[var(--primary)]/10 rounded-2xl blur-md opacity-0 group-hover:opacity-100 transition-opacity duration-500" />
                    <span className="relative z-10 drop-shadow-lg">
                      {service.image ? (
                        <Image src={service.image} alt="" width={32} height={32} className="object-contain" />
                      ) : (
                        "⚡"
                      )}
                    </span>
                  </div>

                  {/* Content */}
                  <h3 className="text-2xl font-bold text-white mb-4 group-hover:text-[var(--primary-light)] transition-colors duration-300 tracking-tight">
                    {service.title}
                  </h3>
                  
                  {service.subtitle && (
                    <div
                      className="text-[var(--text-muted)] text-base leading-relaxed line-clamp-3 mb-8"
                      dangerouslySetInnerHTML={{ __html: DOMPurify.sanitize(service.subtitle) }}
                    />
                  )}

                  {/* Floating Arrow */}
                  <div className="absolute bottom-8 right-8 w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white group-hover:bg-[var(--primary)] group-hover:border-[var(--primary)] group-hover:text-white transition-all duration-300 transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 shadow-[0_0_20px_rgba(0,0,0,0.5)]">
                    <svg className={`w-4 h-4 transform transition-transform duration-300 ${locale === 'ar' ? '-rotate-[135deg] group-hover:rotate-180' : '-rotate-45 group-hover:rotate-0'}`} fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                  </div>
                </div>
              </Link>
            ))}
          </div>
        </div>
      </section>
    </>
  );
}
