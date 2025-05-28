<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Save settings
if (isset($_POST['dynamic_map_settings'])) {
    check_admin_referer('dynamic_map_settings');
    update_option('dynamic_map_settings', $_POST['dynamic_map_settings']);
    echo '<div class="notice notice-success"><p>' . __('Settings saved successfully!', 'dynamic-map-plugin') . '</p></div>';
}

$settings = get_option('dynamic_map_settings', array(
    'default_zoom' => 5,
    'default_center' => '37.8,-96',
    'max_zoom' => 10,
    'min_zoom' => 4
));
?>

<div class="wrap">
    <h1><?php _e('Map Settings', 'dynamic-map-plugin'); ?></h1>
    
    <form method="post" action="">
        <?php wp_nonce_field('dynamic_map_settings'); ?>
        
        <table class="form-table">
            <tr>
                <th scope="row"><?php _e('Default Zoom Level', 'dynamic-map-plugin'); ?></th>
                <td>
                    <input type="number" name="dynamic_map_settings[default_zoom]" 
                           value="<?php echo esc_attr($settings['default_zoom']); ?>" min="1" max="20">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e('Default Center (lat,lng)', 'dynamic-map-plugin'); ?></th>
                <td>
                    <input type="text" name="dynamic_map_settings[default_center]" 
                           value="<?php echo esc_attr($settings['default_center']); ?>">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e('Maximum Zoom Level', 'dynamic-map-plugin'); ?></th>
                <td>
                    <input type="number" name="dynamic_map_settings[max_zoom]" 
                           value="<?php echo esc_attr($settings['max_zoom']); ?>" min="1" max="20">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e('Minimum Zoom Level', 'dynamic-map-plugin'); ?></th>
                <td>
                    <input type="number" name="dynamic_map_settings[min_zoom]" 
                           value="<?php echo esc_attr($settings['min_zoom']); ?>" min="1" max="20">
                </td>
            </tr>
        </table>
        
        <?php submit_button(); ?>
    </form>
</div>