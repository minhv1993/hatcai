<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header_top.php'); ?>

<main class="hc-main">
<?php
$a = new Area('Main');
$a->enableGridContainer();
$a->display($c);
?>
</main>

<?php  $this->inc('elements/footer_bottom.php'); ?>
