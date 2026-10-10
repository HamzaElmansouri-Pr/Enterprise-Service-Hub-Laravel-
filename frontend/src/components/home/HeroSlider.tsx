"use client";

import { useEffect, useMemo, useState, type CSSProperties } from "react";
import Link from "next/link";
import Image from "next/image";
import type { Slider } from "@/lib/types";
import { isKnownSeededHero, resolveHeroPresentationImage } from "@/lib/demoMedia";

interface HeroSliderProps { sliders: Slider[]; cms: { heroTitle: string | null; heroSubtitle: string | null; heroButtonText: string | null; heroImage: string | null; }; }
const fallbackSlide: Slider = { id: 0, title: null, subtitle: null, description: null, badge_text: null, button_text: null, button_url: "/contact", secondary_button_text: "Explore our work", secondary_button_url: "/projects", alignment: "left", overlay_opacity: 75, text_theme: null, video_url: null, title_color: null, subtitle_color: null, description_color: null, image: null, is_active: true, sort_order: 0 };

function normaliseOverlayOpacity(value: Slider["overlay_opacity"]) {
  if (typeof value === "number" && Number.isFinite(value)) return Math.min(1, Math.max(0, value > 1 ? value / 100 : value));
  const numeric = Number(value);
  if (Number.isFinite(numeric) && value !== "") return Math.min(1, Math.max(0, numeric > 1 ? numeric / 100 : numeric));
  return ({ none: .18, low: .42, medium: .66, high: .82 } as Record<string, number>)[String(value || "").toLowerCase()] ?? .75;
}

export function HeroSlider({ sliders, cms }: HeroSliderProps) {
  const [current, setCurrent] = useState(0);
  const [reduceMotion, setReduceMotion] = useState(false);
  const [failedImageSource, setFailedImageSource] = useState<string | null>(null);
  const [failedVideoSource, setFailedVideoSource] = useState<string | null>(null);
  const slides = sliders.length ? sliders : [fallbackSlide];
  useEffect(() => {
    const preference = window.matchMedia("(prefers-reduced-motion: reduce)");
    const updatePreference = () => setReduceMotion(preference.matches);
    updatePreference();
    preference.addEventListener("change", updatePreference);
    return () => preference.removeEventListener("change", updatePreference);
  }, []);
  useEffect(() => {
    if (slides.length < 2 || reduceMotion) return;
    const timer = window.setInterval(() => setCurrent((value) => (value + 1) % slides.length), 7000);
    return () => window.clearInterval(timer);
  }, [reduceMotion, slides.length]);
  const activeIndex = current % slides.length;
  const slide = slides[activeIndex];
  const configuredImage = slide.image || cms.heroImage;
  const usesSeededHeroFallback = isKnownSeededHero(configuredImage);
  const resolvedImage = resolveHeroPresentationImage(configuredImage);
  const image = failedImageSource !== resolvedImage ? resolvedImage : "/images/hero-architecture-fallback.png";
  const headline = slide.title || cms.heroTitle || "Technology that moves your business forward.";
  const headlineParts = headline.trim().split(/\s+/);
  const accentWord = headlineParts.pop();
  const alignment = ["left", "center", "right"].includes(slide.alignment || "") ? slide.alignment : "left";
  const overlayOpacity = normaliseOverlayOpacity(slide.overlay_opacity);
  const heroStyle = useMemo(() => ({ "--hero-overlay-opacity": String(overlayOpacity) }) as CSSProperties, [overlayOpacity]);
  const textStyles = {
    eyebrow: slide.subtitle_color ? { color: slide.subtitle_color } : undefined,
    title: slide.title_color ? { color: slide.title_color } : undefined,
    description: slide.description_color ? { color: slide.description_color } : undefined,
  };
  const changeSlide = (direction: -1 | 1) => {
    setCurrent((value) => (value + direction + slides.length) % slides.length);
  };
  return <section className={`hero-shell hero-shell--${alignment} ${slide.text_theme === "dark" ? "hero-shell--dark-text" : ""}`} style={heroStyle}>
    {image && <Image src={image} alt="" fill priority sizes="100vw" className={`hero-shell__image ${usesSeededHeroFallback ? `hero-shell__image--demo-${activeIndex % 3}` : ""}`} onError={() => setFailedImageSource(resolvedImage)} unoptimized={image.includes("localhost") || image.includes("127.0.0.1")} />}
    {slide.video_url && failedVideoSource !== slide.video_url && <video className="hero-shell__video" autoPlay={!reduceMotion} muted loop playsInline poster={image} onError={() => setFailedVideoSource(slide.video_url)}><source src={slide.video_url} /></video>}
    <div className="hero-shell__wash" />
    <div className="site-container hero-shell__grid"><div className={`hero-shell__copy hero-shell__copy--${alignment}`}>
      <p className="hero-shell__eyebrow" style={textStyles.eyebrow}>{slide.badge_text || slide.subtitle || cms.heroSubtitle || "Software · cloud · IT consulting"}</p>
      <h1 style={textStyles.title}>{headlineParts.join(" ")}{headlineParts.length > 0 && " "}{accentWord && <em style={slide.title_color ? { color: "inherit" } : undefined}>{accentWord}</em>}</h1>
      <p className="hero-shell__description" style={textStyles.description}>{slide.description || "We design, build and connect digital solutions around the way your business works."}</p>
      <div className="hero-shell__actions"><Link href={slide.button_url || "/contact"} className="button-primary">{slide.button_text || cms.heroButtonText || "Discuss your project"} <span>↗</span></Link><Link href={slide.secondary_button_url || "/projects"} className="button-secondary button-secondary--light">{slide.secondary_button_text || "Explore our work"} <span>→</span></Link></div>
      <div className="hero-shell__controls"><span>{String(activeIndex + 1).padStart(2, "0")} / {String(slides.length).padStart(2, "0")}</span><button onClick={() => changeSlide(-1)} aria-label="Previous slide">←</button><button onClick={() => changeSlide(1)} aria-label="Next slide">→</button></div>
    </div><div aria-hidden="true" /></div>
  </section>;
}
