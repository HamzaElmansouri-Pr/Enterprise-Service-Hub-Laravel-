const serviceIcons: Record<string, string> = {
  default: "⚡",
  web: "🌐",
  mobile: "📱",
  cloud: "☁️",
  security: "🔒",
  consulting: "💡",
  data: "📊",
  design: "🎨",
};

export function getIcon(icon: string | null) {
  if (!icon) return serviceIcons.default;
  if (icon.length <= 4) return icon;
  if (icon.includes("setting")) return "⚙️";
  if (icon.includes("web") || icon.includes("globe")) return "🌐";
  if (icon.includes("cloud")) return "☁️";
  if (icon.includes("shield") || icon.includes("security")) return "🔒";
  if (icon.includes("code")) return "💻";
  if (icon.includes("chart") || icon.includes("data")) return "📊";
  if (icon.includes("design") || icon.includes("paint")) return "🎨";
  if (icon.includes("mobile") || icon.includes("phone")) return "📱";
  return serviceIcons.default;
}
