## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2026-05-19 - Icon-Only Button Best Practices
**Learning:** When using Material Symbols for icon-only buttons, having an `aria-label` on the button handles screen readers, but mouse users lack context without a `title` attribute, and nested `<span class="material-symbols-outlined">` elements still get read by some screen readers if they lack `aria-hidden="true"`. Additionally, `focus-visible` utility classes provide essential keyboard navigation feedback without sticky styling.
**Action:** For all future icon-only buttons, ensure the pattern includes: an `aria-label` and matching `title` on the button, `focus-visible` utility classes for focus states, and `aria-hidden="true"` on the inner icon `span` element.
