## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.
## 2024-05-23 - Search Modal Accessibility
**Learning:** For custom modal dialogs in the `city-library` theme, applying ARIA `role="dialog"` alongside standard Focus styling is essential for proper screen reader announcement, as demonstrated on the full-screen search modal. The `focus:` utility classes should be replaced with `focus-visible:` to ensure that a visible focus ring is provided for keyboard navigation, but avoids persisting if the user interacts using a mouse.
**Action:** When implementing new custom UI popups or full-page takeovers, ensure the container includes `role="dialog"`, `aria-modal="true"`, and `aria-labelledby`, and explicitly use `focus-visible:` for interactive elements inside.
