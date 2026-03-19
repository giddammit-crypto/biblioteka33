## 2024-05-24 - Redundant screen reader announcements for Material Symbols
**Learning:** Material Symbols use text ligatures (e.g., `<span class="material-symbols-outlined">menu</span>`) to render icons. If these are placed inside buttons that already have `aria-label`s, screen readers announce both the label and the ligature text (e.g., "Open menu, menu").
**Action:** Always add `aria-hidden="true"` to ligature-based icon spans (like Material Symbols) when they are used purely for visual decoration or when their parent element already provides an accessible label.
