# Natajiwa Village — WordPress Rebuild & Deployment Guide

This package rebuilds the Natajiwa Village website in WordPress with the new
Scott Resort–inspired design, using **free plugins only**. It is designed to
**replace the old WordPress site** on your Hostinger hosting.

> **What you're installing:** a *child theme* of **Hello Elementor** (both free)
> that carries the whole design system — the fonts, colours, curtain-drop hero,
> scroll reveals, image-wipes, per-letter buttons and mobile menu — plus ready
> content for four pages: **Home, Rooms, Gallery, Contact**.

---

## 0. What's in this folder

```
wordpress/
├─ natajiwa-child/            ← the theme (this is what you upload/zip)
│  ├─ style.css
│  ├─ functions.php
│  ├─ header.php              ← Natajiwa nav + mobile menu
│  ├─ footer.php              ← Natajiwa footer
│  ├─ template-fullwidth.php  ← "Natajiwa Full Width" page template
│  └─ assets/
│     ├─ css/scott.css        ← the design system
│     ├─ js/scott.js          ← the motion (reveals, image-wipe, menu)
│     └─ img/                 ← all site images (bundled)
├─ page-content/              ← paste-in HTML for each page
│  ├─ home.html  rooms.html  gallery.html  contact.html
├─ templates-elementor/       ← optional: import into Elementor instead
│  ├─ home.json  rooms.json  gallery.json  contact.json
└─ NATAJIWA-WORDPRESS-GUIDE.md (this file)
```

You can build the pages **two ways** — pick one:

- **Method A (simplest, recommended):** paste the `page-content/*.html` into each
  page using the WordPress **Custom HTML block** + the *Natajiwa Full Width*
  template. No Elementor needed for these pages.
- **Method B (Elementor):** import `templates-elementor/*.json` into Elementor.

---

## 1. Free plugins to install

From **Plugins → Add New**, install & activate:

| Plugin | Why | Cost |
|---|---|---|
| **Hello Elementor** (Theme) | Parent theme our child extends | Free |
| **Elementor** | Page builder (only needed for Method B) | Free |
| **WPForms Lite** *or* **Fluent Forms** | Real contact form that emails you | Free |
| **All-in-One WP Migration** | Backup/restore the site | Free |

> The old site's stack (Happy Addons, Jeg Kit, Envato Elements, MetForm,
> Omnisend, LiteSpeed, Yoast) is **not required** by this design. Keep only
> what you actually use. **Yoast SEO** (free) and **LiteSpeed Cache** (free,
> Hostinger-friendly) are nice to keep.

---

## 2. ⚠️ Back up the OLD site first

Before replacing anything:

1. **Plugins → All-in-One WP Migration → Export → Export to File.**
2. Download the `.wpress` file and keep it safe. This is your rollback.
3. (Optional) In Hostinger **hPanel → Files → Backups**, create a manual backup.

---

## 3. Install the new theme

1. On your computer, **zip the `natajiwa-child` folder** so you get
   `natajiwa-child.zip` (the zip must contain `style.css` at its top level).
   *(A ready-made `natajiwa-child.zip` is included in this package — you can
   upload that directly.)*
2. WordPress **Appearance → Themes → Add New → Upload Theme** → choose the zip
   → **Install**.
3. Make sure **Hello Elementor** is also installed (Add New → search
   "Hello Elementor" → Install). You don't need to activate Hello Elementor —
   just have it present as the parent.
4. **Activate "Natajiwa Village".**

*(Hostinger alternative: hPanel → Files → File Manager → upload & extract the
zip into `/public_html/wp-content/themes/`, then activate in WordPress.)*

---

## 4. Set permalinks (important)

**Settings → Permalinks → select "Post name" → Save.**
This makes `/rooms/`, `/gallery/`, `/contact/` work (the nav links depend on it).

---

## 5. Create the four pages

For **each** page below, do: **Pages → Add New**, set the **Title**, set the
**URL slug** exactly as shown, choose the template, add the content, **Publish.**

| Page title | Slug (Permalink) |
|---|---|
| Home | `home` (or leave as front page, see step 6) |
| Rooms | `rooms` |
| Gallery | `gallery` |
| Contact | `contact` |

### Method A — paste HTML (recommended)

1. In the page editor, open **Page → Template → "Natajiwa Full Width"**
   (right sidebar, "Template" dropdown).
2. Click **+ → Custom HTML** block.
3. Open the matching file in `page-content/` (e.g. `rooms.html`), copy **all**
   of it, and paste into the Custom HTML block.
4. **Publish.**

### Method B — import into Elementor

1. **Templates → Saved Templates → Import Templates** → upload the matching
   `templates-elementor/*.json`.
2. Create/edit the page, click **Edit with Elementor**, then **folder icon
   (Add Template) → My Templates →** insert the imported one.
3. Set the Elementor page layout to **Canvas** or **Full Width** so the theme
   header/footer show correctly, then **Update**.

> Images are already bundled in the theme, so both methods show photos
> immediately — no Media Library uploads needed.

---

## 6. Make Home the front page

**Settings → Reading → "Your homepage displays" → A static page → Homepage:
Home.** Save.

---

## 7. Wire up the contact form (real emails)

The Contact page ships with a styled **demo** form (it shows a thank-you note
but does not send email yet). Replace it with a real free form:

1. **WPForms → Add New → Simple Contact Form.** Add a "Dates of stay" field if
   you like. Under **Settings → Notifications**, set the send-to address to
   `natajiwavilla@gmail.com`. **Save & Embed → copy the shortcode**
   (e.g. `[wpforms id="123"]`).
2. Edit the **Contact** page. In the `page-content/contact.html` you pasted,
   find the `<form ...> ... </form>` block (inside `<div class="form-card">`)
   and replace the whole `<form>…</form>` with the WPForms shortcode.
   *(Keep the surrounding `<div class="form-card">` wrapper so it keeps the
   styled card look — or remove it if WPForms styling is enough.)*
3. On Hostinger, outgoing mail is more reliable with an SMTP plugin
   (**FluentSMTP**, free) pointed at your Gmail/Google Workspace.

---

## 8. Finishing touches (edit these placeholders)

Search the pasted content / theme files and update:

- **WhatsApp number** — currently `6281000000000`. Replace in
  `header.php`, `footer.php`, and `page-content/contact.html`
  (`https://wa.me/…`). Use full international format, no `+` or spaces.
- **Room rates** — Rooms page shows *"Rates on request"*. Put real nightly
  rates in `page-content/rooms.html` if you want them public.
- **Instagram link** — the Contact "Follow" row and Home "Connect" tiles link
  to `#`; point them at your real Instagram URL.
- **Map** — the Contact map is centred on Kerobokan; to pin the exact spot,
  open Google Maps → Share → Embed a map → copy the `src` and replace the one
  in `contact.html`.
- **Logo** — bundled at `assets/img/natajiwa-logo-768.webp`. To use WordPress'
  logo feature instead, **Appearance → Customize → Site Identity**.

---

## 9. Replace the OLD site cleanly

Once the new pages look right:

1. **Menus:** Appearance → Menus — the theme header uses fixed links, so you
   don't strictly need a WP menu. If old menus exist, they won't show.
2. **Delete/unpublish old pages** left over from the previous design so they
   don't appear in search or sitemaps.
3. **Deactivate & delete unused old plugins** (Happy Addons, Jeg Kit, MetForm,
   Envato Elements, Omnisend) to speed up the site — only if nothing else uses
   them.
4. **Cache:** if using LiteSpeed Cache, **Purge All** after go-live.
5. **SEO:** in Yoast, check the homepage title/description; submit the sitemap
   in Google Search Console.

### Rollback
If anything goes wrong: **All-in-One WP Migration → Import** the `.wpress`
backup from step 2, or restore the Hostinger backup.

---

## 10. Keeping design and code in sync

The design system in this theme (`assets/css/scott.css`, `assets/js/scott.js`)
is the **same** file that drives the static prototype in the repo's `redesign/`
folder. If we refine the design later, those two files update together and you
re-upload the theme (or just the changed file via File Manager).

---

*Questions or a tweak to the design? The static prototype at `/redesign/` is the
fastest place to preview changes before they go into WordPress.*
