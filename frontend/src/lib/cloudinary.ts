/**
 * Utility for handling Cloudinary image transformations in the frontend.
 */

interface CloudinaryOptions {
  width?: number;
  height?: number;
  crop?: string;
  quality?: string;
  format?: string;
}

/**
 * Optimizes a Cloudinary URL by injecting transformation parameters.
 * 
 * @param url The original Cloudinary URL
 * @param options Transformation options
 * @returns The optimized URL
 */
export function getOptimizedImageUrl(url: string | null | undefined, options: CloudinaryOptions = {}): string {
  if (!url) return '';
  
  // Only process Cloudinary URLs
  if (!url.includes('res.cloudinary.com')) {
    return url;
  }

  const transformations: string[] = [];
  
  if (options.width) transformations.push(`w_${options.width}`);
  if (options.height) transformations.push(`h_${options.height}`);
  if (options.crop) transformations.push(`c_${options.crop}`);
  
  // Defaults for performance
  transformations.push(options.quality ? `q_${options.quality}` : 'q_auto');
  transformations.push(options.format ? `f_${options.format}` : 'f_auto');

  const transformationString = transformations.join(',');
  
  // Insert transformation after /upload/
  if (url.includes('/upload/')) {
    return url.replace('/upload/', `/upload/${transformationString}/`);
  }

  return url;
}
