<?php

// General

define('DARK_VISITORS_WORDPRESS_PLUGIN_VERSION', '1.28.0');
define('DARK_VISITORS_LOGO_PATH', plugin_dir_path(DARK_VISITORS_PLUGIN_FILE) . 'assets/logo.svg');
define('DARK_VISITORS_LOGO_URL', plugin_dir_url(DARK_VISITORS_PLUGIN_FILE) . 'assets/logo.svg');
define('DARK_VISITORS_BLOCKED_STATUS_CODE', 403);

// File System

define('DARK_VISITORS_FILES_DIRECTORY', wp_upload_dir()['basedir'] . '/dark-visitors');

// Settings Groups

define('DARK_VISITORS_SETTINGS_GROUP', 'dark_visitors_settings_group');

// Setting Options

define('DARK_VISITORS_ACCESS_TOKEN', 'dark_visitors_access_token');
define('DARK_VISITORS_IS_ANALYTICS_ENABLED', 'dark_visitors_is_analytics_enabled');
define('DARK_VISITORS_IS_ENFORCE_ROBOTS_TXT_ENABLED', 'dark_visitors_is_enforce_robots_txt_enabled');
define('DARK_VISITORS_SETTINGS_LAST_SAVED', 'dark_visitors_settings_last_saved');
define('DARK_VISITORS_IS_BLOCK_AI_ASSISTANTS_ENABLED', 'dark_visitors_is_block_ai_assistants_enabled');
define('DARK_VISITORS_IS_BLOCK_AI_DATA_SCRAPERS_ENABLED', 'dark_visitors_is_block_ai_data_scrapers_enabled');
define('DARK_VISITORS_IS_BLOCK_AI_SEARCH_CRAWLERS_ENABLED', 'dark_visitors_is_block_ai_search_crawlers_enabled');
define('DARK_VISITORS_IS_BLOCK_ARCHIVERS_ENABLED', 'dark_visitors_is_block_archivers_enabled');
define('DARK_VISITORS_IS_BLOCK_INTELLIGENCE_GATHERERS_ENABLED', 'dark_visitors_is_block_intelligence_gatherers_enabled');
define('DARK_VISITORS_IS_BLOCK_SCRAPERS_ENABLED', 'dark_visitors_is_block_scrapers_enabled');
define('DARK_VISITORS_IS_BLOCK_SEO_CRAWLERS_ENABLED', 'dark_visitors_is_block_seo_crawlers_enabled');
define('DARK_VISITORS_IS_BLOCK_UNDOCUMENTED_AI_AGENTS_ENABLED', 'dark_visitors_is_block_undocumented_ai_agents_enabled');

// Cached Item Transients

define('DARK_VISITORS_USER_AGENT_STRINGS_LIST', 'dark_visitors_user_agent_strings_list');
define('DARK_VISITORS_ROBOTS_TXT', 'dark_visitors_robots_txt');
define('DARK_VISITORS_USER', 'dark_visitors_user');

// Cron Job Events

define('DARK_VISITORS_DAILY_CRON_EVENT', 'dark_visitors_daily_cron_event');
define('DARK_VISITORS_EVERY_FIVE_MINUTES_CRON_EVENT', 'dark_visitors_every_five_minutes_cron_event');

// Analytics Files

define('DARK_VISITORS_VISITS_LOG_PATH', DARK_VISITORS_FILES_DIRECTORY . '/visits.log');

// Analytics Triggers

define('DARK_VISITORS_VISITS_LOG_SIZE_MAX_IN_BYTES', 16777216);
define('DARK_VISITORS_VISITS_LOG_UPLOAD_INTERVAL_IN_SECONDS', 30);

// Analytics Options

define('DARK_VISITORS_LAST_VISITS_LOG_UPLOAD_TIME', 'dark_visitors_last_visits_log_upload_time');