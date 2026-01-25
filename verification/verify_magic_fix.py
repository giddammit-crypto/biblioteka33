from playwright.sync_api import sync_playwright
import os

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch()
        page = browser.new_page()

        # Load local file
        file_path = f"file://{os.path.abspath('test_magic_fix.html')}"
        page.goto(file_path)

        # Wait for button to appear
        page.wait_for_selector('#magic-mode-toggle')

        # Click the button
        page.click('#magic-mode-toggle')

        # Wait for animation (overlay to appear and class to add)
        # The JS has a 500ms delay before adding the class inside 'animateBookOpening' -> 'enableMagicMode'
        page.wait_for_timeout(2000)

        # Check if body has class
        is_magic = page.evaluate("document.body.classList.contains('magic-mode')")
        print(f"Body has magic-mode class: {is_magic}")

        if is_magic:
            # Check computed style
            bg_color = page.evaluate("window.getComputedStyle(document.body).backgroundColor")
            print(f"Body background color: {bg_color}")

            # Take screenshot
            page.screenshot(path="verification/magic_fix_proof.png", full_page=True)
        else:
            print("Failed: magic-mode class not found on body")

        browser.close()

if __name__ == "__main__":
    run()
