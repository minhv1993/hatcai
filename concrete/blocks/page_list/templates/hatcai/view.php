<?php defined('C5_EXECUTE') or die("Access Denied.");
$th = Loader::helper('text');
$c = Page::getCurrentPage();
$dh = Core::make('helper/date'); /* @var $dh \Concrete\Core\Localization\Service\Date */
?>

<div class="hc-block-page-list-wrapper">
    <?php if (isset($pageListTitle) && $pageListTitle){ ?>
        <div class="hc-block-page-list-header">
            <h5><?php echo h($pageListTitle)?></h5>
        </div>
    <?php } ?>
    <?php foreach ($pages as $page){
		$title = $th->entities($page->getCollectionName());
		$url = $nh->getLinkToCollection($page);
		$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
		$target = empty($target) ? '_self' : $target;
		$thumbnail = $page->getAttribute('thumbnail');
        $hoverLinkText = $title;
        $description = $page->getCollectionDescription();
        $description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
        $description = $th->entities($description);
        if ($useButtonForLink) {
            $hoverLinkText = $buttonLinkText;
        }
    	$date = $dh->formatDateTime($page->getCollectionDatePublic(), false, false);

        ?>

        <div class="hc-block-page-list-item">
            <a href="<?php echo $url ?>" target="<?php echo $target ?>">
                <div class="row">
                    <div class="xs-12 sm-3">
                        <?php if (is_object($thumbnail)){ ?>
                            <div class="hc-image-block" style="background-image: url(<?php echo $thumbnail->getRelativePath(); ?>)">
                            </div>
                        <?php } ?>
                    </div>
                    <div class="xs-8 sm-6 item-content item-title">
                        <?php echo $title; ?>
                    </div>
                    <div class="xs-4 sm-3 item-content item-date-publish">
                        <?php echo $date?>
                    </div>
                </div>
            </a>
        </div>
	<?php } ?>
</div>

<?php if ($showPagination) { 
    echo $pagination;
} ?>

<?php if ( $c->isEditMode() && $controller->isBlockEmpty()){
    print '<div class="ccm-edit-mode-disabled-item">'.t('Empty Page List Block.').'</div>';
} ?>