## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.
## 2024-05-23 - ARIA-hidden on Material Symbols
**Learning:** In the `city-library` theme, icon-only buttons using Material Symbols need `aria-hidden="true"` on the inner `span` and a `title` attribute on the button, in addition to the `aria-label`, to prevent screen readers from reading the ligature text (e.g., "search") redundantly alongside the label, while also providing native tooltips for mouse users.
**Action:** When adding or fixing icon buttons, ensure this exact pattern is followed: `<button aria-label="[label]" title="[label]"><span class="material-symbols-outlined" aria-hidden="true">[icon]</span></button>`
