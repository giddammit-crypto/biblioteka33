import os
from playwright.sync_api import sync_playwright

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        # Load local file
        file_path = os.path.abspath("verification/verify_aaa.html")
        page.goto(f"file://{file_path}")

        # Set Viewport to 1920x1080 (Desktop)
        page.set_viewport_size({"width": 1920, "height": 1080})

        # Wait for Tailwind to process (CDN) - usually fast but good to wait a sec
        page.wait_for_timeout(1000)

        # 1. Full Page Screenshot
        page.screenshot(path="verification/aaa_full_page.png", full_page=True)
        print("Full page screenshot taken.")

        # 2. Hero Section
        hero = page.locator("section").first
        hero.screenshot(path="verification/aaa_hero.png")
        print("Hero screenshot taken.")

        # 3. Card Hover State
        card = page.locator("article").first
        card.hover()
        page.wait_for_timeout(500) # Wait for transition
        card.screenshot(path="verification/aaa_card_hover.png")
        print("Card hover screenshot taken.")

        browser.close()

if __name__ == "__main__":
    run()
