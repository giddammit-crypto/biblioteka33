
import os
from playwright.sync_api import sync_playwright, expect

def run(playwright):
    browser = playwright.chromium.launch(headless=True)

    # 1. Desktop Test
    page = browser.new_page(viewport={"width": 1280, "height": 720})

    # Get absolute path to the HTML file
    cwd = os.getcwd()
    file_path = f"file://{cwd}/verification/mock_renewal_page.html"

    print(f"Navigating to {file_path}")
    page.goto(file_path)

    # Wait for JS to render button
    page.wait_for_selector("#book-renewal-btn")

    # Click Button
    page.click("#book-renewal-btn")

    # Wait for Modal Overlay to appear
    modal_overlay = page.locator("#renewal-modal-overlay")
    expect(modal_overlay).to_be_visible()

    # Wait for Animation (opacity)
    page.wait_for_timeout(1000)

    # Screenshot Desktop
    page.screenshot(path="verification/renewal_modal_desktop.png")
    print("Desktop screenshot saved.")

    # 2. Mobile Test (iPhone 12)
    iphone_12 = playwright.devices['iPhone 12']
    context_mobile = browser.new_context(**iphone_12)
    page_mobile = context_mobile.new_page()
    page_mobile.goto(file_path)

    # Wait & Click
    page_mobile.wait_for_selector("#book-renewal-btn")
    page_mobile.click("#book-renewal-btn")

    # Wait for Modal
    expect(page_mobile.locator("#renewal-modal-overlay")).to_be_visible()
    page_mobile.wait_for_timeout(1000)

    # Screenshot Mobile
    page_mobile.screenshot(path="verification/renewal_modal_mobile.png")
    print("Mobile screenshot saved.")

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
