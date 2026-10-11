"use client";

import { useState } from "react";
import Link from "next/link";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import * as z from "zod";
import { submitTcRequest } from "@/lib/api";
import type { Service } from "@/lib/types";
import { getDictionary } from "@/lib/dictionary";

const schema = z.object({
  email: z.string().email("Please enter a valid work email."),
  service_id: z.string().optional(),
  budget_range: z.string().optional(),
  timeline: z.string().optional(),
  description: z.string().min(10, "Please provide at least 10 characters detailing your project."),
  website_url: z.string().optional(),
});

type Values = z.infer<typeof schema>;

export function TcRequestForm({ services, locale = "en" }: { services: Service[]; locale?: string }) {
  const dictionary = getDictionary(locale);
  const t = dictionary.contactPage;
  const isRtl = locale === "ar";
  const [file, setFile] = useState<File | null>(null);
  const [fileError, setFileError] = useState("");
  const [fileKey, setFileKey] = useState(0);
  const [status, setStatus] = useState<"idle" | "loading" | "success" | "error">("idle");
  const [notice, setNotice] = useState("");

  const {
    register,
    handleSubmit,
    reset,
    formState: { errors },
  } = useForm<Values>({
    resolver: zodResolver(schema),
    defaultValues: { budget_range: "", timeline: "" },
  });

  const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const selected = e.target.files?.[0];
    setFileError("");
    if (!selected) {
      setFile(null);
      return;
    }
    if (selected.size > 10 * 1024 * 1024) {
      setFileError("File exceeds 10MB limit.");
      setFile(null);
      return;
    }
    const ext = selected.name.split(".").pop()?.toLowerCase() || "";
    if (!["pdf", "doc", "docx", "txt"].includes(ext)) {
      setFileError("Invalid format. Accepted: PDF, DOC, DOCX, TXT.");
      setFile(null);
      return;
    }
    setFile(selected);
  };

  async function onSubmit(values: Values) {
    setStatus("loading");
    setNotice("");
    const data = new FormData();
    Object.entries(values).forEach(([key, value]) => {
      if (value !== undefined && value !== null) {
        data.set(key, value);
      }
    });
    if (file) data.set("attached_file", file);

    try {
      const response = await submitTcRequest(data);
      setStatus("success");
      setNotice(response.message || "Your request has been received.");
      reset();
      setFile(null);
      setFileKey((v) => v + 1);
    } catch {
      setStatus("error");
      setNotice(dictionary.contact.error);
    }
  }

  const input =
    "mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50/60 px-3.5 py-3 text-sm text-[var(--ink)] placeholder:text-slate-400 focus:bg-white focus:border-[var(--blue)] focus:ring-2 focus:ring-blue-100 transition-all outline-none";

  return (
    <form onSubmit={handleSubmit(onSubmit)} className="space-y-4">
      <input type="text" className="hidden" tabIndex={-1} autoComplete="off" {...register("website_url")} />
      
      <Label label={t.fields.email} required error={errors.email?.message}>
        <input type="email" placeholder={t.fields.emailPlaceholder} className={input} {...register("email")} />
      </Label>

      <Label label={t.fields.service} optional={t.fields.optional}>
        <select className={input} {...register("service_id")}>
          <option value="">{t.fields.selectService}</option>
          {services.map((service) => (
            <option key={service.id} value={service.id}>
              {service.title}
            </option>
          ))}
        </select>
      </Label>

      <div className="grid gap-4 sm:grid-cols-2">
        <Label label={t.fields.budget} optional={t.fields.optional}>
          <select className={input} {...register("budget_range")}>
            <option value="">{t.fields.selectBudget}</option>
            <option value="1000">{t.fields.budgetOptions.tier1}</option>
            <option value="5000">{t.fields.budgetOptions.tier2}</option>
            <option value="10000">{t.fields.budgetOptions.tier3}</option>
            <option value="50000">{t.fields.budgetOptions.tier4}</option>
          </select>
        </Label>

        <Label label={t.fields.timeline} optional={t.fields.optional}>
          <select className={input} {...register("timeline")}>
            <option value="">{t.fields.selectTimeline}</option>
            <option value="ASAP">{t.fields.timelineOptions.asap}</option>
            <option value="1-3 months">{t.fields.timelineOptions.months1_3}</option>
            <option value="3-6 months">{t.fields.timelineOptions.months3_6}</option>
            <option value="Flexible">{t.fields.timelineOptions.flexible}</option>
          </select>
        </Label>
      </div>

      <Label label={t.fields.projectDetails} required error={errors.description?.message}>
        <textarea rows={4} className={input} placeholder={t.fields.projectDetailsPlaceholder} {...register("description")} />
      </Label>

      <div>
        <label className="block text-xs font-bold text-[var(--ink)]">
          {t.fields.attachment}
          <span className="text-slate-400 font-normal text-xs ml-1.5">({t.fields.optional})</span>
        </label>
        <p className="text-[11px] text-slate-500 mb-2">{t.fields.attachmentHint}</p>
        <input
          key={fileKey}
          type="file"
          accept=".pdf,.doc,.docx,.txt"
          className="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[var(--blue)] hover:file:bg-blue-100 cursor-pointer border border-dashed border-slate-300 rounded-xl p-2.5 bg-slate-50/40"
          onChange={handleFileChange}
        />
        {file && <p className="mt-2 text-xs text-emerald-700">📎 {file.name} ({(file.size / 1024 / 1024).toFixed(2)} MB)</p>}
        {fileError && <p className="mt-1 text-xs text-red-600">{fileError}</p>}
      </div>

      <p className="text-xs text-slate-500 leading-relaxed pt-1">
        {t.privacy.notice}{" "}
        <Link href="/privacy" className="text-[var(--blue)] underline font-medium hover:text-blue-700">
          {t.privacy.linkText}
        </Link>
        .
      </p>

      <button
        disabled={status === "loading"}
        className="button-primary mt-2 w-full py-3.5 rounded-xl font-bold text-sm tracking-wide shadow-sm hover:shadow transition-all disabled:opacity-60 flex items-center justify-center gap-2"
      >
        {status === "loading" ? (
          <span>{t.buttons.submitting}</span>
        ) : (
          <>
            <span>{t.buttons.submitProject}</span>
            <span className={isRtl ? "rotate-180" : ""}>→</span>
          </>
        )}
      </button>

      {status !== "idle" && (
        <p aria-live="polite" className={`mt-3 text-xs sm:text-sm font-medium ${status === "success" ? "text-emerald-700" : "text-red-600"}`}>
          {notice}
        </p>
      )}
    </form>
  );
}

function Label({
  label,
  required,
  optional,
  error,
  children,
}: {
  label: string;
  required?: boolean;
  optional?: string;
  error?: string;
  children: React.ReactNode;
}) {
  return (
    <div>
      <label className="block text-xs font-bold text-[var(--ink)]">
        {label}
        {required && <span className="text-red-500 font-bold ml-1">*</span>}
        {optional && <span className="text-slate-400 font-normal text-xs ml-1.5">({optional})</span>}
      </label>
      {children}
      {error && <span className="mt-1 block text-xs text-red-600">{error}</span>}
    </div>
  );
}
