## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.
## 2024-03-07 - Missing ARIA labels on Icon-Only Elements
**Learning:** Found multiple instances where `material-symbols-outlined` span icons were used as the sole content of a `<button>` without an `aria-label` or `sr-only` text, particularly in dynamic UI components like sliders and modals.
**Action:** Always verify that interactive buttons have explicit text or `aria-label`s, and that inner font-icons or SVGs are marked with `aria-hidden="true"` to prevent screen readers from reading raw icon ligature names (e.g. "arrow_forward").
