import { getHomePage } from "@/lib/api";
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

// Helper to check if a section is active
function isSectionActive(sections: { type: string; is_active: boolean }[], type: string): boolean {
  const section = sections.find((s) => s.type === type);
  return section ? section.is_active : true; // default to visible
}

import { cookies } from "next/headers";
import { getDictionary } from "@/lib/dictionary";

export default async function HomePage() {
  const cookieStore = await cookies();
  const locale = cookieStore.get("NEXT_LOCALE")?.value || "en";
  const t = getDictionary(locale);

  const data = await getHomePage();
  const { cms, sliders, services, projects, reviews, blogs, partners, sections } = data;

  return (
    <>
      {isSectionActive(sections, "home-hero") && (
        <ErrorBoundary>
          <HeroSlider sliders={sliders} cms={cms} />
        </ErrorBoundary>
      )}

      {isSectionActive(sections, "home-about") && (
        <ErrorBoundary>
          <AboutSection about={cms.about} />
        </ErrorBoundary>
      )}

      {isSectionActive(sections, "services-list") && (
        <ErrorBoundary>
          <ServicesGrid services={services} title={cms.services_title} subtitle={cms.services_subtitle} />
        </ErrorBoundary>
      )}

      {isSectionActive(sections, "projects-list") && (
        <ErrorBoundary>
          <ProjectsShowcase projects={projects} title={cms.projects_title} subtitle={cms.projects_subtitle} viewAllText={t.projectsShowcase.viewAll} />
        </ErrorBoundary>
      )}

      {isSectionActive(sections, "reviews-list") && (
        <ErrorBoundary>
          <Testimonials reviews={reviews} title={cms.reviews_title} subtitle={cms.reviews_subtitle} />
        </ErrorBoundary>
      )}

      {isSectionActive(sections, "blog-list") && (
        <ErrorBoundary>
          <BlogPreview blogs={blogs} title={cms.blog_title} subtitle={cms.blog_subtitle} viewAllText={t.blogPreview.viewAll} />
        </ErrorBoundary>
      )}

      {isSectionActive(sections, "cta-simple") && (
        <ErrorBoundary>
          <CTASection cta={cms.cta} />
        </ErrorBoundary>
      )}

      {isSectionActive(sections, "home-partners") && (
        <ErrorBoundary>
          <PartnersBar partners={partners} />
        </ErrorBoundary>
      )}
    </>
  );
}
