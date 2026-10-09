"use client";

import { getDictionary } from "@/lib/dictionary";
import Link from "next/link";
import { useState } from "react";
import { submitNewsletter } from "@/lib/api";
const Linkedin = (props: any) => (<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" {...props}><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>);
const Twitter = (props: any) => (<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" {...props}><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>);
const Github = (props: any) => (<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" {...props}><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>);

export function Footer({ locale = "en" }: { locale?: string }) {
  const t = getDictionary(locale).footer;

  const footerLinks = {
    services: [
      { label: t.webDev, href: "/services" },
      { label: t.itConsulting, href: "/services" },
      { label: t.cloudSolutions, href: "/services" },
      { label: t.cybersecurity, href: "/services" },
    ],
    company: [
      { label: getDictionary(locale).nav.about, href: "/about" },
      { label: getDictionary(locale).nav.projects, href: "/projects" },
      { label: getDictionary(locale).nav.blog, href: "/blog" },
      { label: getDictionary(locale).nav.contact, href: "/contact" },
    ],
  };

  const [email, setEmail] = useState("");
  const [status, setStatus] = useState<"idle" | "loading" | "success" | "error">("idle");
  const [message, setMessage] = useState("");

  const handleSubscribe = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!email) return;

    setStatus("loading");
    setMessage("");

    try {
      const res = await submitNewsletter(email);
      setStatus("success");
      setMessage(res.message || "Thank you for subscribing!");
      setEmail("");
    } catch (error: any) {
      setStatus("error");
      setMessage(error.message || "An error occurred.");
    }
  };

  return (
    <footer className="relative bg-[var(--bg-abyss)] pt-20 pb-10 overflow-hidden border-t border-white/5">
      {/* Decorative Orbs */}
      <div className="absolute top-0 left-1/4 w-96 h-96 bg-[var(--primary)]/5 rounded-full blur-[80px] mix-blend-screen pointer-events-none" />
      <div className="absolute top-0 right-1/4 w-96 h-96 bg-[var(--accent)]/5 rounded-full blur-[80px] mix-blend-screen pointer-events-none" />

      {/* Top Gradient Line */}
      <div className="absolute top-0 left-0 right-0 h-[1px] bg-gradient-to-r from-transparent via-white/10 to-transparent" />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8 mb-16">
          {/* Brand */}
          <div className="lg:col-span-4">
            <Link href="/" className="flex items-center gap-3 mb-6 group">
              <div className="w-12 h-12 rounded-xl bg-gradient-to-br from-[var(--primary)] to-[var(--accent)] p-[1px] shadow-[0_0_20px_rgba(59,130,246,0.3)] group-hover:shadow-[0_0_30px_rgba(59,130,246,0.5)] transition-shadow duration-300">
                <div className="w-full h-full bg-[var(--bg-deep)] rounded-[11px] flex items-center justify-center">
                  <span className="text-white font-bold text-xl group-hover:scale-110 transition-transform duration-300">N</span>
                </div>
              </div>
              <span className="text-2xl font-bold text-white tracking-tight">
                Nova<span className="text-[var(--primary-light)]">Agency</span>
              </span>
            </Link>
            <p className="text-[var(--text-secondary)] text-sm leading-relaxed mb-8 max-w-sm font-light">
              {t.architecting}
            </p>
            {/* Social links */}
            <div className="flex gap-4">
              {[
                { name: "LinkedIn", url: "#", icon: Linkedin },
                { name: "Twitter", url: "#", icon: Twitter },
                { name: "GitHub", url: "#", icon: Github }
              ].map((social) => {
                const Icon = social.icon;
                return (
                  <a
                    key={social.name}
                    href={social.url}
                    target={social.url === "#" ? "_self" : "_blank"}
                    rel="noopener noreferrer"
                    className="w-10 h-10 rounded-xl elite-glass flex items-center justify-center text-[var(--text-muted)] hover:text-white hover:border-white/20 transition-all duration-300 hover:-translate-y-1 group"
                    aria-label={social.name}
                  >
                    <Icon className="w-5 h-5 group-hover:scale-110 transition-transform" />
                  </a>
                );
              })}
            </div>
          </div>

          {/* Services */}
          <div className="lg:col-span-2 lg:col-start-6">
            <h3 className="text-white font-semibold mb-6 text-sm uppercase tracking-[0.2em]">
              {t.services}
            </h3>
            <ul className="space-y-4">
              {footerLinks.services.map((link) => (
                <li key={link.label}>
                  <Link
                    href={link.href}
                    className="group flex items-center text-[var(--text-secondary)] text-sm hover:text-white transition-colors duration-300"
                  >
                    <span className={`w-0 h-px bg-[var(--primary-light)] ${locale === 'ar' ? 'ml-0 group-hover:ml-2' : 'mr-0 group-hover:mr-2'} opacity-0 group-hover:w-4 group-hover:opacity-100 transition-all duration-300`} />
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Company */}
          <div className="lg:col-span-2">
            <h3 className="text-white font-semibold mb-6 text-sm uppercase tracking-[0.2em]">
              {t.company}
            </h3>
            <ul className="space-y-4">
              {footerLinks.company.map((link) => (
                <li key={link.label}>
                  <Link
                    href={link.href}
                    className="group flex items-center text-[var(--text-secondary)] text-sm hover:text-white transition-colors duration-300"
                  >
                    <span className={`w-0 h-px bg-[var(--primary-light)] ${locale === 'ar' ? 'ml-0 group-hover:ml-2' : 'mr-0 group-hover:mr-2'} opacity-0 group-hover:w-4 group-hover:opacity-100 transition-all duration-300`} />
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Newsletter */}
          <div className="lg:col-span-3">
            <h3 className="text-white font-semibold mb-6 text-sm uppercase tracking-[0.2em]">
              {t.stayUpdated}
            </h3>
            <p className="text-[var(--text-secondary)] text-sm mb-6 font-light">
              {t.subscribe}
            </p>
            <form className="relative group" onSubmit={handleSubscribe}>
              <div className="absolute -inset-0.5 bg-gradient-to-r from-[var(--primary)] to-[var(--accent)] rounded-xl opacity-0 group-hover:opacity-30 blur transition duration-500" />
              <div className="relative flex p-1 bg-[var(--bg-deep)] rounded-xl border border-white/10">
                <input
                  type="email"
                  placeholder="your@email.com"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  disabled={status === "loading"}
                  className="flex-1 bg-transparent px-4 py-3 text-white text-sm placeholder:text-white/30 focus:outline-none disabled:opacity-50"
                  required
                />
                <button
                  type="submit"
                  disabled={status === "loading"}
                  className="px-5 py-3 rounded-lg bg-gradient-to-r from-[var(--primary)] to-[var(--primary-dark)] text-white text-sm font-semibold hover:shadow-[0_0_15px_rgba(59,130,246,0.5)] transition-shadow duration-300 disabled:opacity-50"
                >
                  {status === "loading" ? "..." : t.join}
                </button>
              </div>
            </form>
            {message && (
              <p className={`mt-3 text-sm ${status === "success" ? "text-green-400" : "text-red-400"}`}>
                {message}
              </p>
            )}
          </div>
        </div>

        {/* Bottom bar */}
        <div className="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4">
          <p className="text-[var(--text-muted)] text-sm font-light tracking-wide">
            © {new Date().getFullYear()} ELMA Core. {t.allRights}
          </p>
          <div className="flex gap-8">
            <Link href="/privacy" className="text-[var(--text-muted)] text-sm font-light hover:text-white transition-colors">
              {t.privacy}
            </Link>
            <Link href="/terms" className="text-[var(--text-muted)] text-sm font-light hover:text-white transition-colors">
              {t.terms}
            </Link>
          </div>
        </div>
      </div>
    </footer>
  );
}
