export default function ProjectsLoading() {
  return (
    <div className="bg-white py-24 sm:py-32">
      <div className="mx-auto max-w-7xl px-6 lg:px-8">
        <div className="mx-auto max-w-2xl text-center mb-16">
          <div className="h-10 w-64 bg-gray-200 rounded-md animate-pulse mx-auto mb-4"></div>
          <div className="h-6 w-96 bg-gray-200 rounded-md animate-pulse mx-auto"></div>
        </div>

        <div className="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3">
          {[1, 2, 3, 4, 5, 6].map((i) => (
            <div key={i} className="flex flex-col bg-gray-50 rounded-2xl overflow-hidden shadow-sm border border-gray-100">
              <div className="aspect-[4/3] w-full bg-gray-200 animate-pulse"></div>
              <div className="p-8">
                <div className="h-4 w-24 bg-gray-200 rounded-full animate-pulse mb-4"></div>
                <div className="h-6 w-3/4 bg-gray-200 rounded animate-pulse mb-3"></div>
                <div className="h-4 w-full bg-gray-200 rounded animate-pulse mb-2"></div>
                <div className="h-4 w-2/3 bg-gray-200 rounded animate-pulse"></div>
                
                <div className="mt-6 flex flex-wrap gap-2">
                  <div className="h-6 w-16 bg-gray-200 rounded-full animate-pulse"></div>
                  <div className="h-6 w-20 bg-gray-200 rounded-full animate-pulse"></div>
                  <div className="h-6 w-14 bg-gray-200 rounded-full animate-pulse"></div>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}
