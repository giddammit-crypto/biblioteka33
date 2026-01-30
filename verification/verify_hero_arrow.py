
from playwright.sync_api import sync_playwright, expect
import os

def test_hero_arrow():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        # Load the local HTML file
        cwd = os.getcwd()
        file_path = f"file://{cwd}/verification/test_hero_arrow.html"
        page.goto(file_path)

        # Locate the arrow link
        arrow_link = page.get_by_label("Прокрутить к содержимому")

        # Assertions
        expect(arrow_link).to_be_visible()
        expect(arrow_link).to_have_attribute("href", "#start-of-content")

        # Check if the arrow contains the icon
        icon = arrow_link.locator("span.material-symbols-outlined")
        expect(icon).to_have_text("expand_more")

        # Take screenshot of the Hero section bottom
        page.set_viewport_size({"width": 1280, "height": 800})
        # Scroll to bottom of hero section to see the arrow
        # (It's absolute positioned at bottom, so it should be visible in first viewport if h-screen fits,
        # but let's make sure we capture it)

        page.screenshot(path="verification/verification.png")

        browser.close()

if __name__ == "__main__":
    test_hero_arrow()
