## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2024-05-23 - Material Symbols Screen Reader Text
**Learning:** Decorative Google Material Symbol `<span>` elements rely on text ligatures (e.g., `<span>search</span>`). Without `aria-hidden="true"`, screen readers will explicitly read these literal names out loud to users, confusing navigation.
**Action:** Always explicitly mark decorative icon font ligatures with `aria-hidden="true"` and provide alternative text via `aria-label` or `.sr-only` elements on their container.

## 2024-05-23 - Hostile Focus Outlines on Mobile UI
**Learning:** Using `focus:outline-none` unconditionally on interactive elements (like mobile navigation buttons) breaks keyboard accessibility for users relying on alternative input methods.
**Action:** Always pair `focus:outline-none` with safe visual alternatives, like `focus-visible:ring-2`, so sighted keyboard users maintain a clear indicator of focus.
