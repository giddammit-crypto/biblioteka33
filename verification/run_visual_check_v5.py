from playwright.sync_api import sync_playwright
import os

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch()
        page = browser.new_page(viewport={"width": 1400, "height": 2000})

        # Load local HTML file
        file_path = os.path.abspath("verification/visual_check_v5.html")
        page.goto(f"file://{file_path}")

        # Take screenshot
        page.screenshot(path="verification/visual_check_v5.png", full_page=True)

        browser.close()

if __name__ == "__main__":
    run()
