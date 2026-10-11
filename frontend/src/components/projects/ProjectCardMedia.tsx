"use client";

import Image from "next/image";
import { useState } from "react";
import { resolveCmsMediaUrl } from "@/lib/api";
import { isKnownSeededPlaceholder } from "@/lib/demoMedia";

type ProjectCardMediaProps = {
  image: string | null;
  title: string;
  index: number;
};

const fallbackBackgrounds = [
  "linear-gradient(135deg, #dfeeff 0%, #f8fbff 48%, #a9cbff 100%)",
  "linear-gradient(135deg, #071c3b 0%, #123f83 50%, #1f68e8 100%)",
  "linear-gradient(135deg, #f2f7ff 0%, #d4e5fb 52%, #93bbf4 100%)",
];

/**
 * Real CMS uploads are always rendered. The only replacement is for the
 * named local seed images (and failed media), which get a neutral visual
 * treatment instead of a dimension-labelled or duplicated demo image.
 */
export function ProjectCardMedia({ image, title, index }: ProjectCardMediaProps) {
  const source = resolveCmsMediaUrl(image);
  const [failed, setFailed] = useState(!source || isKnownSeededPlaceholder(source));
  const isLocalCmsMedia = /^https?:\/\/(?:localhost|127\.0\.0\.1)(?::\d+)?\//.test(source || "");

  if (failed || !source || isKnownSeededPlaceholder(source)) {
    const darkTreatment = index % fallbackBackgrounds.length === 1;

    return (
      <div
        aria-hidden="true"
        className="absolute inset-0 overflow-hidden"
        style={{ background: fallbackBackgrounds[index % fallbackBackgrounds.length] }}
      >
        <div className={`absolute -right-[12%] top-[12%] h-[84%] w-[47%] -skew-x-[18deg] border border-white/65 ${darkTreatment ? "bg-white/10" : "bg-white/40"}`} />
        <div className={`absolute bottom-[-18%] left-[11%] h-[82%] w-[33%] rotate-[17deg] border border-white/70 ${darkTreatment ? "bg-[#1766ef]/45" : "bg-white/55"}`} />
        <div className={`absolute left-[29%] top-[16%] h-[54%] w-[51%] border border-white/75 ${darkTreatment ? "bg-[#0d315f]/55" : "bg-[#1766ef]/12"}`} />
        <div className={`absolute bottom-[15%] right-[13%] h-10 w-10 rounded-full border-[10px] ${darkTreatment ? "border-white/30" : "border-[#1766ef]/20"}`} />
      </div>
    );
  }

  const imageClassName = "object-cover transition duration-500 group-hover:scale-105 motion-reduce:transition-none";

  if (isLocalCmsMedia) {
    return (
      // eslint-disable-next-line @next/next/no-img-element -- local Laravel media remains directly editable without the dev optimizer mismatch.
      <img src={source} alt={title} className={`absolute inset-0 h-full w-full ${imageClassName}`} onError={() => setFailed(true)} />
    );
  }

  return <Image src={source} alt={title} fill sizes="(max-width: 767px) 100vw, 50vw" className={imageClassName} onError={() => setFailed(true)} />;
}
