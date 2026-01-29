from playwright.sync_api import sync_playwright
import os

def test_search_accessibility():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        # Load the local HTML file
        file_path = os.path.abspath("verification/test_search.html")
        page.goto(f"file://{file_path}")

        # Check input accessibility
        input_field = page.get_by_role("searchbox", name="Search for:")
        if not input_field.is_visible():
             # Fallback if role is not strictly searchbox in some browsers without specific attributes, but <input type="search"> usually is.
             # Or name comes from aria-label.
             print("Search input not found by role/name")

        # Verify aria-label on input
        aria_label_input = page.locator("input[name='s']").get_attribute("aria-label")
        print(f"Input aria-label: {aria_label_input}")
        assert aria_label_input == "Search for:"

        # Check button accessibility
        submit_button = page.get_by_role("button", name="Найти")
        if submit_button.is_visible():
            print("Submit button found by accessible name 'Найти'")
        else:
            print("Submit button NOT found by accessible name 'Найти'")

        # Verify aria-hidden on icons
        icons = page.locator(".material-symbols-outlined")
        count = icons.count()
        print(f"Found {count} icons")
        for i in range(count):
            hidden = icons.nth(i).get_attribute("aria-hidden")
            print(f"Icon {i} aria-hidden: {hidden}")
            assert hidden == "true"

        # Take screenshot
        page.screenshot(path="verification/verification.png")
        print("Screenshot saved to verification/verification.png")

        browser.close()

if __name__ == "__main__":
    test_search_accessibility()
