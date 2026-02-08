document.addEventListener('DOMContentLoaded', function() {
    const params = window.renewal_params || {};

    // 1. Create Floating Button
    const renewBtn = document.createElement('button');
    renewBtn.id = 'book-renewal-btn';
    renewBtn.className = 'fixed bottom-6 left-6 z-50 px-6 py-4 rounded-full bg-green-600 text-white font-bold shadow-lg hover:bg-green-700 transition-all duration-300 hover:scale-105 flex items-center gap-2 group';
    renewBtn.innerHTML = `
        <span class="material-symbols-outlined text-2xl" aria-hidden="true">auto_stories</span>
        <span class="hidden group-hover:inline-block transition-all">Продление книг онлайн</span>
    `;
    renewBtn.title = "Продление книг онлайн";
    renewBtn.setAttribute('aria-label', 'Продление книг онлайн');
    document.body.appendChild(renewBtn);

    // 2. Create Modal Structure
    const modalOverlay = document.createElement('div');
    modalOverlay.id = 'renewal-modal-overlay';
    modalOverlay.className = 'fixed inset-0 z-[100] bg-black/80 backdrop-blur-sm hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300';
    modalOverlay.setAttribute('role', 'dialog');
    modalOverlay.setAttribute('aria-modal', 'true');
    modalOverlay.setAttribute('aria-labelledby', 'renewal-modal-title');

    // Build Branch Options
    let branchOptions = '<option value="">Выберите филиал</option>';
    if (params.branches) {
        for (const [id, name] of Object.entries(params.branches)) {
            branchOptions += `<option value="${id}">${name}</option>`;
        }
    }

    modalOverlay.innerHTML = `
        <div class="bg-white dark:bg-slate-900 bg-pattern-slate rounded-[2rem] w-full max-w-lg shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 relative max-h-[90vh] flex flex-col">
            <!-- Header -->
            <div class="p-6 relative flex justify-center items-center shrink-0 border-b border-slate-200 dark:border-slate-700">
                <h3 id="renewal-modal-title" class="text-xl font-bold font-display uppercase tracking-wider text-green-600 text-center">Продление книг онлайн</h3>
                <button type="button" class="modal-close absolute right-4 top-1/2 -translate-y-1/2 text-slate-900 dark:text-white hover:text-red-500 transition-colors p-2" aria-label="Закрыть">
                    <span class="material-symbols-outlined text-2xl" aria-hidden="true">close</span>
                </button>
            </div>

            <!-- Scrollable Body -->
            <div class="p-8 overflow-y-auto custom-scrollbar">
                <form id="renewal-form" class="space-y-6">
                    <div>
                        <label for="renewal-fio" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Ф.И.О. читателя *</label>
                        <input type="text" id="renewal-fio" name="fio" required class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-700 focus:border-primary focus:ring-primary">
                    </div>

                    <div>
                        <label for="renewal-card" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Номер читательского билета *</label>
                        <input type="text" id="renewal-card" name="card_number" required class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-700 focus:border-primary focus:ring-primary">
                    </div>

                    <div>
                        <label for="renewal-branch" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Филиал *</label>
                        <select id="renewal-branch" name="branch" required class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-700 focus:border-primary focus:ring-primary">
                            ${branchOptions}
                        </select>
                    </div>

                    <div>
                        <label for="renewal-email" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Email для связи *</label>
                        <input type="email" id="renewal-email" name="email" required class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-700 focus:border-primary focus:ring-primary">
                    </div>

                    <div>
                        <label for="renewal-books" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Список книг (автор, название) *</label>
                        <textarea id="renewal-books" name="books" rows="4" required class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-700 focus:border-primary focus:ring-primary" placeholder="Пример: Пушкин А.С. - Евгений Онегин..."></textarea>
                    </div>

                    <div id="renewal-message" class="hidden p-4 rounded-lg text-sm font-bold text-center" role="alert"></div>

                    <button type="submit" id="renewal-submit-btn" class="w-full py-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-colors shadow-md flex justify-center items-center gap-2">
                        <span>Отправить заявку</span>
                        <span class="material-symbols-outlined" aria-hidden="true">send</span>
                    </button>

                    <p class="text-[10px] text-slate-400 text-center leading-tight">
                        Нажимая кнопку «Отправить», я даю свое согласие на обработку моих персональных данных, в соответствии с Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных данных».
                    </p>
                </form>
            </div>
        </div>
    `;
    document.body.appendChild(modalOverlay);

    // 3. Logic
    const form = document.getElementById('renewal-form');
    const msgBox = document.getElementById('renewal-message');
    const submitBtn = document.getElementById('renewal-submit-btn');
    const modalContent = modalOverlay.querySelector('div');
    const closeBtn = modalOverlay.querySelector('.modal-close');
    let previousActiveElement = null;

    function openModal() {
        previousActiveElement = document.activeElement;
        modalOverlay.classList.remove('hidden');
        // Small delay for CSS transition
        setTimeout(() => {
            modalOverlay.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');

            // Focus first interactive element (close button)
            closeBtn.focus();
        }, 10);

        document.body.style.overflow = 'hidden'; // Prevent scrolling background
    }

    function closeModal() {
        modalOverlay.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modalOverlay.classList.add('hidden');
            document.body.style.overflow = '';

            // Return focus
            if (previousActiveElement) {
                previousActiveElement.focus();
            }
        }, 300);
    }

    // Trap Focus Logic
    modalOverlay.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeModal();
            return;
        }

        if (e.key === 'Tab') {
            const focusableElements = modalOverlay.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];

            if (e.shiftKey) { // Shift + Tab
                if (document.activeElement === firstElement) {
                    e.preventDefault();
                    lastElement.focus();
                }
            } else { // Tab
                if (document.activeElement === lastElement) {
                    e.preventDefault();
                    firstElement.focus();
                }
            }
        }
    });

    renewBtn.addEventListener('click', openModal);

    modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay || e.target.closest('.modal-close')) {
            closeModal();
        }
    });

    // 4. AJAX Submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Disable button
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-70', 'cursor-not-allowed');
        submitBtn.innerHTML = '<span class="material-symbols-outlined animate-spin" aria-hidden="true">refresh</span> Отправка...';
        msgBox.classList.add('hidden');

        const formData = new FormData(form);
        formData.append('action', 'city_library_send_book_renewal');
        formData.append('nonce', params.nonce);

        fetch(params.ajax_url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            msgBox.classList.remove('hidden');
            if (data.success) {
                msgBox.className = 'p-4 rounded-lg text-sm font-bold text-center bg-green-100 text-green-700 border border-green-200';
                msgBox.textContent = data.data.message;
                form.reset();
                setTimeout(closeModal, 3000);
            } else {
                msgBox.className = 'p-4 rounded-lg text-sm font-bold text-center bg-red-100 text-red-700 border border-red-200';
                msgBox.textContent = data.data.message || 'Ошибка сервера.';
            }
        })
        .catch(err => {
            console.error(err);
            msgBox.classList.remove('hidden');
            msgBox.className = 'p-4 rounded-lg text-sm font-bold text-center bg-red-100 text-red-700 border border-red-200';
            msgBox.textContent = 'Ошибка сети. Проверьте соединение.';
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-70', 'cursor-not-allowed');
            submitBtn.innerHTML = '<span>Отправить заявку</span><span class="material-symbols-outlined" aria-hidden="true">send</span>';
        });
    });
});
