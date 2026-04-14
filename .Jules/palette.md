## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2024-05-22 - Search Modal Accessibility Upgrade
**Learning:** Even custom-built modal containers require standard ARIA dialog attributes (`role="dialog"`, `aria-modal="true"`, `aria-labelledby`) to ensure screen readers appropriately identify them as modals and focus users inside them. Additionally, icon-only buttons with tooltips benefit from matching `aria-label` and `title` attributes.
**Action:** When building or auditing custom modals, always verify standard dialog attributes are present.
