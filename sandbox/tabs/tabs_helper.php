<?php
namespace Application\Block\Tabs;

use Core;
use Database;
use Request;

class TabsHelper
{
    public $btTable = 'btTabs';
	public $btTabTable = 'btTab';
	public $lastSavedMsqID = 0;
    public $lastSavedTID = 0;
    
    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function addEditTab($values, $withOutput = 1)
	{
		$jsonVals = array();
		
		//set tab set id, or create a new one if none exists
		if (intval($values['tID']) == 0) {
			$values['tID'] = time();
		}

		//validation
		if (strlen($values['tabName']) == 0) {
			//complete required fields
			$jsonVals['success'] = 0;
			$jsonVals['noRequired'] = 1;
		} else {
			if (intval($values['msqID'])) {
				$jsonVals['mode'] = '"Edit"';

				//tabs that are edited are given a placeholder row in btTab with bID=0, until a bID is assign on block update
				$pendingEditExists = $this->db->fetchColumn("select count(*) as total from btTab where bID=0 AND msqID=".intval($values['msqID']));

				//hideQID tells the interface to hide the old version of the tab in the meantime
				$vals = array(intval($values['msqID']));
				$jsonVals['hideTID'] = intval($this->db->fetchColumn("SELECT MAX(tID) FROM btTab WHERE bID!=0 AND msqID=?", $vals));
			} else {
				$jsonVals['mode'] = '"Add"';
			}
			
			if ($pendingEditExists) {
				$dataValues = array(
					intval($values['tsID']),
					trim($values['tabName']),
					strtolower(trim(preg_replace('/\s+/', '_', $values['tabIdStr']))),
					intval($values['position']),
					intval($values['msqID']),
					);
				$sql = "UPDATE btTab SET tabSetID=?, tabName=?, tabIdStr=?, position=? WHERE msqID=? AND bID=0";
			} else {
				if (!isset($values['position'])) {
					$values['position'] = 1000;
				}
				if (!intval($values['msqID'])) {
					$values['msqID'] = intval($this->db->fetchColumn("SELECT MAX(msqID) FROM btTab") + 1);
				}
				$dataValues = array(
					$values['msqID'],
					intval($values['tsID']),
					trim($values['tabName']),
					strtolower(trim(preg_replace('/\s+/', '_', $values['tabIdStr']))),
					intval($values['position']),
					);
				$sql = "INSERT INTO btTab (msqID,tabSetID,tabName,tabIdStr,position) VALUES (?,?,?,?,?)";
			}
			$result = $this->db->executeQuery($sql, $dataValues);
			$this->lastSavedMsqID = intval($values['msqID']);
			$this->lastSavedTID = intval($this->db->fetchColumn("SELECT MAX(tID) FROM btTab WHERE bID=0 AND msqID=?", array($values['msqID'])));
			$jsonVals['tID'] = $this->lastSavedTID;
			$jsonVals['success'] = 1;
		}

		$jsonVals['tsID'] = $values['tsID'];
		$jsonVals['msqID'] = intval($values['msqID']);
		//create json response object
		$jsonPairs = array();
		foreach ($jsonVals as $key => $val) {
			$jsonPairs[] = $key.':'.$val;
		}
		if ($withOutput) {
			echo '{'.implode(',', $jsonPairs).'}';
		}
    }

	public function getTab($tsID, $tID)
	{
		$tabRS = $this->db->executeQuery("SELECT * FROM btTab WHERE tabSetID=".intval($tsID)." AND tID=".intval($tID)." LIMIT 1");
		$tabRow = $tabRS->fetch();
		$jsonPairs = array();
		foreach ($tabRow as $key => $val) {
			$jsonPairs[] = $key.':"'.str_replace(array("\r", "\n"), '%%', addslashes($val)).'"';
		}
		echo '{'.implode(',', $jsonPairs).'}';
    }

	public function deleteTab($tsID, $msqID)
    {
		$sql = "DELETE FROM btTab WHERE tabSetID=".intval($tsID)." AND msqID=".intval($msqID)." AND bID=0";
        $this->db->executeQuery($sql);
    }

	public function loadTabs($tsID, $bID = 0, $showPending = 0)
    {
        $db = Database::connection();
        if (intval($bID)) {
            $bIDClause = ' AND ( bID='.intval($bID).' ';
            if ($showPending) {
                $bIDClause .= ' OR bID=0) ';
            } else {
                $bIDClause .= ' ) ';
            }
        }

		return $db->executeQuery("SELECT * FROM btTab WHERE tabSetID=".intval($tsID)." ".$bIDClause." ORDER BY position");
    }

	public function loadTabsView($tsID, $showEdit = false, $bID = 0, $hideTIDs = array(), $showPending = 0, $editMode = 0){
		
        //loading tabs
        $tabsRS = $this->loadTabs($tsID, $bID, $showPending);
		
        if (!$showEdit) {
            echo '<ul class="hc-tabs">';
            while ($tabRow = $tabsRS->fetch()) {
                if (in_array($tabRow['tID'], $hideTIDs)) {
                    continue;
                }
                echo '<li class="hc-tabs-tab" id="'.($tabRow['tabIdStr'] ? $tabRow['tabIdStr'] : 'tab-'.intval($tabRow['msqID'])).'">'.$tabRow['tabName'].'</li>';
                //}
            }
            echo '</ul>';
        } else {
            echo '<div id="tabsHelperTablewrap"><ul id="tabsHelperPreviewTable" class="list-group">';
            while ($tabRow = $tabsRS->fetch()) {
                if (in_array($tabRow['tID'], $hideTIDs)) {
                    continue;
                }

                ?>
					<li id="tabsHelperTabNameRow<?php echo $tabRow['msqID']?>" class="tabsHelperTabNameRow list-group-item">
						<div class="tabsHelperTabName"><?php echo $tabRow['tabName'].''.($tabRow['tabIdStr'] ? '#'.$tabRow['tabIdStr'] : '');?></div>
						<div class="tabsHelperOptions">
							<a href="javascript:void(0)" class="ccm-icon-wrapper" onclick="tabsHelper.moveUp(this,<?php echo $tabRow['msqID']?>);return false"><i class="fa fa-chevron-up"></i></a>
							<a href="javascript:void(0)" class="ccm-icon-wrapper" onclick="tabsHelper.moveDown(this,<?php echo $tabRow['msqID']?>);return false"><i class="fa fa-chevron-down"></i></a>
							<a href="javascript:void(0)" class="ccm-icon-wrapper" onclick="tabsHelper.reloadTab(<?php echo intval($tabRow['tID']) ?>);return false"><i class="fa fa-pencil"></i></a>
							<a href="javascript:void(0)" class="ccm-icon-wrapper" onclick="tabsHelper.deleteTab(this,<?php echo intval($tabRow['msqID']) ?>,<?php echo intval($tabRow['tID'])?>);return false"><i class="fa fa-trash"></i></a>
						</div>
						<div class="clearfix"></div>
					</li>
				<?php 
            }
            echo '</div></div>';
        }
	}

	public static function getTabCount($tsID)
    {
        $db = Database::connection();

		return $db->fetchColumn("SELECT count(*) FROM btTab WHERE tabSetID=".intval($tsID));
    }

	public function getTabsBlockInfo($bID)
    {
		$rs = $this->db->executeQuery("SELECT * FROM btTabs WHERE bID=".intval($bID)." LIMIT 1");

        return $rs->fetch();
    }

	public function getTabsBlockInfoByTabID($tsID, $bID = 0)
    {
		$sql = 'SELECT * FROM btTabs WHERE tabSetID='.intval($tsID);
        if (intval($bID) > 0) {
            $sql .= ' AND bID='.$bID;
        }
        $sql .= ' LIMIT 1';
        $rs = $this->db->executeQuery($sql);

        return $rs->fetch();
    }

	public function reorderTab($tsID = 0, $tIDs)
    {
		$tIDs = explode(',', $tIDs);
		if (!is_array($tIDs)) {
			$tIDs = array($tIDs);
        }
        $positionNum = 0;
		foreach ($tIDs as $tID) {
			$vals = array($positionNum,intval($tID), intval($tsID));
            $sql = "UPDATE btTab SET position=? WHERE msqID=? AND tabSetID=?";
            $rs = $this->db->executeQuery($sql, $vals);
            ++$positionNum;
        }
    }

    //Run on Form block edit
	public static function tabCleanup($tsID = 0, $bID = 0)
    {
        $db = Database::connection();

        //First make sure that the bID column has been set for this tabSetID (for backwards compatibility)
		$vals = array(intval($tsID));
		$tabsWithBID = $db->fetchColumn("SELECT count(*) FROM btTab WHERE bID!=0 AND tabSetID=? ", $vals);

        //form block was just upgraded, so set the bID column
		if (!$tabsWithBID) {
			$vals = array(intval($bID), intval($tsID));
			$rs = $db->executeQuery("UPDATE btTab SET bID=? WHERE bID=0 AND tabSetID=?", $vals);

            return;
        }

        //Then remove all temp/placeholder tabs for this tabSetID that haven't been assigned to a block
		$vals = array(intval($tsID));
		$rs = $db->executeQuery("DELETE FROM btTab WHERE bID=0 AND tabSetID=?", $vals);
    }
}
