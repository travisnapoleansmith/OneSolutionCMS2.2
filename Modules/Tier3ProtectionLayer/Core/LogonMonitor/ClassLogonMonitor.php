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
* @version    2.2.12, 2013-12-30
*************************************************************************************
*/

class LogonMonitor extends Tier3ProtectionLayerModulesAbstract implements Tier3ProtectionLayerModules
{
	protected $LogonHistoryTable;
	
	/**
	 * Tier Keyword
	 *
	 * @var string
	 */
	protected $TierKeyword;
	
	public function __construct($TableNames, $DatabaseOptions, $LayerModule) {
		$this->TierKeyword = 'PROTECT';
		
		$this->LayerModule = &$LayerModule;

		$hold = current($TableNames);
		$GLOBALS['ErrorMessage']['LogonMonitor'][$hold] = NULL;
		$this->ErrorMessage = &$GLOBALS['ErrorMessage']['LogonMonitor'][$hold];
		$this->ErrorMessage = array();
		
		$this->DatabaseAllow = &$GLOBALS['Tier3DatabaseAllow'];
		$this->DatabaseDeny = &$GLOBALS['Tier3DatabaseDeny'];
		
	}
	
	/**
	 * setDatabaseAll
	 *
	 * Setter for Hostname, Username, Password, Database name and Database table
	 *
	 * @param string $Hostname the name of the host needed to connect to database.
	 * @param string $Username the user account needed to connect to database.
	 * @param string $Password the user's password needed to connect to database.
	 * @param string $DatabaseName the name of the database needed to connect to database.
	 * @param string $DatabaseTable the name of the database table to use.
	 * @access public
	 */
	public function setDatabaseAll ($Hostname, $Username, $Password, $DatabaseName, $DatabaseTable) {
		if (is_null($Hostname) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: Hostname Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($Hostname) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: Hostname Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($Hostname) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: Hostname Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($Hostname) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: Hostname Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_null($Username) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: Username Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($Username) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: Username Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($Username) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: Username Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($Username) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: Username Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_null($Password) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: Password Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($Password) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: Password Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($Password) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: Password Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($Password) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: Password Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_null($DatabaseName) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: DatabaseName Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($DatabaseName) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: DatabaseName Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($DatabaseName) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: DatabaseName Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($DatabaseName) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: DatabaseName Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_null($DatabaseTable) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: DatabaseTable Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($DatabaseTable) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: DatabaseTable Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($DatabaseTable) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: DatabaseTable Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($DatabaseTable) === TRUE) {
			array_push($this->ErrorMessage,'setDatabaseAll: DatabaseTable Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		$this->Hostname = $Hostname;
		$this->User = $Username;
		$this->Password = $Password;
		$this->DatabaseName = $DatabaseName;
		$this->DatabaseTable = $DatabaseTable;

		$this->LayerModule->setDatabaseAll ($Hostname, $Username, $Password, $DatabaseName);
		$this->LayerModule->setDatabasetable ($DatabaseTable);
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

	public function Verify($Function, $FunctionArguments){
		if (is_null($Function) === TRUE) {
			array_push($this->ErrorMessage,'Verify: Function Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($Function) === TRUE) {
			array_push($this->ErrorMessage,'Verify: Function Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($Function) === TRUE) {
			array_push($this->ErrorMessage,'Verify: Function Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($Function) === TRUE) {
			array_push($this->ErrorMessage,'Verify: Function Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($FunctionArguments) === FALSE) {
			array_push($this->ErrorMessage,'Verify: Function Must Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if ($Function === $this->TierKeyword) {
			return TRUE;
		} else {
			if (isset($this->DatabaseDeny[$Function]) === TRUE) {
				return TRUE;
			} else if (isset($this->DatabaseAllow[$Function]) === TRUE) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
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
