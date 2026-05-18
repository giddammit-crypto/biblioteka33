## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2026-05-18 - Native Tooltips for Icon-only Buttons
**Learning:** Icon-only buttons with `aria-label` are accessible to screen readers, but sighted mouse users still lack context without a visible tooltip. Furthermore, Material Symbol `span`s are often read out literally by screen readers (e.g., "search", "menu_open") unless hidden.
**Action:** Add `title` attributes to all icon-only buttons to provide a native hover tooltip, and explicitly add `aria-hidden="true"` to the internal Material Symbol `span` elements to prevent redundant screen reader announcements.
