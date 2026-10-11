import type { Metadata } from "next";
import Image from "next/image";
import Link from "next/link";
import { cookies } from "next/headers";
import { getContactInfo } from "@/lib/api";
import { getDictionary } from "@/lib/dictionary";
import { ContactInteractiveSection } from "@/components/contact/ContactInteractiveSection";

export const dynamic = "force-dynamic";

function configuredValue(value: string | null | undefined, configured: boolean, fallback: string) {
  const normalized = value?.trim() || "";
  return configured ? normalized : fallback;
}

export async function generateMetadata(): Promise<Metadata> {
  const data = await getContactInfo();
  return {
    title: data.page.meta_title || data.page.title || "Contact Us",
    description: data.page.meta_description || data.page.description || "Get in touch with our team",
  };
}

export default async function ContactPage() {
  const [data, cookieStore] = await Promise.all([
    getContactInfo(),
    cookies(),
  ]);

  const locale = cookieStore.get("NEXT_LOCALE")?.value || "en";
  const dictionary = getDictionary(locale);
  const t = dictionary.contactPage;
  const configuredFields = new Set(data.page.configured_fields || []);
  const isConfigured = (field: string) => configuredFields.has(field);

  const title = configuredValue(data.page.title, isConfigured("title"), t.heroTitle) || t.heroTitle;
  const breadcrumb = configuredValue(data.page.breadcrumb_title, isConfigured("breadcrumb_title"), dictionary.nav.contact) || dictionary.nav.contact;
  const eyebrow = configuredValue(data.page.eyebrow, isConfigured("eyebrow"), t.eyebrow);
  const description = configuredValue(data.page.description, isConfigured("description"), t.heroDescription);
  const gridTitle = configuredValue(data.page.grid_title, isConfigured("grid_title"), t.gridTitle) || t.gridTitle;
  const gridDescription = configuredValue(data.page.grid_description, isConfigured("grid_description"), t.gridDescription);
  const heroImage = data.page.image || null;

  const mergedPage = {
    ...data.page,
    eyebrow,
    grid_title: gridTitle,
    grid_description: gridDescription,
  };

  return (
    <>
      {/* Compact Hero Banner: Replaces the oversized hero to bring the form into clear view */}
      <section className="relative isolate overflow-hidden bg-[#06162d] pb-8 pt-24 sm:pb-10 sm:pt-28 text-white">
        {heroImage && (
          <Image
            src={heroImage}
            alt=""
            fill
            priority
            sizes="100vw"
            className="-z-30 object-cover object-[68%_center] opacity-35"
            unoptimized={heroImage.includes("localhost") || heroImage.includes("127.0.0.1")}
          />
        )}
        <div
          aria-hidden="true"
          className="absolute inset-0 -z-20 bg-[linear-gradient(90deg,#06162d_0%,rgba(6,22,45,.97)_38%,rgba(6,22,45,.75)_62%,rgba(6,22,45,.4)_100%)]"
        />
        <div className="site-container">
          <nav className="flex flex-wrap items-center gap-2 text-xs font-semibold text-slate-300">
            <Link href="/" className="hover:text-white transition-colors">
              {dictionary.nav.home}
            </Link>
            <span className="text-slate-500">/</span>
            <span
              className="text-[#8db1ff]"
              dangerouslySetInnerHTML={{ __html: breadcrumb }}
            />
          </nav>
          <div className="mt-4 flex flex-col sm:flex-row sm:items-baseline sm:justify-between gap-2">
            <h1 className="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white">
              {title}
            </h1>
            {description && (
              <p className="text-xs sm:text-sm text-slate-300 max-w-xl">
                {description}
              </p>
            )}
          </div>
        </div>
      </section>

      {/* Balanced 2-Column Section: Intro & Details on Left, Selected Form in White Card on Right */}
      <ContactInteractiveSection
        page={mergedPage}
        services={data.services}
        locale={locale}
      />
    </>
  );
}
