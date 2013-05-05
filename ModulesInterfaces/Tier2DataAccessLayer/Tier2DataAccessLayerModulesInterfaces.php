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
 * Interface Tier 2 Data Access Layer Modules
 *
 * Interface Tier 2 Data Access Layer Modules is designed as the main interface for all One Solution CMS Data Access Layer Modules.
 * This is an outline for any module for the Data Access Layer.
 *
 * @author Travis Napolean Smith
 * @copyright Copyright (c) 1999 - 2012 One Solution CMS
 * @copyright PHP - Copyright (c) 2005 - 2012 One Solution CMS
 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
 * @version PHP - 2.1.130
 * @version C++ - Unknown
 */


interface Tier2DataAccessLayerModules
{
	/**
	 * Connect
	 * Connects to current database.
	 *
	 * @access public
	*/
	public function Connect ();

	/**
	 * Disconnect
	 * Disconnects from current database.
	 *
	 * @access public
	*/
	public function Disconnect ();

	/**
	 * createDatabase
	 * Creates current database.
	 *
	 * @access public
	*/
	public function createDatabase();

	/**
	 * deleteDatabase
	 * Deletes current database.
	 *
	 * @access public
	*/
	public function deleteDatabase ();

	// ------------------------------------------
	/**
	 * createTable
	 *
	 * Create a table using TableString.
	 *
	 * @param string $TableString SQL Query to create table minus the 'CREATE TABLE'. Must be a string.
	 * @access public
	*/
	public function createTable ($TableString);

	/**
	 * updateTable
	 *
	 * Updates a table using TableString.
	 *
	 * @param string $TableString SQL query to update the table. Tablestring comes after 'SET'. Must be a string.
	 * @access public
	*/
	public function updateTable ($TableString);

	/**
	 * deleteTable
	 * Deletes the current table.
	 *
	 * @access public
	*/
	public function deleteTable ();

	// ------------------------------------------
	/**
	 * createRow
	 *
	 * Creates a new row from RowName and rowvalue. Rowname and rowvalue can be a string or an array but must be the same type for each!
	 *
	 * @param string $RowName Name of the row to create. Must be a string or an array of strings.
	 * @param string $rowvalue Value of the row to create. Must be a string or an array of strings.
	 * @access public
	*/
	public function createRow ($RowName, $RowValue);

	/**
	 * updateRow
	 *
	 * Updates a row from RowName and RowValue with RowNumberName and RowNumber. RowName and RowValue can be a string or an array but
	 * must be the same type for each! RowNumberName and RowNumber can be a string or an array but must be the same type for each. Mixing
	 * arrays and strings for all past values are not permitted!
	 *
	 * @param string $RowName Name of the row to update. Must be a string or an array of strings.
	 * @param string $RowValue Value of the row to update. Must be a string or an array of strings.
	 * @param string $RowNumberName Name of the row to update with. Must be a string or an array of strings.
	 * @param string $RowNumber Value of the row to update with. Must be a string or an array of strings.
	 * @access public
	*/
	public function updateRow ($RowName, $RowValue, $RowNumberName, $RowNumber);

	/**
	 * deleteRow
	 *
	 * Deletes a row from RowName and RowValue. RowName and RowValue can be a string or an array but must be the same type for each!
	 *
	 * @param string $RowName Name of the row to delete. Must be a string or an array of strings.
	 * @param string $RowValue Value of the row to delete. Must be a string or an array of strings.
	 * @access public
	*/
	public function deleteRow ($RowName, $RowValue);

	/**
	 * createField
	 *
	 * Creates a new field from fieldstring. Fieldstring can be a string or an array. Fieldflag and fieldflagcolumn can be null. They
	 * are used to set attributes for a new field.
	 *
	 * @param string $fieldstring Name of the field to create. Must be a string or an array of strings.
	 * @param string $fieldflag Specify which field flag to be used. Must be any one of these values:
	 *		- FIRST - Specifies if the field is to be the first column of the table.
	 *		- AFTER - Specifies that the field is to be after fieldflagcolumn.
	 * @param string $fieldflagcolumn Used only when fieldflag is set to AFTER. Specify which field fieldstring is after.
	 * @access public
	*/
	public function createField ($fieldstring, $fieldflag, $fieldflagcolumn);

	/**
	 * updateField
	 *
	 * Updates a field from field and fieldchange. Field and fieldchange can be a string or an array but must be the same type for each!
	 *
	 * @param string $field Name of the field to change. Must be a string or an array of strings.
	 * @param string $fieldchange Value of the field to change. Must be a string or an array of strings.
	 * @access public
	*/
	public function updateField ($field, $fieldchange);

	/**
	 * deleteField
	 *
	 * Deletes a field from field. Field can be a string or an array.
	 *
	 * @param string $field Name of the field to delete. Must be a string or an array of strings.
	 * @access public
	*/
	public function deleteField ($field);

	// ------------------------------------------
	/**
	 * setDatabaseRow
	 *
	 * Executes a SQL query to retrieve the database rows creating a numerical array based on idnumber. Idnumber must be an array!
	 * To get the results, use getRowField(String $rowfield) for a single field in a row and getMultiRowField() for the entire row
	 * or multiple rows depending on the idnumber passed!
	 *
	 * @param array $idnumber Idnumber for the database query. Must be an array of strings with the key being the name of the field
	 * and the value being value of the field.
	 * @access public
	*/
	public function setDatabaseRow ($idnumber);

	/**
	 * setEntireTable
	 * Performs a SQL query to get the entire database table. Use getEntireTable() to get the entire table results!
	 *
	 * @access public
	*/
	public function setEntireTable ();

	/**
	 * BuildDatabaseRows
	 * Executes a SQL query to retrieve the database rows creating an associative array based on idnumber set from
	 * setIdNumber($idnumber). Idnumber must be an array. To retrieve the results use getDatabase($rownumber) using
	 * row value as rownumber.
	 *
	 * OPTIONAL - limit:
	 * If limit is set from setLimit, BuildDatabaseRows will impose that limit on the query.
	 *
	 * @access public
	*/
	public function BuildDatabaseRows ();

}
?>