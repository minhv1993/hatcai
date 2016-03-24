<?php 
namespace Application\Block\Tabs;
defined('C5_EXECUTE') or die(_("Access Denied."));

use \Concrete\Core\Block\BlockController;
use Core;
use Database;
use User;
use Page;
use UserInfo;
use Exception;
use Config;
use Concrete\Core\File\Version;
class Controller extends BlockController
{
	protected $btTable = 'btTabs';
	protected $btTabTable = 'btTab';
    protected $btInterfaceWidth = "400";
    protected $btWrapperClass = 'ccm-ui';
	protected $btInterfaceHeight = "500";
	protected $btCacheBlockRecord = false;
	protected $btExportTables = array('btTabs', 'btTab');

    public function getBlockTypeDescription()
    {
		return t("Add Tabs to the Page");
    }

    public function getBlockTypeName()
    {
		return t("Tabs");
	}
	public function getJavaScriptStrings()
	{
		return array(
			'delete-tab' => t('Are you sure you want to delete this tab?'),
			'form-name' => t('Your tab must have a name.'),
			'complete-required' => t('Please complete all required fields.'),
			'ajax-error' => t('AJAX Error.'),
			'form-min-1' => t('Please add at least one tab.'),
			);
	}

	protected function importAdditionalData($b, $blockNode)
	{
		if (isset($blockNode->data)) {
			foreach ($blockNode->data as $data) {
				if ($data['table'] != $this->getBlockTypeDatabaseTable()) {
					$table = (string) $data['table'];
					if (isset($data->record)) {
						foreach ($data->record as $record) {
							$aar = new \Concrete\Core\Legacy\BlockRecord($table);
							$aar->bID = $b->getBlockID();
							foreach ($record->children() as $node) {
								$nodeName = $node->getName();
								$aar->{$nodeName} = (string) $node;
							}
							if ($table == $btTabTable) {
								$db = Database::connection();
								$aar->tabSetID = $db->GetOne("select tabSetID from btTabs where bID = ?", array($b->getBlockID()));
							}
							$aar->Replace();
						}
					}
				}
			}
		}
	}

	public function __construct($b = null)
	{
		parent::__construct($b);
	}
	
	/**
	 * Form add or edit submit
	 * (run after the duplicate method on first block edit of new page version).
	 */
	public function save($data = array())
	{
		if (!$data || count($data) == 0) {
			$data = $_POST;
		}
		$data += array(
			'tsID' => time(),
			'oldTsID' => null,
			'tabs' => array(),
			);

		$b = $this->getBlockObject();
		$c = $b->getBlockCollectionObject();

		$db = Database::connection();
		if (intval($this->bID) > 0) {
			$q = "SELECT count(*) as total from btTabs where bID = ".intval($this->bID);
			$total = $db->getOne($q);
		} else {
			$total = 0;
		}

		if (isset($_POST['tsID']) && $_POST['tsID']) {
			$data['tsID'] = $_POST['tsID'];
		}
		if (!$data['oldTsID']) {
			$data['oldTsID'] = $data['tsID'];
		}
		$data['bID'] = intval($this->bID);
		
		$v = array($data['tsID'], intval($this->bID));

		//is it new?
		if (intval($total) == 0) {
			$q = "INSERT into btTabs (tabSetID, bID) values (?,?)";
		} else {
			$v[] = $data['tsID'];
			$q = "UPDATE btTabs set tabSetID = ? where bID = ? AND tabSetID= ?";
		}

		$rs = $db->query($q, $v);

		//Add Tabs (for programmatically creating forms, such as during the site install)
		if (count($data['tabs']) > 0) {
			$tabsHelper = new TabsHelper();
			foreach ($data['tabs'] as $tabData) {
				$tabsHelper->addEditTab($tabData, 0);
			}
		}

		$this->tabVersioning($data);

		return true;
	}

	/**
	 * Ties the new or edited tabs to the new block number.
	 * New and edited tabs are temporarily given bID=0, until the block is saved... painfully complicated.
	 *
	 * @param array $data
	 */
	protected function tabVersioning($data = array())
	{
		$data += array(
			'ignoreTabIDs' => '',
			'pendingDeleteIDs' => '',
			);
		$db = Database::connection();
		$oldBID = intval($data['bID']);

		//if this block is being edited a second time, remove edited tabs with the current bID that are pending replacement
		//if( intval($oldBID) == intval($this->bID) ){
		$vals = array(intval($data['oldTsID']));
		$pendingTabs = $db->getAll("SELECT msqID FROM btTab WHERE bID=0 && tabSetID=?", $vals);
		foreach ($pendingTabs as $pendingTab) {
			$vals = array(intval($this->bID), intval($pendingTab['msqID']));
			$db->query("DELETE FROM btTab WHERE bID=? AND msqID=?", $vals);
		}
		//}

		//assign any new tabs the new block id
		$vals = array(intval($data['bID']), intval($data['tsID']), intval($data['oldTsID']));
		$rs = $db->query("UPDATE btTab SET bID=?, tabSetID=? WHERE bID=0 && tabSetID=?", $vals);

		//These are deleted or edited tabs.  (edited tabs have already been created with the new bID).
		$ignoreTabIDsDirty = explode(',', $data['ignoreTabIDs']);
		$ignoreTabIDs = array(0);
		foreach ($ignoreTabIDsDirty as $msqID) {
			$ignoreTabIDs[] = intval($msqID);
		}
		$ignoreTabIDstr = implode(',', $ignoreTabIDs);

		//remove any tabs that are pending deletion, that already have this current bID
		$pendingDeleteTIDsDirty = explode(',', $data['pendingDeleteIDs']);
		$pendingDeleteTIDs = array();
		foreach ($pendingDeleteTIDsDirty as $msqID) {
			$pendingDeleteTIDs[] = intval($msqID);
		}
		$vals = array($this->bID, intval($data['tsID']));
		$pendingDeleteTIDs = implode(',', $pendingDeleteTIDs);
		$unchangedTabs = $db->query("DELETE FROM btTab WHERE bID=? AND tabSetID=? AND msqID IN (".$pendingDeleteTIDs.")", $vals);
	}

	/**
	 * Duplicate will run when copying a page with a block, or editing a block for the first time within a page version (before the save).
	 */
	public function duplicate($newBID)
	{
		$b = $this->getBlockObject();
		$c = $b->getBlockCollectionObject();

		$db = Database::connection();
		$v = array($this->bID);
		$q = "select * from ".$btTable." where bID = ? LIMIT 1";
		$r = $db->query($q, $v);
		$row = $r->fetchRow();

		//if the same block exists in multiple collections with the same tabSetID
		if (count($row) > 0) {
			$oldTabSetID = $row['tabSetID'];

			//It should only generate a new tab set id if the block is copied to a new page,
			//otherwise it will loose all of its answer sets (from all the people who've used the form on this page)
			$tabSetCIDs = $db->getCol("SELECT distinct cID FROM btTabs AS f, CollectionVersionBlocks AS cvb ".
				"WHERE f.bID=cvb.bID AND tabSetID=".intval($row['tabSetID']));

			//this tab set id is used on other pages, so make a new one for this page block
			if (count($tabSetCIDs) > 1 || !in_array($c->cID, $tabSetCIDs)) {
				$newTabSetID = time();
				$_POST['tsID'] = $newTabSetID;
			} else {
				//otherwise the tab set id stays the same
				$newTabSetID = $row['tabSetID'];
			}

			//duplicate survey block record
			//with a new Block ID and a new Tab
			$v = array($newTabSetID);
			$q = "insert into btTabs (tabSetID) values (?)";
			$result = $db->Execute($q, $v);

			$rs = $db->query("SELECT * FROM btTab WHERE tabSetID=$oldTabSetID AND bID=".intval($this->bID));
			while ($row = $rs->fetchRow()) {
				$v = array($newTabSetID,intval($row['msqID']), intval($newBID), $row['tabName'],$row['tabIdStr'],$row['position']);
				$sql = "INSERT INTO btTab (tabSetID,msqID,bID,tabName,tabIdStr,position) VALUES (?,?,?,?,?,?)";
				$db->Execute($sql, $v);
			}

			return $newTabSetID;
		}

		return 0;
	}
	
	public function delete()
	{
		$db = Database::connection();

		$deleteData['tabsIDs'] = array();

		$tabsHelper = new TabsHelper();
		$info = $tabsHelper->getTabsBlockInfo($this->bID);

		//delete the questions
		$deleteData['tabsIDs'] = $db->getAll("SELECT tID FROM btTab WHERE tabSetID = ".intval($info['tabSetID']).' AND bID='.intval($this->bID));
		foreach ($deleteData['tabsIDs'] as $tabData) {
			$db->query("DELETE FROM btTab WHERE tID=".intval($tabData['tID']));
		}

		//delete the form block
		$q = "delete from {$this->btTable} where bID = '{$this->bID}'";
		$r = $db->query($q);

		parent::delete();

		return $deleteData;
	}
}