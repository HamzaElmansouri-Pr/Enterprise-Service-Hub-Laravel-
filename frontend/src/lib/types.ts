// ============================================================
// TypeScript interfaces matching the Laravel API Resources
// ============================================================

export interface Service {
  id: number;
  title: string;
  slug: string;
  subtitle: string | null;
  description: string | null;
  icon: string | null;
  image: string | null;
  order_index: number | null;
  is_active: boolean;
  meta_title: string | null;
  meta_description: string | null;
  og_image: string | null;
  created_at: string | null;
  updated_at: string | null;
}

export interface Project {
  id: number;
  title: string;
  slug: string;
  description: string | null;
  client: string | null;
  completion_date: string | null;
  category: string | null;
  image: string | null;
  is_active: boolean;
  is_featured: boolean;
  order_index: number | null;
  meta_title: string | null;
  meta_description: string | null;
  og_image: string | null;
  created_at: string | null;
  updated_at: string | null;
}

export interface BlogAuthor {
  id: number;
  name: string;
  image: string | null;
}

export interface Blog {
  id: number;
  title: string;
  slug: string;
  content: string | null;
  excerpt: string | null;
  image: string | null;
  category: string | null;
  published_at: string | null;
  author?: BlogAuthor;
  meta_title: string | null;
  meta_description: string | null;
  og_image: string | null;
  created_at: string | null;
  updated_at: string | null;
}

export interface Review {
  id: number;
  client_name: string;
  client_position: string | null;
  client_company: string | null;
  client_image: string | null;
  review_text: string;
  rating: number;
  project_type: string | null;
  is_featured: boolean;
  order_index: number | null;
}

export interface Slider {
  id: number;
  title: string | null;
  subtitle: string | null;
  description: string | null;
  badge_text: string | null;
  button_text: string | null;
  button_url: string | null;
  secondary_button_text: string | null;
  secondary_button_url: string | null;
  alignment: string | null;
  overlay_opacity: number | null;
  text_theme: string | null;
  video_url: string | null;
  title_color: string | null;
  subtitle_color: string | null;
  description_color: string | null;
  image: string | null;
  is_active: boolean;
  sort_order: number;
}

export interface Partner {
  id: number;
  name: string;
  logo: string | null;
  logo_url: string | null;
  url: string | null;
  is_active: boolean;
  order_index: number | null;
}

export interface Section {
  id: number;
  page_id: number | null;
  name: string | null;
  type: string;
  order_index: number | null;
  is_active: boolean;
  settings: Record<string, unknown> | null;
}

export interface PageMeta {
  title: string;
  breadcrumb_title?: string;
  image?: string | null;
  meta_title?: string | null;
  meta_description?: string | null;
}

export interface CMSData {
  heroTitle: string | null;
  heroSubtitle: string | null;
  heroButtonText: string | null;
  heroImage: string | null;
  services_title: string | null;
  services_subtitle: string | null;
  projects_title: string | null;
  projects_subtitle: string | null;
  reviews_title: string | null;
  reviews_subtitle: string | null;
  blog_title: string | null;
  blog_subtitle: string | null;
  cta: {
    title: string;
    subtitle: string;
    description: string;
    button_text: string;
  } | null;
  about: {
    title: string;
    subtitle: string;
    description: string;
    image: string;
    meta_data?: { features: string[] };
  } | null;
}

// API Response types
export interface HomeResponse {
  cms: CMSData;
  sliders: Slider[];
  services: Service[];
  projects: Project[];
  reviews: Review[];
  blogs: Blog[];
  partners: Partner[];
  sections: Section[];
}

export interface ServicesResponse {
  services: Service[];
  page: PageMeta;
}

export interface ServiceDetailResponse {
  service: Service;
  all_services: Service[];
}

export interface ProjectsResponse {
  projects: Project[];
  categories: string[];
  page: PageMeta;
}

export interface ProjectDetailResponse {
  project: Project;
  related_projects: Project[];
}

export interface BlogsResponse {
  blogs: Blog[];
  pagination: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
  recent_blogs: Blog[];
  page: PageMeta;
}

export interface BlogDetailResponse {
  blog: Blog;
  recent_blogs: Blog[];
}

export interface ContactInfoResponse {
  page: PageMeta & {
    contact_address: string | null;
    contact_email: string | null;
    contact_phone: string | null;
  };
  services: Service[];
}

export interface AboutResponse {
  page: PageMeta & {
    about: Record<string, string> | null;
    stats: { label: string; value: string }[] | null;
    values: { title: string; description: string }[] | null;
    history: Record<string, string> | null;
    team: { name: string; position: string; image?: string }[] | null;
  };
}

export interface ApiMessageResponse {
  message: string;
}
