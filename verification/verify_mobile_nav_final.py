from playwright.sync_api import sync_playwright
import os

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        # iPhone 12 viewport
        page = browser.new_page(viewport={"width": 390, "height": 844})

        cwd = os.getcwd()
        page.goto(f"file://{cwd}/verification/mobile_nav_test.html")

        # 1. Screenshot Bottom Nav
        page.screenshot(path="verification/mobile_nav_bar_final.png")

        # 2. Click Menu
        page.click(".mobile-menu-trigger")
        page.wait_for_timeout(500) # Wait for transition

        # 3. Screenshot Menu Open
        page.screenshot(path="verification/mobile_menu_open_final.png")

        browser.close()

if __name__ == "__main__":
    run()
