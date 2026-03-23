document.addEventListener('DOMContentLoaded', function() {
    const params = window.renewal_params || {};
    const settings = params.settings || {};

    // Visibility Check
    const isMobile = window.innerWidth < 1024;
    const visibility = settings.btn_visibility || 'mobile-only';

    if (visibility === 'hidden') return;
    if (visibility === 'mobile-only' && !isMobile) return;
    if (visibility === 'desktop-only' && isMobile) return;

    // 1. Create Floating Button (Stylish & Accessible)
    const renewBtn = document.createElement('button');
    renewBtn.id = 'book-renewal-btn';

    // Base Classes
    let btnClasses = 'fixed z-50 px-6 py-4 font-bold shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 flex items-center gap-3 group active:scale-95 border border-white/20 backdrop-blur-sm transform translate-y-0';

    // Position Classes
    const position = settings.btn_position || 'bottom-right';

    // Logic: Desktop (lg+) landscape follows strict corners.
    // Mobile/Kiosk (< lg OR portrait) snaps to right-center or left-center (vertical middle).

    // Common desktop base: lg:landscape:bottom-6
    if (position === 'bottom-left') {
        // Mobile/Kiosk: Left Center (top-1/2 -translate-y-1/2)
        // Desktop Landscape: Bottom Left (bottom-6)
        btnClasses += ' left-0 top-1/2 -translate-y-1/2 rounded-l-none lg:landscape:top-auto lg:landscape:bottom-6 lg:landscape:left-6 lg:landscape:translate-y-0 lg:landscape:rounded-full';
    } else {
        // Mobile/Kiosk: Right Center (top-1/2 -translate-y-1/2)
        // Desktop Landscape: Bottom Right (bottom-6)
        btnClasses += ' right-0 top-1/2 -translate-y-1/2 rounded-r-none lg:landscape:top-auto lg:landscape:bottom-6 lg:landscape:right-6 lg:landscape:translate-y-0 lg:landscape:rounded-full';
    }

    // Radius Classes
    const radius = settings.btn_radius || 'circle';
    if (radius === 'circle') btnClasses += ' rounded-full';
    else if (radius === 'medium') btnClasses += ' rounded-xl';
    else if (radius === 'small') btnClasses += ' rounded-md';
    else if (radius === 'square') btnClasses += ' rounded-none';

    renewBtn.className = btnClasses;

    // Apply Colors inline
    renewBtn.style.backgroundColor = settings.btn_bg || '#0b7930';
    renewBtn.style.color = settings.btn_text_color || '#ffffff';

    renewBtn.setAttribute('aria-label', settings.btn_text || 'Открыть форму продления книг');
    renewBtn.innerHTML = `
        <span class="material-symbols-outlined text-2xl group-hover:rotate-12 transition-transform duration-300">auto_stories</span>
        <span class="hidden md:inline-block font-display tracking-wide text-sm uppercase">${settings.btn_text || 'Продление книг'}</span>
    `;
    renewBtn.title = settings.btn_text || "Продление книг онлайн";
    document.body.appendChild(renewBtn);

    // Smart Hiding Logic (Scroll)
    // The user requested: "If site scrolled to footer -> hide, else -> show".
    // Removed "Hide at Top" logic.

    function checkVisibility() {
        const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
        const windowHeight = window.innerHeight;
        const docHeight = document.documentElement.scrollHeight;
        const scrollBottom = currentScroll + windowHeight;

        // Hide ONLY if at Bottom of page (Footer Zone)
        if (scrollBottom >= docHeight - 50) {
            renewBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-x-full'); // Hide off-screen
        } else {
            renewBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-x-full');
        }
    }

    // Initial check
    checkVisibility();

    window.addEventListener('scroll', () => {
        checkVisibility();
    }, { passive: true });

    // 2. Create Modal Structure (Ultra Design: White, Clean, Adaptive)
    const modalOverlay = document.createElement('div');
    modalOverlay.id = 'renewal-modal-overlay';
    modalOverlay.className = 'fixed inset-0 z-[100] bg-black/60 backdrop-blur-md hidden flex items-center justify-center p-4 transition-all duration-500 opacity-0';
    modalOverlay.setAttribute('role', 'dialog');
    modalOverlay.setAttribute('aria-modal', 'true');
    modalOverlay.setAttribute('aria-labelledby', 'renewal-modal-title');

    // Build Branch Options
    let branchOptions = '<option value="" disabled selected>Выберите филиал из списка</option>';
    if (params.branches) {
        for (const [id, name] of Object.entries(params.branches)) {
            branchOptions += `<option value="${id}">${name}</option>`;
        }
    }

    // Modal Content: White Background, Black Text (Strictly Enforced)
    modalOverlay.innerHTML = `
        <div class="bg-white rounded-[2.5rem] w-full max-w-md md:max-w-lg shadow-2xl overflow-hidden transform scale-90 transition-all duration-500 relative max-h-[90vh] flex flex-col border border-slate-100 ring-1 ring-black/5" id="renewal-modal-content">

            <!-- Header with Gradient Accent -->
            <div class="relative bg-white px-8 py-6 shrink-0 border-b border-slate-100 flex items-center justify-between z-10">
                <div>
                    <h3 id="renewal-modal-title" class="text-2xl font-display font-bold text-slate-900 tracking-tight leading-none">
                        Продление книг
                    </h3>
                    <p class="text-xs text-slate-500 font-medium mt-1 uppercase tracking-wider">Онлайн сервис</p>
                </div>
                <button type="button" class="modal-close p-2 rounded-full text-slate-400 hover:text-slate-900 hover:bg-slate-100 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary/50 group" aria-label="Закрыть">
                    <span class="material-symbols-outlined text-2xl group-hover:rotate-90 transition-transform duration-300">close</span>
                </button>
            </div>

            <!-- Scrollable Body -->
            <div class="px-8 py-6 overflow-y-auto custom-scrollbar bg-white">
                <form id="renewal-form" class="space-y-5">

                    <!-- FIO Input -->
                    <div class="group">
                        <label for="renewal_fio" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1 transition-colors group-focus-within:text-primary">Ф.И.О. читателя *</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors" aria-hidden="true">person</span>
                            <input type="text" id="renewal_fio" name="fio" required placeholder="Иванов Иван Иванович"
                                   class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-300 hover:bg-slate-50/80 font-medium text-sm">
                        </div>
                    </div>

                    <!-- Card Number Input -->
                    <div class="group">
                        <label for="renewal_card_number" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1 transition-colors group-focus-within:text-primary">Номер читательского билета *</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors" aria-hidden="true">badge</span>
                            <input type="text" id="renewal_card_number" name="card_number" required placeholder="№ 12345"
                                   class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-300 hover:bg-slate-50/80 font-medium text-sm">
                        </div>
                    </div>

                    <!-- Branch Select -->
                    <div class="group">
                        <label for="renewal_branch" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1 transition-colors group-focus-within:text-primary">Филиал *</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors" aria-hidden="true">store</span>
                            <select id="renewal_branch" name="branch" required
                                    class="w-full pl-12 pr-10 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-300 hover:bg-slate-50/80 font-medium text-sm appearance-none cursor-pointer">
                                ${branchOptions}
                            </select>
                            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xl" aria-hidden="true">expand_more</span>
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div class="group">
                        <label for="renewal_email" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1 transition-colors group-focus-within:text-primary">Email для связи *</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors" aria-hidden="true">mail</span>
                            <input type="email" id="renewal_email" name="email" required placeholder="example@mail.ru"
                                   class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-300 hover:bg-slate-50/80 font-medium text-sm">
                        </div>
                    </div>

                    <!-- Books Textarea -->
                    <div class="group">
                        <label for="renewal_books" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1 transition-colors group-focus-within:text-primary">Список книг (автор, название) *</label>
                        <div class="relative">
                            <textarea id="renewal_books" name="books" rows="3" required placeholder="Пример: Пушкин А.С. - Евгений Онегин..."
                                      class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-300 hover:bg-slate-50/80 font-medium text-sm resize-none"></textarea>
                        </div>
                    </div>

                    <!-- Feedback Message Area -->
                    <div id="renewal-message" class="hidden p-4 rounded-xl text-sm font-bold text-center border animate-fade-in-up"></div>

                    <!-- Submit Button -->
                    <button type="submit" id="renewal-submit-btn" class="w-full py-4 bg-primary hover:bg-green-700 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-0.5 active:translate-y-0 flex justify-center items-center gap-2 group mt-2">
                        <span class="uppercase tracking-widest text-xs md:text-sm">Отправить заявку</span>
                        <span class="material-symbols-outlined text-xl group-hover:translate-x-1 transition-transform">send</span>
                    </button>

                    <!-- Legal Text -->
                    <p class="text-[10px] text-slate-400 text-center leading-tight px-4 pb-2">
                        Нажимая кнопку «Отправить», я даю свое согласие на обработку моих персональных данных в соответствии с Федеральным законом №152-ФЗ.
                    </p>
                </form>
            </div>
        </div>
    `;
    document.body.appendChild(modalOverlay);

    // 3. Logic: Animation & Interaction
    const modalContent = document.getElementById('renewal-modal-content');
    const form = document.getElementById('renewal-form');
    const msgBox = document.getElementById('renewal-message');
    const submitBtn = document.getElementById('renewal-submit-btn');

    function openModal() {
        modalOverlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Lock scroll

        // Trigger Animations
        requestAnimationFrame(() => {
            modalOverlay.classList.remove('opacity-0');
            modalContent.classList.remove('scale-90');
            modalContent.classList.add('scale-100');
        });
    }

    function closeModal() {
        modalOverlay.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-90');

        setTimeout(() => {
            modalOverlay.classList.add('hidden');
            document.body.style.overflow = ''; // Unlock scroll
        }, 500); // Match transition duration
    }

    renewBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        openModal();
    });

    // Close on overlay click
    modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) {
            closeModal();
        }
    });

    // Close on button click
    const closeBtns = modalOverlay.querySelectorAll('.modal-close');
    closeBtns.forEach(btn => btn.addEventListener('click', closeModal));

    // Close on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modalOverlay.classList.contains('hidden')) {
            closeModal();
        }
    });

    // 4. AJAX Submission (Enhanced UX)
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Loading State
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-80', 'cursor-wait');
        const originalBtnContent = submitBtn.innerHTML;
        submitBtn.innerHTML = `
            <span class="material-symbols-outlined animate-spin text-xl">refresh</span>
            <span class="uppercase tracking-widest text-xs md:text-sm">Отправка...</span>
        `;
        msgBox.classList.add('hidden');
        msgBox.className = 'hidden p-4 rounded-xl text-sm font-bold text-center border animate-fade-in-up'; // Reset classes

        const formData = new FormData(form);
        formData.append('action', 'city_library_send_book_renewal');
        if (params.nonce) formData.append('nonce', params.nonce);

        // Simulate network delay for better UX feel (optional, but good for "Ultra Quality")
        const minDelay = new Promise(resolve => setTimeout(resolve, 600));
        const fetchRequest = fetch(params.ajax_url, { method: 'POST', body: formData });

        Promise.all([fetchRequest, minDelay])
            .then(([response]) => response.json())
            .then(data => {
                msgBox.classList.remove('hidden');
                if (data.success) {
                    // Success State
                    msgBox.classList.add('bg-green-50', 'text-green-700', 'border-green-200');
                    msgBox.innerHTML = `
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-3xl text-green-600">check_circle</span>
                            <span>${data.data.message}</span>
                        </div>
                    `;
                    form.reset();
                    setTimeout(closeModal, 3000);
                } else {
                    // Error State
                    throw new Error(data.data.message || 'Ошибка сервера.');
                }
            })
            .catch(err => {
                console.error(err);
                msgBox.classList.remove('hidden');
                msgBox.classList.add('bg-red-50', 'text-red-700', 'border-red-200');
                msgBox.innerHTML = `
                    <div class="flex flex-col items-center gap-2">
                        <span class="material-symbols-outlined text-3xl text-red-600">error</span>
                        <span>${err.message || 'Ошибка соединения.'}</span>
                    </div>
                `;
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-80', 'cursor-wait');
                submitBtn.innerHTML = originalBtnContent;
            });
    });
});
