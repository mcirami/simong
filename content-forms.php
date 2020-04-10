<article class="content">
    <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
    <?php endwhile; ?>
</article>
<aside class="sidebar form_sidebar">
    <?php the_field('form_sidebar'); ?>
</aside>