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

	$HOME = $_SERVER['SUBDOMAIN_DOCUMENT_ROOT'];
	// General Settings
	require_once "$HOME/Configuration/settings.php";

	$TOKENKEY = $GLOBALS['SETTINGS']['TIER CONFIGURATION']['TOKENKEY'];

	//session_start();

	$Options = array('consumer_key' => "CONSUMER KEY", 'consumer_secret' => "CONSUMER SECRET");
	/*
	require_once "../Libraries/GlobalLayer/GoogleOAuth/OAuthStore.php";
	require_once "../Libraries/GlobalLayer/GoogleOAuth/OAuthRequester.php";

	OAuthStore::instance("2Leg", $Options);

	$Url = 'http://atpaversion3.travisnapoleansmith.com/Tier2-DataAccessLayer/SoapServerDataAccessLayer.php';
	$Method = 'GET';
	$Parameters = NULL;

	$Request = new OAuthRequester($Url, $Method, $Parameters);
	print_r($Request);
	*/
	$Location = 'http://atpaversion3.travisnapoleansmith.com/Tier2-DataAccessLayer/SoapServerDataAccessLayer.php?Token=' . $TOKENKEY;
	$Uri = 'http://atpaversion3.travisnapoleansmith.com/';
	$Client = new SoapClient(NULL, array('location' => $Location,
										'uri' => $Uri,
										'soap_version' => SOAP_1_2));


	$credentaillogonarray = $GLOBALS['credentaillogonarray'];

	$Client->createDatabaseTable('ContentLayer');
	$Client->setDatabaseAll ($credentaillogonarray[0], $credentaillogonarray[1], $credentaillogonarray[2], $credentaillogonarray[3], NULL);
	$Client->buildModules('DataAccessLayerModules', 'DataAccessLayerTables', 'DataAccessLayerModulesSettings');

	//$return = $Client->getDatabasename();
	//$return = $Client->getDatabaseTable();
	//print_r($return);

	//$return = $Client->TESTING();
	//print_r($return);
	print "HERE\n";

	/////print "HERE\n";
?>
