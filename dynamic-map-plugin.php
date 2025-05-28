<?php
/**
 * Plugin Name: Interactive Location Map
 * Plugin URI: na
 * Description: A dynamic location mapping plugin that allows users to create interactive maps with custom markers, boundaries, and location details.
 * Version: 1.0.0
 * Author: Kashif Iqbal, (developer.kashifiqbal@gmail.com)
 * Author URI: https://www.linkedin.com/in/kashif-iqbal-pak
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class InteractiveLocationMap {
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('init', array($this, 'init'));
        add_action('admin_menu', array($this, 'addAdminMenu'));
        add_action('add_meta_boxes', array($this, 'addMapMetaBoxes'));
        add_action('save_post', array($this, 'saveMapData'));
        add_shortcode('interactive_location', array($this, 'mapShortcode'));
        add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueAdminScripts'));
    }

    public function init() {
        register_post_type('location_map', array(
            'labels' => array(
                'name' => __('Location Maps', 'interactive-location-map'),
                'singular_name' => __('Location Map', 'interactive-location-map'),
                'add_new' => __('Add New Map', 'interactive-location-map'),
                'add_new_item' => __('Add New Location Map', 'interactive-location-map'),
                'edit_item' => __('Edit Location Map', 'interactive-location-map'),
                'new_item' => __('New Location Map', 'interactive-location-map'),
                'view_item' => __('View Location Map', 'interactive-location-map'),
                'search_items' => __('Search Location Maps', 'interactive-location-map'),
                'not_found' => __('No location maps found', 'interactive-location-map'),
                'not_found_in_trash' => __('No location maps found in trash', 'interactive-location-map'),
                'menu_name' => __('Location Maps', 'interactive-location-map')
            ),
            'public' => true,
            'has_archive' => false,
            'supports' => array('title'),
            'menu_icon' => 'dashicons-location',
            'rewrite' => array('slug' => 'location-map')
        ));
    }

    public function addMapMetaBoxes() {
        add_meta_box(
            'location_map_settings',
            __('Map Settings', 'interactive-location-map'),
            array($this, 'renderMapSettings'),
            'location_map',
            'normal',
            'high'
        );

        add_meta_box(
            'location_map_markers',
            __('Map Markers', 'interactive-location-map'),
            array($this, 'renderMapMarkers'),
            'location_map',
            'normal',
            'high'
        );
    }

    public function renderMapSettings($post) {
        wp_nonce_field('location_map_settings', 'location_map_settings_nonce');
        
        $settings = get_post_meta($post->ID, 'map_settings', true);
        $defaults = array(
            'center_lat' => '37.8',
            'center_lng' => '-96',
            'zoom' => '5',
            'max_zoom' => '10',
            'min_zoom' => '4',
            'bounds_sw_lat' => '24.396308',
            'bounds_sw_lng' => '-125.0',
            'bounds_ne_lat' => '49.384358',
            'bounds_ne_lng' => '-66.93457',
            'max_bounds_viscosity' => '1.0',
            'height' => '400'
        );
        
        $settings = wp_parse_args($settings, $defaults);
        ?>
        <div class="map-settings-container">
            <div class="map-setting-row">
                <label>
                    <?php _e('Center Latitude:', 'interactive-location-map'); ?>
                    <input type="number" step="any" name="map_settings[center_lat]" 
                           value="<?php echo esc_attr($settings['center_lat']); ?>" class="map-setting">
                </label>
                <label>
                    <?php _e('Center Longitude:', 'interactive-location-map'); ?>
                    <input type="number" step="any" name="map_settings[center_lng]" 
                           value="<?php echo esc_attr($settings['center_lng']); ?>" class="map-setting">
                </label>
            </div>

            <div class="map-setting-row">
                <label>
                    <?php _e('Initial Zoom:', 'interactive-location-map'); ?>
                    <input type="number" name="map_settings[zoom]" min="1" max="20" 
                           value="<?php echo esc_attr($settings['zoom']); ?>" class="map-setting">
                </label>
                <label>
                    <?php _e('Max Zoom:', 'interactive-location-map'); ?>
                    <input type="number" name="map_settings[max_zoom]" min="1" max="20" 
                           value="<?php echo esc_attr($settings['max_zoom']); ?>" class="map-setting">
                </label>
                <label>
                    <?php _e('Min Zoom:', 'interactive-location-map'); ?>
                    <input type="number" name="map_settings[min_zoom]" min="1" max="20" 
                           value="<?php echo esc_attr($settings['min_zoom']); ?>" class="map-setting">
                </label>
            </div>

            <h4><?php _e('Map Boundaries', 'interactive-location-map'); ?></h4>
            <div class="map-setting-row">
                <label>
                    <?php _e('SW Latitude:', 'interactive-location-map'); ?>
                    <input type="number" step="any" name="map_settings[bounds_sw_lat]" 
                           value="<?php echo esc_attr($settings['bounds_sw_lat']); ?>" class="map-setting">
                </label>
                <label>
                    <?php _e('SW Longitude:', 'interactive-location-map'); ?>
                    <input type="number" step="any" name="map_settings[bounds_sw_lng]" 
                           value="<?php echo esc_attr($settings['bounds_sw_lng']); ?>" class="map-setting">
                </label>
            </div>
            <div class="map-setting-row">
                <label>
                    <?php _e('NE Latitude:', 'interactive-location-map'); ?>
                    <input type="number" step="any" name="map_settings[bounds_ne_lat]" 
                           value="<?php echo esc_attr($settings['bounds_ne_lat']); ?>" class="map-setting">
                </label>
                <label>
                    <?php _e('NE Longitude:', 'interactive-location-map'); ?>
                    <input type="number" step="any" name="map_settings[bounds_ne_lng]" 
                           value="<?php echo esc_attr($settings['bounds_ne_lng']); ?>" class="map-setting">
                </label>
            </div>

            <div class="map-setting-row">
                <label>
                    <?php _e('Max Bounds Viscosity:', 'interactive-location-map'); ?>
                    <input type="number" step="0.1" min="0" max="1" name="map_settings[max_bounds_viscosity]" 
                           value="<?php echo esc_attr($settings['max_bounds_viscosity']); ?>" class="map-setting">
                </label>
                <label>
                    <?php _e('Map Height (px):', 'interactive-location-map'); ?>
                    <input type="number" name="map_settings[height]" min="200" 
                           value="<?php echo esc_attr($settings['height']); ?>" class="map-setting">
                </label>
            </div>

            <div id="map-preview"></div>
        </div>
        <?php
    }

    public function renderMapMarkers($post) {
        wp_nonce_field('location_map_markers', 'location_map_markers_nonce');
        
        $markers = get_post_meta($post->ID, 'map_markers', true);
        if (!is_array($markers)) {
            $markers = array();
        }
        ?>
        <div class="markers-container">
            <?php foreach ($markers as $index => $marker): ?>
            <div class="marker-row">
                <div class="marker-field">
                    <label><?php _e('Name:', 'interactive-location-map'); ?></label>
                    <input type="text" name="map_markers[<?php echo $index; ?>][name]" 
                           value="<?php echo esc_attr($marker['name']); ?>" class="marker-name">
                </div>
                <div class="marker-field">
                    <label><?php _e('Latitude:', 'interactive-location-map'); ?></label>
                    <input type="number" step="any" name="map_markers[<?php echo $index; ?>][lat]" 
                           value="<?php echo esc_attr($marker['lat']); ?>" class="marker-lat">
                </div>
                <div class="marker-field">
                    <label><?php _e('Longitude:', 'interactive-location-map'); ?></label>
                    <input type="number" step="any" name="map_markers[<?php echo $index; ?>][lng]" 
                           value="<?php echo esc_attr($marker['lng']); ?>" class="marker-lng">
                </div>
                <div class="marker-field">
                    <label><?php _e('URL:', 'interactive-location-map'); ?></label>
                    <input type="url" name="map_markers[<?php echo $index; ?>][url]" 
                           value="<?php echo esc_url($marker['url']); ?>" class="marker-url">
                </div>
                <button type="button" class="button remove-marker"><?php _e('Remove', 'interactive-location-map'); ?></button>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="button button-primary add-marker"><?php _e('Add Marker', 'interactive-location-map'); ?></button>
        
        <script type="text/template" id="marker-template">
            <div class="marker-row">
                <div class="marker-field">
                    <label><?php _e('Name:', 'interactive-location-map'); ?></label>
                    <input type="text" name="map_markers[{{index}}][name]" class="marker-name">
                </div>
                <div class="marker-field">
                    <label><?php _e('Latitude:', 'interactive-location-map'); ?></label>
                    <input type="number" step="any" name="map_markers[{{index}}][lat]" class="marker-lat">
                </div>
                <div class="marker-field">
                    <label><?php _e('Longitude:', 'interactive-location-map'); ?></label>
                    <input type="number" step="any" name="map_markers[{{index}}][lng]" class="marker-lng">
                </div>
                <div class="marker-field">
                    <label><?php _e('URL:', 'interactive-location-map'); ?></label>
                    <input type="url" name="map_markers[{{index}}][url]" class="marker-url">
                </div>
                <button type="button" class="button remove-marker"><?php _e('Remove', 'interactive-location-map'); ?></button>
            </div>
        </script>
        <?php
    }

    public function saveMapData($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;
        
        // Save map settings
        if (isset($_POST['location_map_settings_nonce']) && 
            wp_verify_nonce($_POST['location_map_settings_nonce'], 'location_map_settings')) {
            if (isset($_POST['map_settings'])) {
                update_post_meta($post_id, 'map_settings', $_POST['map_settings']);
            }
        }
        
        // Save markers
        if (isset($_POST['location_map_markers_nonce']) && 
            wp_verify_nonce($_POST['location_map_markers_nonce'], 'location_map_markers')) {
            if (isset($_POST['map_markers'])) {
                update_post_meta($post_id, 'map_markers', $_POST['map_markers']);
            }
        }
    }

    public function addAdminMenu() {
        add_submenu_page(
            'edit.php?post_type=location_map',
            __('Settings', 'interactive-location-map'),
            __('Settings', 'interactive-location-map'),
            'manage_options',
            'location-map-settings',
            array($this, 'renderSettingsPage')
        );

        add_submenu_page(
            'edit.php?post_type=location_map',
            __('Documentation', 'interactive-location-map'),
            __('Documentation', 'interactive-location-map'),
            'manage_options',
            'location-map-docs',
            array($this, 'renderDocsPage')
        );
    }

    public function enqueueScripts() {
        wp_enqueue_style('leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');
        wp_enqueue_script('leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', true);
        wp_enqueue_script('interactive-location-map', plugin_dir_url(__FILE__) . 'js/dynamic-map.js', array('leaflet'), '1.0.0', true);
        wp_enqueue_style('interactive-location-map', plugin_dir_url(__FILE__) . 'css/dynamic-map.css');
    }

    public function enqueueAdminScripts($hook) {
        if ('post.php' === $hook || 'post-new.php' === $hook) {
            if ('location_map' === get_post_type()) {
                wp_enqueue_style('interactive-location-map-admin', plugin_dir_url(__FILE__) . 'css/admin.css');
                wp_enqueue_script('interactive-location-map-admin', plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery'), '1.0.0', true);
            }
        }
    }

    public function mapShortcode($atts) {
        $defaults = array(
            'id' => '',
            'height' => ''
        );
        
        $atts = shortcode_atts($defaults, $atts, 'interactive_location');
        
        if (empty($atts['id'])) {
            return '<p>' . __('Please provide a map ID.', 'interactive-location-map') . '</p>';
        }
        
        $settings = get_post_meta($atts['id'], 'map_settings', true);
        $markers = get_post_meta($atts['id'], 'map_markers', true);
        
        if (empty($settings)) {
            return '<p>' . __('Map not found.', 'interactive-location-map') . '</p>';
        }
        
        $height = !empty($atts['height']) ? $atts['height'] : $settings['height'] . 'px';
        
        ob_start();
        include plugin_dir_path(__FILE__) . 'templates/map-template.php';
        return ob_get_clean();
    }

    public function renderSettingsPage() {
        include plugin_dir_path(__FILE__) . 'templates/settings-page.php';
    }

    public function renderDocsPage() {
        include plugin_dir_path(__FILE__) . 'templates/docs-page.php';
    }
}

// Initialize plugin
InteractiveLocationMap::getInstance();