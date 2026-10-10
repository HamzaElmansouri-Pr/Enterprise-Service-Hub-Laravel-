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
  overlay_opacity: number | string | null;
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
  eyebrow?: string | null;
  description?: string | null;
  button_text?: string | null;
  button_url?: string | null;
  grid_eyebrow?: string | null;
  grid_title?: string | null;
  grid_description?: string | null;
}

export interface CMSData {
  heroTitle: string | null;
  heroSubtitle: string | null;
  heroButtonText: string | null;
  heroImage: string | null;
  services_title: string | null;
  services_subtitle: string | null;
  services_eyebrow?: string | null;
  services_button_text?: string | null;
  services_button_url?: string | null;
  projects_title: string | null;
  projects_subtitle: string | null;
  projects_eyebrow?: string | null;
  projects_button_text?: string | null;
  projects_button_url?: string | null;
  reviews_title: string | null;
  reviews_subtitle: string | null;
  reviews_eyebrow?: string | null;
  blog_title: string | null;
  blog_subtitle: string | null;
  blog_eyebrow?: string | null;
  blog_button_text?: string | null;
  blog_button_url?: string | null;
  cta: {
    title: string;
    subtitle: string;
    description: string;
    button_text: string;
    button_url?: string;
    eyebrow?: string;
    visual_variant?: "primary" | "dark" | "light";
  } | null;
  about: {
    title: string;
    subtitle: string;
    description: string;
    image?: string;
    eyebrow?: string;
    highlight_value?: string;
    highlight_suffix?: string;
    highlight_label?: string;
    button_text?: string;
    button_url?: string;
    meta_data?: { features: Array<string | { title: string; description?: string; icon?: string }> };
  } | null;
  partners?: {
    eyebrow?: string;
    title?: string;
    subtitle?: string;
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
    contact_title?: string | null;
    contact_description?: string | null;
    contact_logo?: string | null;
    contact_address: string | null;
    contact_email: string | null;
    contact_phone: string | null;
  };
  services: Service[];
}

export interface AboutResponse {
  page: PageMeta & {
    about: AboutContent | null;
    stats: AboutListSection<AboutStat> | null;
    values: AboutListSection<AboutValue> | null;
    history: AboutHistory | null;
    team: AboutTeamSection | null;
  };
}

export interface AboutContent {
  title?: string;
  subtitle?: string;
  description?: string;
  content?: string;
  image?: string;
}

export interface AboutListSection<T> {
  title?: string;
  subtitle?: string;
  items?: T[];
}

export interface AboutStat {
  label?: string;
  value?: string;
  number?: string;
  suffix?: string;
}

export interface AboutValue {
  title?: string;
  description?: string;
}

export interface AboutMilestone {
  year?: string;
  title?: string;
  description?: string;
}

export interface AboutHistory {
  title?: string;
  subtitle?: string;
  milestones?: AboutMilestone[];
}

export interface AboutTeamMember {
  name?: string;
  position?: string;
  image?: string;
}

export interface AboutTeamSection {
  title?: string;
  subtitle?: string;
  members?: AboutTeamMember[];
}

export interface ApiMessageResponse {
  message: string;
}

export interface GlobalConfigResponse {
  site_info: SiteInfo;
  footer_content: FooterContent;
  navigation: GlobalNavigation;
  theme: ThemeSettings;
}

export interface SiteInfo {
  site_name?: string;
  site_description?: string;
  site_keywords?: string;
  seo_keywords?: string;
  site_logo?: string;
  logo?: string;
  favicon?: string;
  og_image?: string;
  twitter_handle?: string;
  json_ld_organization?: string;
}

export interface NavigationItem {
  label: string | Record<string, string>;
  url: string;
  location?: "header" | "footer-company" | "footer-services";
  sort_order?: number;
  is_active?: boolean;
  open_in_new_tab?: boolean;
}

export interface GlobalNavigation {
  header_cta_label?: string;
  header_cta_url?: string;
  navigation?: NavigationItem[];
}

export interface FooterSocialLink {
  platform?: string;
  label?: string;
  url: string;
}

export interface FooterLink {
  label: string;
  url: string;
  sort_order?: number;
}

export interface FooterContent {
  footer_logo?: string;
  footer_description?: string;
  copyright_text?: string;
  newsletter_title?: string;
  newsletter_description?: string;
  newsletter_placeholder?: string;
  social_links?: FooterSocialLink[];
  footer_legal_links?: FooterLink[];
}

export interface ThemeSettings {
  primary_color?: string;
  accent_color?: string;
  surface_color?: string;
  chat_enabled?: string | boolean;
}
