<?php   defined('C5_EXECUTE') or die(_("Access Denied."));
$uh = Loader::helper('concrete/urls');
$form = Loader::helper('form');
$ih = Loader::helper('concrete/ui');
$a = $view->getAreaObject();
$bt = BlockType::getByHandle('tabs');
$c = Page::getCurrentPage();

$addSelected = true;
?>

<p>
<?php print Loader::helper('concrete/ui')->tabs(array(
	array('tab-add', t('Add'), $addSelected),
	array('tab-edit', t('Edit')),
	array('tab-preview', t('Preview'))
));?>
</p>
<input type="hidden" name="tabsHelperServices" value="<?php echo $uh->getBlockTypeToolsURL($bt)?>/services" />
<?php /* these question ids have been deleted, or edited, and so shouldn't be duplicated for block versioning */ ?>
<input type="hidden" id="ccm-ignoreTabIDs" name="ignoreTabIDs" value="" />
<input type="hidden" id="ccm-pendingDeleteIDs" name="pendingDeleteIDs" value="" />
<input type="hidden" id="tsID" name="tsID" type="text" value="<?php echo intval($tabsHelperInfo['tabSetID'])?>" />
<input type="hidden" id="oldTsID" name="oldTsID" type="text" value="<?php echo intval($tabsHelperInfo['tabSetID'])?>" />
<input type="hidden" id="msqID" name="msqID" type="text" value="<?php echo intval($msqID)?>" />

<div class="ccm-tab-content" id="ccm-tab-content-tab-add">
	<fieldset id="addTabForm">
		<legend><?php echo t('New Tab')?></legend>		
		<div id="tabAddedMsg" class="alert alert alert-info" style="display:none">
			<?php echo t('Tab added. To view it click the preview tab.')?>
		</div>

		<div class="form-group">
			<?php echo $form->label('tabName', t('Tab Name'))?>
			<?php echo $form->text('tabName', array('maxlength' => '255'))?>
		</div>
		<div class="form-group">
			<?php echo $form->label('tabIdStr', t('Tab Id String'))?>
			<?php echo $form->text('tabIdStr', array('maxlength' => '255'))?>
		</div>
		<div class="form-group">
			<?php echo $ih->button(t('Add Tab'), '#', '', '', array('id' => 'addTab'))?>
		</div>
		<input type="hidden" id="position" name="position" value="1000" />
	</fieldset>
</div>
<div class="ccm-tab-content" id="ccm-tab-content-tab-edit">
	<fieldset id="editTabForm" style="display:none">
		<legend><?php echo t('Edit Tab')?></legend>		
		<div id="tabEditedMsg" class="alert alert alert-info" style="display:none">
			<?php echo t('Tab added. To view it click the preview tab.')?>
		</div>

		<div class="form-group">
			<?php echo $form->label('tabNameEdit', t('Tab Name'))?>
			<?php echo $form->text('tabNameEdit', array('maxlength' => '255'))?>
		</div>
		<div class="form-group">
			<?php echo $form->label('tabIdStrEdit', t('Tab Id String'))?>
			<?php echo $form->text('tabIdStrEdit', array('maxlength' => '255'))?>
		</div>
		<div>
			<?php echo $ih->button(t('Cancel'), 'javascript:void(0)', 'left', '', array('id' => 'cancelEditTab'))?>
			<?php echo $ih->button(t('Save Changes'), 'javascript:void(0)', 'right', 'primary', array('id' => 'editTab'))?>
		</div>
		<input type="hidden" id="positionEdit" name="position" value="1000" />
	</fieldset>
	<div id="editTabsTable">
		<fieldset>
			<legend><?php echo t('Edit Tabs')?></legend>
			<div id="editTabsTableWrap"></div>
		</fieldset>
	</div>
</div>
<div class="ccm-tab-content" id="ccm-tab-content-tab-preview">
	<fieldset>
		<legend><?php echo t('Preview Tabs')?></legend>
		<div id="tabsPreviewWrap"></div>
	</fieldset>
</div>

<style type="text/css">
	div.tabsHelperTabName {
		float: left;
		width: 80%;
	}
	div.tabsHelperOptions {
		float: left;
		width: 20%;
		text-align: right;
	}
</style>

<script type="text/javascript">
//safari was loading the auto.js too late. This ensures it's initialized
function initTabsBlockWhenReady(){
	if(tabsHelper && typeof(tabsHelper.init)=='function'){
		tabsHelper.cID=parseInt(<?php echo $c->getCollectionID()?>);
		tabsHelper.arHandle="<?php echo urlencode($_REQUEST['arHandle'])?>";
		tabsHelper.bID=thisbID;
		tabsHelper.btID=thisbtID;
		tabsHelper.tsID=parseInt(<?php echo $tabsHelperInfo['tabSetID']?>);	
		tabsHelper.init();
		tabsHelper.refreshTabsView();
	}else setTimeout('initTabsBlockWhenReady()',100);
}
initTabsBlockWhenReady();
</script>