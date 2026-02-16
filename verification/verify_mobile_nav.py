
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

    # 1. Verify Bottom Nav Existence and Visibility on Mobile
    bottom_nav = page.locator('nav.fixed.bottom-0')
    expect(bottom_nav).to_be_visible()

    # 2. Verify Items
    home_link = bottom_nav.get_by_text("Главная")
    expect(home_link).to_be_visible()

    afisha_link = bottom_nav.get_by_text("Афиша")
    expect(afisha_link).to_be_visible()

    search_btn = bottom_nav.get_by_text("Поиск")
    expect(search_btn).to_be_visible()

    menu_btn = bottom_nav.get_by_text("Меню")
    expect(menu_btn).to_be_visible()

    # 3. Take Screenshot
    page.screenshot(path="verification/mobile_nav_verification.png")
    print("Mobile verification complete. Screenshot saved.")

    # 4. Desktop Check (Should be hidden)
    page_desktop = browser.new_page() # Default viewport 1280x720
    page_desktop.goto(file_path)
    bottom_nav_desktop = page_desktop.locator('nav.fixed.bottom-0')
    # It has 'md:hidden' class. Tailwind CDN might not process 'md:' correctly in file:// context without build or full processing if not sized right?
    # Tailwind CDN works by observing DOM.
    # Let's check visibility.
    expect(bottom_nav_desktop).to_be_hidden()
    print("Desktop verification complete (Nav hidden).")

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
