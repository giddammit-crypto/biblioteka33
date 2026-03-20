<?php
$file = 'wp-content/themes/city-library/inc/virtual-librarian.php';
$content = file_get_contents($file);

$search = "            <!-- Notification Dot -->
            <span class=\"absolute top-0 right-0 w-3.5 h-3.5 bg-red-500 border-2 border-white rounded-full animate-pulse shadow-sm z-20\"></span>
        </button>
    </div>
    <?php";

$replace = "            <!-- Notification Dot -->
            <span class=\"absolute top-0 right-0 w-3.5 h-3.5 bg-red-500 border-2 border-white rounded-full animate-pulse shadow-sm z-20\"></span>
        </button>

        <!-- Help Bubble -->
        <div id=\"ai-chat-help-bubble\" class=\"absolute bottom-20 right-0 w-48 bg-white border border-slate-200 shadow-xl rounded-2xl rounded-br-sm p-3 text-sm font-medium text-slate-700 opacity-0 translate-y-4 pointer-events-none transition-all duration-500 z-0 flex items-center gap-2\">
            <span class=\"material-symbols-outlined text-primary text-xl animate-bounce\">waving_hand</span>
            Я могу помочь!
            <div class=\"absolute -bottom-2 right-4 w-4 h-4 bg-white border-b border-r border-slate-200 transform rotate-45\"></div>
        </div>
    </div>
    <?php";

if (strpos($content, "ai-chat-help-bubble") === false) {
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
        file_put_contents($file, $content);
        echo "Successfully added help bubble HTML.\n";
    } else {
        echo "Search string not found.\n";
    }
} else {
    echo "Already patched.\n";
}
