<?php

/*
Plugin Name: Known Agents
Plugin URI: https://knownagents.com/
Description: Track crawlers, scrapers, LLM assistants, and AI agents on your website. Generate a robots.txt that blocks AI bots. Formerly Dark Visitors.
Version: 1.28.0
Requires at least: 5.0
Requires PHP: 7.0
Author: Known Agents
Author URI: https://knownagents.com/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
*/

if (!defined('ABSPATH')) {
    exit;
}

define('DARK_VISITORS_PLUGIN_FILE', __FILE__);

require_once plugin_dir_path(__FILE__) . 'includes/constants.php';
require_once plugin_dir_path(__FILE__) . 'includes/file-system.php';
require_once plugin_dir_path(__FILE__) . 'includes/cron.php';
require_once plugin_dir_path(__FILE__) . 'includes/variables.php';
require_once plugin_dir_path(__FILE__) . 'includes/settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/robots-txt.php';
require_once plugin_dir_path(__FILE__) . 'includes/blocking.php';
require_once plugin_dir_path(__FILE__) . 'includes/analytics.php';
