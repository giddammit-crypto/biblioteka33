## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2024-07-08 - Icon-Only Button Accessibility and UX
**Learning:** Icon-only buttons using Material Symbols require `aria-hidden="true"` on the `span` to prevent screen readers from reading the ligature text. Adding `title` attributes provides native tooltips for mouse users, and `focus-visible` classes ensure keyboard navigation accessibility without introducing sticky mouse focus rings.
**Action:** When adding or modifying icon-only buttons, consistently apply `aria-hidden` to the icon element, use `aria-label` and `title` on the button, and define clear `focus-visible` states using existing theme colors.
