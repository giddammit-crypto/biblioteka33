from playwright.sync_api import sync_playwright
import os

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        cwd = os.getcwd()
        page.goto(f"file://{cwd}/verification/white_bg_test.html")

        page.screenshot(path="verification/white_bg_final.png")

        browser.close()

if __name__ == "__main__":
    run()
