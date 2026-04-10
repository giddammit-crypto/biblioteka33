## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2026-04-10 - Icon-Only Button Accessibility Pattern
**Learning:** Found multiple instances of icon-only buttons (using Material Symbols) in the Virtual Librarian chat interface lacking descriptive `aria-label`s, rendering them opaque to screen readers.
**Action:** When implementing or modifying icon-only buttons, always ensure an `aria-label` is present and add `aria-hidden="true"` to the inner decorative icon span to prevent redundant or confusing screen reader announcements.
