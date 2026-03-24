
import asyncio
from playwright.async_api import async_playwright
import os

async def run_test():
    async with async_playwright() as p:
        # Test in Chromium
        browser_c = await p.chromium.launch()
        page_c = await browser_c.new_page()
        file_path = "file://" + os.path.abspath("firefox_test.html")
        await page_c.goto(file_path)
        await page_c.screenshot(path="chrome_news_card.png")
        await browser_c.close()

        # Test in Firefox
        browser_f = await p.firefox.launch()
        page_f = await browser_f.new_page()
        await page_f.goto(file_path)
        # Give Firefox a bit more time to render
        await asyncio.sleep(1)
        await page_f.screenshot(path="firefox_news_card.png")
        await browser_f.close()

if __name__ == "__main__":
    asyncio.run(run_test())
