"use client";

import { useState, useRef, useEffect } from "react";
import { motion, AnimatePresence } from "framer-motion";
import { Globe } from "lucide-react";

const languages = [
  { code: "en", name: "English", short: "EN" },
  { code: "fr", name: "Français", short: "FR" },
  { code: "ar", name: "العربية", short: "AR" },
];

export function LanguageSwitcher() {
  const [isOpen, setIsOpen] = useState(false);
  const [currentLang, setCurrentLang] = useState(languages[0]);
  const dropdownRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    // Get current locale from cookie
    const match = document.cookie.match(/(?:^|; )NEXT_LOCALE=([^;]*)/);
    if (match && match[1]) {
      const lang = languages.find((l) => l.code === match[1]);
      // eslint-disable-next-line react-hooks/set-state-in-effect
      if (lang) setCurrentLang(lang);
    }
  }, []);

  useEffect(() => {
    function handleClickOutside(event: MouseEvent) {
      if (dropdownRef.current && !dropdownRef.current.contains(event.target as Node)) {
        setIsOpen(false);
      }
    }
    document.addEventListener("mousedown", handleClickOutside);
    return () => document.removeEventListener("mousedown", handleClickOutside);
  }, []);

  const switchLanguage = (langCode: string) => {
    // Set cookie
    // eslint-disable-next-line react-hooks/immutability
    document.cookie = `NEXT_LOCALE=${langCode}; path=/; max-age=31536000`; // 1 year
    
    // Auto RTL setup handled in layout, but we need to trigger hard reload
    // to re-fetch Server Components with new Locale header
    window.location.reload();
  };

  return (
    <div className="relative" ref={dropdownRef}>
      <button
        onClick={() => setIsOpen(!isOpen)}
        className="flex items-center gap-1 px-2 py-2 text-[.68rem] font-bold text-current opacity-90 transition-opacity hover:opacity-100"
        aria-label="Change language"
      >
        <Globe className="w-4 h-4" />
        <span>{currentLang.short}</span>
      </button>

      <AnimatePresence>
        {isOpen && (
          <motion.div
            initial={{ opacity: 0, y: 10, scale: 0.95 }}
            animate={{ opacity: 1, y: 0, scale: 1 }}
            exit={{ opacity: 0, y: 10, scale: 0.95 }}
            transition={{ duration: 0.2 }}
            className="absolute right-0 mt-2 w-32 rounded-md border border-slate-200 bg-white p-1.5 text-[var(--ink)] shadow-xl z-50 overflow-hidden"
          >
            <div className="flex flex-col space-y-1">
              {languages.map((lang) => (
                <button
                  key={lang.code}
                  onClick={() => switchLanguage(lang.code)}
                  className={`text-left px-3 py-2 rounded-lg text-sm transition-colors ${
                    currentLang.code === lang.code
                      ? "bg-[var(--blue-pale)] text-[var(--blue)] font-bold"
                      : "text-[var(--ink-soft)] hover:bg-slate-50 hover:text-[var(--ink)]"
                  }`}
                >
                  {lang.name}
                </button>
              ))}
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </div>
  );
}
