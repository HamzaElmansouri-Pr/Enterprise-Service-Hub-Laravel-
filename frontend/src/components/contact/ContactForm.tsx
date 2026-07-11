"use client";

import { useState } from "react";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import * as z from "zod";
import { submitContact } from "@/lib/api";
import { motion } from "framer-motion";

import { getDictionary } from "@/lib/dictionary";

export function ContactForm({ locale = "en" }: { locale?: string }) {
  const [status, setStatus] = useState<"idle" | "loading" | "success" | "error">("idle");
  const [message, setMessage] = useState("");
  const t = getDictionary(locale).contact;

  const contactSchema = z.object({
    name: z.string().min(2, t.name + " is required"),
    email: z.string().email("Invalid email address"),
    phone: z.string().optional(),
    subject: z.string().min(2, t.subject + " is required"),
    message: z.string().min(10, t.message + " is too short"),
    website_url: z.string().optional(), // honeypot
  });

  type ContactFormData = z.infer<typeof contactSchema>;

  const {
    register,
    handleSubmit,
    reset,
    formState: { errors },
  } = useForm<ContactFormData>({
    resolver: zodResolver(contactSchema),
  });

  const onSubmit = async (data: ContactFormData) => {
    setStatus("loading");
    try {
      const res = await submitContact(data);
      setStatus("success");
      setMessage(res.message);
      reset();
    } catch {
      setStatus("error");
      setMessage(t.error);
    }
  };

  const inputClass = "w-full px-5 py-4 rounded-xl bg-white/[0.03] border text-white placeholder:text-white/30 focus:outline-none focus:bg-white/[0.05] transition-all duration-300";
  const getInputClass = (error?: { message?: string }) => 
    `${inputClass} ${error ? "border-red-500/50 focus:border-red-500 focus:ring-1 focus:ring-red-500/30" : "border-white/10 focus:border-[var(--primary)]/50 focus:ring-1 focus:ring-[var(--primary)]/30"}`;

  return (
    <motion.div 
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.6 }}
      className="elite-glass p-8 sm:p-12 rounded-[32px] border border-white/10 shadow-2xl relative overflow-hidden"
    >
      {/* Background Glow */}
      <div className="absolute top-0 right-0 w-64 h-64 bg-[var(--primary)]/10 rounded-full blur-[100px] pointer-events-none" />
      <div className="absolute bottom-0 left-0 w-64 h-64 bg-[var(--accent)]/10 rounded-full blur-[100px] pointer-events-none" />

      <form onSubmit={handleSubmit(onSubmit)} className="relative z-10 space-y-6">
        {/* Honeypot Field */}
        <div style={{ display: 'none' }} aria-hidden="true">
          <label htmlFor="website_url">Website URL</label>
          <input type="text" id="website_url" tabIndex={-1} autoComplete="off" {...register("website_url")} />
        </div>
        <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <div className="space-y-2">
            <label className="text-sm font-medium text-[var(--text-secondary)] ml-1">{t.name}</label>
            <input type="text" placeholder={t.name} className={getInputClass(errors.name)} {...register("name")} />
            {errors.name && <p className="text-red-400 text-xs ml-1 mt-1">{errors.name.message}</p>}
          </div>
          <div className="space-y-2">
            <label className="text-sm font-medium text-[var(--text-secondary)] ml-1">{t.email}</label>
            <input type="email" placeholder={t.email} className={getInputClass(errors.email)} {...register("email")} />
            {errors.email && <p className="text-red-400 text-xs ml-1 mt-1">{errors.email.message}</p>}
          </div>
        </div>
        
        <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <div className="space-y-2">
            <label className="text-sm font-medium text-[var(--text-secondary)] ml-1">{t.phone} <span className="text-white/20">({locale === 'ar' ? 'اختياري' : (locale === 'fr' ? 'Optionnel' : 'Optional')})</span></label>
            <input type="tel" placeholder={t.phone} className={getInputClass(errors.phone)} {...register("phone")} />
          </div>
          <div className="space-y-2">
            <label className="text-sm font-medium text-[var(--text-secondary)] ml-1">{t.subject}</label>
            <input type="text" placeholder={t.subject} className={getInputClass(errors.subject)} {...register("subject")} />
            {errors.subject && <p className="text-red-400 text-xs ml-1 mt-1">{errors.subject.message}</p>}
          </div>
        </div>
        
        <div className="space-y-2">
          <label className="text-sm font-medium text-[var(--text-secondary)] ml-1">{t.message}</label>
          <textarea placeholder={t.message} rows={5} className={`${getInputClass(errors.message)} resize-none`} {...register("message")} />
          {errors.message && <p className="text-red-400 text-xs ml-1 mt-1">{errors.message.message}</p>}
        </div>



        <div className="pt-4">
          <button 
            type="submit" 
            disabled={status === "loading"} 
            className="w-full relative group overflow-hidden rounded-xl p-[1px] disabled:opacity-70 disabled:cursor-not-allowed"
          >
            <div className="absolute inset-0 bg-gradient-to-r from-[var(--primary)] to-[var(--accent)] rounded-xl opacity-80 group-hover:opacity-100 transition-opacity duration-300" />
            <div className="relative flex items-center justify-center gap-3 px-8 py-4 bg-[var(--bg-deep)] group-hover:bg-transparent rounded-[11px] transition-colors duration-300">
              <span className="font-semibold text-white text-lg">
                {status === "loading" ? t.sending : t.send}
              </span>
              {!status && (
                <svg className="w-5 h-5 text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              )}
            </div>
          </button>
        </div>

        {status === "success" && (
          <motion.p initial={{ opacity: 0, y: -10 }} animate={{ opacity: 1, y: 0 }} className="text-[#4ade80] text-sm text-center bg-[#4ade80]/10 py-3 rounded-lg border border-[#4ade80]/20">
            {message}
          </motion.p>
        )}
        {status === "error" && (
          <motion.p initial={{ opacity: 0, y: -10 }} animate={{ opacity: 1, y: 0 }} className="text-[#f87171] text-sm text-center bg-[#f87171]/10 py-3 rounded-lg border border-[#f87171]/20">
            {message}
          </motion.p>
        )}
      </form>
    </motion.div>
  );
}
