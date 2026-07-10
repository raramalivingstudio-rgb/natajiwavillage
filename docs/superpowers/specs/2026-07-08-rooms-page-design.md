# Rooms Page — Design Spec

**Date:** 2026-07-08
**Project:** Rarama Teba Villa (local clone, served at `localhost:3006`)
**Status:** Approved (user approved all 3 design sections)

---

## Goal

Create a dedicated `/rooms.html` page that displays the guesthouse's 2 room types (Deluxe Room and Junior Suite) in full detail. Each room gets its own section with photo slider, features, description, and a WhatsApp button to start a reservation conversation. No booking form, no payment — purely informational, with reservation handled via WhatsApp.

---

## Architecture & Routing

### File changes

| File | Change |
|---|---|
| `rooms.html` | **NEW.** Standalone HTML page, served at `/rooms.html` automatically. |
| `index.html` | Update nav: change `Room` link from `#menu` → `/rooms.html` (line 2132). |

### Why a standalone HTML file

`server.js` line 10 already runs `app.use(express.static(ROOT))`. This middleware auto-serves any file in the project root at its filename URL. So placing `rooms.html` in the project root makes it accessible at `/rooms.html` with zero server changes.

### What gets reused vs. duplicated

| Asset | Approach |
|---|---|
| `<head>` (Bootstrap, Font Awesome, Swiper, custom CSS, site CSS vars) | **Copy from `index.html`** into `rooms.html`. YAGNI for a templating engine — only 2 pages. |
| Header + nav | **Copy** with `active` class on the Room link. |
| Footer | **Copy** as-is. |
| Gallery lightbox (CSS + HTML + JS) | **Copy** the lightbox block into `rooms.html`. Script is scoped via `.gallery-grid`, so it won't interfere with Swiper or other elements. |

---

## Page Anatomy

1. `<head>` — copied from `index.html`
2. Header + nav — copied, with Room link marked active
3. **Hero banner** — page title "Our Comfort Rooms" + tagline
4. **Room 1 section** — Deluxe Room (image-left, content-right)
5. **Room 2 section** — Junior Suite (content-left, image-right)
6. Footer — copied
7. Lightbox block — copied (for room photo click-to-enlarge)

---

## Per-Room Layout

### Deluxe Room (image-left)

```
+-----------------------------+-----------------------------+
|  Swiper (col-md-7)          |  Content (col-md-5)         |
|  6 photos, loop             |  Title, features,           |
|                             |  description, WA button     |
+-----------------------------+-----------------------------+
```

### Junior Suite (content-left)

```
+-----------------------------+-----------------------------+
|  Content (col-md-5)         |  Swiper (col-md-7)          |
|  Title, features,           |  5 photos, loop             |
|  description, WA button     |                             |
+-----------------------------+-----------------------------+
```

### Per-room content

| Field | Deluxe Room | Junior Suite |
|---|---|---|
| Title | Deluxe Room with Pool View | Junior Suite with Pool View |
| Bed | 1 Double Bed | 1 King Bed |
| Pool | Outdoor Pool | Outdoor Pool |
| Guests | 2 Guest | 2 Guest |
| Description | (copy from `index.html` line 3382) | (copy from `index.html` line 3408) |
| Photos | 6 images | 5 images |
| WhatsApp msg | `Halo, saya tertarik memesan Deluxe Room di Rarama Teba Villa` | `Halo, saya tertarik memesan Junior Suite di Rarama Teba Villa` |

### Image sources

Reuse the existing `https://raramalivingstudio.com/wp-content/uploads/...` URLs already in `index.html`. Mixing sources (some local `assets/img/gallery/`, some hosted on WP) would create inconsistency — sticking with WP URLs for room photos keeps the home page and rooms page visually aligned.

---

## WhatsApp Integration

### URLs

```
Deluxe Room:
https://api.whatsapp.com/send?phone=6282341985030&text=Halo%2C%20saya%20tertarik%20memesan%20Deluxe%20Room%20di%20Rarama%20Teba%20Villa

Junior Suite:
https://api.whatsapp.com/send?phone=6282341985030&text=Halo%2C%20saya%20tertarik%20memesan%20Junior%20Suite%20di%20Rarama%20Teba%20Villa
```

- Number `6282341985030` (without `+`) is from the footer (line 5284).
- Spaces → `%20`, commas → `%2C` (URL encoding).
- `target="_blank"` opens in new tab.
- Each button is `<a class="btn btn-whatsapp">` so the styling can target it specifically.

### Button styling

- Background: `var(--colors)` (#005232, the brand green)
- Text: white
- Icon: Font Awesome `fa-whatsapp` before the label "Book via WhatsApp"
- Hover: same as site `.btn:hover` patterns (subtle lift)
- Full-width on mobile, auto-width on desktop

---

## Hero Section

```html
<section class="page-hero">
  <h1>Our Comfort Rooms</h1>
  <p>Find your perfect stay at Rarama Teba Villa</p>
</section>
```

- Height: ~280px on desktop, ~200px on mobile
- Background: `https://raramalivingstudio.com/wp-content/uploads/2024/02/bed-view-pool-deluxe-rarama-768x543.jpg` set as `background-image` with a dark overlay (`rgba(0,0,0,0.45)`) for text legibility
- Title centered, white text
- 6rem of breathing room below the hero before the first room section

---

## Mobile Behavior

- On screens narrower than `md` (768px), both columns stack vertically (image on top, content below) — natural Bootstrap behavior with `col-md-*`
- Hero shrinks to 200px height
- WhatsApp buttons become full-width
- Swiper remains functional (Swiper has its own touch handling)

---

## Implementation Sequence

1. Create `rooms.html` skeleton with copied `<head>`.
2. Copy header/nav, mark Room link active.
3. Add hero section.
4. Add Deluxe Room section (image-left, content-right).
5. Add Junior Suite section (content-left, image-right).
6. Copy footer.
7. Copy lightbox block to bottom of page.
8. Update `index.html` nav: change `Room` link to `/rooms.html`.
9. Verify by loading `http://localhost:3006/rooms.html` in browser.

---

## Out of Scope (YAGNI)

- Booking form / date picker — user explicitly chose "informasi saja, arahkan reservasi ke nomor WhatsApp"
- Room detail sub-pages — each room lives on this single page
- Image optimization / lazy loading — defer until performance becomes an issue
- Server-side templating — duplicate markup is acceptable for 2 pages
- Database / CMS integration — content is hardcoded HTML

---

## Verification Checklist

- [ ] `http://localhost:3006/rooms.html` loads without 404
- [ ] Both rooms display with correct photos in sliders
- [ ] Each WhatsApp button opens `wa.me/...` with correct pre-filled message
- [ ] Nav Room link from `index.html` now navigates to `/rooms.html`
- [ ] Mobile layout: columns stack, hero shrinks, buttons full-width
- [ ] Page reuses site's brand colors and typography (no orphan styles)
- [ ] Lightbox works on room photos (click → enlarge)