## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2024-05-23 - Material Symbols Screen Reader English Override
**Learning:** In a localized (Russian) application, Material Symbols (e.g., `span.material-symbols-outlined`) read out their literal English ligature text (e.g., "fullscreen" or "attach file") by default, which confuses screen reader users.
**Action:** When adding Material Symbols to icon buttons, ALWAYS include `aria-hidden="true"` on the `span` element, and provide a localized (e.g., Russian) `aria-label` on the parent `<button>`.
