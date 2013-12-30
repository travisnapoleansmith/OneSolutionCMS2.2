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
	
abstract class GlobalTierAbstract //extends LayerModulesAbstract
{
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
	
	protected $ErrorMessage = array();
	
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
					} else {
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
	
}
?>