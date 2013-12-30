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
	
	ini_set("soap.wsdl_cache_enabled", 0); 
	ini_set("session.auto_start", 0);
	
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
	// General Settings
	require_once "$HOME/Configuration/settings.php";

	$TOKENKEY = $GLOBALS['SETTINGS']['TIER CONFIGURATION']['TOKENKEY'];
	$TOKEN = $_GET['Token'];
	if ($TOKEN === $TOKENKEY) {
		// All Tier Abstract
		require_once "$HOME/ModulesAbstract/LayerModulesAbstract.php";

		// Tiers Modules Abstract
		require_once "$HOME/ModulesAbstract/Tier2DataAccessLayer/Tier2DataAccessLayerModulesAbstract.php";
		require_once "$HOME/ModulesAbstract/Tier3ProtectionLayer/Tier3ProtectionLayerModulesAbstract.php";

		// Tiers Interface Includes
		require_once "$HOME/ModulesInterfaces/Tier3ProtectionLayer/Tier3ProtectionLayerModulesInterfaces.php";
		require_once "$HOME/ModulesInterfaces/Tier2DataAccessLayer/Tier2DataAccessLayerModulesInterfaces.php";

		// Tiers Includes
		require_once "$HOME/Tier2-DataAccessLayer/ClassDataAccessLayer.php";
		require_once "$HOME/Tier3-ProtectionLayer/ClassProtectionLayer.php";

		// Tier 2 Modules
		require_once "$HOME/Modules/Tier2DataAccessLayer/Core/MySqlConnect/ClassMySqlConnect.php";

		// Tier 3 Protection Layer Settings
		require_once "$HOME/Testcases/Configuration/Tier2DataAccessLayerSettings.php";
		require_once "$HOME/Testcases/Configuration/Tier3ProtectionLayerSettings.php";
		
		session_start();
		
		$LayerModuleOn = FALSE;
		
		//$Tier3Protection = new ProtectionLayer();
		
		try {
			$ServerLocation = $sitelink . 'Tier3-ProtectionLayer/';
			
			$Server = new SoapServer(NULL, array('uri' => $ServerLocation, 
												/*'soap_version' => 'SOAP_1_2',*/
												'encoding' => 'utf-8'));
			
			$Server->setClass('ProtectionLayer', $LayerModuleOn);
			
			$Server->setPersistence(SOAP_PERSISTENCE_SESSION);
			
			$Server->handle();
			
		} catch (SoapFault $E) {
			error_log("SOAP ERROR: ". $E->getMessage());
		}
		
	} else {
		header('HTTP/1.0 401 Unauthorized');
		exit;
	}
	
?>