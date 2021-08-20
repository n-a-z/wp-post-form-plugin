<?php
/*
Plugin Name: Post Form Plugin
Plugin URI: https://github.com/n-a-z/wp-post-form-plugin
Description: A lightweight WordPress form plugin to add new posts. To use add the shortcode [post_form] in the desired area.
Version: 1.0
Author: Piotr Stepien
Author URI: https://github.com/n-a-z
*/

function load_plugin_css()
{
    $plugin_url = plugin_dir_url(__FILE__);

    wp_enqueue_style('style', $plugin_url . 'assets/css/style.css');
}
add_action('wp_enqueue_scripts', 'load_plugin_css');

function load_plugin_js()
{
    $plugin_url = plugin_dir_url(__FILE__);

    wp_enqueue_script('validation', $plugin_url . 'assets/js/validation.js');
}
add_action('wp_enqueue_scripts', 'load_plugin_js');

function html_form_code()
{
    if (isset($_POST["post_form_title"]) && isset($_POST["post_form_content"])) {
        echo '<div class="post-form-success">';
        echo '<p class="post-form-success__content">Your post <strong>' . $_POST["post_form_title"] . '</strong> has been created!</p>';
        echo '</div';
    } else {
        echo '<form name="post_form" class="post-form" action="' . esc_url($_SERVER['REQUEST_URI']) . '" onsubmit="return validateForm()" method="post">';
        echo '<div class="post-form__input-container">';
        echo '<p class="post-form__input-title">Post Title (required)</p>';
        echo '<input class="post-form__input" type="text" name="post_form_title" value="' . (isset($_POST["post_form_title"]) ? esc_attr($_POST["post_form_title"]) : '') . '" size="40" />';
        echo '</div>';
        echo '<div class="post-form__input-container">';
        echo '<p class="post-form__input-title">Post Content (required)</p>';
        echo '<textarea class="post-form__input"  rows="6" cols="35" name="post_form_content">' . (isset($_POST["post_form_content"]) ? esc_attr($_POST["post_form_content"]) : '') . '</textarea>';
        echo '</div>';
        echo '<div class="post-form__submit-container">';
        echo '<input class="post-form__submit" type="submit" name="post_form_submit" value="Create Post" /> ';
        echo '</div>';
        echo '</form>';
    }
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
