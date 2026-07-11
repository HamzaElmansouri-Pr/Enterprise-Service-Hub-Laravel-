import type { Metadata } from "next";
import { getAboutPage } from "@/lib/api";
import { Breadcrumb } from "@/components/ui/Breadcrumb";

import { cookies } from "next/headers";
import { getDictionary } from "@/lib/dictionary";

export async function generateMetadata(): Promise<Metadata> {
  const cookieStore = await cookies();
  const locale = cookieStore.get("NEXT_LOCALE")?.value || "en";
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
  const { about, stats, values, team } = page;

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
                    <img src={about.image} alt="About" className="w-full h-auto" />
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
          {stats && stats.length > 0 && (
            <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
              {stats.map((stat, i) => (
                <div key={i} className="glass-card p-8 text-center">
                  <span className="block text-3xl font-bold gradient-text mb-2">{stat.value}</span>
                  <span className="text-[var(--text-muted)] text-sm">{stat.label}</span>
                </div>
              ))}
            </div>
          )}

          {/* Values */}
          {values && values.length > 0 && (
            <div>
              <h2 className="text-3xl font-bold text-white mb-10 text-center">{t.contact.ourValues}</h2>
              <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                {values.map((value, i) => (
                  <div key={i} className="glass-card p-8">
                    <div className="w-12 h-12 rounded-xl bg-gradient-to-br from-[var(--primary)]/20 to-[var(--accent)]/10 flex items-center justify-center text-xl mb-4">{i === 0 ? "🎯" : i === 1 ? "💡" : "🤝"}</div>
                    <h3 className="text-lg font-bold text-white mb-3">{value.title}</h3>
                    <p className="text-[var(--text-secondary)] text-sm leading-relaxed">{value.description}</p>
                  </div>
                ))}
              </div>
            </div>
          )}

          {/* Team */}
          {team && team.length > 0 && (
            <div>
              <h2 className="text-3xl font-bold text-white mb-10 text-center">{t.contact.ourTeam}</h2>
              <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {team.map((member, i) => (
                  <div key={i} className="glass-card p-6 text-center">
                    <div className="w-20 h-20 rounded-full mx-auto mb-4 overflow-hidden bg-gradient-to-br from-[var(--primary)] to-[var(--accent)]">
                      {member.image ? <img src={member.image} alt={member.name} className="w-full h-full object-cover" /> : <div className="w-full h-full flex items-center justify-center text-white text-2xl font-bold">{member.name?.[0]}</div>}
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
