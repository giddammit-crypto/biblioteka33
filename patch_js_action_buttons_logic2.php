<?php
$file = 'wp-content/themes/city-library/js/ai-chat.js';
$content = file_get_contents($file);

$search = "        // Scroll to bottom\n        messagesContainer.scrollTop = messagesContainer.scrollHeight;\n    }";

$replace = "        // Bind PDF Download (using browser print to PDF)
        const pdfBtn = wrapper.querySelector('.ai-pdf-btn');
        if (pdfBtn) {
            pdfBtn.addEventListener('click', function() {
                const rawText = this.getAttribute('data-text');
                const printWindow = window.open('', '_blank', 'width=800,height=600');
                let htmlContent = rawText;
                if (typeof marked !== 'undefined') {
                    htmlContent = marked.parse(rawText);
                }
                printWindow.document.write(`
                    <html><head><title>Печать / Сохранить как PDF</title>
                    <style>
                        body { font-family: sans-serif; padding: 40px; line-height: 1.6; color: #333; }
                        img { max-width: 100%; height: auto; }
                    </style>
                    </head><body>
                    \${htmlContent}
                    <script>window.onload = function() { window.print(); window.close(); }</script>
                    </body></html>
                `);
                printWindow.document.close();
            });
        }

        // Bind DOCX Download
        const docxBtn = wrapper.querySelector('.ai-docx-btn');
        if (docxBtn) {
            docxBtn.addEventListener('click', function() {
                const rawText = this.getAttribute('data-text');
                const originalHTML = this.innerHTML;
                this.innerHTML = '<span class=\"material-symbols-outlined text-[14px] animate-spin\">sync</span> ...';
                this.disabled = true;

                jQuery.ajax({
                    url: cl_ai_ajax.url,
                    type: 'POST',
                    data: {
                        action: 'city_library_ai_docx',
                        nonce: cl_ai_ajax.nonce,
                        content: rawText
                    },
                    success: (response) => {
                        if (response.success) {
                            const byteCharacters = atob(response.data.html);
                            const byteNumbers = new Array(byteCharacters.length);
                            for (let i = 0; i < byteCharacters.length; i++) {
                                byteNumbers[i] = byteCharacters.charCodeAt(i);
                            }
                            const byteArray = new Uint8Array(byteNumbers);
                            const blob = new Blob([byteArray], { type: 'application/msword;charset=utf-8' });
                            const link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = 'Ответ_Библиотекаря.doc';
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        } else {
                            alert(\"Ошибка генерации DOCX: \" + response.data);
                        }
                    },
                    error: () => {
                        alert(\"Произошла ошибка при генерации документа.\");
                    },
                    complete: () => {
                        this.innerHTML = originalHTML;
                        this.disabled = false;
                    }
                });
            });
        }

        // Bind Email Button
        const emailBtn = wrapper.querySelector('.ai-email-btn');
        if (emailBtn) {
            emailBtn.addEventListener('click', function() {
                const rawText = this.getAttribute('data-text');
                const userEmail = prompt(\"Введите ваш email адрес для отправки ответа:\");
                if (userEmail && userEmail.trim() !== '') {
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<span class=\"material-symbols-outlined text-[14px] animate-spin\">sync</span> ...';
                    this.disabled = true;

                    jQuery.ajax({
                        url: cl_ai_ajax.url,
                        type: 'POST',
                        data: {
                            action: 'city_library_ai_email',
                            nonce: cl_ai_ajax.nonce,
                            email: userEmail,
                            content: rawText
                        },
                        success: (response) => {
                            if (response.success) {
                                this.innerHTML = '<span class=\"material-symbols-outlined text-[14px]\">check</span> Отправлено';
                                this.classList.add('text-green-600');
                                setTimeout(() => {
                                    this.innerHTML = originalHTML;
                                    this.classList.remove('text-green-600');
                                }, 3000);
                            } else {
                                alert(\"Ошибка: \" + response.data);
                                this.innerHTML = originalHTML;
                            }
                        },
                        error: () => {
                            alert(\"Произошла ошибка при отправке.\");
                            this.innerHTML = originalHTML;
                        },
                        complete: () => {
                            this.disabled = false;
                        }
                    });
                }
            });
        }

        // Bind Draft Button if present
        const draftBtns = wrapper.querySelectorAll('.ai-draft-btn');
        if (draftBtns.length > 0) {
            draftBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const authorName = this.getAttribute('data-author');
                    if (authorName) {
                        inputField.value = '/author ' + authorName;
                        sendMessage();
                    }
                });
            });
        }

        // Bind Save to WP Draft button
        const saveDraftBtn = wrapper.querySelector('.ai-save-draft-btn');
        if (saveDraftBtn) {
            saveDraftBtn.addEventListener('click', function() {
                const rawText = this.getAttribute('data-text');
                const postTitle = 'Черновик: ' + (rawText.split('\\n')[0].replace(/#/g, '').trim() || 'Статья');

                const originalHTML = this.innerHTML;
                this.innerHTML = '<span class=\"material-symbols-outlined text-[14px] animate-spin\">sync</span> Сохраняем...';
                this.disabled = true;

                jQuery.ajax({
                    url: cl_ai_ajax.url,
                    type: 'POST',
                    data: {
                        action: 'city_library_ai_draft',
                        nonce: cl_ai_ajax.nonce,
                        title: postTitle,
                        content: rawText
                    },
                    success: (response) => {
                        if (response.success) {
                            this.innerHTML = `<a href=\"\${response.data.edit_link}\" target=\"_blank\" class=\"flex items-center gap-1\"><span class=\"material-symbols-outlined text-[14px]\">open_in_new</span> Редактировать</a>`;
                            this.classList.add('text-green-600', 'hover:text-green-700');
                            this.classList.remove('text-slate-500', 'hover:text-primary', 'bg-slate-100');
                        } else {
                            alert(\"Ошибка: \" + response.data);
                            this.innerHTML = originalHTML;
                        }
                    },
                    error: () => {
                        alert(\"Произошла ошибка при создании черновика.\");
                        this.innerHTML = originalHTML;
                    },
                    complete: () => {
                        this.disabled = false;
                    }
                });
            });
        }

        // Scroll to bottom
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }";

if (strpos($content, "Bind PDF Download") === false) {
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
        file_put_contents($file, $content);
        echo "Successfully patched Action Buttons Logic.\n";
    } else {
        echo "Search string not found.\n";
    }
} else {
    echo "Already patched Logic.\n";
}
