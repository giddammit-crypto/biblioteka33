## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.
## 2024-06-25 - Focus-Visible Modal and Button Accessibility
**Learning:** In the `city-library` theme, using `focus:ring-2` on buttons like the modal close or mobile menu toggle results in a "sticky" ring after mouse clicks, degrading mouse UX. Additionally, `search-modal` lacked semantic `dialog` roles making screen readers unaware of its modal context, and icon-only buttons relied solely on `aria-label` which left sighted mouse users without native tooltip context.
**Action:** Always prefer `focus-visible:` pseudo-classes (e.g., `focus-visible:ring-primary/50`) over `focus:` for interactive buttons to preserve clean mouse UX. For modals, always construct with `role="dialog"`, `aria-modal="true"`, and connect an `aria-labelledby` to the title ID. Finally, ensure all icon-only buttons with an `aria-label` also include a matching `title` attribute for tooltip visibility.
