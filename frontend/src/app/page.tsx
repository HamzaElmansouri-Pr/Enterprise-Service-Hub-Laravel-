import { getHomePage } from "@/lib/api";
import { HeroSlider } from "@/components/home/HeroSlider";
import { AboutSection } from "@/components/home/AboutSection";
import { ServicesGrid } from "@/components/home/ServicesGrid";
import dynamic from "next/dynamic";

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

export default async function HomePage() {
  const data = await getHomePage();
  const { cms, sliders, services, projects, reviews, blogs, partners, sections } = data;

  return (
    <>
      {isSectionActive(sections, "home-hero") && (
        <HeroSlider sliders={sliders} cms={cms} />
      )}

      {isSectionActive(sections, "home-about") && (
        <AboutSection about={cms.about} />
      )}

      {isSectionActive(sections, "services-list") && (
        <ServicesGrid services={services} title={cms.services_title} subtitle={cms.services_subtitle} />
      )}

      {isSectionActive(sections, "projects-list") && (
        <ProjectsShowcase projects={projects} title={cms.projects_title} subtitle={cms.projects_subtitle} />
      )}

      {isSectionActive(sections, "reviews-list") && (
        <Testimonials reviews={reviews} title={cms.reviews_title} subtitle={cms.reviews_subtitle} />
      )}

      {isSectionActive(sections, "blog-list") && (
        <BlogPreview blogs={blogs} title={cms.blog_title} subtitle={cms.blog_subtitle} />
      )}

      {isSectionActive(sections, "cta-simple") && (
        <CTASection cta={cms.cta} />
      )}

      {isSectionActive(sections, "home-partners") && (
        <PartnersBar partners={partners} />
      )}
    </>
  );
}
