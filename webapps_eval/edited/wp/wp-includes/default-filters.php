<?php require_once('AspisMain.php'); ?><?php
foreach ( (array(array('pre_term_name',false),array('pre_comment_author_name',false),array('pre_link_name',false),array('pre_link_target',false),array('pre_link_rel',false),array('pre_user_display_name',false),array('pre_user_first_name',false),array('pre_user_last_name',false),array('pre_user_nickname',false))) as $filter  )
{add_filter($filter,array('sanitize_text_field',false));
add_filter($filter,array('wp_filter_kses',false));
add_filter($filter,array('_wp_specialchars',false),array(30,false));
}foreach ( (array(array('term_name',false),array('comment_author_name',false),array('link_name',false),array('link_target',false),array('link_rel',false),array('user_display_name',false),array('user_first_name',false),array('user_last_name',false),array('user_nickname',false))) as $filter  )
{add_filter($filter,array('sanitize_text_field',false));
add_filter($filter,array('wp_kses_data',false));
add_filter($filter,array('_wp_specialchars',false),array(30,false));
}foreach ( (array(array('pre_term_description',false),array('pre_link_description',false),array('pre_link_notes',false),array('pre_user_description',false))) as $filter  )
{add_filter($filter,array('wp_filter_kses',false));
}foreach ( (array(array('term_description',false),array('link_description',false),array('link_notes',false),array('user_description',false))) as $filter  )
{add_filter($filter,array('wp_kses_data',false));
}foreach ( (array(array('pre_comment_author_email',false),array('pre_user_email',false))) as $filter  )
{add_filter($filter,array('trim',false));
add_filter($filter,array('sanitize_email',false));
add_filter($filter,array('wp_filter_kses',false));
}foreach ( (array(array('comment_author_email',false),array('user_email',false))) as $filter  )
{add_filter($filter,array('sanitize_email',false));
add_filter($filter,array('wp_kses_data',false));
}foreach ( (array(array('pre_comment_author_url',false),array('pre_user_url',false),array('pre_link_url',false),array('pre_link_image',false),array('pre_link_rss',false))) as $filter  )
{add_filter($filter,array('wp_strip_all_tags',false));
add_filter($filter,array('esc_url_raw',false));
add_filter($filter,array('wp_filter_kses',false));
}foreach ( (array(array('user_url',false),array('link_url',false),array('link_image',false),array('link_rss',false),array('comment_url',false))) as $filter  )
{add_filter($filter,array('wp_strip_all_tags',false));
add_filter($filter,array('esc_url',false));
add_filter($filter,array('wp_kses_data',false));
}foreach ( (array(array('pre_term_slug',false))) as $filter  )
{add_filter($filter,array('sanitize_title',false));
}foreach ( (array(array('pre_post_type',false))) as $filter  )
{add_filter($filter,array('sanitize_user',false));
}foreach ( (array(array('content_save_pre',false),array('excerpt_save_pre',false),array('comment_save_pre',false),array('pre_comment_content',false))) as $filter  )
{add_filter($filter,array('balanceTags',false),array(50,false));
}foreach ( (array(array('comment_author',false),array('term_name',false),array('link_name',false),array('link_description',false),array('link_notes',false),array('bloginfo',false),array('wp_title',false),array('widget_title',false))) as $filter  )
{add_filter($filter,array('wptexturize',false));
add_filter($filter,array('convert_chars',false));
add_filter($filter,array('esc_html',false));
}foreach ( (array(array('term_description',false))) as $filter  )
{add_filter($filter,array('wptexturize',false));
add_filter($filter,array('convert_chars',false));
add_filter($filter,array('wpautop',false));
add_filter($filter,array('shortcode_unautop',false));
}foreach ( (array(array('term_name_rss',false))) as $filter  )
{add_filter($filter,array('convert_chars',false));
}add_filter(array('the_title',false),array('wptexturize',false));
add_filter(array('the_title',false),array('convert_chars',false));
add_filter(array('the_title',false),array('trim',false));
add_filter(array('the_content',false),array('wptexturize',false));
add_filter(array('the_content',false),array('convert_smilies',false));
add_filter(array('the_content',false),array('convert_chars',false));
add_filter(array('the_content',false),array('wpautop',false));
add_filter(array('the_content',false),array('shortcode_unautop',false));
add_filter(array('the_content',false),array('prepend_attachment',false));
add_filter(array('the_excerpt',false),array('wptexturize',false));
add_filter(array('the_excerpt',false),array('convert_smilies',false));
add_filter(array('the_excerpt',false),array('convert_chars',false));
add_filter(array('the_excerpt',false),array('wpautop',false));
add_filter(array('the_excerpt',false),array('shortcode_unautop',false));
add_filter(array('get_the_excerpt',false),array('wp_trim_excerpt',false));
add_filter(array('comment_text',false),array('wptexturize',false));
add_filter(array('comment_text',false),array('convert_chars',false));
add_filter(array('comment_text',false),array('make_clickable',false),array(9,false));
add_filter(array('comment_text',false),array('force_balance_tags',false),array(25,false));
add_filter(array('comment_text',false),array('convert_smilies',false),array(20,false));
add_filter(array('comment_text',false),array('wpautop',false),array(30,false));
add_filter(array('comment_excerpt',false),array('convert_chars',false));
add_filter(array('list_cats',false),array('wptexturize',false));
add_filter(array('single_post_title',false),array('wptexturize',false));
add_filter(array('wp_sprintf',false),array('wp_sprintf_l',false),array(10,false),array(2,false));
add_filter(array('the_title_rss',false),array('strip_tags',false));
add_filter(array('the_title_rss',false),array('ent2ncr',false),array(8,false));
add_filter(array('the_title_rss',false),array('esc_html',false));
add_filter(array('the_content_rss',false),array('ent2ncr',false),array(8,false));
add_filter(array('the_excerpt_rss',false),array('convert_chars',false));
add_filter(array('the_excerpt_rss',false),array('ent2ncr',false),array(8,false));
add_filter(array('comment_author_rss',false),array('ent2ncr',false),array(8,false));
add_filter(array('comment_text_rss',false),array('ent2ncr',false),array(8,false));
add_filter(array('comment_text_rss',false),array('esc_html',false));
add_filter(array('bloginfo_rss',false),array('ent2ncr',false),array(8,false));
add_filter(array('the_author',false),array('ent2ncr',false),array(8,false));
add_filter(array('option_ping_sites',false),array('privacy_ping_filter',false));
add_filter(array('option_blog_charset',false),array('_wp_specialchars',false));
add_filter(array('option_home',false),array('_config_wp_home',false));
add_filter(array('option_siteurl',false),array('_config_wp_siteurl',false));
add_filter(array('tiny_mce_before_init',false),array('_mce_set_direction',false));
add_filter(array('pre_kses',false),array('wp_pre_kses_less_than',false));
add_filter(array('sanitize_title',false),array('sanitize_title_with_dashes',false));
add_action(array('check_comment_flood',false),array('check_comment_flood_db',false),array(10,false),array(3,false));
add_filter(array('comment_flood_filter',false),array('wp_throttle_comment_flood',false),array(10,false),array(3,false));
add_filter(array('pre_comment_content',false),array('wp_rel_nofollow',false),array(15,false));
add_filter(array('comment_email',false),array('antispambot',false));
add_filter(array('option_tag_base',false),array('_wp_filter_taxonomy_base',false));
add_filter(array('option_category_base',false),array('_wp_filter_taxonomy_base',false));
add_filter(array('the_posts',false),array('_close_comments_for_old_posts',false));
add_filter(array('comments_open',false),array('_close_comments_for_old_post',false),array(10,false),array(2,false));
add_filter(array('pings_open',false),array('_close_comments_for_old_post',false),array(10,false),array(2,false));
add_filter(array('editable_slug',false),array('urldecode',false));
add_filter(array('atom_service_url',false),array('atom_service_url_filter',false));
add_action(array('wp_head',false),array('wp_enqueue_scripts',false),array(1,false));
add_action(array('wp_head',false),array('feed_links_extra',false),array(3,false));
add_action(array('wp_head',false),array('rsd_link',false));
add_action(array('wp_head',false),array('wlwmanifest_link',false));
add_action(array('wp_head',false),array('index_rel_link',false));
add_action(array('wp_head',false),array('parent_post_rel_link',false),array(10,false),array(0,false));
add_action(array('wp_head',false),array('start_post_rel_link',false),array(10,false),array(0,false));
add_action(array('wp_head',false),array('adjacent_posts_rel_link',false),array(10,false),array(0,false));
add_action(array('wp_head',false),array('locale_stylesheet',false));
add_action(array('publish_future_post',false),array('check_and_publish_future_post',false),array(10,false),array(1,false));
add_action(array('wp_head',false),array('noindex',false),array(1,false));
add_action(array('wp_head',false),array('wp_print_styles',false),array(8,false));
add_action(array('wp_head',false),array('wp_print_head_scripts',false),array(9,false));
add_action(array('wp_head',false),array('wp_generator',false));
add_action(array('wp_head',false),array('rel_canonical',false));
add_action(array('wp_footer',false),array('wp_print_footer_scripts',false));
if ( (!(defined(('DOING_CRON')))))
 add_action(array('sanitize_comment_cookies',false),array('wp_cron',false));
add_action(array('do_feed_rdf',false),array('do_feed_rdf',false),array(10,false),array(1,false));
add_action(array('do_feed_rss',false),array('do_feed_rss',false),array(10,false),array(1,false));
add_action(array('do_feed_rss2',false),array('do_feed_rss2',false),array(10,false),array(1,false));
add_action(array('do_feed_atom',false),array('do_feed_atom',false),array(10,false),array(1,false));
add_action(array('do_pings',false),array('do_all_pings',false),array(10,false),array(1,false));
add_action(array('do_robots',false),array('do_robots',false));
add_action(array('sanitize_comment_cookies',false),array('sanitize_comment_cookies',false));
add_action(array('admin_print_scripts',false),array('print_head_scripts',false),array(20,false));
add_action(array('admin_print_footer_scripts',false),array('print_footer_scripts',false),array(20,false));
add_action(array('admin_print_styles',false),array('print_admin_styles',false),array(20,false));
add_action(array('init',false),array('smilies_init',false),array(5,false));
add_action(array('plugins_loaded',false),array('wp_maybe_load_widgets',false),array(0,false));
add_action(array('plugins_loaded',false),array('wp_maybe_load_embeds',false),array(0,false));
add_action(array('shutdown',false),array('wp_ob_end_flush_all',false),array(1,false));
add_action(array('pre_post_update',false),array('wp_save_post_revision',false));
add_action(array('publish_post',false),array('_publish_post_hook',false),array(5,false),array(1,false));
add_action(array('future_post',false),array('_future_post_hook',false),array(5,false),array(2,false));
add_action(array('future_page',false),array('_future_post_hook',false),array(5,false),array(2,false));
add_action(array('save_post',false),array('_save_post_hook',false),array(5,false),array(2,false));
add_action(array('transition_post_status',false),array('_transition_post_status',false),array(5,false),array(3,false));
add_action(array('comment_form',false),array('wp_comment_form_unfiltered_html_nonce',false));
add_action(array('wp_scheduled_delete',false),array('wp_scheduled_delete',false));
add_action(array('begin_fetch_post_thumbnail_html',false),array('_wp_post_thumbnail_class_filter_add',false));
add_action(array('end_fetch_post_thumbnail_html',false),array('_wp_post_thumbnail_class_filter_remove',false));
add_action(array('template_redirect',false),array('wp_old_slug_redirect',false));
add_action(array('edit_post',false),array('wp_check_for_changed_slugs',false));
add_action(array('edit_form_advanced',false),array('wp_remember_old_slug',false));
add_action(array('init',false),array('_show_post_preview',false));
add_filter(array('pre_option_gmt_offset',false),array('wp_timezone_override_offset',false));
