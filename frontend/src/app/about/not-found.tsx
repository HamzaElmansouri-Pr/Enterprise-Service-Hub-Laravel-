import { NotFoundState } from '@/components/ui/NotFoundState';

export default function NotFound() {
  const segmentName = "about";
  return (
    <div className="container mx-auto px-4">
      <NotFoundState 
        title={`${segmentName ? segmentName.charAt(0).toUpperCase() + segmentName.slice(1) : "Page"} Not Found`}
        message="We couldn't find the resource you requested." 
      />
    </div>
  );
}
