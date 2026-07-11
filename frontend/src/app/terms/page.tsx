import { Breadcrumb } from "@/components/ui/Breadcrumb";
import type { Metadata } from "next";

export const metadata: Metadata = {
  title: "Terms of Service",
  description: "Terms of Service for Nova Agency.",
};

export default function TermsPage() {
  return (
    <>
      <Breadcrumb title="Terms of Service" items={[{ label: "Terms of Service" }]} />
      
      <section className="section-padding bg-[var(--bg-dark)]">
        <div className="max-w-4xl mx-auto prose prose-invert prose-lg">
          <h2>1. Agreement to Terms</h2>
          <p>
            These Terms of Service constitute a legally binding agreement made between you, whether personally or on behalf of an entity ("you") and Nova Agency ("Company," "we," "us," or "our"), concerning your access to and use of the website as well as any other media form, media channel, mobile website or mobile application related, linked, or otherwise connected thereto.
          </p>
          
          <h2>2. Intellectual Property Rights</h2>
          <p>
            Unless otherwise indicated, the Site is our proprietary property and all source code, databases, functionality, software, website designs, audio, video, text, photographs, and graphics on the Site (collectively, the "Content") and the trademarks, service marks, and logos contained therein (the "Marks") are owned or controlled by us or licensed to us.
          </p>

          <h2>3. User Representations</h2>
          <p>
            By using the Site, you represent and warrant that: (1) all registration information you submit will be true, accurate, current, and complete; (2) you will maintain the accuracy of such information and promptly update such registration information as necessary.
          </p>

          <h2>4. Contact Us</h2>
          <p>
            In order to resolve a complaint regarding the Site or to receive further information regarding use of the Site, please contact us at: terms@novaagency.com.
          </p>
        </div>
      </section>
    </>
  );
}
