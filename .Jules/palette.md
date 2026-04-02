## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.
## 2024-05-23 - ARIA labels for Icon-only Buttons
**Learning:** Icon-only buttons using ligature icon fonts like Material Symbols require careful accessibility treatment. Without `aria-label` on the button and `aria-hidden="true"` on the icon itself, screen readers will read the ligature text (e.g., "support_agent") instead of the button's action.
**Action:** Always ensure icon-only buttons have descriptive `aria-label` attributes and that the inner icon element (e.g., `<span class="material-symbols-outlined">`) has `aria-hidden="true"`.
