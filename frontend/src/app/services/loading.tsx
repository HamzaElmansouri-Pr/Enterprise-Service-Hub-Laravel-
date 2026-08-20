export default function ServicesLoading() {
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

      {/* Grid Skeleton */}
      <section className="section-padding bg-[var(--bg-dark)]">
        <div className="max-w-7xl mx-auto">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {[1, 2, 3, 4, 5, 6].map((i) => (
              <div key={i} className="glass-card p-8 min-h-[300px] flex flex-col">
                <div className="w-16 h-16 rounded-2xl bg-white/5 mb-6"></div>
                <div className="h-6 w-3/4 bg-white/5 rounded mb-4"></div>
                <div className="h-4 w-full bg-white/5 rounded mb-2"></div>
                <div className="h-4 w-5/6 bg-white/5 rounded mb-2"></div>
                <div className="h-4 w-4/6 bg-white/5 rounded mt-auto"></div>
              </div>
            ))}
          </div>
        </div>
      </section>
    </div>
  );
}
