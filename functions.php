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
