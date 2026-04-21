## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2024-05-23 - Modal Dialog Accessibility & Keyboard Focus
**Learning:** Custom modally-positioned elements (like the site search modal) must use standard ARIA dialog attributes (`role="dialog"`, `aria-modal="true"`, and `aria-labelledby`) connected to an ID on the title element to ensure screen readers trap reading within the modal context appropriately. Furthermore, interactive elements within these custom templates need `focus-visible:` utilities over `focus:` to provide clear visual feedback for keyboard users without creating sticky outlines for mouse clicks.
**Action:** When creating or maintaining custom overlays/modals in the theme, always define the dialog role and an accessible name. Apply `focus-visible:` classes to inputs and buttons within them.
