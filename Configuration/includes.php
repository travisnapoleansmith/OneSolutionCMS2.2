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
	set_time_limit(60);
	
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
	// General Settings
	require_once "$HOME/Configuration/settings.php";

	// All Tier Abstract
	require_once "$HOME/ModulesAbstract/GlobalTierAbstract.php";
	require_once "$HOME/ModulesAbstract/LayerModulesAbstract.php";

	// Tiers Modules Abstract
	require_once "$HOME/ModulesAbstract/Tier6ContentLayer/Tier6ContentLayerModulesAbstract.php";
	require_once "$HOME/ModulesAbstract/Tier5ValidationLayer/Tier5ValidationLayerModulesAbstract.php";
	require_once "$HOME/ModulesAbstract/Tier4AuthenticationLayer/Tier4AuthenticationLayerModulesAbstract.php";
	require_once "$HOME/ModulesAbstract/Tier3ProtectionLayer/Tier3ProtectionLayerModulesAbstract.php";
	require_once "$HOME/ModulesAbstract/Tier2DataAccessLayer/Tier2DataAccessLayerModulesAbstract.php";

	// Tiers Interface Includes
	require_once "$HOME/ModulesInterfaces/Tier6ContentLayer/Tier6ContentLayerModulesInterfaces.php";
	require_once "$HOME/ModulesInterfaces/Tier5ValidationLayer/Tier5ValidationLayerModulesInterfaces.php";
	require_once "$HOME/ModulesInterfaces/Tier4AuthenticationLayer/Tier4AuthenticationLayerModulesInterfaces.php";
	require_once "$HOME/ModulesInterfaces/Tier3ProtectionLayer/Tier3ProtectionLayerModulesInterfaces.php";
	require_once "$HOME/ModulesInterfaces/Tier2DataAccessLayer/Tier2DataAccessLayerModulesInterfaces.php";

	// Tiers Includes
	require_once "$HOME/Tier2-DataAccessLayer/ClassDataAccessLayer.php";
	require_once "$HOME/Tier3-ProtectionLayer/ClassProtectionLayer.php";
	require_once "$HOME/Tier4-AuthenticationLayer/ClassAuthenticationLayer.php";
	require_once "$HOME/Tier5-ValidationLayer/ClassValidationLayer.php";
	require_once "$HOME/Tier6-ContentLayer/ClassContentLayer.php";

	// Tier 2 Modules
	require_once "$HOME/Modules/Tier2DataAccessLayer/Core/MySqlConnect/ClassMySqlConnect.php";

	// Tier 3 Modules

	// Tier 4 Modules

	// Tier 5 Modules

	// Tier 6 Modules

	// Tier 2 Data Access Layer Settings
	require_once "$HOME/Configuration/Tier2DataAccessLayerSettings.php";

	// Tier 3 Protection Layer Settings
	require_once "$HOME/Configuration/Tier3ProtectionLayerSettings.php";

	// Tier 4 Authentication Layer Settings
	require_once "$HOME/Configuration/Tier4AuthenticationLayerSettings.php";

	// Tier 5 Validation Layer Settings
	require_once "$HOME/Configuration/Tier5ValidationLayerSettings.php";

	// Tier 6 Content Layer Settings
	require_once "$HOME/Configuration/Tier6ContentLayerDatabaseSettings.php";
	require_once "$HOME/Configuration/Tier6ContentLayerSettings.php";

?>