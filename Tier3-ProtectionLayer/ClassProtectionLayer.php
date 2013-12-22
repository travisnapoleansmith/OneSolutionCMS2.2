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
	 * Protection Layer Modules
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
	 * Tier Keyword
	 *
	 * @var string
	 */
	protected $TierKeyword;

	/**
	 * Create an instance of ProtectionLayer
	 *
	 * @access public
	 */
	public function __construct () {
		$this->TierKeyword = 'PROTECT';
		
		$this->Modules = Array();
		$this->DatabaseTable = Array();
		$GLOBALS['ErrorMessage']['ProtectionLayer'] = array();
		$this->ErrorMessage = &$GLOBALS['ErrorMessage']['ProtectionLayer'];

		$this->DatabaseAllow = &$GLOBALS['Tier3DatabaseAllow'];
		$this->DatabaseDeny = &$GLOBALS['Tier3DatabaseDeny'];

		$credentaillogonarray = $GLOBALS['credentaillogonarray'];

		//$this->LayerModuleOn = FALSE;

		if ($this->LayerModuleOn === TRUE) {
			$this->LayerModule = new DataAccessLayer();
			$this->LayerModule->setPriorLayerModule($this);
			//$this->LayerModule->createDatabaseTable('ContentLayer');
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
			
			//$this->Client->createDatabaseTable('ContentLayer');
			$this->Client->setDatabaseAll ($credentaillogonarray[0], $credentaillogonarray[1], $credentaillogonarray[2], $credentaillogonarray[3], NULL);
			$this->Client->buildModules('DataAccessLayerModules', 'DataAccessLayerTables', 'DataAccessLayerModulesSettings');
		}

		$this->PageID = $_GET['PageID'];

		$this->SessionName['SessionID'] = $_GET['SessionID'];
	}
	
	// Move to global tier - FINISH UP NOTES FOR THIS: Need it for arguments
	/**
	 * setModules
	 *
	 * Setter for Modules
	 *
	 * @access public
	 */
	public function setModules($ModuleName, $ObjectName, $ModuleObject) {
		if ($ModuleName != NULL) {
			if (!is_array($ModuleName)) {
				if ($ObjectName != NULL) {
					if (!is_array($ObjectName)) {
						if ($ModuleObject != NULL) {
							if (!is_array($ModuleObject)) {
								$this->Modules[$ModuleName][$ObjectName] = $ModuleObject;
								return $this;
							} else {
								array_push($this->ErrorMessage,'setModules: ModuleObject cannot be an array!');
								$BackTrace = debug_backtrace(FALSE);
								return FALSE;
							}
						} else {
							array_push($this->ErrorMessage,'setModules: ModuleObject cannot be NULL!');
							$BackTrace = debug_backtrace(FALSE);
							return FALSE;
						}
					} else {
						array_push($this->ErrorMessage,'setModules: ObjectName cannot be an array!');
						$BackTrace = debug_backtrace(FALSE);
						return FALSE;
					}
				} else {
					array_push($this->ErrorMessage,'setModules: ObjectName cannot be NULL!');
					$BackTrace = debug_backtrace(FALSE);
					return FALSE;
				}
			} else {
				array_push($this->ErrorMessage,'setModules: ModuleName cannot be an array!');
				$BackTrace = debug_backtrace(FALSE);
				return FALSE;
			}
		} else {
			array_push($this->ErrorMessage,'setModules: ModuleName cannot be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
	}
	
	// Move to global tier
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
		if ($ModuleName != NULL) {
			if ($this->Modules[$ModuleName] != NULL) {
				return $this->Modules[$ModuleName];
			} else {
				array_push($this->ErrorMessage,'getModules: Module is not set!');
				$BackTrace = debug_backtrace(FALSE);
				return FALSE;
			}
		} else {
			array_push($this->ErrorMessage,'getModules: ModuleName cannot be NULL!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
	}
	
	public function buildDatabase() {

	}
	
	public function checkPass($DatabaseTable, $Function, $FunctionArguments) {
		reset($this->Modules);
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
						
						$Hold = $Module->Verify($Function, $FunctionArguments, $HookArguments);
						if ($Hold === false) {
							break;
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
				$Module = current($Element);
				if (is_object($Module)) {
					if ($Function === $this->TierKeyword) {
						$Module->FetchDatabase ($FunctionArguments);
					} else {
						$Module->FetchDatabase ($this->PageID);
					}
					
					$Hold = $Module->Verify($Function, $FunctionArguments);
					
					if ($Hold === false) {
						break;
					}
				} else {
					array_push($this->ErrorMessage,'checkPass: Module is not an object!');
					$BackTrace = debug_backtrace(FALSE);
				}
			}
		}

		if ($function === $this->TierKeyword) {
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
											//print "PASS\n";
											$Hold = $this->LayerModule->pass($DatabaseTable, $Function, $FunctionArguments, $HookArguments);
										} else {
											array_push($this->ErrorMessage,'pass: LayerModule Cannot Be Null!');
											$BackTrace = debug_backtrace(FALSE);
											return FALSE;
										}
									} else {
										if ($this->Client != NULL) {
											//print "CLIENT PASS\n";
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
									//print "PASS TWO\n";
									$Hold = $this->LayerModule->pass($DatabaseTable, $Function, $FunctionArguments);
								} else {
									//print "CLIENT PASS TWO\n";
									$Hold = $this->Client->pass($DatabaseTable, $Function, $FunctionArguments);
								}
							}

							if ($Hold) {
								return $Hold;
							}
						} else if ($this->DatabaseDeny[$Function] || $Function === $this->TierKeyword) {
							$args = func_num_args();
							if ($args > 3) {
								$HookArgumentsArray = func_get_args();
								$HookArguments = $HookArgumentsArray[3];
								if (is_array($HookArguments)) {
									if ($Function === $this->TierKeyword) {
										if ($HookArguments['Execute'] === TRUE) {
											if ($HookArguments['Method'] != NULL) {
												if ($HookArguments['ObjectType'] != NULL) {
													if ($HookArguments['ObjectTypeName'] != NULL) {
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
														array_push($this->ErrorMessage,'pass: Missing Hook Argument - ObjectTypeName!');
														$BackTrace = debug_backtrace(FALSE);
														return FALSE;
													}
												} else {
													array_push($this->ErrorMessage,'pass: Missing Hook Argument - ObjectType!');
													$BackTrace = debug_backtrace(FALSE);
													return FALSE;
												}
											} else {
												array_push($this->ErrorMessage,'pass: Missing Hook Argument - Method!');
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
						} else {
							array_push($this->ErrorMessage,'pass: Tier 2 Data Access Layer Member Does Not Exist!');
							$BackTrace = debug_backtrace(FALSE);
							return FALSE;
						}
					} else {
						array_push($this->ErrorMessage,'pass: Tier 2 Data Access Layer Member Cannot Be An Array!');
						$BackTrace = debug_backtrace(FALSE);
						return FALSE;
					}
				} else {
					array_push($this->ErrorMessage,'pass: Tier 2 Data Access Layer Member Cannot Be Null!');
					$BackTrace = debug_backtrace(FALSE);
					return FALSE;
				}
			} else {
				array_push($this->ErrorMessage,'pass: Function Arguments Must Be An Array!');
				$BackTrace = debug_backtrace(FALSE);
				return FALSE;
			}
		} else {
			array_push($this->ErrorMessage,'pass: Function Arguments Cannot Be Null!');
			$BackTrace = debug_backtrace(FALSE);
			return FALSE;
		}
	}

}

?>