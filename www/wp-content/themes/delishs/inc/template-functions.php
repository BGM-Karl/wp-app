<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package delishs
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function delishs_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages.
    if ( !is_singular() ) {
        $classes[] = 'hfeed';
    }
    // Adds a class of no-sidebar when there is no sidebar present.
    if ( !is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }
    if (  function_exists('tutor') ) {
        $user_name = sanitize_text_field(get_query_var('tutor_student_username'));
        $get_user = tutor_utils()->get_user_by_login($user_name);
    }

    if ( !empty($get_user) ) {
        $classes[] = 'profile-breadcrumb';
    }

    return $classes;
}
add_filter( 'body_class', 'delishs_body_classes' );

/**
 * Get tags.
 */
function delishs_get_tag() {
    $html = '';
    if ( has_tag() ) {
        $html .= '<div class="blog__details-bottom-tags_wapper d-flex align-items-center"><div class="blog__details-bottom-tags"><span>Tags</span><div class="blog__details-bottom-tags">';
        $html .= get_the_tag_list( '', '', '' );
        $html .= '</div></div></div>';
    }
    return $html;
}

/**
 * Get categories.
 */
function delishs_get_category() {

    $categories = get_the_category( get_the_ID() );
    $x = 0;
    foreach ( $categories as $category ) {

        if ( $x == 2 ) {
            break;
        }
        $x++;
        print '<a class="news-tag" href="' . get_category_link( $category->term_id ) . '">' . $category->cat_name . '</a>';

    }
}

// Add Span In category number
function delishs_cat_count_span($links) {
    $links = str_replace('</a> (', '</a> <span>(', $links);
    $links = str_replace(')', ')</span>', $links);
    return $links;
}

add_filter('wp_list_categories', 'delishs_cat_count_span');

// Add Span In archive number
function delishs_the_archive_count($links) {
    $links = str_replace('</a>'.esc_attr__('&nbsp;','delishs').'(', '</a> <span>(', $links);
    $links = str_replace(')', ')</span>', $links);
    return $links;
}

add_filter('get_archives_link', 'delishs_the_archive_count');

/** img alt-text **/
function delishs_img_alt_text( $img_er_id = null ) {
    $image_id = $img_er_id;
    $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', false );
    $image_title = get_the_title( $image_id );

    if ( !empty( $image_id ) ) {
        if ( $image_alt ) {
            $alt_text = get_post_meta( $image_id, '_wp_attachment_image_alt', false );
        } else {
            $alt_text = get_the_title( $image_id );
        }
    } else {
        $alt_text = esc_html__( 'Image Alt Text', 'delishs' );
    }

    return $alt_text;
}