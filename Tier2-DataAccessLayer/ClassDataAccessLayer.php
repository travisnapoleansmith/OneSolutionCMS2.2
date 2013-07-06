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
 * Class DataAccessLayer is designed as the database abstraction of the entire system.
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
	public function setDatabaseAll ($Hostname, $User, $Password, $DatabaseName) {
		if ($Hostname != NULL & $User != NULL & $Password != NULL & $DatabaseName != NULL) {
			$this->Hostname = $Hostname;
			$this->User = $User;
			$this->Password = $Password;
			$this->DatabaseName = $DatabaseName;
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
							if (!empty($TableNameKey)) {
								$this->DatabaseTable[$TableNameKey]->setDatabaseAll($this->Hostname, $this->User, $this->Password, $this->DatabaseName, $TableNameValue);
								$this->DatabaseTable[$TableNameKey]->Connect();
							}
						} catch (Exception $e) {
							array_push($this->ErrorMessage,'ConnectAll: Exception Thrown - Message: ' . $e->getMessage() . '!');
							return FALSE;
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
				throw new SoapFault("Connect", 'Key Doesn\'t Exist!');
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
		if ($this->DatabaseTable != NULL) {
			if (is_array($this->DatabaseTable)) {
				foreach($this->DatabaseTable as $Key => $Value) {
					try {
						$Return = $this->DatabaseTable[$Key]->Disconnect();
						
						if ($Return != TRUE) {
							array_push($this->ErrorMessage,'DisconnectAll: Could Not Disconnect From Database!');
							return FALSE;
						}
					} catch (SoapFault $E) {
						array_push($this->ErrorMessage,'DisconnectAll: Could Not Disconnect From Database!');
						return FALSE;
					}
				}
			} else {
				array_push($this->ErrorMessage,'DisconnectAll: $this->DatabaseTable Must Be An Array!');
				return FALSE;
			}
		} else {
			array_push($this->ErrorMessage,'DisconnectAll: $this->DatabaseTable Cannot Be Null!');
			return FALSE;
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
	public function Disconnect ($Key) {
		if ($Key != NULL) {
			$Return = NULL;
			if (isset($this->DatabaseTable[$Key])) {
				$Return = $this->DatabaseTable[$Key]->Disconnect();
			} else {
				array_push($this->ErrorMessage,'Disconnect: Exception Thrown - Message: Key Doesn\'t Exist!');
				throw new SoapFault("Disconnect", 'Key Doesn\'t Exist!');
			}
			
			if ($Return == TRUE) {
				return $this;
			} else {
				array_push($this->ErrorMessage,'Disconnect: Could Not Disconnect From Database!');
				return FALSE;
			}
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
	 * Creates a database table object
	 *
	 * @param string $DatabaseTableName the name of the database table to create
	 * @access public
	 */
	public function createDatabaseTable($DatabaseTableName) {
		if ($DatabaseTableName != NULL) {
			if (!is_array($DatabaseTableName)) {
				if (!isset($this->DatabaseTable[$DatabaseTableName])) {
					$this->DatabaseTable[$DatabaseTableName] =  new MySqlConnect();
					return $this;
				} else {
					array_push($this->ErrorMessage,'createDatabaseTable: Exception Thrown - Message: DatabaseTableName Has Already Been Set!');
					throw new SoapFault("createDatabaseTable", 'DatabaseTableName Has Already Been Set!');
				}
				
			} else {
				array_push($this->ErrorMessage,'createDatabaseTable: DatabaseTableName Cannot Be An Array!');
				return FALSE;
			}
		} else {
			array_push($this->ErrorMessage,'createDatabaseTable: DatabaseTableName Cannot Be Null!');
			return FALSE;
		}
		
	}
	
	/**
	 * destroyDatabaseTable
	 *
	 * Destroys a database table object
	 *
	 * @param string $DatabaseTableName the name of the database table to destroy
	 * @access public
	 */
	public function destroyDatabaseTable($DatabaseTableName) {
		if ($DatabaseTableName != NULL) {
			if (!is_array($DatabaseTableName)) {
				if (isset($this->DatabaseTable[$DatabaseTableName])) {
					unset($this->DatabaseTable[$DatabaseTableName]);
					return $this;
				} else {
					array_push($this->ErrorMessage,'destroyDatabaseTable: Exception Thrown - Message: DatabaseTableName Has Not Been Set!');
					throw new SoapFault("destroyDatabaseTable", 'DatabaseTableName Has Not Been Set!');
				}
				
			} else {
				array_push($this->ErrorMessage,'destroyDatabaseTable: DatabaseTableName Cannot Be An Array!');
				return FALSE;
			}
		} else {
			array_push($this->ErrorMessage,'destroyDatabaseTable: DatabaseTableName Cannot Be Null!');
			return FALSE;
		}
		
	}

	protected function checkPass($DatabaseTable, $Function, $FunctionArguments) {
		//reset($this->Modules);
		
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
		
		if (!is_null($FunctionArguments)) {
			if (is_array($FunctionArguments)) {
				if (!is_null($Function)) {
					if (!is_array($Function)) {
						if (isset($this->DatabaseTable["$DatabaseTable"])) {
							if ($FunctionArguments[0]) {
								$PassArguments = array();
								$PassArguments[0] = $FunctionArguments;
							} else {
								$PassArguments = $FunctionArguments;
							}
							
							$hold2 = call_user_func_array(array($this->DatabaseTable["$DatabaseTable"], "$Function"), $PassArguments);
							if ($hold2) {
								return $hold2;
							} else {
								return FALSE;
								// NEEDS TO MAKE THIS WORK WITH ALL MODULES
								//return $this;
							}
						} else {
							array_push($this->ErrorMessage,'checkPass: $DatabaseTable MUST BE SET!');
							return FALSE;
						}
					} else {
						array_push($this->ErrorMessage,'checkPass: MySqlConnect Member Cannot Be An Array!');
						return FALSE;
					}
				} else {
					array_push($this->ErrorMessage,'checkPass: MySqlConnect Member Cannot Be Null!');
					return FALSE;
				}
			} else {
				array_push($this->ErrorMessage,'checkPass: Function Arguments Must Be An Array!');
				return FALSE;
			}
		} else {
			array_push($this->ErrorMessage,'checkPass: Function Arguments Cannot Be Null!');
			return FALSE;
		}
	}

	public function pass($DatabaseTable, $Function, $FunctionArguments) {
		if (!is_null($FunctionArguments)) {
			if (is_array($FunctionArguments)) {
				if (!is_null($Function)) {
					if (!is_array($Function)) {
						if (isset($this->DatabaseTable[$DatabaseTable])) {
							if ($this->DatabaseAllow[$Function]) {
								$hold = call_user_func_array(array($this->DatabaseTable["$DatabaseTable"], "$Function"), $FunctionArguments);
								if ($hold) {
									return $hold;
								} else {
									return FALSE;
									// NEEDS TO MAKE THIS WORK WITH ALL MODULES
									//return $this;
								}
							} else if ($this->DatabaseDeny[$Function]) {
								$hold = $this->checkPass($DatabaseTable, $Function, $FunctionArguments);
								if ($hold) {
									return $hold;
								} else {
									return FALSE;
								}
							} else {
								array_push($this->ErrorMessage,"pass: $Function from $DatabaseTable - MySqlConnect Member Does Not Exist!");
								return FALSE;
							}
						} else {
							array_push($this->ErrorMessage,'pass: $DatabaseTable MUST BE SET!');
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
		//debug_print_backtrace();
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
			if (is_array($this->LayerTable)) {
				
				foreach ($this->LayerModuleTable as $ModuleTableKey => $ModuleTable) {
					$ObjectType = $ModuleTable['ObjectType'];
					$ObjectTypeName = $ModuleTable['ObjectTypeName'];
					$ObjectTypeLocation = $ModuleTable['ObjectTypeLocation'];
					
					//$ModuleFileNameArray = array();
					//$ModuleFileNameArray = $this->buildArray($ModuleFileNameArray, 'ModuleFileName', $ModuleTableKey, $this->LayerModuleTable);
					$EnableDisable = $ModuleTable['Enable/Disable'];
			
					if ($EnableDisable == 'Enable') {
						foreach ($ModuleTable as $ModuleFileNameKey => $ModuleFileNameData) {
							if (strstr($ModuleFileNameKey, 'ModuleFileName')) {
								if (!empty($ModuleFileNameData)) {
									$ModulesFile = $_SERVER['SUBDOMAIN_DOCUMENT_ROOT'];
									$ModulesFile .= '/';
									$ModulesFile .= $ObjectTypeLocation;
									$ModulesFile .= '/';
									$ModulesFile .= $ModuleFileNameData;
									$ModulesFile .= '.php';
									
									if (is_file($ModulesFile)) {
										require_once($ModulesFile);
									} else {
										array_push($this->ErrorMessage,"buildModules: Module filename - $ModulesFile does not exist!");
									}
									
									//$this->LayerModuleTable[$ObjectType][$ObjectTypeName][$ModuleFileNameKey] = $ModulesFile;
								}
							}
						}					
						$DatabaseTables = NULL;
						foreach ($this->LayerTable as $Table) {
							if ($Table['ObjectType'] == $ObjectType & $Table['ObjectTypeName'] == $ObjectTypeName) {
								$DatabaseTables = $Table;
								break;
							}
						}
						
						if (is_array($DatabaseTables)) {
							foreach ($DatabaseTables as $DatabaseTablesKey => $DatabaseTableValue) {
								if (strstr($DatabaseTablesKey, 'DatabaseTable')) {
									if (!empty($DatabaseTableValue)) {
										$this->createDatabaseTable($DatabaseTableValue);
										
										if ($this->SessionTypeName['SessionTypeName'] == $ObjectTypeName) {
											$DatabaseOptionsName = $ObjectType;
											$DatabaseOptionsName .= 'Session';
		
											$DatabaseOptions[$DatabaseOptionsName] = $_SESSION['POST'][$this->SessionTypeName['SessionValue']];
										}
									}
								}
							}
						}
					}
				}
			}
		} else {
			array_push($this->ErrorMessage,'buildModules: Module Tablename is not set!');
			return FALSE;
		}
		
		return $this;
	}

}

?>