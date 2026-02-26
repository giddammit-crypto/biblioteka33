document.addEventListener('DOMContentLoaded', function() {
    const mapContainer = document.getElementById('branches-yandex-map');
    if (!mapContainer || typeof ymaps === 'undefined') return;

    ymaps.ready(init);

    function init() {
        const data = window.branches_map_data || {};
        const branches = data.branches || [];
        const center = data.center || [56.145, 40.405];
        const zoom = data.zoom || 12;

        const myMap = new ymaps.Map("branches-yandex-map", {
            center: center,
            zoom: zoom,
            controls: ['zoomControl', 'fullscreenControl']
        });

        // Create a clusterer
        const clusterer = new ymaps.Clusterer({
            preset: 'islands#invertedDarkGreenClusterIcons',
            groupByCoordinates: false,
            clusterDisableClickZoom: false,
            clusterHideIconOnBalloonOpen: false,
            geoObjectHideIconOnBalloonOpen: false
        });

        const placemarks = [];

        branches.forEach(branch => {
            const placemark = new ymaps.Placemark(branch.coords, {
                balloonContentHeader: `<h3 style="color: #0b7930; font-weight: bold;">${branch.name}</h3>`,
                balloonContentBody: `
                    <p><strong>Адрес:</strong> ${branch.address}</p>
                    <p><strong>Телефон:</strong> ${branch.phone}</p>
                `,
                balloonContentFooter: 'Центральная городская библиотека',
                hintContent: branch.name
            }, {
                preset: 'islands#darkGreenIcon'
            });
            placemarks.push(placemark);
        });

        clusterer.add(placemarks);
        myMap.geoObjects.add(clusterer);

        myMap.behaviors.disable('scrollZoom');

        if (placemarks.length > 0) {
             myMap.setBounds(clusterer.getBounds(), { checkZoomRange: true });
        }
    }
});
