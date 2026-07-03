## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2024-07-03 - Search Modal Accessibility & UX
**Learning:** For custom modals (like search), using `focus:` pseudo-classes on buttons often results in a "sticky" focus ring after a mouse click, degrading the visual experience. Screen readers also needlessly announce literal icon text (e.g., "close") if the span isn't explicitly hidden, even when the parent button has a proper `aria-label`.
**Action:** When styling interactive elements, default to Tailwind's `focus-visible:` pseudo-class (e.g., `focus-visible:outline-none focus-visible:ring-2`) to provide clear focus rings for keyboard navigation while avoiding them for mouse users. Always add `aria-hidden="true"` to Material Symbol spans inside buttons that already have an `aria-label`. Ensure custom modal containers have `role="dialog"`, `aria-modal="true"`, and an `aria-labelledby` linking to their heading ID.
