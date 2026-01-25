## 2024-05-23 - Accessibility: Skip to Content
**Learning:** Adding a "Skip to Content" link is a critical accessibility feature that is often missed in custom themes. It allows keyboard users to bypass repetitive navigation. Using `sr-only focus:not-sr-only` with Tailwind is a clean way to implement this without custom CSS.
**Action:** Always check for "Skip to Content" links in `header.php` and verify that the target ID exists on the main content container.
