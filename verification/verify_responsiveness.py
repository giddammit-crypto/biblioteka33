from playwright.sync_api import sync_playwright
import os

def run(playwright):
    browser = playwright.chromium.launch(headless=True)
    page = browser.new_page()

    # Load the local HTML file
    file_path = os.path.abspath("verification/mock_index.html")
    page.goto(f"file://{file_path}")

    # Wait for Tailwind to load/render (approx)
    page.wait_for_timeout(1000)

    # 1. Mobile
    page.set_viewport_size({"width": 375, "height": 800})
    page.screenshot(path="verification/responsive_mobile.png", full_page=True)
    print("Mobile screenshot taken.")

    # 2. Tablet
    page.set_viewport_size({"width": 768, "height": 1024})
    page.screenshot(path="verification/responsive_tablet.png", full_page=True)
    print("Tablet screenshot taken.")

    # 3. Desktop (Standard)
    page.set_viewport_size({"width": 1280, "height": 1024})
    page.screenshot(path="verification/responsive_desktop.png", full_page=True)
    print("Desktop screenshot taken.")

    # 4. Large Desktop (Check 80% cap)
    page.set_viewport_size({"width": 1920, "height": 1080})
    page.screenshot(path="verification/responsive_xl.png", full_page=True)
    print("XL screenshot taken.")

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
