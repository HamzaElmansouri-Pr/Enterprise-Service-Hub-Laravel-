"use client";

import { useState } from "react";
import Link from "next/link";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import * as z from "zod";
import { submitContact, submitTcRequest } from "@/lib/api";
import type { ContactInfoResponse, Service } from "@/lib/types";
import { getDictionary } from "@/lib/dictionary";

interface ContactInteractiveSectionProps {
  page: ContactInfoResponse["page"];
  services: Service[];
  locale?: string;
}

export function ContactInteractiveSection({
  page,
  services,
  locale = "en",
}: ContactInteractiveSectionProps) {
  const dictionary = getDictionary(locale);
  const t = dictionary.contactPage;
  const isRtl = locale === "ar";

  // Form type selector: default to "project" as requested
  const [formType, setFormType] = useState<"project" | "general">("project");

  // Check which contact details are available
  const hasAddress = Boolean(page.contact_address?.trim());
  const hasEmail = Boolean(page.contact_email?.trim());
  const hasPhone = Boolean(page.contact_phone?.trim());
  const hasAnyContactDetails = hasAddress || hasEmail || hasPhone;

  return (
    <section className="page-section page-section--mist py-12 sm:py-16">
      <div className="site-container">
        <div className="grid gap-10 lg:grid-cols-12 lg:gap-12 items-start">
          {/* Left Column: Introduction & Real Contact Details */}
          <div className="lg:col-span-5 space-y-6">
            <div>
              {page.eyebrow && (
                <span className="eyebrow block mb-2">{page.eyebrow}</span>
              )}
              <h2 className="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-[var(--ink)] leading-tight">
                {page.grid_title || page.contact_title || t.gridTitle}
              </h2>
              {(page.grid_description || page.contact_description || t.gridDescription) && (
                <p className="mt-3.5 text-base leading-relaxed text-slate-600">
                  {page.grid_description || page.contact_description || t.gridDescription}
                </p>
              )}
            </div>

            {/* Contact details list - Only displays real values, hides unavailable */}
            {hasAnyContactDetails && (
              <div className="space-y-3 pt-2">
                {hasAddress && page.contact_address && (
                  <div className="content-card flex items-start gap-4 p-4 sm:p-5 bg-white/90 rounded-xl border border-slate-200/80">
                    <span
                      className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 text-lg"
                      aria-hidden="true"
                    >
                      📍
                    </span>
                    <div className="min-w-0">
                      <span className="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">
                        {t.cards.visit}
                      </span>
                      <p className="mt-0.5 text-sm font-medium text-[var(--ink)] whitespace-pre-line leading-snug">
                        {page.contact_address}
                      </p>
                    </div>
                  </div>
                )}

                {hasEmail && page.contact_email && (
                  <a
                    href={`mailto:${page.contact_email}`}
                    className="content-card flex items-start gap-4 p-4 sm:p-5 bg-white/90 rounded-xl border border-slate-200/80 transition-all hover:border-blue-400 hover:shadow-sm group"
                  >
                    <span
                      className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 text-lg group-hover:bg-blue-600 group-hover:text-white transition-colors"
                      aria-hidden="true"
                    >
                      ✉
                    </span>
                    <div className="min-w-0">
                      <span className="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">
                        {t.cards.email}
                      </span>
                      <p className="mt-0.5 text-sm font-semibold text-[var(--blue)] group-hover:underline truncate">
                        {page.contact_email}
                      </p>
                    </div>
                  </a>
                )}

                {hasPhone && page.contact_phone && (
                  <a
                    href={`tel:${page.contact_phone.replace(/\s+/g, "")}`}
                    className="content-card flex items-start gap-4 p-4 sm:p-5 bg-white/90 rounded-xl border border-slate-200/80 transition-all hover:border-blue-400 hover:shadow-sm group"
                  >
                    <span
                      className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 text-lg group-hover:bg-blue-600 group-hover:text-white transition-colors"
                      aria-hidden="true"
                    >
                      📞
                    </span>
                    <div className="min-w-0">
                      <span className="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">
                        {t.cards.call}
                      </span>
                      <p className="mt-0.5 text-sm font-semibold text-[var(--ink)] group-hover:text-[var(--blue)] truncate" dir="ltr">
                        {page.contact_phone}
                      </p>
                    </div>
                  </a>
                )}
              </div>
            )}

            {/* Response time reassurance badge */}
            <div className="flex items-center gap-2.5 px-3.5 py-2 rounded-lg bg-slate-100/90 text-xs text-slate-600 w-fit">
              <span className="relative flex h-2 w-2">
                <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span className="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
              </span>
              <span>{t.cards.responseTimeValue}</span>
            </div>
          </div>

          {/* Right Column: Selected Form in a Larger White Card */}
          <div className="lg:col-span-7">
            <div className="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-6 sm:p-9 lg:p-10">
              {/* Form Selector Toggle Pills */}
              <div
                className="flex p-1 bg-slate-100 rounded-xl mb-7 border border-slate-200/70"
                role="tablist"
                aria-label="Contact options"
              >
                <button
                  type="button"
                  role="tab"
                  id="tab-project"
                  aria-selected={formType === "project"}
                  aria-controls="panel-project"
                  onClick={() => setFormType("project")}
                  className={`flex-1 py-2.5 px-4 text-xs sm:text-sm font-bold rounded-lg transition-all duration-200 text-center ${
                    formType === "project"
                      ? "bg-[#06162d] text-white shadow-sm"
                      : "text-slate-600 hover:text-slate-900 hover:bg-slate-200/50"
                  }`}
                >
                  {t.selector.discussProject}
                </button>
                <button
                  type="button"
                  role="tab"
                  id="tab-general"
                  aria-selected={formType === "general"}
                  aria-controls="panel-general"
                  onClick={() => setFormType("general")}
                  className={`flex-1 py-2.5 px-4 text-xs sm:text-sm font-bold rounded-lg transition-all duration-200 text-center ${
                    formType === "general"
                      ? "bg-[#06162d] text-white shadow-sm"
                      : "text-slate-600 hover:text-slate-900 hover:bg-slate-200/50"
                  }`}
                >
                  {t.selector.generalQuestion}
                </button>
              </div>

              {/* Form Header Context */}
              <div className="mb-6">
                <span className="text-[11px] font-bold uppercase tracking-wider text-[var(--blue)] block mb-1">
                  {formType === "project" ? t.selector.projectBadge : t.selector.generalBadge}
                </span>
                <h3 className="text-xl sm:text-2xl font-extrabold text-[var(--ink)] tracking-tight">
                  {formType === "project" ? t.selector.projectHeading : t.selector.generalHeading}
                </h3>
                <p className="mt-1 text-xs sm:text-sm text-slate-500">
                  {formType === "project" ? t.selector.projectSubtitle : t.selector.generalSubtitle}
                </p>
              </div>

              {/* Form Content: Switch between Project Form & General Form */}
              <div
                role="tabpanel"
                id={formType === "project" ? "panel-project" : "panel-general"}
                aria-labelledby={formType === "project" ? "tab-project" : "tab-general"}
              >
                {formType === "project" ? (
                  <ProjectEnquiryForm
                    services={services}
                    dictionary={dictionary}
                    isRtl={isRtl}
                  />
                ) : (
                  <GeneralQuestionForm
                    dictionary={dictionary}
                    isRtl={isRtl}
                  />
                )}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}

/**
 * Technical Consultation / Project Enquiry Form (submits to /api/v1/tc-request)
 */
function ProjectEnquiryForm({
  services,
  dictionary,
  isRtl,
}: {
  services: Service[];
  dictionary: ReturnType<typeof getDictionary>;
  isRtl: boolean;
}) {
  const t = dictionary.contactPage;
  const projectSchema = z.object({
    email: z.string().email("Please enter a valid work email address."),
    service_id: z.string().optional(),
    budget_range: z.string().optional(),
    timeline: z.string().optional(),
    description: z.string().min(10, "Please provide at least 10 characters detailing your project."),
    website_url: z.string().optional(), // Honeypot
  });

  type ProjectFormValues = z.infer<typeof projectSchema>;

  const {
    register,
    handleSubmit,
    reset,
    formState: { errors },
  } = useForm<ProjectFormValues>({
    resolver: zodResolver(projectSchema),
    defaultValues: {
      budget_range: "", // Explicitly unselected default placeholder as requested
      timeline: "",
      service_id: "",
    },
  });

  const [file, setFile] = useState<File | null>(null);
  const [fileError, setFileError] = useState<string>("");
  const [fileKey, setFileKey] = useState(0);
  const [status, setStatus] = useState<"idle" | "loading" | "success" | "error">("idle");
  const [notice, setNotice] = useState("");

  const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const selected = e.target.files?.[0];
    setFileError("");
    if (!selected) {
      setFile(null);
      return;
    }

    // Check size (10MB limit matching backend)
    if (selected.size > 10 * 1024 * 1024) {
      setFileError("File exceeds 10MB limit. Please choose a smaller file.");
      setFile(null);
      return;
    }

    // Check extension
    const ext = selected.name.split(".").pop()?.toLowerCase() || "";
    if (!["pdf", "doc", "docx", "txt"].includes(ext)) {
      setFileError("Invalid format. Accepted: PDF, DOC, DOCX, TXT.");
      setFile(null);
      return;
    }

    setFile(selected);
  };

  const onSubmit = async (values: ProjectFormValues) => {
    setStatus("loading");
    setNotice("");
    const formData = new FormData();
    Object.entries(values).forEach(([key, val]) => {
      if (val !== undefined && val !== null) {
        formData.set(key, val);
      }
    });
    if (file) {
      formData.set("attached_file", file);
    }

    try {
      const response = await submitTcRequest(formData);
      setStatus("success");
      setNotice(response.message || "Your request has been received. Our team will review it shortly.");
      reset();
      setFile(null);
      setFileKey((k) => k + 1);
    } catch {
      setStatus("error");
      setNotice(dictionary.contact.error || "Failed to submit request. Please try again.");
    }
  };

  const inputClass =
    "mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50/60 px-3.5 py-3 text-sm text-[var(--ink)] placeholder:text-slate-400 focus:bg-white focus:border-[var(--blue)] focus:ring-2 focus:ring-blue-100 transition-all outline-none";

  return (
    <form onSubmit={handleSubmit(onSubmit)} className="space-y-4">
      {/* Honeypot */}
      <input type="text" className="hidden" tabIndex={-1} autoComplete="off" {...register("website_url")} />

      {/* Work Email */}
      <FormField
        label={t.fields.email}
        required
        error={errors.email?.message}
      >
        <input
          type="email"
          placeholder={t.fields.emailPlaceholder}
          className={inputClass}
          {...register("email")}
        />
      </FormField>

      {/* Service of Interest */}
      <FormField label={t.fields.service} optional={t.fields.optional}>
        <select className={inputClass} {...register("service_id")}>
          <option value="">{t.fields.selectService}</option>
          {services.map((service) => (
            <option key={service.id} value={service.id}>
              {service.title}
            </option>
          ))}
        </select>
      </FormField>

      {/* Budget & Timeline in 2 columns */}
      <div className="grid gap-4 sm:grid-cols-2">
        <FormField label={t.fields.budget} optional={t.fields.optional}>
          <select className={inputClass} {...register("budget_range")}>
            <option value="">{t.fields.selectBudget}</option>
            <option value="1000">{t.fields.budgetOptions.tier1}</option>
            <option value="5000">{t.fields.budgetOptions.tier2}</option>
            <option value="10000">{t.fields.budgetOptions.tier3}</option>
            <option value="50000">{t.fields.budgetOptions.tier4}</option>
          </select>
        </FormField>

        <FormField label={t.fields.timeline} optional={t.fields.optional}>
          <select className={inputClass} {...register("timeline")}>
            <option value="">{t.fields.selectTimeline}</option>
            <option value="ASAP">{t.fields.timelineOptions.asap}</option>
            <option value="1-3 months">{t.fields.timelineOptions.months1_3}</option>
            <option value="3-6 months">{t.fields.timelineOptions.months3_6}</option>
            <option value="Flexible">{t.fields.timelineOptions.flexible}</option>
          </select>
        </FormField>
      </div>

      {/* Project Details */}
      <FormField
        label={t.fields.projectDetails}
        required
        error={errors.description?.message}
      >
        <textarea
          rows={4}
          placeholder={t.fields.projectDetailsPlaceholder}
          className={inputClass}
          {...register("description")}
        />
      </FormField>

      {/* Attachment */}
      <div>
        <div className="flex items-center justify-between mb-1">
          <label className="text-xs font-bold text-[var(--ink)]">
            {t.fields.attachment}
            <span className="text-slate-400 font-normal text-xs ml-1.5">({t.fields.optional})</span>
          </label>
        </div>
        <p className="text-[11px] text-slate-500 mb-2">{t.fields.attachmentHint}</p>
        <div className="relative">
          <input
            key={fileKey}
            type="file"
            accept=".pdf,.doc,.docx,.txt"
            onChange={handleFileChange}
            className="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[var(--blue)] hover:file:bg-blue-100 cursor-pointer border border-dashed border-slate-300 rounded-xl p-2.5 bg-slate-50/40"
          />
        </div>
        {file && (
          <div className="mt-2 flex items-center justify-between rounded-lg bg-emerald-50 px-3 py-1.5 text-xs text-emerald-800">
            <span className="truncate">📎 {file.name} ({(file.size / 1024 / 1024).toFixed(2)} MB)</span>
            <button
              type="button"
              onClick={() => {
                setFile(null);
                setFileKey((k) => k + 1);
              }}
              className="text-emerald-700 hover:text-emerald-900 font-bold ml-2"
            >
              ✕
            </button>
          </div>
        )}
        {fileError && <p className="mt-1 text-xs text-red-600">{fileError}</p>}
      </div>

      {/* Privacy Notice */}
      <div className="pt-1">
        <p className="text-xs text-slate-500 leading-relaxed">
          {t.privacy.notice}{" "}
          <Link href="/privacy" className="text-[var(--blue)] underline font-medium hover:text-blue-700">
            {t.privacy.linkText}
          </Link>
          .
        </p>
      </div>

      {/* Submit Button */}
      <button
        type="submit"
        disabled={status === "loading"}
        className="button-primary mt-2 w-full py-3.5 rounded-xl font-bold text-sm tracking-wide shadow-sm hover:shadow transition-all disabled:opacity-60 flex items-center justify-center gap-2"
      >
        {status === "loading" ? (
          <>
            <span className="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent" />
            <span>{t.buttons.submitting}</span>
          </>
        ) : (
          <>
            <span>{t.buttons.submitProject}</span>
            <span className={isRtl ? "rotate-180" : ""}>→</span>
          </>
        )}
      </button>

      {/* Response Feedback */}
      {status !== "idle" && (
        <div
          role="alert"
          className={`p-3.5 rounded-xl text-xs sm:text-sm font-medium ${
            status === "success"
              ? "bg-emerald-50 border border-emerald-200 text-emerald-800"
              : "bg-red-50 border border-red-200 text-red-700"
          }`}
        >
          {notice}
        </div>
      )}
    </form>
  );
}

/**
 * General Question / Contact Form (submits to /api/v1/contact)
 */
function GeneralQuestionForm({
  dictionary,
  isRtl,
}: {
  dictionary: ReturnType<typeof getDictionary>;
  isRtl: boolean;
}) {
  const t = dictionary.contactPage;
  const generalSchema = z.object({
    name: z.string().min(2, "Please enter your name."),
    email: z.string().email("Please enter a valid email address."),
    phone: z.string().optional(),
    subject: z.string().optional(),
    message: z.string().min(10, "Please provide at least 10 characters in your message."),
    website_url: z.string().optional(), // Honeypot
  });

  type GeneralFormValues = z.infer<typeof generalSchema>;

  const {
    register,
    handleSubmit,
    reset,
    formState: { errors },
  } = useForm<GeneralFormValues>({
    resolver: zodResolver(generalSchema),
  });

  const [status, setStatus] = useState<"idle" | "loading" | "success" | "error">("idle");
  const [notice, setNotice] = useState("");

  const onSubmit = async (values: GeneralFormValues) => {
    setStatus("loading");
    setNotice("");
    try {
      const response = await submitContact({
        name: values.name,
        email: values.email,
        phone: values.phone || undefined,
        subject: values.subject || "General Inquiry",
        message: values.message,
        website_url: values.website_url,
      });
      setStatus("success");
      setNotice(response.message || "Thank you for contacting us! We will get back to you shortly.");
      reset();
    } catch {
      setStatus("error");
      setNotice(dictionary.contact.error || "Failed to send message. Please try again.");
    }
  };

  const inputClass =
    "mt-1.5 w-full rounded-xl border border-slate-200 bg-slate-50/60 px-3.5 py-3 text-sm text-[var(--ink)] placeholder:text-slate-400 focus:bg-white focus:border-[var(--blue)] focus:ring-2 focus:ring-blue-100 transition-all outline-none";

  return (
    <form onSubmit={handleSubmit(onSubmit)} className="space-y-4">
      {/* Honeypot */}
      <input type="text" className="hidden" tabIndex={-1} autoComplete="off" {...register("website_url")} />

      {/* Name and Email in 2 columns */}
      <div className="grid gap-4 sm:grid-cols-2">
        <FormField label={t.fields.name} required error={errors.name?.message}>
          <input
            type="text"
            placeholder={t.fields.namePlaceholder}
            className={inputClass}
            {...register("name")}
          />
        </FormField>

        <FormField label={t.fields.email} required error={errors.email?.message}>
          <input
            type="email"
            placeholder={t.fields.emailPlaceholder}
            className={inputClass}
            {...register("email")}
          />
        </FormField>
      </div>

      {/* Phone and Subject in 2 columns */}
      <div className="grid gap-4 sm:grid-cols-2">
        <FormField label={t.fields.phone} optional={t.fields.optional}>
          <input
            type="tel"
            placeholder={t.fields.phonePlaceholder}
            className={inputClass}
            {...register("phone")}
          />
        </FormField>

        <FormField label={t.fields.subject} optional={t.fields.optional}>
          <input
            type="text"
            placeholder={t.fields.subjectPlaceholder}
            className={inputClass}
            {...register("subject")}
          />
        </FormField>
      </div>

      {/* Message */}
      <FormField label={t.fields.message} required error={errors.message?.message}>
        <textarea
          rows={5}
          placeholder={t.fields.messagePlaceholder}
          className={inputClass}
          {...register("message")}
        />
      </FormField>

      {/* Privacy Notice */}
      <div className="pt-1">
        <p className="text-xs text-slate-500 leading-relaxed">
          {t.privacy.notice}{" "}
          <Link href="/privacy" className="text-[var(--blue)] underline font-medium hover:text-blue-700">
            {t.privacy.linkText}
          </Link>
          .
        </p>
      </div>

      {/* Submit Button */}
      <button
        type="submit"
        disabled={status === "loading"}
        className="button-primary mt-2 w-full py-3.5 rounded-xl font-bold text-sm tracking-wide shadow-sm hover:shadow transition-all disabled:opacity-60 flex items-center justify-center gap-2"
      >
        {status === "loading" ? (
          <>
            <span className="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent" />
            <span>{t.buttons.submitting}</span>
          </>
        ) : (
          <>
            <span>{t.buttons.submitGeneral}</span>
            <span className={isRtl ? "rotate-180" : ""}>→</span>
          </>
        )}
      </button>

      {/* Response Feedback */}
      {status !== "idle" && (
        <div
          role="alert"
          className={`p-3.5 rounded-xl text-xs sm:text-sm font-medium ${
            status === "success"
              ? "bg-emerald-50 border border-emerald-200 text-emerald-800"
              : "bg-red-50 border border-red-200 text-red-700"
          }`}
        >
          {notice}
        </div>
      )}
    </form>
  );
}

/**
 * Helper Form Field with clear Required / Optional indicators
 */
function FormField({
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
        {required && (
          <span className="text-red-500 font-bold ml-1" title="Required">
            *
          </span>
        )}
        {optional && (
          <span className="text-slate-400 font-normal text-xs ml-1.5">
            ({optional})
          </span>
        )}
      </label>
      {children}
      {error && <p className="mt-1 text-xs text-red-600 font-medium">{error}</p>}
    </div>
  );
}
