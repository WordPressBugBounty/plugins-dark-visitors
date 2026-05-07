<?php

// Activation

function dark_visitors_start_cron_jobs_if_needed() {
    if (!wp_next_scheduled(DARK_VISITORS_DAILY_CRON_EVENT)) {
        wp_schedule_event(time(), 'daily', DARK_VISITORS_DAILY_CRON_EVENT);
    }

    if (!wp_next_scheduled(DARK_VISITORS_HOURLY_CRON_EVENT)) {
        wp_schedule_event(time(), 'hourly', DARK_VISITORS_HOURLY_CRON_EVENT);
    }
}

add_action('init', 'dark_visitors_start_cron_jobs_if_needed');

// Deactivation

function dark_visitors_stop_cron_jobs() {
    wp_clear_scheduled_hook(DARK_VISITORS_DAILY_CRON_EVENT);
    wp_clear_scheduled_hook(DARK_VISITORS_HOURLY_CRON_EVENT);
}

register_deactivation_hook(DARK_VISITORS_PLUGIN_FILE, 'dark_visitors_stop_cron_jobs');