<?php

wp_enqueue_style(
// tag unique baraye in css file
    'hamid-tag-for-css1',
    // inja url (https://wordpress.local/wp-content/themes/hamidp).'/assets/hamidp.css' in file ro mide
    get_template_directory_uri() . '/assets/hamidp.css',
    // dependency ha (vabastegi haye gablie in css)
    [],
    // inja address FILE to server barmigardad mesle in : (C:\xampp\htdocs/wp-content/themes/hamidp/assets/hamidp.css)
    filemtime(get_template_directory() . '/assets/hamidp.css')
);


function getPosts($postPerPage = false, $category = false, $orderBy = 'date', $order = 'DESC')
{
    $paged = get_query_var('paged', 1);
    $args = [
        'paged' => $paged,
        'post_type' => 'post',
        'post_status' => 'publish',
        'suppress_filters' => true,
        'orderby' => $orderBy,
        'order' => $order,
        'posts_per_page' => $postPerPage,
        'category__in' => $category
    ];
    return new WP_Query($args);
}


function getPagination($query = false)
{
    if (!$query) {
        global $wp_query;
        $query = $wp_query;
    }
    $pages = paginate_links(array(
        'base' => str_replace(PHP_INT_MAX, '%#%', esc_url(get_pagenum_link(PHP_INT_MAX))),
        'format' => '?paged=%#%',
        'add_args' => false,
        'show_all' => false,
        'current' => max(1, get_query_var('paged')),
        'total' => $query->max_num_pages,
        'prev_text' => '<span aria-hidden="true">«</span>',
        'next_text' => '<span aria-hidden="true">»</span>',
        'type' => 'array',
        'end_size' => 1,
        'mid_size' => 2,
    ));

    $output = '<ul class="pagination pagination-blog justify-content-center">';
    if ($pages) {
        foreach ($pages as $page) {
            $page = str_replace('page-numbers', 'page-link', $page);
            $classes = ['page-item'];
            if (str_contains($page, 'current')) {
                $classes[] = 'active';
            }
            if (str_contains($page, 'dots')) {
                $classes[] = 'disabled';
            }
            $output .= '<li class="' . implode(' ', $classes) . '" >' . $page . '</li>';
        }
    }
    $output .= '</ul>';
    return $output;
}


/*
 * @hooked add_meta_box
 * in fuction tavasote WP vaqti k meta box sakhte mishavad call shode
 * va $post jari ham pas dade mishavad;
 */
function google_maps_custom_box_html($post)
{
    // "_hamid_google_maps_meta_key" kilide in metadata dar DB ast.
    $value = get_post_meta($post->ID, '_hamid_google_maps_meta_key')[0] ?? "";
    ?>
    <label>
        Google Map Link:
        <br>
        <br>
        <input class="widefat" type="url" name="google_map_link"
               value="<?php echo $value ?>">
        <iframe class="widefat" src="<?php echo $value ?>" height="150"></iframe>
        <!--<iframe class="widefat" src="https://www.google.com/" height="100"></iframe>-->

    </label>
    <?php
}


function google_map_add_custom_box()
{
    add_meta_box(
        'google_maps_box_id',             // Unique ID
        'Google Map',                     // Box title
        'google_maps_custom_box_html',    // CallBack Dakhele MetaBox (FORM) dar samte admin pannel
        [
            'post',
            //'page'
        ]                                 // Ro Che Post type hayi ezafe shavad
    );
}

add_action('add_meta_boxes', 'google_map_add_custom_box');


/*
 * @hooked save_post
 * in function vaqti post save shod call mishavad va $post_id ra ham
 * dar argument migirad.
 */
function google_maps_save_postdata($post_id)
{
    if (array_key_exists('google_map_link', $_POST)) {
        update_post_meta(
            $post_id,
            '_hamid_google_maps_meta_key',  // Kilide meta data to DB
            $_POST['google_map_link']       // Value input ba name="google_map_link"
        );
    }
}


/*
 * update_post_meta();
get_post_meta();
delete_post_meta();
register_post_meta();

*/


add_action('save_post', 'google_maps_save_postdata');