## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2024-10-26 - Keyboard Navigation Breaking
**Learning:** Using `focus:outline-none` without providing alternative focus styles breaks keyboard navigation, making the element inaccessible for users relying on keyboards to navigate.
**Action:** Always pair `focus:outline-none` with visual alternatives like `focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-primary/50` to maintain focus indicators for keyboard users while still avoiding the default outline for mouse users.
