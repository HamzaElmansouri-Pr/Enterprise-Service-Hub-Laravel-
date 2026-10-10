"use client";

import { useEffect, useState } from "react";
import Link from "next/link";
import Image from "next/image";
import { usePathname } from "next/navigation";
import { Menu, Search, X } from "lucide-react";
import { LanguageSwitcher } from "./LanguageSwitcher";
import { SearchModal } from "./SearchModal";
import { getDictionary } from "@/lib/dictionary";
import type { GlobalNavigation, NavigationItem, SiteInfo } from "@/lib/types";

const defaultLinks = (locale: string) => {
  const nav = getDictionary(locale).nav;
  return [
    { href: "/", label: nav.home, external: false }, { href: "/services", label: nav.services, external: false },
    { href: "/projects", label: nav.projects, external: false }, { href: "/about", label: nav.about, external: false },
    { href: "/blog", label: nav.blog, external: false }, { href: "/contact", label: nav.contact, external: false },
  ];
};

function labelFor(item: NavigationItem, locale: string): string {
  return typeof item.label === "string" ? item.label : item.label[locale] || item.label.en || "Navigation link";
}

export function Navbar({ locale = "en", siteInfo, navigation }: { locale?: string; siteInfo?: SiteInfo; navigation?: GlobalNavigation }) {
  const [open, setOpen] = useState(false);
  const [searchOpen, setSearchOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const pathname = usePathname();
  const configuredLinks = (navigation?.navigation || [])
    .filter((item) => item.location !== "footer-company" && item.location !== "footer-services" && item.is_active !== false)
    .sort((a, b) => (a.sort_order || 0) - (b.sort_order || 0))
    .map((item) => ({ href: item.url, label: labelFor(item, locale), external: item.open_in_new_tab }));
  const links = configuredLinks.length ? configuredLinks : defaultLinks(locale);
  const cta = { label: navigation?.header_cta_label || getDictionary(locale).nav.getStarted, href: navigation?.header_cta_url || "/contact" };

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 18);
    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  const brand = siteInfo?.site_name || "ELMACORE";

  return (
    <header className={`fixed inset-x-0 top-0 z-50 border-b transition-colors duration-200 ${scrolled ? "border-slate-200 bg-white/96 shadow-sm backdrop-blur" : "border-white/10 bg-[#06162d]/92"}`}>
      <div className="site-container flex h-[72px] items-center justify-between gap-5 lg:grid lg:grid-cols-[1fr_auto_1fr]">
        <Link href="/" className="flex shrink-0 items-center gap-2.5 lg:justify-self-start" aria-label={`${brand} home`}>
          {siteInfo?.logo ? <Image src={siteInfo.logo} alt={brand} width={144} height={32} sizes="144px" className="h-8 max-w-36 object-contain" unoptimized={siteInfo.logo.includes("localhost") || siteInfo.logo.includes("127.0.0.1")} /> : <><span className="flex h-7 w-7 items-center justify-center bg-[var(--blue)] text-lg font-black text-white">E</span><span className={`text-sm font-extrabold tracking-[.04em] ${scrolled ? "text-[var(--ink)]" : "text-white"}`}>{brand}</span></>}
        </Link>

        <nav className="hidden items-center gap-6 lg:flex lg:justify-self-center xl:gap-7" aria-label="Primary navigation">
          {links.map((link) => <Link key={`${link.href}-${link.label}`} href={link.href} target={link.external ? "_blank" : undefined} rel={link.external ? "noreferrer" : undefined} className={`text-[.78rem] font-bold transition-colors ${pathname === link.href ? "!text-[var(--blue)]" : scrolled ? "!text-[var(--ink)] hover:!text-[var(--blue)]" : "!text-slate-100 hover:!text-[#78a2ff]"}`}>{link.label}</Link>)}
        </nav>

        <div className="flex items-center gap-2 lg:justify-self-end">
          <div className={scrolled ? "text-[var(--ink)]" : "text-white"}><LanguageSwitcher /></div>
          <button type="button" onClick={() => setSearchOpen(true)} className={`hidden h-9 w-9 items-center justify-center sm:flex ${scrolled ? "text-[var(--ink)]" : "text-white"}`} aria-label="Search"><Search size={17} /></button>
          <Link href={cta.href} className="button-primary hidden min-h-9 px-4 text-[.7rem] md:inline-flex">{cta.label} <span aria-hidden="true">→</span></Link>
          <button type="button" onClick={() => setOpen((value) => !value)} className={`flex h-9 w-9 items-center justify-center lg:hidden ${scrolled ? "text-[var(--ink)]" : "text-white"}`} aria-label={open ? "Close navigation" : "Open navigation"} aria-expanded={open}>{open ? <X size={22} /> : <Menu size={22} />}</button>
        </div>
      </div>

      {open && <div className="border-t border-slate-200 bg-white lg:hidden"><nav className="site-container flex flex-col py-4" aria-label="Mobile navigation">{links.map((link) => <Link key={`${link.href}-${link.label}`} href={link.href} onClick={() => setOpen(false)} className={`border-b border-slate-100 py-3 text-sm font-bold ${pathname === link.href ? "text-[var(--blue)]" : "text-[var(--ink)]"}`}>{link.label}</Link>)}<Link href={cta.href} onClick={() => setOpen(false)} className="button-primary mt-4">{cta.label} →</Link></nav></div>}
      <SearchModal isOpen={searchOpen} onClose={() => setSearchOpen(false)} locale={locale} />
    </header>
  );
}
