## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2024-06-25 - Prevent Redundant Screen Reader Output on Material Symbols
**Learning:** For icon-only buttons using Material Symbols (`span.material-symbols-outlined`), screen readers may literally announce the ligature text (e.g., "menu open", "fullscreen") in English, causing confusion for users of a localized application. Additionally, mixed icon-and-text buttons might redundantly announce the ligature text alongside the visible text.
**Action:** Always provide explicit `aria-label` attributes for icon-only buttons, and crucially, apply `aria-hidden="true"` to the inner `span.material-symbols-outlined` element to prevent the ligature text from being announced by screen readers.
