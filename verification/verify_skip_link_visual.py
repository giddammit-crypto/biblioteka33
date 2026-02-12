
import os
from playwright.sync_api import sync_playwright

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch()
        page = browser.new_page()

        # Determine the absolute path to the HTML file
        cwd = os.getcwd()
        file_url = f"file://{cwd}/verification/test_skip_link.html"

        page.goto(file_url)

        # Initial state: skip link should be hidden (sr-only)
        skip_link = page.locator('text=Перейти к основному контенту')

        # Check that it has sr-only class initially (visually hidden)
        # We can't easily check for specific class presence with locator methods alone,
        # but we can check bounding box or visibility if not for sr-only tech.
        # However, sr-only usually makes it 1x1px or clipped.

        # Press Tab to focus the link
        page.keyboard.press("Tab")

        # Now it should be focused
        expect_focus = skip_link.is_visible()
        if expect_focus:
            print("Skip link is visible after Tab.")
        else:
            print("Skip link is NOT visible after Tab.")

        # Take a screenshot of the focused state
        page.screenshot(path="verification/skip_link_focused.png")

        browser.close()

if __name__ == "__main__":
    run()
