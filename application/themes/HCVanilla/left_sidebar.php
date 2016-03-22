<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>

<main class="hc-main">
    <?php
    $a = new Area('Page Header');
    $a->enableGridContainer();
    $a->display($c);
    ?>
    <div class="container">
        <div class="row">
            <div class="md-3 col-sidebar">
                <?php
                $a = new Area('Sidebar');
                $a->display($c);
                ?>
            </div>
            <div class="md-8 sm-offset-1 col-content">
                <?php
                $a = new Area('Main');
                $a->setAreaGridMaximumColumns(12);
                $a->display($c);
                ?>
            </div>
        </div>
    </div>

    <?php
    $a = new Area('Page Footer');
    $a->enableGridContainer();
    $a->display($c);
    ?>

</main>

<?php  $this->inc('elements/footer.php'); ?>
