"use client";
import { useEffect } from 'react';
import { ErrorState } from '@/components/ui/ErrorState';

export default function Error({ error, reset }: { error: Error & { digest?: string }; reset: () => void }) {
  useEffect(() => {
    console.error(error);
  }, [error]);

  return <div className="container mx-auto px-4"><ErrorState reset={reset} /></div>;
}
