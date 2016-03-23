<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div id="ccm-block-social-links<?php echo $bID?>" class="ccm-block-social-links">
    <div class="row between-xs">
        <div class="hc-list-group"
        <?php foreach($links as $link) {
            $service = $link->getServiceObject();
            ?>
            <a target="_blank" href="<?php echo h($link->getURL()); ?>"><?php echo $service->getServiceIconHTML(); ?></a>
        <?php } ?>
        </div>
    <div>
</div>