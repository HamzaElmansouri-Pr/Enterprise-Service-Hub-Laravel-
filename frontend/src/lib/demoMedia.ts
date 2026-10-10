/**
 * Presentation-only substitutions for assets created by the local seeders.
 *
 * These checks deliberately match a small, known set of template paths. They
 * never change API values or CMS records, so an editor can replace an image in
 * the backoffice and the uploaded image will render immediately.
 */
const pathOf = (url?: string | null) => (url || "").split("?")[0].toLowerCase();

const isCaseStudySeed = (url?: string | null) =>
  /\/assets\/img\/case-studies\/0[1-8]\.jpg$/.test(pathOf(url));

const isAboutSeed = (url?: string | null) =>
  /\/assets\/img\/about\/01\.jpg$/.test(pathOf(url));

const isServicesHeaderSeed = (url?: string | null) =>
  /\/assets\/img\/breadcrumb-bg\.jpg$/.test(pathOf(url));

export const isKnownSeededPlaceholder = (url?: string | null) =>
  isCaseStudySeed(url) || isAboutSeed(url);

export const isKnownSeededHero = (url?: string | null) =>
  /\/storage\/sliders\/slide[1-3]\.jpg$/.test(pathOf(url));

export function resolveProjectPresentationImage(url?: string | null, index = 0) {
  if (!isKnownSeededPlaceholder(url)) return url || null;
  return index % 2 === 0
    ? "/images/demo-project-operations.png"
    : "/images/demo-project-portal.png";
}

export function resolveAboutPresentationImage(url?: string | null) {
  return isAboutSeed(url) ? "/images/demo-about-team.png" : url || null;
}

export function shouldRenderServiceImage(url?: string | null) {
  return Boolean(url && !isKnownSeededPlaceholder(url));
}

export function resolveHeroPresentationImage(url?: string | null) {
  return isKnownSeededHero(url) || !url
    ? "/images/hero-architecture-fallback.png"
    : url;
}

/** The seeded Services header is generic artwork; real CMS uploads always win. */
export function resolveServicesHeroImage(url?: string | null) {
  return isServicesHeaderSeed(url) || !url
    ? "/images/hero-architecture-fallback.png"
    : url;
}

/** The Projects header shares the CMS image contract used by Services. */
export function resolveProjectsHeroImage(url?: string | null) {
  return isServicesHeaderSeed(url) || !url
    ? "/images/hero-architecture-fallback.png"
    : url;
}

/** Legacy seed content may retain the former demo brand in a CMS text field. */
export function isLegacyBrandCopy(value?: string | null) {
  return /\b(?:nova agency|supremeit)\b/i.test(value || "");
}
