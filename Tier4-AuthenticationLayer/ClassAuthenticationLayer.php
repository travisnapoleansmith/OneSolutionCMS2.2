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
 * Class Authentication Layer
 *
 * Class AuthenticationLayer is designed to authenticate users.
 *
 * @author Travis Napolean Smith
 * @copyright Copyright (c) 1999 - 2013 One Solution CMS
 * @copyright PHP - Copyright (c) 2005 - 2013 One Solution CMS
 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
 * @version PHP - 2.1.140
 * @version C++ - Unknown
 */
class AuthenticationLayer extends LayerModulesAbstract
{
	/**
	 * Content Layer Modules
	 *
	 * @var array
	 */
	protected $Modules;

	/**
	 * User settings for what is allowed to be done with the database -  set with Tier4AuthenticationLayerSetting.php
	 * in /Configuration folder
	 *
	 * @var array
	 */
	protected $DatabaseAllow;

	/**
	 * User setting for what is cannot be done with the database - set with Tier4AuthenticationLayerSetting.php
	 * in /Configuration folder
	 *
	 * @var array
	 */
	protected $DatabaseDeny;

	/**
	 * Create an instance of AuthenticationLayer
	 *
	 * @access public
	 */
	public function __construct () {
		$this->Modules = Array();
		$this->DatabaseTable = Array();
		$GLOBALS['ErrorMessage']['AuthenticationLayer'] = array();
		$this->ErrorMessage = &$GLOBALS['ErrorMessage']['AuthenticationLayer'];

		$this->DatabaseAllow = &$GLOBALS['Tier4DatabaseAllow'];
		$this->DatabaseDeny = &$GLOBALS['Tier4DatabaseDeny'];

		$credentaillogonarray = $GLOBALS['credentaillogonarray'];

		$this->LayerModule = new ProtectionLayer();
		$this->LayerModule->setPriorLayerModule($this);
		$this->LayerModule->createDatabaseTable('ContentLayer');
		$this->LayerModule->setDatabaseAll ($credentaillogonarray[0], $credentaillogonarray[1], $credentaillogonarray[2], $credentaillogonarray[3], NULL);
		$this->LayerModule->buildModules('ProtectionLayerModules', 'ProtectionLayerTables', 'ProtectionLayerModulesSettings');

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
	/*
	public function setDatabaseAll ($hostname, $user, $password, $databasename) {
		$this->Hostname = $hostname;
		$this->User = $user;
		$this->Password = $password;
		$this->DatabaseName = $databasename;

		$this->LayerModule->setDatabaseAll ($hostname, $user, $password, $databasename);
	}*/

	/**
	 * ConnectAll
	 *
	 * Connects to all databases
	 *
	 * @access public
	*/
	/*
	public function ConnectAll () {
		$this->LayerModule->ConnectAll();
	}*/

	/**
	 * Connect
	 *
	 * Connect to a database table
	 *
	 * @param string $DatabaseTable the name of the database table to connect to
	 * @access public
	 */
	/*
	public function Connect ($key) {
		$this->LayerModule->Connect($key);
	}*/

	/**
	 * DiscconnectAll
	 *
	 * Disconnects from all databases
	 *
	 * @access public
	 */
	/*
	public function DisconnectAll () {
		$this->LayerModule->DisconnectAll();
	}*/

	/**
	 * Disconnect
	 *
	 * Disconnection from a database table
	 *
	 * @param string $DatabaseTable the name of the database table to disconnect from
	 * @access public
	*/
	/*
	public function Disconnect ($key) {
		$this->LayerModule->Disconnect($key);
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
	/*
	public function createDatabaseTable($DatabaseTableName) {
		try {
			$this->LayerModule->createDatabaseTable($DatabaseTableName);
		} catch (SoapFault $E) {
			return FALSE;
		}
	}*/

	protected function checkPass($DatabaseTable, $function, $functionarguments) {
		reset($this->Modules);
		$hold = NULL;
		$args = func_num_args();
		if ($args > 3) {
			$hookargumentsarray = func_get_args();
			$hookarguments = $hookargumentsarray[3];
			if (is_array($hookarguments)) {
				while (current($this->Modules)) {
					$tempobject = current($this->Modules[key($this->Modules)]);
					$databasetables = $tempobject->getTableNames();
					if ($function == 'AUTHENTICATE') {
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
				$databasetables = $tempobject->getTableNames();
				if ($function == 'AUTHENTICATE') {
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

		if ($function == 'AUTHENTICATE') {
			if ($hold) {
				return $hold;
			}
		} else {
			$hold2 = $this->LayerModule->pass($DatabaseTable, $function, $functionarguments);
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
						if ($this->DatabaseAllow[$function] || $function == 'PROTECT') {
							$args = func_num_args();
							if ($args > 3) {
								$hookargumentsarray = func_get_args();
								$hookarguments = $hookargumentsarray[3];
								if (is_array($hookarguments)) {
									$hold = $this->LayerModule->pass($databasetable, $function, $functionarguments, $hookarguments);
								} else {
									array_push($this->ErrorMessage,'pass: Hook Arguments Must Be An Array!');
								}
							} else {
								$hold = $this->LayerModule->pass($databasetable, $function, $functionarguments);
							}

							if ($hold) {
								return $hold;
							}
						} else if ($this->DatabaseDeny[$function] || $function == 'AUTHENTICATE') {
							$args = func_num_args();
							if ($args > 3) {
								$hookargumentsarray = func_get_args();
								$hookarguments = $hookargumentsarray[3];
								if (is_array($hookarguments)) {
									$hold = $this->checkPass($databasetable, $function, $functionarguments, $hookarguments);
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