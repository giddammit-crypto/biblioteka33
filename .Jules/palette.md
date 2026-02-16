## 2025-05-19 - Hero Scroll Indicator Interaction
**Learning:** Users often perceive bouncing arrow icons in hero sections as clickable buttons, even if they are purely decorative.
**Action:** When implementing scroll indicators, always wrap them in an `<a>` tag with an `href` targeting the content section immediately following the hero. Use `aria-label` for accessibility and ensure the target element has `scroll-margin-top` (e.g., `scroll-mt-24`) if a sticky header is present to prevent content occlusion.
