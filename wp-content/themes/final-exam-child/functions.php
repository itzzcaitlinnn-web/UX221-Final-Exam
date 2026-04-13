<?php
/**
 * Kits for Family Times – child theme functions.
 *
 * Enqueues parent (wpico) + child styles and the custom-elements script.
 * Adds a favicon. On first admin load after activation (or version bump),
 * creates all sample pages and posts automatically.
 */

/* ─── Content version – bump to force a fresh install ───────────────────── */
define( 'KITS_FAMILY_CONTENT_VERSION', '2.0' );

/* ─── Enqueue styles + scripts ───────────────────────────────────────────── */
add_action( 'wp_enqueue_scripts', 'kits_family_enqueue_assets' );
function kits_family_enqueue_assets() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style(
        'kits-family-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'parent-style' )
    );
    wp_enqueue_script(
        'kits-family-custom-elements',
        get_stylesheet_directory_uri() . '/customElements.js',
        array(),
        null,
        true  /* load in footer */
    );
}

/* ─── Favicon ────────────────────────────────────────────────────────────── */
add_action( 'wp_head', 'kits_family_favicon' );
function kits_family_favicon() {
    echo '<link rel="icon" href="' . esc_url( get_stylesheet_directory_uri() . '/favicon.svg' ) . '" type="image/svg+xml">' . "\n";
}

/* ─── Demo content: install on theme switch + admin_init version check ───── */
add_action( 'after_switch_theme', 'kits_family_maybe_install_demo' );
add_action( 'admin_init',         'kits_family_maybe_install_demo' );

function kits_family_maybe_install_demo() {
    if ( get_option( 'kits_family_content_version' ) === KITS_FAMILY_CONTENT_VERSION ) {
        return;
    }
    kits_family_install_demo();
    update_option( 'kits_family_content_version', KITS_FAMILY_CONTENT_VERSION );
}

/* ─── Master installer ───────────────────────────────────────────────────── */
function kits_family_install_demo() {
    $landing_cat  = kits_family_get_or_create_cat( 'Landing Kits',  'landing-kits' );
    $product_cat  = kits_family_get_or_create_cat( 'Product Kits',  'product-kits' );

    /* ── Pages ── */
    $home_id = kits_family_upsert_page(
        'Kits for Family Times',
        '<p>Build calm at-home rituals with ready-made family kits. Whether you want to craft, play, or simply breathe together, you\'ll find a kit that fits your evening.</p>',
        'home'
    );

    if ( $home_id ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $home_id );
    }

    kits_family_upsert_page(
        'Family Kit Shop',
        '<p>Browse our collection of hands-on family kits designed to reduce stress, spark creativity, and make at-home time feel easy and enjoyable.</p>',
        'shop'
    );

    kits_family_upsert_page(
        'Kit Developer Registration',
        '<p>Do you have ideas for kits that help families slow down and connect? Tell us in about 100 words why you\'d be a great kit developer and we\'ll be in touch.</p>',
        'kit-developer-registration'
    );

    /* ── 5 Landing posts – editorial angle: kits + stress relief ── */
    kits_family_upsert_post(
        'How Family Craft Kits Help You Manage Stress at Home',
        <<<'HTML'
<!-- wp:image {"align":"wide"} -->
<figure class="wp-block-image alignwide">
<img src="https://placehold.co/1200x600/2D6A4F/D8F3DC?text=Craft+Kits+%26+Stress+Relief" alt="Family doing a craft kit together at the kitchen table" />
</figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>Life gets busy. Between work deadlines, school runs, and the constant buzz of notifications, it can feel impossible to simply exhale. That is exactly where a family craft kit earns its place on the kitchen table.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Research consistently shows that hands-on creative activity lowers cortisol — the body's primary stress hormone. When parents and children sit down together to cut, paint, or assemble something, their nervous systems shift. Conversation slows. Screens disappear. The task in front of them becomes the only thing that matters.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>Why "doing" beats "watching" for stress relief</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Passive entertainment — scrolling, streaming — can feel relaxing in the moment but rarely leaves people feeling restored. A craft kit asks something different of you: your hands, your attention, your ideas. That small demand is what makes the difference. Families who build things together report feeling more connected and less anxious than those who spend the same amount of time in front of a screen.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Our landing kits are designed with busy households in mind. All materials are pre-sorted. Instructions are simple. The goal is to lower the barrier to creative time so that even a thirty-minute window becomes genuinely restorative.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>Getting started tonight</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>You do not need a special occasion. Pull out a kit, clear a corner of the table, and let the evening look after itself. Browse our collection to find a kit that fits your family's mood right now.</p>
<!-- /wp:paragraph -->
HTML,
        'Discover how hands-on family craft kits reduce stress hormones, build connection, and turn ordinary evenings into calm, restorative moments at home.',
        'how-family-craft-kits-help-manage-stress',
        $landing_cat
    );

    kits_family_upsert_post(
        'Mindful Building: Why DIY Kits Ease Anxiety for the Whole Family',
        <<<'HTML'
<!-- wp:image {"align":"wide"} -->
<figure class="wp-block-image alignwide">
<img src="https://placehold.co/1200x600/2D6A4F/D8F3DC?text=Mindful+Building+for+Families" alt="Child and parent assembling a kit together" />
</figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>Anxiety thrives on uncertainty. One of the most reliable ways to interrupt an anxious spiral — for children and adults alike — is to give the mind a clear, achievable task. That is the quiet magic behind a well-designed DIY kit.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>When you follow a step-by-step project, your prefrontal cortex — the planning and problem-solving part of your brain — takes over from the amygdala, which drives the fight-or-flight response. The result is a natural, medication-free shift toward calm.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>Kits as a family mindfulness practice</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Mindfulness does not have to mean sitting still. For many families, especially those with younger children, mindful building — paying close attention to what your hands are doing — is far more accessible than formal meditation. A kit provides the structure that makes this possible without effort or planning.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Children who regularly engage in focused hands-on play show measurable improvements in attention and emotional regulation. Parents report that building sessions feel like a shared reset button — a way to leave the day's noise behind and simply be present with the people they love most.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>Find a kit that fits your family</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Our curated collection of family kits is designed to make mindful building easy. Each kit includes everything you need, so the first step is the only barrier. Visit the shop to explore options for all ages and interests.</p>
<!-- /wp:paragraph -->
HTML,
        'Learn why step-by-step DIY kits are a proven way to ease anxiety in children and parents, turning focused hands-on building into a family mindfulness practice.',
        'mindful-building-diy-kits-ease-anxiety',
        $landing_cat
    );

    kits_family_upsert_post(
        'Calm Evenings Start Here: Kit Activities That Transform Stressful Nights',
        <<<'HTML'
<!-- wp:image {"align":"wide"} -->
<figure class="wp-block-image alignwide">
<img src="https://placehold.co/1200x600/2D6A4F/D8F3DC?text=Calm+Evening+Kit+Activities" alt="Warm kitchen table with a family kit laid out for the evening" />
</figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>The hours between dinner and bedtime can feel like the hardest part of the day. Everyone is tired, everyone is a little short-tempered, and the temptation to retreat to separate screens is very real. A family kit can change the entire texture of that time.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Transitioning from high-stress mode to rest mode requires something that occupies the hands while quieting the mind. That is not usually a conversation or a movie. It is something you make together — something that leaves a small, satisfying result behind.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>The ritual effect</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Rituals — even tiny, informal ones — reduce anxiety by creating predictability. When children know that after dinner there is kit time, the transition becomes easier. Their nervous systems begin to anticipate calm rather than conflict. Over weeks, the kit table becomes a genuinely comforting place.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Parents tell us that having a kit ready to open is the difference between a chaotic evening and one they actually enjoy. The preparation is done for them. There is nothing to organise. All that remains is to sit down together and begin.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>Shop calm evening kits</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Browse our full collection of evening kits designed for families of all sizes. Each one is compact, mess-controlled, and built around the idea that the best family time does not require effort — just a little intention.</p>
<!-- /wp:paragraph -->
HTML,
        'Discover how a simple family kit can transform chaotic evenings into calm, connected rituals that help kids and parents decompress together after a long day.',
        'calm-evenings-kit-activities-stressful-nights',
        $landing_cat
    );

    kits_family_upsert_post(
        'Screen-Free and Stress-Free: Why Family Kits Work When Nothing Else Does',
        <<<'HTML'
<!-- wp:image {"align":"wide"} -->
<figure class="wp-block-image alignwide">
<img src="https://placehold.co/1200x600/2D6A4F/D8F3DC?text=Screen-Free+Family+Kit+Time" alt="Family gathered around a table working on a kit without screens" />
</figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>Screens are not inherently bad. But when a household reaches for a device every time stress levels rise, the underlying tension never actually gets released — it just gets postponed. Family kits offer a different path.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>The physical act of making something — cutting, folding, painting, assembling — provides a sensory outlet that digital content cannot replicate. Tactile engagement activates the parasympathetic nervous system, the branch responsible for rest and recovery. This is why people feel genuinely better after a crafting session, not just distracted.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>What families say</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Families who introduce a weekly kit night consistently report the same shift: children argue less, sleep better, and talk more openly. Parents describe feeling less isolated and more like a team. These are not small outcomes — they are the things most families quietly wish for and rarely find in a subscription box or a streaming service.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>Low prep, high payoff</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Our kits are designed for real households where time and energy are limited. Everything arrives pre-sorted. Instructions are clear enough for children to lead. The adult's only job is to show up — and that is more than enough.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Ready to try a screen-free evening? Browse the kit shop and find the one that fits your family best.</p>
<!-- /wp:paragraph -->
HTML,
        'Find out why hands-on family kits outperform screen time for stress relief, explaining the science behind tactile play and how kit nights improve mood and sleep for kids and parents.',
        'screen-free-stress-free-family-kits',
        $landing_cat
    );

    kits_family_upsert_post(
        'Weekend Reset: Five Ways a Family Kit Helps You Recover from a Hard Week',
        <<<'HTML'
<!-- wp:image {"align":"wide"} -->
<figure class="wp-block-image alignwide">
<img src="https://placehold.co/1200x600/2D6A4F/D8F3DC?text=Weekend+Reset+Family+Kits" alt="Family relaxing on the weekend with a creative kit project" />
</figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>By the time the weekend arrives, most families are running on empty. The to-do list is still long, the children are restless, and the idea of planning a meaningful activity feels like one more task. A family kit solves all of that in one step.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>Five ways kits help you reset</h2>
<!-- /wp:heading -->

<!-- wp:list {"ordered":true} -->
<ol>
<li><strong>No planning needed.</strong> Open the box and start. The kit has already done the thinking.</li>
<li><strong>Slows the pace.</strong> Hands-on projects naturally resist rushing. The family settles into a slower rhythm without being told to.</li>
<li><strong>Opens conversation.</strong> Side-by-side activity is one of the best conditions for genuine family conversation. Talking while building is easier than talking face-to-face.</li>
<li><strong>Creates a shared memory.</strong> A finished kit — a painting, a puppet, a pressed-flower page — becomes a small anchor of "remember when we made this?" in years to come.</li>
<li><strong>Ends with something.</strong> The feeling of completing a project together, however small, builds confidence and a quiet sense of accomplishment for every member of the family.</li>
</ol>
<!-- /wp:list -->

<!-- wp:heading {"level":2} -->
<h2>Make this weekend different</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Pick a kit, clear an hour, and let the weekend shift from recovery mode to restoration mode. Browse the full family kit collection and find what suits your household right now.</p>
<!-- /wp:paragraph -->
HTML,
        'Explore five simple ways a family kit helps everyone reset after a hard week — no planning, slower pace, real conversation, shared memories, and the satisfaction of finishing something together.',
        'weekend-reset-family-kit-recovery',
        $landing_cat
    );

    /* ── 5 Product kit posts ── */
    kits_family_upsert_post(
        'The Calm Crafters Family Kit',
        <<<'HTML'
<!-- wp:image {"align":"wide"} -->
<figure class="wp-block-image alignwide">
<img src="https://placehold.co/1200x600/F4A261/1B4332?text=Calm+Crafters+Kit" alt="Calm Crafters Family Kit contents laid out on a table" />
</figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>The Calm Crafters Kit is our most popular starter kit for families who want to build a weekly creative ritual without any fuss. It includes watercolour cards, pre-cut felt shapes, two brushes, a mixing palette, and a printed prompt card with four gentle activity ideas.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Designed for children aged 5 and up with a grown-up alongside. All materials are non-toxic and mess-controlled. Total build time: 30–45 minutes per session. The kit includes enough materials for two full evenings of creative play.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>What's in the kit</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li>6 watercolour card sheets (A5)</li>
<li>Assorted pre-cut felt shapes</li>
<li>2 paint brushes</li>
<li>1 mixing palette</li>
<li>Small tubes of non-toxic watercolour paint (6 colours)</li>
<li>Activity prompt card</li>
</ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>Perfect for: families with young children, first-time kit builders, and anyone looking for a calm mid-week reset.</p>
<!-- /wp:paragraph -->
HTML,
        'The Calm Crafters Kit includes watercolour cards, felt shapes, brushes, and paint for two evenings of gentle family creativity designed to ease stress and spark connection.',
        'calm-crafters-family-kit',
        $product_cat
    );

    kits_family_upsert_post(
        'Sensory Calm Jar Kit',
        <<<'HTML'
<!-- wp:image {"align":"wide"} -->
<figure class="wp-block-image alignwide">
<img src="https://placehold.co/1200x600/F4A261/1B4332?text=Sensory+Calm+Jar+Kit" alt="Sensory calm jar kit with glitter and a glass jar" />
</figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>A calm jar — sometimes called a glitter jar or mind jar — is one of the most effective stress-relief tools for children and adults alike. Watching the glitter slowly settle mirrors the experience of a racing mind finding stillness. Building one together makes it even more meaningful.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>This kit includes a clear glass jar with a sealed lid, fine biodegradable glitter in three colours, a bottle of calm-jar liquid (pre-mixed with glycerin), and a card explaining how to use the jar during anxious moments. The build takes about twenty minutes and can be done at any age.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>What's in the kit</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li>1 clear glass jar with sealable lid</li>
<li>Fine biodegradable glitter (3 colours)</li>
<li>Pre-mixed calm jar liquid (glycerin blend)</li>
<li>Instruction and usage card</li>
<li>Decorative labels (pack of 4)</li>
</ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>Great for: children aged 4 and up, families dealing with big emotions, and parents looking for a simple grounding tool they can use together.</p>
<!-- /wp:paragraph -->
HTML,
        'Build a beautiful sensory calm jar together — a gentle stress-relief tool for children and parents that takes just 20 minutes and lasts for years.',
        'sensory-calm-jar-kit',
        $product_cat
    );

    kits_family_upsert_post(
        'Build-A-Story Puppet Kit',
        <<<'HTML'
<!-- wp:image {"align":"wide"} -->
<figure class="wp-block-image alignwide">
<img src="https://placehold.co/1200x600/F4A261/1B4332?text=Build-A-Story+Puppet+Kit" alt="Colourful handmade puppets from the Build-A-Story Kit" />
</figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>Storytelling is one of the oldest ways human beings process difficult feelings. For children especially, giving a worry or a fear to a puppet — and then deciding what happens next — can be remarkably healing. The Build-A-Story Puppet Kit makes this easy and genuinely fun.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>The kit includes pre-cut felt puppet bodies, googly eyes, yarn for hair, fabric glue, and a set of story-starter cards with simple prompts to get the narrative flowing. Children design their own characters and then — guided gently by the story cards — act out a short tale together.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>What's in the kit</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li>4 pre-cut felt puppet body shapes</li>
<li>Assorted googly eyes, buttons, yarn</li>
<li>Non-toxic fabric glue</li>
<li>12 story-starter prompt cards</li>
<li>Simple illustrated instruction sheet</li>
</ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>Ideal for: families with children aged 4–10, playful parents, and anyone who finds it easier to talk through feelings in character.</p>
<!-- /wp:paragraph -->
HTML,
        'Make four felt puppets and tell a story together with this imaginative family kit that helps children process big feelings through creative, character-led play.',
        'build-a-story-puppet-kit',
        $product_cat
    );

    kits_family_upsert_post(
        'Nature Press and Print Kit',
        <<<'HTML'
<!-- wp:image {"align":"wide"} -->
<figure class="wp-block-image alignwide">
<img src="https://placehold.co/1200x600/F4A261/1B4332?text=Nature+Press+%26+Print+Kit" alt="Pressed leaves and nature prints from the Nature Press and Print Kit" />
</figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>There is a long tradition of using nature as a way to ground ourselves when life feels overwhelming. The Nature Press and Print Kit combines a gentle outdoor gathering walk with a quiet at-home craft session — giving families two opportunities to slow down and reconnect with something steady.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Collect leaves, petals, or small flowers on a neighbourhood walk. Bring them home and press them using the included pressing boards and absorbent paper. Once pressed, use the ink pads and card sheets included to create nature prints — simple, beautiful, and deeply calming to make.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>What's in the kit</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li>2 wooden pressing boards with butterfly screws</li>
<li>12 absorbent pressing sheets</li>
<li>3 ink pads (forest green, terracotta, sky blue)</li>
<li>10 blank card sheets for printing</li>
<li>Activity and ideas booklet</li>
</ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>Perfect for: families with outdoor access, nature-loving children, and anyone who finds calm in slow, tactile work.</p>
<!-- /wp:paragraph -->
HTML,
        'Collect, press, and print with this two-part nature kit that combines a calming outdoor walk with a quiet at-home craft session for the whole family.',
        'nature-press-and-print-kit',
        $product_cat
    );

    kits_family_upsert_post(
        'Family Gratitude Journal Kit',
        <<<'HTML'
<!-- wp:image {"align":"wide"} -->
<figure class="wp-block-image alignwide">
<img src="https://placehold.co/1200x600/F4A261/1B4332?text=Family+Gratitude+Journal+Kit" alt="Decorated family gratitude journals from the kit" />
</figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>Gratitude practice is one of the most evidence-backed tools for improving wellbeing in both adults and children. A regular habit of noticing good things — however small — literally rewires the brain toward optimism over time. This kit makes building that habit a family activity rather than a solitary one.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Each kit contains four blank softcover journals (one per family member), a set of decorating materials to personalise the covers, and a card of weekly reflection prompts designed to spark gentle, positive conversation at the table. Building the journals together is part of the ritual — the decoration session signals that this is something the family cares about.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2>What's in the kit</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li>4 blank softcover journals (A6, 60 pages each)</li>
<li>Sticker sheets, washi tape, and stamp set</li>
<li>Coloured pens (6 colours)</li>
<li>52 weekly gratitude prompt cards</li>
<li>Getting-started guide for families</li>
</ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>Great for: all ages from 5 upwards, families wanting a lasting wellbeing habit, and households going through stressful transitions.</p>
<!-- /wp:paragraph -->
HTML,
        'Build a shared family gratitude practice with four personalised journals, weekly prompt cards, and decorating materials — a kit designed to reduce stress and strengthen connection over time.',
        'family-gratitude-journal-kit',
        $product_cat
    );
}

/* ─── Helper: get or create category ────────────────────────────────────── */
function kits_family_get_or_create_cat( $name, $slug ) {
    $term = get_term_by( 'slug', $slug, 'category' );
    if ( $term ) {
        return $term->term_id;
    }
    $new = wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
    return ( ! is_wp_error( $new ) && isset( $new['term_id'] ) ) ? $new['term_id'] : 0;
}

/* ─── Helper: create or update a page ───────────────────────────────────── */
function kits_family_upsert_page( $title, $content, $slug ) {
    $existing = get_page_by_path( $slug, OBJECT, 'page' );
    if ( $existing ) {
        wp_update_post( array(
            'ID'           => $existing->ID,
            'post_title'   => $title,
            'post_content' => $content,
            'post_status'  => 'publish',
        ) );
        return $existing->ID;
    }
    $id = wp_insert_post( array(
        'post_title'   => $title,
        'post_content' => $content,
        'post_name'    => $slug,
        'post_type'    => 'page',
        'post_status'  => 'publish',
    ) );
    return is_wp_error( $id ) ? 0 : $id;
}

/* ─── Helper: create or update a post ───────────────────────────────────── */
function kits_family_upsert_post( $title, $content, $excerpt, $slug, $category_id = 0 ) {
    $existing = get_page_by_path( $slug, OBJECT, 'post' );
    if ( $existing ) {
        wp_update_post( array(
            'ID'           => $existing->ID,
            'post_title'   => $title,
            'post_content' => $content,
            'post_excerpt' => $excerpt,
            'post_status'  => 'publish',
        ) );
        if ( $category_id ) {
            wp_set_post_categories( $existing->ID, array( $category_id ), false );
        }
        return $existing->ID;
    }
    $id = wp_insert_post( array(
        'post_title'   => $title,
        'post_content' => $content,
        'post_excerpt' => $excerpt,
        'post_name'    => $slug,
        'post_type'    => 'post',
        'post_status'  => 'publish',
    ) );
    if ( ! is_wp_error( $id ) && $category_id ) {
        wp_set_post_categories( $id, array( $category_id ), false );
    }
    return is_wp_error( $id ) ? 0 : $id;
}
