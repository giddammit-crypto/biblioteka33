document.addEventListener('DOMContentLoaded', () => {
    const accessibilityButton = document.getElementById('accessibility-button');
    if (!accessibilityButton) return;

    // GOST AA CSS Stylesheet
    const style = document.createElement('style');
    style.id = 'city-library-a11y-gost-styles';
    style.textContent = `
        /* Base A11y Reset */
        body.a11y-active *, body.a11y-active *:before, body.a11y-active *:after {
            transition: none !important;
            animation: none !important;
            box-shadow: none !important;
            text-shadow: none !important;
            border-radius: 0 !important;
            background-image: none !important;
        }

        /* Color Themes Setup */
        body.a11y-active {
            --a11y-bg: #ffffff;
            --a11y-text: #000000;
            --a11y-link: #0000ee;
            --a11y-border: #000000;
        }

        body.a11y-active[data-a11y-theme="wb"] {
            --a11y-bg: #000000;
            --a11y-text: #ffffff;
            --a11y-link: #ffff00;
            --a11y-border: #ffffff;
        }

        body.a11y-active[data-a11y-theme="bb"] {
            --a11y-bg: #9dd1ff;
            --a11y-text: #063462;
            --a11y-link: #000000;
            --a11y-border: #063462;
        }

        body.a11y-active[data-a11y-theme="br"] {
            --a11y-bg: #f7f3d6;
            --a11y-text: #4d3319;
            --a11y-link: #000000;
            --a11y-border: #4d3319;
        }

        /* Apply Colors Globally (excluding the control panel) */
        body.a11y-active,
        body.a11y-active main:not(#a11y-panel *),
        body.a11y-active header:not(#a11y-panel *),
        body.a11y-active footer:not(#a11y-panel *),
        body.a11y-active section:not(#a11y-panel *),
        body.a11y-active article:not(#a11y-panel *),
        body.a11y-active nav:not(#a11y-panel *),
        body.a11y-active div:not(#a11y-panel *),
        body.a11y-active span:not(.material-symbols-outlined):not(#a11y-panel *) {
            background-color: var(--a11y-bg) !important;
            color: var(--a11y-text) !important;
            border-color: var(--a11y-border) !important;
        }

        body.a11y-active h1, body.a11y-active h2, body.a11y-active h3, body.a11y-active h4, body.a11y-active h5, body.a11y-active h6,
        body.a11y-active p, body.a11y-active li, body.a11y-active td, body.a11y-active th, body.a11y-active label {
            color: var(--a11y-text) !important;
        }

        body.a11y-active a:not(#a11y-panel *), body.a11y-active a *:not(#a11y-panel *) {
            color: var(--a11y-link) !important;
            text-decoration: underline !important;
            text-decoration-thickness: 2px !important;
        }

        body.a11y-active a:hover, body.a11y-active a:focus {
            background-color: var(--a11y-link) !important;
            color: var(--a11y-bg) !important;
            outline: 4px solid var(--a11y-border) !important;
            outline-offset: 4px !important;
        }

        /* Font Family */
        body.a11y-active[data-a11y-font="sans"] *:not(.material-symbols-outlined) {
            font-family: Arial, Helvetica, sans-serif !important;
        }
        body.a11y-active[data-a11y-font="serif"] *:not(.material-symbols-outlined) {
            font-family: "Times New Roman", Times, serif !important;
        }
        body.a11y-active .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            color: var(--a11y-text) !important;
        }

        /* Font Size Setup */
        body.a11y-active[data-a11y-size="normal"] { --a11y-scale: 1; }
        body.a11y-active[data-a11y-size="large"] { --a11y-scale: 1.5; }
        body.a11y-active[data-a11y-size="xlarge"] { --a11y-scale: 2; }

        body.a11y-active h1 { font-size: calc(2.5rem * var(--a11y-scale)) !important; line-height: 1.2 !important; font-weight: bold !important; }
        body.a11y-active h2 { font-size: calc(2rem * var(--a11y-scale)) !important; font-weight: bold !important; }
        body.a11y-active h3 { font-size: calc(1.75rem * var(--a11y-scale)) !important; font-weight: bold !important; }
        body.a11y-active p, body.a11y-active li, body.a11y-active span:not(.material-symbols-outlined), body.a11y-active div, body.a11y-active a {
            font-size: calc(1.125rem * var(--a11y-scale)) !important;
            line-height: 1.5 !important;
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
        }

        /* Letter Spacing */
        body.a11y-active[data-a11y-spacing="normal"] * { letter-spacing: normal !important; }
        body.a11y-active[data-a11y-spacing="medium"] * { letter-spacing: 0.1em !important; }
        body.a11y-active[data-a11y-spacing="large"] * { letter-spacing: 0.2em !important; }

        /* Images */
        body.a11y-active[data-a11y-images="grayscale"] img {
            filter: grayscale(100%) contrast(150%) !important;
        }
        body.a11y-active[data-a11y-images="hidden"] img,
        body.a11y-active[data-a11y-images="hidden"] svg,
        body.a11y-active[data-a11y-images="hidden"] .swiper-slide > div.absolute.inset-0 {
            display: none !important;
        }

        body.a11y-active img {
            border: 2px solid var(--a11y-border) !important;
            max-width: 100% !important;
            max-height: 50vh !important;
            height: auto !important;
            object-fit: contain !important;
            margin-left: auto !important;
            margin-right: auto !important;
            display: block !important;
            position: relative !important; /* Force static/relative so absolutely positioned images appear */
        }

        /* UI Adjustments for Adaptivity */
        body.a11y-active .swiper-wrapper { display: flex !important; flex-direction: column !important; gap: 2rem !important; transform: none !important; }
        body.a11y-active .swiper-slide { width: 100% !important; height: auto !important; position: relative !important; }
        body.a11y-active .swiper-slide > div { position: relative !important; height: auto !important; }

        body.a11y-active article.group { display: flex !important; flex-direction: column !important; height: auto !important; width: 100% !important; border: 2px solid var(--a11y-border) !important; position: relative !important; overflow: visible !important; }
        body.a11y-active article.group > div.absolute.inset-0,
        body.a11y-active article.group > div:first-child { position: relative !important; height: auto !important; min-height: 200px !important; width: 100% !important; border-bottom: 2px solid var(--a11y-border) !important; overflow: visible !important; }
        body.a11y-active article.group > div.relative.z-10 { position: relative !important; padding: 1.5rem !important; pointer-events: auto !important; }
        body.a11y-active article.group a.absolute.inset-0.lg\\:hidden { display: none !important; }
        body.a11y-active .absolute.bg-primary\\/5, body.a11y-active .blur-3xl, body.a11y-active [class*="bg-gradient"]:not(.swiper-button-prev):not(.swiper-button-next) { display: none !important; }
        body.a11y-active article, body.a11y-active .widget, body.a11y-active .swiper-slide > div, body.a11y-active footer { border: 2px solid var(--a11y-border) !important; box-sizing: border-box !important; }

        /* Menu & Header Adaptivity */
        body.a11y-active #masthead { border-top: none !important; border-left: none !important; border-right: none !important; border-bottom: 4px solid var(--a11y-border) !important; height: auto !important; }
        body.a11y-active #masthead > div { flex-wrap: wrap !important; gap: 1rem !important; }
        body.a11y-active nav { width: 100% !important; overflow: visible !important; }
        body.a11y-active nav > ul { flex-wrap: wrap !important; display: flex !important; justify-content: flex-start !important; gap: 1rem !important; }
        body.a11y-active .sub-menu { position: static !important; display: block !important; opacity: 1 !important; visibility: visible !important; transform: none !important; box-shadow: none !important; padding-left: 1rem !important; border-left: 2px solid var(--a11y-border) !important; margin-top: 0.5rem !important; }
        body.a11y-active li.group > a .material-symbols-outlined { display: none !important; }

        /* Compact Panel UI Styles (Adaptive toolbar) */
        #a11y-panel {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 999999;
            background: #ffffff;
            color: #000000;
            border-bottom: 2px solid #000000;
            padding: 0.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            font-family: Arial, Helvetica, sans-serif !important;
            letter-spacing: normal !important;
            font-size: 14px !important;
            max-height: 100vh;
            overflow-y: auto;
        }

        #a11y-panel.is-visible {
            display: block;
        }

        #a11y-panel * {
            background-color: transparent !important;
            color: inherit !important;
            border-color: #000000 !important;
            font-size: inherit !important;
            letter-spacing: inherit !important;
            font-family: inherit !important;
            transition: none !important;
        }

        #a11y-panel .a11y-panel-inner {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
            justify-content: center;
            max-width: 1400px;
            margin: 0 auto;
        }

        #a11y-panel .a11y-group {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            border: 1px solid #ccc !important;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }

        #a11y-panel .a11y-label {
            font-weight: bold !important;
            font-size: 0.85rem !important;
            margin-right: 0.5rem !important;
            color: #333 !important;
            border: none !important;
            text-transform: uppercase;
        }

        #a11y-panel button.a11y-btn {
            background: #f8f9fa !important;
            color: #000000 !important;
            border: 1px solid #000000 !important;
            padding: 0.25rem 0.5rem !important;
            font-size: 0.9rem !important;
            font-weight: bold !important;
            cursor: pointer !important;
            border-radius: 2px !important;
            text-decoration: none !important;
            min-width: 32px;
            text-align: center;
        }

        #a11y-panel button.a11y-btn:hover, #a11y-panel button.a11y-btn:focus {
            background: #e2e8f0 !important;
            outline: 2px solid #000000 !important;
        }

        #a11y-panel button.a11y-btn.active {
            background: #000000 !important;
            color: #ffffff !important;
        }

        /* Specific theme buttons inside panel */
        #a11y-panel button[data-action="theme"][data-value="bw"] { background: #ffffff !important; color: #000000 !important; }
        #a11y-panel button[data-action="theme"][data-value="wb"] { background: #000000 !important; color: #ffffff !important; }
        #a11y-panel button[data-action="theme"][data-value="wb"].active { border-color: #666 !important; }
        #a11y-panel button[data-action="theme"][data-value="bb"] { background: #9dd1ff !important; color: #063462 !important; border-color: #063462 !important; }
        #a11y-panel button[data-action="theme"][data-value="br"] { background: #f7f3d6 !important; color: #4d3319 !important; border-color: #4d3319 !important; }

        #a11y-panel .a11y-actions {
            display: flex;
            gap: 0.5rem;
            margin-left: auto;
        }

        #a11y-panel button.a11y-btn-turn-off {
            background: #fee2e2 !important;
            color: #991b1b !important;
            border-color: #991b1b !important;
        }
        #a11y-panel button.a11y-btn-turn-off:hover { background: #fca5a5 !important; }

        @media (max-width: 1024px) {
            #a11y-panel .a11y-actions {
                margin-left: 0;
                width: 100%;
                justify-content: space-between;
                margin-top: 0.5rem;
            }
            #a11y-panel .a11y-group {
                flex: 1 1 auto;
                justify-content: center;
            }
        }
    `;

    if (!document.getElementById('city-library-a11y-gost-styles')) {
        document.head.appendChild(style);
    }

    // Default settings object
    const defaultSettings = {
        active: false,
        size: 'normal',
        theme: 'bw',
        font: 'sans',
        spacing: 'normal',
        images: 'color'
    };

    let currentSettings = { ...defaultSettings };

    // Load from local storage
    try {
        const saved = localStorage.getItem('city_library_a11y_settings');
        if (saved) {
            currentSettings = { ...defaultSettings, ...JSON.parse(saved) };
        }
    } catch (e) {
        console.error('Failed to parse a11y settings', e);
    }

    // Create Compact Toolbar HTML
    const panelHTML = `
        <div id="a11y-panel" aria-label="Панель настроек для слабовидящих" role="dialog" aria-modal="false">
            <div class="a11y-panel-inner">

                <div class="a11y-group">
                    <span class="a11y-label">Размер:</span>
                    <button class="a11y-btn" data-action="size" data-value="normal" title="Обычный">А</button>
                    <button class="a11y-btn" data-action="size" data-value="large" title="Увеличенный">А+</button>
                    <button class="a11y-btn" data-action="size" data-value="xlarge" title="Большой">А++</button>
                </div>

                <div class="a11y-group">
                    <span class="a11y-label">Цвет:</span>
                    <button class="a11y-btn" data-action="theme" data-value="bw" title="Чёрным по белому">Ц</button>
                    <button class="a11y-btn" data-action="theme" data-value="wb" title="Белым по чёрному">Ц</button>
                    <button class="a11y-btn" data-action="theme" data-value="bb" title="Тёмно-синим по голубому">Ц</button>
                    <button class="a11y-btn" data-action="theme" data-value="br" title="Коричневым по бежевому">Ц</button>
                </div>

                <div class="a11y-group">
                    <span class="a11y-label">Шрифт:</span>
                    <button class="a11y-btn" data-action="font" data-value="sans" title="Без засечек">Без</button>
                    <button class="a11y-btn" data-action="font" data-value="serif" title="С засечками">С</button>
                </div>

                <div class="a11y-group">
                    <span class="a11y-label">Инт:</span>
                    <button class="a11y-btn" data-action="spacing" data-value="normal" title="Обычный интервал">=</button>
                    <button class="a11y-btn" data-action="spacing" data-value="medium" title="Средний интервал">==</button>
                    <button class="a11y-btn" data-action="spacing" data-value="large" title="Большой интервал">===</button>
                </div>

                <div class="a11y-group">
                    <span class="a11y-label">Изобр:</span>
                    <button class="a11y-btn" data-action="images" data-value="color" title="Цветные">Цв</button>
                    <button class="a11y-btn" data-action="images" data-value="grayscale" title="Чёрно-белые">ЧБ</button>
                    <button class="a11y-btn" data-action="images" data-value="hidden" title="Скрыть">Нет</button>
                </div>

                <div class="a11y-actions">
                    <button class="a11y-btn" id="a11y-close-panel" title="Скрыть панель">Скрыть панель</button>
                    <button class="a11y-btn a11y-btn-turn-off" id="a11y-turn-off" title="Выключить версию для слабовидящих">Выключить АА</button>
                </div>

            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('afterbegin', panelHTML);
    const panel = document.getElementById('a11y-panel');

    // Function to apply settings to DOM
    function applySettings() {
        if (!currentSettings.active) {
            document.body.classList.remove('a11y-active');
            // Remove attributes
            ['theme', 'font', 'size', 'spacing', 'images'].forEach(key => {
                document.body.removeAttribute('data-a11y-' + key);
            });
            document.body.style.paddingTop = ''; // reset padding
        } else {
            document.body.classList.add('a11y-active');
            document.body.setAttribute('data-a11y-theme', currentSettings.theme);
            document.body.setAttribute('data-a11y-font', currentSettings.font);
            document.body.setAttribute('data-a11y-size', currentSettings.size);
            document.body.setAttribute('data-a11y-spacing', currentSettings.spacing);
            document.body.setAttribute('data-a11y-images', currentSettings.images);
        }

        // Update active classes on buttons
        const buttons = panel.querySelectorAll('button[data-action]');
        buttons.forEach(btn => {
            const action = btn.getAttribute('data-action');
            const val = btn.getAttribute('data-value');
            if (currentSettings[action] === val) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        localStorage.setItem('city_library_a11y_settings', JSON.stringify(currentSettings));

        // Adjust body padding if panel is visible
        if (panel.classList.contains('is-visible')) {
            document.body.style.paddingTop = panel.offsetHeight + 'px';
        } else {
            document.body.style.paddingTop = '';
        }
    }

    // Toggle panel visibility
    accessibilityButton.addEventListener('click', (e) => {
        e.preventDefault();

        if (panel.classList.contains('is-visible')) {
            panel.classList.remove('is-visible');
        } else {
            panel.classList.add('is-visible');
            // If opening panel and settings aren't active, activate defaults
            if (!currentSettings.active) {
                currentSettings.active = true;
            }
        }
        applySettings();
    });

    // Handle setting changes
    panel.addEventListener('click', (e) => {
        const btn = e.target.closest('button[data-action]');
        if (!btn) return;

        const action = btn.getAttribute('data-action');
        const val = btn.getAttribute('data-value');

        currentSettings[action] = val;
        applySettings();
    });

    // Close panel button
    document.getElementById('a11y-close-panel').addEventListener('click', () => {
        panel.classList.remove('is-visible');
        applySettings(); // Will readjust body padding
    });

    // Turn off button
    document.getElementById('a11y-turn-off').addEventListener('click', () => {
        currentSettings = { ...defaultSettings };
        panel.classList.remove('is-visible');
        applySettings();
    });

    // Handle window resize to adjust padding
    window.addEventListener('resize', () => {
        if (panel.classList.contains('is-visible')) {
            document.body.style.paddingTop = panel.offsetHeight + 'px';
        }
    });

    // Initial apply
    if (currentSettings.active) {
        applySettings();
    }
});
