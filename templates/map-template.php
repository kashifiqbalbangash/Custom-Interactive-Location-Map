<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

$map_data = array(
    'center' => array(
        floatval($settings['center_lat']),
        floatval($settings['center_lng'])
    ),
    'zoom' => intval($settings['zoom']),
    'maxZoom' => intval($settings['max_zoom']),
    'minZoom' => intval($settings['min_zoom']),
    'maxBounds' => array(
        array(
            floatval($settings['bounds_sw_lat']),
            floatval($settings['bounds_sw_lng'])
        ),
        array(
            floatval($settings['bounds_ne_lat']),
            floatval($settings['bounds_ne_lng'])
        )
    ),
    'maxBoundsViscosity' => floatval($settings['max_bounds_viscosity']),
    'markers' => array()
);

if (!empty($markers) && is_array($markers)) {
    foreach ($markers as $marker) {
        $map_data['markers'][] = array(
            'name' => esc_html($marker['name']),
            'coords' => array(
                floatval($marker['lat']),
                floatval($marker['lng'])
            ),
            'url' => esc_url($marker['url'])
        );
    }
}
?>
<div class="interactive-location-map-container">
    <div id="map-<?php echo esc_attr($atts['id']); ?>" 
         class="interactive-location-map" 
         style="height: <?php echo esc_attr($height); ?>;">
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mapId = '<?php echo esc_js($atts['id']); ?>';
    const mapData = <?php echo json_encode($map_data); ?>;
    initDynamicMap(mapId, mapData);
});</script>