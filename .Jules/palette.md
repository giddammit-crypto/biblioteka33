## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2024-05-23 - Localized Icon Buttons and Focus Rings
**Learning:** Icon-only buttons using localized strings (like Russian) for `aria-label` but literal English text for ligatures (e.g., 'search', 'visibility') in `span.material-symbols-outlined` cause screen readers to mix languages awkwardly if the `span` lacks `aria-hidden="true"`. Also, `focus:` creates sticky focus rings after mouse clicks, whereas `focus-visible:` combined with native `title` attributes provides optimal keyboard-only indications and mouse hover clarity.
**Action:** Always pair `aria-label` with an identical `title` on icon-only buttons for tooltips, use `focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color]` instead of `focus:`, and add `aria-hidden="true"` to the internal material symbol span.
