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

		$this->LayerModuleOn = TRUE;

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
	public function setDatabaseAll ($hostname, $user, $password, $databasename) {
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
	}

	/**
	 * ConnectAll
	 *
	 * Connects to all databases
	 *
	 * @access public
	*/
	public function ConnectAll () {
		if ($this->LayerModuleOn === TRUE) {
			$this->LayerModule->ConnectAll();
		} else {
			$this->Client->ConnectAll();
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
	public function Connect ($key) {
		if ($this->LayerModuleOn === TRUE) {
			$this->LayerModule->Connect($key);
		} else {
			$this->Client->Connect($key);
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
		if ($this->LayerModuleOn === TRUE) {
			$this->LayerModule->DisconnectAll();
		} else {
			$this->Client->DisconnectAll();
		}
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
		if ($this->LayerModuleOn === TRUE) {
			$this->LayerModule->Disconnect($key);
		} else {
			$this->Client->Disconnect($key);
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
		if ($this->LayerModuleOn === TRUE) {
			$this->LayerModule->createDatabaseTable($key);
		} else {
			$this->Client->createDatabaseTable($key);
		}
	}

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

	public function pass($databasetable, $function, $functionarguments) {
		if (!is_null($functionarguments)) {
			if (is_array($functionarguments)) {
				if (!is_null($function)) {
					if (!is_array($function)) {
						if ($this->DatabaseAllow[$function]) {
							$args = func_num_args();
							if ($args > 3) {
								$hookargumentsarray = func_get_args();
								$hookarguments = $hookargumentsarray[3];
								if (is_array($hookarguments)) {
									if ($this->LayerModuleOn === TRUE) {
										$hold = $this->LayerModule->pass($databasetable, $function, $functionarguments, $hookarguments);
									} else {
										$hold = $this->Client->pass($databasetable, $function, $functionarguments, $hookarguments);
									}
								} else {
									array_push($this->ErrorMessage,'pass: Hook Arguments Must Be An Array!');
								}
							} else {
								if ($this->LayerModuleOn === TRUE) {
									$hold = $this->LayerModule->pass($databasetable, $function, $functionarguments);
								} else {
									$hold = $this->Client->pass($databasetable, $function, $functionarguments);
								}
							}

							if ($hold) {
								return $hold;
							}
						} else if ($this->DatabaseDeny[$function] || $function = 'PROTECT') {
							$args = func_num_args();
							if ($args > 3) {
								$hookargumentsarray = func_get_args();
								$hookarguments = $hookargumentsarray[3];
								if (is_array($hookarguments)) {
									if ($hookarguments['Execute'] === TRUE) {
										if ($hookarguments['Method'] != NULL) {
											if ($hookarguments['ObjectType'] != NULL) {
												if ($hookarguments['ObjectTypeName'] != NULL) {
													$Method = $hookarguments['Method'];
													$ObjectType = $hookarguments['ObjectType'];
													$ObjectTypeName = $hookarguments['ObjectTypeName'];
													$hold = $this->Modules[$ObjectType][$ObjectTypeName]->$Method($functionarguments);
												}
											}
											
										}
										
									} else {
										$hold = $this->checkPass($databasetable, $function, $functionarguments, $hookarguments);
									}
								} else {
									array_push($this->ErrorMessage,'pass: Hook Arguments Must Be An Array!');
								}
							} else {
								$hold = $this->checkPass($databasetable, $function, $functionarguments);
							}

							if ($hold) {
								return $hold;
							} else {
								return FALSE;
							}
						} else {
							array_push($this->ErrorMessage,'pass: MySqlConnect Member Does Not Exist!');
						}
					} else {
						array_push($this->ErrorMessage,'pass: MySqlConnect Member Cannot Be An Array!');
					}
				} else {
					array_push($this->ErrorMessage,'pass: MySqlConnect Member Cannot Be Null!');
				}
			} else {
				array_push($this->ErrorMessage,'pass: Function Arguments Must Be An Array!');
			}
		} else {
			array_push($this->ErrorMessage,'pass: Function Arguments Cannot Be Null!');
		}
	}

}

?>