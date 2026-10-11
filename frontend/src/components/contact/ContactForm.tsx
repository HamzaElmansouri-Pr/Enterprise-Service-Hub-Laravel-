"use client";

import { useState } from "react";
import Link from "next/link";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import * as z from "zod";
import { submitContact } from "@/lib/api";
import { getDictionary } from "@/lib/dictionary";

const schema = z.object({
  name: z.string().min(2, "Please enter your name."),
  email: z.string().email("Please enter a valid work email."),
  phone: z.string().optional(),
  subject: z.string().optional(),
  message: z.string().min(10, "Please provide at least 10 characters in your message."),
  website_url: z.string().optional(),
});

type Values = z.infer<typeof schema>;

export function ContactForm({ locale = "en" }: { locale?: string }) {
  const dictionary = getDictionary(locale);
  const t = dictionary.contactPage;
  const isRtl = locale === "ar";

  const {
    register,
    handleSubmit,
    reset,
    formState: { errors },
  } = useForm<Values>({
    resolver: zodResolver(schema),
  });

  const [status, setStatus] = useState<"idle" | "loading" | "success" | "error">("idle");
  const [notice, setNotice] = useState("");

  async function onSubmit(values: Values) {
    setStatus("loading");
    setNotice("");
    try {
      const result = await submitContact({
        name: values.name,
        email: values.email,
        phone: values.phone || undefined,
        subject: values.subject || "General Inquiry",
        message: values.message,
        website_url: values.website_url,
      });
      setStatus("success");
      setNotice(result.message || "Thank you for contacting us!");
      reset();
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
      
      <div className="grid gap-4 sm:grid-cols-2">
        <Field label={t.fields.name} required error={errors.name?.message}>
          <input className={input} placeholder={t.fields.namePlaceholder} {...register("name")} />
        </Field>
        <Field label={t.fields.email} required error={errors.email?.message}>
          <input type="email" className={input} placeholder={t.fields.emailPlaceholder} {...register("email")} />
        </Field>
      </div>

      <div className="grid gap-4 sm:grid-cols-2">
        <Field label={t.fields.phone} optional={t.fields.optional}>
          <input className={input} placeholder={t.fields.phonePlaceholder} {...register("phone")} />
        </Field>
        <Field label={t.fields.subject} optional={t.fields.optional}>
          <input className={input} placeholder={t.fields.subjectPlaceholder} {...register("subject")} />
        </Field>
      </div>

      <Field label={t.fields.message} required error={errors.message?.message}>
        <textarea rows={5} className={input} placeholder={t.fields.messagePlaceholder} {...register("message")} />
      </Field>

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
            <span>{t.buttons.submitGeneral}</span>
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

function Field({
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
