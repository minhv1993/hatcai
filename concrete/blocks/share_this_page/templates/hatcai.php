<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="ccm-block-share-this-page">
    <div class="row betweeen-xs">
        <div class="hc-list-group">
        <?php foreach($selected as $service) { ?>
            <a href="<?php echo h($service->getServiceLink()) ?>"><?php echo $service->getServiceIconHTML()?></a>
        <?php } ?>
        </div>
    </div>
</div>