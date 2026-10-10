"use client";

import Image from "next/image";
import { useState } from "react";
import { ServiceIcon } from "@/components/ui/ServiceIcon";
import { resolveCmsMediaUrl } from "@/lib/api";
import { shouldRenderServiceImage } from "@/lib/demoMedia";

type ServiceCardMediaProps = {
  image: string | null;
  icon: string | null;
};

/**
 * Keeps cards presentation-ready without replacing CMS media. Known seed
 * placeholders and failed requests receive an icon-based visual; editor
 * uploads render unchanged.
 */
export function ServiceCardMedia({ image, icon }: ServiceCardMediaProps) {
  const source = resolveCmsMediaUrl(image);
  const [failed, setFailed] = useState(!shouldRenderServiceImage(source));
  const canRenderImage = Boolean(source) && shouldRenderServiceImage(source) && !failed;
  const isLocalCmsMedia = /^https?:\/\/(?:localhost|127\.0\.0\.1)(?::\d+)?\//.test(source || "");

  if (!canRenderImage) {
    return (
      <div aria-hidden="true" className="relative flex min-h-52 items-center justify-center overflow-hidden bg-[#edf5ff] text-[var(--blue)] sm:min-h-full">
        <div className="absolute -right-10 -top-12 h-48 w-48 rounded-full border-[18px] border-white/75" />
        <div className="absolute bottom-0 right-0 h-24 w-24 bg-[linear-gradient(135deg,transparent_0_42%,rgba(21,88,255,.13)_42%_100%)]" />
        <div className="relative flex h-20 w-20 items-center justify-center rounded-2xl border border-[#c8dcff] bg-white/80 shadow-[0_16px_36px_rgba(21,88,255,.12)]">
          <ServiceIcon icon={icon} className="h-10 w-10" />
        </div>
      </div>
    );
  }

  const imageClassName = "object-cover transition duration-500 motion-reduce:transition-none group-hover:scale-[1.035]";

  return (
    <div className="relative min-h-52 overflow-hidden bg-[#edf5ff] sm:min-h-full">
      {isLocalCmsMedia ? (
        // eslint-disable-next-line @next/next/no-img-element -- supports editable local Laravel media without the dev optimizer mismatch.
        <img src={source!} alt="" className={`absolute inset-0 h-full w-full ${imageClassName}`} onError={() => setFailed(true)} />
      ) : (
        <Image src={source!} alt="" fill sizes="(max-width: 767px) 100vw, (max-width: 1280px) 45vw, 520px" className={imageClassName} onError={() => setFailed(true)} />
      )}
      <div aria-hidden="true" className="absolute inset-0 bg-[linear-gradient(135deg,rgba(234,242,255,.22),rgba(234,242,255,.04))]" />
    </div>
  );
}
