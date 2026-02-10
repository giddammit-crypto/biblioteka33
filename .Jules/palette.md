## 2024-05-22 - Global Styles vs Component Specificity
**Learning:** Global CSS rules with `!important` injected via PHP (e.g., `button { ... !important }`) override Tailwind utility classes, forcing the use of inline styles for exceptions.
**Action:** When overriding such styles for specific components (like light-themed navigation buttons), use inline `style="..."` attributes with `!important` as a last resort, or refactor the global injection to be less aggressive.

## 2024-05-22 - Large Typography Overlap
**Learning:** Using `leading-tight` on responsive display fonts (`text-3xl` to `text-6xl`) can cause vertical overlap when words wrap, especially with unknown custom fonts.
**Action:** Default to `leading-snug` or `leading-normal` for dynamic headers and always include `break-words` or `pb-2` (padding-bottom) to accommodate descenders.

## 2024-05-24 - Missing Landmark Structure
**Learning:** The theme was structurally broken (`<main>` opened in `header.php` but never closed), which breaks landmark navigation for screen readers. This is a common pattern in older or fragmented themes.
**Action:** Always verify the structural integrity of landmark elements (`<main>`, `<header>`, `<footer>`) across template parts when auditing accessibility.

## 2024-05-24 - Russian Localization Default
**Learning:** The theme uses Russian text directly in the source code as the default, wrapped in translation functions. This is unconventional for international themes but critical context for this specific project.
**Action:** When adding new UI text, use Russian as the default string to maintain consistency with the existing codebase.
