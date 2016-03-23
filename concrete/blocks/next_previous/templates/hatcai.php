<?php defined('C5_EXECUTE') or die("Access Denied.");
      $nh = Loader::helper('navigation');
      $previousLinkURL = is_object($previousCollection) ? $nh->getLinkToCollection($previousCollection) : '';
      $parentLinkURL = is_object($parentCollection) ? $nh->getLinkToCollection($parentCollection) : '';
      $nextLinkURL = is_object($nextCollection) ? $nh->getLinkToCollection($nextCollection) : '';
      $previousLinkText = is_object($previousCollection) ? $previousCollection->getCollectionName() : '';
      $nextLinkText = is_object($nextCollection) ? $nextCollection->getCollectionName() : '';
?>

<?php if ($previousLinkURL || $nextLinkURL || $parentLinkText): ?>

<div class="ccm-block-next-previous-wrapper hc-block-next-previous">
    <div class="row">
        <?php if($previousLinkURL != '') {?>
        <div class="xs-6 sm-12">
            <a class="hc-previous-wrapper" href="<?php echo $previousLinkURL;?>" title="<?php echo $previousLabel?>">
                <span><?php echo $previousLinkText;?></span>
            </a>
        </div>
        <?php }?>
        <?php if($nextLinkURL != '') {?>
        <div class="<?php if($previousLinkURL == ''){echo "xs-offset-6";}?> xs-6 sm-12 ">
            <a class="hc-next-wrapper" href="<?php echo $nextLinkURL;?>" title="<?php echo $nextLabel?>">
                <span><?php echo $nextLinkText;?></span>
            </a>
        </div>
        <?php } ?>

        <?php if ($parentLinkText) { ?>
        <div class="xs-12">
            <?php echo $parentLinkURL ? '<a href="' . $parentLinkURL . '">' . $parentLinkText . '</a>' : '' ?>
        </div>
        <?php } ?>
    </div>
</div>

<?php endif; ?>
