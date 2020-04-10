<article class="about_content">
    <?php the_content(); ?>
</article>
<aside class="about_sidebar">
    <figure>
        <figcaption><?php the_field('image_caption'); ?></figcaption>
       <?php the_post_thumbnail(); ?>
    </figure>
</aside>