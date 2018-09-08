<?php
/*
Plugin Name:  Wowhead Tooltips
Plugin URI:   http://dailyquest.it
Description:  The Wowhead Tooltips plugin made for the Dailyquest Website
Version:      0.1
Author:       Francesco Rho
Author URI:   https://rhofrances.co/
License:      MIT License
License URI:  https://opensource.org/licenses/MIT
Text Domain:  wowhead-tooltips
Domain Path:  /languages
 */
defined('ABSPATH') or die('No script kiddies please!');

class WowheadTooltips
{
    public function __construct()
    {
        $this->plugin_domain = 'wowhead-tooltips';
        $this->version = '1.0';
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        if (is_admin()) {
            add_action('init', array($this, 'setup_tinymce_plugin'));
        }
    }

    /**
     * Proper way to enqueue scripts and styles.
     */
    public function enqueue_scripts()
    {
        wp_enqueue_style($this->plugin_domain . '-style', plugins_url('style.css', __FILE__));
        wp_enqueue_script($this->plugin_domain . '-settings', plugins_url('wowhead-tooltip-settings.js', __FILE__), array(), '1.0.0', false);
        wp_enqueue_script($this->plugin_domain, '//wow.zamimg.com/widgets/power.js', array(), '1.0.0', false);
    }

    /**
     * Check if the current user can edit Posts or Pages, and is using the Visual Editor
     * If so, add some filters so we can register our plugin
     */
    public function setup_tinymce_plugin()
    {

        // Check if the logged in WordPress User can edit Posts or Pages
        // If not, don't register our TinyMCE plugin

        if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return;
        }

        // Check if the logged in WordPress User has the Visual Editor enabled
        // If not, don't register our TinyMCE plugin
        if (get_user_option('rich_editing') !== 'true') {
            return;
        }

        // Setup some filters
        add_filter('mce_external_plugins', array(&$this, 'add_tinymce_plugin'));
        add_filter('mce_buttons', array(&$this, 'add_tinymce_toolbar_button'));

    }

    /**
     * Adds a TinyMCE plugin compatible JS file to the TinyMCE / Visual Editor instance
     *
     * @param array $plugin_array Array of registered TinyMCE Plugins
     * @return array Modified array of registered TinyMCE Plugins
     */
    public function add_tinymce_plugin($plugin_array)
    {

        $plugin_array['wowhead_tooltip_class'] = plugin_dir_url(__FILE__) . 'wowhead-tinymce.js';
        return $plugin_array;

    }

    /**
     * Adds a button to the TinyMCE / Visual Editor which the user can click
     * to insert a link with a custom CSS class.
     *
     * @param array $buttons Array of registered TinyMCE Buttons
     * @return array Modified array of registered TinyMCE Buttons
     */
    public function add_tinymce_toolbar_button($buttons)
    {
        array_push($buttons, 'wowhead_tooltip_button');
        return $buttons;
    }

}

new WowheadTooltips();
