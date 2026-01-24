from playwright.sync_api import sync_playwright
import os

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        # Construct file URL
        cwd = os.getcwd()
        file_path = f"file://{cwd}/test_sidebar_magic.html"

        print(f"Navigating to {file_path}")
        page.goto(file_path)

        # Wait for fonts and content
        page.wait_for_load_state("networkidle")

        # Screenshot 1: Initial State (Magic Mode + Sidebar)
        page.screenshot(path="verification/1_magic_sidebar_visible.png", full_page=True)
        print("Screenshot 1 taken.")

        # Test Sidebar Toggle
        # Click the button
        page.click("#sidebar-toggle-btn")

        # Wait for transition (300ms in CSS)
        page.wait_for_timeout(500)

        # Screenshot 2: Sidebar Hidden
        page.screenshot(path="verification/2_magic_sidebar_hidden.png", full_page=True)
        print("Screenshot 2 taken.")

        browser.close()

if __name__ == "__main__":
    run()
