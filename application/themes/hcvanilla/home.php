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
                    <div class="hc-hero-text">
                    <?php
                        $a = new Area('Hero Text');
                        $a->display($c);
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="hc-image-slider container">
        <?php
        $a = new Area('Slider');
        $a->enableGridContainer();
        $a->setCustomTemplate('image_slider', 'hatcai');
        $a->display($c);
        ?>
    </section>
    <section class="hc-features container">
        <div class="row">
            <div class="xs-12 md-6">
                <div class="row">
                    <div class="xs-12 no-padding-xs no-padding-sm md-offset-4 md-8">
                        <div class="hc-features-title">
                            <?php
                            $a = new Area('Features 1 Title');
                            $a->setCustomTemplate('content', 'paragraphs');
                            $a->display($c);
                            ?>
                        </div>
                    </div>
                    <div class="xs-12 no-padding-xs no-padding-sm hc-features-image">
                        <?php
                        $a = new Area('Feature 1 Image');
                        $a->setCustomTemplate('image', 'hatcai');
                        $a->display($c);
                        ?>
                    </div>
                </div>
            </div>
            <div class="xs-12 md-6 hc-features-text">
                <?php
                $a = new Area('Feature 1 Text');
                $a->setCustomTemplate('content', 'paragraphs');
                $a->display($c);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="xs-12 md-7">
                <div class="row">
                    <div class="xs-12 no-padding-xs no-padding-sm md-8">
                        <div class="hc-features-title">
                            <?php
                            $a = new Area('Features 2 Title');
                            $a->setCustomTemplate('content', 'paragraphs');
                            $a->display($c);
                            ?>
                        </div>
                    </div>
                    <div class="xs-12 no-padding-xs no-padding-sm md-10 hc-features-image">
                        <?php
                        $a = new Area('Features 2 Image');
                        $a->setCustomTemplate('image', 'hatcai');
                        $a->display($c);
                        ?>
                    </div>
                </div>
            </div>
            <div class="xs-12 md-5 hc-features-text first-md">
                <?php
                $a = new Area('Features 2 Text');
                $a->setCustomTemplate('content', 'paragraphs');
                $a->display($c);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="xs-12 md-offset-1 md-6">
                <div class="row">
                    <div class="xs-12 no-padding-xs no-padding-sm md-offset-5 md-7">
                        <div class="hc-features-title">
                            <?php
                            $a = new Area('Features 3 Title');
                            $a->setCustomTemplate('content', 'paragraphs');
                            $a->display($c);
                            ?>
                        </div>
                    </div>
                    <div class="xs-12 no-padding-xs no-padding-sm hc-features-image">
                        <?php
                        $a = new Area('Features 3 Image');
                        $a->setCustomTemplate('image', 'hatcai');
                        $a->display($c);
                        ?>
                    </div>
                </div>
            </div>
            <div class="xs-12 md-5 hc-features-text ">
                <?php
                $a = new Area('Features 3 Text');
                $a->setCustomTemplate('content', 'paragraphs');
                $a->display($c);
                ?>
            </div>
        </div>
    </section>
</main>

<?php  $this->inc('elements/footer.php'); ?>
