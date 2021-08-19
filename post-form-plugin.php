<?php
/*
Plugin Name: Post Form Plugin
Plugin URI: https://github.com/n-a-z/wp-post-form-plugin
Description: Form plugin to add WordPress posts
Version: 1.0
Author: Piotr Stepien
Author URI: https://github.com/n-a-z
*/

function html_form_code()
{
    echo '<form action="' . esc_url($_SERVER['REQUEST_URI']) . '" method="post">';
    echo 'Post Title (required) <br />';
    echo '<input type="text" name="post_form_title" pattern="[a-zA-Z0-9 ]+" value="' . (isset($_POST["post_form_title"]) ? esc_attr($_POST["post_form_title"]) : '') . '" size="40" />';
    echo '</p>';
    echo '<p>';
    echo 'Post Entry (required) <br />';
    echo '<textarea rows="10" cols="35" name="post_form_content">' . (isset($_POST["post_form_content"]) ? esc_attr($_POST["post_form_content"]) : '') . '</textarea>';
    echo '</p>';
    echo '<p><input type="submit" name="post_form_submit" value="Create Post"/></p>';
    echo '</form>';
}

function create_post()
{
    if (isset($_POST['post_form_submit'])) {
        $my_post = array(
            'post_title'    => wp_strip_all_tags($_POST['post_form_title']),
            'post_content'  => $_POST['post_form_content'],
            'post_status'   => 'draft',
            'post_author'   => 1,
            'post_category' => array(8, 39)
        );

        wp_insert_post($my_post);
    }
}

function form_shortcode()
{
    ob_start();
    create_post();
    html_form_code();

    return ob_get_clean();
}

add_shortcode('post_form', 'form_shortcode');

?>