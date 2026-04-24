## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2024-04-24 - Accessibility Enhancements for AI Chat Buttons
**Learning:** Found multiple icon-only buttons (`button` containing only `span.material-symbols-outlined`) in `wp-content/themes/city-library/inc/virtual-librarian.php` without `aria-label` attributes, which would read poorly (or not at all) to screen reader users. Also lacking `title` attributes for sighted mouse users to understand the icon's purpose.
**Action:** Always add descriptive `aria-label` and `title` attributes (localized, if possible, e.g., `<?php esc_attr_e('На весь экран', 'city-library'); ?>`) to icon-only buttons. Ensure the child icon element (like `span.material-symbols-outlined`) has `aria-hidden="true"` to prevent redundant/confusing announcements by screen readers.
