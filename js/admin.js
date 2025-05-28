jQuery(document).ready(function($) {
    let markerCount = $('.marker-row').length;

    // Handle marker addition
    $('.add-marker').on('click', function(e) {
        e.preventDefault();
        const template = $('#marker-template').html();
        const newRow = template.replace(/\{\{index\}\}/g, markerCount++);
        $('.markers-container').append(newRow);
        updateMapPreview();
    });

    // Handle marker removal
    $(document).on('click', '.remove-marker', function(e) {
        e.preventDefault();
        $(this).closest('.marker-row').remove();
        updateMapPreview();
    });

    // Initialize map preview
    let previewMap = null;
    if ($('#map-preview').length) {
        initMapPreview();
    }

    function initMapPreview() {
        const defaultLat = $('input[name="map_settings[center_lat]"]').val() || 37.8;
        const defaultLng = $('input[name="map_settings[center_lng]"]').val() || -96;
        const defaultZoom = $('input[name="map_settings[zoom]"]').val() || 5;

        previewMap = L.map('map-preview', {
            center: [defaultLat, defaultLng],
            zoom: defaultZoom
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(previewMap);

        // Update preview when any setting changes
        $('.map-setting, .marker-name, .marker-lat, .marker-lng, .marker-url').on('change input', function() {
            updateMapPreview();
        });

        // Initial preview update
        updateMapPreview();
    }

    function updateMapPreview() {
        if (!previewMap) return;

        // Update map settings
        const centerLat = parseFloat($('input[name="map_settings[center_lat]"]').val()) || 37.8;
        const centerLng = parseFloat($('input[name="map_settings[center_lng]"]').val()) || -96;
        const zoom = parseInt($('input[name="map_settings[zoom]"]').val()) || 5;

        previewMap.setView([centerLat, centerLng], zoom);

        // Clear existing markers
        previewMap.eachLayer((layer) => {
            if (layer instanceof L.Marker) {
                previewMap.removeLayer(layer);
            }
        });

        // Add markers from form
        $('.marker-row').each(function() {
            const lat = parseFloat($(this).find('.marker-lat').val());
            const lng = parseFloat($(this).find('.marker-lng').val());
            const name = $(this).find('.marker-name').val();
            const url = $(this).find('.marker-url').val();
            
            if (lat && lng) {
                const marker = L.marker([lat, lng]).addTo(previewMap);
                
                if (url) {
                    marker.bindPopup(`<a href="${url}" target="_blank"><strong>${name}</strong></a>`);
                } else {
                    marker.bindPopup(`<strong>${name}</strong>`);
                }
                
                marker.bindTooltip(`<strong>${name}</strong>`, {
                    permanent: true,
                    direction: 'top',
                    className: 'city-label'
                }).openTooltip();
            }
        });
    }
});