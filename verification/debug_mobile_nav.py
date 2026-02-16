
import os
from playwright.sync_api import sync_playwright, expect

def run(playwright):
    browser = playwright.chromium.launch(headless=True)
    # Emulate iPhone 12
    iphone_12 = playwright.devices['iPhone 12']
    context = browser.new_context(**iphone_12)
    page = context.new_page()

    # Get absolute path to the HTML file
    cwd = os.getcwd()
    file_path = f"file://{cwd}/verification/mobile_nav.html"

    print(f"Navigating to {file_path}")
    page.goto(file_path)

    # Print viewport
    print(f"Viewport: {page.viewport_size}")

    # Wait for tailwind to process (simple delay)
    page.wait_for_timeout(2000)

    # 1. Verify Bottom Nav Existence
    bottom_nav = page.locator('nav.fixed.bottom-0')

    # Check if it has the classes
    expect(bottom_nav).to_have_class("md:hidden fixed bottom-0 left-0 w-full bg-white/95 backdrop-blur-md shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] z-50 border-t border-slate-200")

    # Take screenshot to see what's happening
    page.screenshot(path="verification/mobile_nav_debug.png")

    # If visible fails, maybe it's off-screen or 0 height?
    box = bottom_nav.bounding_box()
    print(f"Bounding box: {box}")

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
