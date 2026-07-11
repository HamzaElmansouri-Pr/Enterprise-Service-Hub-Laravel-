export default function BlogLoading() {
  return (
    <div className="py-24 sm:py-32 bg-gray-50">
      <div className="mx-auto max-w-7xl px-6 lg:px-8">
        <div className="mx-auto max-w-2xl text-center">
          <div className="h-10 w-64 bg-gray-200 rounded-md animate-pulse mx-auto mb-4"></div>
          <div className="h-6 w-96 bg-gray-200 rounded-md animate-pulse mx-auto"></div>
        </div>
        
        <div className="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
          {[1, 2, 3, 4, 5, 6].map((i) => (
            <div key={i} className="flex flex-col items-start justify-between">
              {/* Image Skeleton */}
              <div className="relative w-full">
                <div className="aspect-[16/9] w-full rounded-2xl bg-gray-200 animate-pulse sm:aspect-[2/1] lg:aspect-[3/2]"></div>
              </div>
              
              <div className="max-w-xl w-full">
                {/* Meta tags skeleton */}
                <div className="mt-8 flex items-center gap-x-4 text-xs">
                  <div className="h-4 w-20 bg-gray-200 rounded animate-pulse"></div>
                  <div className="h-4 w-16 bg-gray-200 rounded-full animate-pulse"></div>
                </div>
                
                {/* Title and excerpt skeleton */}
                <div className="group relative mt-3">
                  <div className="h-6 w-3/4 bg-gray-200 rounded animate-pulse mb-3"></div>
                  <div className="h-4 w-full bg-gray-200 rounded animate-pulse mt-1"></div>
                  <div className="h-4 w-full bg-gray-200 rounded animate-pulse mt-1"></div>
                  <div className="h-4 w-2/3 bg-gray-200 rounded animate-pulse mt-1"></div>
                </div>
                
                {/* Author skeleton */}
                <div className="relative mt-8 flex items-center gap-x-4">
                  <div className="h-10 w-10 rounded-full bg-gray-200 animate-pulse"></div>
                  <div className="text-sm leading-6">
                    <div className="h-4 w-24 bg-gray-200 rounded animate-pulse"></div>
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}
