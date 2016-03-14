<?php defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header_top.php');
$as = new GlobalArea('Header Search');
$blocks = $as->getTotalBlocksInArea();
$displayThirdColumn = $blocks > 0 || $c->isEditMode();

?>

<header class="hc-header">
    <div class="container">
        <div class="row bottom-xs">
            <div class="xs-12 sm-4">
                <a class="hc-logo" href="/">
                    <span class="logo-top">Hạt Cải</span>
                    <span class="logo-bottom">Mustard Seed</span>
                </a>
            </div>
            <div class="<?php if ($displayThirdColumn) { ?>xs-12 sm-5<?php } else { ?>xs-12 sm-8<?php } ?>">
                <?php
                $a = new GlobalArea('Header Navigation');
                $a->display();
                ?>
            </div>
            <?php if ($displayThirdColumn) { ?>
                <div class="xs-12 sm-3"><?php $as->display(); ?></div>
            <?php } ?>
        </div>
    </div>
</header>