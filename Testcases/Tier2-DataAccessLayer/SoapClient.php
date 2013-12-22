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
	* @version    2.2.1, 2013-05-05
	*************************************************************************************
	*/
	if ($_SERVER['SUBDOMAIN_DOCUMENT_ROOT'] != NULL) {
		$HOME = $_SERVER['SUBDOMAIN_DOCUMENT_ROOT'];
	} else {
		if ($_SERVER['REAL_DOCUMENT_ROOT'] != NULL) {
			$_SERVER['SUBDOMAIN_DOCUMENT_ROOT'] = $_SERVER['REAL_DOCUMENT_ROOT'];
			$HOME = $_SERVER['SUBDOMAIN_DOCUMENT_ROOT'];
		} else {
			$HOME = NULL;
		}
	}
	
	$HOME = $_SERVER['SUBDOMAIN_DOCUMENT_ROOT'];

	global $HOST;
	
	if ($_SERVER['HTTP_HOST'] != NULL) {
		$HOST = 'http://' . $_SERVER['HTTP_HOST'] . '/';
	} else if ($_SERVER['DOMAIN_NAME'] != NULL) {
		$HOST = 'http://' . $_SERVER['DOMAIN_NAME'] . '/';
	} else if ($_SERVER['SERVER_NAME'] != NULL) {
		$HOST = 'http://' . $_SERVER['SERVER_NAME'] . '/';
	} else {
		$HOST = NULL;
	}
	// General Settings
	//require_once "$HOME/Configuration/settings.php";
	ini_set('session.auto_start', 0);
	
	function Tier2SetupSoap() {
		$HOST = $GLOBALS['HOST'];
		
		$TOKENKEY = $GLOBALS['SETTINGS']['TIER CONFIGURATION']['TOKENKEY'];
		
		$Location = $HOST . 'Tier2-DataAccessLayer/SoapServerDataAccessLayer.php?Token=' . $TOKENKEY;
		$Uri = $HOST;
		$Tier2DataAccessLayerClient = new SoapClient(NULL, array('location' => $Location,
											'uri' => $Uri,
											'soap_version' => SOAP_1_2, 
											/*'exceptions' => FALSE,*/ 
											'trace' => TRUE,
											'encoding' => 'utf-8'));
		//$Header = new SoapHeader($Uri,'ConnectionOverride', TRUE);
		//$Tier2DataAccessLayerClient->__setSoapHeaders($Header);
		
		return $Tier2DataAccessLayerClient;
	}
	
?>
