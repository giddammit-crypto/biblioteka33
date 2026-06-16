## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2024-06-16 - Material Symbols Ligature Text and Screen Readers
**Learning:** In the Russian localized UI of the `city-library` theme, Material Symbols use English ligature text (e.g., `search`, `visibility`). If not hidden, screen readers will announce this English text, creating a confusing and redundant experience alongside existing `aria-label` attributes.
**Action:** Always add `aria-hidden="true"` to `<span class="material-symbols-outlined">` elements when they are used within interactive elements that already have an `aria-label` or visible text. Ensure icon-only buttons include both `aria-label` for screen readers and `title` for mouse hover tooltips.
