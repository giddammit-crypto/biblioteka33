from playwright.sync_api import sync_playwright
import os

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        # Determine absolute path to the HTML file
        cwd = os.getcwd()
        file_path = f"file://{cwd}/verification/page_block_preview.html"

        print(f"Navigating to: {file_path}")
        page.goto(file_path)

        # Wait for Tailwind to process (though it's usually fast via CDN)
        page.wait_for_timeout(1000)

        # Screenshot
        output_path = f"{cwd}/verification/screenshot_page_block.png"
        page.screenshot(path=output_path, full_page=True)
        print(f"Screenshot saved to: {output_path}")

        browser.close()

if __name__ == "__main__":
    run()
