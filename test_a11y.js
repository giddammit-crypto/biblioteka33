const fs = require('fs');

const fileContent = fs.readFileSync('wp-content/themes/city-library/inc/virtual-librarian.php', 'utf8');

const buttons = [
  'id="fullscreen-ai-chat"',
  'id="close-ai-chat"',
  'id="ai-chat-attachment"',
  'id="ai-chat-send"',
  'id="ai-chat-toggle"'
];

let allPassed = true;

buttons.forEach(buttonId => {
  const match = fileContent.match(new RegExp(`<button[^>]*${buttonId}[^>]*>`));
  if (match) {
    if (match[0].includes('aria-label=')) {
        console.log(`✅ Passed: ${buttonId} has aria-label.`);
    } else {
        console.log(`❌ Failed: ${buttonId} is missing aria-label.`);
        allPassed = false;
    }
  } else {
    console.log(`❌ Failed: Could not find ${buttonId}.`);
    allPassed = false;
  }
});

if (!allPassed) {
  process.exit(1);
} else {
  console.log("All buttons have correct aria-label attributes.");
}
