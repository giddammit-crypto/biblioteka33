## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.
## 2024-03-28 - Hide decorative icons inside aria-labeled buttons
**Learning:** When using font icons (like Material Symbols via span) inside an icon-only button, if the button itself already has a descriptive `aria-label`, the internal span must have `aria-hidden="true"`. Otherwise, screen readers may read both the aria-label and the literal text of the icon ligature (e.g., "search", "close"), resulting in redundant and confusing output like "Search search button".
**Action:** Always verify that decorative icon spans have `aria-hidden="true"` when their container provides the necessary accessibility context.
