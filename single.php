<?php get_header() ?>

<?php if (have_posts()) : ?>

    <?php while (have_posts()) : the_post(); ?>

        <div class="post-single">
            <h3> <?php the_title(); ?></h3>
            <time> <?php echo get_the_date(); ?></time>
            <article>
                <?php the_content(); ?>
            </article>

        </div>

    <?php endwhile; ?>
<?php endif; ?>


<?php get_footer(); ?>
