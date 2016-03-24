<?php defined('C5_EXECUTE') or die(_("Access Denied.")); 
use \Application\Block\Tabs\TabsHelper;

$tabsHelper = new TabsHelper($b);
$c = Page::getCurrentPage();
$b = Block::getByID(intval($bID), $c);
$a = $b->getBlockAreaObject(); 
$editModeClass = $c->isEditMode() ? 'editmode' : '';

//Clean up variables from controller so html is easier to work with...
$bID = intval($bID);
$tsID = intval($controller->tabSetID);

$tabsRS = $tabsHelper->loadTabs($tsID, $bID);

$tabs = array();
while ($tabRow = $tabsRS->fetchRow()) {
	$tab = $tabRow;
	$tab['htmlTabId'] = $tab['tabIdStr'] ? $tab['tabIdStr'] : 'tab-'.intval($tab['msqID']);
	$tab['htmlContentId'] = $tab['tabIdStr'] ? $tab['tabIdStr'].'-content' : 'tab-'.intval($tab['msqID']).'-content';
	$tab['areaName'] = $tab['tabName'].' Content';
	$tabs[] = $tab;
}
?>
<div class="hc-tabs-block <?php echo $editModeClass; ?>">
	<ul class="hc-tabs">
		<?php $index = 0; foreach ($tabs as $tab): ?>
			<li class="hc-tabs-tab <?php echo (!$editModeClass && $index == 0 ? 'active': ''); ?>" id="<?php echo $tabs['htmlTabId'];?>">
				<?php echo $tab['tabName']; ?>
			</li>
		<?php  $index++; endforeach; ?>
	</ul>
	<?php $index = 0; foreach ($tabs as $tab): ?>
	<section class="hc-tabs-content <?php echo (!$editModeClass && $index == 0 ? 'active': ''); echo $editModeClass; ?>" id="<?php echo $tabs['htmlContentId'];?>">
		<?php 
		if($c->isEditMode()){ echo '<div>'; }
		$a = new Area($tab['areaName']);
		$a->enableGridContainer();
		$a->display($a->getAreaHandle()); 
		if($c->isEditMode()){ echo '</div>'; }?>
	</section>
	<?php  $index++; endforeach; ?>
</div>
