<?php

// Server Analytics

function dark_visitors_log_visit() {
    $should_log_visit = dark_visitors_is_analytics_enabled_and_allowed();
    $access_token = get_option(DARK_VISITORS_ACCESS_TOKEN);
    $request_path = isset($_SERVER['REQUEST_URI']) ? sanitize_url(wp_unslash($_SERVER['REQUEST_URI'])) : "";
    
    if ($should_log_visit && $access_token && !dark_visitors_is_system_request($request_path)) {
        $request_method = isset($_SERVER['REQUEST_METHOD']) ? sanitize_text_field(wp_unslash($_SERVER['REQUEST_METHOD'])) : "";
        $request_headers = dark_visitors_get_request_headers();
        $response_status_code = http_response_code();
        $response_headers = dark_visitors_get_response_headers();
        $is_blocked = $response_status_code === DARK_VISITORS_BLOCKED_STATUS_CODE;
        $response_duration_in_milliseconds = round((microtime(true) - WP_START_TIMESTAMP) * 1000);

        $visit = array(
            'request_path' => $request_path,
            'request_method' => $request_method,
            'request_headers' => $request_headers,
            'is_blocked' => $is_blocked,
            'response_status_code' => $response_status_code,
            'response_headers' => $response_headers,
            'response_duration_in_milliseconds' => $response_duration_in_milliseconds,
            'wordpress_plugin_version' => DARK_VISITORS_WORDPRESS_PLUGIN_VERSION,
            'created' => gmdate('c')
        );

        dark_visitors_append_to_visits_log($visit);
        dark_visitors_upload_visits_log_if_needed();
    }
}

add_action('shutdown', 'dark_visitors_log_visit');

// Log Files

function dark_visitors_append_to_visits_log($visit) {
    try {
        $file_size = file_exists(DARK_VISITORS_VISITS_LOG_PATH) ? filesize(DARK_VISITORS_VISITS_LOG_PATH) : 0;

        if ($file_size >= DARK_VISITORS_VISITS_LOG_SIZE_MAX_IN_BYTES) {
            return;
        }
        
        $log_line = wp_json_encode($visit) . PHP_EOL;
        $file_handle = fopen(DARK_VISITORS_VISITS_LOG_PATH, 'a');

        if ($file_handle === false) {
            return;
        }
        
        if (!flock($file_handle, LOCK_EX | LOCK_NB)) {
            fclose($file_handle);
            return;
        }
        
        fwrite($file_handle, $log_line);
        flock($file_handle, LOCK_UN);
        fclose($file_handle);
    } catch (Exception $e) {
        error_log('Known Agents: Error appending to visit log - ' . $e->getMessage());
    }
}

// Upload

function dark_visitors_upload_visits_log_if_needed() {
    $last_visits_log_upload_time = get_option(DARK_VISITORS_LAST_VISITS_LOG_UPLOAD_TIME, 0);
    $current_time = time();
    
    if (($current_time - $last_visits_log_upload_time) > DARK_VISITORS_VISITS_LOG_UPLOAD_INTERVAL_IN_SECONDS) {
        update_option(DARK_VISITORS_LAST_VISITS_LOG_UPLOAD_TIME, $current_time, false);
        dark_visitors_upload_visits_log();
    }
}

function dark_visitors_upload_visits_log() {
    try {
        $file_handle = fopen(DARK_VISITORS_VISITS_LOG_PATH, 'r+');

        if ($file_handle === false) {
            return;
        }

        if (!flock($file_handle, LOCK_EX | LOCK_NB)) {
            fclose($file_handle);
            return;
        }

        $ndjson_content = stream_get_contents($file_handle);

        ftruncate($file_handle, 0);
        flock($file_handle, LOCK_UN);
        fclose($file_handle);

        $access_token = get_option(DARK_VISITORS_ACCESS_TOKEN);

        if (!empty($ndjson_content) && $access_token) {
            $compressed_ndjson_content = gzencode($ndjson_content, 6);
            
            $headers = array(
                'Content-Type' => 'text/plain',
                'Content-Encoding' => 'gzip',
                'Authorization' => 'Bearer ' . $access_token
            );

            wp_remote_post('https://api.knownagents.com/logs/wordpress', array(
                'headers' => $headers,
                'body' => $compressed_ndjson_content,
                'blocking' => false
            ));
        }
    } catch (Exception $e) {
        error_log('Known Agents: Error uploading visit log - ' . $e->getMessage());
    }
}

// Script Tags

function dark_visitors_add_analytics_script_tag() {
    $should_add_analytics_script_tag = dark_visitors_is_analytics_enabled_and_allowed();

    if ($should_add_analytics_script_tag) {
        echo "
<!-- Known Agents (https://knownagents.com/) -->
";
    
        echo dark_visitors_get_user_analytics_script_tag();

        echo "
";
    }
}

add_action('wp_head', 'dark_visitors_add_analytics_script_tag');

// Helpers

function dark_visitors_get_request_headers() {
    $header_names = [
        'User-Agent',
        'Referer',
        'From',
        'Accept',
        'Accept-Language',
        'Accept-Encoding',
        'Origin',
        'Host',
        'Connection',
        'DNT',
        'X-Country-Code',
        'Remote-Addr',
        'X-Forwarded-For',
        'X-Real-IP',
        'Client-IP',
        'CF-Connecting-IP',
        'X-Cluster-Client-IP',
        'Forwarded',
        'X-Original-Forwarded-For',
        'Fastly-Client-IP',
        'True-Client-IP',
        'X-Appengine-User-IP',
        'Sec-Fetch-Site',
        'Sec-Fetch-Mode',
        'Sec-Fetch-User',
        'Sec-Fetch-Dest',
        'Sec-CH-UA',
        'Sec-CH-UA-Mobile',
        'Sec-CH-UA-Platform',
        'Sec-CH-UA-Platform-Version',
        'Sec-CH-UA-Arch',
        'Sec-CH-UA-Bitness',
        'Sec-CH-UA-Model',
        'Sec-CH-UA-Full-Version',
        'Sec-CH-UA-Full-Version-List',
        'Signature',
        'Signature-Input',
        'Signature-Agent',
        'Content-Type',
        'Content-Length',
        'Content-Encoding',
        'Content-Language'
    ];

    $request_headers = [];

    foreach ($header_names as $header_name) {
        $header_value = dark_visitors_get_request_header_value($header_name);

        if ($header_value) {
            $request_headers[$header_name] = $header_value;
        }
    }
    
    return $request_headers;
}

function dark_visitors_get_response_headers() {
    $header_names = [
        'Content-Type',
        'Content-Length',
        'Content-Encoding',
        'Content-Language',
        'Cache-Control',
        'Vary',
        'Expires',
        'Last-Modified',
        'ETag',
        'Location',
        'X-Robots-Tag',
        'Link',
        'Access-Control-Allow-Origin'
    ];

    $response_headers = [];

    foreach ($header_names as $header_name) {
        $header_value = dark_visitors_get_response_header_value($header_name);

        if ($header_value) {
            $response_headers[$header_name] = $header_value;
        }
    }
    
    return $response_headers;
}

function dark_visitors_get_request_header_value($header_name) {
    $server_key = strtoupper(str_replace('-', '_', $header_name));
    $server_key_with_http_prefix = 'HTTP_' . $server_key;

    if (isset($_SERVER[$server_key])) {
        return sanitize_text_field(wp_unslash($_SERVER[$server_key]));
    } else if (isset($_SERVER[$server_key_with_http_prefix])) {
        return sanitize_text_field(wp_unslash($_SERVER[$server_key_with_http_prefix]));
    } else if (function_exists('getallheaders')) {
        $headers_with_lowercase_keys = array_change_key_case(getallheaders(), CASE_LOWER);
        $lowercased_header_name = strtolower($header_name);

        if (isset($headers_with_lowercase_keys[$lowercased_header_name])) {
            return sanitize_text_field($headers_with_lowercase_keys[$lowercased_header_name]);
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function dark_visitors_get_response_header_value($header_name) {
    $headers_list = headers_list();
    $all_headers = [];
    
    foreach ($headers_list as $header) {
        $parts = explode(':', $header, 2);
        
        if (count($parts) === 2) {
            $all_headers[trim($parts[0])] = trim($parts[1]);
        }
    }
    
    $headers_with_lowercase_keys = array_change_key_case($all_headers, CASE_LOWER);
    $lowercased_header_name = strtolower($header_name);

    if (isset($headers_with_lowercase_keys[$lowercased_header_name])) {
        return $headers_with_lowercase_keys[$lowercased_header_name];
    } else {
        return null;
    }
}

function dark_visitors_is_system_request($request_path) {
    return (
        stripos($request_path, '/wp-admin') === 0 ||
        stripos($request_path, '/wp-login') === 0 ||
        stripos($request_path, '/wp-cron') === 0 ||
        stripos($request_path, '/wp-json') === 0 ||
        stripos($request_path, '/wp-includes') === 0 ||
        stripos($request_path, '/wp-content') === 0
    );
}

function dark_visitors_is_analytics_enabled_and_allowed() {
    $is_analytics_enabled = get_option(DARK_VISITORS_IS_ANALYTICS_ENABLED) === '1';
    $is_analytics_disallowed = dark_visitors_get_user_is_analytics_disallowed();
    return $is_analytics_enabled && !$is_analytics_disallowed;
}
