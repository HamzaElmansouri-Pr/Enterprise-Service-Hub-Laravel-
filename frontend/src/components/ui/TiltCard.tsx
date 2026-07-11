"use client";

import { useRef, useState, ReactNode, MouseEvent } from "react";
import { motion, useSpring, useTransform } from "framer-motion";

interface TiltCardProps {
  children: ReactNode;
  className?: string;
  intensity?: number;
}

export default function TiltCard({ children, className = "", intensity = 15 }: TiltCardProps) {
  const ref = useRef<HTMLDivElement>(null);
  
  // Track mouse position over the card
  const [x, setX] = useState(0);
  const [y, setY] = useState(0);

  // Smooth out the spring physics for that premium feel
  const mouseXSpring = useSpring(x, { stiffness: 150, damping: 20 });
  const mouseYSpring = useSpring(y, { stiffness: 150, damping: 20 });

  // Transform raw mouse position into rotation values
  const rotateX = useTransform(mouseYSpring, [-0.5, 0.5], [intensity, -intensity]);
  const rotateY = useTransform(mouseXSpring, [-0.5, 0.5], [-intensity, intensity]);

  const handleMouseMove = (e: MouseEvent<HTMLDivElement>) => {
    if (!ref.current) return;
    
    const rect = ref.current.getBoundingClientRect();
    
    // Calculate mouse position relative to the center of the card (-0.5 to 0.5)
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
      style={{
        rotateX,
        rotateY,
        transformStyle: "preserve-3d",
      }}
      className={`relative w-full ${className}`}
    >
      <div 
        style={{ transform: "translateZ(30px)" }} 
        className="w-full h-full"
      >
        {children}
      </div>
    </motion.div>
  );
}
