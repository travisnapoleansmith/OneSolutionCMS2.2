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

	// MySql Connect Allow and Deny Member Functions For Tier 4 Authentication Layer
	$Tier4DatabaseAllow = Array();
	$Tier4DatabaseDeny = Array();

	// Must be allowed!
	$Tier4DatabaseAllow['MySqlConnect'] = 'MySqlConnect';

	// Setters and Getters
	$Tier4DatabaseAllow['setIdnumber'] = 'setIdnumber';
	$Tier4DatabaseAllow['getIdnumber'] = 'getIdnumber';
	$Tier4DatabaseAllow['setOrderbyname'] = 'setOrderbyname';
	$Tier4DatabaseAllow['getOrderbyname'] = 'getOrderbyname';
	$Tier4DatabaseAllow['setOrderbytype'] = 'setOrderbytype';
	$Tier4DatabaseAllow['getOrderbytype'] = 'getOrderbytype';
	$Tier4DatabaseAllow['setLimit'] = 'setLimit';
	$Tier4DatabaseAllow['getLimit'] = 'getLimit';
	$Tier4DatabaseAllow['setDatabasename'] = 'setDatabasename';
	$Tier4DatabaseAllow['getDatabasename'] = 'getDatabasename';
	$Tier4DatabaseAllow['setUser'] = 'setUser';
	$Tier4DatabaseAllow['getUser'] = 'getUser';
	$Tier4DatabaseAllow['setPassword'] = 'setPassword';
	$Tier4DatabaseAllow['getPassword'] = 'getPassword';
	$Tier4DatabaseAllow['setDatabasetable'] = 'setDatabasetable';
	$Tier4DatabaseAllow['getDatabasetable'] = 'getDatabasetable';
	$Tier4DatabaseAllow['setHostname'] = 'setHostname';
	$Tier4DatabaseAllow['getHostname'] = 'getHostname';
	$Tier4DatabaseAllow['getError'] = 'getError';
	$Tier4DatabaseAllow['getErrorArray'] = 'getErrorArray';
	$Tier4DatabaseAllow['setDatabaseAll'] = 'setDatabaseAll';
	$Tier4DatabaseAllow['setOrderByAll'] = 'setOrderByAll';

	// Connecting to database
	$Tier4DatabaseAllow['Connect'] = 'Connect';
	$Tier4DatabaseAllow['Disconnect'] = 'Disconnect';

	// Basic checks and verifies
	$Tier4DatabaseAllow['checkDatabaseName'] = 'checkDatabaseName';
	$Tier4DatabaseAllow['checkTableName'] = 'checkTableName';
	$Tier4DatabaseAllow['checkPermissions'] = 'checkPermissions';
	$Tier4DatabaseAllow['checkField'] = 'checkField';

	// Basic Setup of Database
	$Tier4DatabaseDeny['createDatabase'] = 'createDatabase';
	$Tier4DatabaseDeny['deleteDatabase'] = 'deleteDatabase';

	// Table Methods
	$Tier4DatabaseDeny['createTable'] = 'createTable';
	$Tier4DatabaseDeny['updateTable'] = 'updateTable';
	$Tier4DatabaseDeny['deleteTable'] = 'deleteTable';

	// Row Methods
	$Tier4DatabaseDeny['createRow'] = 'createRow';
	$Tier4DatabaseDeny['updateRow'] = 'updateRow';
	$Tier4DatabaseDeny['deleteRow'] = 'deleteRow';

	// Field Methods
	$Tier4DatabaseDeny['createField'] = 'createField';
	$Tier4DatabaseDeny['updateField'] = 'updateField';
	$Tier4DatabaseDeny['deleteField'] = 'deleteField';

	// General SQL Command
	$Tier4DatabaseAllow['executeSQlCommand'] = 'executeSQlCommand';

	// Empty Table Methods
	$Tier4DatabaseAllow['emptyTable'] = 'emptyTable';

	// Maintenance Methods
	$Tier4DatabaseDeny['sortTable'] = 'sortTable';

	// Setting Database Row
	$Tier4DatabaseAllow['setDatabaseRow'] = 'setDatabaseRow';

	// Setting Database Fields
	$Tier4DatabaseAllow['setDatabaseField'] = 'setDatabaseField';

	// Entire Table Methods
	$Tier4DatabaseAllow['setEntireTable'] = 'setEntireTable';
	$Tier4DatabaseAllow['BuildingEntireTable'] = 'BuildingEntireTable';

	// Field Methods
	$Tier4DatabaseAllow['searchFieldNames'] = 'searchFieldNames';
	$Tier4DatabaseAllow['BuildFieldNames'] = 'BuildFieldNames';

	// Entire Table Methods
	$Tier4DatabaseAllow['searchEntireTable'] = 'searchEntireTable';
	$Tier4DatabaseAllow['removeEntryEntireTable'] = 'removeEntryEntireTable';
	$Tier4DatabaseAllow['removeEntireEntireTable'] = 'RemoveEntireEntireTable';
	$Tier4DatabaseAllow['reindexEntireTable'] = 'ReindexEntireTable';
	$Tier4DatabaseAllow['updateEntireTableEntry'] = 'updateEntireTableEntry';

	// Row Methods
	$Tier4DatabaseAllow['BuildDatabaseRows'] = 'BuildDatabaseRows';

	// Getters
	$Tier4DatabaseAllow['getRowCount'] = 'getRowCount';
	$Tier4DatabaseAllow['getRowFieldName'] = 'getRowFieldName';
	$Tier4DatabaseAllow['getRowFieldNames'] = 'getRowFieldNames';
	$Tier4DatabaseAllow['getDatabase'] = 'getDatabase';
	$Tier4DatabaseAllow['getRowField'] = 'getRowField';
	$Tier4DatabaseAllow['getMultiRowField'] = 'getMultiRowField';
	$Tier4DatabaseAllow['getTable'] = 'getTable';
	$Tier4DatabaseAllow['getEntireTable'] = 'getEntireTable';
	$Tier4DatabaseAllow['getSearchResults'] = 'getSearchResults';
	$Tier4DatabaseAllow['getTableNames'] = 'getTableNames';

	// Basic Developer Diagnostics
	$Tier4DatabaseAllow['walkarray'] = 'walkarray';
	$Tier4DatabaseAllow['walkfieldname'] = 'walkfieldname';
	$Tier4DatabaseAllow['walktable'] = 'walktable';
	$Tier4DatabaseAllow['walkidsearch'] = 'walkidsearch';
?>