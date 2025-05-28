<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <h1><?php _e('Documentation', 'dynamic-map-plugin'); ?></h1>
    
    <div class="dynamic-map-docs">
        <h2><?php _e('Getting Started', 'dynamic-map-plugin'); ?></h2>
        <p><?php _e('Welcome to the Dynamic Map Plugin documentation. Here you\'ll find everything you need to know about creating and customizing your maps.', 'dynamic-map-plugin'); ?></p>
        
        <h3><?php _e('Basic Usage', 'dynamic-map-plugin'); ?></h3>
        <p><?php _e('To create a new map:', 'dynamic-map-plugin'); ?></p>
        <ol>
            <li><?php _e('Go to Dynamic Maps > Add New', 'dynamic-map-plugin'); ?></li>
            <li><?php _e('Enter a title for your map', 'dynamic-map-plugin'); ?></li>
            <li><?php _e('Add markers and customize settings', 'dynamic-map-plugin'); ?></li>
            <li><?php _e('Publish your map', 'dynamic-map-plugin'); ?></li>
        </ol>
        
        <h3><?php _e('Shortcode Usage', 'dynamic-map-plugin'); ?></h3>
        <p><?php _e('Basic shortcode:', 'dynamic-map-plugin'); ?></p>
        <pre><code>[interactive_location id="377"]</code></pre>
        
        <p><?php _e('Shortcode with options:', 'dynamic-map-plugin'); ?></p>
        <pre><code>[interactive_location id="377" center="37.8,-96" zoom="5" height="400px"]</code></pre>
        
        <h3><?php _e('Available Parameters', 'dynamic-map-plugin'); ?></h3>
        <ul>
            <li><code>id</code>: <?php _e('The ID of your map (required)', 'dynamic-map-plugin'); ?></li>
            <li><code>center</code>: <?php _e('Center coordinates (latitude,longitude)', 'dynamic-map-plugin'); ?></li>
            <li><code>zoom</code>: <?php _e('Initial zoom level (1-20)', 'dynamic-map-plugin'); ?></li>
            <li><code>height</code>: <?php _e('Map height (default: 400px)', 'dynamic-map-plugin'); ?></li>
        </ul>
    </div>
</div>