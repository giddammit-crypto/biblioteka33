## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2025-02-12 - Material Symbols and Icon-Only Button Tooltips
**Learning:** For icon-only buttons using Material Symbols, the inner `<span class="material-symbols-outlined">` must have `aria-hidden="true"` to prevent screen readers from reading the literal English ligature text (e.g., "search", "menu") in localized apps (like Russian). Additionally, native tooltips (`title` attribute matching the `aria-label`) are needed to provide visual clarity for sighted users alongside screen reader accessibility. Finally, `focus-visible` with a clear ring styling (e.g., `focus-visible:outline-none focus-visible:ring-2`) is required for proper keyboard navigation accessibility without causing sticky hover states for mouse users.
**Action:** Always include `aria-hidden="true"` on Material Symbols inside buttons that have an `aria-label`, duplicate the `aria-label` text to the `title` attribute for icon-only buttons, and use Tailwind's `focus-visible` to ensure clear keyboard focus rings.
