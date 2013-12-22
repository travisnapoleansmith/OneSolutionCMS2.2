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

class SpamFilter extends Tier3ProtectionLayerModulesAbstract implements Tier3ProtectionLayerModules
{
	protected $BannedIPAddressTableName;
	protected $UserBannedIPAddressTableName;
	
	public function __construct($tablenames, $databaseoptions, $layermodule) {
		$this->LayerModule = &$layermodule;

		$hold = current($tablenames);
		$GLOBALS['ErrorMessage']['SpamFilter'][$hold] = NULL;
		$this->ErrorMessage = &$GLOBALS['ErrorMessage']['SpamFilter'][$hold];
		$this->ErrorMessage = array();
		
		if (is_array($tablenames) === true) {
			$this->BannedIPAddressTableName = $tablenames['DatabaseTable1'];
			$this->UserBannedIPAddressTableName = $tablenames['DatabaseTable2'];
		}
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
		
		$passarray = array();
		$passarray = $PageID;
		try {
			$this->LayerModule->createDatabaseTable($this->BannedIPAddressTableName);
		} catch (SoapFault $E) {
		
		}
		$this->LayerModule->Connect($this->BannedIPAddressTableName);
		
		$this->LayerModule->pass ($this->BannedIPAddressTableName, 'setDatabaseField', array('idnumber' => $passarray));
		$this->LayerModule->pass ($this->BannedIPAddressTableName, 'setDatabaseRow', array('idnumber' => $passarray));
		
		$this->LayerModule->Disconnect($this->BannedIPAddressTableName);
		
		try {
			$this->LayerModule->createDatabaseTable($this->UserBannedIPAddressTableName);
		} catch (SoapFault $E) {
		
		}
		$this->LayerModule->Connect($this->UserBannedIPAddressTableName);
		
		$this->LayerModule->pass ($this->UserBannedIPAddressTableName, 'setDatabaseField', array('idnumber' => $passarray));
		$this->LayerModule->pass ($this->UserBannedIPAddressTableName, 'setDatabaseRow', array('idnumber' => $passarray));
		
		$this->LayerModule->Disconnect($this->UserBannedIPAddressTableName);
	}

	public function Verify($function, $functionarguments){
		return TRUE;
	}
	
	public function findBannedIPAddress ($IPAddress) {
		$this->FetchDatabase($IPAddress);
		
		$BannedIPAddressRecord = $this->LayerModule->pass ($this->BannedIPAddressTableName, 'getMultiRowField', array());
		$UserBannedIPAddressRecord = $this->LayerModule->pass ($this->UserBannedIPAddressTableName, 'getMultiRowField', array());
		
		if ($BannedIPAddressRecord[0] === FALSE & $UserBannedIPAddressRecord[0] === FALSE) {
			return "TRUE";
		} else {
			return "FALSE";
		}
	}
}


?>
