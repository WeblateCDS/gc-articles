<?php

declare(strict_types=1);

require_once __DIR__.'/util.php';
require_once __DIR__.'/notices.php';
require_once __DIR__.'/profile.php';


/*--------------------------------------------*
 * Dashboard
 *--------------------------------------------*/

function remove_dashboard_meta(): void
{
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
    remove_meta_box('dashboard_primary', 'dashboard', 'normal');
    remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');
    remove_meta_box('dashboard_site_health', 'dashboard', 'normal');
    remove_meta_box('task_dashboard', 'dashboard', 'normal');

    /* plugins */
    remove_meta_box('wpseo-dashboard-overview', 'dashboard', 'normal');
    remove_meta_box('wp_mail_smtp_reports_widget_lite', 'dashboard', 'normal');
}

add_action('admin_init', 'remove_dashboard_meta');

/*--------------------------------------------*
 * Admin Bar
 *--------------------------------------------*/
function remove_from_admin_bar_before(): void
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('WPML_ALS');
}

function remove_from_admin_bar($wp_admin_bar): void
{
    if (super_admin()) {
        return;
    }

    $wp_admin_bar->remove_node('updates');
    $wp_admin_bar->remove_node('comments');
    $wp_admin_bar->remove_node('new-content');
    $wp_admin_bar->remove_node('wp-logo');
    $wp_admin_bar->remove_node('site-name');
    $wp_admin_bar->remove_node('customize');

    /* plugins */
    $wp_admin_bar->remove_menu('wp-mail-smtp-menu');
    $wp_admin_bar->remove_menu('wpseo-menu');

    /* remove "Howdy" from admin bar */
    $my_account = $wp_admin_bar->get_node('my-account');
    $newtext    = str_replace('Howdy,', '', $my_account->title);
    $wp_admin_bar->add_node([
        'id'    => 'my-account',
        'title' => $newtext,
    ]);

    $wp_admin_bar->add_node([
        'id'    => 'cds-home',
        'title' => '<div class="ab-item"><span class="ab-icon"></span>'.__('Canadian Digital Service',
                'cds-snc').'</div>',
        'href'  => "https://digital.canada.ca",
    ]);

    $wp_admin_bar->remove_menu('my-sites');
}

add_action('admin_bar_menu', 'remove_from_admin_bar', 2147483647);

add_action('wp_before_admin_bar_render', 'remove_from_admin_bar_before', 99);

/*--------------------------------------------*
 * Footer Text
 *--------------------------------------------*/
add_filter('admin_footer_text', '__return_false');

/*--------------------------------------------*
 * Screen Options Tab
 *--------------------------------------------*/
function cds_remove_screen_options()
{
    return false;
}

add_filter('screen_options_show_screen', 'cds_remove_screen_options');

/*--------------------------------------------*
 * Help Tab
 *--------------------------------------------*/
function cds_remove_help_tab(): void
{
    $screen = get_current_screen();
    $screen->remove_help_tabs();
}

add_action('admin_head', 'cds_remove_help_tab');

