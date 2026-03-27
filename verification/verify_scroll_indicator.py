from playwright.sync_api import sync_playwright, expect
import os
import re

def test_scroll_indicator():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()
        page.set_viewport_size({"width": 1280, "height": 800})

        # Load the mock HTML file
        file_path = os.path.abspath("verification/mock_header.html")
        page.goto(f"file://{file_path}")

        # 1. Verify the scroll indicator is an anchor tag
        indicator = page.locator('a[href="#content-start"]')
        expect(indicator).to_be_visible()

        # 2. Verify aria-label
        expect(indicator).to_have_attribute("aria-label", "Прокрутить вниз")

        # 3. Verify it has the correct icon (content check)
        # The text inside the span is the ligature for the icon
        expect(indicator.locator("span.material-symbols-outlined")).to_have_text("expand_more")

        # 4. Verify target element exists and has the class
        target = page.locator("#content-start")
        expect(target).to_be_attached()
        expect(target).to_have_class(re.compile(r"scroll-mt-24"))

        # Wait for any animations or fonts (just a small pause)
        page.wait_for_timeout(1000)

        # Screenshot the hero section
        hero_section = page.locator("section.relative")
        hero_section.screenshot(path="verification/verification.png")

        print("Verification passed! Screenshot saved to verification/verification.png")

        browser.close()

if __name__ == "__main__":
    test_scroll_indicator()
