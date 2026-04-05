## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.
## 2026-04-05 - Focus Styles and Icon Accessibility
**Learning:** Using standard `focus:` rings on interactive elements like buttons creates sticky focus outlines after a mouse click, which can be visually distracting. Additionally, Material Design icon spans without `aria-hidden="true"` cause redundant screen reader announcements if the parent element already has an `aria-label`.
**Action:** Always prefer Tailwind's `focus-visible:` modifier (e.g., `focus-visible:ring-2`) for keyboard-only focus states, and explicitly hide decorative icon spans using `aria-hidden="true"`.
