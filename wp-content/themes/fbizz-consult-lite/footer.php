<?php
/**
 * footer Template.
 *
 * @package fbizz-consult-lite
 */
?>
<?php
$fbizz_consult_lite_copyright = get_theme_mod('fbizz_consult_lite_copyright');
$fbizz_consult_lite_design    = get_theme_mod('fbizz_consult_lite_design');
?>
<?php if ($fbizz_consult_lite_copyright || $fbizz_consult_lite_design) { ?>
    <div class="footer-bottom">

        <div class="container">

            <div class="row">
                <div class="col-sm-12 col-xs-12 col-lg-12 col-md-12">

                    <div class="copyright text-center">


                        <?php if (get_theme_mod('fbizz_consult_lite_copyright')) { ?>
                            <?php echo esc_html($fbizz_consult_lite_copyright); ?>
                        <?php } ?>         
                    </div><!--copyright-->

                </div>
                
                <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">

                    <div class="design text-center">

                        <?php if (get_theme_mod('fbizz_consult_lite_design')) { ?>
                            <?php echo esc_html($fbizz_consult_lite_design); ?>
                        <?php } ?>

                    </div><!--design-->

                </div><!--col-sm-6-->

                



            </div><!--row-->

        </div><!--container-->

    </div><!--footer-bottom-->
    <?php
}?>
<?php wp_footer(); ?>
</body>
</html>