from playwright.sync_api import sync_playwright
import os

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page(viewport={"width": 1024, "height": 768})

        # Load local file
        cwd = os.getcwd()
        page.goto(f"file://{cwd}/verification/responsive_test.html")

        # Wait for Tailwind CDN
        page.wait_for_timeout(2000)

        page.screenshot(path="verification/screenshot_1024.png")
        browser.close()

if __name__ == "__main__":
    run()
