import type { Metadata } from "next";
import Image from "next/image";
import Link from "next/link";
import { cookies } from "next/headers";
import { ServiceCardMedia } from "@/components/services/ServiceCardMedia";
import { ServiceIcon } from "@/components/ui/ServiceIcon";
import { getServices } from "@/lib/api";
import { getDictionary } from "@/lib/dictionary";
import { resolveServicesHeroImage } from "@/lib/demoMedia";

export async function generateMetadata(): Promise<Metadata> {
  const data = await getServices();

  return {
    title: data.page.meta_title || data.page.title || "Our Services",
    description: data.page.meta_description || "Professional IT services and technology solutions",
  };
}

function textSummary(value?: string | null) {
  return (value || "").replace(/<[^>]*>/g, " ").replace(/\s+/g, " ").trim();
}

export default async function ServicesPage() {
  const [data, cookieStore] = await Promise.all([getServices(), cookies()]);
  const locale = cookieStore.get("NEXT_LOCALE")?.value || "en";
  const dictionary = getDictionary(locale);
  const t = dictionary.servicesPage;
  const pageTitle = data.page.title?.trim() || t.heroTitle;
  const pageBreadcrumb = data.page.breadcrumb_title?.trim() || pageTitle || dictionary.nav.services;
  const heroImage = resolveServicesHeroImage(data.page.image);
  const eyebrow = data.page.eyebrow?.trim() || t.eyebrow;
  const description = data.page.description?.trim() || t.heroDescription;
  const buttonText = data.page.button_text?.trim() || t.primaryAction;
  const buttonUrl = data.page.button_url?.trim() || "/contact";
  const gridEyebrow = data.page.grid_eyebrow?.trim() || t.gridEyebrow;
  const gridTitle = data.page.grid_title?.trim() || t.gridTitle;
  const gridDescription = data.page.grid_description?.trim() || t.gridDescription;

  return (
    <>
      <section className="relative isolate min-h-[560px] overflow-hidden bg-[#06162d] pb-20 pt-32 text-white sm:pb-24 sm:pt-36">
        <Image
          src={heroImage}
          alt=""
          fill
          priority
          sizes="100vw"
          className="-z-30 object-cover object-[68%_center]"
          unoptimized={heroImage.includes("localhost") || heroImage.includes("127.0.0.1")}
        />
        <div aria-hidden="true" className="absolute inset-0 -z-20 bg-[linear-gradient(90deg,#06162d_0%,rgba(6,22,45,.97)_36%,rgba(6,22,45,.68)_62%,rgba(6,22,45,.32)_100%)]" />
        <div aria-hidden="true" className="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_80%_25%,rgba(21,88,255,.26),transparent_30%)]" />

        <div className="site-container">
          <nav aria-label="Breadcrumb" className="flex flex-wrap items-center gap-2 text-sm font-semibold text-slate-300">
            <Link href="/" className="transition hover:text-white">{dictionary.nav.home}</Link>
            <span aria-hidden="true" className="text-slate-500">/</span>
            <span className="text-[#9bc0ff]">{pageBreadcrumb}</span>
          </nav>

          <div className="mt-10 max-w-[720px]">
            {eyebrow && <span className="eyebrow eyebrow--light">{eyebrow}</span>}
            <h1 className="max-w-[680px] text-[clamp(3rem,5.2vw,4rem)] font-extrabold leading-[.98] tracking-[-.065em] text-white">{pageTitle}</h1>
            {description && <p className="mt-6 max-w-xl text-[1.05rem] leading-7 text-slate-300 sm:text-[1.12rem]">{description}</p>}
            {buttonText && <Link href={buttonUrl} className="button-primary mt-8">{buttonText} <span aria-hidden="true">→</span></Link>}
          </div>
        </div>
      </section>

      <section className="bg-[#f4f8fd] py-16 sm:py-20 lg:py-24">
        <div className="site-container">
          <div className="grid gap-6 border-b border-slate-200 pb-9 lg:grid-cols-[1.45fr_.55fr] lg:items-end lg:gap-12">
            <div>
              <span className="eyebrow">{gridEyebrow}</span>
              <h2 className="max-w-3xl text-[clamp(2.15rem,3.6vw,3.55rem)] font-extrabold leading-[1.02] tracking-[-.055em] text-[var(--ink)]">{gridTitle}</h2>
            </div>
            <p className="max-w-sm text-[.98rem] leading-7 text-[var(--muted)]">{gridDescription}</p>
          </div>

          <div className="mt-8 grid gap-5 md:grid-cols-2">
            {data.services.map((service, index) => {
              const number = String(service.order_index ?? index + 1).padStart(2, "0");
              const description = service.subtitle || textSummary(service.description);

              return (
                <Link
                  key={service.id}
                  href={`/services/${service.slug}`}
                  className="group grid min-h-[330px] overflow-hidden rounded-xl border border-slate-200 bg-white shadow-[0_10px_32px_rgba(24,58,108,.06)] transition duration-200 hover:-translate-y-1 hover:border-[#a7c3ff] hover:shadow-[0_18px_42px_rgba(24,58,108,.12)] motion-reduce:transform-none motion-reduce:transition-none sm:grid-cols-[1.05fr_.95fr]"
                >
                  <div className="flex min-w-0 flex-col p-6 sm:p-7">
                    <span className="text-sm font-extrabold text-[var(--muted)]">{number}</span>
                    <ServiceIcon icon={service.icon} className="mt-7 h-9 w-9 text-[var(--blue)]" />
                    <h3 className="mt-7 text-[1.35rem] font-extrabold leading-tight tracking-[-.045em] text-[var(--ink)]">{service.title}</h3>
                    {description && <p className="mt-3 text-[.94rem] leading-6 text-[var(--muted)]">{description}</p>}
                    <span className="mt-auto pt-8 text-sm font-extrabold text-[var(--blue)]">
                      {t.viewService} <span aria-hidden="true" className="ms-2 inline-block transition-transform duration-200 group-hover:translate-x-1 motion-reduce:transition-none">→</span>
                    </span>
                  </div>
                  <ServiceCardMedia image={service.image} icon={service.icon} />
                </Link>
              );
            })}
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
          <Link href="/contact" className="inline-flex min-h-12 shrink-0 items-center justify-center gap-3 rounded bg-white px-6 text-sm font-extrabold text-[var(--ink)] transition hover:-translate-y-0.5 hover:bg-slate-100 motion-reduce:transform-none">{t.primaryAction} <span aria-hidden="true">→</span></Link>
        </div>
      </section>
    </>
  );
}
