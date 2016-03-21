<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>

<main class="hc-main">
    <div class="container">
        <div class="row">
            <div class="sm-12">

                <?php Loader::element('system_errors', array('format' => 'block', 'error' => $error, 'success' => $success, 'message' => $message)); ?>

                <?php print $innerContent; ?>
            </div>
        </div>
    </div>
</main>

<?php  $this->inc('elements/footer.php'); ?>
