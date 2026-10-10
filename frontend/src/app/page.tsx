import { getHomePage } from "@/lib/api";
import type { Section } from "@/lib/types";
import { HeroSlider } from "@/components/home/HeroSlider";
import { AboutSection } from "@/components/home/AboutSection";
import { ServicesGrid } from "@/components/home/ServicesGrid";
import dynamic from "next/dynamic";
import { ErrorBoundary } from "@/components/ui/ErrorBoundary";

const ProjectsShowcase = dynamic(() => import("@/components/home/ProjectsShowcase").then(mod => mod.ProjectsShowcase), { ssr: true });
const Testimonials = dynamic(() => import("@/components/home/Testimonials").then(mod => mod.Testimonials), { ssr: true });
const BlogPreview = dynamic(() => import("@/components/home/BlogPreview").then(mod => mod.BlogPreview), { ssr: true });
const CTASection = dynamic(() => import("@/components/home/CTASection").then(mod => mod.CTASection), { ssr: true });
const PartnersBar = dynamic(() => import("@/components/home/PartnersBar").then(mod => mod.PartnersBar), { ssr: true });

import { cookies } from "next/headers";
import { getDictionary } from "@/lib/dictionary";

const homeSectionTypes = [
  "home-hero",
  "services-list",
  "projects-list",
  "home-about",
  "home-partners",
  "reviews-list",
  "blog-list",
  "cta-simple",
] as const;

type HomeSectionType = (typeof homeSectionTypes)[number];

function orderedHomeSections(sections: Section[]) {
  const known = new Map(sections.filter((section): section is Section & { type: HomeSectionType } => homeSectionTypes.includes(section.type as HomeSectionType)).map((section) => [section.type, section]));
  const configured = [...known.values()].sort((a, b) => (a.order_index ?? Number.MAX_SAFE_INTEGER) - (b.order_index ?? Number.MAX_SAFE_INTEGER));
  const missing = homeSectionTypes.filter((type) => !known.has(type)).map((type, index) => ({ id: `fallback-${type}`, type, is_active: true, order_index: Number.MAX_SAFE_INTEGER - homeSectionTypes.length + index }));

  return [...configured, ...missing];
}

export default async function HomePage() {
  const cookieStore = await cookies();
  const locale = cookieStore.get("NEXT_LOCALE")?.value || "en";
  const t = getDictionary(locale);

  const data = await getHomePage();
  const { cms, sliders, services, projects, reviews, blogs, partners, sections } = data;

  return <>{orderedHomeSections(sections).map((section) => {
    if (!section.is_active) return null;

    switch (section.type) {
      case "home-hero": return <ErrorBoundary key={section.id}><HeroSlider sliders={sliders} cms={cms} /></ErrorBoundary>;
      case "services-list": return <ErrorBoundary key={section.id}><ServicesGrid services={services} title={cms.services_title} subtitle={cms.services_subtitle} eyebrow={cms.services_eyebrow} buttonText={cms.services_button_text} buttonUrl={cms.services_button_url} /></ErrorBoundary>;
      case "projects-list": return <ErrorBoundary key={section.id}><ProjectsShowcase projects={projects} title={cms.projects_title} subtitle={cms.projects_subtitle} eyebrow={cms.projects_eyebrow} buttonText={cms.projects_button_text} buttonUrl={cms.projects_button_url} viewAllText={t.projectsShowcase.viewAll} /></ErrorBoundary>;
      case "home-about": return <ErrorBoundary key={section.id}><AboutSection about={cms.about} /></ErrorBoundary>;
      case "home-partners": return <ErrorBoundary key={section.id}><PartnersBar partners={partners} content={cms.partners} /></ErrorBoundary>;
      case "reviews-list": return <ErrorBoundary key={section.id}><Testimonials reviews={reviews} title={cms.reviews_title} subtitle={cms.reviews_subtitle} eyebrow={cms.reviews_eyebrow} /></ErrorBoundary>;
      case "blog-list": return <ErrorBoundary key={section.id}><BlogPreview blogs={blogs} title={cms.blog_title} subtitle={cms.blog_subtitle} eyebrow={cms.blog_eyebrow} buttonText={cms.blog_button_text} buttonUrl={cms.blog_button_url} viewAllText={t.blogPreview.viewAll} /></ErrorBoundary>;
      case "cta-simple": return <ErrorBoundary key={section.id}><CTASection cta={cms.cta} /></ErrorBoundary>;
      default: return null;
    }
  })}</>;
}
