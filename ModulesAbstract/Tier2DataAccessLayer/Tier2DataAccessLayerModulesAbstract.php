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

abstract class Tier2DataAccessLayerModulesAbstract extends LayerModulesAbstract
{
	protected $IDNumber;
	protected $OrderByName;
	protected $OrderByType;
	protected $Limit;
	protected $DatabaseName;
	protected $User;
	protected $Password;
	protected $DatabaseTable;
	protected $HostName;
	protected $Link;
	protected $RowQuery;
	protected $RowResult;
	protected $RowField;
	protected $MultRrowField = array();
	protected $RowFieldNames;
	protected $TableNameQuery;
	protected $TableNames;
	protected $TableQuery;
	protected $TableResult;
	protected $RowNumber;
	protected $EntireTable;
	protected $EntireTableResult;
	protected $Database;
	protected $I;
	protected $IDSearch;

	abstract protected function checkDatabaseName ();
	abstract protected function checkTableName ();
	abstract protected function checkPermissions ($permission);
	abstract protected function checkField ($field);
	abstract protected function BuildingEntireTable();

	public function setIdnumber ($IdNumber) {
		$this->IDNumber = $IdNumber;
	}

	public function getIdnumber () {
		return $this->IDNumber;
	}

	public function setOrderbyname ($OrderByName) {
		$this->OrderByName = $OrderByName;
	}

	public function getOrderbyname () {
		return $this->OrderByName;
	}

	public function setOrderbytype ($OrderByType) {
		$this->OrderByType = $OrderByType;
	}

	public function getOrderbytype () {
		return $this->OrderByType;
	}

	public function setLimit ($Limit) {
		$this->Limit = $Limit;
	}

	public function getLimit () {
		return $this->Limit;
	}

	public function setDatabasename ($DatabaseName){
		$this->DatabaseName = $DatabaseName;
	}

	public function getDatabasename () {
		return $this->DatabaseName;
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

	public function setDatabasetable ($DatabaseTable){
		$this->DatabaseTable = $DatabaseTable;
	}

	public function getDatabasetable () {
		return $this->DatabaseTable;
	}

	public function setHostname ($HostName){
		$this->HostName = $HostName;
	}

	public function getHostname () {
		return $this->HostName;
	}

	public function setDatabaseAll ($HostName, $User, $Password, $DatabaseName, $DatabaseTable) {
		$this->HostName = $HostName;
		$this->User = $User;
		$this->Password = $Password;
		$this->DatabaseName = $DatabaseName;
		$this->DatabaseTable = $DatabaseTable;
	}

	public function setOrderByAll ($OrderByName, $OrderByType) {
		$this->OrderByName = $OrderByName;
		$this->OrderByType = $OrderByType;
	}

	public function setDatabaseField ($IdNumber) {
		$this->IDNumber = $IdNumber;
		$this->BuildDatabaseRows();
		$this->RowFieldNames = Array ();
		if (is_array($this->Database)) {
			$this->RowFieldNames = array_keys($this->Database);
		}
	}

	public function searchFieldNames($Search) {
		if (is_array($this->RowFieldNames)) {
			if (array_search($Search, $this->RowFieldNames)) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}

	public function searchEntireTable($Search){
		$arguments = func_get_args();
		$Search2 = $arguments[1];

		if ($this->IDSearch) {
			unset ($this->IDSearch);
		}

		if ($Search2) {
			$this->I = 0;
			$j = 0;
			while ($this->I <= $this->RowNumber) {
				if (in_array($Search, $this->EntireTable[$this->I]) && in_array($Search2, $this->EntireTable[$this->I])){
					$this->IDSearch[$j]["idnumber"] = $this->EntireTable[$this->I]["idnumber"];
					$this->IDSearch[$j]["keyname"] = array_search($Search, $this->EntireTable[$this->I]);
					$j++;
				}
				$this->I++;
			}
		} else {
			$this->I = 0;
			$j = 0;
			while ($this->I <= $this->RowNumber) {
				if (is_array($this->EntireTable[$this->I])) {
					if (in_array($Search, $this->EntireTable[$this->I])){
						$this->IDSearch[$j]["idnumber"] = $this->EntireTable[$this->I]["idnumber"];
						$this->IDSearch[$j]["keyname"] = array_search($Search, $this->EntireTable[$this->I]);
						$j++;
					}
				}
				$this->I++;
			}
		}
	}

	public function removeEntryEntireTable($RowNumber, $RowColumn){
		unset($this->EntireTable[$RowNumber][$RowColumn]);
	}

	public function removeEntireEntireTable($RowNumber) {
		unset($this->EntireTable[$RowNumber]);
	}

	public function reindexEntireTable(){
		$this->EntireTable = array_merge($this->EntireTable);
	}

	public function updateEntireTableEntry ($RowNumber, $RowColumn, $Information) {
		$this->EntireTable[$RowNumber][$RowColumn] = $Information;
	}

	public function getRowCount (){
		return $this->RowNumber;
	}

	public function getRowFieldName ($RowNumber) {
		return $this->RowFieldNames[$RowNumber];
	}

	public function getRowFieldNames() {
		return $this->RowFieldNames;
	}

	public function getDatabase ($RowNumber) {
		return $this->Database[$RowNumber];
	}

	public function getRowField ($RowNumber) {
		return $this->RowField[$RowNumber];
	}

	public function getEntireRow(){
		return $this->RowField;
	}

	public function getMultiRowField() {
		return $this->MultRrowField;
	}

	public function getTable ($RowNumber, $RowColumn) {
		return $this->EntireTable[$RowNumber][$RowColumn];
	}

	public function getEntireTable () {
		return $this->EntireTable;
	}

	public function getSearchResults($IDNumber, $Key) {
		return $this->IDSearch[$IDNumber][$Key];
	}

	public function getSearchResultsArray() {
		return $this->IDSearch;
	}

	public function getTableNames() {
		return $this->TableNames;
	}

	public function walkarray () {
		print_r($this->Database);
	}

	public function walkfieldname () {
		print_r($this->RowFieldNames);
	}

	public function walktable () {
		print_r($this->EntireTable);
	}

	public function walkidsearch () {
		print_r($this->IDSearch);
	}

}
?>
