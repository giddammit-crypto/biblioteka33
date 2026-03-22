## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.
## 2024-05-17 - Missing Focus Indicators on Mobile Bottom Navigation

**Learning:** When using full-height flex items (`h-full`) inside a grid layout (like the bottom mobile navigation), relying on default browser outlines often results in invisible or severely clipped focus states due to the `overflow-hidden` or tight container bounds of the sticky/fixed nav bar. Additionally, elements that are strictly designed for tap/touch interactions (like mobile nav tabs) are frequently overlooked for keyboard accessibility.
**Action:** Always pair `focus:outline-none` with explicit `focus-visible:ring-*` classes (e.g., `focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-primary/50`) on interactive elements within tight grids or sticky containers to ensure the focus indicator renders inward and remains visible without breaking the layout.
