"use client";

import { FormEvent, useState } from "react";
import Link from "next/link";
import Image from "next/image";
import { submitNewsletter } from "@/lib/api";
import { getDictionary } from "@/lib/dictionary";
import type { FooterContent, GlobalNavigation, NavigationItem, SiteInfo } from "@/lib/types";

function itemLabel(item: NavigationItem, locale: string) {
  return typeof item.label === "string" ? item.label : item.label[locale] || item.label.en || "Link";
}

export function Footer({ locale = "en", siteInfo, footerContent, navigation }: { locale?: string; siteInfo?: SiteInfo; footerContent?: FooterContent; navigation?: GlobalNavigation }) {
  const [email, setEmail] = useState("");
  const [message, setMessage] = useState("");
  const [loading, setLoading] = useState(false);
  const dictionary = getDictionary(locale);
  const configured = (navigation?.navigation || []).filter((item) => item.is_active !== false);
  const serviceLinks = configured.filter((item) => item.location === "footer-services");
  const companyLinks = configured.filter((item) => item.location === "footer-company");
  const fallbackServices = [{ label: dictionary.footer.webDev, url: "/services" }, { label: dictionary.footer.itConsulting, url: "/services" }, { label: dictionary.footer.cloudSolutions, url: "/services" }];
  const fallbackCompany = [{ label: dictionary.nav.about, url: "/about" }, { label: dictionary.nav.projects, url: "/projects" }, { label: dictionary.nav.blog, url: "/blog" }, { label: dictionary.nav.contact, url: "/contact" }];
  const legal = footerContent?.footer_legal_links?.length ? footerContent.footer_legal_links : [{ label: dictionary.footer.privacy, url: "/privacy" }, { label: dictionary.footer.terms, url: "/terms" }];

  async function subscribe(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();
    if (!email || loading) return;
    setLoading(true); setMessage("");
    try { const result = await submitNewsletter(email); setMessage(result.message || "Thank you for subscribing."); setEmail(""); }
    catch { setMessage("Unable to subscribe right now. Please try again."); }
    finally { setLoading(false); }
  }

  const brand = siteInfo?.site_name || "ELMACORE";
  return <footer className="bg-[#06162d] pb-7 pt-16 text-white">
    <div className="site-container">
      <div className="grid gap-10 md:grid-cols-2 lg:grid-cols-[1.65fr_.8fr_.8fr_1.3fr]">
        <div>
          <Link href="/" className="mb-5 inline-flex items-center gap-2.5">{footerContent?.footer_logo ? <Image src={footerContent.footer_logo} alt={brand} width={160} height={32} sizes="160px" className="h-8 max-w-40 object-contain" unoptimized={footerContent.footer_logo.includes("localhost") || footerContent.footer_logo.includes("127.0.0.1")} /> : <><span className="flex h-7 w-7 items-center justify-center bg-[var(--blue)] text-lg font-black">E</span><span className="text-sm font-extrabold tracking-[.04em]">{brand}</span></>}</Link>
          <p className="max-w-xs text-sm leading-6 text-slate-300">{footerContent?.footer_description || dictionary.footer.architecting}</p>
          {(footerContent?.social_links || []).length > 0 && <div className="mt-5 flex flex-wrap gap-2">{footerContent?.social_links?.map((social, index) => <a key={`${social.url}-${index}`} href={social.url} target="_blank" rel="noreferrer" className="rounded border border-slate-600 px-2.5 py-1.5 text-xs font-bold text-slate-200 hover:border-[#78a2ff] hover:text-white">{social.label || social.platform || "Social"}</a>)}</div>}
        </div>
        <FooterColumn title={dictionary.footer.services} links={serviceLinks.length ? serviceLinks.map((item) => ({ label: itemLabel(item, locale), url: item.url })) : fallbackServices} />
        <FooterColumn title={dictionary.footer.company} links={companyLinks.length ? companyLinks.map((item) => ({ label: itemLabel(item, locale), url: item.url })) : fallbackCompany} />
        <div>
          <h2 className="mb-4 text-xs font-extrabold uppercase tracking-[.16em]">{footerContent?.newsletter_title || dictionary.footer.stayUpdated}</h2>
          <p className="mb-4 text-sm leading-6 text-slate-300">{footerContent?.newsletter_description || dictionary.footer.subscribe}</p>
          <form onSubmit={subscribe} className="flex border border-slate-500 p-1">
            <label className="sr-only" htmlFor="newsletter-email">Email address</label><input id="newsletter-email" type="email" required value={email} onChange={(event) => setEmail(event.target.value)} placeholder={footerContent?.newsletter_placeholder || "Your email address"} className="min-w-0 flex-1 bg-transparent px-3 text-sm text-white outline-none placeholder:text-slate-400" />
            <button type="submit" disabled={loading} className="bg-[var(--blue)] px-3 py-2 text-xs font-extrabold disabled:opacity-60">{loading ? "…" : dictionary.footer.join}</button>
          </form>{message && <p className="mt-2 text-xs text-[#a8c3ff]" aria-live="polite">{message}</p>}
        </div>
      </div>
      <div className="mt-12 flex flex-col gap-3 border-t border-slate-700 pt-6 text-xs text-slate-400 sm:flex-row sm:items-center sm:justify-between"><p>© {new Date().getFullYear()} {brand}. {footerContent?.copyright_text || dictionary.footer.allRights}</p><div className="flex gap-5">{legal.map((link) => <Link key={`${link.url}-${link.label}`} href={link.url} className="hover:text-white">{link.label}</Link>)}</div></div>
    </div>
  </footer>;
}

function FooterColumn({ title, links }: { title: string; links: { label: string; url: string }[] }) {
  return <div><h2 className="mb-4 text-xs font-extrabold uppercase tracking-[.16em]">{title}</h2><ul className="space-y-2.5">{links.map((link) => <li key={`${link.url}-${link.label}`}><Link href={link.url} className="text-sm text-slate-300 transition-colors hover:text-[#78a2ff]">{link.label}</Link></li>)}</ul></div>;
}
