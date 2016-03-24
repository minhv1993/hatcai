<?php    
defined('C5_EXECUTE') or die(_("Access Denied.")); 
use \Application\Block\Tabs\TabsHelper;
$tabsHelper=new TabsHelper($b);
$tabsHelperInfo=$tabsHelper->getTabsBlockInfo( $b->getBlockID() );
TabsHelper::tabCleanup( intval($tabsHelperInfo['tabSetID']), $b->getBlockID() );

$u=new User();
$ui=UserInfo::getByID($u->uID);?>

<script>
<?php if (is_object($b->getProxyBlock())) { ?>
	var thisbID=parseInt(<?php echo $b->getProxyBlock()->getBlockID()?>); 
	<?php } else { ?>
	var thisbID=parseInt(<?php echo $b->getBlockID()?>); 
	<?php } ?>
var thisbtID=parseInt(<?php echo $b->getBlockTypeID()?>); 
</script>
<?php 
$this->inc("form_setup_html.php", array('c' => $c, 'b' => $b, 'tabsHelperInfo' => $tabsHelperInfo, 'tabsHelper' => $tabsHelper, 'a' => $a, 'bt' => $bt));
?>