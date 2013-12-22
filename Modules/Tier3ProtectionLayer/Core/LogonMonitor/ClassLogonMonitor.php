<?php
/*
**************************************************************************************
* One Solution CMS
*
* Copyright (c) 1999 - 2013 One Solution CMS
* This content management system is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 2 of the License, or
* (at your option) any later version.
*
* This content management system is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @copyright  Copyright (c) 1999 - 2013 One Solution CMS (http://www.onesolutioncms.com/)
* @license    http://www.gnu.org/licenses/gpl-2.0.txt
* @version    2.1.141, 2013-01-14
*************************************************************************************
*/

class LogonMonitor extends Tier3ProtectionLayerModulesAbstract implements Tier3ProtectionLayerModules
{
	protected $LogonHistoryTable;
	
	public function __construct($tablenames, $databaseoptions, $layermodule) {
		$this->LayerModule = &$layermodule;

		$hold = current($tablenames);
		$GLOBALS['ErrorMessage']['LogonMonitor'][$hold] = NULL;
		$this->ErrorMessage = &$GLOBALS['ErrorMessage']['LogonMonitor'][$hold];
		$this->ErrorMessage = array();

	}

	public function setDatabaseAll ($hostname, $user, $password, $databasename, $databasetable) {
		$this->Hostname = $hostname;
		$this->User = $user;
		$this->Password = $password;
		$this->DatabaseName = $databasename;
		$this->DatabaseTable = $databasetable;

		$this->LayerModule->setDatabaseAll ($hostname, $user, $password, $databasename);
		$this->LayerModule->setDatabasetable ($databasetable);
	}

	public function FetchDatabase ($PageID) {
		$this->PageID = $PageID;
		
		try {
			$this->LayerModule->createDatabaseTable($this->DatabaseTable);
		} catch (SoapFault $E) {
		
		}
		
		$this->LayerModule->Connect($this->DatabaseTable);
		
		$this->LayerModule->pass ($this->DatabaseTable, 'setEntireTable', array());
		$this->LogonHistoryTable = $this->LayerModule->pass ($this->DatabaseTable, 'getEntireTable', array());
		
		$this->LayerModule->Disconnect($this->DatabaseTable);
	}

	public function Verify($function, $functionarguments){
		return TRUE;
	}
	
	public function setLogonHistoryTable($Table) {
		$this->LogonHistoryTable = $Table;
	}
	
	public function getLogonHistoryTable() {
		return $this->LogonHistoryTable;
	}
	
	public function createLogonHistoryEvent($EventData) {
		if (!empty($EventData)) {
			if (is_array($EventData)) {
				$this->LayerModule->pass ($this->DatabaseTable, 'BuildFieldNames', array('TableName' => $this->DatabaseTable));
				$Keys = $this->LayerModule->pass ($this->DatabaseTable, 'getRowFieldNames', array());
				$this->addModuleContent($Keys, $EventData, $this->DatabaseTable);
			}
		}
	}
}


?>
