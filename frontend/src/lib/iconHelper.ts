export type ServiceIconName = "default" | "web" | "mobile" | "cloud" | "security" | "consulting" | "data" | "design" | "code" | "settings" | "marketing";

/**
 * CMS icon values are intentionally permissive. Map the familiar values to a
 * single, consistent outline system instead of rendering browser-dependent emoji.
 */
export function getServiceIconName(icon: string | null): ServiceIconName {
  const value = icon?.toLowerCase().trim() || "";
  if (value.includes("setting") || value.includes("infrastructure")) return "settings";
  if (value.includes("web") || value.includes("globe")) return "web";
  if (value.includes("cloud")) return "cloud";
  if (value.includes("shield") || value.includes("security")) return "security";
  if (value.includes("code") || value.includes("develop")) return "code";
  if (value.includes("chart") || value.includes("data") || value.includes("analytic")) return "data";
  if (value.includes("design") || value.includes("paint") || value.includes("ui")) return "design";
  if (value.includes("mobile") || value.includes("phone")) return "mobile";
  if (value.includes("market") || value.includes("bullhorn") || value.includes("megaphone")) return "marketing";
  if (value.includes("consult") || value.includes("strategy")) return "consulting";
  return "default";
}
