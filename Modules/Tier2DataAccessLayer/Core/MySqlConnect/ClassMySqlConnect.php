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
 * Class MySql Connect
 *
 * Class MySqlConnect is designed as the MySql database engine for One Solution CMS. It is used to do all MySql queries on the database.
 *
 * @author Travis Napolean Smith
 * @copyright Copyright (c) 1999 - 2012 One Solution CMS
 * @copyright PHP - Copyright (c) 2005 - 2012 One Solution CMS
 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
 * @version PHP - 2.1.130
 * @version C++ - Unknown
 */

class MySqlConnect extends Tier2DataAccessLayerModulesAbstract implements Tier2DataAccessLayerModules
{
	/**
	 * Create an instance of MySqlConnect.
	 *
	 * @access public
	*/
	public function MySqlConnect () {
		$this->IDSearch = Array();

		$Hold = array();
		if (!is_array($GLOBALS['ErrorMessage']['MySqlConnect'])) {
			$GLOBALS['ErrorMessage']['MySqlConnect'] = array();
		}
		array_push($GLOBALS['ErrorMessage']['MySqlConnect'], $Hold);
		$this->ErrorMessage = &$GLOBALS['ErrorMessage']['MySqlConnect'][key($GLOBALS['ErrorMessage']['MySqlConnect'])];
	}
	
	/**
	 * Connect
	 * Connects to current database.
	 *
	 * @access public
	*/
	public function Connect () {
		
		/*if ($this->HostName == NULL | $this->User == NULL | $this->Password == NULL | $this->DatabaseName == NULL) {
			$this->HostName = $GLOBALS['credentaillogonarray'][0];
			$this->User = $GLOBALS['credentaillogonarray'][1];
			$this->Password = $GLOBALS['credentaillogonarray'][2];
			$this->DatabaseName = $GLOBALS['credentaillogonarray'][3];
		}*/
		
		if ($this->HostName == NULL | $this->User == NULL | $this->Password == NULL | $this->DatabaseName == NULL) {
			throw new Exception('HostName, User, Password, and DatabaseName none of them can be NULL!');
			return FALSE;
		}
		
		try {
			$this->Link = @mysql_connect($this->HostName, $this->User, $this->Password);
			if (!$this->Link) {
				array_push($this->ErrorMessage,'Connect: Could not connect to server');
				return new Exception('Could not connect to server');
			}
		} catch (Exception $E) {
			throw $E;
			return FALSE;
		}
		
		try {
			if ($this->Link) {
				if (!mysql_select_db($this->DatabaseName, $this->Link)) {
					array_push($this->ErrorMessage,'Connect: Could not select database');
					throw new Exception('Could not select database');
					return FALSE;
				}
			}
		} catch (Exception $E) {
			throw $E;
			return FALSE;
		}
	}

	/**
	 * Disconnect
	 * Disconnects from current database.
	 *
	 * @access public
	*/
	public function Disconnect () {
		if ($this->Link) {
			if (mysql_close($this->Link) === TRUE) {
				return $this;
			} else {
				array_push($this->ErrorMessage,'Disconnect: Could not disconnect from server');
				return new Exception('Could not disconnect from server');
			}
		} else {
			array_push($this->ErrorMessage,'Disconnect: Link is not set!');
			//return new Exception('Link is not set!');
			return FALSE;
		}
	}
	
	/**
	 * checkDatabaseName
	 * Check to see if database name exists.
	 *
	 * @return Database Name or BOOL FALSE if the database name does not exist.
	 * @access protected
	*/
	protected function checkDatabaseName (){
		$this->Connect();
		$Results = mysql_list_dbs($this->Link);
		$i = 0;
		while (mysql_db_name($Results, $i)){
			$Temp = mysql_db_name($Results, $i);
			if ($Temp == $this->DatabaseName) {
				return $Temp;
			}
			$i++;
		}
		array_push($this->ErrorMessage,'checkDatabaseName: Database Name does not exist');
		return FALSE;
	}
	
	/**
	 * checkTableName
	 * Check to see if database table exists.
	 *
	 * @return Database Table Name or BOOL FALSE if the table name does not exist.
	 * @access protected
	*/
	protected function checkTableName () {
		$TableName = $this->DatabaseTable;
		if ($this->TableNames === NULL) {
			$this->Connect();

			$Query = 'SHOW TABLES FROM `' . $this->DatabaseName . '`';
			$Result = mysql_query($Query);

			$this->TableNames = Array();

			while ($CurrentTableName = mysql_fetch_array($Result, MYSQL_NUM)) {
				array_push($this->TableNames, $CurrentTableName[0]);
			}

			$this->Disconnect();

		}

		foreach ($this->TableNames as $Key => $Value) {
			if ($Value === $TableName) {
				return $TableName;
			}
		}
		return FALSE;
	}
	
	/**
	 * checkPermissions
	 * Check to see if database table exists.
	 *
	 * @param string $Permission String of permissions to check for. Must be a string.
	 * @return BOOL TRUE if the permissions exists or permissions are set to ALL or BOOL FALSE if the permissions have been denied.
	 * @access protected
	*/
	protected function checkPermissions ($Permission) {
		$this->Connect();
		$Query = 'SHOW GRANTS';
		$Result = mysql_query($Query);
		$UserData = mysql_result($Result, 1);
		$UserData2 = mysql_result($Result, 0);
		$UserData = substr_replace($UserData, NULL, 0, 5);
		if (strpos($UserData, $Permission)) {
			return TRUE;
		} else if (strpos($UserData2, 'ALL PRIVILEGES ON')){
			return TRUE;
		} else {
			array_push($this->ErrorMessage,'checkPermissions: Permission has been denied');
			return FALSE;
		}
	}
	
	/**
	 * checkField
	 * Check to see if database field exists.
	 *
	 * @param string $Field String of Field Name to be checked. Must be a string.
	 * @return Field Name if the field exists BOOL FALSE if the field not exist.
	 * @access protected
	*/
	protected function checkField ($Field) {
		$this->Connect();
		$Query = 'SHOW COLUMNS FROM `' . $this->DatabaseTable . '` LIKE "' . $Field . '" ';
		$Result = mysql_query($Query);
		$UserData = mysql_result($Result, 0);
		if (!$UserData) {
			return FALSE;
		} else {
			if ($UserData == $Field) {
				return $UserData;
			} else {
				array_push($this->ErrorMessage,'checkField: Field does not exist');
				return FALSE;
			}
		}
	}

	/**
	 * createDatabase
	 * Creates current database.
	 *
	 * @access public
	*/
	public function createDatabase () {
		$DatabaseNameCheck = $this->checkDatabaseName();
		$PermissionsCheck = $this->checkPermissions ('CREATE');

		if (!$DatabaseNameCheck) {
			if ($PermissionsCheck) {
				$Query = 'CREATE DATABASE ' . $this->DatabaseName .'';
				$Result = mysql_query($Query);
			} else {
				array_push($this->ErrorMessage,'createDatabase: Permission has been denied!');
			}
		} else {
			array_push($this->ErrorMessage,'createDatabase: Database name exists!');
		}
	}

	/**
	 * deleteDatabase
	 * Deletes current database.
	 *
	 * @access public
	*/
	public function deleteDatabase (){
		$DatabaseNameCheck = $this->checkDatabaseName();
		$PermissionsCheck = $this->checkPermissions('DROP');

		if ($DatabaseNameCheck) {
			if ($PermissionsCheck) {
				$Query = 'DROP DATABASE ' . $this->DatabaseName .'';
				$Result = mysql_query($Query);
			} else {
				array_push($this->ErrorMessage,'deleteDatabase: Permission has been denied!');
			}
		} else {
			array_push($this->ErrorMessage,'deleteDatabase: Database name does not exist!');
		}
	}

	/**
	 * createTable
	 *
	 * Create a table using TableString.
	 *
	 * @param string $TableString SQL Query to create table minus the 'CREATE TABLE'. Must be a string.
	 * @access public
	*/
	public function createTable ($TableString) {
		$DatabaseNameCheck = $this->checkDatabaseName();
		$TableNameCheck = $this->checkTableName();
		$PermissionsCheck = $this->checkPermissions ('CREATE');

		if ($DatabaseNameCheck) {
			if ($PermissionsCheck) {
				if (!$TableNameCheck) {
					if (!is_array($TableString)) {
						if ($TableString != NULL) {
							$Query = 'CREATE TABLE ' . $this->DatabaseTable . ' ( ' . $TableString . ' ); ';
							$Result = mysql_query($Query);
						} else {
							array_push($this->ErrorMessage,'createTable: Table String cannot be NULL!');
						}
					} else {
						array_push($this->ErrorMessage,'createTable: Table String cannot be an Array!');
					}
				} else {
					array_push($this->ErrorMessage,'createTable: Table name exists!');
				}
			} else {
				array_push($this->ErrorMessage,'createTable: Permission has been denied!');
			}
		} else {
			array_push($this->ErrorMessage,'createTable: Database name does not exist!');
		}
	}

	/**
	 * updateTable
	 *
	 * Updates a table using TableString.
	 *
	 * @param string $TableString SQL query to update the table. Tablestring comes after 'SET'. Must be a string.
	 * @access public
	*/
	public function updateTable ($TableString) {
		$DatabaseNameCheck = $this->checkDatabaseName();
		$TableNameCheck = $this->checkTableName();
		$PermissionsCheck = $this->checkPermissions ('UPDATE');
		if ($DatabaseNameCheck) {
			if ($PermissionsCheck) {
				if ($TableNameCheck) {
					if ($TableString != NULL) {
						if (!is_array($TableString)) {
							$Query = 'UPDATE `'  . $this->DatabaseTable . '` SET ' . $TableString . '; ';
							$Result = mysql_query($Query);
						} else {
							while (isset($TableString[key($TableString)])) {
								$Query = 'UPDATE `'  . $this->DatabaseTable . '` SET ' . current($TableString) . '; ';
								$Result = mysql_query($Query);
								next($TableString);
							}
						}
					} else {
						array_push($this->ErrorMessage,'updateTable: Table string cannot be NULL!');
					}
				} else {
					array_push($this->ErrorMessage,'updateTable: Table name does not exist!');
				}
			} else {
				array_push($this->ErrorMessage,'updateTable: Permission has been denied!');
			}
		} else {
			array_push($this->ErrorMessage,'updateTable: Database name does not exist!');
		}
	}

	/**
	 * deleteTable
	 * Deletes the current table.
	 *
	 * @access public
	*/
	public function deleteTable () {
		$DatabaseNameCheck = $this->checkDatabaseName();
		$TableNameCheck = $this->checkTableName();
		$PermissionsCheck = $this->checkPermissions ('CREATE');

		if ($DatabaseNameCheck) {
			if ($PermissionsCheck) {
				if ($TableNameCheck) {
					$Query = 'DROP TABLE ' . $this->DatabaseTable . '';
					$Result = mysql_query($Query);
				} else {
					array_push($this->ErrorMessage,'deleteTable: Table name does not exist!');
				}
			} else {
				array_push($this->ErrorMessage,'deleteTable: Permission has been denied!');
			}
		} else {
			array_push($this->ErrorMessage,'deleteTable: Database name does not exist!');
		}
	}

	/**
	 * createRow
	 *
	 * Creates a new row from RowName and RowValue. Rowname and rowvalue can be a string or an array but must be the same type for each!
	 *
	 * @param string $RowName Name of the row to create. Must be a string or an array of strings.
	 * @param string $RowValue Value of the row to create. Must be a string or an array of strings.
	 * @access public
	*/
	public function createRow ($RowName, $RowValue) {
		$DatabaseNameCheck = $this->checkDatabaseName();
		$TableNameCheck = $this->checkTableName();
		$PermissionsCheck = $this->checkPermissions ('INSERT');
		
		$InsertRow = NULL;
		$InsertRowValue = NULL;
		if ($DatabaseNameCheck) {
			if ($PermissionsCheck) {
				if ($TableNameCheck) {
					if (is_array($RowName[0])) {
						if (is_array($RowValue[0])) {
							if ($RowName != NULL) {
								if ($RowValue != NULL) {
									while (isset($RowName[key($RowName)])) {
										while(current($RowName[key($RowName)])) {
											$InsertRow .= "`";
											$InsertRow .= mysql_real_escape_string(current($RowName[key($RowName)]));
											$InsertRow .= "`";

											if (is_null(current($RowValue[key($RowValue)]))) {
												$InsertRowValue .= 'NULL';
											} else {
												$InsertRowValue .= "'";
												$InsertRowValue .= mysql_real_escape_string(current($RowValue[key($RowValue)]));
												$InsertRowValue .= "'";
											}

											next($RowName[key($RowName)]);
											next($RowValue[key($RowValue)]);
											if (current($RowName[key($RowName)])) {
												$InsertRow .= ' , ';
												$InsertRowValue .= ' , ';
											}
										}
										$Query = 'INSERT INTO ' . $this->DatabaseTable . ' ( ' . $InsertRow . ') VALUES ( ' . $InsertRowValue . '); ';
										$Result = mysql_query($Query);
										if (!$Result) {
											$Temp = key($RowValue);
											array_push($this->ErrorMessage,"createRow: Row Value [$Temp] exists in the Database!");
										}

										next($RowName);
										next($RowValue);

										$InsertRowValue = NULL;
										$InsertRow = NULL;
									}
								} else {
									array_push($this->ErrorMessage,'createRow: Row Value cannot be NULL!');
								}
							} else {
								array_push($this->ErrorMessage,'createRow: Row Name cannot be NULL!');
							}
						} else if (is_array($RowValue)){
							array_push($this->ErrorMessage,'createRow: Row Name is a 3 dimmensional Array but Row Value must be an Array!');
						} else {
							array_push($this->ErrorMessage,'createRow: Row Name is a 3 Dimmensional Array but Row Value must be a 3 Dimmensional Array!');
						}
					} else if (is_array($RowValue[0])) {
						array_push($this->ErrorMessage,'createRow: Row Value is a 3 Dimmensional Array but Row Name must be a 3 Dimmensional Array!');
					} else if (is_array($RowName)) {
						if (is_array($RowValue)) {
							if ($RowName != NULL) {
								if ($RowValue != NULL) {
									while (isset($RowName[key($RowName)])) {
										$InsertRow .= "`";
										$InsertRow .= mysql_real_escape_string(current($RowName));
										$InsertRow .= "`";

										if (is_null(current($RowValue))) {
											$InsertRowValue .= 'NULL';
										} else {
											$InsertRowValue .= "'";
											$InsertRowValue .= mysql_real_escape_string(current($RowValue));
											$InsertRowValue .= "'";
										}

										next($RowName);
										next($RowValue);
										if (current($RowName)) {
											$InsertRow .= ' , ';
											$InsertRowValue .= ' , ';
										}
									}
									
									$Query = 'INSERT INTO ' . $this->DatabaseTable . ' ( ' . $InsertRow . ') VALUES ( ' . $InsertRowValue . '); ';
									
									$Result = mysql_query($Query);
									
									if (!$Result) {
										array_push($this->ErrorMessage,'createRow: Row Value exists in the Database!');
									}
								} else {
									array_push($this->ErrorMessage,'createRow: Row Value cannot be NULL!');
								}
							} else {
								array_push($this->ErrorMessage,'createRow: Row Name cannot be NULL!');
							}
						} else {
							array_push($this->ErrorMessage,'createRow: Row Value must be an Array!');
						}
					} else {
						array_push($this->ErrorMessage,'createRow: Row Name must be an Array!');
					}
				} else {
					array_push($this->ErrorMessage,'createRow: Table name does not exist!');
				}
			} else {
				array_push($this->ErrorMessage,'createRow: Permission has been denied!');
			}
		} else {
			array_push($this->ErrorMessage,'createRow: Database name does not exist!');
		}
	}

	/**
	 * updateRow
	 *
	 * Updates a row from RowName and RowValue with RowNumberName and RowNumber. Rowname and rowvalue can be a string or an array but
	 * must be the same type for each! RowNumberName and RowNumber can be a string or an array but must be the same type for each. Mixing
	 * arrays and strings for all past values are not permitted!
	 *
	 * @param string $RowName Name of the row to update. Must be a string or an array of strings.
	 * @param string $RowValue Value of the row to update. Must be a string or an array of strings.
	 * @param string $RowNumberName Name of the row to update with. Must be a string or an array of strings.
	 * @param string $RowNumber Value of the row to update with. Must be a string or an array of strings.
	 * @access public
	*/
	public function updateRow ($RowName, $RowValue, $RowNumberName, $RowNumber) {
		$DatabaseNameCheck = $this->checkDatabaseName();
		$TableNameCheck = $this->checkTableName();
		$PermissionsCheck = $this->checkPermissions ('UPDATE');

		if ($DatabaseNameCheck) {
			if ($PermissionsCheck) {
				if ($TableNameCheck) {
					if (!is_array($RowName)) {
						if (!is_array($RowValue)) {
							if (!is_array($RowNumberName)) {
								if (!is_array($RowNumber)) {
									if ($RowName != NULL) {
										if ($RowValue != NULL) {
											if ($RowNumberName != NULL) {
												if ($RowNumber != NULL) {
													$RowNumber = mysql_real_escape_string($RowNumber);
													$Query = 'UPDATE `'  . $this->DatabaseTable . '` SET `' . $RowName . '` = \'' . $RowValue . '\' WHERE `' . $RowNumberName .'` = "' . $RowNumber . '" ';
													$Result = mysql_query($Query);
												} else {
													array_push($this->ErrorMessage,'updateRow: Row Number cannot be NULL!');
												}
											} else {
												array_push($this->ErrorMessage,'updateRow: Row Number Name cannot be NULL!');
											}
										} else {
											array_push($this->ErrorMessage,'updateRow: Row Value cannot be NULL!');
										}
									} else {
										array_push($this->ErrorMessage,'updateRow: Row Name cannot be NULL!');
									}
								} else {
									array_push($this->ErrorMessage,'updateRow: Row Name is not an Array, Row Value is not an Array, Row Number Name is not an Array so Row Number cannot be an Array!');
								}
							} else {
								array_push($this->ErrorMessage,'updateRow: Row Name is not an Array, Row Value is not an Array so Row Number Name cannot be an Array!');
							}
						} else {
							array_push($this->ErrorMessage, 'updateRow: Row Name is not an Array so Row Value cannot be an Array!');
						}
					} else {
						if (is_array($RowValue)){
							if (is_array($RowNumberName)) {
								if (is_array($RowNumber)) {
									while (isset($RowName[key($RowName)])) {
										if (is_array($RowNumberName[key($RowNumberName)]) || is_array($RowNumber[key($RowNumber)])) {
											$NameArray = $RowNumberName[key($RowNumberName)];
											$ValueArray = $RowNumber[key($RowNumber)];
											reset($NameArray);
											reset($ValueArray);
											$String = NULL;
											while (isset($NameArray[key($NameArray)])) {
												$String .= '`';
												$String .= mysql_real_escape_string(current($NameArray));
												$String .= '` = \'';
												$String .= mysql_real_escape_string(current($ValueArray));
												$String .= '\'';
												next($NameArray);
												next($ValueArray);
												if (isset($NameArray[key($NameArray)])) {
													$String .= ' AND ';
												}
											}
											$RowValuestring = NULL;
											$RowValuestring = current($RowValue);
											$RowValuestring = mysql_real_escape_string($RowValuestring);
											if ($RowValuestring) {
												$Query = 'UPDATE `'  . $this->DatabaseTable . '` SET `' . current($RowName) . '` = \'' . $RowValuestring . '\' WHERE ' . $String . ' ';
											} else {
												$Query = 'UPDATE `'  . $this->DatabaseTable . '` SET `' . current($RowName) . '` = NULL WHERE ' . $String . ' ';
											}

											$Result = mysql_query($Query);
										} else {
											$RowNumberstring = NULL;
											$RowNumberstring = mysql_real_escape_string(current($RowNumber));
											$RowNumberNamestring = NULL;
											$RowNumberNamestring = mysql_real_escape_string(current($RowNumberName));
											$RowNamestring = NULL;
											$RowNamestring = mysql_real_escape_string(current($RowName));
											$RowValuestring = NULL;
											$RowValuestring = mysql_real_escape_string(current($RowValue));
											if ($RowValuestring) {
												$Query = 'UPDATE `'  . $this->DatabaseTable . '` SET `' . $RowNamestring . '` = \'' . $RowValuestring . '\' WHERE `' . $RowNumberNamestring .'` = "' . $RowNumberstring . '" ';
											} else {
												$Query = 'UPDATE `'  . $this->DatabaseTable . '` SET `' . $RowNamestring . '` = NULL WHERE `' . $RowNumberNamestring .'` = "' . $RowNumberstring . '" ';
											}
											$Result = mysql_query($Query);
										}
										next($RowName);
										next($RowValue);
										if (!next($RowNumberName)) {
											reset($RowNumberName);
										}
										if (!next($RowNumber)) {
											reset($RowNumber);
										}
									}

								} else {
									array_push($this->ErrorMessage,'updateRow: Row Name is an Array, Row Value is an Array, Row Number Name is an Array and Row Number must be an Array!');
								}
							} else {
								array_push($this->ErrorMessage,'updateRow: Row Name is an Array, Row Value is an Array and Row Number Name must be an Array!');
							}
						} else {
							array_push($this->ErrorMessage,'updateRow: Row Name is an Array and Row Value must be an Array!');
						}
					}
				} else {
					array_push($this->ErrorMessage,'updateRow: Table name does not exist!');
				}
			} else {
				array_push($this->ErrorMessage,'updateRow: Permission has been denied!');
			}
		} else {
			array_push($this->ErrorMessage,'updateRow: Database name does not exist!');
		}
	}

	/**
	 * deleteRow
	 *
	 * Deletes a row from RowName and RowValue. RowName and RowValue can be a string or an array but must be the same type for each!
	 *
	 * @param string $RowName Name of the row to delete. Must be a string or an array of strings.
	 * @param string $RowValue Value of the row to delete. Must be a string or an array of strings.
	 * @access public
	*/
	public function deleteRow ($RowName, $RowValue) {
		$DatabaseNameCheck = $this->checkDatabaseName();
		$TableNameCheck = $this->checkTableName();
		$PermissionsCheck = $this->checkPermissions ('DELETE');

		if ($DatabaseNameCheck) {
			if ($PermissionsCheck) {
				if ($TableNameCheck) {
					if (!is_array($RowName)) {
						if (!is_array($RowValue)) {
							if ($RowName != NULL) {
								if ($RowValue != NULL) {
									$Query = 'DELETE FROM ' . $this->DatabaseTable . ' WHERE ' . $RowName . ' = ' . $RowValue . '';
									$Result = mysql_query($Query);
								} else {
									array_push($this->ErrorMessage,'deleteRow: Row Name has a value but Row Value cannot be NULL!');
								}
							} else {
								if ($RowValue == NULL) {
									$Query = 'DELETE FROM ' . $this->DatabaseTable . ' ';
									$Result = mysql_query($Query);
								} else {
									array_push($this->ErrorMessage,'deleteRow: Row Name is NULL but Row Value cannot have a value!');
								}
							}
						} else {
							array_push($this->ErrorMessage,'deleteRow: Row Value cannot be an Array!');
						}
					} else {
						if (is_array($RowValue)) {
							if ($RowName != NULL) {
								if ($RowValue != NULL) {
									while (isset($RowName[key($RowName)])) {
										$Query = 'DELETE FROM ' . $this->DatabaseTable . ' WHERE ' . current($RowName) . ' = ' . current($RowValue) . '';
										$Result = mysql_query($Query);
										next($RowName);
										next($RowValue);
									}
								} else {
									array_push($this->ErrorMessage,'deleteRow: Row Name is an array and has a value. Row Value is an array but cannot be NULL!');
								}
							} else {
								if ($RowValue == NULL) {
									$Query = 'DELETE FROM ' . $this->DatabaseTable . ' ';
									$Result = mysql_query($Query);
								} else {
									array_push($this->ErrorMessage,'deleteRow: Row Name is an array and is NULL but Row Value is an array but cannot have a value!');
								}
							}
						}
					}
				} else {
					array_push($this->ErrorMessage,'deleteRow: Table name does not exist!');
				}
			} else {
				array_push($this->ErrorMessage,'deleteRow: Permission has been denied!');
			}
		} else {
			array_push($this->ErrorMessage,'deleteRow: Database name does not exist!');
		}
	}

	/**
	 * createField
	 *
	 * Creates a new field from fieldstring. Fieldstring can be a string or an array. Fieldflag and fieldflagcolumn can be null. They
	 * are used to set attributes for a new field.
	 *
	 * @param string $FieldString Name of the field to create. Must be a string or an array of strings.
	 * @param string $FieldFlag Specify which field flag to be used. Must be any one of these values:
	 *		- FIRST - Specifies if the field is to be the first column of the table.
	 *		- AFTER - Specifies that the field is to be after fieldflagcolumn.
	 * @param string $FieldFlagColumn Used only when fieldflag is set to AFTER. Specify which field fieldstring is after.
	 * @access public
	*/
	public function createField ($FieldString, $FieldFlag, $FieldFlagColumn) {
		$DatabaseNameCheck = $this->checkDatabaseName();
		$TableNameCheck = $this->checkTableName();
		$PermissionsCheck = $this->checkPermissions ('ALTER');

		if ($DatabaseNameCheck) {
			if ($PermissionsCheck) {
				if ($TableNameCheck) {
					if (!is_array($FieldString)) {
						if (!is_array($FieldFlag)) {
							if (!is_array($FieldFlagColumn)) {
								if ($FieldString != NULL) {
									if ($FieldFlag != NULL) {
										if ($FieldFlag == 'FIRST') {
											if ($FieldFlagColumn == NULL) {
												$Query = 'ALTER TABLE `' . $this->DatabaseTable . '` ADD ' . $FieldString . ' FIRST; ';
												$Result = mysql_query($Query);
												if (!$Result) {
													array_push($this->ErrorMessage,"createField: FIRST: Field String exists in the Database!");
												}
											} else {
												array_push($this->ErrorMessage,'createField: Field Flag has been set to FIRST and Field Flag Column has to be NULL!');
											}
										} else if ($FieldFlag == 'AFTER') {
											if ($FieldFlagColumn != NULL) {
												$Query = 'ALTER TABLE `' . $this->DatabaseTable . '` ADD ' . $FieldString . ' AFTER `' . $FieldFlagColumn .'` ; ';
												$Result = mysql_query($Query);
												if (!$Result) {
													array_push($this->ErrorMessage,"createField: AFTER: Field String exists in the Database!");
												}
											} else {
												array_push($this->ErrorMessage,'createField: Field Flag has been set to AFTER and Field Flag Column cannot be NULL!');
											}
										} else {
											array_push($this->ErrorMessage,'createField: Field Flag can only be FIRST or AFTER');
										}
									} else {
										$Query = 'ALTER TABLE `' . $this->DatabaseTable . '` ADD ' . $FieldString . ' ; ';
										$Result = mysql_query($Query);
										if (!$Result) {
											array_push($this->ErrorMessage,"createField: Field String exists in the Database!");
										}
									}
								} else {
									array_push($this->ErrorMessage,'createField: Field String cannot be NULL!');
								}
							} else {

								array_push($this->ErrorMessage,'createField: Field Flag Column cannot be an Array!');
							}
						} else {
							array_push($this->ErrorMessage,'createField: Field Flag cannot be an Array!');
						}
					} else {
						if (is_array($FieldFlag)) {
							if (is_array($FieldFlagColumn)) {
								if ($FieldString != NULL) {
									while (current($FieldString)) {
										if ($FieldFlag != NULL) {
											if (current($FieldFlag) == 'FIRST') {
												if (current($FieldFlagColumn) == NULL) {
													$Query = 'ALTER TABLE `' . $this->DatabaseTable . '` ADD ' . current($FieldString) . ' FIRST; ';
													$Result = mysql_query($Query);
													if (!$Result) {
														$Temp = key($FieldString);
														array_push($this->ErrorMessage,"createField: FIRST: Field String [$Temp] exists in the Database!");
													}
												} else {
													array_push($this->ErrorMessage,"createField: Field Flag [current($FieldFlag)] has been set to FIRST and Field Flag Column [current($FieldFlagColumn)]has to be NULL!");
												}
											} else if (current($FieldFlag) == 'AFTER') {
												if ($FieldFlagColumn != NULL) {
													$Query = 'ALTER TABLE `' . $this->DatabaseTable . '` ADD ' . current($FieldString) . ' AFTER `' . current($FieldFlagColumn) .'` ; ';
													$Result = mysql_query($Query);
													if (!$Result) {
														$Temp = key($FieldString);
														array_push($this->ErrorMessage,"createField: AFTER: Field String [$Temp] and Field Flag Column [$Temp] exists in the Database!");
													}
												} else {
													array_push($this->ErrorMessage,'createField: Field Flag [current($FieldFlag)] has been set to AFTER and Field Flag Column [current($FieldFlagColumn)] cannot be NULL!');
												}
											} else {
												array_push($this->ErrorMessage,'createField: Field Flag [current($FieldFlag)] can only be FIRST or AFTER');
											}
										} else {
											$Query = 'ALTER TABLE `' . $this->DatabaseTable . '` ADD ' . current($FieldString) . ' ; ';
											$Result = mysql_query($Query);
											if (!$Result) {
												$Temp = key($FieldString);
												array_push($this->ErrorMessage,"createField: Field String [$Temp] exists in the Database!");
											}
										}
										next($FieldString);
										next($FieldFlag);
										next($FieldFlagColumn);
									}
								} else {
									array_push($this->ErrorMessage,'createField: Field String cannot be NULL!');
								}
							} else {
								array_push($this->ErrorMessage,'createField: Field String is an Array. Field Flag is an Array so Field Flag Column must be an Array!');
							}
						} else {
							array_push($this->ErrorMessage,'createField: Field String is an Array so Field Flag must be an Array!');
						}
					}
				} else {
					array_push($this->ErrorMessage,'createField: Table name does not exist!');
				}
			} else {
				array_push($this->ErrorMessage,'createField: Permission has been denied!');
			}
		} else {
			array_push($this->ErrorMessage,'createField: Database name does not exist!');
		}
	}

	/**
	 * updateField
	 *
	 * Updates a field from field and fieldchange. Field and fieldchange can be a string or an array but must be the same type for each!
	 *
	 * @param string $Field Name of the field to change. Must be a string or an array of strings.
	 * @param string $FieldChange Value of the field to change. Must be a string or an array of strings.
	 * @access public
	*/
	public function updateField ($Field, $FieldChange) {
		$DatabaseNameCheck = $this->checkDatabaseName();
		$TableNameCheck = $this->checkTableName();
		$PermissionsCheck = $this->checkPermissions ('ALTER');
		$FieldCheck = $this->checkField($Field);
		$FieldCheck2 = $this->checkField($FieldChange);

		if ($DatabaseNameCheck) {
			if ($PermissionsCheck) {
				if ($TableNameCheck) {
					if (!is_array($Field)) {
						if ($Field != NULL) {
							if ($FieldCheck) {
								if (!is_array($FieldChange)) {
									if ($FieldChange != NULL) {
										if (!$FieldCheck2) {
											$Type = NULL;

											$Query = "SHOW COLUMNS FROM `$this->DatabaseTable` LIKE '$Field';";
											$Result = mysql_query($Query);
											$FieldValue = mysql_fetch_array($Result, MYSQL_ASSOC);
											unset($FieldValue['Field']);

											if ($FieldValue['Type']) {
												$Type = $FieldValue['Type'];
												unset($FieldValue['Type']);
											}

											if ($FieldValue['Key'] == NULL) {
												unset($FieldValue['Key']);
											}

											if ($FieldValue['Extra'] == NULL) {
												unset($FieldValue['Extra']);
											}

											if ($Type){
												$Type = strtoupper($Type);
												$ChangeString .= $Type;
												$ChangeString .= ' ';
											} else {
												$ChangeString .= 'NULL ';
											}
											reset($FieldValue);
											while (key($FieldValue)){
												if (key($FieldValue) == 'Null') {
													if (current($FieldValue)) {
														$ChangeString .= "current($FieldValue) ";
													} else {
														$ChangeString .= 'NOT NULL ';
													}
												} else {
													$Hold = key($FieldValue);
													$ChangeString .= "$Hold ";
													$Hold = current($FieldValue);
													$ChangeString .= "'$Hold' ";
												}
												next($FieldValue);
											}
											$Query2 = 'ALTER TABLE `' . $this->DatabaseTable . '` CHANGE `' . $Field .'` `' . $FieldChange . '` ' . $ChangeString . ' ;';
											$Result2 = mysql_query($Query2);
										} else {
											array_push($this->ErrorMessage,'updateField: Field Change - Field name exists!');
										}
									} else {
										array_push($this->ErrorMessage,'updateField: Field Change cannot be NULL!');
									}
								} else {

									array_push($this->ErrorMessage,'updateField: Field Change cannot be an Array!');
								}

							} else {
								array_push($this->ErrorMessage,'updateField: Field name does not exist!');
							}
						} else {
							array_push($this->ErrorMessage,'updateField: Field cannot be NULL!');
						}
					} else {
						if ($Field != NULL) {
							while (isset($Field[key($Field)])) {
								$FieldCheck = $this->checkField(current($Field));
								$FieldCheck2 = $this->checkField(current($FieldChange));
								if ($FieldCheck) {
									if (is_array($FieldChange)) {
										if ($FieldChange != NULL) {
											if (!$FieldCheck2) {
												$Type = NULL;
												$Helper = current($Field);
												$Query = "SHOW COLUMNS FROM `$this->DatabaseTable` LIKE '$Helper';";
												$Result = mysql_query($Query);
												$FieldValue = mysql_fetch_array($Result, MYSQL_ASSOC);
												unset($FieldValue['Field']);

												if ($FieldValue['Type']) {
													$Type = $FieldValue['Type'];
													unset($FieldValue['Type']);
												}

												if ($FieldValue['Key'] == NULL) {
													unset($FieldValue['Key']);
												}

												if ($FieldValue['Extra'] == NULL) {
													unset($FieldValue['Extra']);
												}

												if ($Type){
													$Type = strtoupper($Type);
													$ChangeString .= $Type;
													$ChangeString .= ' ';
												} else {
													$ChangeString .= 'NULL ';
												}
												reset($FieldValue);
												while (key($FieldValue)){
													if (key($FieldValue) == 'Null') {
														if (current($FieldValue)) {
															$ChangeString .= "current($FieldValue) ";
														} else {
															$ChangeString .= 'NOT NULL ';
														}
													} else {
														$Hold = key($FieldValue);
														$ChangeString .= "$Hold ";
														$Hold = current($FieldValue);
														$ChangeString .= "'$Hold' ";
													}
													next($FieldValue);
												}
												$Query2 = 'ALTER TABLE `' . $this->DatabaseTable . '` CHANGE `' . current($Field) .'` `' . current($FieldChange) . '` ' . $ChangeString . ' ;';
												$Result2 = mysql_query($Query2);
											} else {
												$Temp = key($FieldChange);
												array_push($this->ErrorMessage,"updateField: Field is an Array and Field Change [$Temp] - Field name exists!");
											}
										} else {
											array_push($this->ErrorMessage,'updateField: Field is an Array so Field Change cannot be NULL!');
										}
									} else {
										array_push($this->ErrorMessage,'updateField: Field is an Array so Field Change must be an Array!');
									}
								} else {
									$Temp = key($Field);
									array_push($this->ErrorMessage,"updateField: Field [$Temp] is an Array and Field name does not exist!");
								}
								next($Field);
								next($FieldChange);
							}
						} else {
							array_push($this->ErrorMessage,'updateField: Field is an Array and cannot be NULL!');
						}
					}
				} else {
					array_push($this->ErrorMessage,'updateField: Table name does not exist!');
				}
			} else {
				array_push($this->ErrorMessage,'updateField: Permission has been denied!');
			}
		} else {
			array_push($this->ErrorMessage,'updateField: Database name does not exist!');
		}
	}

	/**
	 * deleteField
	 *
	 * Deletes a field from field. Field can be a string or an array.
	 *
	 * @param string $Field Name of the field to delete. Must be a string or an array of strings.
	 * @access public
	*/
	public function deleteField ($Field) {
		$DatabaseNameCheck = $this->checkDatabaseName();
		$TableNameCheck = $this->checkTableName();
		$PermissionsCheck = $this->checkPermissions ('ALTER');
		$FieldCheck = $this->checkField($Field);

		if ($DatabaseNameCheck) {
			if ($PermissionsCheck) {
				if ($TableNameCheck) {
					if (!is_array($Field)) {
						if ($Field != NULL) {
							if ($FieldCheck) {
								$Query = 'ALTER TABLE `' . $this->DatabaseTable . '` DROP `' . $Field . '` ; ';
								$Result = mysql_query($Query);
							} else {
								array_push($this->ErrorMessage,'deleteField: Field does not exist!');
							}
						} else {
							array_push($this->ErrorMessage,'deleteField: Field cannot be NULL!');
						}
					} else {
						if ($Field != NULL) {
							while (isset($Field[key($Field)])) {
								$FieldCheck = $this->checkField(current($Field));
								if ($FieldCheck) {
									$Query = 'ALTER TABLE `' . $this->DatabaseTable . '` DROP `' . current($Field) . '` ; ';
									$Result = mysql_query($Query);
									next($Field);
								} else {
									array_push($this->ErrorMessage,'deleteField: Field is an Array but does not exist!');
								}
							}
						} else {
							array_push($this->ErrorMessage,'deleteField: Field is an Array but cannot be NULL!');
						}
					}
				} else {
					array_push($this->ErrorMessage,'deleteField: Table name does not exist!');
				}
			} else {
				array_push($this->ErrorMessage,'deleteField: Permission has been denied!');
			}
		} else {
			array_push($this->ErrorMessage,'deleteField: Database name does not exist!');
		}

	}
	
	/**
	 * emptyTable
	 * Empties current database table.
	 *
	 * @access public
	*/
	public function emptyTable() {
		$Query = 'TRUNCATE TABLE `' . $this->DatabaseTable . '` ; ';
		$Result = mysql_query($Query);
	}
	
	/**
	 * executeSQlCommand
	 *
	 * Executes a direct SQL Command.
	 *
	 * @param string $SQLCommand a string with the SQL Command to be executed. Must be a string NO ARRAYS ARE ALLOWED.
	 * @access public
	*/
	public function executeSQlCommand ($SQLCommand) {
		if (!is_null($SQLCommand)) {
			$this->Connect();
			$Result = mysql_query($SQLCommand);
			$this->Disconnect();
		}
	}
	
	/**
	 * sortTable
	 *
	 * Executes a direct SQL Command to sort out table from Sort Order.
	 *
	 * @param string $SortOrder a string or an array listing the Sort Order for the database table. Must be a string or an array.
	 * @access public
	*/
	public function sortTable($SortOrder) {
		$DatabaseNameCheck = $this->checkDatabaseName();
		$TableNameCheck = $this->checkTableName();
		$PermissionsCheck = $this->checkPermissions ('ALTER');
		if (!is_array($SortOrder)) {
			$FieldCheck = $this->checkField($SortOrder);
		}
		if ($DatabaseNameCheck) {
			if ($PermissionsCheck) {
				if ($TableNameCheck) {
					if (!is_array($SortOrder)) {
						if ($SortOrder != NULL) {
							if ($FieldCheck) {
								$Query = 'ALTER TABLE `' . $this->DatabaseTable . '` ORDER BY `' . $SortOrder . '` ; ';
								$Result = mysql_query($Query);
							} else {
								array_push($this->ErrorMessage,'sortTable: Field does not exist!');
							}
						} else {
							array_push($this->ErrorMessage,'sortTable: Field cannot be NULL!');
						}
					} else {
						if ($SortOrder != NULL) {
							$String = NULL;
							reset($SortOrder);
							while (isset($SortOrder[key($SortOrder)])) {
								$FieldCheck = $this->checkField(current($SortOrder));
								if ($FieldCheck) {
									$String .= '`';
									$String .= current($SortOrder);
									$String .= '`';
									next($SortOrder);
									if (current($SortOrder)) {
										$String .= ', ';
									}
								} else {
									array_push($this->ErrorMessage,'sortTable: Field is an Array but does not exist!');
								}
							}
							if ($String != NULL) {
								$Query = 'ALTER TABLE `' . $this->DatabaseTable . '` ORDER BY ' . $String . ' ; ';
								$Result = mysql_query($Query);
							}
						} else {
							array_push($this->ErrorMessage,'sortTable: Field is an Array but cannot be NULL!');
						}
					}
				} else {
					array_push($this->ErrorMessage,'sortTable: Table name does not exist!');
				}
			} else {
				array_push($this->ErrorMessage,'sortTable: Permission has been denied!');
			}
		} else {
			array_push($this->ErrorMessage,'sortTable: Database name does not exist!');
		}
	}

	/**
	 * setDatabaseRow
	 *
	 * Executes a SQL query to retrieve the database rows creating a numerical array based on idnumber. Idnumber must be an array!
	 * To get the results, use getRowField(String $rowfield) for a single field in a row and getMultiRowField() for the entire row
	 * or multiple rows depending on the idnumber passed!
	 *
	 * @param array $IDNumber Idnumber for the database query. Must be an array of strings with the key being the name of the field
	 * and the value being value of the field.
	 * @access public
	*/
	public function setDatabaseRow ($IDNumber) {
		$this->IDNumber = $IDNumber;
		if ($this->MultRrowField) {
			$this->MultRrowField = array();
		}

		if (is_array($IDNumber)) {
			while (isset($this->IDNumber[key($this->IDNumber)])) {
				$Temp .= '`';
				$Temp .= key($this->IDNumber);
				$Temp .= '` = "';
				$Temp .= current($this->IDNumber);
				$Temp .= '" ';
				next($this->IDNumber);
				if (isset($this->IDNumber[key($this->IDNumber)])) {
					$Temp .= 'AND ';
				}
			}
			reset($this->IDNumber);
			if ($this->OrderByName && $this->OrderByType) {
				$this->RowQuery = 'SELECT * FROM ' . $this->DatabaseTable . ' WHERE ' . $Temp .' ORDER BY `' . $this->OrderByName . '` ' . $this->OrderByType;
			} else {
				$this->RowQuery = 'SELECT * FROM ' . $this->DatabaseTable . ' WHERE ' . $Temp .' ';
			}

			if ($this->Limit) {
				$this->RowQuery .= ' LIMIT ';
				$this->RowQuery .= $this->Limit;
			}

			$this->RowResult = mysql_query($this->RowQuery);

			if ($this->RowResult) {
				$this->RowField = mysql_fetch_array($this->RowResult, MYSQL_ASSOC);

				array_push($this->MultRrowField, $this->RowField);
				$RowField = mysql_fetch_array($this->RowResult, MYSQL_ASSOC);
				while ($RowField) {
					array_push($this->MultRrowField, $RowField);
					$RowField = mysql_fetch_array($this->RowResult, MYSQL_ASSOC);
				}
			}

		} else {
			array_push($this->ErrorMessage,'setDatabaseRow: Idnumber must be an Array!');
		}
	}

	/**
	 * setEntireTable
	 * Performs a SQL query to get the entire database table. Use getEntireTable() to get the entire table results!
	 *
	 * @access public
	*/
	public function setEntireTable () {
		if ($this->OrderByName && $this->OrderByType) {
			$this->TableQuery = 'SELECT * FROM ' . $this->DatabaseTable . ' ' . 'ORDER BY `' . $this->OrderByName . '` ' . $this->OrderByType;
		} else {
			$this->TableQuery = 'SELECT * FROM ' . $this->DatabaseTable . ' ';
		}
		if ($this->Limit) {
			$this->TableQuery .= ' LIMIT ';
			$this->TableQuery .= $this->Limit;
		}

		$this->TableResult = mysql_query($this->TableQuery);

		if ($this->TableResult) {
			$this->RowNumber = mysql_num_rows($this->TableResult);
			//mysql_data_seek($this->TableResult, 0);
		}

		$this->RowNumber = $this->RowNumber + 0;
		$this->I = 1;
		$this->BuildingEntireTable();
	}
	
	/**
	 * BuildingEntireTable
	 * Creates an array of all data in a database table. This information is stored in EntireTable.
	 *
	 * @access protected
	*/
	protected function BuildingEntireTable(){
		$i = 1;
		if ($this->EntireTable) {
			$this->EntireTable = NULL;
			$this->EntireTable = array();
		}
		while ($i <= $this->RowNumber){
			$this->EntireTable[$i] = mysql_fetch_array($this->TableResult, MYSQL_ASSOC);
			$i++;
		}
	}

	/**
	 * BuildDatabaseRows
	 * Executes a SQL query to retrieve the database rows creating an associative array based on idnumber set from
	 * setIdNumber($IDNumber). Idnumber must be an array. To retrieve the results use getDatabase($rownumber) using
	 * row value as rownumber.
	 *
	 * OPTIONAL - limit:
	 * If limit is set from setLimit, BuildDatabaseRows will impose that limit on the query.
	 *
	 * @access public
	*/
	public function BuildDatabaseRows (){
		if (is_array($this->IDNumber)) {
			while (isset($this->IDNumber[key($this->IDNumber)])) {
				$Temp .= '`';
				$Temp .= key($this->IDNumber);
				$Temp .= '` = "';
				$Temp .= current($this->IDNumber);
				$Temp .= '" ';
				next($this->IDNumber);
				if (isset($this->IDNumber[key($this->IDNumber)])) {
					$Temp .= 'AND ';
				}
			}
			reset($this->IDNumber);
			if ($this->OrderByName && $this->OrderByType) {
				$this->RowQuery = 'SELECT * FROM ' . $this->DatabaseTable . ' WHERE ' . $Temp .' ORDER BY `' . $this->OrderByName . '` ' . $this->OrderByType;
			} else {
				$this->RowQuery = 'SELECT * FROM ' . $this->DatabaseTable . ' WHERE ' . $Temp .' ';
			}

			if ($this->Limit) {
				$this->RowQuery .= ' LIMIT ';
				$this->RowQuery .= $this->Limit;
			}
			$this->RowResult = mysql_query($this->RowQuery);
			if ($this->RowResult) {
				$this->Database = mysql_fetch_assoc($this->RowResult);
			}
		} else {
			array_push($this->ErrorMessage,'setDatabaseRow: Idnumber must be an Array!');
		}
	}
	
	/**
	 * BuildFieldNames
	 * Creates an array of all fields from a database table. This information is stored in RowFieldNames.
	 *
	 * @param string $TableName a string with the name of the table to put into RowFieldNames. Must be a string NO ARRAYS ARE ALLOWED.
	 * @access public
	*/
	public function BuildFieldNames($TableName) {
		if ($TableName) {
			$this->DatabaseTable = $TableName;
		}

		$this->Connect();
		$Query = 'SHOW COLUMNS FROM `' . $this->DatabaseTable . '` ';
		$Result = mysql_query($Query);

		$this->RowFieldNames = array();
		while ($Row = mysql_fetch_array ($Result)) {
			array_push($this->RowFieldNames, $Row['Field']);
			$Row = NULL;
		}
	}

}
?>