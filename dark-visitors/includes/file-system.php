<?php

// Initialization

function dark_visitors_create_files_directory_if_needed() {
    if (!file_exists(DARK_VISITORS_FILES_DIRECTORY)) {
        wp_mkdir_p(DARK_VISITORS_FILES_DIRECTORY);
        file_put_contents(DARK_VISITORS_FILES_DIRECTORY . '/.htaccess', "deny from all");
    }
}

add_action('init', 'dark_visitors_create_files_directory_if_needed');