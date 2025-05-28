<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <h1><?php _e('Dynamic Maps', 'dynamic-map-plugin'); ?></h1>
    
    <div class="dynamic-maps-container">
        <div class="dynamic-maps-list">
            <h2><?php _e('Your Maps', 'dynamic-map-plugin'); ?></h2>
            <a href="<?php echo admin_url('post-new.php?post_type=dynamic_map'); ?>" class="button button-primary">
                <?php _e('Create New Map', 'dynamic-map-plugin'); ?>
            </a>
            
            <?php
            $maps = get_posts(array(
                'post_type' => 'dynamic_map',
                'posts_per_page' => -1
            ));
            
            if ($maps): ?>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th><?php _e('Map Name', 'dynamic-map-plugin'); ?></th>
                            <th><?php _e('Shortcode', 'dynamic-map-plugin'); ?></th>
                            <th><?php _e('Actions', 'dynamic-map-plugin'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($maps as $map): ?>
                            <tr>
                                <td><?php echo esc_html($map->post_title); ?></td>
                                <td><code>[dynamic_map id="<?php echo $map->ID; ?>"]</code></td>
                                <td>
                                    <a href="<?php echo get_edit_post_link($map->ID); ?>" class="button">
                                        <?php _e('Edit', 'dynamic-map-plugin'); ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p><?php _e('No maps created yet.', 'dynamic-map-plugin'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>