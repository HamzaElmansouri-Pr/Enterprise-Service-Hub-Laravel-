"use client";

import { useRef, useState, ReactNode, MouseEvent } from "react";
import { motion, useSpring, useTransform } from "framer-motion";

interface MagneticButtonProps {
  children: ReactNode;
  className?: string;
  intensity?: number;
  onClick?: () => void;
}

export default function MagneticButton({ 
  children, 
  className = "", 
  intensity = 0.5,
  onClick
}: MagneticButtonProps) {
  const ref = useRef<HTMLDivElement>(null);
  
  // Track mouse position over the button area
  const [x, setX] = useState(0);
  const [y, setY] = useState(0);

  // Smooth out the spring physics for that premium feel
  const mouseXSpring = useSpring(x, { stiffness: 150, damping: 15, mass: 0.1 });
  const mouseYSpring = useSpring(y, { stiffness: 150, damping: 15, mass: 0.1 });

  // Transform raw mouse position into translation values
  const translateX = useTransform(mouseXSpring, [-0.5, 0.5], [-intensity * 50, intensity * 50]);
  const translateY = useTransform(mouseYSpring, [-0.5, 0.5], [-intensity * 50, intensity * 50]);

  const handleMouseMove = (e: MouseEvent<HTMLDivElement>) => {
    if (!ref.current) return;
    
    const rect = ref.current.getBoundingClientRect();
    
    // Calculate mouse position relative to the center of the button (-0.5 to 0.5)
    const width = rect.width;
    const height = rect.height;
    
    const mouseX = e.clientX - rect.left;
    const mouseY = e.clientY - rect.top;
    
    const xPct = mouseX / width - 0.5;
    const yPct = mouseY / height - 0.5;
    
    setX(xPct);
    setY(yPct);
  };

  const handleMouseLeave = () => {
    setX(0);
    setY(0);
  };

  return (
    <motion.div
      ref={ref}
      onMouseMove={handleMouseMove}
      onMouseLeave={handleMouseLeave}
      onClick={onClick}
      style={{
        x: translateX,
        y: translateY,
      }}
      className={`inline-block cursor-pointer ${className}`}
    >
      {children}
    </motion.div>
  );
}
