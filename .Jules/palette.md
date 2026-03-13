## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2024-05-22 - Non-Disruptive Screen Reader Announcements
**Learning:** Using `alert()` to announce state changes (like toggling accessibility modes) provides poor UX as it blocks the main thread and requires interaction. It's especially disruptive for sighted users who don't need the audible confirmation.
**Action:** Always use an `aria-live="polite"` region (visually hidden with utility classes like `.sr-only`) to update text content for screen readers without interrupting the visual experience.
