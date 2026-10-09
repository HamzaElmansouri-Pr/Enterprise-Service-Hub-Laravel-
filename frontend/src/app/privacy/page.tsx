import { Breadcrumb } from "@/components/ui/Breadcrumb";
import type { Metadata } from "next";

export const metadata: Metadata = {
  title: "Privacy Policy",
  description: "Privacy Policy for ELMA Core.",
};

export default function PrivacyPage() {
  return (
    <>
      <Breadcrumb title="Privacy Policy" items={[{ label: "Privacy Policy" }]} />
      
      <section className="section-padding bg-[var(--bg-dark)]">
        <div className="max-w-4xl mx-auto prose prose-invert prose-lg">
          <h2>1. Introduction</h2>
          <p>
            Welcome to ELMA Core. We are committed to protecting your personal information and your right to privacy. 
            If you have any questions or concerns about this privacy notice, or our practices with regards to your personal information, please contact us.
          </p>
          
          <h2>2. Information We Collect</h2>
          <p>
            We collect personal information that you voluntarily provide to us when you register on the website, 
            express an interest in obtaining information about us or our products and Services, when you participate in activities on the Website or otherwise when you contact us.
          </p>

          <h2>3. How We Use Your Information</h2>
          <p>
            We use personal information collected via our Website for a variety of business purposes described below. 
            We process your personal information for these purposes in reliance on our legitimate business interests, 
            in order to enter into or perform a contract with you, with your consent, and/or for compliance with our legal obligations.
          </p>

          <h2>4. Contact Us</h2>
          <p>
            If you have questions or comments about this notice, you may email us at privacy@novaagency.com.
          </p>
        </div>
      </section>
    </>
  );
}
