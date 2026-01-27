from playwright.sync_api import sync_playwright
import os
import time

def test_ui():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        file_path = os.path.abspath("verification/test_ui.html")
        page.goto(f"file://{file_path}")

        # 1. Verify Cookie Banner (Wait for animation)
        print("Waiting for cookie banner...")
        page.wait_for_selector("#cookie-consent-banner", state="visible")
        time.sleep(1.5) # Wait for slide up

        # 2. Verify Book Renewal Button
        print("Waiting for renewal button...")
        page.wait_for_selector("#book-renewal-btn", state="visible")
        renew_btn = page.locator("#book-renewal-btn")

        # Hide cookie banner to see modal clearly
        page.evaluate("document.getElementById('cookie-consent-banner').style.display = 'none'")

        # 3. Open Modal
        print("Clicking renewal button...")
        renew_btn.click()

        # 4. Verify Modal
        print("Waiting for modal...")
        page.wait_for_selector("#renewal-modal-overlay", state="visible")
        time.sleep(1) # Wait for transition

        print("Taking screenshot of Modal...")
        page.screenshot(path="verification/ui_modal_v2.png")

        browser.close()

if __name__ == "__main__":
    test_ui()
