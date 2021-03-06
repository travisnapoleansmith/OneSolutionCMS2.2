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
	
	function Tier3SetupSoap() {
		$HOST = $GLOBALS['HOST'];
		
		$TOKENKEY = $GLOBALS['SETTINGS']['TIER CONFIGURATION']['TOKENKEY'];
		
		$Location = $HOST . 'Tier3-ProtectionLayer/SoapServerProtectionLayer.php?Token=' . $TOKENKEY;
		$Uri = $HOST;
		$Tier3ProtectionLayerClient = new SoapClient(NULL, array('location' => $Location,
											'uri' => $Uri,
											'soap_version' => SOAP_1_2, 
											/*'exceptions' => FALSE,*/ 
											'trace' => TRUE,
											'encoding' => 'utf-8'));
		//$Header = new SoapHeader($Uri,'ConnectionOverride', TRUE);
		//$Tier3ProtectionLayerClient->__setSoapHeaders($Header);
		$credentaillogonarray = $GLOBALS['credentaillogonarray'];
		$ServerName = $credentaillogonarray[0];
		$Username = $credentaillogonarray[1];
		$Password = $credentaillogonarray[2];
		$DatabaseName = $credentaillogonarray[3];
			
		$Tier3ProtectionLayerClient->createDatabaseTable('ContentLayer');
		$Tier3ProtectionLayerClient->setDatabaseAll ($ServerName, $Username, $Password, $DatabaseName, NULL);
		$Tier3ProtectionLayerClient->buildModules('ProtectionLayerModules', 'ProtectionLayerTables', 'ProtectionLayerModulesSettings');
		
		return $Tier3ProtectionLayerClient;
	}
	
?>
