"use client";

import { useEffect, useState, useRef } from "react";
import { useInView, useMotionValue, useSpring } from "framer-motion";

interface AnimatedCounterProps {
  value: number;
  duration?: number;
  format?: "number" | "currency" | "percent";
  className?: string;
}

export default function AnimatedCounter({ 
  value, 
  duration = 2, 
  format = "number",
  className = "" 
}: AnimatedCounterProps) {
  const ref = useRef<HTMLSpanElement>(null);
  const isInView = useInView(ref, { once: true, margin: "-50px" });
  
  const motionValue = useMotionValue(0);
  const springValue = useSpring(motionValue, {
    duration: duration * 1000,
    bounce: 0,
  });
  
  const [displayValue, setDisplayValue] = useState("0");

  useEffect(() => {
    if (isInView) {
      motionValue.set(value);
    }
  }, [isInView, motionValue, value]);

  useEffect(() => {
    return springValue.on("change", (latest) => {
      let formatted = Math.floor(latest).toString();
      
      if (format === "currency") {
        formatted = "$" + Math.floor(latest).toLocaleString();
      } else if (format === "percent") {
        formatted = Math.floor(latest).toString() + "%";
      } else {
        formatted = Math.floor(latest).toLocaleString();
      }
      
      setDisplayValue(formatted);
    });
  }, [springValue, format]);

  return <span ref={ref} className={className}>{displayValue}</span>;
}
