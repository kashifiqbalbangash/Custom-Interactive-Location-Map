=== Interactive Location Map ===
Author: kashif iqbal
Tags: map, leaflet, interactive map, custom markers, location, mapping  
Requires at least: 5.0  
Tested up to: 6.5  
Requires PHP: 7.2  
Stable tag: 1.0.0  
License: GPLv2 or later  
License URI: https://www.gnu.org/licenses/gpl-2.0.html  

A dynamic location mapping plugin that lets you create interactive maps with custom markers, zoom settings, and boundary constraints.

== Description ==

**Interactive Location Map** is a user-friendly plugin to build fully customizable, responsive maps using Leaflet.js. Ideal for businesses, directories, or anyone needing to visualize locations interactively.

**Key Features:**

- Create unlimited maps as custom post types
- Add multiple markers with custom titles and coordinates
- Set map center, zoom levels, and bounding box
- Restrict panning outside set boundaries
- Use shortcode `[interactive_location id=MAP_ID]` to embed maps
- Admin settings panel for global defaults
- Interactive preview in the admin area
- Supports both frontend and backend scripts/styles

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/interactive-location-map/` directory or install via WordPress Plugins screen.
2. Activate the plugin through the ‘Plugins’ menu.
3. Go to **Location Maps** > **Add New Map** to create your first map.
4. Use the shortcode `[interactive_location id=MAP_ID]` to embed it on any page or post.
5. Configure global defaults under **Settings > Map Settings**.

== Shortcode ==

`[interactive_location id=MAP_ID]`  
- Replace `MAP_ID` with the ID of the map post you created.

== Frequently Asked Questions ==

= Can I add multiple maps? =  
Yes, you can create as many location maps as you need using the custom post type interface.

= Is this plugin compatible with page builders? =  
Yes, the shortcode works with all major page builders like Elementor, WPBakery, and Gutenberg.

= Does it use Google Maps? =  
No, it uses [Leaflet.js](https://leafletjs.com/) – a free, open-source JavaScript library for interactive maps.

== Screenshots ==

1. Admin map settings interface  
2. Marker input UI  
3. Map preview in the editor  
4. Map display on the frontend

== Changelog ==

= 1.0.0 =  
* Initial release:  
  - Custom post type for maps  
  - Meta boxes for map settings and markers  
  - Shortcode rendering  
  - Admin settings page  

== Upgrade Notice ==

= 1.0.0 =  
First release – no upgrade needed.

== Credits ==

Developed by [Kashif Iqbal](https://www.linkedin.com/in/kashif-iqbal-pak)

== License ==

This plugin is licensed under the GPLv2 or later.
