<?php

function dark_visitors_block_request_if_needed() {
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT'])) : false;
    $should_get_user_agent_strings_list = dark_visitors_is_enforce_robots_txt_enabled_and_allowed();
    $user_agent_strings_list = $should_get_user_agent_strings_list ? dark_visitors_get_user_agent_strings_list() : array();
    $should_block_request = $user_agent && in_array($user_agent, $user_agent_strings_list);

    if ($should_block_request) {        
        status_header(DARK_VISITORS_BLOCKED_STATUS_CODE);
        nocache_headers();

        echo 'This visit is disallowed by robots.txt rules. Please contact the website owner if you think this is a mistake.';

        exit();
    }
}

add_action('wp_loaded', 'dark_visitors_block_request_if_needed');

// Helpers

function dark_visitors_is_enforce_robots_txt_enabled_and_allowed() {
    $is_enforce_robots_txt_enabled = get_option(DARK_VISITORS_IS_ENFORCE_ROBOTS_TXT_ENABLED) === '1';
    $is_robots_txt_enforcement_disallowed = dark_visitors_get_user_is_robots_txt_enforcement_disallowed();
    return $is_enforce_robots_txt_enabled && !$is_robots_txt_enforcement_disallowed;
}
