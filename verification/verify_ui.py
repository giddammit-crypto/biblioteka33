from playwright.sync_api import sync_playwright
import os

def test_ui():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        # Get absolute path to html file
        file_path = os.path.abspath("verification/test_ui.html")
        page.goto(f"file://{file_path}")

        # 1. Verify Cookie Banner
        print("Waiting for cookie banner...")
        page.wait_for_selector("#cookie-consent-banner", state="visible")
        banner = page.locator("#cookie-consent-banner")

        # Check Button Color
        btn = banner.locator("#cookie-accept-btn")
        # We can't easily check computed style color without JS evaluation, but visuals will show it.
        # But let's check class presence if possible or just screenshot.

        # 2. Verify Book Renewal Button
        print("Waiting for renewal button...")
        page.wait_for_selector("#book-renewal-btn", state="visible")
        renew_btn = page.locator("#book-renewal-btn")

        # 3. Open Modal
        print("Clicking renewal button...")
        renew_btn.click()

        # 4. Verify Modal
        print("Waiting for modal...")
        page.wait_for_selector("#renewal-modal-overlay", state="visible")

        # 5. Take Screenshot
        # We want to capture the whole viewport to see the banner (bottom) and modal (center) and button (bottom left)
        # Note: Modal overlay covers everything, so button might be behind overlay?
        # Actually button has z-index 50, overlay z-100. So button is behind.
        # But Cookie Banner has z-90. Overlay z-100.
        # So overlay covers everything.
        # But we want to see the button color too.
        # Maybe I'll close the modal to see the button first?
        # Or take two screenshots.

        print("Taking screenshot of Modal...")
        page.screenshot(path="verification/ui_modal.png")

        # Close modal to see buttons
        page.locator(".modal-close").click()
        page.wait_for_selector("#renewal-modal-overlay", state="hidden")

        print("Taking screenshot of Buttons...")
        page.screenshot(path="verification/ui_buttons.png")

        browser.close()

if __name__ == "__main__":
    test_ui()
