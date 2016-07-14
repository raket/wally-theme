<?php get_header() ?>
    <div class="container">
        <div class="row">

            <section class="four-oh-four" role="region" aria-labelledby="page-title-404">
                <img src="<?php echo get_template_directory_uri() ?>/assets/images/question-mark.svg" alt="">
                <h1 id="page-title-404"><?php _e('Hoppsan - här var det tomt!', 'wally-theme') ?></h1>
                <p>
                    <?php _e('Innehållet du söker har troligtvis flyttats eller tagits bort.', 'wally-theme') ?><br>
                    <a href="<?php echo home_url() ?>">Tillbaka till startsidan</a>
                </p>
            </section>

        </div>
    </div>
<?php get_footer() ?>