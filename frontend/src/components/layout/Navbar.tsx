"use client";

import { useState, useEffect } from "react";
import Link from "next/link";
import { usePathname } from "next/navigation";
import { motion, AnimatePresence } from "framer-motion";
import { Menu, X } from "lucide-react";
import { Search } from "lucide-react";
import { LanguageSwitcher } from "./LanguageSwitcher";
import { SearchModal } from "./SearchModal";

import { getDictionary } from "@/lib/dictionary";

export function Navbar({ locale = "en", siteInfo = {} }: { locale?: string, siteInfo?: Record<string, string> }) {
  const [isOpen, setIsOpen] = useState(false);
  const [isSearchOpen, setIsSearchOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const pathname = usePathname();
  const t = getDictionary(locale).nav;

  const navLinks = [
    { href: "/", label: t.home },
    { href: "/about", label: t.about },
    { href: "/services", label: t.services },
    { href: "/projects", label: t.projects },
    { href: "/blog", label: t.blog },
    { href: "/contact", label: t.contact },
  ];


  useEffect(() => {
    const handleScroll = () => setScrolled(window.scrollY > 50);
    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  useEffect(() => {
    // eslint-disable-next-line react-hooks/set-state-in-effect
    setIsOpen(false);
  }, [pathname]);

  return (
    <motion.header
      initial={{ y: -100, opacity: 0 }}
      animate={{ y: 0, opacity: 1 }}
      transition={{ duration: 0.8, ease: [0.16, 1, 0.3, 1] }}
      className={`fixed top-0 left-0 right-0 z-50 transition-all duration-500 ${scrolled ? "py-4" : "py-6"
        }`}
    >
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav
          className={`flex items-center justify-between transition-all duration-500 mx-auto ${scrolled
              ? "elite-glass rounded-full px-6 py-3 max-w-5xl shadow-[0_8px_30px_rgb(0,0,0,0.4)]"
              : "px-2 py-2"
            }`}
        >
          {/* Logo */}
          <Link href="/" className="flex items-center gap-3 group focus-ring rounded-full" aria-label={siteInfo.site_name || "ELMA Core Home"}>
            {siteInfo.logo ? (
              <img src={siteInfo.logo} alt={siteInfo.site_name || "Logo"} className="h-10 w-auto" />
            ) : (
              <div className="w-10 h-10 rounded-full bg-gradient-to-br from-[var(--primary)] to-[var(--accent)] flex items-center justify-center shadow-lg group-hover:shadow-[var(--primary-glow)] transition-all duration-300 relative overflow-hidden">
                <span className="text-white font-bold text-lg relative z-10">
                  {(siteInfo.site_name || "EC")[0]}
                </span>
                <div className="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300" />
              </div>
            )}
            <span className="text-xl font-bold text-white hidden sm:block tracking-tight">
              {siteInfo.site_name ? (
                <>
                  {siteInfo.site_name.split(' ')[0]}<span className="text-[var(--primary-light)]">{siteInfo.site_name.substring(siteInfo.site_name.indexOf(' ') + 1)}</span>
                </>
              ) : (
                <>ELMA<span className="text-[var(--primary-light)]">Core</span></>
              )}
            </span>
          </Link>

          {/* Desktop Nav */}
          <div className="hidden md:flex items-center gap-1 bg-[var(--bg-deep)]/40 p-1 rounded-full border border-white/5 backdrop-blur-md">
            {navLinks.map((link) => {
              const isActive = pathname === link.href;
              return (
                <Link
                  key={link.href}
                  href={link.href}
                  className={`relative px-5 py-2 rounded-full text-sm font-medium transition-colors duration-300 focus-ring ${isActive ? "text-white" : "text-[var(--text-muted)] hover:text-white"
                    }`}
                >
                  {isActive && (
                    <motion.div
                      layoutId="activeNav"
                      className="absolute inset-0 bg-gradient-to-r from-[var(--primary)] to-[var(--primary-glow)] rounded-full shadow-[0_0_15px_var(--primary-transparent)]"
                      transition={{ type: "spring", stiffness: 400, damping: 30 }}
                    />
                  )}
                  <span className="relative z-10">{link.label}</span>
                </Link>
              );
            })}
          </div>

          {/* CTA + Mobile Toggle */}
          <div className="flex items-center gap-4">
            {/* Language Switcher */}
            <div className="hidden md:block border-r border-white/10 pr-4 mr-1">
              <LanguageSwitcher />
            </div>

            <button
              onClick={() => setIsSearchOpen(true)}
              className="relative w-10 h-10 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-white focus-ring hover:bg-white/10 transition-colors"
              aria-label="Search"
            >
              <Search className="w-5 h-5" />
            </button>

            <Link
              href="/contact"
              className="hidden md:inline-flex relative group px-6 py-2.5 rounded-full overflow-hidden focus-ring"
            >
              <div className="absolute inset-0 bg-gradient-to-r from-[var(--primary)] to-[var(--accent)] opacity-80 group-hover:opacity-100 transition-opacity duration-300" />
              <div className="absolute inset-0 bg-gradient-to-r from-[var(--primary-light)] to-[var(--primary)] opacity-0 group-hover:opacity-100 blur-xl transition-opacity duration-300" />
              <span className="relative z-10 text-white text-sm font-semibold tracking-wide">
                {t.getStarted}
              </span>
            </Link>

            {/* Mobile burger */}
            <button
              onClick={() => setIsOpen(!isOpen)}
              className="md:hidden relative w-10 h-10 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-white focus-ring"
              aria-label={isOpen ? "Close menu" : "Open menu"}
              aria-expanded={isOpen}
              aria-controls="mobile-menu"
            >
              <AnimatePresence mode="wait">
                {isOpen ? (
                  <motion.div key="close" initial={{ rotate: -90, opacity: 0 }} animate={{ rotate: 0, opacity: 1 }} exit={{ rotate: 90, opacity: 0 }}>
                    <X className="w-5 h-5" />
                  </motion.div>
                ) : (
                  <motion.div key="menu" initial={{ rotate: 90, opacity: 0 }} animate={{ rotate: 0, opacity: 1 }} exit={{ rotate: -90, opacity: 0 }}>
                    <Menu className="w-5 h-5" />
                  </motion.div>
                )}
              </AnimatePresence>
            </button>
          </div>
        </nav>

        {/* Mobile Menu */}
        <AnimatePresence>
          {isOpen && (
            <motion.div
              id="mobile-menu"
              initial={{ opacity: 0, y: -20, scale: 0.95 }}
              animate={{ opacity: 1, y: 10, scale: 1 }}
              exit={{ opacity: 0, y: -20, scale: 0.95 }}
              transition={{ duration: 0.3, ease: [0.16, 1, 0.3, 1] }}
              className="md:hidden absolute left-4 right-4 elite-glass rounded-2xl p-4 shadow-2xl"
            >
              <div className="flex flex-col space-y-1">
                <div className="flex items-center justify-between px-4 py-2 border-b border-white/10 mb-2">
                  <span className="text-sm font-medium text-[var(--text-muted)]">{t.language}</span>
                  <LanguageSwitcher />
                </div>
                {navLinks.map((link, i) => {
                  const isActive = pathname === link.href;
                  return (
                    <motion.div
                      key={link.href}
                      initial={{ opacity: 0, x: -20 }}
                      animate={{ opacity: 1, x: 0 }}
                      transition={{ delay: i * 0.05 }}
                    >
                      <Link
                        href={link.href}
                        className={`block px-4 py-3 rounded-xl text-base font-medium transition-all focus-ring ${isActive
                            ? "bg-[var(--primary-transparent)] text-white border border-[var(--primary)]/30"
                            : "text-[var(--text-muted)] hover:bg-white/5 hover:text-white"
                          }`}
                      >
                        {link.label}
                      </Link>
                    </motion.div>
                  );
                })}
                <motion.div
                  initial={{ opacity: 0, y: 10 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ delay: navLinks.length * 0.05 }}
                  className="pt-4 mt-2 border-t border-white/10"
                >
                  <Link
                    href="/contact"
                    className="block w-full text-center px-4 py-3 rounded-xl bg-gradient-to-r from-[var(--primary)] to-[var(--accent)] text-white font-semibold focus-ring"
                  >
                    {t.getStarted}
                  </Link>
                </motion.div>
              </div>
            </motion.div>
          )}
        </AnimatePresence>
      </div>

      <SearchModal isOpen={isSearchOpen} onClose={() => setIsSearchOpen(false)} locale={locale} />
    </motion.header>
  );
}
