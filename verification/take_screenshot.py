from playwright.sync_api import sync_playwright
import os

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        # Load the local HTML file
        url = "file://" + os.path.abspath("verification/verify_promo_design.html")
        page.goto(url)

        # Wait for fonts and content
        page.wait_for_timeout(2000)

        # Take a screenshot
        page.screenshot(path="verification/verification_promo.png", full_page=True)

        browser.close()

if __name__ == "__main__":
    run()
