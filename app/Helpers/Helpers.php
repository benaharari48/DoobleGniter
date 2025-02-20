<?php
defined('ABSPATH') OR exit('No direct script access allowed');

/**
 * Generate a random string of a given length (alphanumeric).
 *
 * @param int $length The length of the random string.
 * @return string The generated random string.
 */
function generate_random_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters_length = strlen($characters);
    $random_string = '';
    
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, $characters_length - 1)];
    }
    
    return $random_string;
}

/**
 * Convert a string to a slug (lowercase and hyphenated).
 *
 * @param string $string The string to convert.
 * @return string The slugified string.
 */
function string_to_slug($string) {
    // Remove special characters and spaces, convert to lowercase
    $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($string));
    return trim($slug, '-');
}

/**
 * Format a date into a more readable string.
 *
 * @param string $date The original date string.
 * @param string $format The format for the date (default is 'F j, Y').
 * @return string The formatted date.
 */
function format_readable_date($date, $format = 'F j, Y') {
    $timestamp = strtotime($date);
    return date($format, $timestamp);
}

/**
 * Generate a unique ID for use in a variety of scenarios.
 *
 * @return string The unique ID.
 */
function generate_unique_id() {
    return uniqid('ID_', true);
}

/**
 * Capitalize the first letter of each word in a sentence.
 *
 * @param string $string The sentence to capitalize.
 * @return string The capitalized sentence.
 */
function capitalize_words($string) {
    return ucwords(strtolower($string));
}