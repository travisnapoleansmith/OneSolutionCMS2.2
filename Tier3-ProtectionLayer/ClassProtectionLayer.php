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
 * Class Protection Layer
 *
 * Class ProtectionLayer is designed as the security of the entire system.
 *
 * @author Travis Napolean Smith
 * @copyright Copyright (c) 1999 - 2013 One Solution CMS
 * @copyright PHP - Copyright (c) 2005 - 2013 One Solution CMS
 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
 * @version PHP - 2.1.140
 * @version C++ - Unknown
 */
class ProtectionLayer extends LayerModulesAbstract
{
	/**
	 * Content Layer Modules
	 *
	 * @var array
	 */
	protected $Modules;

	/**
	 * User settings for what is allowed to be done with the database -  set with Tier3ProtectionLayerSetting.php
	 * in /Configuration folder
	 *
	 * @var array
	 */
	protected $DatabaseAllow;

	/**
	 * User setting for what is cannot be done with the database - set with Tier3ProtectionLayerSetting.php
	 * in /Configuration folder
	 *
	 * @var array
	 */
	protected $DatabaseDeny;

	/**
	 * Create an instance of ProtectionLayer
	 *
	 * @access public
	 */
	public function __construct () {
		$this->Modules = Array();
		$this->DatabaseTable = Array();
		$GLOBALS['ErrorMessage']['ProtectionLayer'] = array();
		$this->ErrorMessage = &$GLOBALS['ErrorMessage']['ProtectionLayer'];

		$this->DatabaseAllow = &$GLOBALS['Tier3DatabaseAllow'];
		$this->DatabaseDeny = &$GLOBALS['Tier3DatabaseDeny'];

		$credentaillogonarray = $GLOBALS['credentaillogonarray'];

		//$this->LayerModuleOn = TRUE;

		if ($this->LayerModuleOn === TRUE) {
			$this->LayerModule = new DataAccessLayer();
			$this->LayerModule->setPriorLayerModule($this);
			//$this->LayerModule->createDatabaseTable('ContentLayer');
			$this->LayerModule->setDatabaseAll ($credentaillogonarray[0], $credentaillogonarray[1], $credentaillogonarray[2], $credentaillogonarray[3], NULL);
			$this->LayerModule->buildModules('DataAccessLayerModules', 'DataAccessLayerTables', 'DataAccessLayerModulesSettings');
		} else {
			$this->TokenKey = &$GLOBALS['SETTINGS']['TIER CONFIGURATION']['TOKENKEY'];
			$this->Location = $GLOBALS['SETTINGS']['TIER CONFIGURATION']['TIER2DATAACCESSLAYERSOAPLOCATION'] . $this->TokenKey;
			$this->Uri = &$GLOBALS['SETTINGS']['SITE SETTINGS']['SITELINK'];

			$this->Client = new SoapClient(NULL, array('location' => $this->Location, 'uri' => $this->Uri, 'soap_version' => SOAP_1_2));
			//$this->Client->createDatabaseTable('ContentLayer');
			$this->Client->setDatabaseAll ($credentaillogonarray[0], $credentaillogonarray[1], $credentaillogonarray[2], $credentaillogonarray[3], NULL);
			$this->Client->buildModules('DataAccessLayerModules', 'DataAccessLayerTables', 'DataAccessLayerModulesSettings');

			//$return = $this->Client->getDatabaseTable();
			//print_r($return);
		}

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
	/*public function setDatabaseAll ($hostname, $user, $password, $databasename) {
		$this->Hostname = $hostname;
		$this->User = $user;
		$this->Password = $password;
		$this->DatabaseName = $databasename;

		if ($this->LayerModuleOn === TRUE) {
			$this->LayerModule->setDatabaseAll ($hostname, $user, $password, $databasename);
		} else {
			$this->Client->setDatabaseAll ($hostname, $user, $password, $databasename);
		}

		//$return = $this->Client->getDatabasename();
		//print_r($return . "\n");
	}*/
	
	/*public function setDatabaseAll ($Hostname, $User, $Password, $DatabaseName) {
		if ($Hostname != NULL & $User != NULL & $Password != NULL & $DatabaseName != NULL) {
			$this->Hostname = $Hostname;
			$this->User = $User;
			$this->Password = $Password;
			$this->DatabaseName = $DatabaseName;
			if ($this->LayerModuleOn === TRUE) {
				if ($this->LayerModule != NULL) {
					$this->LayerModule->setDatabaseAll ($Hostname, $User, $Password, $DatabaseName);
				} else {
					array_push($this->ErrorMessage,'setDatabaseAll: LayerModule Cannot Be Null!');
					return FALSE;
				}
			} else {
				if ($this->Client != NULL) {
					$this->Client->setDatabaseAll ($Hostname, $User, $Password, $DatabaseName);
				} else {
					array_push($this->ErrorMessage,'setDatabaseAll: Client Cannot Be Null!');
					return FALSE;
				}
			}
			
			return $this;
		} else {
			array_push($this->ErrorMessage,'setDatabaseAll: Hostname, User, Password or DatabaseName Cannot Be Null!');
			return FALSE;
		}
	}*/

	/**
	 * ConnectAll
	 *
	 * Connects to all databases
	 *
	 * @access public
	*/
	/*public function ConnectAll () {
		if ($this->LayerModuleOn === TRUE) {
			$this->LayerModule->ConnectAll();
		} else {
			$this->Client->ConnectAll();
		}
	}*/
	
	/*public function ConnectAll () {
		if ($this->Hostname != NULL & $this->User != NULL & $this->Password != NULL & $this->DatabaseName != NULL) {
			try {
				if ($this->LayerModuleOn === TRUE) {
					if ($this->LayerModule != NULL) {
						$this->LayerModule->ConnectAll();
					} else {
						array_push($this->ErrorMessage,'ConnectAll: LayerModule Cannot Be Null!');
						return FALSE;
					}
				} else {
					if ($this->Client != NULL) {
						$this->Client->ConnectAll();
					} else {
						array_push($this->ErrorMessage,'ConnectAll: Client Cannot Be Null!');
						return FALSE;
					}
				}
			} catch (Exception $e) {
				array_push($this->ErrorMessage,'ConnectAll: Exception Thrown - Message: ' . $e->getMessage() . '!');
				return FALSE;
			}
		
			return $this;
		} else {
			array_push($this->ErrorMessage,'ConnectAll: $this->Hostname, $this->User, $this->Password or $this->DatabaseName Cannot Be Null!');
			return FALSE;
		}
	}*/
	
	/**
	 * Connect
	 *
	 * Connect to a database table
	 *
	 * @param string $DatabaseTable the name of the database table to connect to
	 * @access public
	 */
	/*public function Connect ($key) {
		if ($this->LayerModuleOn === TRUE) {
			$this->LayerModule->Connect($key);
		} else {
			$this->Client->Connect($key);
		}
	}*/
	
	/*public function Connect ($Key) {
		if ($this->Hostname != NULL & $this->User != NULL & $this->Password != NULL & $this->DatabaseName != NULL) {
			if ($Key != NULL) {
				try {
					if ($this->LayerModuleOn === TRUE) {
						if ($this->LayerModule != NULL) {
							$Return = $this->LayerModule->Connect($Key);
							if ($Return === FALSE) {
								return FALSE;
							}
						 } else {
							array_push($this->ErrorMessage,'Connect: LayerModule Cannot Be Null!');
							return FALSE;
						}
					} else {
						if ($this->Client != NULL) {
							$Return = $this->Client->Connect($Key);
							
							if ($Return === FALSE) {
								return FALSE;
							}
						} else {
							array_push($this->ErrorMessage,'Connect: Client Cannot Be Null!');
							return FALSE;
						}
					}
				} catch (Exception $E) {
					array_push($this->ErrorMessage,'ConnectAll: Exception Thrown - Message: ' . $E->getMessage() . '!');
					return FALSE;
				} 
				
				return $this;
				
			} else {
				array_push($this->ErrorMessage,'Connect: Key Cannot Be Null!');
				return FALSE;
			}
		} else {
			array_push($this->ErrorMessage,'Connect: $this->Hostname, $this->User, $this->Password or $this->DatabaseName Cannot Be Null!');
			return FALSE;
		}
	}*/
	
	/**
	 * DiscconnectAll
	 *
	 * Disconnects from all databases
	 *
	 * @access public
	 */
	/*public function DisconnectAll () {
		if ($this->LayerModuleOn === TRUE) {
			$this->LayerModule->DisconnectAll();
		} else {
			$this->Client->DisconnectAll();
		}
	}*/
	
	/*public function DisconnectAll () {
		if ($this->LayerModuleOn === TRUE) {
			if ($this->LayerModule != NULL) {
				try {
					$Return = $this->LayerModule->DisconnectAll();
					
					if ($Return != TRUE) {
						array_push($this->ErrorMessage,'DisconnectAll: Could Not Disconnect From Database!');
						return FALSE;
					}
				} catch (SoapFault $E) {
					array_push($this->ErrorMessage,'DisconnectAll: Could Not Disconnect From Database!');
					return FALSE;
				}
			} else {
				array_push($this->ErrorMessage,'DisconnectAll: LayerModule Cannot Be Null!');
				return FALSE;
			}
		} else {
			if ($this->Client != NULL) {
				try {
					$Return = $this->Client->DisconnectAll();
					
					if ($Return != TRUE) {
						array_push($this->ErrorMessage,'DisconnectAll: Could Not Disconnect From Database!');
						return FALSE;
					}
				} catch (SoapFault $E) {
					array_push($this->ErrorMessage,'DisconnectAll: Could Not Disconnect From Database!');
					return FALSE;
				}
			} else {
				array_push($this->ErrorMessage,'DisconnectAll: Client Cannot Be Null!');
				return FALSE;
			}
		}
		return $this;
	}*/
	
	/**
	 * Disconnect
	 *
	 * Disconnection from a database table
	 *
	 * @param string $DatabaseTable the name of the database table to disconnect from
	 * @access public
	*/
	/*public function Disconnect ($key) {
		if ($this->LayerModuleOn === TRUE) {
			$this->LayerModule->Disconnect($key);
		} else {
			$this->Client->Disconnect($key);
		}
	}*/
	
	/*public function Disconnect ($Key) {
		if ($Key != NULL) {
			if ($this->LayerModuleOn === TRUE) {
				if ($this->LayerModule != NULL) {
					try {
						$Return = $this->LayerModule->Disconnect($Key);
						
						if ($Return == TRUE) {
							return $this;
						} else {
							array_push($this->ErrorMessage,'Disconnect: Could Not Disconnect From Database!');
							return FALSE;
						}
					} catch (SoapFault $E) {
						array_push($this->ErrorMessage,'Disconnect: Could Not Disconnect From Database!');
						return FALSE;
					}
				} else {
					array_push($this->ErrorMessage,'Disconnect: LayerModule Cannot Be Null!');
					return FALSE;
				}
			} else {
				if ($this->Client != NULL) {
					try {
						$Return = $this->Client->Disconnect($Key);
						
						if ($Return == TRUE) {
							return $this;
						} else {
							array_push($this->ErrorMessage,'Disconnect: Could Not Disconnect From Database!');
							return FALSE;
						}
					} catch (SoapFault $E) {
						array_push($this->ErrorMessage,'Disconnect: Could Not Disconnect From Database!');
						return FALSE;
					}
				} else {
					array_push($this->ErrorMessage,'Disconnect: Client Cannot Be Null!');
					return FALSE;
				}
			}
		} else {
			array_push($this->ErrorMessage,'Disconnect: Key Cannot Be Null!');
			return FALSE;
		}
	}*/
	
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
	/*public function createDatabaseTable($key) {
		if ($this->LayerModuleOn === TRUE) {
			try {
				$this->LayerModule->createDatabaseTable($key);
			} catch (SoapFault $E) {
				return FALSE;
			}
		} else {
			$this->Client->createDatabaseTable($key);
		}
	}*/
	
	/**
	 * createDatabaseTable
	 *
	 * Creates a database table object
	 *
	 * @param string $DatabaseTableName the name of the database table to create
	 * @access public
	 */
	/*public function createDatabaseTable($DatabaseTableName) {
		if ($DatabaseTableName != NULL) {
			if (!is_array($DatabaseTableName)) {
				if ($this->LayerModuleOn === TRUE) {
					if ($this->LayerModule != NULL) {
						try {
							$this->LayerModule->createDatabaseTable($DatabaseTableName);
						} catch (SoapFault $E) {
							throw new SoapFault("createDatabaseTable", $E->getMessage());
						}
					} else {
						array_push($this->ErrorMessage,'createDatabaseTable: LayerModule Cannot Be Null!');
						return FALSE;
					}
				} else {
					if ($this->Client != NULL) {
						try {
							$this->Client->createDatabaseTable($DatabaseTableName);
						} catch (SoapFault $E) {
							throw new SoapFault("createDatabaseTable", $E->getMessage());
						}
					} else {
						array_push($this->ErrorMessage,'createDatabaseTable: Client Cannot Be Null!');
						return FALSE;
					}
				}
				return $this;
				
			} else {
				array_push($this->ErrorMessage,'createDatabaseTable: DatabaseTableName Cannot Be An Array!');
				return FALSE;
			}
		} else {
			array_push($this->ErrorMessage,'createDatabaseTable: DatabaseTableName Cannot Be Null!');
			return FALSE;
		}
	}*/
	
	/**
	 * destroyDatabaseTable
	 *
	 * Destroys a database table object
	 *
	 * @param string $DatabaseTableName the name of the database table to destroy
	 * @access public
	 */
	/*public function destroyDatabaseTable($DatabaseTableName) {
		if ($DatabaseTableName != NULL) {
			if (!is_array($DatabaseTableName)) {
				if ($this->LayerModuleOn === TRUE) {
					if ($this->LayerModule != NULL) {
						try {
							$Return = $this->LayerModule->destroyDatabaseTable($DatabaseTableName);
							
							if ($Return === FALSE) {
								return FALSE;
							} else {
								return $this;
							}
						} catch (SoapFault $E) {
							throw new SoapFault("destroyDatabaseTable", $E->getMessage());
						}
					} else {
						array_push($this->ErrorMessage,'destroyDatabaseTable: LayerModule Cannot Be Null!');
						return FALSE;
					}
				} else {
					if ($this->Client != NULL) {
						try {
							$Return = $this->Client->destroyDatabaseTable($DatabaseTableName);
							
							if ($Return === FALSE) {
								return FALSE;
							} else {
								return $this;
							}
						} catch (SoapFault $E) {
							throw new SoapFault("destroyDatabaseTable", $E->getMessage());
						}
					} else {
						array_push($this->ErrorMessage,'destroyDatabaseTable: Client Cannot Be Null!');
						return FALSE;
					}
				}
			} else {
				array_push($this->ErrorMessage,'destroyDatabaseTable: DatabaseTableName Cannot Be An Array!');
				return FALSE;
			}
		} else {
			array_push($this->ErrorMessage,'destroyDatabaseTable: DatabaseTableName Cannot Be Null!');
			return FALSE;
		}
	}*/
	
	public function checkPass($DatabaseTable, $function, $functionarguments) {
		reset($this->Modules);
		$hold = NULL;
		$args = func_num_args();
		if ($args > 3) {
			$hookargumentsarray = func_get_args();
			$hookarguments = $hookargumentsarray[3];
			if (is_array($hookarguments)) {
				while (current($this->Modules)) {
					$tempobject = current($this->Modules[key($this->Modules)]);
					//$databasetables = $tempobject->getTableNames();
					if ($function == 'PROTECT') {
						$tempobject->FetchDatabase ($functionarguments);
					} else {
						$tempobject->FetchDatabase ($this->PageID);
					}
					//$tempobject->CreateOutput($this->Space);
					//$tempobject->getOutput();
					$hold = $tempobject->Verify($function, $functionarguments, $hookarguments);
					next($this->Modules);
				}
			} else {
				array_push($this->ErrorMessage,'checkPass: Hook Arguments Must Be An Array!');
			}
		} else {
			while (current($this->Modules)) {
				$tempobject = current($this->Modules[key($this->Modules)]);
				//$databasetables = $tempobject->getTableNames();
				if ($function == 'PROTECT') {
					$tempobject->FetchDatabase ($functionarguments);
				} else {
					$tempobject->FetchDatabase ($this->PageID);
				}
				//$tempobject->CreateOutput($this->Space);
				//$tempobject->getOutput();
				$hold = $tempobject->Verify($function, $functionarguments);
				next($this->Modules);
			}
		}
		/*
		while (current($this->Modules)) {
			$tempobject = current($this->Modules[key($this->Modules)]);
			//$databasetables = $tempobject->getTableNames();
			if ($function == 'PROTECT') {
				$tempobject->FetchDatabase ($functionarguments);
			} else {
				$tempobject->FetchDatabase ($this->PageID);
			}
			//$tempobject->CreateOutput($this->Space);
			//$tempobject->getOutput();
			$hold = $tempobject->Verify($function, $functionarguments);
			next($this->Modules);
		}*/

		if ($function == 'PROTECT') {
			if ($hold) {
				return $hold;
			}
		} else {
			if ($this->LayerModuleOn === TRUE) {
				$hold2 = $this->LayerModule->pass($DatabaseTable, $function, $functionarguments);
			} else {
				$hold2 = $this->Client->pass($DatabaseTable, $function, $functionarguments);
			}
			if ($hold2) {
				return $hold2;
			} else {
				return FALSE;
			}
		}
	}

	public function pass($DatabaseTable, $Function, $FunctionArguments) {
		if (!is_null($FunctionArguments)) {
			if (is_array($FunctionArguments)) {
				if (!is_null($Function)) {
					if (!is_array($Function)) {
						if ($this->DatabaseAllow[$Function]) {
							$args = func_num_args();
							if ($args > 3) {
								$HookArgumentsArray = func_get_args();
								$HookArguments = $HookArgumentsArray[3];
								if (is_array($HookArguments)) {
									if ($this->LayerModuleOn === TRUE) {
										if ($this->LayerModule != NULL) {
											$hold = $this->LayerModule->pass($DatabaseTable, $Function, $FunctionArguments, $HookArguments);
										} else {
											array_push($this->ErrorMessage,'pass: LayerModule Cannot Be Null!');
											return FALSE;
										}
									} else {
										if ($this->Client != NULL) {
											$hold = $this->Client->pass($DatabaseTable, $Function, $FunctionArguments, $HookArguments);
										} else {
											array_push($this->ErrorMessage,'pass: Client Cannot Be Null!');
											return FALSE;
										}
									}
								} else {
									array_push($this->ErrorMessage,'pass: Hook Arguments Must Be An Array!');
								}
							} else {
								if ($this->LayerModuleOn === TRUE) {
									$hold = $this->LayerModule->pass($DatabaseTable, $Function, $FunctionArguments);
								} else {
									$hold = $this->Client->pass($DatabaseTable, $Function, $FunctionArguments);
								}
							}

							if ($hold) {
								return $hold;
							}
						} else if ($this->DatabaseDeny[$Function] || $Function = 'PROTECT') {
							$args = func_num_args();
							if ($args > 3) {
								$HookArgumentsArray = func_get_args();
								$HookArguments = $HookArgumentsArray[3];
								if (is_array($HookArguments)) {
									if ($HookArguments['Execute'] === TRUE) {
										if ($HookArguments['Method'] != NULL) {
											if ($HookArguments['ObjectType'] != NULL) {
												if ($HookArguments['ObjectTypeName'] != NULL) {
													$Method = $HookArguments['Method'];
													$ObjectType = $HookArguments['ObjectType'];
													$ObjectTypeName = $HookArguments['ObjectTypeName'];
													$hold = $this->Modules[$ObjectType][$ObjectTypeName]->$Method($FunctionArguments);
												}
											}
											
										}
										
									} else {
										$hold = $this->checkPass($DatabaseTable, $Function, $FunctionArguments, $HookArguments);
									}
								} else {
									array_push($this->ErrorMessage,'pass: Hook Arguments Must Be An Array!');
								}
							} else {
								$hold = $this->checkPass($DatabaseTable, $Function, $FunctionArguments);
							}

							if ($hold) {
								return $hold;
							} else {
								return FALSE;
							}
						} else {
							array_push($this->ErrorMessage,'pass: MySqlConnect Member Does Not Exist!');
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

}

?>