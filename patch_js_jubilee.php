<?php
$file = 'wp-content/themes/city-library/js/ai-chat.js';
$content = file_get_contents($file);

$search = "            } else {\n                addMessageToUI('bot', '<span class=\"text-red-500\">' + response.data.reply + '</span>');\n            }\n        },\n        error: function() {";

$replace = "            } else {\n                addMessageToUI('bot', '<span class=\"text-red-500\">' + response.data.reply + '</span>');\n            }\n        },\n        error: function() {";

// Let's add the event delegator for "Собрать черновик" buttons to the wrapper
$search2 = "        // Scroll to bottom\n        messagesContainer.scrollTop = messagesContainer.scrollHeight;\n    }";

$replace2 = "        // Bind Draft Button if present\n        const draftBtns = wrapper.querySelectorAll('.ai-draft-btn');\n        if (draftBtns.length > 0) {\n            draftBtns.forEach(btn => {\n                btn.addEventListener('click', function() {\n                    const authorName = this.getAttribute('data-author');\n                    if (authorName) {\n                        inputField.value = '/author ' + authorName;\n                        sendMessage();\n                    }\n                });\n            });\n        }\n\n        // Bind Save to WP Draft button (dynamically added if /author returns good text)\n        const saveDraftBtn = wrapper.querySelector('.ai-save-draft-btn');\n        if (saveDraftBtn) {\n            saveDraftBtn.addEventListener('click', function() {\n                const rawText = this.getAttribute('data-text');\n                const postTitle = 'Черновик: ' + (rawText.split('\\n')[0].replace(/#/g, '').trim() || 'Статья');\n                \n                const originalHTML = this.innerHTML;\n                this.innerHTML = '<span class=\"material-symbols-outlined text-[14px] animate-spin\">sync</span> Сохраняем...';\n                this.disabled = true;\n\n                jQuery.ajax({\n                    url: cl_ai_ajax.url,\n                    type: 'POST',\n                    data: {\n                        action: 'city_library_ai_draft',\n                        nonce: cl_ai_ajax.nonce,\n                        title: postTitle,\n                        content: rawText\n                    },\n                    success: (response) => {\n                        if (response.success) {\n                            this.innerHTML = `<a href=\"\${response.data.edit_link}\" target=\"_blank\" class=\"flex items-center gap-1\"><span class=\"material-symbols-outlined text-[14px]\">open_in_new</span> Редактировать</a>`;\n                            this.classList.add('text-green-600', 'hover:text-green-700');\n                            this.classList.remove('text-slate-400', 'hover:text-primary');\n                        } else {\n                            alert(\"Ошибка: \" + response.data);\n                            this.innerHTML = originalHTML;\n                        }\n                    },\n                    error: () => {\n                        alert(\"Произошла ошибка при создании черновика.\");\n                        this.innerHTML = originalHTML;\n                    },\n                    complete: () => {\n                        this.disabled = false;\n                    }\n                });\n            });\n        }\n\n        // Scroll to bottom\n        messagesContainer.scrollTop = messagesContainer.scrollHeight;\n    }";

if (strpos($content, ".ai-draft-btn") === false) {
    if (strpos($content, $search2) !== false) {
        $content = str_replace($search2, $replace2, $content);
        file_put_contents($file, $content);
        echo "Successfully added Draft Button JS logic.\n";
    } else {
        echo "Search string 2 not found.\n";
    }
} else {
    echo "Already patched JS logic.\n";
}
