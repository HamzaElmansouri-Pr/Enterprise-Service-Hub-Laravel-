export default function ProjectsLoading() {
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
          {/* Category Filter Skeleton */}
          <div className="flex flex-wrap justify-center gap-2 mb-12">
            {[1, 2, 3, 4, 5].map((i) => (
              <div key={i} className="h-10 w-24 bg-white/5 rounded-full"></div>
            ))}
          </div>
          
          {/* Grid Skeleton */}
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {[1, 2, 3, 4, 5, 6].map((i) => (
              <div key={i} className="glass-card flex flex-col h-full overflow-hidden">
                <div className="h-64 w-full bg-white/5"></div>
                <div className="p-6">
                  <div className="h-6 w-3/4 bg-white/5 rounded mb-2"></div>
                  <div className="h-4 w-1/2 bg-white/5 rounded"></div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
    </div>
  );
}
