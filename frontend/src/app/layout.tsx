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

export const metadata: Metadata = {
  title: {
    default: "Nova Agency — IT Services & Technology Solutions",
    template: "%s | Nova Agency",
  },
  description:
    "Professional IT services, technology solutions, and digital transformation for businesses of all sizes.",
  keywords: ["IT services", "technology solutions", "web development", "digital transformation"],
  openGraph: {
    type: "website",
    locale: "en_US",
    siteName: "Nova Agency",
  },
};

export const viewport = {
  themeColor: "#3b82f6",
};

import { LiveAnnouncer } from "@/components/ui/LiveAnnouncer";

export default async function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  const cookieStore = await cookies();
  const locale = cookieStore.get("NEXT_LOCALE")?.value || "en";
  const dir = locale === "ar" ? "rtl" : "ltr";

  return (
    <html lang={locale} dir={dir} className={inter.variable}>
      <body className={`antialiased${dir === "rtl" ? " font-arabic" : ""}`}>
        <a href="#main-content" className="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-[var(--primary)] text-white px-4 py-2 z-50 rounded-md font-semibold focus-ring">
          Skip to content
        </a>
        <LiveAnnouncer />
        <Navbar locale={locale} />
        <main id="main-content" className="min-h-screen">{children}</main>
        <Footer locale={locale} />
        <ChatWidget />
      </body>
    </html>
  );
}
