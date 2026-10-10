"use client";

import { useEffect, useState } from "react";
import Image from "next/image";
import type { Review } from "@/lib/types";

export function Testimonials({ reviews, title, eyebrow }: { reviews: Review[]; title: string | null; subtitle: string | null; eyebrow?: string | null }) {
  const [active, setActive] = useState(0);
  useEffect(() => { if (reviews.length < 2) return; const timer = window.setInterval(() => setActive((value) => (value + 1) % reviews.length), 8000); return () => window.clearInterval(timer); }, [reviews.length]);
  if (!reviews.length) return null;
  const review = reviews[active];
  const heading = title || eyebrow || "Client perspectives";
  return <section className="relative overflow-hidden bg-[#06162d] py-20 text-white"><div className="absolute -right-32 -top-48 h-[520px] w-[520px] rounded-full border border-[#1e63ed] opacity-70" /><div className="site-container relative"><h2 className="eyebrow eyebrow--light">{heading}</h2><div className="grid gap-9 lg:grid-cols-[1fr_auto]"><div><blockquote className="max-w-4xl text-[clamp(1.625rem,2.4vw,2.125rem)] font-medium leading-[1.28] tracking-[-.04em]">“{review.review_text}”</blockquote><div className="mt-8 flex items-center gap-3">{review.client_image ? <Image src={review.client_image} alt={review.client_name} width={42} height={42} className="h-10 w-10 rounded-full object-cover" unoptimized={review.client_image.includes("localhost") || review.client_image.includes("127.0.0.1")} /> : <span className="flex h-10 w-10 items-center justify-center rounded-full bg-[#759ce7] text-xs font-bold">{review.client_name?.[0] || "C"}</span>}<div><p className="text-sm font-bold">{review.client_name}</p><p className="text-xs text-slate-300">{[review.client_position, review.client_company].filter(Boolean).join(" · ")}</p></div></div></div><div className="flex items-end gap-3"><button onClick={() => setActive((active - 1 + reviews.length) % reviews.length)} aria-label="Previous testimonial" className="flex h-11 w-11 items-center justify-center rounded-full border border-[#4678c8] text-xl hover:bg-[#1558ff]">←</button><button onClick={() => setActive((active + 1) % reviews.length)} aria-label="Next testimonial" className="flex h-11 w-11 items-center justify-center rounded-full border border-[#4678c8] text-xl hover:bg-[#1558ff]">→</button></div></div></div></section>;
}
