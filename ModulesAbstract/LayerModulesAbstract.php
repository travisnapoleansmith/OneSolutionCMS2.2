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

abstract class LayerModulesAbstract
{
	protected $Writer;
	
	protected $Layers = array();

	protected $LayerModule;
	protected $PriorLayerModule;

	protected $LayerModuleTable;
	protected $LayerModuleTableName;
	protected $LayerModuleTableNameSetting;

	protected $LayerModuleSetting = array();

	protected $LayerTable;
	protected $LayerTableName;

	protected $LayerModuleOn = TRUE;

	protected $TokenKey = NULL;
	protected $Uri = NULL;
	protected $Location = NULL;
	protected $Client = NULL;
	
	protected $PageID;
	protected $ObjectID;

	protected $SessionName = array();
	protected $SessionTypeName;
	
	protected $Hostname;
	protected $User;
	protected $Password;
	protected $DatabaseName;
	protected $DatabaseTable;

	protected $OneSolutionCMSVersion;
	
	protected $ModulesLocation;

	/**
	 * Protection Layer Modules
	 *
	 * @var array
	 */
	protected $Modules = array();

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
	 * Tier Keyword
	 *
	 * @var string
	 */
	protected $TierKeyword;
	
	/**
	 * Tier Verify Method Call Name
	 *
	 * @var string
	 */
	protected $TierVerifyMethod;
	
	protected $Space;
	
	protected $ErrorMessage = array();
	
	public function setPriorLayerModule(self &$PriorLayerModule) {
		$this->PriorLayerModule = &$PriorLayerModule;
	}

	public function setPageID($PageID) {
		$this->PageID = $PageID;
	}

	public function getPageID() {
		return $this->PageID;
	}

	public function setObjectID($ObjectID) {
		$this->ObjectID = $ObjectID;
	}

	public function getObjectID() {
		return $this->ObjectID;
	}

	public function setHostname ($Hostname){
		$this->Hostname = $Hostname;
	}

	public function getHostname () {
		return $this->Hostname;
	}

	public function setUser ($User){
		$this->User = $User;
	}

	public function getUser () {
		return $this->User;
	}

	public function setPassword ($Password){
		$this->Password = $Password;
	}

	public function getPassword () {
		return $this->Password;
	}

	public function setDatabaseName ($DatabaseName){
		$this->DatabaseName = $DatabaseName;
	}

	public function getDatabaseName () {
		return $this->DatabaseName;
	}

	final public function getOneSolutionCMSVersion() {
		return $this->OneSolutionCMSVersion;
	}

	public function setDatabasetable ($DatabaseTable){
		$this->DatabaseTable[$DatabaseTable] =  new MySqlConnect();
	}

	public function getDatabaseTable() {
		return $this->DatabaseTable;
	}

	public function getSpace() {
		return $this->Space;
	}

	public function getError ($IDNumber) {
		return $this->ErrorMessage[$IDNumber];
	}

	public function getErrorArray() {
		return $this->ErrorMessage;
	}

	public function setModulesLocation ($ModulesLocation){
		$this->ModulesLocation = $ModulesLocation;
	}

	public function getModulesLocation () {
		return $this->ModulesLocation;
	}

	public function getLayerModuleTable (){
		return $this->LayerModuleTable;
	}

	public function getLayerModuleSetting () {
		return $this->LayerModuleSetting;
	}
	
	// TIERS NEED
	/**
	 * setModules
	 *
	 * Setter for Modules
	 *
	 * @param string $ModuleName String for Module Name set. Must be a string.
	 * @param string $ObjectName String for Object Name set or Instance Name of this Object. Must be a string.
	 * @param string $ModuleObject Object for Module to set. Must be an object.
	 * @return BOOL FALSE if ModuleName, ObjectName or ModuleObject is not set or is an Array). Return BOOL FALSE if ModuleObject is not an object.
	 * @access public
	 */
	public function setModules($ModuleName, $ObjectName, $ModuleObject) {
		if (is_null($ModuleName) === TRUE) {
			array_push($this->ErrorMessage,'setModules: ModuleName Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($ModuleName) === TRUE) {
			array_push($this->ErrorMessage,'setModules: ModuleName Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($ModuleName) === TRUE) {
			array_push($this->ErrorMessage,'setModules: ModuleName Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($ModuleName) === TRUE) {
			array_push($this->ErrorMessage,'setModules: ModuleName Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
	
		if (is_null($ObjectName) === TRUE) {
			array_push($this->ErrorMessage,'setModules: ObjectName Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($ObjectName) === TRUE) {
			array_push($this->ErrorMessage,'setModules: ObjectName Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($ObjectName) === TRUE) {
			array_push($this->ErrorMessage,'setModules: ObjectName Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($ObjectName) === TRUE) {
			array_push($this->ErrorMessage,'setModules: ObjectName Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_null($ModuleObject) === TRUE) {
			array_push($this->ErrorMessage,'setModules: ObjectName Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($ModuleObject) === TRUE) {
			array_push($this->ErrorMessage,'setModules: ObjectName Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($ObjectName) === FALSE) {
			array_push($this->ErrorMessage,'setModules: ObjectName MUST Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($ModuleObject) === TRUE) {
			array_push($this->ErrorMessage,'setModules: ObjectName Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		$this->Modules[$ModuleName][$ObjectName] = $ModuleObject;
		return $this;
	}
	
	// TIERS NEED
	/**
	 * getModules
	 *
	 * Returns the Module for ModuleName set
	 * 
	 * @param string $ModuleName String for Module Name set. Must be a string.
	 * @return BOOL FALSE if ModuleName is not set or an Array if the module has been set.
	 * @access public
	 */
	public function getModules($ModuleName) {
		if (is_null($ModuleName) === TRUE) {
			array_push($this->ErrorMessage,'setModules: ModuleName Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($ModuleName) === TRUE) {
			array_push($this->ErrorMessage,'setModules: ModuleName Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($ModuleName) === TRUE) {
			array_push($this->ErrorMessage,'setModules: ModuleName Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($ModuleName) === TRUE) {
			array_push($this->ErrorMessage,'setModules: ModuleName Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if ($this->Modules[$ModuleName] != NULL) {
			return $this->Modules[$ModuleName];
		} else {
			array_push($this->ErrorMessage,'getModules: Module is not set!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
	}
	
	// TIERS NEED
	/**
	 * setDatabaseAll
	 *
	 * Setter for Hostname, Username, Password, Database name and Database table
	 *
	 * @param string $Hostname the name of the host needed to connect to database.
	 * @param string $Username the user account needed to connect to database.
	 * @param string $Password the user's password needed to connect to database.
	 * @param string $DatabaseName the name of the database needed to connect to database.
	 * @access public
	 */
	public function setDatabaseAll ($Hostname, $Username, $Password, $DatabaseName) {
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
		
		$this->Hostname = $Hostname;
		$this->User = $Username;
		$this->Password = $Password;
		$this->DatabaseName = $DatabaseName;
		if ($this->LayerModuleOn === TRUE) {
			if ($this->LayerModule != NULL) {
				$Return = $this->LayerModule->setDatabaseAll ($Hostname, $Username, $Password, $DatabaseName);
				
				$LayerModuleType = get_class($this->LayerModule);
				
				if ($Return != NULL) {
					if (is_object($Return) === FALSE) {
						return $Return;
					} else {
						if (get_class($Return) !== $LayerModuleType) {
							return $Return;
						}
					}
				}
			} else {
				array_push($this->ErrorMessage,'setDatabaseAll: LayerModule Cannot Be Null!');
				$BackTrace = debug_backtrace(FALSE);
				return FALSE;
			}
			
		} else {
			if ($this->Client != NULL) {
				$Return = $this->Client->setDatabaseAll ($Hostname, $Username, $Password, $DatabaseName);
				if ($Return != NULL) {
					return $Return;
				} else {
					return NULL;
				}
			} else {
				array_push($this->ErrorMessage,'setDatabaseAll: Client Cannot Be Null!');
				$BackTrace = debug_backtrace(FALSE);
				return FALSE;
			}
		}
		
		return $this;
	}
	
	// TIERS NEED
	/**
	 * ConnectAll
	 *
	 * Connects to all databases
	 *
	 * @access public
	*/
	public function ConnectAll () {
		if (is_null($this->Hostname) === TRUE) {
			array_push($this->ErrorMessage,'ConnectAll: Hostname Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($this->Hostname) === TRUE) {
			array_push($this->ErrorMessage,'ConnectAll: Hostname Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($this->Hostname) === TRUE) {
			array_push($this->ErrorMessage,'ConnectAll: Hostname Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}

		if (is_resource($this->Hostname) === TRUE) {
			array_push($this->ErrorMessage,'ConnectAll: Hostname Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_null($this->User) === TRUE) {
			array_push($this->ErrorMessage,'ConnectAll: User Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($this->User) === TRUE) {
			array_push($this->ErrorMessage,'ConnectAll: User Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($this->User) === TRUE) {
			array_push($this->ErrorMessage,'ConnectAll: User Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($this->User) === TRUE) {
			array_push($this->ErrorMessage,'ConnectAll: User Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}

		if (is_null($this->Password) === TRUE) {
			array_push($this->ErrorMessage,'ConnectAll: Password Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($this->Password) === TRUE) {
			array_push($this->ErrorMessage,'ConnectAll: Password Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($this->Password) === TRUE) {
			array_push($this->ErrorMessage,'ConnectAll: Password Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($this->Password) === TRUE) {
			array_push($this->ErrorMessage,'ConnectAll: Password Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}

		if (is_null($this->DatabaseName) === TRUE) {
			array_push($this->ErrorMessage,'ConnectAll: DatabaseName Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($this->DatabaseName) === TRUE) {
			array_push($this->ErrorMessage,'ConnectAll: DatabaseName Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($this->DatabaseName) === TRUE) {
			array_push($this->ErrorMessage,'ConnectAll: DatabaseName Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($this->DatabaseName) === TRUE) {
			array_push($this->ErrorMessage,'ConnectAll: DatabaseName Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
			
		try {
			if (empty($this->DatabaseTable) === FALSE) {
				if ($this->LayerModuleOn === TRUE) {
					if ($this->LayerModule != NULL) {
						$Return = $this->LayerModule->ConnectAll();
						
						$LayerModuleType = get_class($this->LayerModule);
						
						if ($Return != NULL) {
							if (is_object($Return) === FALSE) {
								return $Return;
							} else {
								if (get_class($Return) !== $LayerModuleType) {
									return $Return;
								}
							}
						}
					} else {
						array_push($this->ErrorMessage,'ConnectAll: LayerModule Cannot Be Null!');
						$BackTrace = debug_backtrace(FALSE);
						return FALSE;
					}
				} else {
					if ($this->Client != NULL) {
						$Return = $this->Client->ConnectAll();
						
						if ($Return != NULL) {
							return $Return;
						} else {
							return NULL;
						}
					} else {
						array_push($this->ErrorMessage,'ConnectAll: Client Cannot Be Null!');
						$BackTrace = debug_backtrace(FALSE);
						return FALSE;
					}
				}
			} else {
				array_push($this->ErrorMessage,'ConnectAll: $this->DatabaseTable Is An Array But Is Empty!');
				$BackTrace = debug_backtrace(FALSE);
				return FALSE;
			}
			
		} catch (Exception $e) {
			array_push($this->ErrorMessage,'ConnectAll: Exception Thrown - Message: ' . $e->getMessage() . '!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
	
		return $this;
	}
	
	// TIERS NEED
	/**
	 * Connect
	 *
	 * Connect to a database table
	 *
	 * @param string $DatabaseTable the name of the database table to connect to
	 * @access public
	 */
	public function Connect ($Key) {
		if (is_null($this->Hostname) === TRUE) {
			array_push($this->ErrorMessage,'Connect: Hostname Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($this->Hostname) === TRUE) {
			array_push($this->ErrorMessage,'Connect: Hostname Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($this->Hostname) === TRUE) {
			array_push($this->ErrorMessage,'Connect: Hostname Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}

		if (is_resource($this->Hostname) === TRUE) {
			array_push($this->ErrorMessage,'Connect: Hostname Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_null($this->User) === TRUE) {
			array_push($this->ErrorMessage,'Connect: User Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($this->User) === TRUE) {
			array_push($this->ErrorMessage,'Connect: User Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($this->User) === TRUE) {
			array_push($this->ErrorMessage,'Connect: User Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($this->User) === TRUE) {
			array_push($this->ErrorMessage,'Connect: User Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}

		if (is_null($this->Password) === TRUE) {
			array_push($this->ErrorMessage,'Connect: Password Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($this->Password) === TRUE) {
			array_push($this->ErrorMessage,'Connect: Password Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($this->Password) === TRUE) {
			array_push($this->ErrorMessage,'Connect: Password Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($this->Password) === TRUE) {
			array_push($this->ErrorMessage,'Connect: Password Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}

		if (is_null($this->DatabaseName) === TRUE) {
			array_push($this->ErrorMessage,'Connect: DatabaseName Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($this->DatabaseName) === TRUE) {
			array_push($this->ErrorMessage,'Connect: DatabaseName Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($this->DatabaseName) === TRUE) {
			array_push($this->ErrorMessage,'Connect: DatabaseName Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($this->DatabaseName) === TRUE) {
			array_push($this->ErrorMessage,'Connect: DatabaseName Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_null($Key) === TRUE) {
			array_push($this->ErrorMessage,'Connect: Key Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($Key) === TRUE) {
			array_push($this->ErrorMessage,'Connect: Key Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($Key) === TRUE) {
			array_push($this->ErrorMessage,'Connect: Key Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}

		if (is_resource($Key) === TRUE) {
			array_push($this->ErrorMessage,'Connect: Key Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		try {
			if ($this->LayerModuleOn === TRUE) {
				if ($this->LayerModule != NULL) {
					$Return = $this->LayerModule->Connect($Key);
					
					$LayerModuleType = get_class($this->LayerModule);
						
					if ($Return != NULL) {
						if (is_object($Return) === FALSE) {
							return $Return;
						} else {
							if (get_class($Return) !== $LayerModuleType) {
								return $Return;
							}
						}
					}
				 } else {
					array_push($this->ErrorMessage,'Connect: LayerModule Cannot Be Null!');
					$BackTrace = debug_backtrace(FALSE);
					return FALSE;
				}
			} else {
				if ($this->Client != NULL) {
					$Return = $this->Client->Connect($Key);
					
					if ($Return === FALSE) {
						return FALSE;
					} else if ($Return != NULL) {
						return $Return;
					}  else {
						return NULL;
					}
				} else {
					array_push($this->ErrorMessage,'Connect: Client Cannot Be Null!');
					$BackTrace = debug_backtrace(FALSE);
					return FALSE;
				}
			}
		} catch (Exception $E) {
			array_push($this->ErrorMessage,'Connect: Exception Thrown - Message: ' . $E->getMessage() . '!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		} 
		
		return $this;
	}
	
	// TIERS NEED
	/**
	 * DiscconnectAll
	 *
	 * Disconnects from all databases
	 *
	 * @access public
	 */
	 public function DisconnectAll () {
		if ($this->LayerModuleOn === TRUE) {
			if ($this->LayerModule != NULL) {
				try {
					$Return = $this->LayerModule->DisconnectAll();
					
					$LayerModuleType = get_class($this->LayerModule);
					
					if ($Return != TRUE) {
						array_push($this->ErrorMessage,'DisconnectAll: Could Not Disconnect From Database!');
						$BackTrace = debug_backtrace(FALSE);
						return FALSE;
					} else {
						if ($Return != NULL) {
							if (is_object($Return) === FALSE) {
								return $Return;
							} else {
								if (get_class($Return) !== $LayerModuleType) {
									return $Return;
								}
							}
						}
					}
				} catch (SoapFault $E) {
					array_push($this->ErrorMessage,'DisconnectAll: Could Not Disconnect From Database!');
					$BackTrace = debug_backtrace(FALSE);
					return FALSE;
				}
			} else {
				array_push($this->ErrorMessage,'DisconnectAll: LayerModule Cannot Be Null!');
				$BackTrace = debug_backtrace(FALSE);
				return FALSE;
			}
		} else {
			if ($this->Client != NULL) {
				try {
					$Return = $this->Client->DisconnectAll();
					
					if ($Return != TRUE) {
						array_push($this->ErrorMessage,'DisconnectAll: Could Not Disconnect From Database!');
						$BackTrace = debug_backtrace(FALSE);
						return FALSE;
					} else {
						if ($Return != NULL) {
							return $Return;
						} else {
							return NULL;
						}
					}
				} catch (SoapFault $E) {
					array_push($this->ErrorMessage,'DisconnectAll: Could Not Disconnect From Database!');
					$BackTrace = debug_backtrace(FALSE);
					return FALSE;
				}
			} else {
				array_push($this->ErrorMessage,'DisconnectAll: Client Cannot Be Null!');
				$BackTrace = debug_backtrace(FALSE);
				return FALSE;
			}
		}
		return $this;
	}
	
	 // TIERS NEED
	 /**
	 * Disconnect
	 *
	 * Disconnection from a database table
	 *
	 * @param string $DatabaseTable the name of the database table to disconnect from
	 * @access public
	*/
	public function Disconnect ($Key) {
		if (is_null($Key) === TRUE) {
			array_push($this->ErrorMessage,'Disconnect: Key Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($Key) === TRUE) {
			array_push($this->ErrorMessage,'Disconnect: Key Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($Key) === TRUE) {
			array_push($this->ErrorMessage,'Disconnect: Key Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}

		if (is_resource($Key) === TRUE) {
			array_push($this->ErrorMessage,'Disconnect: Key Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		$Return = NULL;
		
		if ($this->LayerModuleOn === TRUE) {
			if ($this->LayerModule != NULL) {
				try {
					$Return = $this->LayerModule->Disconnect($Key);
					
					$LayerModuleType = get_class($this->LayerModule);
					
					if ($Return != TRUE) {
						array_push($this->ErrorMessage,'Disconnect: Could Not Disconnect From Database!');
						$BackTrace = debug_backtrace(FALSE);
						return FALSE;
					} else {
						if ($Return != NULL) {
							if (is_object($Return) === FALSE) {
								return $Return;
							} else {
								if (get_class($Return) !== $LayerModuleType) {
									return $Return;
								}
							}
						}
					}
				} catch (SoapFault $E) {
					array_push($this->ErrorMessage,'Disconnect: Could Not Disconnect From Database!');
					$BackTrace = debug_backtrace(FALSE);
					return FALSE;
				}
			} else {
				array_push($this->ErrorMessage,'Disconnect: LayerModule Cannot Be Null!');
				$BackTrace = debug_backtrace(FALSE);
				return FALSE;
			}
		} else {
			if ($this->Client != NULL) {
				try {
					$Return = $this->Client->Disconnect($Key);
					
					if ($Return != TRUE) {
						array_push($this->ErrorMessage,'Disconnect: Could Not Disconnect From Database!');
						$BackTrace = debug_backtrace(FALSE);
						return FALSE;
					} else {
						if ($Return != NULL) {
							return $Return;
						} else {
							return NULL;
						}
					}
				} catch (SoapFault $E) {
					array_push($this->ErrorMessage,'Disconnect: Could Not Disconnect From Database!');
					$BackTrace = debug_backtrace(FALSE);
					return FALSE;
				}
			} else {
				array_push($this->ErrorMessage,'Disconnect: Client Cannot Be Null!');
				$BackTrace = debug_backtrace(FALSE);
				return FALSE;
			}
		}
		
		return $this;
	}
	
	// TIERS NEED
	/**
	 * createDatabaseTable
	 *
	 * Creates a connection for a database table
	 *
	 * @param string $DatabaseTable the name of the database table to create a connection to
	 * @access public
	 */
	 public function createDatabaseTable($DatabaseTableName) {
		if (is_null($DatabaseTableName) === TRUE) {
			array_push($this->ErrorMessage,'createDatabaseTable: DatabaseTableName Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($DatabaseTableName) === TRUE) {
			array_push($this->ErrorMessage,'createDatabaseTable: DatabaseTableName Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($DatabaseTableName) === TRUE) {
			array_push($this->ErrorMessage,'createDatabaseTable: DatabaseTableName Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($DatabaseTableName) === TRUE) {
			array_push($this->ErrorMessage,'createDatabaseTable: DatabaseTableName Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if ($this->LayerModuleOn === TRUE) {
			if ($this->LayerModule != NULL) {
				try {
					$Return = $this->setDatabasetable($DatabaseTableName);
					
					$LayerModuleType = get_class($this->LayerModule);
					
					if ($Return != NULL) {
						if (is_object($Return) === FALSE) {
							return $Return;
						} else {
							if (get_class($Return) !== $LayerModuleType) {
								return $Return;
							}
						}
					}
					
					$Return = $this->LayerModule->createDatabaseTable($DatabaseTableName);
					
					if ($Return != NULL) {
						if (is_object($Return) === FALSE) {
							return $Return;
						} else {
							if (get_class($Return) !== $LayerModuleType) {
								return $Return;
							}
						}
					}
				} catch (SoapFault $E) {
					$BackTrace = debug_backtrace(FALSE);
					throw new SoapFault("createDatabaseTable", $E->getMessage());
				}
			} else {
				array_push($this->ErrorMessage,'createDatabaseTable: LayerModule Cannot Be Null!');
				$BackTrace = debug_backtrace(FALSE);
				return FALSE;
			}
		} else {
			if ($this->Client != NULL) {
				try {
					$Return = $this->setDatabasetable($DatabaseTableName);
					
					if ($Return === FALSE) {
						return $Return;
					}
					
					$Return = $this->Client->createDatabaseTable($DatabaseTableName);
					
					if ($Return != NULL) {
						return $Return;
					} else {
						return NULL;
					}
				} catch (SoapFault $E) {
					$BackTrace = debug_backtrace(FALSE);
					throw new SoapFault("createDatabaseTable", $E->getMessage());
				}
			} else {
				array_push($this->ErrorMessage,'createDatabaseTable: Client Cannot Be Null!');
				$BackTrace = debug_backtrace(FALSE);
				return FALSE;
			}
		}
		return $this;
	}
	
	// TIERS NEED
	/**
	 * destroyDatabaseTable
	 *
	 * Destroys a database table object
	 *
	 * @param string $DatabaseTableName the name of the database table to destroy
	 * @access public
	 */
	public function destroyDatabaseTable($DatabaseTableName) {
		if (is_null($DatabaseTableName) === TRUE) {
			array_push($this->ErrorMessage,'destroyDatabaseTable: DatabaseTableName Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($DatabaseTableName) === TRUE) {
			array_push($this->ErrorMessage,'destroyDatabaseTable: DatabaseTableName Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($DatabaseTableName) === TRUE) {
			array_push($this->ErrorMessage,'destroyDatabaseTable: DatabaseTableName Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($DatabaseTableName) === TRUE) {
			array_push($this->ErrorMessage,'destroyDatabaseTable: DatabaseTableName Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if ($this->LayerModuleOn === TRUE) {
			if ($this->LayerModule != NULL) {
				try {
					$Return = $this->LayerModule->destroyDatabaseTable($DatabaseTableName);
					
					$LayerModuleType = get_class($this->LayerModule);
					
					if ($Return === FALSE) {
						return FALSE;
					} else {
						$LayerModuleType = get_class($this->LayerModule);
						if ($Return != NULL) {
							if (is_object($Return) === FALSE) {
								return $Return;
							} else {
								if (get_class($Return) !== $LayerModuleType) {
									return $Return;
								}
							}
						}
						return $this;
					}
				} catch (SoapFault $E) {
					$BackTrace = debug_backtrace(FALSE);
					throw new SoapFault("destroyDatabaseTable", $E->getMessage());
				}
			} else {
				array_push($this->ErrorMessage,'destroyDatabaseTable: LayerModule Cannot Be Null!');
				$BackTrace = debug_backtrace(FALSE);
				return FALSE;
			}
		} else {
			if ($this->Client != NULL) {
				try {
					$Return = $this->Client->destroyDatabaseTable($DatabaseTableName);
					
					if ($Return === FALSE) {
						return FALSE;
					} else if ($Return != NULL) {
						return $Return;
					} else {
						return NULL;
					}
				} catch (SoapFault $E) {
					$BackTrace = debug_backtrace(FALSE);
					throw new SoapFault("destroyDatabaseTable", $E->getMessage());
				}
			} else {
				array_push($this->ErrorMessage,'destroyDatabaseTable: Client Cannot Be Null!');
				$BackTrace = debug_backtrace(FALSE);
				return FALSE;
			}
		}
	}
	
	/*
	public function FetchDatabase ($idnumber) {

	}
	public function CreateOutput($space) {

	}
	public function getOutput() {

	}*/

	public function buildModules($LayerModuleTableName, $LayerTableName, $LayerModuleTableNameSetting) {
		if ($this->SessionName) {
			reset($this->SessionName);
			$passarray = array();
			$passarray['SessionName'] = key($this->SessionName);
			
			/*try {
				$this->LayerModule->createDatabaseTable('Sessions');
			} catch (SoapFault $E) {
			
			}*/

			//reset($this->Layers);
			//while (current($this->Layers)) {
				//$this->Layers[key($this->Layers)]->createDatabaseTable('Sessions');
				//next($this->Layers);
			//}

			if ($this->LayerModuleOn === TRUE) {
				try {
					$this->LayerModule->createDatabaseTable('Sessions');
				} catch (SoapFault $E) {
				
				}

				$this->LayerModule->Connect('Sessions');
				$this->LayerModule->pass ('Sessions', 'setDatabaseRow', array('idnumber' => $passarray));
				$this->LayerModule->Disconnect('Sessions');

				$this->SessionTypeName = $this->LayerModule->pass ('Sessions', 'getMultiRowField', array());
				$this->SessionTypeName = $this->SessionTypeName[0];
			} else {
				try {
					$this->Client->createDatabaseTable('Sessions');
				} catch (SoapFault $E) {
				
				}

				$this->Client->Connect('Sessions');
				$this->Client->pass ('Sessions', 'setDatabaseRow', array('idnumber' => $passarray));
				$this->Client->Disconnect('Sessions');

				$this->SessionTypeName = $this->Client->pass ('Sessions', 'getMultiRowField', array());
				$this->SessionTypeName = $this->SessionTypeName[0];
			}

		}
		
		$this->LayerModuleTableNameSetting = $LayerModuleTableNameSetting;
		$this->LayerModuleTableName = $LayerModuleTableName;
		$this->LayerTableName = $LayerTableName;

		$this->createDatabaseTable($this->LayerModuleTableNameSetting);
		$this->createDatabaseTable($this->LayerModuleTableName);
		$this->createDatabaseTable($this->LayerTableName);
		
		if ($this->LayerModuleOn === TRUE) {
			try {
				$this->LayerModule->createDatabaseTable($this->LayerModuleTableNameSetting);
				$this->LayerModule->createDatabaseTable($this->LayerModuleTableName);
				$this->LayerModule->createDatabaseTable($this->LayerTableName);
			} catch (SoapFault $E) {
				
			}
		} else {
			try {
				$this->Client->createDatabaseTable($this->LayerModuleTableNameSetting);
				$this->Client->createDatabaseTable($this->LayerModuleTableName);
				$this->Client->createDatabaseTable($this->LayerTableName);
			} catch (SoapFault $E) {
				
			}
		}

		$passarray = array();
		$passarray['Enable/Disable'] = 'Enable';

		if ($this->LayerModuleOn === TRUE) {
			$this->LayerModule->Connect($this->LayerModuleTableName);
			$this->LayerModule->pass ($this->LayerModuleTableName, 'setDatabaseRow', array('idnumber' => $passarray));
			$this->LayerModule->Disconnect($this->LayerModuleTableName);

			$LayerModuleTable = $this->LayerModule->pass ($this->LayerModuleTableName, 'getMultiRowField', array());
		} else {
			$Return = $this->Client->Connect($this->LayerModuleTableName);
			$Return = $this->Client->pass ($this->LayerModuleTableName, 'setDatabaseRow', array('idnumber' => $passarray));
			$Return = $this->Client->Disconnect($this->LayerModuleTableName);
			
			$LayerModuleTable = $this->Client->pass ($this->LayerModuleTableName, 'getMultiRowField', array());
		}


		if ($this->LayerModuleOn === TRUE) {
			$this->LayerModule->Connect($this->LayerTableName);
			$this->LayerModule->pass ($this->LayerTableName, 'setEntireTable', array());
			$this->LayerModule->Disconnect($this->LayerTableName);

			$this->LayerTable = $this->LayerModule->pass ($this->LayerTableName, 'getEntireTable', array());
		} else {
			$this->Client->Connect($this->LayerTableName);
			$this->Client->pass ($this->LayerTableName, 'setEntireTable', array());
			$this->Client->Disconnect($this->LayerTableName);

			$this->LayerTable = $this->Client->pass ($this->LayerTableName, 'getEntireTable', array());
		}

		if ($this->LayerModuleOn === TRUE) {
			$this->LayerModule->Connect($this->LayerModuleTableNameSetting);
			$this->LayerModule->pass ($this->LayerModuleTableNameSetting, 'setEntireTable', array());
			$this->LayerModule->Disconnect($this->LayerModuleTableNameSetting);

			$LayerModuleSetting = $this->LayerModule->pass ($this->LayerModuleTableNameSetting, 'getEntireTable', array());
		} else {
			$this->Client->Connect($this->LayerModuleTableNameSetting);
			$this->Client->pass ($this->LayerModuleTableNameSetting, 'setEntireTable', array());
			$this->Client->Disconnect($this->LayerModuleTableNameSetting);

			$LayerModuleSetting = $this->Client->pass ($this->LayerModuleTableNameSetting, 'getEntireTable', array());
		}

		$ModuleSetting = array();
		$InnerKey = array();
		$InnerKey['ObjectTypeName'] = 'ObjectTypeName';
		$InnerKey['Setting'] = 'Setting';
		$this->LayerModuleSetting = $this->buildArray($ModuleSetting, $InnerKey, 'ObjectType', $LayerModuleSetting);
		$this->LayerModuleTable = array();
		
		if ($LayerModuleTableName && $LayerModuleTable && $LayerTableName && $this->LayerTable) {
			if (is_array($this->LayerTable)) {
				foreach ($LayerModuleTable as $ModuleTableKey => $ModuleTable) {
					$ObjectType = $ModuleTable['ObjectType'];
					$ObjectTypeName = $ModuleTable['ObjectTypeName'];
					$ObjectTypeLocation = $ModuleTable['ObjectTypeLocation'];
					$ObjectTypeConfiguration = $ModuleTable['ObjectTypeConfiguration'];
					$ObjectTypePrintPreview = $ModuleTable['ObjectTypePrintPreview'];
					
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
										$BackTrace = debug_backtrace(FALSE);
										array_push($this->ErrorMessage,"buildModules: Module filename - $ModulesFile does not exist!");
									}
									
									$this->LayerModuleTable[$ObjectType][$ObjectTypeName][$ModuleFileNameKey] = $ModulesFile;
								}
							}
						}
						
						$this->LayerModuleTable[$ObjectType][$ObjectTypeName]['ObjectTypeLocation'] = $ObjectTypeLocation;
						$this->LayerModuleTable[$ObjectType][$ObjectTypeName]['ObjectTypeConfiguration'] = $ObjectTypeConfiguration;
						$this->LayerModuleTable[$ObjectType][$ObjectTypeName]['ObjectTypePrintPreview'] = $ObjectTypePrintPreview;
						$this->LayerModuleTable[$ObjectType][$ObjectTypeName]['Enable/Disable'] = $EnableDisable;					
						
						$DatabaseTables = NULL;
						foreach ($this->LayerTable as $Table) {
							if ($Table['ObjectType'] == $ObjectType & $Table['ObjectTypeName'] == $ObjectTypeName) {
								$DatabaseTables = $Table;
								break;
							}
						}
						
						$DatabaseTableArray = array();
						if (is_array($DatabaseTables)) {
							foreach ($DatabaseTables as $DatabaseTablesKey => $DatabaseTableValue) {
								if (strstr($DatabaseTablesKey, 'DatabaseTable')) {
									$DatabaseTableArray[$DatabaseTablesKey] = $DatabaseTableValue;
									if (!empty($DatabaseTableValue)) {
										try {
											$this->createDatabaseTable($DatabaseTableValue);
										} catch (SoapFault $E) {
											
										}
										if ($this->SessionTypeName['SessionTypeName'] == $ObjectTypeName) {
											$DatabaseOptionsName = $ObjectType;
											$DatabaseOptionsName .= 'Session';
		
											$DatabaseOptions[$DatabaseOptionsName] = $_SESSION['POST'][$this->SessionTypeName['SessionValue']];
										}
										
									}
									
								}
							}

							if ($this->LayerModuleSetting[$ObjectType][$ObjectTypeName]) {
								if (is_array($this->LayerModuleSetting[$ObjectType][$ObjectTypeName])) {
									foreach ($this->LayerModuleSetting[$ObjectType][$ObjectTypeName] as $Key => $Value) {
										$Setting = $Value['Setting'];
										$SettingAttribute = $Value['SettingAttribute'];
										$DatabaseOptions[$Setting] = $SettingAttribute;
									}
								}
							}

							$this->createModules($ObjectType, $ObjectTypeName, $DatabaseTableArray, $DatabaseOptions);
							$DatabaseOptions = array();
							
						}
						
					}
				}
			}
		} else {
			array_push($this->ErrorMessage,'buildModules: Module Tablename is not set!');
			$BackTrace = debug_backtrace(FALSE);
		}
	}

	protected function createModules($ObjectType, $ObjectTypeName, $DatabaseTables, $DatabaseOptions) {
		$this->Modules[$ObjectType][$ObjectTypeName] = new $ObjectType ($DatabaseTables, $DatabaseOptions, $this->LayerModule);
		
		reset($DatabaseTables);
		$this->Modules[$ObjectType][$ObjectTypeName]->setDatabaseAll ($this->Hostname, $this->User, $this->Password, $this->DatabaseName, current($DatabaseTables));

	}

	protected function buildArray($array, $innerkey, $outerkey, $databasetable) {
		if (is_array($array)) {
			$numargs = func_num_args();
			$numerical = NULL;
			if ($numargs == 5) {
				$args = func_get_args();
				$numberical = $args[4];
			}

			if ($numberical == 'Numerical') {
				$i = 1;
				$name = $innerkey;
				$name .= $i;
				$hold = $databasetable[$outerkey][$name];
				while (array_key_exists($name, $databasetable[$outerkey])) {
					$array[$name] = $hold;
					$i++;
					$name = $innerkey;
					$name .= $i;
					$hold = $databasetable[$outerkey][$name];
				}
				reset ($array);

				$temp2 = NULL;
				while (array_key_exists(key($array), $array)) {
					if (!current($array)) {
						$temp = key($array);
						next($array);
						unset($array[$temp]);
					} else {
						next($array);
					}
				}
			} else {
				if (is_array($databasetable)) {
					reset($databasetable);
					if (is_array($innerkey)) {
						while (current($databasetable)) {
							$key1 = $databasetable[key($databasetable)][$outerkey];

							reset($innerkey);
							$key2 = $databasetable[key($databasetable)][current($innerkey)];
							next($innerkey);

							while (current($innerkey)) {
								$key3 = $databasetable[key($databasetable)][current($innerkey)];
								$array[$key1][$key2][$key3] = $databasetable[key($databasetable)];
								next($innerkey);
							}

							next($databasetable);
						}
					} else {
						while (current($databasetable)) {
							$key1 = $databasetable[key($databasetable)][$outerkey];
							$key2 = $databasetable[key($databasetable)][$innerkey];
							$array[$key1][$key2] = $databasetable[key($databasetable)];
							next($databasetable);
						}
					}
				}
			}

			return $array;
		} else {
			return NULL;
		}
	}

	protected function addModuleContent(array $Keys, array $Content, $DatabaseTableName) {
		if ($Keys != NULL && $Content != NULL && $DatabaseTableName) {
			$passarray = array();
			$passarray1 = array();
			$passarray2 = array();
			$i = 0;
			reset($Keys);
			while (current($Keys)) {
				$passarray1[$i] = current($Keys);
				$i++;
				next($Keys);
			}
			$this->LayerModule->Connect($DatabaseTableName);

			if (count($Content) == count($Content, COUNT_RECURSIVE)) {
				$i = 0;
				reset($Content);
				while (key($Content)) {
					$passarray2[$i] = $Content[$passarray1[$i]];
					$i++;
					next($Content);
				}

				$passarray['rowname'] = $passarray1;
				$passarray['rowvalue'] = $passarray2;

				if ($this->LayerModuleOn === TRUE) {
					//$this->LayerModule->Connect($DatabaseTableName);
					$this->LayerModule->pass ($DatabaseTableName, 'createRow', $passarray);
					//$this->LayerModule->Disconnect($DatabaseTableName);
				} else {
					//$this->Client->Connect($DatabaseTableName);
					$this->Client->pass ($DatabaseTableName, 'createRow', $passarray);
					//$this->Client->Disconnect($DatabaseTableName);
				}
			} else {
				$i = 0;

				$count = 0;
				$count2 = count($Content[key($Content)]);

				$passarray = array();
				if (is_array($Content)) {
					foreach ($Content as $Key => $Value) {
						$j = 0;
						$hold = $Value;
						reset($hold);
						while (key($hold)) {
							$passarray2[$j] = current($hold);
							next($hold);
							$j++;
						}
						$passarray['rowname'][] = $passarray1;
						$passarray['rowvalue'][] = $passarray2;
						
						$i++;
					}
					
					if ($this->LayerModuleOn === TRUE) {
						$this->LayerModule->pass ($DatabaseTableName, 'createRow', $passarray);
					} else {
						$this->Client->pass ($DatabaseTableName, 'createRow', $passarray);
					}
				}
				
			}
			if ($this->LayerModuleOn === TRUE) {
				$this->LayerModule->Disconnect($DatabaseTableName);
			} else {
				$this->Client->Disconnect($DatabaseTableName);
			}

			if (in_array('ObjectID', $Keys)) {
				$SortOrder = array();
				$SortOrder['ObjectID'] = 'ObjectID';
				$this->sortTable($SortOrder, $DatabaseTableName);
			}

			if (in_array('RevisionID', $Keys)) {
				$SortOrder = array();
				$SortOrder['RevisionID'] = 'RevisionID';
				$this->sortTable($SortOrder, $DatabaseTableName);
			}

			if (in_array('PageID', $Keys)) {
				$SortOrder = array();
				$SortOrder['PageID'] = 'PageID';
				$this->sortTable($SortOrder, $DatabaseTableName);
			}

			if (in_array('XMLFeedName', $Keys)) {
				$SortOrder = array();
				$SortOrder['XMLFeedName'] = 'XMLFeedName';
				$this->sortTable($SortOrder, $DatabaseTableName);
			}

			if (in_array('XMLItem', $Keys)) {
				$SortOrder = array();
				$SortOrder['XMLItem'] = 'XMLItem';
				$this->sortTable($SortOrder, $DatabaseTableName);
			}

			if (in_array('TableID', $Keys)) {
				$SortOrder = array();
				$SortOrder['TableID'] = 'TableID';
				$this->sortTable($SortOrder, $DatabaseTableName);
			}

		} else {
			array_push($this->ErrorMessage,'addModuleContent: Keys, Content or Database Table Name cannot be NULL!');
		}
	}

	protected function updateModuleContent(array $PageID, $DatabaseTableName) {
		$arguments = func_get_args();
		$Data = $arguments[2];
		if ($PageID != NULL && $DatabaseTableName != NULL) {
			$passarray = array();
			$passarray1 = array();
			$passarray2 = array();
			$passarray3 = array();
			$passarray4 = array();
			if ($Data != NULL) {
				$passarray1 = array_keys($Data);
				$passarray2 = array_values($Data);

				$i = 0;
				foreach ($Data as $Key => $Value) {
					$passarray3[$i] = array_keys($PageID);
					$passarray4[$i] = array_values($PageID);

					$i++;
				}
			} else {
				if ($PageID['PageID']) {
					$passarray1[0] = 'CurrentVersion';
					$passarray2[0] = 'false';
				}

				if ($PageID['XMLItem']) {
					$passarray1[0][0] = 'XMLItem';
					$passarray2[0][0] = $PageID['XMLItem'];

					if ($PageID['FeedItemTitle']) {
						$passarray1[0] = 'FeedItemTitle';
						$passarray2[0] = $PageID['FeedItemTitle'];
					}

					if ($PageID['FeedItemDescription']) {
						$passarray1[1] = 'FeedItemDescription';
						$passarray2[1] = $PageID['FeedItemDescription'];
					}

					if ($PageID['FeedItemAuthor']) {
						$passarray1[2] = 'FeedItemAuthor';
						$passarray2[2] = $PageID['FeedItemAuthor'];
					}

					if ($PageID['FeedItemCategory']) {
						$passarray1[3] = 'FeedItemCategory';
						$passarray2[3] = $PageID['FeedItemCategory'];
					}

					if ($PageID['FeedItemGuid']) {
						$passarray1[4] = 'FeedItemGuid';
						$passarray2[4] = $PageID['FeedItemGuid'];
					}

					if ($PageID['FeedItemPubDate']) {
						$passarray1[5] = 'FeedItemPubDate';
						$passarray2[5] = $PageID['FeedItemPubDate'];
					}
				}

				if ($PageID['PageID']) {
					$passarray3[0][0] = 'PageID';
					$passarray4[0][0] = $PageID['PageID'];

					$passarray3[0][1] = 'CurrentVersion';
					$passarray4[0][1] = 'true';

				}

				if ($PageID['XMLItem']) {
					$passarray3[0] = 'XMLItem';
					$passarray4[0] = $PageID['XMLItem'];

					$passarray3[1] = 'XMLItem';
					$passarray4[1] = $PageID['XMLItem'];

					$passarray3[2] = 'XMLItem';
					$passarray4[2] = $PageID['XMLItem'];

					$passarray3[3] = 'XMLItem';
					$passarray4[3] = $PageID['XMLItem'];

					$passarray3[4] = 'XMLItem';
					$passarray4[4] = $PageID['XMLItem'];

					$passarray3[5] = 'XMLItem';
					$passarray4[5] = $PageID['XMLItem'];
				}
			}

			$passarray['rowname'] = $passarray1;
			$passarray['rowvalue'] = $passarray2;
			$passarray['rownumbername'] = $passarray3;
			$passarray['rownumber'] = $passarray4;

			if ($this->LayerModuleOn === TRUE) {
				$this->LayerModule->Connect($DatabaseTableName);
				$this->LayerModule->pass ($DatabaseTableName, 'updateRow', $passarray);
				$this->LayerModule->Disconnect($DatabaseTableName);
			} else {
				$this->Client->Connect($DatabaseTableName);
				$this->Client->pass ($DatabaseTableName, 'updateRow', $passarray);
				$this->Client->Disconnect($DatabaseTableName);
			}

		} else {
			array_push($this->ErrorMessage,'updateModuleContent: PageID and DatabaseTableName cannot be NULL!');
			$BackTrace = debug_backtrace(FALSE);
		}
	}

	protected function deleteModuleContent(array $PageID, $DatabaseTableName) {
		if ($PageID != NULL && $DatabaseTableName != NULL) {
			$passarray = array();
			$passarray1 = array();
			$passarray2 = array();
			$passarray3 = array();
			$passarray4 = array();

			$passarray1[0] = 'Enable/Disable';

			$passarray2[0] = 'Disable';

			if ($PageID['PageID']) {
				$passarray3[0][0] = 'PageID';

				$passarray4[0][0] = $PageID['PageID'];
			} else if ($PageID['XMLItem']) {
				$passarray3[0][0] = 'XMLItem';

				$passarray4[0][0] = $PageID['XMLItem'];
			}

			if ($PageID['ObjectID']) {
				$passarray3[0][1] = 'ObjectID';
				$passarray4[0][1] = $PageID['ObjectID'];
			}

			if ($PageID['XhtmlTableName']) {
				$passarray3[0][1] = 'XhtmlTableName';

				$passarray4[0][1] = $PageID['XhtmlTableName'];
			}

			if ($PageID['XhtmlTableID']) {
				$passarray3[0][1] = 'XhtmlTableID';

				$passarray4[0][1] = $PageID['XhtmlTableID'];
			}

			$passarray['rowname'] = $passarray1;
			$passarray['rowvalue'] = $passarray2;
			$passarray['rownumbername'] = $passarray3;
			$passarray['rownumber'] = $passarray4;

			if ($this->LayerModuleOn === TRUE) {
				$this->LayerModule->Connect($DatabaseTableName);
				$this->LayerModule->pass ($DatabaseTableName, 'updateRow', $passarray);
				$this->LayerModule->Disconnect($DatabaseTableName);
			} else {
				$this->Client->Connect($DatabaseTableName);
				$this->Client->pass ($DatabaseTableName, 'updateRow', $passarray);
				$this->Client->Disconnect($DatabaseTableName);
			}
		} else {
			array_push($this->ErrorMessage,'deleteModuleContent: PageID and DatabaseTableName cannot be NULL!');
			$BackTrace = debug_backtrace(FALSE);
		}
	}

	protected function enableModuleContent(array $PageID, $DatabaseTableName) {
		if ($PageID != NULL && $DatabaseTableName != NULL) {
			$passarray = array();
			$passarray1 = array();
			$passarray2 = array();
			$passarray3 = array();
			$passarray4 = array();

			$passarray1[0] = 'Enable/Disable';
			$passarray2[0] = 'Enable';
			if ($PageID['PageID']) {
				$passarray3[0][0] = 'PageID';
				$passarray4[0][0] = $PageID['PageID'];
			} else if ($PageID['XMLItem']) {
				$passarray3[0][0] = 'XMLItem';

				$passarray4[0][0] = $PageID['XMLItem'];
			}

			if ($PageID['ObjectID']) {
				$passarray3[0][1] = 'ObjectID';
				$passarray4[0][1] = $PageID['ObjectID'];
			}

			if ($PageID['XhtmlTableName']) {
				$passarray3[0][2] = 'XhtmlTableName';

				$passarray4[0][2] = $PageID['XhtmlTableName'];
			}

			if ($PageID['XhtmlTableID']) {
				$passarray3[0][3] = 'XhtmlTableID';

				$passarray4[0][3] = $PageID['XhtmlTableID'];
			}

			$passarray['rowname'] = $passarray1;
			$passarray['rowvalue'] = $passarray2;
			$passarray['rownumbername'] = $passarray3;
			$passarray['rownumber'] = $passarray4;

			if ($this->LayerModuleOn === TRUE) {
				$this->LayerModule->Connect($DatabaseTableName);
				$this->LayerModule->pass ($DatabaseTableName, 'updateRow', $passarray);
				$this->LayerModule->Disconnect($DatabaseTableName);
			} else {
				$this->Client->Connect($DatabaseTableName);
				$this->Client->pass ($DatabaseTableName, 'updateRow', $passarray);
				$this->Client->Disconnect($DatabaseTableName);
			}
		} else {
			array_push($this->ErrorMessage,'enableModuleContent: PageID and DatabaseTableName cannot be NULL!');
			$BackTrace = debug_backtrace(FALSE);
		}
	}

	protected function disableModuleContent(array $PageID, $DatabaseTableName) {
		if ($PageID != NULL && $DatabaseTableName != NULL) {
			$passarray = array();
			$passarray1 = array();
			$passarray2 = array();
			$passarray3 = array();
			$passarray4 = array();

			$passarray1[0] = 'Enable/Disable';

			$passarray2[0] = 'Disable';

			if ($PageID['PageID']) {
				$passarray3[0][0] = 'PageID';

				$passarray4[0][0] = $PageID['PageID'];
			} else if ($PageID['XMLItem']) {
				$passarray3[0][0] = 'XMLItem';

				$passarray4[0][0] = $PageID['XMLItem'];
			}

			if ($PageID['ObjectID']) {
				$passarray3[0][1] = 'ObjectID';
				$passarray4[0][1] = $PageID['ObjectID'];
			}

			if ($PageID['XhtmlTableName']) {
				$passarray3[0][2] = 'XhtmlTableName';

				$passarray4[0][2] = $PageID['XhtmlTableName'];
			}

			if ($PageID['XhtmlTableID']) {
				$passarray3[0][3] = 'XhtmlTableID';

				$passarray4[0][3] = $PageID['XhtmlTableID'];
			}

			$passarray['rowname'] = $passarray1;
			$passarray['rowvalue'] = $passarray2;
			$passarray['rownumbername'] = $passarray3;
			$passarray['rownumber'] = $passarray4;

			if ($this->LayerModuleOn === TRUE) {
				$this->LayerModule->Connect($DatabaseTableName);
				$this->LayerModule->pass ($DatabaseTableName, 'updateRow', $passarray);
				$this->LayerModule->Disconnect($DatabaseTableName);
			} else {
				$this->Client->Connect($DatabaseTableName);
				$this->Client->pass ($DatabaseTableName, 'updateRow', $passarray);
				$this->Client->Disconnect($DatabaseTableName);
			}
		} else {
			array_push($this->ErrorMessage,'disableModuleContent: PageID and DatabaseTableName cannot be NULL!');
			$BackTrace = debug_backtrace(FALSE);
		}
	}

	protected function approvedModuleContent(array $PageID, $DatabaseTableName) {
		if ($PageID != NULL && $DatabaseTableName != NULL) {
			$passarray = array();
			$passarray1 = array();
			$passarray2 = array();
			$passarray3 = array();
			$passarray4 = array();

			$passarray1[0] = 'Status';

			$passarray2[0] = 'Approved';

			if ($PageID['PageID']) {
				$passarray3[0][0] = 'PageID';

				$passarray4[0][0] = $PageID['PageID'];
			} else if ($PageID['XMLItem']) {
				$passarray3[0][0] = 'XMLItem';

				$passarray4[0][0] = $PageID['XMLItem'];
			}

			if ($PageID['ObjectID']) {
				$passarray3[0][1] = 'ObjectID';
				$passarray4[0][1] = $PageID['ObjectID'];
			}

			if ($PageID['XhtmlTableName']) {
				$passarray3[0][2] = 'XhtmlTableName';

				$passarray4[0][2] = $PageID['XhtmlTableName'];
			}

			if ($PageID['XhtmlTableID']) {
				$passarray3[0][3] = 'XhtmlTableID';

				$passarray4[0][3] = $PageID['XhtmlTableID'];
			}

			$passarray['rowname'] = $passarray1;
			$passarray['rowvalue'] = $passarray2;
			$passarray['rownumbername'] = $passarray3;
			$passarray['rownumber'] = $passarray4;

			if ($this->LayerModuleOn === TRUE) {
				$this->LayerModule->Connect($DatabaseTableName);
				$this->LayerModule->pass ($DatabaseTableName, 'updateRow', $passarray);
				$this->LayerModule->Disconnect($DatabaseTableName);
			} else {
				$this->Client->Connect($DatabaseTableName);
				$this->Client->pass ($DatabaseTableName, 'updateRow', $passarray);
				$this->Client->Disconnect($DatabaseTableName);
			}
		} else {
			array_push($this->ErrorMessage,'approvedModuleContent: PageID and DatabaseTableName cannot be NULL!');
			$BackTrace = debug_backtrace(FALSE);
		}
	}

	protected function notApprovedModuleContent(array $PageID, $DatabaseTableName) {
		if ($PageID != NULL && $DatabaseTableName != NULL) {
			$passarray = array();
			$passarray1 = array();
			$passarray2 = array();
			$passarray3 = array();
			$passarray4 = array();

			$passarray1[0] = 'Status';

			$passarray2[0] = 'Not-Approved';

			if ($PageID['PageID']) {
				$passarray3[0][0] = 'PageID';

				$passarray4[0][0] = $PageID['PageID'];
			} else if ($PageID['XMLItem']) {
				$passarray3[0][0] = 'XMLItem';

				$passarray4[0][0] = $PageID['XMLItem'];
			}

			if ($PageID['ObjectID']) {
				$passarray3[0][1] = 'ObjectID';
				$passarray4[0][1] = $PageID['ObjectID'];
			}

			if ($PageID['XhtmlTableName']) {
				$passarray3[0][2] = 'XhtmlTableName';

				$passarray4[0][2] = $PageID['XhtmlTableName'];
			}

			if ($PageID['XhtmlTableID']) {
				$passarray3[0][3] = 'XhtmlTableID';

				$passarray4[0][3] = $PageID['XhtmlTableID'];
			}

			$passarray['rowname'] = $passarray1;
			$passarray['rowvalue'] = $passarray2;
			$passarray['rownumbername'] = $passarray3;
			$passarray['rownumber'] = $passarray4;
			if ($this->LayerModuleOn === TRUE) {
				$this->LayerModule->Connect($DatabaseTableName);
				$this->LayerModule->pass ($DatabaseTableName, 'updateRow', $passarray);
				$this->LayerModule->Disconnect($DatabaseTableName);
			} else {
				$this->Client->Connect($DatabaseTableName);
				$this->Client->pass ($DatabaseTableName, 'updateRow', $passarray);
				$this->Client->Disconnect($DatabaseTableName);
			}
		} else {
			array_push($this->ErrorMessage,'notApprovedModuleContent: PageID and DatabaseTableName cannot be NULL!');
			$BackTrace = debug_backtrace(FALSE);
		}
	}

	protected function spamModuleContent(array $PageID, $DatabaseTableName) {
		if ($PageID != NULL && $DatabaseTableName != NULL) {
			$passarray = array();
			$passarray1 = array();
			$passarray2 = array();
			$passarray3 = array();
			$passarray4 = array();

			$passarray1[0] = 'Status';

			$passarray2[0] = 'Spam';

			if ($PageID['PageID']) {
				$passarray3[0][0] = 'PageID';

				$passarray4[0][0] = $PageID['PageID'];
			} else if ($PageID['XMLItem']) {
				$passarray3[0][0] = 'XMLItem';

				$passarray4[0][0] = $PageID['XMLItem'];
			}

			if ($PageID['ObjectID']) {
				$passarray3[0][1] = 'ObjectID';
				$passarray4[0][1] = $PageID['ObjectID'];
			}

			if ($PageID['XhtmlTableName']) {
				$passarray3[0][2] = 'XhtmlTableName';

				$passarray4[0][2] = $PageID['XhtmlTableName'];
			}

			if ($PageID['XhtmlTableID']) {
				$passarray3[0][3] = 'XhtmlTableID';

				$passarray4[0][3] = $PageID['XhtmlTableID'];
			}

			$passarray['rowname'] = $passarray1;
			$passarray['rowvalue'] = $passarray2;
			$passarray['rownumbername'] = $passarray3;
			$passarray['rownumber'] = $passarray4;

			if ($this->LayerModuleOn === TRUE) {
				$this->LayerModule->Connect($DatabaseTableName);
				$this->LayerModule->pass ($DatabaseTableName, 'updateRow', $passarray);
				$this->LayerModule->Disconnect($DatabaseTableName);
			} else {
				$this->Client->Connect($DatabaseTableName);
				$this->Client->pass ($DatabaseTableName, 'updateRow', $passarray);
				$this->Client->Disconnect($DatabaseTableName);
			}
		} else {
			array_push($this->ErrorMessage,'spamModuleContent: PageID and DatabaseTableName cannot be NULL!');
			$BackTrace = debug_backtrace(FALSE);
		}
	}

	protected function pendingModuleContent(array $PageID, $DatabaseTableName) {
		if ($PageID != NULL && $DatabaseTableName != NULL) {
			$passarray = array();
			$passarray1 = array();
			$passarray2 = array();
			$passarray3 = array();
			$passarray4 = array();

			$passarray1[0] = 'Status';

			$passarray2[0] = 'Pending';

			if ($PageID['PageID']) {
				$passarray3[0][0] = 'PageID';

				$passarray4[0][0] = $PageID['PageID'];
			} else if ($PageID['XMLItem']) {
				$passarray3[0][0] = 'XMLItem';

				$passarray4[0][0] = $PageID['XMLItem'];
			}

			if ($PageID['ObjectID']) {
				$passarray3[0][1] = 'ObjectID';
				$passarray4[0][1] = $PageID['ObjectID'];
			}

			if ($PageID['XhtmlTableName']) {
				$passarray3[0][2] = 'XhtmlTableName';

				$passarray4[0][2] = $PageID['XhtmlTableName'];
			}

			if ($PageID['XhtmlTableID']) {
				$passarray3[0][3] = 'XhtmlTableID';

				$passarray4[0][3] = $PageID['XhtmlTableID'];
			}

			$passarray['rowname'] = $passarray1;
			$passarray['rowvalue'] = $passarray2;
			$passarray['rownumbername'] = $passarray3;
			$passarray['rownumber'] = $passarray4;

			if ($this->LayerModuleOn === TRUE) {
				$this->LayerModule->Connect($DatabaseTableName);
				$this->LayerModule->pass ($DatabaseTableName, 'updateRow', $passarray);
				$this->LayerModule->Disconnect($DatabaseTableName);
			} else {
				$this->Client->Connect($DatabaseTableName);
				$this->Client->pass ($DatabaseTableName, 'updateRow', $passarray);
				$this->Client->Disconnect($DatabaseTableName);
			}
		} else {
			array_push($this->ErrorMessage,'pendingModuleContent: PageID and DatabaseTableName cannot be NULL!');
			$BackTrace = debug_backtrace(FALSE);
		}
	}

	protected function installModule($ModuleType, $ModuleName, $ModuleInstallFile) {

	}

	protected function upgradeModule($ModuleType, $ModuleName, $ModuleUpgradeFile) {

	}

	protected function deleteModule($ModuleType, $ModuleName, $ModuleDeleteFile) {

	}

	protected function enableModule($ModuleType, $ModuleName) {

	}

	protected function disableModule($ModuleType, $ModuleName) {

	}

	public function installSystem() {

	}

	public function upgradeDatabase($Filename) {
		if (!empty($Filename)) {
			if (file_exists($Filename)) {
				$File = file($Filename);

				foreach ($File as $FileContent) {
					$FileContent = str_replace("\n", '', $FileContent);
					if (file_exists($FileContent)) {
						$SqlFileCommand = 'mysql -h' . $this->Hostname . ' -u' . $this->User . ' -p' . $this->Password . ' ' . $this->DatabaseName . ' < ' . $FileContent;
						system ($SqlFileCommand);
					}
				}
				
			} else {
				array_push($this->ErrorMessage,'upgradeDatabase: Filename DOES NOT EXIST!');
				$BackTrace = debug_backtrace(FALSE);
			}
		} else {
			array_push($this->ErrorMessage,'upgradeDatabase: Filename CANNOT BE EMPTY!');
			$BackTrace = debug_backtrace(FALSE);
		}
	}

	public function backupDatabase($DirectoryName, $Filename) {
		if (!empty($Filename)) {
			if (!empty($DirectoryName)) {
				if (is_dir($DirectoryName)) {
					if (!file_exists($Filename)) {
						$SqlFileCommand = 'mysqldump --extended-insert=FALSE --complete-insert=FALSE -h' . $this->Hostname . ' -u' . $this->User . ' -p' . $this->Password . ' ' . $this->DatabaseName . ' > ' . $DirectoryName . $Filename;
						system ($SqlFileCommand);
					} else {
						array_push($this->ErrorMessage,'backupDatabase: Filename EXISTS!');
						$BackTrace = debug_backtrace(FALSE);
					}
				} else {
					array_push($this->ErrorMessage,'backupDatabase: DirectoryName DOES NOT EXIST!');
					$BackTrace = debug_backtrace(FALSE);
				}
			} else {
				array_push($this->ErrorMessage,'backupDatabase: DirectoryName CANNOT BE EMPTY!');
				$BackTrace = debug_backtrace(FALSE);
			}
		} else {
			array_push($this->ErrorMessage,'backupDatabase: Filename CANNOT BE EMPTY!');
			$BackTrace = debug_backtrace(FALSE);
		}
	}

	public function restoreDatabase($Filename) {
		if (!empty($Filename)) {
			if (file_exists($Filename)) {
				$SqlFileCommand = 'mysql -h' . $this->Hostname . ' -u' . $this->User . ' -p' . $this->Password . ' ' . $this->DatabaseName . ' < ' . $Filename;
				system ($SqlFileCommand);
			} else {
				array_push($this->ErrorMessage,'restoreDatabase: Filename DOES NOT EXIST!');
				$BackTrace = debug_backtrace(FALSE);
			}
		} else {
			array_push($this->ErrorMessage,'restoreDatabase: Filename CANNOT BE EMPTY!');
			$BackTrace = debug_backtrace(FALSE);
		}
	}

	public function processSqlFile($Filename) {
		if (!empty($Filename)) {
			if (file_exists($Filename)) {
				$File = file($Filename);
				$ReturnFile = array();
				foreach ($File as $Line) {
					// Skip it if it is a comment or it is empty space
					if (substr($Line, 0, 2) == '--' || $Line == '' || strstr($Line, '/*') || strstr($Line, '/*') || empty($Line) || substr($Line, 0, 1) == "\r") {
						continue;
					}

					// Add this line to the current segment
					$Content .= $Line;

					// If it has a semicolon at the end, it's the end of the query
					if (substr(trim($Line), -1, 1) == ';') {
						$Content = trim($Content);
						$Content = str_replace("\n", '', $Content);
						$Content = str_replace("\r", '', $Content);
						array_push($ReturnFile,$Content);
						$Content = '';
					}
				}
				return $ReturnFile;
				//$SqlFileCommand = 'mysql -h' . $this->Hostname . ' -u' . $this->User . ' -p' . $this->Password . ' ' . $this->DatabaseName . ' < ' . $Filename;
				//system ($SqlFileCommand);
			}
		}
	}

	public function getTable($TableName) {
		if (is_string($TableName)) {
			if ($this->LayerModuleOn === TRUE) {
				$this->LayerModule->createDatabaseTable($TableName);
				$this->LayerModule->Connect($TableName);
				$this->LayerModule->pass ($TableName, 'setEntireTable', array());
				$this->LayerModule->Disconnect($TableName);

				$hold = $this->LayerModule->pass ($TableName, 'getEntireTable', array());
			} else {
				$this->Client->createDatabaseTable($TableName);
				$this->Client->Connect($TableName);
				$this->Client->pass ($TableName, 'setEntireTable', array());
				$this->Client->Disconnect($TableName);

				$hold = $this->Client->pass ($TableName, 'getEntireTable', array());
			}
			return $hold;
		}
	}

	public function getRecord($PageID) {
		$passarray = array();
		$passarray = $PageID['PageID'];

		$args = func_get_args();
		if ($args[1]) {
			$DatabaseName = $args[1];
			if ($this->LayerModuleOn === TRUE) {
				$this->LayerModule->createDatabaseTable($DatabaseName);
			} else {
				$this->Client->createDatabaseTable($DatabaseName);
			}
			if (is_array($PageID)) {
				$passarray = $PageID;
			}
			if ($this->LayerModuleOn === TRUE) {
				$this->LayerModule->Connect($DatabaseName);
			} else {
				$this->Client->Connect($DatabaseName);
			}
			if ($args[2]) {
				$hold = NULL;
				$trip = FALSE;
				foreach ($args[3] as $key => $value) {
					if ($value != NULL) {
						if ($trip) {
							$hold .= '`, `';
							$hold .= $value;
						} else {
							$hold .= $value;
							$trip = TRUE;
						}
					}
				}

				if ($hold) {
					if ($this->LayerModuleOn === TRUE) {
						$this->LayerModule->pass ($DatabaseName, 'setOrderbyname', array('orderbyname' => $hold));
					} else {
						$this->Client->pass ($DatabaseName, 'setOrderbyname', array('orderbyname' => $hold));
					}
				}

				if ($args[4] == 'ASC' | $args[4] == 'DESC') {
					if ($this->LayerModuleOn !== TRUE) {
						$this->Client->pass ($DatabaseName, 'setOrderbytype', array('orderbytype' => $args[4]));
					} else {
						$this->LayerModule->pass ($DatabaseName, 'setOrderbytype', array('orderbytype' => $args[4]));
					}
				} else if ($args[3]){
					if ($this->LayerModuleOn === TRUE) {
						$this->LayerModule->pass ($DatabaseName, 'setOrderbytype', array('orderbytype' => 'ASC'));
					} else {
						$this->Client->pass ($DatabaseName, 'setOrderbytype', array('orderbytype' => 'ASC'));
					}
				}
			}
			if ($this->LayerModuleOn === TRUE) {
				$this->LayerModule->pass ($DatabaseName, 'setDatabaseRow', array('idnumber' => $passarray));
				$this->LayerModule->Disconnect($DatabaseName);

				$hold = $this->LayerModule->pass ($DatabaseName, 'getMultiRowField', array());
			} else {
				$this->Client->pass ($DatabaseName, 'setDatabaseRow', array('idnumber' => $passarray));
				$this->Client->Disconnect($DatabaseName);

				$hold = $this->Client->pass ($DatabaseName, 'getMultiRowField', array());
			}
		} else {
			if (isset($PageID['DatabaseVariableName'])) {
				$DatabaseVariableName = $PageID['DatabaseVariableName'];

				if ($this->LayerModuleOn === TRUE) {
					$this->LayerModule->Connect($this->$DatabaseVariableName);
					$this->LayerModule->pass ($this->$DatabaseVariableName, 'setDatabaseRow', array('idnumber' => $passarray));
					$this->LayerModule->Disconnect($this->$DatabaseVariableName);

					$hold = $this->LayerModule->pass ($this->$DatabaseVariableName, 'getMultiRowField', array());
				} else {
					$this->Client->Connect($this->$DatabaseVariableName);
					$this->Client->pass ($this->$DatabaseVariableName, 'setDatabaseRow', array('idnumber' => $passarray));
					$this->Client->Disconnect($this->$DatabaseVariableName);

					$hold = $this->Client->pass ($this->$DatabaseVariableName, 'getMultiRowField', array());
				}
			} else if (isset($PageID['DatabaseTableName'])) {
				$DatabaseTableName = $PageID['DatabaseTableName'];

				if ($this->LayerModuleOn === TRUE) {
					$this->LayerModule->Connect($DatabaseTableName);
					$this->LayerModule->pass ($DatabaseTableName, 'setDatabaseRow', array('idnumber' => $passarray));
					$this->LayerModule->Disconnect($DatabaseTableName);

					$hold = $this->LayerModule->pass ($DatabaseTableName, 'getMultiRowField', array());
				} else {
					$this->Client->Connect($DatabaseTableName);
					$this->Client->pass ($DatabaseTableName, 'setDatabaseRow', array('idnumber' => $passarray));
					$this->Client->Disconnect($DatabaseTableName);

					$hold = $this->Client->pass ($DatabaseTableName, 'getMultiRowField', array());
				}
			}
		}

		return $hold;
	}

	protected function updateRecord(array $PageID, array $Content, $DatabaseTableName) {
		if ($PageID != NULL && $Content != NULL && $DatabaseTableName != NULL) {
			$passarray = array();
			$passarray1 = array();
			$passarray2 = array();
			$passarray3 = array();
			$passarray4 = array();

			$j = 0;
			while (key($PageID)) {
				$passarray3[0][$j] = key($PageID);
				$passarray4[0][$j] = current($PageID);
				$j++;
				next ($PageID);
			}

			$flag = FALSE;
			reset ($Content);
			$i = 0;
			while (key($Content)) {
				if (is_array($Content[key($Content)])) {
					$hold = $Content[key($Content)];
					reset($hold);
					$j = 0;
					while (key($hold)) {
						$passarray1[$j] = key($hold);
						$passarray2[$j] = current($hold);
						next($hold);
						$j++;
					}

					$passarray['rowname'] = $passarray1;
					$passarray['rowvalue'] = $passarray2;
					$passarray['rownumbername'] = $passarray3;
					$passarray['rownumber'] = $passarray4;

					if ($this->LayerModuleOn === TRUE) {
						$this->LayerModule->Connect($DatabaseTableName);
						$this->LayerModule->pass ($DatabaseTableName, 'updateRow', $passarray);
						$this->LayerModule->Disconnect($DatabaseTableName);
					} else {
						$this->Client->Connect($DatabaseTableName);
						$this->Client->pass ($DatabaseTableName, 'updateRow', $passarray);
						$this->Client->Disconnect($DatabaseTableName);
					}

				} else {
					$passarray1[$i] = key($Content);
					$passarray2[$i] = current($Content);
					$flag = TRUE;
				}
				reset ($PageID);

				$i++;
				next ($Content);
			}
			if ($flag) {
				$passarray['rowname'] = $passarray1;
				$passarray['rowvalue'] = $passarray2;
				$passarray['rownumbername'] = $passarray3;
				$passarray['rownumber'] = $passarray4;

				if ($this->LayerModuleOn === TRUE) {
					$this->LayerModule->Connect($DatabaseTableName);
					$this->LayerModule->pass ($DatabaseTableName, 'updateRow', $passarray);
					$this->LayerModule->Disconnect($DatabaseTableName);
				} else {
					$this->Client->Connect($DatabaseTableName);
					$this->Client->pass ($DatabaseTableName, 'updateRow', $passarray);
					$this->Client->Disconnect($DatabaseTableName);
				}
			}
		} else {
			array_push($this->ErrorMessage,'updateRecord: PageID, Content and DatabaseTableName cannot be NULL!');
			$BackTrace = debug_backtrace(FALSE);
		}
	}

	public function updateModuleSetting($ObjectType, $ObjectTypeName, $ModuleSetting, $ModuleSettingAttribute) {
		if ($ModuleSetting != NULL && $ModuleSettingAttribute != NULL && $ObjectType != NULL && $ObjectTypeName != NULL) {
			$passarray = array();
			$passarray1 = array();
			$passarray2 = array();
			$passarray3 = array();
			$passarray4 = array();

			$passarray1[0] = 'SettingAttribute';

			$passarray2[0] = $ModuleSettingAttribute;


			$passarray3[0][0] = 'ObjectType';
			$passarray3[0][1] = 'ObjectTypeName';
			$passarray3[0][2] = 'Setting';

			$passarray4[0][0] = $ObjectType;
			$passarray4[0][1] = $ObjectTypeName;
			$passarray4[0][2] = $ModuleSetting;

			$passarray['rowname'] = $passarray1;
			$passarray['rowvalue'] = $passarray2;
			$passarray['rownumbername'] = $passarray3;
			$passarray['rownumber'] = $passarray4;

			if ($this->LayerModuleOn === TRUE) {
				$this->LayerModule->Connect($this->LayerModuleTableNameSetting);
				$this->LayerModule->pass ($this->LayerModuleTableNameSetting, 'updateRow', $passarray);
				$this->LayerModule->Disconnect($this->LayerModuleTableNameSetting);
			} else {
				$this->Client->Connect($this->LayerModuleTableNameSetting);
				$this->Client->pass ($this->LayerModuleTableNameSetting, 'updateRow', $passarray);
				$this->Client->Disconnect($this->LayerModuleTableNameSetting);
			}
		} else {
			array_push($this->ErrorMessage,'updateModuleSetting: ObjectType, ObjectTypeName, ModuleSetting and ModuleSettingAttribute cannot be NULL!');
			$BackTrace = debug_backtrace(FALSE);
		}
	}

	public function sortTable(array $SortOrder, $DatabaseTableName) {
		if ($DatabaseTableName != NULL) {
			if ($this->LayerModuleOn === TRUE) {
				$this->LayerModule->createDatabaseTable($DatabaseTableName);
				$this->LayerModule->Connect($DatabaseTableName);
				$this->LayerModule->pass ($DatabaseTableName, 'sortTable', array('SortOrder'=> $SortOrder));
				$this->LayerModule->Disconnect($DatabaseTableName);
			} else {
				$this->Client->createDatabaseTable($DatabaseTableName);
				$this->Client->Connect($DatabaseTableName);
				$this->Client->pass ($DatabaseTableName, 'sortTable', array('SortOrder'=> $SortOrder));
				$this->Client->Disconnect($DatabaseTableName);
			}
		} else {
			array_push($this->ErrorMessage,'sortTable: SortOrder cannot be NULL!');
			$BackTrace = debug_backtrace(FALSE);
		}
	}

	public function MultiArrayBuild(array $Start, $StartKey, $ConditionalKey, $StartNumber, array $Source) {
		$functionarguments = func_get_args();

		$Sort = NULL;
		if ($functionarguments[5]) {
			$Sort = $functionarguments[5];
		}

		$EndKey = NULL;
		if ($functionarguments[6]) {
			$EndKey = $functionarguments[6];
		}

		if (is_null($StartKey)) {
			array_push($this->ErrorMessage,'MultiArrayBuild: RemoveKey cannot be NULL!');
			$BackTrace = debug_backtrace(FALSE);
		} else if (is_null($ConditionalKey)) {
			array_push($this->ErrorMessage,'MultiArrayBuild: Key cannot be NULL!');
			$BackTrace = debug_backtrace(FALSE);
		} else if (is_null($StartNumber)) {
			array_push($this->ErrorMessage,'MultiArrayBuild: StartNumber cannot be NULL!');
			$BackTrace = debug_backtrace(FALSE);
		} else {
			$temp = array();
			$i = $StartNumber;
			if ($EndKey) {
				$SourceKey = $StartKey;
				$SourceKey .= $ConditionalKey;
				$SourceKey .= $i;
			} else {
				$SourceKey = $StartKey;
				$SourceKey .= $i;
				$SourceKey .= $ConditionalKey;
			}
			while (array_key_exists($SourceKey, $Source)) {
				if (isset($Source[$SourceKey])) {
					$SourceKeyHold = $SourceKey;
					foreach ($Start as $StartValue) {
						if ($EndKey) {
							$SourceKey = $StartKey;
							$SourceKey .= $StartValue;
							$SourceKey .= $i;
						} else {
							$SourceKey = $StartKey;
							$SourceKey .= $i;
							$SourceKey .= $StartValue;
						}

						if (is_null($Source[$SourceKey])) {
							unset($Source[$SourceKey]);
						} else {
							$temp[$i][$SourceKey] = $Source[$SourceKey];
							unset($Source[$SourceKey]);
						}
					}
					if (isset($Source[$SourceKeyHold])) {
						unset($Source[$SourceKeyHold]);
					}
				} else {
					$SourceKeyHold = $SourceKey;
					foreach ($Start as $StartValue) {
						if ($EndKey) {
							$SourceKey = $StartKey;
							$SourceKey .= $StartValue;
							$SourceKey .= $i;
						} else {
							$SourceKey = $StartKey;
							$SourceKey .= $i;
							$SourceKey .= $StartValue;
						}

						unset($Source[$SourceKey]);
					}
				}
				$i++;
				if ($EndKey) {
					$SourceKey = $StartKey;
					$SourceKey .= $ConditionalKey;
					$SourceKey .= $i;
				} else {
					$SourceKey = $StartKey;
					$SourceKey .= $i;
					$SourceKey .= $ConditionalKey;
				}
			}
			$Source = $Source + $temp;
			unset ($temp);
			if (!is_null($Sort)) {
				if (!is_array($Sort)) {
					$temp = $Source;
					$newtemp = array();
					$holdarray = array();

					for ($i = $StartNumber; $temp[$i]; $i++) {
						if ($EndKey) {
							$SetOrder = $StartKey;
							$SetOrder .= $Sort;
							$SetOrder .= $i;
						} else {
							$SetOrder = $StartKey;
							$SetOrder .= $i;
							$SetOrder .= $Sort;
						}

						if ($temp[$i][$SetOrder]) {
							try {
								if (is_numeric($temp[$i][$SetOrder])) {
									$index = $temp[$i][$SetOrder];

									if ($newtemp[$index]) {
										if ($newtemp[$i] == NULL) {
											$newtemp[$i] = $newtemp[$index];
											unset($newtemp[$index]);
										} else {
											$j = $i;
											while ($newtemp[$j]) {
												$j++;
											}
											$newtemp[$j] = $newtemp[$index];
											unset($newtemp[$index]);
										}
									}

									foreach ($temp[$i] as $key => $value) {
										$key = explode($StartKey, $key, 2);
										$hold = $key[0];
										$key[0] = $StartKey;
										if (is_null($EndKey)) {
											$key[0] .= $hold;
											$key[0] .= $index;
											$key[1] = preg_replace('([0-9]+)', '', $key[1], 1);
										} else {
											preg_match('([0-9]+)', $key[1], $oldindex);
											$oldindex = $oldindex[0];
											$key[1] = str_replace($oldindex, $index, $key[1]);
										}
										$key = implode($key);
										$newtemp[$index][$key] = $value;
									}
									unset($temp[$i]);
									unset($Source[$i]);
								} else {
									array_push($this->ErrorMessage,"MultiArrayBuild: Array Sort Order from index - $i key - $SetOrder MUST BE AN INTEGER!");
									$BackTrace = debug_backtrace(FALSE);
									throw new Exception("FATAL ERROR: MultiArrayBuild: Array Sort Order from index - $i key - $SetOrder MUST BE AN INTEGER!");
								}
							} catch (Exception $e) {
								print $e->getMessage();
								print "\n";
								return NULL;
							}

						} else if ($temp[$i]) {
							$temp[$i][$SetOrder] = NULL;
							array_push($holdarray, $temp[$i]);
							unset($temp[$i]);
							unset($Source[$i]);
						}
					}

					if ($holdarray) {
						foreach ($holdarray as $key => $values) {
							array_push($newtemp, $values);
						}
						unset($holdarray);
					}

					$holdarray = array();

					ksort($newtemp);
					$newtemp = array_merge($newtemp);

					//$newtemp = array_combine(range($StartNumber, count($newtemp)), array_values($newtemp));
					foreach ($newtemp as $key => $value) {
						if ($EndKey) {
							$SetOrder = $StartKey;
							$SetOrder .= $Sort;
							$SetOrder .= $key;
						} else {
							$SetOrder = $StartKey;
							$SetOrder .= $key;
							$SetOrder .= $Sort;
						}
						if (isset($key)) {
							$newkey = $key;
							$newkey++;
							$holdarray[$newkey] = $value;

							unset($newtemp[$key]);

						}
					}
					$newtemp = $newtemp + $holdarray;
					foreach ($newtemp as $key => $value) {
						if ($EndKey) {
							$SetOrder = $StartKey;
							$SetOrder .= $Sort;
							$SetOrder .= $key;
						} else {
							$SetOrder = $StartKey;
							$SetOrder .= $key;
							$SetOrder .= $Sort;
						}

						if ($key != $value[$SetOrder]) {
							foreach($value as $key2 => $value2) {
								preg_match('([0-9]+)', $key2, $oldcount);
								$oldcount = $oldcount[0];

								$replace = $StartKey;
								$replace .= $oldcount;
								$replacement = $StartKey;
								$replacement .= $key;

								$key3 = str_replace($replace, $replacement, $key2);
								if ($key2 != $key3) {
									$newtemp[$key][$key3] = $newtemp[$key][$key2];
									unset($newtemp[$key][$key2]);
								}
							}
						}
					}

					foreach ($newtemp as $key => $value) {
						if ($EndKey) {
							$SetOrder = $StartKey;
							$SetOrder .= $Sort;
							$SetOrder .= $key;
						} else {
							$SetOrder = $StartKey;
							$SetOrder .= $key;
							$SetOrder .= $Sort;
						}
						if (isset($value[$SetOrder])) {
							$newtemp[$key][$SetOrder] = NULL;
						}
					}

					$Source = $Source + $newtemp;
					unset($newtemp);
					unset($temp);

				} else {
					array_push($this->ErrorMessage,'MultiArrayBuild: Sort cannot be an ARRAY!');
					$BackTrace = debug_backtrace(FALSE);
				}
			}

			return $Source;
		}

	}

	public function MultiArrayCombine($StartNumber, array $Source) {
		if ($StartNumber != NULL) {
			try {
				if (is_numeric($StartNumber)) {
					for ($i = $StartNumber; $Source[$i]; $i++) {
						foreach ($Source[$i] as $key => $value) {
							if (is_numeric($key)) {
								$hold = $this->MultiArrayCombine($StartNumber, $value);
								if ($hold) {
									$Source = $Source + $hold;
								}
							} else {
								$Source[$key] = $value;
							}
							unset($Source[$i][$key]);
						}
						unset($Source[$i]);
					}
					return $Source;

				} else {
					array_push($this->ErrorMessage,"MultiArrayCombine: StartNumber MUST BE AN INTEGER!");
					$BackTrace = debug_backtrace(FALSE);
					throw new Exception("FATAL ERROR: MultiArrayCombine: StartNumber MUST BE AN INTEGER!");
				}
			} catch (Exception $e){
				print $e->getMessage();
				print "\n";
				return NULL;
			}
		} else {
			array_push($this->ErrorMessage,'MultiArrayCombine: StartNumber MUST be set!');
			$BackTrace = debug_backtrace(FALSE);
		}
	}
	
	public function getMethods() {
		return get_class_methods($this);
	}

}
?>
