## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2024-05-23 - Decorative Icon Literal Text Redundancy
**Learning:** Using Google Material Symbols via literal text (e.g., `<span class="material-symbols-outlined">menu</span>`) causes screen readers to read the literal word "menu" even if the parent button already has a properly descriptive `aria-label="Открыть меню"`. This leads to confusing, redundant audio like "Открыть меню, menu".
**Action:** Always add `aria-hidden="true"` to `material-symbols-outlined` spans that are purely decorative or when their parent interactive element already provides the necessary accessible name.
