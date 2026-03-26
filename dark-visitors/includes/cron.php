<?php

// Initialization

function dark_visitors_start_cron_jobs_if_needed() {
    if (!wp_next_scheduled(DARK_VISITORS_DAILY_CRON_EVENT)) {
        wp_schedule_event(time(), 'daily', DARK_VISITORS_DAILY_CRON_EVENT);
    }
    
    dark_visitors_stop_deprecated_cron_jobs_if_needed();
}

add_action('init', 'dark_visitors_start_cron_jobs_if_needed');

// Deactivation

function dark_visitors_stop_cron_jobs() {
    wp_clear_scheduled_hook(DARK_VISITORS_DAILY_CRON_EVENT);
}

register_deactivation_hook(DARK_VISITORS_PLUGIN_FILE, 'dark_visitors_stop_cron_jobs');

// Helpers

function dark_visitors_stop_deprecated_cron_jobs_if_needed() {
    $deprecated_events = [
        DARK_VISITORS_EVERY_FIVE_MINUTES_CRON_EVENT,
    ];
    
    foreach ($deprecated_events as $event) {
        if (wp_next_scheduled($event)) {
            wp_clear_scheduled_hook($event);
        }
    }
}
