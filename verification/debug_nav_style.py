
import os
from playwright.sync_api import sync_playwright

def run(playwright):
    browser = playwright.chromium.launch(headless=True)
    iphone_12 = playwright.devices['iPhone 12']
    context = browser.new_context(**iphone_12)
    page = context.new_page()

    cwd = os.getcwd()
    file_path = f"file://{cwd}/verification/mobile_nav.html"
    page.goto(file_path)

    # Check innerWidth
    width = page.evaluate("window.innerWidth")
    print(f"Window innerWidth: {width}")

    # Check computed display style
    display = page.locator('nav.fixed.bottom-0').evaluate("el => getComputedStyle(el).display")
    print(f"Computed display: {display}")

    # Check media query match
    mq = page.evaluate("window.matchMedia('(min-width: 768px)').matches")
    print(f"Media Query (min-width: 768px) matches: {mq}")

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
