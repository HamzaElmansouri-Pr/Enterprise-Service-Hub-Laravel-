export default function ContactLoading() {
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
          {/* Info cards skeleton */}
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
            {[1, 2, 3].map((i) => (
              <div key={i} className="glass-card p-8 text-center flex flex-col items-center">
                <div className="w-14 h-14 rounded-2xl bg-white/5 mb-4"></div>
                <div className="h-5 w-1/2 bg-white/5 rounded mb-3"></div>
                <div className="h-4 w-3/4 bg-white/5 rounded"></div>
              </div>
            ))}
          </div>

          {/* Forms skeleton */}
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
            {[1, 2].map((i) => (
              <div key={i} className="w-full">
                <div className="h-8 w-1/2 bg-white/5 rounded mb-6"></div>
                <div className="glass-card p-8 space-y-6 w-full">
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div className="h-12 w-full bg-white/5 rounded-xl"></div>
                    <div className="h-12 w-full bg-white/5 rounded-xl"></div>
                  </div>
                  <div className="h-12 w-full bg-white/5 rounded-xl"></div>
                  <div className="h-32 w-full bg-white/5 rounded-xl"></div>
                  <div className="h-12 w-full bg-white/5 rounded-xl"></div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
    </div>
  );
}
