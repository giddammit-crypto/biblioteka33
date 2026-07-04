## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2024-05-23 - Accessible Icon-Only Buttons
**Learning:** For icon-only buttons in the `city-library` theme (like header actions), standard `aria-label` is good for screen readers, but mouse users miss out on native tooltips. Material Symbols (e.g. `span` with literal text 'search') can also cause redundant or unlocalized English announcements for screen readers if not hidden. Additionally, standard `:focus` styling can leave sticky rings after mouse clicks.
**Action:** When creating icon-only buttons, always combine `aria-label` with a native `title` attribute for mouse hover. Wrap the inner icon element (like Material Symbols) with `aria-hidden="true"`. Use Tailwind's `focus-visible` (e.g., `focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/50`) instead of `:focus` for accessible keyboard styling that doesn't penalize mouse users.
