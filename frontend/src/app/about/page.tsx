import type { Metadata } from "next";
import Image from "next/image";
import { getAboutPage } from "@/lib/api";
import { Breadcrumb } from "@/components/ui/Breadcrumb";

import { cookies } from "next/headers";
import { getDictionary } from "@/lib/dictionary";

export async function generateMetadata(): Promise<Metadata> {
  const data = await getAboutPage();
  return {
    title: data.page.meta_title || "About Us",
    description: data.page.meta_description || "Learn more about our company, values, and team",
  };
}

export default async function AboutPage() {
  const cookieStore = await cookies();
  const locale = cookieStore.get("NEXT_LOCALE")?.value || "en";
  const t = getDictionary(locale);
  const { page } = await getAboutPage();
  const { about, stats, values, team, history } = page;
  const statsItems = stats?.items ?? [];
  const valuesItems = values?.items ?? [];
  const teamMembers = team?.members ?? [];

  return (
    <>
      <Breadcrumb title={page.title} image={page.image} items={[{ label: t.nav.about }]} />

      <section className="section-padding bg-[var(--bg-dark)]">
        <div className="max-w-5xl mx-auto space-y-20">
          {/* About content */}
          {about && (
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
              <div>
                {about.image && (
                  <div className="rounded-2xl overflow-hidden">
                    <Image src={about.image} alt="About" width={1200} height={800} className="w-full h-auto" />
                  </div>
                )}
              </div>
              <div>
                {about.subtitle && <span className="inline-block px-4 py-1.5 rounded-full bg-[var(--primary)]/10 text-[var(--primary-light)] text-sm font-medium mb-4">{about.subtitle}</span>}
                {about.title && <h2 className="text-3xl font-bold text-white mb-6">{about.title}</h2>}
                {about.description && <p className="text-[var(--text-secondary)] leading-relaxed">{about.description}</p>}
              </div>
            </div>
          )}

          {/* Stats */}
          {statsItems.length > 0 && (
            <div>
              {(stats?.title || stats?.subtitle) && (
                <div className="text-center mb-10">
                  {stats.subtitle && <span className="text-[var(--primary-light)] font-semibold tracking-wider uppercase text-sm">{stats.subtitle}</span>}
                  {stats.title && <h2 className="text-3xl font-bold text-white mt-2">{stats.title}</h2>}
                </div>
              )}
              <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
              {statsItems.map((stat, i) => (
                <div key={i} className="glass-card p-8 text-center">
                  <span className="block text-3xl font-bold gradient-text mb-2">{stat.value ?? `${stat.number ?? ""}${stat.suffix ?? ""}`}</span>
                  <span className="text-[var(--text-muted)] text-sm">{stat.label}</span>
                </div>
              ))}
              </div>
            </div>
          )}

          {/* Values */}
          {valuesItems.length > 0 && (
            <div>
              <div className="text-center mb-10">
                {values?.subtitle && <span className="text-[var(--primary-light)] font-semibold tracking-wider uppercase text-sm">{values.subtitle}</span>}
                <h2 className="text-3xl font-bold text-white mt-2">{values?.title || t.contact.ourValues}</h2>
              </div>
              <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                {valuesItems.map((value, i) => (
                  <div key={i} className="glass-card p-8">
                    <div className="w-12 h-12 rounded-xl bg-gradient-to-br from-[var(--primary)]/20 to-[var(--accent)]/10 flex items-center justify-center text-xl mb-4">{i === 0 ? "🎯" : i === 1 ? "💡" : "🤝"}</div>
                    <h3 className="text-lg font-bold text-white mb-3">{value.title}</h3>
                    <p className="text-[var(--text-secondary)] text-sm leading-relaxed">{value.description}</p>
                  </div>
                ))}
              </div>
            </div>
          )}

          {/* History / Milestones */}
          {history && history.milestones && history.milestones.length > 0 && (
            <div className="py-12 border-t border-white/5">
              <div className="text-center mb-16">
                {history.subtitle && <span className="text-[var(--primary-light)] font-semibold tracking-wider uppercase text-sm">{history.subtitle}</span>}
                <h2 className="text-3xl font-bold text-white mt-2">{history.title || "Our Journey"}</h2>
              </div>
              <div className="relative border-l border-[var(--primary)]/30 ml-4 md:ml-6 space-y-12 pb-8">
                {history.milestones.map((milestone, i) => (
                  <div key={i} className="relative pl-8 md:pl-12">
                    <div className="absolute left-[-5px] top-1 w-2.5 h-2.5 rounded-full bg-[var(--primary)] ring-4 ring-[var(--bg-deep)]" />
                    <span className="text-[var(--primary-light)] font-bold text-sm tracking-wider mb-1 block">{milestone.year}</span>
                    <h3 className="text-xl font-bold text-white mb-2">{milestone.title}</h3>
                    <p className="text-[var(--text-secondary)] text-sm leading-relaxed max-w-2xl">{milestone.description}</p>
                  </div>
                ))}
              </div>
            </div>
          )}

          {/* Team */}
          {teamMembers.length > 0 && (
            <div>
              <div className="text-center mb-10">
                {team?.subtitle && <span className="text-[var(--primary-light)] font-semibold tracking-wider uppercase text-sm">{team.subtitle}</span>}
                <h2 className="text-3xl font-bold text-white mt-2">{team?.title || t.contact.ourTeam}</h2>
              </div>
              <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {teamMembers.map((member, i) => (
                  <div key={i} className="glass-card p-6 text-center">
                    <div className="w-20 h-20 rounded-full mx-auto mb-4 overflow-hidden bg-gradient-to-br from-[var(--primary)] to-[var(--accent)] relative">
                      {member.image ? <Image src={member.image} alt={member.name || ""} fill sizes="80px" className="object-cover" /> : <div className="w-full h-full flex items-center justify-center text-white text-2xl font-bold">{member.name?.[0]}</div>}
                    </div>
                    <h3 className="text-white font-semibold">{member.name}</h3>
                    <p className="text-[var(--text-muted)] text-sm">{member.position}</p>
                  </div>
                ))}
              </div>
            </div>
          )}
        </div>
      </section>
    </>
  );
}
