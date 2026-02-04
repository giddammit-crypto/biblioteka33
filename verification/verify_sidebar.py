
from playwright.sync_api import sync_playwright, expect
import os

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        # Load local HTML file
        file_path = os.path.abspath("test_sidebar_access.html")
        page.goto(f"file://{file_path}")

        # Locate elements
        btn = page.locator("#sidebar-toggle-btn")

        # 1. Initial State Check
        # Expect aria-expanded to be "true"
        expect(btn).to_have_attribute("aria-expanded", "true")
        print("Initial state confirmed: aria-expanded='true'")

        # Take screenshot of initial state
        page.screenshot(path="verification/sidebar_initial.png")

        # 2. Click to Collapse
        btn.click()

        # Expect aria-expanded to be "false"
        expect(btn).to_have_attribute("aria-expanded", "false")
        print("Collapsed state confirmed: aria-expanded='false'")

        # Take screenshot of collapsed state
        page.screenshot(path="verification/sidebar_collapsed.png")

        # 3. Click to Expand
        btn.click()

        # Expect aria-expanded to be "true" again
        expect(btn).to_have_attribute("aria-expanded", "true")
        print("Expanded state confirmed: aria-expanded='true'")

        browser.close()

if __name__ == "__main__":
    run()
