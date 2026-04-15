## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.
## 2026-04-15 - [A11y/UX] Enhanced icon-only header buttons
**Learning:** Screen readers redundantly read the literal text content of Material Symbols (e.g., 'search', 'visibility') in icon-only buttons if they lack `aria-hidden="true"`, confusing the user alongside the button's `aria-label`. Additionally, lacking `title` attributes on these buttons deprives sighted users of native tooltips to clarify the icon's function.
**Action:** Always verify that icon-only buttons combining an `aria-label` with an icon font span explicitly set `aria-hidden="true"` on the span. Simultaneously, consider mirroring the `aria-label` text into a `title` attribute to support mouse users with native tooltips.
