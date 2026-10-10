import Link from "next/link";

interface CTA { title: string; subtitle: string; description: string; button_text: string; button_url?: string; eyebrow?: string; visual_variant?: "primary" | "dark" | "light"; }
export function CTASection({ cta }: { cta: CTA | null }) {
  if (!cta) return null;
  const isDark = cta.visual_variant === "dark";
  const isLight = cta.visual_variant === "light";
  const title = cta.title?.trim() || "Let’s build what’s next.";
  const buttonLabel = cta.button_text?.trim() || "Start a conversation";
  return <section className={`relative overflow-hidden py-12 ${isDark ? "bg-[#06162d]" : isLight ? "bg-[var(--mist)]" : "bg-[var(--blue)]"}`}><div className={`absolute -right-16 -bottom-44 h-[470px] w-[470px] rounded-full border-[48px] ${isLight ? "border-[#bcd2ff]" : "border-white/10"}`} /><div className={`site-container relative py-12 ${isLight ? "text-[var(--ink)]" : "text-white"}`}><span className={`eyebrow ${isLight ? "text-[var(--blue)]" : "text-[#c5d6ff]"}`}>{cta.eyebrow || cta.subtitle}</span><h2 className="max-w-3xl text-[clamp(2.2rem,4.3vw,4.3rem)] font-extrabold leading-none tracking-[-.06em]">{title}</h2>{cta.description && <p className={`mt-4 max-w-2xl text-[1.05rem] leading-7 ${isLight ? "text-[var(--ink-soft)]" : "text-white/90"}`}>{cta.description}</p>}<Link href={cta.button_url || "/contact"} className={`mt-7 inline-flex min-h-11 items-center gap-2 rounded px-5 text-sm font-extrabold transition ${isLight ? "button-primary" : "bg-white !text-[#06172f] hover:bg-slate-100"}`}>{buttonLabel} <span>↗</span></Link></div></section>;
}
