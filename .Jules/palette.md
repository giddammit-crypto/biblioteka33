## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2024-05-24 - Tooltips and Screen Readers on Icon Buttons
**Learning:** While `aria-label` makes icon-only buttons accessible to screen readers, sighted users often rely on hover tooltips to understand ambiguous icons. Adding a `title` attribute that matches the `aria-label` solves this for sighted users. Additionally, when using icon fonts (like Material Symbols), the span containing the icon text (e.g., 'search', 'menu') must have `aria-hidden="true"` to prevent screen readers from reading the icon's ligature text immediately after reading the button's `aria-label`.
**Action:** Always pair `title` and `aria-label` on icon-only buttons, and explicitly hide the inner icon span with `aria-hidden="true"`.
