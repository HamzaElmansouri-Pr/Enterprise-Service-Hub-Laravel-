"use client";

import { useEffect, useState } from "react";
import { usePathname } from "next/navigation";

export function LiveAnnouncer() {
  const [message, setMessage] = useState("");
  const pathname = usePathname();

  useEffect(() => {
    // Announce page changes to screen readers
    // eslint-disable-next-line react-hooks/set-state-in-effect
    setMessage(`Navigated to ${pathname === '/' ? 'Home' : pathname}`);
    
    // Clear message after announcement
    const timer = setTimeout(() => setMessage(""), 3000);
    return () => clearTimeout(timer);
  }, [pathname]);

  return (
    <div
      aria-live="polite"
      aria-atomic="true"
      className="sr-only"
    >
      {message}
    </div>
  );
}
