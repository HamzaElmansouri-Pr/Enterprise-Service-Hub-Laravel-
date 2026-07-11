import { MetadataRoute } from 'next';

export default function manifest(): MetadataRoute.Manifest {
  return {
    name: 'Enterprise Service Hub',
    short_name: 'Service Hub',
    description: 'Enterprise IT Solutions and Consulting',
    start_url: '/',
    display: 'standalone',
    background_color: '#050505',
    theme_color: '#3b82f6',
    icons: [
      {
        src: '/icon.svg',
        sizes: 'any',
        type: 'image/svg+xml',
      },
    ],
  };
}
