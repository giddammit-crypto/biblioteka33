<?php
$file = 'wp-content/themes/city-library/js/ai-chat.js';
$content = file_get_contents($file);

$search = "    const closeBtn = document.getElementById('close-ai-chat');";
$replace = "    const closeBtn = document.getElementById('close-ai-chat');\n    const helpBubble = document.getElementById('ai-chat-help-bubble');";

if (strpos($content, "'ai-chat-help-bubble'") === false) {
    $content = str_replace($search, $replace, $content);
}

$search2 = "    // Toggle Window\n    function toggleChat() {";
$replace2 = "    // Help Bubble Logic (Every 10 minutes)\n    let helpBubbleInterval = setInterval(showHelpBubble, 600000); // 10 minutes = 600000 ms\n\n    function showHelpBubble() {\n        if (chatWindow.classList.contains('hidden') && helpBubble) {\n            helpBubble.classList.remove('opacity-0', 'translate-y-4');\n            helpBubble.classList.add('opacity-100', 'translate-y-0');\n            setTimeout(() => {\n                if (helpBubble) {\n                    helpBubble.classList.remove('opacity-100', 'translate-y-0');\n                    helpBubble.classList.add('opacity-0', 'translate-y-4');\n                }\n            }, 5000);\n        }\n    }\n\n    // Initial delayed bubble (e.g. 1 minute after load)\n    setTimeout(showHelpBubble, 60000);\n\n    // Toggle Window\n    function toggleChat() {\n        // Hide bubble if it's showing\n        if (helpBubble) {\n            helpBubble.classList.remove('opacity-100', 'translate-y-0');\n            helpBubble.classList.add('opacity-0', 'translate-y-4');\n        }";

if (strpos($content, "showHelpBubble") === false) {
    $content = str_replace($search2, $replace2, $content);
}

file_put_contents($file, $content);
echo "Successfully added JS logic for help bubble.\n";
