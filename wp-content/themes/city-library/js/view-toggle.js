document.addEventListener('DOMContentLoaded', function() {
    const gridViewButton = document.getElementById('grid-view-button');
    const listViewButton = document.getElementById('list-view-button');
    const postsContainer = document.getElementById('posts-container');

    if (!gridViewButton || !listViewButton || !postsContainer) {
        return;
    }

    // При загрузке страницы проверяем сохраненный вид
    const currentView = localStorage.getItem('newsView') || 'grid';
    postsContainer.classList.add(currentView + '-view');
    updateButtonStates(currentView);


    gridViewButton.addEventListener('click', function() {
        if (!postsContainer.classList.contains('grid-view')) {
            postsContainer.classList.remove('list-view');
            postsContainer.classList.add('grid-view');
            localStorage.setItem('newsView', 'grid');
            updateButtonStates('grid');
        }
    });

    listViewButton.addEventListener('click', function() {
        if (!postsContainer.classList.contains('list-view')) {
            postsContainer.classList.remove('grid-view');
            postsContainer.classList.add('list-view');
            localStorage.setItem('newsView', 'list');
            updateButtonStates('list');
        }
    });

    function updateButtonStates(activeView) {
        if (activeView === 'grid') {
            gridViewButton.classList.add('bg-white', 'dark:bg-slate-700', 'shadow-sm');
            gridViewButton.classList.remove('text-slate-400');
            listViewButton.classList.remove('bg-white', 'dark:bg-slate-700', 'shadow-sm');
            listViewButton.classList.add('text-slate-400');
        } else {
            listViewButton.classList.add('bg-white', 'dark:bg-slate-700', 'shadow-sm');
            listViewButton.classList.remove('text-slate-400');
            gridViewButton.classList.remove('bg-white', 'dark:bg-slate-700', 'shadow-sm');
            gridViewButton.classList.add('text-slate-400');
        }
    }
});
