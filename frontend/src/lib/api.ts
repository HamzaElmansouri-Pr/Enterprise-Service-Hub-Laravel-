import type {
  HomeResponse,
  ServicesResponse,
  ServiceDetailResponse,
  ProjectsResponse,
  ProjectDetailResponse,
  BlogsResponse,
  BlogDetailResponse,
  ContactInfoResponse,
  AboutResponse,
  ApiMessageResponse,
} from './types';

// ============================================================
// API Client — Typed fetch wrapper for the Laravel API
// ============================================================

const API_BASE_URL = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000/api/v1';

class ApiError extends Error {
  status: number;
  constructor(message: string, status: number) {
    super(message);
    this.status = status;
    this.name = 'ApiError';
  }
}

async function fetchApi<T>(
  endpoint: string,
  options: RequestInit = {}
): Promise<T> {
  const url = `${API_BASE_URL}${endpoint}`;

  let locale = 'en';
  if (typeof window === 'undefined') {
    try {
      const { cookies } = await import('next/headers');
      const cookieStore = await cookies();
      locale = cookieStore.get('NEXT_LOCALE')?.value || 'en';
    } catch {
      // Ignore
    }
  } else {
    const match = document.cookie.match(/(?:^|; )NEXT_LOCALE=([^;]*)/);
    if (match) locale = match[1];
  }

  const isFormData = typeof FormData !== 'undefined' && options.body instanceof FormData;
  
  const defaultHeaders: Record<string, string> = {
    'Accept': 'application/json',
    'X-App-Locale': locale,
    'Accept-Language': locale,
  };

  if (!isFormData) {
    defaultHeaders['Content-Type'] = 'application/json';
  }

  const method = (options.method || 'GET').toUpperCase();
  const isMutation = ['POST', 'PUT', 'PATCH', 'DELETE'].includes(method);

  const fetchOptions: RequestInit = {
    ...options,
    headers: {
      ...defaultHeaders,
      ...options.headers,
    },
  };

  if (isMutation) {
    fetchOptions.cache = 'no-store';
  } else {
    fetchOptions.next = {
      revalidate: 3600, // Default to 1 hour for GET
      ...options.next,
    };
  }

  const response = await fetch(url, fetchOptions);

  if (!response.ok) {
    throw new ApiError(
      `API Error: ${response.statusText}`,
      response.status
    );
  }

  return response.json();
}

// ============================================================
// Public API Functions
// ============================================================

/** Get all homepage data (sliders, services, projects, reviews, blogs, partners, sections, CMS) */
export async function getHomePage(): Promise<HomeResponse> {
  return fetchApi<HomeResponse>('/home');
}

/** Get the about page CMS content */
export async function getAboutPage(): Promise<AboutResponse> {
  return fetchApi<AboutResponse>('/about');
}

/** Get all active services with page meta */
export async function getServices(): Promise<ServicesResponse> {
  return fetchApi<ServicesResponse>('/services');
}

/** Get a single service by slug */
export async function getService(slug: string): Promise<ServiceDetailResponse> {
  return fetchApi<ServiceDetailResponse>(`/services/${slug}`);
}

/** Get all active projects with optional filters */
export async function getProjects(params?: {
  category?: string;
  search?: string;
}): Promise<ProjectsResponse> {
  const searchParams = new URLSearchParams();
  if (params?.category) searchParams.set('category', params.category);
  if (params?.search) searchParams.set('search', params.search);
  const qs = searchParams.toString();
  return fetchApi<ProjectsResponse>(`/projects${qs ? `?${qs}` : ''}`);
}

/** Get a single project by slug */
export async function getProject(slug: string): Promise<ProjectDetailResponse> {
  return fetchApi<ProjectDetailResponse>(`/projects/${slug}`);
}

/** Get paginated blog posts */
export async function getBlogs(page: number = 1): Promise<BlogsResponse> {
  return fetchApi<BlogsResponse>(`/blogs?page=${page}`);
}

/** Get a single blog post by slug */
export async function getBlog(slug: string): Promise<BlogDetailResponse> {
  return fetchApi<BlogDetailResponse>(`/blogs/${slug}`);
}

/** Get contact page info + services list */
export async function getContactInfo(): Promise<ContactInfoResponse> {
  return fetchApi<ContactInfoResponse>('/contact-info');
}

/** Submit a contact form */
export async function submitContact(data: {
  name: string;
  email: string;
  phone?: string;
  subject: string;
  message: string;
  website_url?: string;
}): Promise<ApiMessageResponse> {
  return fetchApi<ApiMessageResponse>('/contact', {
    method: 'POST',
    body: JSON.stringify(data),
  });
}

/** Submit a technical consultation request */
export async function submitTcRequest(data: FormData): Promise<ApiMessageResponse> {
  return fetchApi<ApiMessageResponse>('/tc-request', {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      // Let browser set Content-Type for FormData (multipart/form-data)
    },
    body: data,
  });
}

/** Subscribe to newsletter */
export async function submitNewsletter(email: string): Promise<ApiMessageResponse> {
  return fetchApi<ApiMessageResponse>('/subscribe', {
    method: 'POST',
    body: JSON.stringify({ email }),
  });
}

export async function searchGlobal(query: string): Promise<any> {
  return fetchApi<any>(`/search?q=${encodeURIComponent(query)}`, {
    next: { revalidate: 60 }
  });
}

/** Chatbot Submit */
export async function submitChat(message: string): Promise<any> {
  return fetchApi<any>('/chat', {
    method: 'POST',
    body: JSON.stringify({ message }),
  });
}

export async function getComments(modelType: string, modelId: string | number): Promise<any> {
  if (modelType === 'blog') {
    return fetchApi<any>(`/blogs/${modelId}/comments`, { next: { revalidate: 60 } });
  }
  return fetchApi<any>(`/comments/${modelType}/${modelId}`, { next: { revalidate: 60 } });
}

/** Submit a Comment */
export async function submitComment(modelType: string, modelId: string | number, data: { name: string; email: string; content: string; parent_id?: number }): Promise<any> {
  if (modelType === 'blog') {
    return fetchApi<any>(`/blogs/${modelId}/comments`, {
      method: 'POST',
      body: JSON.stringify(data),
    });
  }
  return fetchApi<any>(`/comments/${modelType}/${modelId}`, {
    method: 'POST',
    body: JSON.stringify(data),
  });
}
