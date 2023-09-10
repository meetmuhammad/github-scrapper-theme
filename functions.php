<?php

/**
 * Enqueue custom scripts and styles for the theme.
 */
function enqueueCustomScript() 
{
    wp_enqueue_script('tailwind-script', 'https://cdn.tailwindcss.com', [], null, false);
    wp_enqueue_style('scrapper-styles', get_template_directory_uri() . '/style.css', [], '1.0');
    wp_enqueue_script('scrapper-js', get_template_directory_uri() . '/assets/js/scrapper.js', ['jquery'], '1.0', true);

    // Localizing ajax URL to use it in the JS file.
    wp_localize_script('scrapper-js', 'data_obj', ['ajax_url' => admin_url('admin-ajax.php')]);
}
add_action('wp_enqueue_scripts', 'enqueueCustomScript');

// Ensure the Bearer Token is defined.
if (!defined('BEARER_TOKEN')) {
    define('BEARER_TOKEN', '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');
}

/**
 * AJAX action to scrape GitHub users.
 */
function githubScraper() 
{
    // Sanitize and validate the input.
    $user_qty = isset($_POST['user_qty']) ? sanitize_text_field($_POST['user_qty']) : '';

    // Fetch GitHub users.
    $users = fetchGithubUsers($user_qty);

    foreach ($users as $user) {
        // Get user data for each user.
        $user_details = getUserData($user->url);

        // Include the user card template and pass data.
        get_template_part("assets/templates/github-user-card", null, [
            'avatar_url' => $user_details->avatar_url,
            'full_name' => $user_details->name,
            'username' => $user_details->login,
            'bio' => $user_details->bio,
            'email' => $user_details->email,
            'company_name' => $user_details->company,
            'location' => $user_details->location,
            'github_url' => $user_details->html_url,
        ]);
    }

    exit;
}
add_action('wp_ajax_github_scraper', 'githubScraper');         // Hook for logged-in users.
add_action('wp_ajax_nopriv_github_scraper', 'githubScraper');  // Hook for non-logged-in users.

/**
 * Fetch GitHub users.
 *
 * @param int $user_qty Number of users to retrieve.
 * 
 * @return array|mixed Decoded array of user data or error message.
 */
function fetchGithubUsers($user_qty) 
{
    $api_url = "https://api.github.com/users?since=0&per_page=$user_qty";
    
    $response = wp_remote_get($api_url, [
        'headers' => [
            'User-Agent' => 'YourApp',
            'Authorization' => 'Bearer ' . BEARER_TOKEN,
        ],
    ]);

    if (is_wp_error($response)) {
        return "Error: " . $response->get_error_message();
    }

    $body = wp_remote_retrieve_body($response);
    return json_decode($body);
}

/**
 * Retrieve specific user data from GitHub API using a given URL.
 *
 * @param string $url API endpoint URL.
 * 
 * @return object|mixed Decoded object of user data or error message.
 */
function getUserData($url) 
{
    $response = wp_remote_get($url, [
        'headers' => [
            'User-Agent' => 'YourApp',
            'Authorization' => 'Bearer ' . BEARER_TOKEN,
        ],
    ]);

    if (is_wp_error($response)) {
        return "Error: " . $response->get_error_message();
    }

    $body = wp_remote_retrieve_body($response);
    return json_decode($body);
}

/**
 * Retrieve the last scrapped ID from the provided scrapped data.
 *
 * @param array $scrapped_data Array of user data.
 * 
 * @return int The ID of the last scrapped user.
 */
function getLastScrappedId(array $scrapped_data) 
{
    end($scrapped_data);
    return current($scrapped_data)->id;
}
