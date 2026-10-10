import type { Metadata } from "next";
import { getProjects } from "@/lib/api";
import { Breadcrumb } from "@/components/ui/Breadcrumb";
import { ProjectsGrid } from "@/components/projects/ProjectsGrid";


export async function generateMetadata(): Promise<Metadata> {
  const data = await getProjects();
  return {
    title: data.page.meta_title || "Our Projects",
    description: data.page.meta_description || "Explore our portfolio of successful projects",
  };
}

export default async function ProjectsPage({ searchParams }: { searchParams: Promise<{ category?: string; search?: string }> }) {
  const sp = await searchParams;
  const data = await getProjects({ category: sp.category, search: sp.search });

  return (
    <>
      <Breadcrumb title={data.page.title} image={data.page.image} items={[{ label: "Projects" }]} />
      <ProjectsGrid projects={data.projects} categories={data.categories} activeCategory={sp.category} />
    </>
  );
}
