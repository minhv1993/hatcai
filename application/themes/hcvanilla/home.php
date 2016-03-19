<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>

<main class="hc-main hc-home">
    <section class="hc-hero parallax">
        <div class="parallax-layer parallax parallax-layer-1 hc-hero-image">
        </div>
        <div class="parallax-layer parallax-layer-0 container">
            <div class="row full-height-xs full-height-sm full-height-md full-height-lg full-height-xl">
                <div class="xs-12 sm-12 md-5 no-padding-xs no-padding-sm full-height-xs full-height-sm full-height-md full-height-lg full-height-xl">
                    <div class="hc-hero-text"></div>
                </div>
            </div>
        </div>
    </section>
    <section class="hc-image-slider container">
        <?php
        $a = new Area('Slider');
        $a->enableGridContainer();
        $a->display($c);
        ?>
    </section>
    <section class="hc-features">
        <?php
        $a = new Area('Features');
        $a->enableGridContainer();
        $a->display($c);
        ?>
    </section>
    <section class="hc-page-footer container">
        <?php
        $a = new Area('Page Footer');
        $a->enableGridContainer();
        $a->display($c);
        ?>
    </section>
</main>

<?php  $this->inc('elements/footer.php'); ?>
