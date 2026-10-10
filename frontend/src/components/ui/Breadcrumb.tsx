import Link from "next/link";

interface BreadcrumbProps { title: string; image?: string | null; items?: { label: string; href?: string }[]; }
export function Breadcrumb({ title, image, items = [] }: BreadcrumbProps) {
  return <section className="relative isolate overflow-hidden bg-[#06162d] pb-20 pt-36 text-white"><div className="absolute inset-0 -z-20 bg-cover bg-center opacity-30" style={image ? { backgroundImage: `url(${image})` } : undefined} /><div className="absolute inset-0 -z-10 bg-[linear-gradient(100deg,rgba(6,22,45,.98),rgba(6,22,45,.75))]" /><div className="site-container"><nav className="flex flex-wrap items-center gap-2 text-xs font-bold text-slate-300"><Link href="/" className="hover:text-white">Home</Link>{items.map((item) => <span key={`${item.label}-${item.href || "current"}`} className="flex items-center gap-2"><span className="text-slate-500">/</span>{item.href ? <Link href={item.href} className="hover:text-white">{item.label}</Link> : <span className="text-[#8db1ff]">{item.label}</span>}</span>)}</nav><h1 className="mt-7 max-w-4xl text-[clamp(2.7rem,5vw,5rem)] font-extrabold leading-none tracking-[-.06em]">{title}</h1></div></section>;
}
