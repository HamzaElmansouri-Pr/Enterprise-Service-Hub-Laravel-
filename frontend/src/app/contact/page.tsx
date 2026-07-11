import type { Metadata } from "next";
import { getContactInfo } from "@/lib/api";
import { Breadcrumb } from "@/components/ui/Breadcrumb";
import { ContactForm } from "@/components/contact/ContactForm";
import { TcRequestForm } from "@/components/contact/TcRequestForm";

import { cookies } from "next/headers";
import { getDictionary } from "@/lib/dictionary";

export async function generateMetadata(): Promise<Metadata> {
  const cookieStore = await cookies();
  const locale = cookieStore.get("NEXT_LOCALE")?.value || "en";
  const data = await getContactInfo();
  return {
    title: data.page.meta_title || "Contact Us",
    description: data.page.meta_description || "Get in touch with our team for professional IT solutions",
  };
}

export default async function ContactPage() {
  const cookieStore = await cookies();
  const locale = cookieStore.get("NEXT_LOCALE")?.value || "en";
  const data = await getContactInfo();
  const { page, services } = data;
  const t = getDictionary(locale);

  return (
    <>
      <Breadcrumb title={page.title} items={[{ label: t.nav.contact }]} />

      <section className="section-padding bg-[var(--bg-dark)]">
        <div className="max-w-7xl mx-auto">
          {/* Contact info cards */}
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
            {page.contact_address && (
              <div className="glass-card p-8 text-center">
                <div className="w-14 h-14 rounded-2xl bg-[var(--primary)]/10 flex items-center justify-center text-2xl mx-auto mb-4">📍</div>
                <h3 className="text-white font-semibold mb-2">{locale === 'ar' ? 'عنواننا' : (locale === 'fr' ? 'Notre adresse' : 'Our Address')}</h3>
                <p className="text-[var(--text-secondary)] text-sm">{page.contact_address}</p>
              </div>
            )}
            {page.contact_email && (
              <div className="glass-card p-8 text-center">
                <div className="w-14 h-14 rounded-2xl bg-[var(--primary)]/10 flex items-center justify-center text-2xl mx-auto mb-4">✉️</div>
                <h3 className="text-white font-semibold mb-2">{locale === 'ar' ? 'راسلنا' : (locale === 'fr' ? 'Email nous' : 'Email Us')}</h3>
                <a href={`mailto:${page.contact_email}`} className="text-[var(--primary-light)] text-sm hover:underline">{page.contact_email}</a>
              </div>
            )}
            {page.contact_phone && (
              <div className="glass-card p-8 text-center">
                <div className="w-14 h-14 rounded-2xl bg-[var(--primary)]/10 flex items-center justify-center text-2xl mx-auto mb-4">📞</div>
                <h3 className="text-white font-semibold mb-2">{locale === 'ar' ? 'اتصل بنا' : (locale === 'fr' ? 'Appelez-nous' : 'Call Us')}</h3>
                <a href={`tel:${page.contact_phone}`} className="text-[var(--primary-light)] text-sm hover:underline">{page.contact_phone}</a>
              </div>
            )}
          </div>

          {/* Forms */}
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div>
              <h2 className="text-2xl font-bold text-white mb-6">{t.contact.consultation.sendTitle}</h2>
              <ContactForm locale={locale} />
            </div>
            <div>
              <h2 className="text-2xl font-bold text-white mb-6">{t.contact.consultation.title}</h2>
              <TcRequestForm services={services} locale={locale} />
            </div>
          </div>
        </div>
      </section>
    </>
  );
}
