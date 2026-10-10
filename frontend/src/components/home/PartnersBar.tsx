import Image from "next/image";
import type { Partner } from "@/lib/types";

export function PartnersBar({ partners, content }: { partners: Partner[]; content?: { eyebrow?: string; title?: string; subtitle?: string } | null }) {
  const activePartners = partners.filter((partner) => partner.is_active && (partner.logo_url || partner.logo || partner.name));
  if (!activePartners.length) return null;

  const title = content?.title?.trim() || "Our partners";
  const subtitle = content?.subtitle?.trim() || "Working together to deliver better digital solutions.";
  const headingId = "partners-heading";

  return (
    <section className="border-t border-slate-200 bg-white py-9 md:py-14" aria-labelledby={headingId}>
      <div className="site-container grid items-center gap-8 lg:grid-cols-[3fr_7fr] lg:gap-12">
        <div className="max-w-sm text-start">
          <h2 id={headingId} className="text-[clamp(1.75rem,2.3vw,2rem)] font-semibold leading-tight tracking-[-.04em] text-[var(--ink)]">{title}</h2>
          <p className="mt-3 text-[.98rem] leading-6 text-[var(--muted)]">{subtitle}</p>
        </div>

        <ul className="grid grid-cols-2 items-center gap-x-7 gap-y-5 sm:grid-cols-3 lg:grid-cols-4 lg:gap-x-9" role="list">
          {activePartners.map((partner) => {
            const logo = partner.logo_url || partner.logo;
            const visual = logo ? (
              <Image
                src={logo}
                alt={partner.name}
                width={176}
                height={64}
                sizes="(max-width: 640px) 42vw, (max-width: 1024px) 27vw, 15vw"
                className="h-20 w-auto max-w-[176px] object-contain transition-transform duration-200 group-hover:scale-[1.02]"
                unoptimized={logo.includes("localhost") || logo.includes("127.0.0.1")}
              />
            ) : (
              <span className="text-center text-sm font-semibold text-[var(--ink-soft)]">{partner.name}</span>
            );

            return (
              <li key={partner.id} className="flex min-h-20 items-center justify-center">
                {partner.url ? (
                  <a href={partner.url} target="_blank" rel="noreferrer" aria-label={`Visit ${partner.name}`} className="group flex min-h-16 min-w-16 items-center justify-center rounded-sm px-2 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[var(--blue)]">
                    {visual}
                  </a>
                ) : (
                  <div className="flex min-h-16 min-w-16 items-center justify-center px-2">{visual}</div>
                )}
              </li>
            );
          })}
        </ul>
      </div>
    </section>
  );
}
