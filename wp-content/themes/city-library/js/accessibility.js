document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('accessibility-toggle');
    const rootElement = document.documentElement;

    if (!toggleButton) {
        return;
    }

    // При загрузке страницы проверяем, был ли включен режим для слабовидящих
    if (localStorage.getItem('accessibilityMode') === 'true') {
        rootElement.classList.add('accessibility-mode');
    }

    toggleButton.addEventListener('click', function() {
        // Переключаем класс
        rootElement.classList.toggle('accessibility-mode');

        // Сохраняем состояние в localStorage
        if (rootElement.classList.contains('accessibility-mode')) {
            localStorage.setItem('accessibilityMode', 'true');
        } else {
            localStorage.setItem('accessibilityMode', 'false');
        }
    });
});
