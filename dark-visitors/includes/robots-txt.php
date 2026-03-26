<?php

define('DARK_VISITORS_ROBOTS_TXT_BLOCK_START', '# START KNOWN AGENTS BLOCK');
define('DARK_VISITORS_ROBOTS_TXT_BLOCK_END', '# END KNOWN AGENTS BLOCK');
define('DARK_VISITORS_ROBOTS_TXT_BLOCK_DIVIDER', '# ---------------------------');
define('DARK_VISITORS_ROBOTS_TXT_PATH', ABSPATH . 'robots.txt');

// Virtual Robots.txt

function dark_visitors_augment_virtual_robots_txt() {
    $robots_txt = dark_visitors_get_robots_txt();
    if ($robots_txt) {
        echo PHP_EOL . PHP_EOL;
        echo DARK_VISITORS_ROBOTS_TXT_BLOCK_START . PHP_EOL;
        echo DARK_VISITORS_ROBOTS_TXT_BLOCK_DIVIDER . PHP_EOL;
        echo $robots_txt . PHP_EOL;
        echo DARK_VISITORS_ROBOTS_TXT_BLOCK_DIVIDER . PHP_EOL;
        echo DARK_VISITORS_ROBOTS_TXT_BLOCK_END . PHP_EOL;
    }
}

add_action('do_robots', 'dark_visitors_augment_virtual_robots_txt');

// Physical Robots.txt

function dark_visitors_update_physical_robots_txt() {
    try {
        $existing_robots_txt_file_content = dark_visitors_get_robots_txt_file_content();
        if ($existing_robots_txt_file_content === null) {
            return;
        }
    
        $robots_txt_file_content = dark_visitors_get_robots_txt_file_content_without_dark_visitors_block($existing_robots_txt_file_content);
    
        $robots_txt = dark_visitors_get_robots_txt();
        if ($robots_txt) {
            $robots_txt_file_content .= PHP_EOL . PHP_EOL;
            $robots_txt_file_content .= DARK_VISITORS_ROBOTS_TXT_BLOCK_START . PHP_EOL;
            $robots_txt_file_content .= DARK_VISITORS_ROBOTS_TXT_BLOCK_DIVIDER . PHP_EOL;
            $robots_txt_file_content .= $robots_txt . PHP_EOL;
            $robots_txt_file_content .= DARK_VISITORS_ROBOTS_TXT_BLOCK_DIVIDER . PHP_EOL;
            $robots_txt_file_content .= DARK_VISITORS_ROBOTS_TXT_BLOCK_END . PHP_EOL;
        } else {
            $robots_txt_file_content .= PHP_EOL;
        }

        if (!is_writable(DARK_VISITORS_ROBOTS_TXT_PATH)) {
            error_log('Known Agents: The robots.txt file is not writable.');
            return;
        }
    
        file_put_contents(DARK_VISITORS_ROBOTS_TXT_PATH, $robots_txt_file_content, LOCK_EX);
    } catch (Exception $e) {
        error_log('Known Agents: Error updating physical robots.txt - ' . $e->getMessage());
    }
}

add_action('update_option_' . DARK_VISITORS_SETTINGS_LAST_SAVED, function () {
    add_action('shutdown', 'dark_visitors_update_physical_robots_txt');
});

// Plugin Activation

register_activation_hook(DARK_VISITORS_PLUGIN_FILE, 'dark_visitors_update_physical_robots_txt');

// Plugin Deactivation

function dark_visitors_remove_physical_robots_txt_block() {
    try {
        $existing_robots_txt_file_content = dark_visitors_get_robots_txt_file_content();
        if ($existing_robots_txt_file_content === null) {
            return;
        }
    
        $robots_txt_file_content = dark_visitors_get_robots_txt_file_content_without_dark_visitors_block($existing_robots_txt_file_content);
        
        if (!is_writable(DARK_VISITORS_ROBOTS_TXT_PATH)) {
            error_log('Known Agents: The robots.txt file is not writable.');
            return;
        }

        file_put_contents(DARK_VISITORS_ROBOTS_TXT_PATH, $robots_txt_file_content, LOCK_EX);
    } catch (Exception $e) {
        error_log('Known Agents: Error removing physical robots.txt block - ' . $e->getMessage());
    }
}

register_deactivation_hook(DARK_VISITORS_PLUGIN_FILE, 'dark_visitors_remove_physical_robots_txt_block');

// Cron Jobs

add_action(DARK_VISITORS_DAILY_CRON_EVENT, 'dark_visitors_update_physical_robots_txt');

// Helpers

function dark_visitors_get_robots_txt_file_content() {
    try {
        if (!file_exists(DARK_VISITORS_ROBOTS_TXT_PATH) || !is_readable(DARK_VISITORS_ROBOTS_TXT_PATH)) {
            return null;
        }
    
        return file_get_contents(DARK_VISITORS_ROBOTS_TXT_PATH);
    } catch (Exception $e) {
        error_log('Known Agents: Error getting robots.txt file content - ' . $e->getMessage());
        return null;
    }
}

function dark_visitors_get_robots_txt_file_content_without_dark_visitors_block($robots_txt_file_content) {
    $start_position = strpos($robots_txt_file_content, DARK_VISITORS_ROBOTS_TXT_BLOCK_START);
    if ($start_position !== false) {
        $end_position = strpos($robots_txt_file_content, DARK_VISITORS_ROBOTS_TXT_BLOCK_END, $start_position);
        if ($end_position !== false) {
            $end_position += strlen(DARK_VISITORS_ROBOTS_TXT_BLOCK_END);
            return trim(substr($robots_txt_file_content, 0, $start_position) . substr($robots_txt_file_content, $end_position));
        }
    }

    return $robots_txt_file_content;
}