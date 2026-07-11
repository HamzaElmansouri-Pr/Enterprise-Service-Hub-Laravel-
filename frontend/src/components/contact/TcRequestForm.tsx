"use client";

import { useState, useRef } from "react";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import * as z from "zod";
import { submitTcRequest } from "@/lib/api";
import type { Service } from "@/lib/types";
import { motion, AnimatePresence } from "framer-motion";
import { getDictionary } from "@/lib/dictionary";

interface TcRequestFormProps {
  services: Service[];
  locale?: string;
}

export function TcRequestForm({ services, locale = "en" }: TcRequestFormProps) {
  const [step, setStep] = useState(1);
  const [status, setStatus] = useState<"idle" | "loading" | "success" | "error">("idle");
  const [message, setMessage] = useState("");
  const [dragActive, setDragActive] = useState(false);
  const [selectedFileName, setSelectedFileName] = useState<string | null>(null);
  const fileInputRef = useRef<HTMLInputElement>(null);

  const t = getDictionary(locale).contact.consultation;
  
  const nextText = locale === 'ar' ? 'التالي' : (locale === 'fr' ? 'Suivant' : 'Next');
  const prevText = locale === 'ar' ? 'السابق' : (locale === 'fr' ? 'Précédent' : 'Previous');

  const tcSchema = z.object({
    email: z.string().email("Invalid email address"),
    service_id: z.string().optional(),
    budget_range: z.string().optional(),
    timeline: z.string().optional(),
    description: z.string().min(10, t.detailsPlaceholder + " (min 10 chars)"),
    website_url: z.string().optional(),
  });

  type TcFormData = z.infer<typeof tcSchema>;

  const {
    register,
    handleSubmit,
    trigger,
    watch,
    setValue,
    reset,
    formState: { errors },
  } = useForm<TcFormData>({
    resolver: zodResolver(tcSchema),
    mode: "onTouched",
    defaultValues: {
      budget_range: "5000",
      timeline: "Flexible",
    }
  });

  const nextStep = async () => {
    let fieldsToValidate: (keyof TcFormData)[] = [];
    if (step === 1) fieldsToValidate = ["service_id"];
    if (step === 2) fieldsToValidate = ["description"];
    if (step === 3) fieldsToValidate = ["email"];
    
    const isValid = await trigger(fieldsToValidate);
    if (isValid) setStep((s) => s + 1);
  };

  const prevStep = () => setStep((s) => s - 1);

  async function onSubmit(data: TcFormData) {
    setStatus("loading");
    
    const form = document.getElementById("tc-form") as HTMLFormElement;
    const formData = new FormData(form);
    
    // Explicitly append react-hook-form values in case custom components didn't update native inputs
    formData.set("service_id", data.service_id || "");
    formData.set("budget_range", data.budget_range || "");
    formData.set("timeline", data.timeline || "");

    try {
      const res = await submitTcRequest(formData);
      setStatus("success");
      setMessage(res.message);
      reset();
      setSelectedFileName(null);
      setStep(1);
    } catch {
      setStatus("error");
      setMessage(getDictionary(locale).contact.error);
    }
  }

  // Drag and Drop handlers
  const handleDrag = (e: React.DragEvent) => {
    e.preventDefault();
    e.stopPropagation();
    if (e.type === "dragenter" || e.type === "dragover") {
      setDragActive(true);
    } else if (e.type === "dragleave") {
      setDragActive(false);
    }
  };

  const handleDrop = (e: React.DragEvent) => {
    e.preventDefault();
    e.stopPropagation();
    setDragActive(false);
    
    if (e.dataTransfer.files && e.dataTransfer.files[0]) {
      handleFile(e.dataTransfer.files[0]);
    }
  };

  const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    if (e.target.files && e.target.files[0]) {
      handleFile(e.target.files[0]);
    }
  };

  const handleFile = (file: File) => {
    setSelectedFileName(file.name);
    // Programmatically set the file in the hidden input
    if (fileInputRef.current) {
      const dataTransfer = new DataTransfer();
      dataTransfer.items.add(file);
      fileInputRef.current.files = dataTransfer.files;
    }
  };

  const inputClass = "w-full px-5 py-4 rounded-xl bg-white/[0.03] border text-white placeholder:text-white/30 focus:outline-none focus:bg-white/[0.05] transition-all duration-300";
  const getInputClass = (error?: { message?: string }) => 
    `${inputClass} ${error ? "border-red-500/50 focus:border-red-500 focus:ring-1 focus:ring-red-500/30" : "border-white/10 focus:border-[var(--accent)]/50 focus:ring-1 focus:ring-[var(--accent)]/30"}`;

  const currentServiceId = watch("service_id");
  const currentTimeline = watch("timeline");
  const currentBudget = watch("budget_range");

  return (
    <motion.div 
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.6, delay: 0.1 }}
      className="elite-glass p-8 sm:p-12 rounded-[32px] border border-white/10 shadow-2xl relative overflow-hidden"
    >
      <div className="absolute top-0 left-0 w-64 h-64 bg-[var(--accent)]/10 rounded-full blur-[100px] pointer-events-none" />
      <div className="absolute bottom-0 right-0 w-64 h-64 bg-[var(--primary)]/10 rounded-full blur-[100px] pointer-events-none" />

      {/* Progress Steps */}
      <div className="relative z-10 mb-8 flex items-center justify-between">
        {[1, 2, 3, 4].map((num) => (
          <div key={num} className="flex flex-col items-center relative z-10">
            <div className={`w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors duration-300 ${step >= num ? "bg-[var(--accent)] text-white shadow-[0_0_15px_var(--accent)]" : "bg-white/10 text-white/40"}`}>
              {num}
            </div>
          </div>
        ))}
        {/* Connecting Lines */}
        <div className="absolute top-4 left-0 w-full h-[2px] bg-white/10 -z-10">
          <motion.div 
            className="h-full bg-[var(--accent)]" 
            initial={{ width: "0%" }}
            animate={{ width: `${((step - 1) / 3) * 100}%` }}
            transition={{ duration: 0.3 }}
          />
        </div>
      </div>

      <form id="tc-form" onSubmit={handleSubmit(onSubmit)} className="relative z-10">
        <div style={{ display: 'none' }} aria-hidden="true">
          <input type="text" id="website_url_tc" tabIndex={-1} autoComplete="off" {...register("website_url")} />
        </div>

        <div className="min-h-[380px]">
          <AnimatePresence mode="wait">
            {step === 1 && (
              <motion.div key="step1" initial={{ opacity: 0, x: -20 }} animate={{ opacity: 1, x: 0 }} exit={{ opacity: 0, x: 20 }} className="space-y-6">
                <div className="space-y-4">
                  <label className="text-lg font-medium text-white">{t.selectService}</label>
                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {services.map((s) => (
                      <div 
                        key={s.id} 
                        onClick={() => setValue("service_id", s.id.toString(), { shouldValidate: true })}
                        className={`cursor-pointer rounded-2xl p-5 border transition-all duration-300 ${currentServiceId === s.id.toString() ? 'bg-gradient-to-br from-[var(--accent)]/20 to-[var(--primary)]/20 border-[var(--accent)] shadow-[0_0_15px_rgba(var(--accent-rgb),0.3)]' : 'bg-white/[0.03] border-white/10 hover:border-white/30 hover:bg-white/[0.05]'}`}
                      >
                        <div className="flex items-center gap-4">
                          <div className={`w-10 h-10 rounded-full flex items-center justify-center ${currentServiceId === s.id.toString() ? 'bg-[var(--accent)] text-white' : 'bg-white/10 text-[var(--accent)]'}`}>
                            {s.icon ? <i className={s.icon}></i> : <span className="font-bold">{s.title.charAt(0)}</span>}
                          </div>
                          <div>
                            <h4 className="text-white font-medium">{s.title}</h4>
                            <p className="text-xs text-[var(--text-muted)] line-clamp-1">{s.subtitle || s.description || ""}</p>
                          </div>
                        </div>
                      </div>
                    ))}
                  </div>
                  {/* Hidden input for RHF to track value */}
                  <input type="hidden" {...register("service_id")} />
                </div>
              </motion.div>
            )}

            {step === 2 && (
              <motion.div key="step2" initial={{ opacity: 0, x: -20 }} animate={{ opacity: 1, x: 0 }} exit={{ opacity: 0, x: 20 }} className="space-y-8">
                
                {/* Budget Range Slider */}
                <div className="space-y-4">
                  <div className="flex justify-between items-center">
                    <label className="text-sm font-medium text-[var(--text-secondary)]">{t.budget || "Budget Range"}</label>
                    <span className="text-[var(--accent)] font-semibold">${Number(currentBudget).toLocaleString()}</span>
                  </div>
                  <input 
                    type="range" 
                    min="1000" 
                    max="50000" 
                    step="1000" 
                    className="w-full h-2 bg-white/20 rounded-lg appearance-none cursor-pointer accent-[var(--accent)]"
                    {...register("budget_range")}
                  />
                  <div className="flex justify-between text-xs text-white/40">
                    <span>$1,000</span>
                    <span>$50,000+</span>
                  </div>
                </div>

                {/* Timeline Radio Buttons */}
                <div className="space-y-4">
                  <label className="text-sm font-medium text-[var(--text-secondary)]">{t.timeline || "Timeline"}</label>
                  <div className="flex flex-wrap gap-3">
                    {["ASAP", "1-3 months", "3-6 months", "Flexible"].map((opt) => (
                      <div 
                        key={opt}
                        onClick={() => setValue("timeline", opt)}
                        className={`cursor-pointer px-5 py-2.5 rounded-full border transition-all ${currentTimeline === opt ? 'bg-[var(--accent)] border-[var(--accent)] text-white' : 'bg-white/[0.03] border-white/10 text-white/70 hover:border-white/30'}`}
                      >
                        {opt}
                      </div>
                    ))}
                  </div>
                  <input type="hidden" {...register("timeline")} />
                </div>

                {/* Description */}
                <div className="space-y-2">
                  <label className="text-sm font-medium text-[var(--text-secondary)]">{t.details}</label>
                  <textarea placeholder={t.detailsPlaceholder} rows={4} className={`${getInputClass(errors.description)} resize-none`} {...register("description")} />
                  {errors.description && <p className="text-red-400 text-xs mt-1">{errors.description.message}</p>}
                </div>
              </motion.div>
            )}

            {step === 3 && (
              <motion.div key="step3" initial={{ opacity: 0, x: -20 }} animate={{ opacity: 1, x: 0 }} exit={{ opacity: 0, x: 20 }} className="space-y-6">
                <div className="space-y-2">
                  <label className="text-sm font-medium text-[var(--text-secondary)] ml-1">{t.email}</label>
                  <input type="email" placeholder="your@email.com" className={getInputClass(errors.email)} {...register("email")} />
                  {errors.email && <p className="text-red-400 text-xs ml-1 mt-1">{errors.email.message}</p>}
                </div>

                <div className="space-y-2">
                  <label className="text-sm font-medium text-[var(--text-secondary)] ml-1">{t.attach} <span className="text-white/20">({locale === 'ar' ? 'اختياري' : (locale === 'fr' ? 'Optionnel' : 'Optional')})</span></label>
                  <div 
                    className={`relative rounded-xl border-2 border-dashed p-8 text-center transition-all duration-300 ${dragActive ? 'bg-[var(--accent)]/10 border-[var(--accent)]' : 'bg-white/[0.02] border-white/10 hover:bg-white/[0.04]'}`}
                    onDragEnter={handleDrag}
                    onDragLeave={handleDrag}
                    onDragOver={handleDrag}
                    onDrop={handleDrop}
                  >
                    <input 
                      ref={fileInputRef}
                      name="attached_file" 
                      type="file" 
                      className="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                      onChange={handleFileChange}
                    />
                    <div className="flex flex-col items-center justify-center gap-3">
                      <svg className={`w-10 h-10 transition-colors ${dragActive ? 'text-[var(--accent)]' : 'text-white/40'}`} fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                      </svg>
                      {selectedFileName ? (
                        <span className="text-white font-medium bg-[var(--accent)]/20 px-3 py-1 rounded-full">{selectedFileName}</span>
                      ) : (
                        <span className="text-sm text-[var(--text-muted)] pointer-events-none">{t.upload}</span>
                      )}
                    </div>
                  </div>
                </div>
              </motion.div>
            )}

            {step === 4 && (
              <motion.div key="step4" initial={{ opacity: 0, x: -20 }} animate={{ opacity: 1, x: 0 }} exit={{ opacity: 0, x: 20 }} className="space-y-4">
                <h3 className="text-xl font-semibold text-white mb-4">Review your request</h3>
                <div className="bg-white/5 rounded-xl p-5 space-y-4 border border-white/10">
                  <div className="grid grid-cols-2 gap-4">
                    <div>
                      <p className="text-xs text-[var(--text-muted)]">{t.email}</p>
                      <p className="text-white font-medium break-all">{watch("email")}</p>
                    </div>
                    {currentServiceId && (
                      <div>
                        <p className="text-xs text-[var(--text-muted)]">{t.service}</p>
                        <p className="text-white font-medium">
                          {services.find(s => s.id.toString() === currentServiceId)?.title || "-"}
                        </p>
                      </div>
                    )}
                    <div>
                      <p className="text-xs text-[var(--text-muted)]">{t.budget || "Budget"}</p>
                      <p className="text-[var(--accent)] font-medium">${Number(currentBudget).toLocaleString()}</p>
                    </div>
                    <div>
                      <p className="text-xs text-[var(--text-muted)]">{t.timeline || "Timeline"}</p>
                      <p className="text-white font-medium">{currentTimeline}</p>
                    </div>
                  </div>
                  <div className="pt-2 border-t border-white/10">
                    <p className="text-xs text-[var(--text-muted)] mb-1">{t.details}</p>
                    <p className="text-white text-sm line-clamp-3">{watch("description")}</p>
                  </div>
                  {selectedFileName && (
                    <div className="pt-2 border-t border-white/10">
                      <p className="text-xs text-[var(--text-muted)] mb-1">{t.attach}</p>
                      <p className="text-white text-sm">{selectedFileName}</p>
                    </div>
                  )}
                </div>
              </motion.div>
            )}
          </AnimatePresence>
        </div>

        <div className="pt-8 flex gap-4">
          {step > 1 && (
            <button 
              type="button" 
              onClick={prevStep}
              className="flex-1 py-4 bg-white/5 hover:bg-white/10 rounded-xl text-white font-semibold transition-colors"
            >
              {prevText}
            </button>
          )}
          
          {step < 4 ? (
            <button 
              type="button" 
              onClick={nextStep}
              className="flex-1 py-4 bg-gradient-to-r from-[var(--accent)] to-[var(--primary)] rounded-xl text-white font-semibold opacity-90 hover:opacity-100 transition-opacity"
            >
              {nextText}
            </button>
          ) : (
            <button 
              type="submit" 
              disabled={status === "loading"} 
              className="flex-1 relative group overflow-hidden rounded-xl p-[1px] disabled:opacity-70 disabled:cursor-not-allowed"
            >
              <div className="absolute inset-0 bg-gradient-to-r from-[var(--accent)] to-[var(--primary)] rounded-xl opacity-80 group-hover:opacity-100 transition-opacity duration-300" />
              <div className="relative flex items-center justify-center gap-3 py-4 bg-[var(--bg-deep)] group-hover:bg-transparent rounded-xl transition-colors duration-300">
                <span className="font-semibold text-white text-lg">
                  {status === "loading" ? t.submitting : t.submit}
                </span>
              </div>
            </button>
          )}
        </div>

        {status === "success" && (
          <motion.p initial={{ opacity: 0, y: -10 }} animate={{ opacity: 1, y: 0 }} className="text-[#4ade80] text-sm text-center bg-[#4ade80]/10 py-3 rounded-lg border border-[#4ade80]/20 mt-6">
            {message}
          </motion.p>
        )}
        {status === "error" && (
          <motion.p initial={{ opacity: 0, y: -10 }} animate={{ opacity: 1, y: 0 }} className="text-[#f87171] text-sm text-center bg-[#f87171]/10 py-3 rounded-lg border border-[#f87171]/20 mt-6">
            {message}
          </motion.p>
        )}
      </form>
    </motion.div>
  );
}
