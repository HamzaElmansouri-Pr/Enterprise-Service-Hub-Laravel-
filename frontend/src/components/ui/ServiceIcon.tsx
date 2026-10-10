import {
  BarChart3,
  Cloud,
  Code2,
  Globe2,
  Lightbulb,
  Megaphone,
  Palette,
  Settings2,
  ShieldCheck,
  Smartphone,
  Zap,
} from "lucide-react";
import { getServiceIconName } from "@/lib/iconHelper";

export function ServiceIcon({ icon, className }: { icon: string | null; className?: string }) {
  const props = { "aria-hidden": true as const, className, strokeWidth: 1.7 };

  switch (getServiceIconName(icon)) {
    case "web": return <Globe2 {...props} />;
    case "mobile": return <Smartphone {...props} />;
    case "cloud": return <Cloud {...props} />;
    case "security": return <ShieldCheck {...props} />;
    case "consulting": return <Lightbulb {...props} />;
    case "data": return <BarChart3 {...props} />;
    case "design": return <Palette {...props} />;
    case "code": return <Code2 {...props} />;
    case "settings": return <Settings2 {...props} />;
    case "marketing": return <Megaphone {...props} />;
    default: return <Zap {...props} />;
  }
}
