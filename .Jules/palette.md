## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2024-05-24 - Custom Modal Accessibility
**Learning:** Custom modal dialogs lack native accessibility semantics, requiring explicit `role="dialog"`, `aria-modal="true"`, and an `aria-labelledby` referencing the title to ensure proper screen reader behavior. Additionally, using `focus:` on close buttons creates sticky focus rings after mouse clicks, degrading the visual experience.
**Action:** Always apply `role="dialog"`, `aria-modal="true"`, and `aria-labelledby` to custom modal containers. Use `focus-visible:` instead of `focus:` for focus rings on interactive elements to provide clear keyboard focus without lingering mouse artifacts.
