<?php
/**
 * Shop page template (page slug: shop).
 * Displays the 5 sample product kit posts from the "Product Kits" category.
 */

get_header();
?>

<main class="site-main">

    <?php /* ── Page title + intro text ── */ ?>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="page-intro">
            <h1><?php the_title(); ?></h1>
            <div class="entry-content"><?php the_content(); ?></div>
        </div>
    <?php endwhile; endif; ?>

    <?php /* ── Product kits grid ── */ ?>
    <?php
    $product_posts = get_posts( array(
        'category_name'  => 'product-kits',
        'posts_per_page' => 10,
        'post_status'    => 'publish',
    ) );
    ?>

    <?php if ( $product_posts ) : ?>
        <div class="kits-grid">
            <?php foreach ( $product_posts as $pp ) : ?>
                <article class="kit-card">
                    <?php if ( has_post_thumbnail( $pp->ID ) ) : ?>
                        <a href="<?php echo esc_url( get_permalink( $pp->ID ) ); ?>">
                            <?php echo get_the_post_thumbnail( $pp->ID, 'medium' ); ?>
                        </a>
                    <?php else : ?>
                        <img
                            src="https://placehold.co/600x360/F4A261/1B4332?text=<?php echo rawurlencode( get_the_title( $pp->ID ) ); ?>"
                            alt="<?php echo esc_attr( get_the_title( $pp->ID ) ); ?>">
                    <?php endif; ?>

                    <div class="kit-card-body">
                        <h3>
                            <a href="<?php echo esc_url( get_permalink( $pp->ID ) ); ?>">
                                <?php echo esc_html( get_the_title( $pp->ID ) ); ?>
                            </a>
                        </h3>
                        <p><?php echo esc_html( wp_trim_words( get_the_excerpt( $pp->ID ), 20, '…' ) ); ?></p>
                        <a class="read-more" href="<?php echo esc_url( get_permalink( $pp->ID ) ); ?>">See kit details &rarr;</a>
                    </div>
                </article>
            <?php endforeach;
            wp_reset_postdata(); ?>
        </div>
    <?php else : ?>
        <p>No kits available yet. Check back soon!</p>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
