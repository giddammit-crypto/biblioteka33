## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2024-05-18 - [Accessible Search Modal]
**Learning:** Custom modal containers (like `search-modal.php`) require `role="dialog"`, `aria-modal="true"`, and an `aria-labelledby` attribute linked to the modal's title heading to be properly announced by screen readers. Furthermore, `focus-visible:` is preferable to `focus:` on interactive elements like close buttons to prevent sticky focus rings after mouse interactions while preserving keyboard accessibility.
**Action:** Always apply these ARIA attributes when implementing or modifying custom modal dialogs, and default to `focus-visible:` for interactive element focus states.
