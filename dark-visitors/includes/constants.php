<?php

// General

define('DARK_VISITORS_WORDPRESS_PLUGIN_VERSION', '1.32.0');
define('DARK_VISITORS_LOGO_PATH', plugin_dir_path(DARK_VISITORS_PLUGIN_FILE) . 'assets/logo.svg');
define('DARK_VISITORS_LOGO_URL', plugin_dir_url(DARK_VISITORS_PLUGIN_FILE) . 'assets/logo.svg');
define('DARK_VISITORS_BLOCKED_STATUS_CODE', 403);

// Settings Groups

define('DARK_VISITORS_SETTINGS_GROUP', 'dark_visitors_settings_group');

// Setting Options

define('DARK_VISITORS_ACCESS_TOKEN', 'dark_visitors_access_token');
define('DARK_VISITORS_IS_ANALYTICS_ENABLED', 'dark_visitors_is_analytics_enabled');
define('DARK_VISITORS_IS_ENFORCE_ROBOTS_TXT_ENABLED', 'dark_visitors_is_enforce_robots_txt_enabled');
define('DARK_VISITORS_SETTINGS_LAST_SAVED', 'dark_visitors_settings_last_saved');
define('DARK_VISITORS_IS_BLOCK_AI_ASSISTANTS_ENABLED', 'dark_visitors_is_block_ai_assistants_enabled');
define('DARK_VISITORS_IS_BLOCK_AI_DATA_PROVIDERS_ENABLED', 'dark_visitors_is_block_ai_data_providers_enabled');
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
define('DARK_VISITORS_HOURLY_CRON_EVENT', 'dark_visitors_hourly_cron_event');

// Analytics Visits

define('DARK_VISITORS_LOG_FLUSH_INTERVAL_IN_SECONDS', 15);

// Analytics Cache Visits

define('DARK_VISITORS_CACHE_GROUP', 'dark_visitors');
define('DARK_VISITORS_CACHE_CURRENT_VISIT_INDEX_KEY', 'dark_visitors_current_visit_index');
define('DARK_VISITORS_CACHE_LAST_FLUSHED_VISIT_INDEX_KEY', 'dark_visitors_last_flushed_visit_index');
define('DARK_VISITORS_CACHE_VISIT_KEY_PREFIX', 'dark_visitors_visit_');
define('DARK_VISITORS_CACHE_LOG_FLUSH_LOCK_KEY', 'dark_visitors_log_flush_lock');
define('DARK_VISITORS_CACHE_VISIT_TTL_IN_SECONDS', MINUTE_IN_SECONDS);
define('DARK_VISITORS_CACHE_LOG_FLUSH_MAX_VISITS', 10000);

// Analytics File Visits

define('DARK_VISITORS_FILE_VISITS_LOG_PATH', trailingslashit(get_temp_dir()) . 'dark-visitors-visits-' . md5(ABSPATH . '|' . get_current_blog_id()) . '.ndjson');
define('DARK_VISITORS_FILE_LAST_FLUSH_PATH', trailingslashit(get_temp_dir()) . 'dark-visitors-visits-' . md5(ABSPATH . '|' . get_current_blog_id()) . '.flush');
define('DARK_VISITORS_FILE_VISITS_LOG_SIZE_MAX_IN_BYTES', 8 * MB_IN_BYTES);
