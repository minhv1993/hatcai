<?php  defined('C5_EXECUTE') or die("Access Denied.");
$dh = Core::make('helper/date'); /* @var $dh \Concrete\Core\Localization\Service\Date */
$page = Page::getCurrentPage();
$date = $dh->formatDate($page->getCollectionDatePublic(), true);
$user = UserInfo::getByID($page->getCollectionUserID());
$thumbnail = $page->getAttribute("thumbnail");
$excludePublishInfo = $page->getAttribute("exclude_publish_info");
?>
<div class="hc-block-page-title">
    <div class="row">
        <div class="xs-8 sm-7 md-6 hc-page-info">
            <div class="hc-page-info-wrapper">
                <h1 class="page-title"><?php echo h($title)?></h1>
                <?php if($excludePublishInfo == 0) { ?>
                    <div class="hc-page-publication-wrapper"><span><span class="page-date"><?php print $date; ?></span> //

                    <?php if (is_object($user)) { ?>
                        <span class="page-author"><?php print $user->getUserDisplayName(); ?></span>
                    <?php } ?>
                    </span></div>
                <?php }?>
            </div>
        </div>
        <!-- Thumbmails -->
        <?php if($thumbnail){ ?>
            <div class="xs-offset-1 xs-11 no-padding-xs sm-offset-2 sm-10 no-padding-sm md-offset-3 md-9 hc-page-thumbnail">
                <div class="hc-image-block" style="background-image: url(<?php echo $thumbnail->getRelativePath(); ?>)"></div>
        <?php } else { ?>
            <div class="xs-offset-1 xs-11 no-padding-xs no-padding-sm hc-page-thumbnail">
                <div class="hc-page-title-placeholder"></div>
        <?php } ?>
        </div>
    </div>
</div>
