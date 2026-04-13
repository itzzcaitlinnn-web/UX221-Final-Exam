<?php
/**
 * Front-page template for the Kits for Family Times site.
 *
 * Shows:
 *  1. The custom <kit-action-panel> element (routes makers vs developers)
 *  2. A grid of the 5 "Landing Kits" posts
 */

get_header();
?>

<main class="site-main">

    <?php /* ── Custom element: directs visitors to shop or registration ── */ ?>
    <kit-action-panel
        data-shop="<?php echo esc_url( home_url( '/shop' ) ); ?>"
        data-register="<?php echo esc_url( home_url( '/kit-developer-registration' ) ); ?>">
    </kit-action-panel>

    <?php /* ── Introductory page content (editable in WP admin) ── */ ?>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    <?php endwhile; endif; ?>

    <?php /* ── Landing Kits grid ── */ ?>
    <?php
    $landing_posts = get_posts( array(
        'category_name'  => 'landing-kits',
        'posts_per_page' => 5,
        'post_status'    => 'publish',
    ) );
    ?>

    <?php if ( $landing_posts ) : ?>
        <h2 class="section-heading">Explore kit ideas for calmer family time</h2>
        <div class="kits-grid">
            <?php foreach ( $landing_posts as $lp ) : ?>
                <article class="kit-card">
                    <?php if ( has_post_thumbnail( $lp->ID ) ) : ?>
                        <a href="<?php echo esc_url( get_permalink( $lp->ID ) ); ?>">
                            <?php echo get_the_post_thumbnail( $lp->ID, 'medium' ); ?>
                        </a>
                    <?php else : ?>
                        <img
                            src="https://placehold.co/600x360/2D6A4F/D8F3DC?text=<?php echo rawurlencode( get_the_title( $lp->ID ) ); ?>"
                            alt="<?php echo esc_attr( get_the_title( $lp->ID ) ); ?>">
                    <?php endif; ?>

                    <div class="kit-card-body">
                        <h3>
                            <a href="<?php echo esc_url( get_permalink( $lp->ID ) ); ?>">
                                <?php echo esc_html( get_the_title( $lp->ID ) ); ?>
                            </a>
                        </h3>
                        <p><?php echo esc_html( wp_trim_words( get_the_excerpt( $lp->ID ), 20, '…' ) ); ?></p>
                        <a class="read-more" href="<?php echo esc_url( get_permalink( $lp->ID ) ); ?>">Read more &rarr;</a>
                    </div>
                </article>
            <?php endforeach;
            wp_reset_postdata(); ?>
        </div>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
