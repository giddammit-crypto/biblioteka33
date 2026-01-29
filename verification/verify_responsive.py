import os
from playwright.sync_api import sync_playwright

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        # Load local file
        file_path = os.path.abspath("verification/verify_responsive.html")
        page.goto(f"file://{file_path}")

        # 1. Desktop View (1920x1080)
        page.set_viewport_size({"width": 1920, "height": 1080})
        page.screenshot(path="verification/desktop_view.png")
        print("Desktop screenshot taken.")

        # Check Eye Icon Position (Should be far right)
        # We can visually confirm in the screenshot.

        # 2. Tablet View (768x1024)
        page.set_viewport_size({"width": 768, "height": 1024})
        page.screenshot(path="verification/tablet_view.png")
        print("Tablet screenshot taken.")

        # 3. Mobile View (375x800)
        page.set_viewport_size({"width": 375, "height": 800})
        page.screenshot(path="verification/mobile_view.png")
        print("Mobile screenshot taken.")

        # 4. Mobile Menu Drawer
        page.click("#mobile-menu-btn")
        page.wait_for_timeout(500) # Wait for transition
        page.screenshot(path="verification/mobile_menu_open.png")
        print("Mobile Menu screenshot taken.")

        # 5. Book Renewal Modal (Desktop)
        page.set_viewport_size({"width": 1920, "height": 1080})
        page.reload() # Reset state
        page.click("#book-renewal-btn")
        page.wait_for_timeout(500)
        page.screenshot(path="verification/modal_open.png")
        print("Modal screenshot taken.")

        browser.close()

if __name__ == "__main__":
    run()
