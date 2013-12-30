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

// SOAP TRACTING CALL
//throw new SoapFault("Constructor", 'HERE!');

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
	 * Create an instance of ProtectionLayer
	 *
	 * @access public
	 */
	public function __construct () {
		
		$ArgumentsArray = func_get_args();
		
		if ($ArgumentsArray != NULL) {
			if ($ArgumentsArray[0] != NULL) {
				$this->LayerModuleOn = $ArgumentsArray[0];
			}
		}
		
		$this->TierKeyword = 'PROTECT';
		$this->TierVerifyMethod = 'Verify';
		
		$this->Modules = array();
		$this->DatabaseTable = array();
		$GLOBALS['ErrorMessage']['ProtectionLayer'] = array();
		$this->ErrorMessage = &$GLOBALS['ErrorMessage']['ProtectionLayer'];

		$this->DatabaseAllow = &$GLOBALS['Tier3DatabaseAllow'];
		$this->DatabaseDeny = &$GLOBALS['Tier3DatabaseDeny'];

		$credentaillogonarray = $GLOBALS['credentaillogonarray'];
		
		if (isset($GLOBALS['LayerModuleOn']) === TRUE) {
			$this->LayerModuleOn = &$GLOBALS['LayerModuleOn'];
		} else {
			$this->LayerModuleOn = TRUE;
		}
		
		if ($this->LayerModuleOn === TRUE) {
			$this->LayerModule = new DataAccessLayer();
			$this->LayerModule->setPriorLayerModule($this);

			$this->LayerModule->setDatabaseAll ($credentaillogonarray[0], $credentaillogonarray[1], $credentaillogonarray[2], $credentaillogonarray[3], NULL);
			$this->LayerModule->buildModules('DataAccessLayerModules', 'DataAccessLayerTables', 'DataAccessLayerModulesSettings');
		} else {
			if ($_SERVER['HTTP_HOST'] != NULL) {
				$HOST = 'http://' . $_SERVER['HTTP_HOST'] . '/';
			} else if ($_SERVER['DOMAIN_NAME'] != NULL) {
				$HOST = 'http://' . $_SERVER['DOMAIN_NAME'] . '/';
			} else if ($_SERVER['SERVER_NAME'] != NULL) {
				$HOST = 'http://' . $_SERVER['SERVER_NAME'] . '/';
			} else {
				$HOST = NULL;
			}
			
			ini_set('session.auto_start', 0);
			
			$this->TokenKey = $GLOBALS['SETTINGS']['TIER CONFIGURATION']['TOKENKEY'];
		
			$this->Location = $HOST . 'Tier2-DataAccessLayer/SoapServerDataAccessLayer.php?Token=' . $this->TokenKey;
			$this->Uri = $HOST;
			$this->Client = new SoapClient(NULL, array('location' => $this->Location,
												'uri' => $this->Uri,
												'soap_version' => SOAP_1_2, 
												/*'exceptions' => FALSE,*/ 
												'trace' => TRUE,
												'encoding' => 'utf-8'));
			$this->Client->setPriorLayerModule($this);
			$this->Client->setDatabaseAll ($credentaillogonarray[0], $credentaillogonarray[1], $credentaillogonarray[2], $credentaillogonarray[3], NULL);
			$this->Client->buildModules('DataAccessLayerModules', 'DataAccessLayerTables', 'DataAccessLayerModulesSettings');
		}

		$this->PageID = $_GET['PageID'];

		$this->SessionName['SessionID'] = $_GET['SessionID'];
	}
	
	public function buildDatabase() {

	}
	
	/**
	 * checkPass
	 *
	 * Runs safety checks for the Tier's modules. It will ether call Verify or Pass depending on conditions
	 * 
	 * @param string $DatabaseTable String for Database Table to access. Must be a string.
	 * @param string $Function String for method to call or Keyword needed for the Tier. Must be a string.
	 * @param Array $FunctionArguments Array of Arguments to pass to method call. Must be an Array.
	 * @param Array $HookArguments String for Database Table to access. Must be a string.
	 *
	 * @return BOOL FALSE if no return type for a module call or if an error has occured. Returns the return of the module call.
	 * @access public
	 */
	public function checkPass($DatabaseTable, $Function, $FunctionArguments) {
		reset($this->Modules);
		
		if (is_null($DatabaseTable) === TRUE) {
			array_push($this->ErrorMessage,'checkPass: DatabaseTable Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($DatabaseTable) === TRUE) {
			array_push($this->ErrorMessage,'checkPass: DatabaseTable Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($DatabaseTable) === TRUE) {
			array_push($this->ErrorMessage,'checkPass: DatabaseTable Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($DatabaseTable) === TRUE) {
			array_push($this->ErrorMessage,'checkPass: DatabaseTable Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_null($Function) === TRUE) {
			array_push($this->ErrorMessage,'checkPass: Function Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($Function) === TRUE) {
			array_push($this->ErrorMessage,'checkPass: Function Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($Function) === TRUE) {
			array_push($this->ErrorMessage,'checkPass: Function Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($Function) === TRUE) {
			array_push($this->ErrorMessage,'checkPass: Function Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($FunctionArguments) === FALSE) {
			array_push($this->ErrorMessage,'checkPass: FunctionArguments Must Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		$Hold = NULL;
		$args = func_num_args();
		if ($args > 3) {
			$HookArgumentsArray = func_get_args();
			$HookArguments = $HookArgumentsArray[3];
			if (is_array($HookArguments)) {
				foreach($this->Modules as $Key => $Element) {
					$Module = current($Element);
					if (is_object($Module)) {
						if ($Function === $this->TierKeyword) {
							$Module->FetchDatabase ($FunctionArguments);
						} else {
							$Module->FetchDatabase ($this->PageID);
						}
						$Method = $this->TierVerifyMethod;
						$Hold = $Module->$Method($Function, $FunctionArguments, $HookArguments);
						if ($Hold === FALSE) {
							array_push($this->ErrorMessage,'checkPass: Verify Returned FALSE!');
							$BackTrace = debug_backtrace(FALSE);
							return FALSE;
						}
					} else {
						array_push($this->ErrorMessage,'checkPass: Module is not an object!');
						$BackTrace = debug_backtrace(FALSE);
					}
				}
			} else {
				array_push($this->ErrorMessage,'checkPass: Hook Arguments Must Be An Array!');
				$BackTrace = debug_backtrace(FALSE);
				return FALSE;
			}
		} else {
			foreach($this->Modules as $Key => $Element) {
				// MUST KEEP - current($Element) contains the actual Module needed!
				$Module = current($Element);
				if (is_object($Module)) {
					if ($Function === $this->TierKeyword) {
						$Module->FetchDatabase ($FunctionArguments);
					} else {
						$Module->FetchDatabase ($this->PageID);
					}
					$Method = $this->TierVerifyMethod;
					
					$Hold = $Module->$Method($Function, $FunctionArguments);
					
					if ($Hold === FALSE) {
						array_push($this->ErrorMessage,'checkPass: Verify Returned FALSE!');
						$BackTrace = debug_backtrace(FALSE);
						return FALSE;
					}
				} else {
					array_push($this->ErrorMessage,'checkPass: Module is not an object!');
					$BackTrace = debug_backtrace(FALSE);
				}
			}
		}
		
		if ($Function === $this->TierKeyword) {
			if ($Hold) {
				return $Hold;
			}
		} else {
			if ($this->LayerModuleOn === TRUE) {
				$Hold2 = $this->LayerModule->pass($DatabaseTable, $Function, $FunctionArguments);
			} else {
				$Hold2 = $this->Client->pass($DatabaseTable, $Function, $FunctionArguments);
			}
			
			if ($Hold2) {
				return $Hold2;
			} else {
				return FALSE;
			}
		}
	}
	
	/**
	 * pass
	 *
	 * Runs safety checks for the Tier's modules. It will ether call checkPass or Pass it down to the next tier, depending on conditions
	 * 
	 * @param string $DatabaseTable String for Database Table to access. Must be a string.
	 * @param string $Function String for method to call or Keyword needed for the Tier. Must be a string.
	 * @param Array $FunctionArguments Array of Arguments to pass to method call. Must be an Array.
	 * @param Array $HookArguments String for Database Table to access. Must be a string.
	 *
	 * @return BOOL FALSE if no return type for a module call or if an error has occured. Returns the return of the module call.
	 * @access public
	 */
	public function pass($DatabaseTable, $Function, $FunctionArguments) {
		if (is_null($DatabaseTable) === TRUE) {
			array_push($this->ErrorMessage,'checkPass: DatabaseTable Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($DatabaseTable) === TRUE) {
			array_push($this->ErrorMessage,'checkPass: DatabaseTable Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($DatabaseTable) === TRUE) {
			array_push($this->ErrorMessage,'checkPass: DatabaseTable Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($DatabaseTable) === TRUE) {
			array_push($this->ErrorMessage,'checkPass: DatabaseTable Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_null($Function) === TRUE) {
			array_push($this->ErrorMessage,'checkPass: Function Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($Function) === TRUE) {
			array_push($this->ErrorMessage,'checkPass: Function Cannot Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($Function) === TRUE) {
			array_push($this->ErrorMessage,'checkPass: Function Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($Function) === TRUE) {
			array_push($this->ErrorMessage,'checkPass: Function Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_null($FunctionArguments) === TRUE) {
			array_push($this->ErrorMessage,'checkPass: FunctionArguments Cannot Be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_array($FunctionArguments) === FALSE) {
			array_push($this->ErrorMessage,'checkPass: FunctionArguments Must Be An Array!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_object($FunctionArguments) === TRUE) {
			array_push($this->ErrorMessage,'checkPass: FunctionArguments Cannot Be An Object!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if (is_resource($FunctionArguments) === TRUE) {
			array_push($this->ErrorMessage,'checkPass: FunctionArguments Cannot Be A Resource!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
		
		if ($this->DatabaseDeny[$Function] || $Function === $this->TierKeyword) {
			$args = func_num_args();
			if ($args > 3) {
				$HookArgumentsArray = func_get_args();
				$HookArguments = $HookArgumentsArray[3];
				if (is_array($HookArguments)) {
					if ($Function === $this->TierKeyword) {
						if (isset($HookArguments['Execute']) === FALSE) {
							array_push($this->ErrorMessage,'pass: Missing Hook Argument - Execute!');
							$BackTrace = debug_backtrace(FALSE);
							return FALSE;
						} else if ($HookArguments['Execute'] !== TRUE) {
							array_push($this->ErrorMessage,'pass: Hook Argument - Execute Is Not Set To TRUE!');
							$BackTrace = debug_backtrace(FALSE);
							return FALSE;
						}
						
						if (isset($HookArguments['Method']) === FALSE) {
							array_push($this->ErrorMessage,'pass: Missing Hook Argument - Method!');
							$BackTrace = debug_backtrace(FALSE);
							return FALSE;
						}

						if (isset($HookArguments['ObjectType']) === FALSE) {
							array_push($this->ErrorMessage,'pass: Missing Hook Argument - ObjectType!');
							$BackTrace = debug_backtrace(FALSE);
							return FALSE;
						}

						if (isset($HookArguments['ObjectTypeName']) === FALSE) {
							array_push($this->ErrorMessage,'pass: Missing Hook Argument - ObjectTypeName!');
							$BackTrace = debug_backtrace(FALSE);
							return FALSE;
						}
						$Method = $HookArguments['Method'];
						$ObjectType = $HookArguments['ObjectType'];
						$ObjectTypeName = $HookArguments['ObjectTypeName'];
						
						if ($this->Modules[$ObjectType][$ObjectTypeName] != NULL) {
							if (is_object($this->Modules[$ObjectType][$ObjectTypeName])) {
								if (method_exists($this->Modules[$ObjectType][$ObjectTypeName], $Method)) {
									$Hold = call_user_func_array(array($this->Modules[$ObjectType][$ObjectTypeName], $Method),$FunctionArguments);
									//$Hold = $this->Modules[$ObjectType][$ObjectTypeName]->$Method($FunctionArguments);
									if ($Hold) {
										return $Hold;
									} else {
										return FALSE;
									}
								} else {
									array_push($this->ErrorMessage,'pass: Module Method does not exist!');
									$BackTrace = debug_backtrace(FALSE);
									return FALSE;
								}
							} else {
								array_push($this->ErrorMessage,'pass: Module is not an object!');
								$BackTrace = debug_backtrace(FALSE);
								return FALSE;
							}
						} else {
							array_push($this->ErrorMessage,'pass: Module does not exists!');
							$BackTrace = debug_backtrace(FALSE);
							return FALSE;
						}
					} else {
						$Hold = $this->checkPass($DatabaseTable, $Function, $FunctionArguments, $HookArguments);
						if ($Hold) {
							return $Hold;
						} else {
							return FALSE;
						}
					}
				} else {
					array_push($this->ErrorMessage,'pass: Hook Arguments Must Be An Array!');
					$BackTrace = debug_backtrace(FALSE);
					return FALSE;
				}
			} else {
				$Hold = $this->checkPass($DatabaseTable, $Function, $FunctionArguments);
				if ($Hold) {
					return $Hold;
				} else {
					return FALSE;
				}
			}

			if ($Hold) {
				return $Hold;
			} else {
				return FALSE;
			}
		} else if ($this->DatabaseAllow[$Function]) {
			$args = func_num_args();
			if ($args > 3) {
				$HookArgumentsArray = func_get_args();
				$HookArguments = $HookArgumentsArray[3];
				if (is_array($HookArguments)) {
					if ($this->LayerModuleOn === TRUE) {
						if ($this->LayerModule != NULL) {
							$Hold = $this->LayerModule->pass($DatabaseTable, $Function, $FunctionArguments, $HookArguments);
						} else {
							array_push($this->ErrorMessage,'pass: LayerModule Cannot Be Null!');
							$BackTrace = debug_backtrace(FALSE);
							return FALSE;
						}
					} else {
						if ($this->Client != NULL) {
							$Hold = $this->Client->pass($DatabaseTable, $Function, $FunctionArguments, $HookArguments);
						} else {
							array_push($this->ErrorMessage,'pass: Client Cannot Be Null!');
							$BackTrace = debug_backtrace(FALSE);
							return FALSE;
						}
					}
				} else {
					array_push($this->ErrorMessage,'pass: Hook Arguments Must Be An Array!');
					$BackTrace = debug_backtrace(FALSE);
					return FALSE;
				}
			} else {
				if ($this->LayerModuleOn === TRUE) {
					$Hold = $this->LayerModule->pass($DatabaseTable, $Function, $FunctionArguments);
				} else {
					$Hold = $this->Client->pass($DatabaseTable, $Function, $FunctionArguments);
				}
			}

			if ($Hold) {
				return $Hold;
			}
		} else {
			array_push($this->ErrorMessage,'pass: Tier 2 Data Access Layer Member Does Not Exist!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
	}

}

?>