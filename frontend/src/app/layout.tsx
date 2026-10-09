import type { Metadata } from "next";
import { cookies } from "next/headers";
import { Inter } from "next/font/google";
import "./globals.css";
import { Navbar } from "@/components/layout/Navbar";
import { Footer } from "@/components/layout/Footer";
import { ChatWidget } from "@/components/layout/ChatWidget";

const inter = Inter({
  subsets: ["latin"],
  variable: "--font-inter",
});

import { LiveAnnouncer } from "@/components/ui/LiveAnnouncer";
import { getGlobalConfig } from "@/lib/api";

export const viewport = {
  themeColor: "#3b82f6",
};

export async function generateMetadata(): Promise<Metadata> {
  try {
    const globalConfig = await getGlobalConfig();
    const siteInfo = globalConfig?.site_info || {};
    
    return {
      title: {
        default: siteInfo.site_name || "ELMA Core — IT Services & Technology Solutions",
        template: `%s | ${siteInfo.site_name || "ELMA Core"}`,
      },
      description: siteInfo.site_description || "Professional IT services, technology solutions, and digital transformation for businesses of all sizes.",
      keywords: siteInfo.seo_keywords ? siteInfo.seo_keywords.split(',') : ["IT services", "technology solutions", "web development", "digital transformation"],
      openGraph: {
        type: "website",
        locale: "en_US",
        siteName: siteInfo.site_name || "ELMA Core",
      },
    };
  } catch (e) {
    return {
      title: {
        default: "ELMA Core — IT Services & Technology Solutions",
        template: "%s | ELMA Core",
      },
      description: "Professional IT services, technology solutions, and digital transformation for businesses of all sizes.",
      keywords: ["IT services", "technology solutions", "web development", "digital transformation"],
    };
  }
}

export default async function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  const cookieStore = await cookies();
  const locale = cookieStore.get("NEXT_LOCALE")?.value || "en";
  const dir = locale === "ar" ? "rtl" : "ltr";
  
  let globalConfig = null;
  try {
    globalConfig = await getGlobalConfig();
  } catch (e) {
    console.error("Failed to fetch global config", e);
  }

  return (
    <html lang={locale} dir={dir} className={inter.variable}>
      <body className={`antialiased${dir === "rtl" ? " font-arabic" : ""}`}>
        <a href="#main-content" className="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-[var(--primary)] text-white px-4 py-2 z-50 rounded-md font-semibold focus-ring">
          Skip to content
        </a>
        <LiveAnnouncer />
        <Navbar locale={locale} siteInfo={globalConfig?.site_info} />
        <main id="main-content" className="min-h-screen">{children}</main>
        <Footer locale={locale} siteInfo={globalConfig?.site_info} footerContent={globalConfig?.footer_content} />
        <ChatWidget locale={locale} />
      </body>
    </html>
  );
}
