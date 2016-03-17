<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>

<main class="hc-main">
    <section class="hc-hero parallax">
        <div class="parallax-layer parallax parallax-layer-1 hc-hero-image">
        </div>
        <div class="parallax-layer parallax-layer-0">
            <div class="row">
                <div class="xs-12 md-4">
                    <section class="container hc-hero-text">
                        <?php
                        $a = new Area('Hero');
                        $a->display($c);
                        ?>
                    </section>
                </div>
            </div>
        </div>
    </section>
    <section class="hc-features container">
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
