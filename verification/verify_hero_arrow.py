from playwright.sync_api import sync_playwright
import os

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page(viewport={"width": 1280, "height": 720})

        # Construct file URL
        cwd = os.getcwd()
        file_path = f"file://{cwd}/verification/test_hero.html"

        print(f"Navigating to {file_path}")
        page.goto(file_path)

        # Wait for content
        # page.wait_for_load_state("domcontentloaded") # Sometimes fails with file://
        page.wait_for_timeout(2000) # Wait for external resources

        # Screenshot 1: Initial State
        page.screenshot(path="verification/hero_arrow_initial.png", full_page=True)
        print("Screenshot 1 taken.")

        # Test Focus State
        # Focus the anchor
        page.locator('a[href="#content-start"]').focus()
        page.wait_for_timeout(500)

        # Verify focus
        if page.locator('a[href="#content-start"]').is_visible():
            print("Anchor is visible.")

        # Screenshot 2: Focused State
        page.screenshot(path="verification/hero_arrow_focused.png")
        print("Screenshot 2 taken.")

        browser.close()

if __name__ == "__main__":
    run()
