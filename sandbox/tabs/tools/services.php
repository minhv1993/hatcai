<?php
defined('C5_EXECUTE') or die("Access Denied.");
use \Application\Block\Tabs\TabsHelper;

$tabsHelper = new TabsHelper();

$bID = $_GET['bID'];
//Permissions Check
$bID = $_REQUEST['bID'];

if($_GET['cID'] && $_GET['arHandle']){
	$c = Page::getByID($_GET['cID'], 'RECENT');
	$a = Area::get($c, $_GET['arHandle']);
	if(intval($_GET['bID'])==0){
		//add survey mode
		$ap = new Permissions($a);
		$bt = BlockType::getByID($_GET['btID']);
		if(!$ap->canAddBlock($bt)) $badPermissions=true;
	}else{
		//edit survey mode
		// this really ought to be refactored
		if (!$a->isGlobalArea()) {
			$b = Block::getByID($_REQUEST['bID'], $c, $a);
			if ($b->getBlockTypeHandle() == BLOCK_HANDLE_SCRAPBOOK_PROXY) {
				$b = Block::getByID($b->getController()->getOriginalBlockID());
				$b->setBlockAreaObject($a);
				$b->loadNewCollection($c);
				$bID = $b->getBlockID();
			}
		} else {
			$b = Block::getByID($_REQUEST['bID'], Stack::getByName($a->getAreaHandle()), STACKS_AREA_NAME);
			$b->setBlockAreaObject($a); // set the original area object
		}

		$bp = new Permissions($b);
		if( !$bp->canWrite() ) $badPermissions=true;
	}
}else $badPermissions=true;
if($badPermissions){
	echo t('Invalid Permissions');
	die;
}


switch ($_GET['mode']){

	case 'addTab':
		$tabsHelper->addEditTab($_POST);
		break;

	case 'getTab':
		$tabsHelper->getTab(intval($_GET['tsID']), intval($_GET['tID']));
		break;

	case 'delTab':
		$tabsHelper->deleteTab(intval($_GET['tsID']),intval($_GET['msqID']));
		break;

	case 'reorderTab':
		$tabsHelper->reorderTab(intval($_POST['tsID']),$_POST['tIDs']);
		break;

	case 'refreshTabsView':
	default:
		$showEdit=(intval($_REQUEST['showEdit'])==1)?true:false;
		$tabsHelper->loadTabsView(intval($_GET['tsID']), $showEdit, intval($bID), explode(',',$_GET['hide']), 1 , 1);
}
