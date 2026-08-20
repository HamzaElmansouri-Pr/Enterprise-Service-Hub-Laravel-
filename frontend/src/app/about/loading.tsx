export default function AboutLoading() {
  return (
    <div className="animate-pulse">
      {/* Breadcrumb Skeleton */}
      <div className="relative pt-32 pb-20 overflow-hidden bg-[var(--bg-deep)]">
        <div className="max-w-7xl mx-auto px-4 text-center">
          <div className="h-10 w-64 bg-white/5 rounded-xl mx-auto mb-4"></div>
          <div className="flex justify-center items-center gap-2">
            <div className="h-4 w-16 bg-white/5 rounded"></div>
            <div className="h-4 w-4 bg-white/5 rounded-full"></div>
            <div className="h-4 w-24 bg-white/5 rounded"></div>
          </div>
        </div>
      </div>

      <section className="section-padding bg-[var(--bg-dark)]">
        <div className="max-w-7xl mx-auto">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            {/* Image Skeleton */}
            <div className="aspect-[4/3] rounded-3xl bg-white/5 w-full"></div>
            
            {/* Content Skeleton */}
            <div className="space-y-6 w-full">
              <div className="h-4 w-32 bg-white/5 rounded-full"></div>
              <div className="h-10 w-3/4 bg-white/5 rounded-xl"></div>
              <div className="space-y-3">
                <div className="h-4 w-full bg-white/5 rounded"></div>
                <div className="h-4 w-full bg-white/5 rounded"></div>
                <div className="h-4 w-5/6 bg-white/5 rounded"></div>
              </div>
              
              <div className="grid grid-cols-2 gap-6 pt-6">
                {[1, 2, 3, 4].map((i) => (
                  <div key={i} className="flex gap-4 items-start">
                    <div className="w-12 h-12 rounded-xl bg-white/5 flex-shrink-0"></div>
                    <div className="space-y-2 w-full">
                      <div className="h-5 w-3/4 bg-white/5 rounded"></div>
                      <div className="h-4 w-full bg-white/5 rounded"></div>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}
