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
Text Domain:  hearthstone-archive
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

}

new WowheadTooltips();
