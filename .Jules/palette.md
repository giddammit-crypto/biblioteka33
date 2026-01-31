## 2024-05-23 - Skip Link Implementation in Tailwind Themes
**Learning:** In themes relying on Tailwind CSS for styling (like `city-library`), standard "screen-reader-only" classes might not be available or configured.
**Action:** Use Tailwind's utility classes `absolute -top-full focus:top-0` to create accessible skip links without relying on external CSS or custom classes. This ensures the skip link works even if custom CSS fails to load, as long as Tailwind is present.
