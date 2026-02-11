## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2024-05-23 - High Contrast Mode Aggressiveness
**Learning:** The theme's High Contrast Mode uses `* { background-color: #000000 !important; color: #ffff00 !important; }`, which overrides all element styles including new UI components like toasts.
**Action:** Ensure all new dynamic UI elements (modals, toasts) have sufficiently distinct structure (borders, spacing) or are tested to be readable under this forced styling. For the toast, adding `border` helped visibility against the black background.
