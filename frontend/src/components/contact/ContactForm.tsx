"use client";

import { useState } from "react";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import * as z from "zod";
import { submitContact } from "@/lib/api";
import { getDictionary } from "@/lib/dictionary";

export function ContactForm({ locale = "en" }: { locale?: string }) {
  const t = getDictionary(locale).contact;
  const schema = z.object({ name: z.string().min(2, "Please enter your name."), email: z.string().email("Please enter a valid email."), phone: z.string().optional(), subject: z.string().min(2, "Please enter a subject."), message: z.string().min(10, "Please add a little more detail."), website_url: z.string().optional() });
  type Values = z.infer<typeof schema>;
  const { register, handleSubmit, reset, formState: { errors } } = useForm<Values>({ resolver: zodResolver(schema) });
  const [status, setStatus] = useState<"idle" | "loading" | "success" | "error">("idle"); const [notice, setNotice] = useState("");
  async function onSubmit(values: Values) { setStatus("loading"); try { const result = await submitContact(values); setStatus("success"); setNotice(result.message); reset(); } catch { setStatus("error"); setNotice(t.error); } }
  const input = "mt-1.5 w-full border border-slate-300 bg-white px-3 py-3 text-sm text-[var(--ink)] outline-none transition placeholder:text-slate-400 focus:border-[var(--blue)]";
  return <form onSubmit={handleSubmit(onSubmit)} className="content-card p-6 sm:p-8"><input type="text" className="hidden" tabIndex={-1} autoComplete="off" {...register("website_url")} /><div className="grid gap-4 sm:grid-cols-2"><Field label={t.name} error={errors.name?.message}><input className={input} {...register("name")} /></Field><Field label={t.email} error={errors.email?.message}><input type="email" className={input} {...register("email")} /></Field><Field label={t.phone}><input className={input} {...register("phone")} /></Field><Field label={t.subject} error={errors.subject?.message}><input className={input} {...register("subject")} /></Field></div><Field label={t.message} error={errors.message?.message}><textarea rows={5} className={input} {...register("message")} /></Field><button disabled={status === "loading"} className="button-primary mt-5 w-full disabled:opacity-60">{status === "loading" ? t.sending : t.send} →</button>{status !== "idle" && <p aria-live="polite" className={`mt-4 text-sm ${status === "success" ? "text-emerald-700" : "text-red-600"}`}>{notice}</p>}</form>;
}
function Field({ label, error, children }: { label: string; error?: string; children: React.ReactNode }) { return <label className="mt-4 block text-sm font-bold text-[var(--ink)]">{label}{children}{error && <span className="mt-1 block text-xs text-red-600">{error}</span>}</label>; }
