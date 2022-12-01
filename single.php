<?php get_header() ?>

<?php if (have_posts()) : ?>

    <?php while (have_posts()) : the_post(); ?>

        <div class="post-single">
            <h3> <?php the_title(); ?></h3>
            <time> <?php echo get_the_date(); ?></time>
            <article>
                <?php the_content(); ?>

                <?php

                $value = get_post_meta(get_the_ID(), '_hamid_google_maps_meta_key')[0] ?? "";

                ?>

                <iframe style="width: 100%" src="<?php echo $value ?>" height="400"></iframe>

            </article>

        </div>

    <?php endwhile; ?>
<?php endif; ?>


<?php get_footer(); ?>
