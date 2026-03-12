1. **Identify the UX issue**: In `header.php` and `template-parts/mobile-bottom-nav.php`, decorative icon `<span>` elements (using Google Material Symbols) are not hidden from screen readers. This means screen readers might announce "search" or "menu" multiple times unnecessarily.
2. **Implement the fix**: Add `aria-hidden="true"` to all decorative `<span class="material-symbols-outlined">...</span>` tags inside `<button>` and `<a>` elements that already have proper `aria-label` or visible text.
3. **Verify the changes**: Use `grep` to ensure `aria-hidden="true"` has been added to the relevant files.
4. **Journal Entry**: Add a learning about icon font screen reader accessibility.
5. **Pre-commit steps**: Run necessary testing before submission.
6. **Submit**: Create PR with a title describing the UX improvement.
