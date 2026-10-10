"use client";

import Image from "next/image";
import { useState } from "react";
import { resolveCmsMediaUrl } from "@/lib/api";

type ContentImageProps = {
  src?: string | null;
  alt: string;
  sizes: string;
  className?: string;
  fallbackClassName?: string;
  priority?: boolean;
};

/** Keeps an unavailable CMS image from leaving a broken-image icon in an editorial card. */
export function ContentImage({ src, alt, sizes, className = "", fallbackClassName = "", priority = false }: ContentImageProps) {
  const resolvedSrc = resolveCmsMediaUrl(src);
  const [failedSrc, setFailedSrc] = useState<string | null>(null);
  const hasFailed = !resolvedSrc || failedSrc === resolvedSrc;
  const isLocalCmsMedia = /^https?:\/\/(?:localhost|127\.0\.0\.1)(?::\d+)?\//.test(resolvedSrc || "");

  if (hasFailed || !resolvedSrc) {
    return <div aria-hidden="true" className={`absolute inset-0 media-fallback ${fallbackClassName}`} />;
  }

  if (isLocalCmsMedia) {
    // eslint-disable-next-line @next/next/no-img-element -- keeps editable local Laravel media direct; Next's wrapper emits a false error for these URLs in development.
    return <img src={resolvedSrc} alt={alt} sizes={sizes} className={`absolute inset-0 h-full w-full ${className}`} onError={() => setFailedSrc(resolvedSrc)} />;
  }

  return (
    <Image
      src={resolvedSrc}
      alt={alt}
      fill
      sizes={sizes}
      priority={priority}
      className={className}
      onError={() => setFailedSrc(resolvedSrc)}
    />
  );
}
