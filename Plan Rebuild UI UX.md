# Goal

Replace the entire current public Next.js UI/UX with the reference style while preserving all current Laravel backoffice functionality and extending CMS control where it is currently incomplete.

Do not replace or remove Laravel business logic, admin workflows, authentication, lead handling, comments, subscribers, media, SEO, or APIs unless explicitly listed below.

Target outcome:

```text
Backoffice controls content, visibility, order, media, SEO, navigation, footer,
social links, CTA targets, and approved design options.

Frontend controls layout, responsive behavior, interactions, accessibility,
animation, and safe fallbacks.
```

# Non-negotiable rules

1. Keep all current public routes:

```text
/
 /about
 /services
 /services/[slug]
 /projects
 /projects/[slug]
 /blog
 /blog/[slug]
 /contact
 /privacy
 /terms
```

2. Keep existing API endpoints working. Extend responses additively; do not rename or remove existing response fields.

3. Preserve locale behavior:

```text
en / fr / ar
NEXT_LOCALE cookie
Arabic RTL layout
X-App-Locale and Accept-Language API headers
```

4. Preserve backoffice workflows:

- Services, Projects, Blogs, Sliders, Reviews, Partners
- Contact inbox and reply
- Technical consultation requests and attachments
- Newsletter subscribers
- Comments moderation
- SEO pages
- CMS section visibility and ordering
- Media library, trash, activity logs, users, notifications

5. Do not delete old frontend components until replacement pages pass build, lint, API contract, and responsive checks.

6. Before editing frontend files, read [frontend/AGENTS.md](/home/hamza/Workspace/Master_Projects/Project/Enterprise-Service-Hub-Laravel-/frontend/AGENTS.md) and relevant local Next.js documentation.

# Desired frontoffice structure

```text
Global Header
├── Dynamic logo and brand
├── Dynamic primary navigation
├── Language selector
├── Search
└── Dynamic header CTA

Homepage
├── Hero slider
├── Partner/network strip
├── Services / expertise
├── Selected projects
├── About / technology-partner block
├── Testimonials
├── Blog insights
├── Large CTA
└── Dynamic footer

Internal pages
├── About
├── Services and service details
├── Projects and project details
├── Blog and article details
├── Contact and consultation requests
├── Privacy
└── Terms
```

# Backoffice control matrix

## 1. Global brand and design settings

Create or complete a “Global Website Settings” area.

| Control | Stored in | Public usage |
|---|---|---|
| Site name | `site-info` | Header, footer, metadata |
| Logo | `site-info` | Header/footer |
| Favicon | `site-info` | Next metadata/icon |
| Site description | `site-info` | Metadata/footer |
| SEO keywords | `site-info` | Metadata |
| Default OG image | `site-info` | Metadata fallback |
| Organization JSON-LD | `site-info` | Structured data |
| Primary/accent colors | New theme settings | CSS variables |
| Theme preset | New theme settings | Controlled design variants only |
| Social links | New structured setting | Footer/social metadata |
| Header CTA label and URL | New global-navigation setting | Header |
| Enable/disable chat widget | New global setting | Layout |
| Contact/WhatsApp CTA | New global setting | Header/footer/contact CTA |

Do not allow arbitrary CSS injection. Use controlled fields such as:

```text
primary_color
accent_color
surface_color
header_cta_label
header_cta_url
chat_enabled
```

## 2. Navigation

Add a CMS-managed `global-navigation` section.

Each item should support:

```text
label[en/fr/ar]
url
sort_order
is_active
open_in_new_tab
location: header | footer-company | footer-services
```

Default initial items:

```text
Home
Services
Projects
About
Insights / Blog
Contact
```

The frontend must render only active items in the configured order.

## 3. Footer

Complete the currently incomplete `footer-content` CMS section.

Required fields:

```text
footer_logo
footer_description
copyright_text
newsletter_title
newsletter_description
newsletter_placeholder
social_links[]:
  platform
  url
  label
  icon
footer_legal_links[]:
  label
  url
  sort_order
```

The new footer must not hard-code company links, social URLs, brand text, or copyright copy.

## 4. Hero slider

Continue using Slider records as the primary hero source.

Each slider must support:

```text
badge_text
title
subtitle
description
image
video_url
button_text
button_url
secondary_button_text
secondary_button_url
alignment
overlay_opacity
text_theme
title_color
subtitle_color
description_color
image_alt
sort_order
is_active
```

Frontend behavior:

- Render only active sliders in `sort_order`.
- Use CMS `home-hero` values only as fallback when no active slider exists.
- Support image or video only if `video_url` is valid.
- Respect overlay, alignment, text color/theme, primary and secondary CTA URLs.
- Preserve swipe, keyboard, button, autoplay, and reduced-motion behavior.
- Use descriptive image alt text.

## 5. Homepage content sections

| Section | Backoffice fields required | New UI target |
|---|---|---|
| `home-hero` | Fallback hero copy/image | Hero fallback |
| `home-partners` | Eyebrow, title, subtitle | Partner/network strip |
| `services-list` | Eyebrow, title, subtitle, CTA label/url, selected service IDs/order | Expertise cards |
| `projects-list` | Eyebrow, title, description, CTA label/url, selected project IDs/order | Selected work |
| `home-about` | Eyebrow, title, subtitle, description, image, feature bullets, CTA, stat/highlight | Technology-partner split block |
| `reviews-list` | Eyebrow, title, subtitle, autoplay settings | Testimonials |
| `blog-list` | Eyebrow, title, subtitle, CTA label/url | Insights cards |
| `cta-simple` | Eyebrow, title, subtitle, description, button text, button URL, optional visual variant | Blue final CTA |

Add these `home-about` fields to remove hard-coded UI content:

```text
highlight_value
highlight_suffix
highlight_label
button_text
button_url
features[]:
  icon
  title
  description
```

The current hard-coded “10+ Years,” partner heading, CTA routes, and feature presentation must become dynamic.

## 6. Business records

Do not duplicate these records inside CMS. Use the existing CRUD modules as their source of truth.

| Record | Must drive frontend |
|---|---|
| Services | Expertise cards, service list/detail pages, consultation service selector, search |
| Projects | Selected work, all-projects grid, category filters, project details, search |
| Blogs | Insights cards, listing, article details, comments, search |
| Reviews | Testimonials |
| Partners | Network/partner strip |
| Sliders | Hero |
| Contacts | Admin inbox only |
| TC Requests | Admin lead workflow only |
| Subscribers | Newsletter workflow only |

Clarify “featured” behavior:

- Services: either add a meaningful frontend featured use or remove the field/control.
- Projects: choose one source of truth. Recommended: use `projects-list` selected IDs/order for homepage; remove the separate project featured toggle from public-design logic.
- Reviews: use `is_featured` to select homepage testimonials, or remove it.

# API contract work

Keep `/api/v1` endpoints, but extend them.

## Required endpoint ownership

| Endpoint | Must provide |
|---|---|
| `/home` | Homepage sections, section status/order, hero fallback, selected records, CMS copy |
| `/global` | Brand, theme settings, navigation, footer, socials, global SEO |
| `/about` | About intro, stats, values, history, team, page metadata |
| `/services` | Active services, page header, metadata |
| `/services/{slug}` | Full service and related services |
| `/projects` | Active projects, categories, page header, metadata |
| `/projects/{slug}` | Project and related projects |
| `/blogs` | Published blogs, pagination, page header, metadata |
| `/blogs/{slug}` | Blog, recent posts, comments support |
| `/contact-info` | Contact header, contact intro, address/email/phone/logo, active services |
| `/contact` | Contact submission |
| `/tc-request` | Consultation submission/file upload |
| `/subscribe` | Newsletter signup |
| `/search` | Public active/published search results |
| `/chat` | Chat behavior if enabled |

All API changes must be backward compatible and locale-aware.

# Backend implementation order

## Phase 1 — Audit and contracts

1. Create a written field-to-component map in the repository, for example:

```text
docs/frontoffice-cms-contract.md
```

2. Add feature tests for every endpoint in English, French, and Arabic.
3. Add tests confirming inactive records are never exposed publicly.
4. Add tests confirming CMS section order and `is_active` state are respected.
5. Add tests for global footer/navigation/social response shapes.

## Phase 2 — CMS completion

Update:

- `app/Services/CMSValidationRules.php`
- `app/Services/CMSContentEditor.php`
- `app/Services/CMSPageResolver.php`
- `app/Services/CMSManager.php`
- `app/Http/Controllers/Admin/ContentController.php`
- `resources/views/admin/content/index.blade.php`
- `resources/views/admin/content/edit.blade.php`

Implement CMS editing for:

```text
global-navigation
footer-content
theme-settings
home-partners title/subtitle
home-about highlight and CTA
services-list CTA
projects-list CTA
blog-list CTA
cta-simple button URL and visual variant
contact intro/title/description/logo
```

## Phase 3 — API completion

Update:

- `app/Http/Controllers/Api/V1/GlobalController.php`
- `app/Http/Controllers/Api/V1/HomeController.php`
- `app/Http/Controllers/Api/V1/ContactController.php`
- `app/Http/Controllers/Api/V1/AboutController.php`
- `app/Services/HomePageService.php`
- `app/Http/Resources/*.php`
- `routes/api.php`

Requirements:

- Add global navigation/footer/theme data to `/global`.
- Add all homepage section labels, CTA links, and presentation fields to `/home`.
- Add contact title, description, logo, and header image to `/contact-info`.
- Add alt text and display metadata where required.
- Invalidate appropriate cache entries after every CMS mutation.
- Keep locale in all cache keys.

## Phase 4 — Data migrations and seed data

Create migrations only if new persisted fields are needed.

Likely additions:

```text
sliders.image_alt
sections/settings additions, if used
```

Prefer `content_blocks` for translatable CMS copy and structured JSON arrays for navigation/social links/features.

Update seeders to create valid initial values for:

```text
site-info
global-navigation
footer-content
theme-settings
home-partners
home-about
services-list
projects-list
reviews-list
blog-list
cta-simple
```

## Phase 5 — Admin UX updates

Improve the Content Architect:

- Separate Global Settings, Header/Navigation, Footer, Homepage, Page Content.
- Show whether a section is:
  - Live
  - Hidden
  - Using fallback/default content
  - Empty/incomplete
- Provide a direct public preview link per section.
- Keep existing reorder capability for homepage sections.
- Add previews for footer, header, hero, CTA, and theme colors.
- Use clear labels: “Shown on website,” “Visible in header,” “Featured on homepage.”

# Frontend implementation order

## Phase 6 — Create the new design system

Replace visual styling only after API contracts are ready.

Update:

- `frontend/src/app/globals.css`
- `frontend/src/app/layout.tsx`
- `frontend/src/lib/types.ts`
- `frontend/src/lib/api.ts`

Create reusable components:

```text
components/site/Header.tsx
components/site/Footer.tsx
components/site/Navigation.tsx
components/site/LanguageSwitcher.tsx
components/site/Search.tsx

components/home/Hero.tsx
components/home/PartnerStrip.tsx
components/home/ServicesSection.tsx
components/home/ProjectsSection.tsx
components/home/AboutPartnerSection.tsx
components/home/TestimonialsSection.tsx
components/home/InsightsSection.tsx
components/home/FinalCta.tsx

components/shared/SectionHeading.tsx
components/shared/ArrowLink.tsx
components/shared/ResponsiveImage.tsx
components/shared/RichText.tsx
components/shared/EmptyState.tsx
```

Use the reference image as the visual direction:

```text
Clean white/light content sections
Deep navy hero/testimonial/footer zones
Blue accent tokens
Structured enterprise typography
Grid cards, not glass cards
Controlled animation
Strong image-led project cards
Clear CTA hierarchy
```

## Phase 7 — Build public pages

Replace, then verify:

```text
frontend/src/app/page.tsx
frontend/src/app/about/page.tsx
frontend/src/app/services/page.tsx
frontend/src/app/services/[slug]/page.tsx
frontend/src/app/projects/page.tsx
frontend/src/app/projects/[slug]/page.tsx
frontend/src/app/blog/page.tsx
frontend/src/app/blog/[slug]/page.tsx
frontend/src/app/contact/page.tsx
```

Rules:

- Every visible heading, description, label, CTA, link, logo, image, section status, and ordering must come from CMS/API unless explicitly a dictionary translation.
- Preserve all loading, error, empty, and not-found routes.
- Do not hard-code CMS-driven content.
- Use `next/image`.
- Continue sanitizing trusted rich text before rendering.
- Use accessible button/input/radio elements; no clickable `<div>` controls.
- Respect reduced-motion preference.
- Make RTL layouts intentional, including arrow direction, alignments, margins, navigation, sliders, and project cards.

# Cutover and removal plan

Do not delete the current UI first.

1. Build the new components alongside current ones.
2. Swap route page imports to the new UI.
3. Test every route, locale, screen size, and CMS state.
4. Remove old UI components only after successful verification.
5. Do not remove:
   - API client functions
   - Error/loading states
   - Form submission logic
   - language switcher logic
   - image optimization helpers
   - comment/contact/newsletter/consultation behavior

# Required acceptance criteria

The implementation is complete only when all are true:

- Every CMS field either visibly controls the frontend or is removed from the admin.
- Every frontend dynamic element has a documented backend source.
- No admin control falsely claims to affect the public site.
- Header navigation, footer links, social links, branding, CTA URLs, and SEO are all configurable.
- Homepage respects section visibility and order.
- Homepage works if one or more sections are empty or disabled.
- Hero works with zero, one, and many active sliders.
- Only active services/projects/reviews/partners and published blogs appear publicly.
- Project/service/blog detail pages work for all supported locales.
- Arabic RTL is visually correct.
- Contact, consultation, newsletter, comments, search, and chat retain their current backend behavior.
- `npm run lint` passes with zero errors.
- `npm run build` passes.
- `php artisan test` passes after updating only genuinely outdated expectations for translations and soft deletes.
- API feature tests cover all public endpoints and CMS settings.
- No current admin route is removed without an explicit replacement.

This plan gives the new UI maximum useful backoffice control without making the CMS responsible for raw layout or arbitrary CSS.

# Visual reference implementation brief

The reference image must be attached to the implementation agent's task together with this plan. This image is the visual source of truth for the public frontend; this document is the functional and CMS source of truth.

## Agent instruction

```text
Rebuild the public frontend to closely match the attached reference image.

Visual direction:
- Clean enterprise technology-agency design.
- Deep navy hero, testimonial, CTA, and footer zones.
- White and pale-blue content sections.
- Electric-blue accent color with restrained gradients.
- Compact, editorial typography and strong heading hierarchy.
- Thin borders, structured grids, modest corner radii, and image-led project cards.
- Avoid the current glassmorphism, oversized blur effects, and neon-card aesthetic.

Preserve every backend, CMS, API, locale, SEO, lead-capture, and backoffice behavior specified in this plan.
Do not redesign the Laravel backoffice except where this plan explicitly adds missing CMS controls.
Do not replace dynamic CMS/API content with hard-coded copy.
```

## Required public homepage composition

Match the reference's visual order and hierarchy:

```text
1. Header: logo, navigation, language, search, primary CTA
2. Full-width hero slider with content left and image/media right
3. Partner/network logo strip
4. Services/expertise split layout with service cards
5. Selected-work/project grid
6. About/technology-partner image-and-content block
7. Testimonial band
8. Insights/blog-card section
9. High-impact final CTA band
10. Structured footer with newsletter, navigation, legal, social, and branding
```

Every section above must use the corresponding dynamic source defined in the main plan.

## Visual acceptance criteria

```text
- The desktop homepage follows the reference's section order, visual hierarchy,
  spacing rhythm, color direction, card proportions, typography scale, and CTA placement.
- The implementation is recognizably the same design direction, not a new visual interpretation.
- Tablet and mobile layouts are intentionally redesigned responsively from the desktop reference.
- Arabic RTL preserves the same quality, alignment, and hierarchy.
- Public pages for Services, Projects, Blog, About, and Contact use the same design system.
- No current glassmorphism/blur/neon visual language remains in the replacement UI.
- Before removing old components, capture or inspect desktop and mobile screenshots for:
  homepage, services, projects, blog, about, and contact.
```
