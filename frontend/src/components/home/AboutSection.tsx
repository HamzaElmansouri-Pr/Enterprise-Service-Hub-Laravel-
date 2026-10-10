import Link from "next/link";
import { ContentImage } from "@/components/ui/ContentImage";
import { isLegacyBrandCopy, resolveAboutPresentationImage } from "@/lib/demoMedia";

type Feature = string | { title: string; description?: string; icon?: string };
interface About { title: string; subtitle: string; description: string; image?: string; eyebrow?: string; highlight_value?: string; highlight_suffix?: string; highlight_label?: string; button_text?: string; button_url?: string; meta_data?: { features: Feature[] }; }

export function AboutSection({ about }: { about: About | null }) {
  if (!about) return null;
  const features = about.meta_data?.features || [];
  const eyebrow = about.eyebrow || (isLegacyBrandCopy(about.subtitle) ? "Your technology partner" : about.subtitle);
  return <section className="page-section bg-white"><div className="site-container grid items-center gap-12 lg:grid-cols-[.96fr_1.04fr] lg:gap-16">
    <div className="relative min-h-[340px] overflow-hidden bg-slate-200 sm:min-h-[440px]"><ContentImage src={resolveAboutPresentationImage(about.image)} alt={about.title} sizes="(max-width: 1024px) 100vw, 48vw" className="object-cover" fallbackClassName="about-image-placeholder" />{about.highlight_value && <div className="absolute bottom-0 right-0 bg-[var(--blue)] px-7 py-5 text-white"><strong className="block text-3xl tracking-[-.06em]">{about.highlight_value}{about.highlight_suffix}</strong><span className="text-xs font-bold uppercase tracking-[.12em]">{about.highlight_label}</span></div>}</div>
    <div><span className="eyebrow">{eyebrow}</span><h2 className="display-title max-w-[760px] text-[clamp(2.1rem,3.2vw,3.65rem)]">{about.title}</h2><p className="section-copy mt-6">{about.description}</p>{features.length > 0 && <div className="mt-7 space-y-3">{features.slice(0, 3).map((feature, index) => { const item = typeof feature === "string" ? { title: feature } : feature; return <div key={`${item.title}-${index}`} className="flex gap-3"><span className="mt-1 flex h-5 w-5 shrink-0 items-center justify-center rounded-full border border-[var(--blue)] text-xs text-[var(--blue)]">✓</span><div><strong className="text-sm text-[var(--ink)]">{item.title}</strong>{item.description && <p className="mt-1 text-sm text-[var(--muted)]">{item.description}</p>}</div></div>; })}</div>}{about.button_text && <Link href={about.button_url || "/about"} className="arrow-link mt-8">{about.button_text}</Link>}</div>
  </div></section>;
}
