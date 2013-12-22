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

class SystemFileIntegrityScanner extends Tier3ProtectionLayerModulesAbstract implements Tier3ProtectionLayerModules
{
	protected $SystemFilesTable;
	protected $FilesTable;
	
	public function __construct($tablenames, $databaseoptions, $layermodule) {
		$this->LayerModule = &$layermodule;

		$hold = current($tablenames);
		$GLOBALS['ErrorMessage']['SystemFileIntegrityScanner'][$hold] = NULL;
		$this->ErrorMessage = &$GLOBALS['ErrorMessage']['SystemFileIntegrityScanner'][$hold];
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
		$this->SystemFilesTable = $this->LayerModule->pass ($this->DatabaseTable, 'getEntireTable', array());
		
		$this->LayerModule->Disconnect($this->DatabaseTable);
	}

	public function Verify($function, $functionarguments){
		return TRUE;
	}
	
	public function getSystemFilesTable() {
		return $this->SystemFilesTable;
	}
	
	public function getFilesTable() {
		return $this->FilesTable;
	}
	
	public function createSystemFileTable (){
		if (is_array($this->SystemFilesTable)) {
			$Temp = $this->SystemFilesTable;
			$this->SystemFilesTable = array();
			
			foreach ($Temp as $Key => $Value) {
				$FilePath = $Value['FilePath'];
				$this->SystemFilesTable[$FilePath] = $Value;
			}
		}
	}
	
	public function createFileTable (){
		if (is_array($this->SystemFilesTable)) {
			$this->FilesTable = array();
			
			foreach ($this->SystemFilesTable as $Key => $Value) {
				$FilePath = $Value['FilePath'];
				$this->FilesTable[$FilePath] = $Value['Hash'];
			}
		}
	}
	
	public function createSystemFiles($Filename) {
		if (!empty($Filename)) {
			if (file_exists($Filename)) {
				$HashArray = array();
				$File = file($Filename);
				$DirectoryListing = array();
				foreach ($File as $FileContent) {
					$FileContent = str_replace("\n", '', $FileContent);
					$FileContent = str_replace("\r", '', $FileContent);
					if (is_file($FileContent)) {
						$Hash = hash_file('sha1', $FileContent);
						
						$HashArrayTemp = array();
						$HashArrayTemp['FilePath'] = $FileContent;
						$HashArrayTemp['Hash'] = $Hash;
						$HashArrayTemp['Timestamp'] = $_SERVER['REQUEST_TIME'];
						
						$HashArray[$FileContent] = $HashArrayTemp;
					}
				}
				return $HashArray;
			}
		}
	}
	
	public function scanSystemFiles($Filename) {
		if (!empty($Filename)) {
			if (file_exists($Filename)) {
				$HashArray = array();
				$File = file($Filename);
				$DirectoryListing = array();
				foreach ($File as $FileContent) {
					$FileContent = str_replace("\n", '', $FileContent);
					$FileContent = str_replace("\r", '', $FileContent);
					if (is_file($FileContent)) {
						$Hash = hash_file('sha1', $FileContent);
						$HashArray[$FileContent] = $Hash;
					}
				}
				return $HashArray;
			}
		}
	}
	
	public function compareSystemFiles($DatabaseTableArray, $HashArray) {
		if (!empty($DatabaseTableArray)) {
			if (!empty($HashArray)) {
				if (is_array($DatabaseTableArray)) {
					if (is_array($HashArray)) {
						$Difference = array_diff_assoc($HashArray, $DatabaseTableArray);
						return ($Difference);
					}
				}
			}
		}
		
	}
	
	public function emptyDatabaseTable() {
		$this->LayerModule->Connect($this->DatabaseTable);
		$this->LayerModule->pass ($this->DatabaseTable, 'emptyTable', array());
		$this->LayerModule->Disconnect($this->DatabaseTable);
	}
	
	public function createDatabaseTableArray($DatabaseTableData) {
		if (!empty($DatabaseTableData)) {
			if (is_array($DatabaseTableData)) {
				$this->LayerModule->pass ($this->DatabaseTable, 'BuildFieldNames', array('TableName' => $this->DatabaseTable));
				$Keys = $this->LayerModule->pass ($this->DatabaseTable, 'getRowFieldNames', array());
				$this->addModuleContent($Keys, $DatabaseTableData, $this->DatabaseTable);
			}
		}
	}
}


?>
