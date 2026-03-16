import asyncio
from playwright.async_api import async_playwright
import os

async def run():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        page = await browser.new_page()

        # HTML file path
        html_file_path = os.path.abspath('test_book_renewal.html')

        html_content = """
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <title>Test Book Renewal</title>
            <script src="https://cdn.tailwindcss.com"></script>
        </head>
        <body>
            <script>
                window.renewal_params = {
                    branches: {
                        '1': 'Центральная библиотека',
                        '2': 'Филиал 1'
                    },
                    ajax_url: 'dummy',
                    nonce: 'dummy'
                };
            </script>
            <script src="./wp-content/themes/city-library/js/book-renewal.js"></script>
        </body>
        </html>
        """

        with open(html_file_path, 'w') as f:
            f.write(html_content)

        await page.goto(f'file://{html_file_path}')

        # Click the floating button to open the modal
        await page.click('#book-renewal-btn')

        # Wait for the modal to be visible
        await page.wait_for_selector('#renewal-modal-content', state='visible')

        # Check for the correct attributes
        elements_to_check = [
            {'label_for': 'renewal-fio', 'input_id': 'renewal-fio'},
            {'label_for': 'renewal-card', 'input_id': 'renewal-card'},
            {'label_for': 'renewal-branch', 'input_id': 'renewal-branch'},
            {'label_for': 'renewal-email', 'input_id': 'renewal-email'},
            {'label_for': 'renewal-books', 'input_id': 'renewal-books'},
        ]

        all_passed = True
        for item in elements_to_check:
            label_for = item['label_for']
            input_id = item['input_id']

            # Check label
            label_exists = await page.evaluate(f"document.querySelector('label[for=\"{label_for}\"]') !== null")
            if not label_exists:
                print(f"FAILED: Label with for='{label_for}' not found.")
                all_passed = False
            else:
                print(f"PASSED: Label with for='{label_for}' found.")

            # Check input/select/textarea
            input_exists = await page.evaluate(f"document.getElementById('{input_id}') !== null")
            if not input_exists:
                print(f"FAILED: Element with id='{input_id}' not found.")
                all_passed = False
            else:
                print(f"PASSED: Element with id='{input_id}' found.")

        if all_passed:
            print("All accessibility attributes verified successfully.")

        await browser.close()
        os.remove(html_file_path)

if __name__ == "__main__":
    asyncio.run(run())
