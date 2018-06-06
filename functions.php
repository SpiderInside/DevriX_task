<?php

/**
 * 
 * Enqueue scripts and styles
 * 
 */
function theme_name_scripts() {
    wp_enqueue_style('style.css', get_template_directory_uri() . '/style.css');
    wp_enqueue_script('jquery.min.js', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', '', '1.1', true);
    wp_enqueue_script('custom.js', get_template_directory_uri() . '/js/custom.js', '', '1.1', true);
    wp_enqueue_script('jquery-ui-core');
}

add_action('wp_enqueue_scripts', 'theme_name_scripts');


/**
 * 
 * Add theme support
 * 
 */
add_theme_support('post-thumbnails');
add_theme_support('menus');
add_theme_support('widgets');


/**
 * 
 * Register post type
 * 
 */
function event_register() {

    $labels = array('name' => _x('Event', 'post type general name'),
        'singular_name' => _x('Event Item', 'post type singular name'),
        'add_new' => _x('Add New', 'event item'),
        'add_new_item' => __('Add New Event Item'),
        'edit_item' => __('Edit Event Item'),
        'new_item' => __('New Event Item'),
        'view_item' => __('View Event Item'),
        'search_items' => __('Search Event'),
        'not_found' => __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => '',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail')
    );

    register_post_type('event', $args);
    register_taxonomy("event_type", array("event"), array("hierarchical" => true, "label" => "Event Type", "singular_label" => "event type", "rewrite" => true));
}

add_action('init', 'event_register');

add_action("admin_init", "admin_init");


/**
 * 
 * Add custom  post type meta fields
 * 
 */
function admin_init() {
    add_meta_box("event_date-meta", __("Event Date"), "event_date", "event", "normal", "low");
    add_meta_box("event_location_latitude-meta", __("Event Location Latitude"), "event_location_latitude", "event", "normal", "low");
    add_meta_box("event_location_longitude-meta", __("Event Location Longitude"), "event_location_longitude", "event", "normal", "low");
    add_meta_box("event_url-meta", __("Event URL"), "event_url", "event", "normal", "low");
}

/**
 * 
 * Event date field
 * 
 */
function event_date() {
    global $post;
    $custom = get_post_custom($post->ID);
    $event_date = $custom["event_date"][0];
    ?>
    <label><?php __('Event Date:'); ?></label>
    <input id="event-date" name="event_date" value="<?php echo $event_date; ?>" />

    <script>
        $(function () {
            $("#event-date").datepicker({dateFormat: 'yy-mm-dd'});
        });
    </script>
    <?php
}

/**
 * 
 * Event location latitude field
 * 
 */
function event_location_latitude() {
    global $post;
    $custom = get_post_custom($post->ID);
    $event_location_latitude = $custom["event_location_latitude"][0];
    ?>
    <label><?php __('Event Location Latitude:'); ?></label>
    <input name="event_location_latitude" value="<?php echo $event_location_latitude; ?>" />

    <?php
}

/**
 * 
 * Event location longitude field
 * 
 */
function event_location_longitude() {
    global $post;
    $custom = get_post_custom($post->ID);
    $event_location_longitude = $custom["event_location_longitude"][0];
    ?>
    <label><?php __('Event Location Longitude:'); ?></label>
    <input name="event_location_longitude" value="<?php echo $event_location_longitude; ?>" />

    <?php
}

/**
 * 
 * Event url field
 * 
 */
function event_url() {
    global $post;
    $custom = get_post_custom($post->ID);
    $event_url = $custom["event_url"][0];
    ?>
    <label><?php __('Event URL:'); ?></label>
    <input name="event_url" value="<?php echo $event_url; ?>" />

    <?php
}


/**
 * 
 * Save custom  post type meta fields data
 * 
 */
add_action('save_post', 'save_details');

function save_details() {
    global $post;

    update_post_meta($post->ID, "event_date", $_POST["event_date"]);
    update_post_meta($post->ID, "event_location_latitude", $_POST["event_location_latitude"]);
    update_post_meta($post->ID, "event_location_longitude", $_POST["event_location_longitude"]);
    update_post_meta($post->ID, "event_url", $_POST["event_url"]);
}


/**
 * 
 * Save custom  post type list page
 * 
 */

add_action("manage_posts_custom_column", "event_custom_columns");
add_filter("manage_edit-event_columns", "event_edit_columns");

function event_edit_columns($columns) {
    $columns = array(
        "cb" => '<input type="checkbox" />',
        "title" => __("Event Title"),
        "description" => __('Description'),
        "event_date" => __("Event Date"),
        "event_location_latitude" => __("Event Location Latitude"),
        "event_location_longitude" => __("Event Location Longitude"),
        "event_url" => __("Event URL"),
    );

    return $columns;
}

function event_custom_columns($column) {
    global $post;

    switch ($column) {
        case "event_date":
            $custom = get_post_custom();
            echo $custom["event_date"][0];
            break;
        case "event_location_latitude":
            $custom = get_post_custom();
            echo $custom["event_location_latitude"][0];
            break;
        case "event_location_longitude":
            $custom = get_post_custom();
            echo $custom["event_location_longitude"][0];
            break;
        case "event_url":
            $custom = get_post_custom();
            echo $custom["event_url"][0];
            break;
    }
}
