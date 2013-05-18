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

/**
 * Class Data Access Layer
 *
 * Class DataAccessLayer is designed as the security of the entire system.
 *
 * @author Travis Napolean Smith
 * @copyright Copyright (c) 1999 - 2013 One Solution CMS
 * @copyright PHP - Copyright (c) 2005 - 2013 One Solution CMS
 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
 * @version PHP - 2.1.140
 * @version C++ - Unknown
 */
class DataAccessLayer extends LayerModulesAbstract
{
	/**
	 * Content Layer Modules
	 *
	 * @var array
	 */
	protected $Modules;

	/**
	 * User settings for what is allowed to be done with the database -  set with Tier2DataAccessLayerSetting.php
	 * in /Configuration folder
	 *
	 * @var array
	 */
	protected $DatabaseAllow;

	/**
	 * User setting for what is cannot be done with the database - set with Tier2DataAccessLayerSetting.php
	 * in /Configuration folder
	 *
	 * @var array
	 */
	protected $DatabaseDeny;

	/**
	 * Create an instance of DataAccessLayer
	 *
	 * @access public
	 */
	public function __construct () {

		$this->Modules = Array();
		$this->DatabaseTable = Array();
		$GLOBALS['ErrorMessage']['DataAccessLayer'] = array();
		$this->ErrorMessage = &$GLOBALS['ErrorMessage']['DataAccessLayer'];

		$this->DatabaseAllow = &$GLOBALS['Tier2DatabaseAllow'];
		$this->DatabaseDeny = &$GLOBALS['Tier2DatabaseDeny'];

		$this->PageID = $_GET['PageID'];

		$this->SessionName['SessionID'] = $_GET['SessionID'];
	}

	/**
	 * setModules
	 *
	 * Setter for Modules
	 *
	 * @access public
	 */
	public function setModules() {

	}

	public function getModules($key) {
		return $this->Modules[$key];
	}

	/**
	 * setDatabaseAll
	 *
	 * Setter for Hostname, User, Password, Database name and Database table
	 *
	 * @param string $Hostname the name of the host needed to connect to database.
	 * @param string $User the user account needed to connect to database.
	 * @param string $Password the user's password needed to connect to database.
	 * @param string $DatabaseName the name of the database needed to connect to database.
	 * @access public
	 */
	public function setDatabaseAll ($hostname, $user, $password, $databasename) {
		if ($hostname != NULL & $user != NULL & $password != NULL & $databasename != NULL) {
			$this->Hostname = $hostname;
			$this->User = $user;
			$this->Password = $password;
			$this->DatabaseName = $databasename;
			
			return $this;
		} else {
			array_push($this->ErrorMessage,'setDatabaseAll: hostname, user, password or databasename Cannot Be Null!');
			return FALSE;
		}
	}

	/**
	 * ConnectAll
	 *
	 * Connects to all databases
	 *
	 * @access public
	*/
	public function ConnectAll () {
		if ($this->Hostname != NULL & $this->User != NULL & $this->Password != NULL & $this->DatabaseName != NULL) {
			if ($this->DatabaseTable != NULL) {
				if (is_array($this->DatabaseTable)) {
					foreach ($this->DatabaseTable as $TableNameKey => $TableNameValue) {
						try {
							$this->DatabaseTable[$TableNameKey]->setDatabaseAll($this->Hostname, $this->User, $this->Password, $this->DatabaseName, $TableNameValue);
							$this->DatabaseTable[$TableNameKey]->Connect();
						} catch (Exception $e) {
							array_push($this->ErrorMessage,'ConnectAll: Exception Thrown - Message: ' . $e->getMessage() . '!');
						}
					}
					return $this;
				} else {
					array_push($this->ErrorMessage,'ConnectAll: $this->DatabaseTable Must Be An Array!');
					return FALSE;
				}
			} else {
				array_push($this->ErrorMessage,'ConnectAll: $this->DatabaseTable Cannot Be Null!');
				return FALSE;
			}
		} else {
			array_push($this->ErrorMessage,'ConnectAll: $this->Hostname, $this->User, $this->Password or $this->DatabaseName Cannot Be Null!');
			return FALSE;
		}
	}

	/**
	 * Connect
	 *
	 * Connect to a database table
	 *
	 * @param string $DatabaseTable the name of the database table to connect to
	 * @access public
	 */
	public function Connect ($Key) {
		if ($Key != NULL) {
			if (isset($this->DatabaseTable[$Key])) {
				try {
					$this->DatabaseTable[$Key]->setDatabaseAll($this->Hostname, $this->User, $this->Password, $this->DatabaseName, $Key);
					$this->DatabaseTable[$Key]->Connect();
				} catch (Exception $E) {
					array_push($this->ErrorMessage,'ConnectAll: Exception Thrown - Message: ' . $E->getMessage() . '!');
					return FALSE;
				} 
				
				return $this;
			} else {
				array_push($this->ErrorMessage,'ConnectAll: Exception Thrown - Message: Key Doesn\'t Exist!');
				
				return new Exception('Key Doesn\'t Exist!');
			}
		} else {
			array_push($this->ErrorMessage,'Connect: Key Cannot Be Null!');
			return FALSE;
		}
	}

	/**
	 * DiscconnectAll
	 *
	 * Disconnects from all databases
	 *
	 * @access public
	 */
	public function DisconnectAll () {
		reset($this->DatabaseTable);
		while (current($this->DatabaseTable)){
			$tablename = key($this->DatabaseTable);
			$this->DatabaseTable[key($this->DatabaseTable)]->Disconnect();

			next($this->DatabaseTable);
		}
		return $this;
	}

	/**
	 * Disconnect
	 *
	 * Disconnection from a database table
	 *
	 * @param string $DatabaseTable the name of the database table to disconnect from
	 * @access public
	*/
	public function Disconnect ($key) {
		if ($key != NULL) {
			$this->DatabaseTable[$key]->Disconnect();
			return $this;
		} else {
			array_push($this->ErrorMessage,'Disconnect: Key Cannot Be Null!');
			return FALSE;
		}
	}

	public function buildDatabase() {

	}

	/**
	 * createDatabaseTable
	 *
	 * Creates a connection for a database table
	 *
	 * @param string $DatabaseTable the name of the database table to create a connection to
	 * @access public
	 */
	public function createDatabaseTable($key) {
		$this->DatabaseTable[$key] =  new MySqlConnect();
		return $this;
	}

	protected function checkPass($DatabaseTable, $function, $functionarguments) {
		reset($this->Modules);
		$hold = NULL;
		/*while (current($this->Modules)) {
			//$tempobject = current($this->Modules[key($this->Modules)]);
			//$databasetables = $tempobject->getTableNames();
			//$tempobject->FetchDatabase ($this->PageID);
			//$tempobject->CreateOutput($this->Space);
			//$tempobject->getOutput();
			//$hold = $tempobject->Verify($function, $functionarguments);
			next($this->Modules);
		}*/
		if ($functionarguments[0]) {
			$PassArguments = array();
			$PassArguments[0] = $functionarguments;
		} else {
			$PassArguments = $functionarguments;
		}
		//print_r($functionarguments);
		$hold2 = call_user_func_array(array($this->DatabaseTable["$DatabaseTable"], "$function"), $PassArguments);
		if ($hold2) {
			return $hold2;
		} else {
			return FALSE;
		}
	}

	public function pass($databasetable, $function, $functionarguments) {
		if (!is_null($functionarguments)) {
			if (is_array($functionarguments)) {
				if (!is_null($function)) {
					if (!is_array($function)) {
						if ($this->DatabaseAllow[$function]) {
							if ($functionarguments[0]) {
								$PassArguments = array();
								$PassArguments[0] = $functionarguments;
							} else {
								$PassArguments = $functionarguments;
							}
							$hold = call_user_func_array(array($this->DatabaseTable["$databasetable"], "$function"), $functionarguments);
							if ($hold) {
								return $hold;
							}
						} else if ($this->DatabaseDeny[$function]) {
							$hold = $this->checkPass($databasetable, $function, $functionarguments);
							if ($hold) {
								return $hold;
							} else {
								return FALSE;
							}
						} else {
							array_push($this->ErrorMessage,"pass: $function from $databasetable - MySqlConnect Member Does Not Exist!");
							return FALSE;
						}
					} else {
						array_push($this->ErrorMessage,'pass: MySqlConnect Member Cannot Be An Array!');
						return FALSE;
					}
				} else {
					array_push($this->ErrorMessage,'pass: MySqlConnect Member Cannot Be Null!');
					return FALSE;
				}
			} else {
				array_push($this->ErrorMessage,'pass: Function Arguments Must Be An Array!');
				return FALSE;
			}
		} else {
			array_push($this->ErrorMessage,'pass: Function Arguments Cannot Be Null!');
			return FALSE;
		}
	}

	public function buildModules($LayerModuleTableName, $LayerTableName, $LayerModuleTableNameSetting) {
		if ($this->SessionName) {
			$passarray = array();
			$passarray['SessionName'] = $this->SessionName;

			$this->createDatabaseTable('Sessions');

			reset($this->Layers);
			while (current($this->Layers)) {
				$this->Layers[key($this->Layers)]->createDatabaseTable('Sessions');
				next($this->Layers);
			}

			$this->Connect('Sessions');
			$this->pass ('Sessions', 'setDatabaseRow', array('idnumber' => $passarray));
			$this->Disconnect('Sessions');

			$this->SessionTypeName = $this->pass ('Sessions', 'getMultiRowField', array());
			$this->SessionTypeName = $this->SessionTypeName[0];
		}
		$this->LayerModuleTableNameSetting = $LayerModuleTableNameSetting;
		$this->LayerModuleTableName = $LayerModuleTableName;
		$this->LayerTableName = $LayerTableName;

		$this->createDatabaseTable($this->LayerModuleTableNameSetting);
		$this->createDatabaseTable($this->LayerModuleTableName);
		$this->createDatabaseTable($this->LayerTableName);

		$passarray = array();
		$passarray['Enable/Disable'] = 'Enable';

		$this->Connect($this->LayerModuleTableName);
		$this->pass ($this->LayerModuleTableName, 'setDatabaseRow', array('idnumber' => $passarray));
		$this->Disconnect($this->LayerModuleTableName);

		$this->LayerModuleTable = $this->pass ($this->LayerModuleTableName, 'getMultiRowField', array());

		$this->Connect($this->LayerTableName);
		$this->pass ($this->LayerTableName, 'setEntireTable', array());
		$this->Disconnect($this->LayerTableName);

		$this->LayerTable = $this->pass ($this->LayerTableName, 'getEntireTable', array());

		if ($LayerModuleTableName && $this->LayerModuleTable && $LayerTableName && $this->LayerTable) {
			$moduletable = current($this->LayerModuleTable);
			$keymoduletable = key($this->LayerModuleTable);
			while ($moduletable) {
				$ObjectType = $this->LayerModuleTable[$keymoduletable]['ObjectType'];
				$ObjectTypeName = $this->LayerModuleTable[$keymoduletable]['ObjectTypeName'];
				$ObjectTypeLocation = $this->LayerModuleTable[$keymoduletable]['ObjectTypeLocation'];
				$ModuleFileName = array();
				$ModuleFileName = $this->buildArray($ModuleFileName, 'ModuleFileName', $keymoduletable, $this->LayerModuleTable);
				$EnableDisable = $this->LayerModuleTable[$keymoduletable]['Enable/Disable'];

				reset ($this->LayerTable);
				$layertable = current($this->LayerTable);
				$keylayertable = key($this->LayerTable);
				while ($layertable) {
					$NewObjectType = $this->LayerTable[$keylayertable]['ObjectType'];
					$NewObjectTypeName = $this->LayerTable[$keylayertable]['ObjectTypeName'];

					if ($NewObjectType == $ObjectType && $NewObjectTypeName == $ObjectTypeName) {
						break;
					}
					next($this->LayerTable);
					$layertable = current($this->LayerTable);
					$keylayertable = key($this->LayerTable);
				}

				if ($EnableDisable == 'Enable') {
					reset ($ModuleFileName);
					$modulesfile = $_SERVER['SUBDOMAIN_DOCUMENT_ROOT'];
					$modulesfile .= '/';
					$modulesfile .= $ObjectTypeLocation;
					$modulesfile .= '/';
					$modulesfile .= current($ModuleFileName);
					$modulesfile .= '.php';

					$filename = current($ModuleFileName);
					while ($filename) {
						if (is_file($modulesfile)) {
							require_once($modulesfile);
						} else {
							array_push($this->ErrorMessage,"buildModules: Module filename - $modulesfile does not exist!");
						}
						next($ModuleFileName);
						$modulesfile = $ObjectTypeLocation;
						$modulesfile .= '/';
						$modulesfile .= $filename;
						$modulesfile .= '.php';
						$filename = current($ModuleFileName);
					}

				}

				if (is_array($layertable)) {
					if (in_array($this->LayerTable[$keylayertable]['ObjectType'], $layertable) && in_array($this->LayerTable[$keylayertable]['ObjectTypeName'], $layertable)) {
						$DatabaseTables = array();
						$DatabaseTables = $this->buildArray($DatabaseTables, 'DatabaseTable', $keylayertable, $this->LayerTable);
						reset($DatabaseTables);
						while (current($DatabaseTables)) {
							$this->createDatabaseTable(current($DatabaseTables));
							reset($this->Layers);
							while (current($this->Layers)) {
								$this->Layers[key($this->Layers)]->createDatabaseTable(current($DatabaseTables));
								next($this->Layers);
							}
							next ($DatabaseTables);
						}
						$DatabaseOptions = array();
						if ($this->SessionTypeName['SessionTypeName'] == $ObjectTypeName) {
							$DatabaseOptionsName = $ObjectType;
							$DatabaseOptionsName .= 'Session';

							$DatabaseOptions[$DatabaseOptionsName] = $_SESSION['POST'][$this->SessionTypeName['SessionValue']];
						}
						$this->createModules($ObjectType, $ObjectTypeName, $DatabaseTables, $DatabaseOptions);
					}
				}

				next($this->LayerModuleTable);
				$moduletable = current($this->LayerModuleTable);
				$keymoduletable = key($this->LayerModuleTable);
			}
		} else {
			array_push($this->ErrorMessage,'buildModules: Module Tablename is not set!');
			return FALSE;
		}
		
		return $this;
	}

}

?>