<?php
/**
 * Kit Developer Registration page template (page slug: kit-developer-registration).
 *
 * Includes a 100-word summary form. Submissions are emailed to the site admin.
 * A live word-counter is provided via customElements.js.
 */

/* ── Handle form submission ─────────────────────────────────────────────── */
$form_submitted = false;
$form_error     = '';

if (
    isset( $_POST['kit_dev_nonce'] )
    && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kit_dev_nonce'] ) ), 'kit_dev_register' )
) {
    $dev_name    = sanitize_text_field( wp_unslash( $_POST['dev_name']    ?? '' ) );
    $dev_email   = sanitize_email(      wp_unslash( $_POST['dev_email']   ?? '' ) );
    $dev_summary = sanitize_textarea_field( wp_unslash( $_POST['dev_summary'] ?? '' ) );
    $word_count  = $dev_summary !== '' ? count( preg_split( '/\s+/', trim( $dev_summary ) ) ) : 0;

    if ( empty( $dev_name ) || empty( $dev_email ) || empty( $dev_summary ) ) {
        $form_error = 'Please fill in all fields before submitting.';
    } elseif ( ! is_email( $dev_email ) ) {
        $form_error = 'Please enter a valid email address.';
    } elseif ( $word_count < 80 || $word_count > 120 ) {
        $form_error = "Your summary is {$word_count} word(s). Please write between 80 and 120 words (aim for about 100).";
    } else {
        $admin_email = get_option( 'admin_email' );
        $subject     = 'New Kit Developer Application from ' . $dev_name;
        $body        = "Name: {$dev_name}\nEmail: {$dev_email}\n\nWhy I would make a great kit developer:\n\n{$dev_summary}";
        wp_mail( $admin_email, $subject, $body );
        $form_submitted = true;
    }
}

get_header();
?>

<main class="site-main">
    <div class="reg-wrap">

        <?php /* ── Page heading from WP editor ── */ ?>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <h1><?php the_title(); ?></h1>
            <div class="reg-intro"><?php the_content(); ?></div>
        <?php endwhile; endif; ?>

        <?php if ( $form_submitted ) : ?>

            <div class="reg-form">
                <div class="notice success">
                    <strong>Application received!</strong> Thank you for applying to become a kit developer.
                    We will be in touch at the email address you provided.
                </div>
                <p><a href="<?php echo esc_url( home_url( '/shop' ) ); ?>">&larr; Browse family kits while you wait</a></p>
            </div>

        <?php else : ?>

            <form class="reg-form" method="post" action="">
                <?php wp_nonce_field( 'kit_dev_register', 'kit_dev_nonce' ); ?>

                <?php if ( $form_error ) : ?>
                    <div class="notice error"><?php echo esc_html( $form_error ); ?></div>
                <?php endif; ?>

                <div class="form-row">
                    <label for="dev_name">Your name</label>
                    <input
                        type="text"
                        id="dev_name"
                        name="dev_name"
                        value="<?php echo esc_attr( $dev_name ?? '' ); ?>"
                        placeholder="First and last name"
                        required>
                </div>

                <div class="form-row">
                    <label for="dev_email">Email address</label>
                    <input
                        type="email"
                        id="dev_email"
                        name="dev_email"
                        value="<?php echo esc_attr( $dev_email ?? '' ); ?>"
                        placeholder="you@example.com"
                        required>
                </div>

                <div class="form-row">
                    <label for="dev_summary">
                        Why would you make a great kit developer?
                        <small style="font-weight:400; color:#4A6B55;"> (about 100 words)</small>
                    </label>
                    <textarea
                        id="dev_summary"
                        name="dev_summary"
                        placeholder="Tell us about your experience, your ideas for family kits, and what makes your kits special for busy or stressed-out families…"
                        required><?php echo esc_textarea( $dev_summary ?? '' ); ?></textarea>
                    <p class="word-count-hint">
                        Word count: <span id="word-count-display">0</span> / aim for 80–120
                    </p>
                </div>

                <button type="submit">Submit application</button>

            </form>

        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>
