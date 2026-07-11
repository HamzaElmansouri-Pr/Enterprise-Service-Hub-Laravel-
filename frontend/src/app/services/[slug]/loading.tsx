export default function ServiceDetailLoading() {
  return (
    <div className="bg-white">
      {/* Hero Skeleton */}
      <div className="relative isolate px-6 pt-14 lg:px-8 bg-gray-50 pb-24 pt-32 sm:pb-32 sm:pt-40">
        <div className="mx-auto max-w-7xl">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
              <div className="h-4 w-24 bg-gray-200 rounded animate-pulse mb-6"></div>
              <div className="h-12 w-3/4 bg-gray-200 rounded-md animate-pulse mb-6"></div>
              <div className="h-4 w-full bg-gray-200 rounded animate-pulse mb-2"></div>
              <div className="h-4 w-full bg-gray-200 rounded animate-pulse mb-2"></div>
              <div className="h-4 w-2/3 bg-gray-200 rounded animate-pulse mb-8"></div>
              <div className="flex gap-4">
                <div className="h-10 w-32 bg-gray-200 rounded-md animate-pulse"></div>
                <div className="h-10 w-32 bg-gray-200 rounded-md animate-pulse"></div>
              </div>
            </div>
            <div className="relative">
              <div className="aspect-[4/3] w-full rounded-2xl bg-gray-200 animate-pulse shadow-xl"></div>
            </div>
          </div>
        </div>
      </div>

      {/* Content Skeleton */}
      <div className="py-24 sm:py-32">
        <div className="mx-auto max-w-7xl px-6 lg:px-8">
          <div className="mx-auto max-w-3xl">
            <div className="h-8 w-1/2 bg-gray-200 rounded animate-pulse mb-8"></div>
            
            <div className="space-y-4">
              <div className="h-4 w-full bg-gray-200 rounded animate-pulse"></div>
              <div className="h-4 w-full bg-gray-200 rounded animate-pulse"></div>
              <div className="h-4 w-5/6 bg-gray-200 rounded animate-pulse"></div>
            </div>
            
            <div className="mt-12 space-y-4">
              <div className="h-4 w-full bg-gray-200 rounded animate-pulse"></div>
              <div className="h-4 w-4/5 bg-gray-200 rounded animate-pulse"></div>
            </div>

            <div className="mt-16 grid grid-cols-1 sm:grid-cols-2 gap-8">
              {[1, 2, 3, 4].map((i) => (
                <div key={i} className="flex gap-4">
                  <div className="h-12 w-12 rounded-lg bg-gray-200 animate-pulse shrink-0"></div>
                  <div className="w-full">
                    <div className="h-5 w-2/3 bg-gray-200 rounded animate-pulse mb-2"></div>
                    <div className="h-3 w-full bg-gray-200 rounded animate-pulse mb-1"></div>
                    <div className="h-3 w-4/5 bg-gray-200 rounded animate-pulse"></div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
