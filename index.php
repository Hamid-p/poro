<?php get_header() ?>


<?php

$posts = getPosts(2);

while ($posts->have_posts()):?>

    <?php $posts->the_post(); ?>

    <div class="post-item">

        <a href="<?php echo get_permalink() ?>">
            <span><?php echo get_the_date("Y M d") ?></span>
            <h4><?php echo get_the_title() ?></h4>
            <div><?php echo wp_trim_words(get_the_content(), 10) ?></div>
        </a>

    </div>

<?php endwhile; ?>

<div class="pagination-wrap">
    <?php echo getPagination($posts) ?>
</div>


<?php get_footer() ?>
