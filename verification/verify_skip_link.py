
import os
from playwright.sync_api import sync_playwright, expect

def test_skip_link(page):
    # Load the local HTML file
    cwd = os.getcwd()
    file_path = f"file://{cwd}/verification/mock_site.html"
    page.goto(file_path)

    # Initially, the link should be translated up (visually hidden)
    # We can't easily check 'visually hidden' via standard matchers if it's transform-based,
    # but we can check the class or computed style if needed.
    # However, let's just focus on the interaction.

    # Press Tab to focus the first interactive element.
    # Since the skip link is the first element in the body, it should receive focus.
    page.keyboard.press("Tab")

    # Get the link
    skip_link = page.get_by_text("Перейти к основному контенту")

    # Verify it is focused
    expect(skip_link).to_be_focused()

    # Verify it is now visible (conceptually) - taking a screenshot
    # We wait a brief moment for transition
    page.wait_for_timeout(300)
    page.screenshot(path="verification/skip_link_focused.png")

    # Click (or press Enter) to activate
    page.keyboard.press("Enter")

    # Verify URL fragment
    assert "#main-content" in page.url

    # Verify focus moved to main content
    main_content = page.locator("#main-content")
    expect(main_content).to_be_focused()

if __name__ == "__main__":
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()
        try:
            test_skip_link(page)
            print("Verification successful!")
        except Exception as e:
            print(f"Verification failed: {e}")
            exit(1)
        finally:
            browser.close()
