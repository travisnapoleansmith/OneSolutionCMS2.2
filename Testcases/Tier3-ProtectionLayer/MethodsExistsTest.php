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
	
	$HOME = $_SERVER['SUBDOMAIN_DOCUMENT_ROOT'];
	
	/* Auto run for SimpleTest
	*/
	require_once("$HOME/Testcases/SimpleTest/simpletest/autorun.php");
	
	// Tier Settings
	require_once "$HOME/Testcases/Configuration/Tier2DataAccessLayerSettings.php";
	require_once "$HOME/Testcases/Configuration/Tier3ProtectionLayerSettings.php";
	
	// All Tier Abstract
	require_once "$HOME/ModulesAbstract/LayerModulesAbstract.php";
	
	// Tiers Modules Abstract
	require_once "$HOME/ModulesAbstract/Tier2DataAccessLayer/Tier2DataAccessLayerModulesAbstract.php";
	
	// Tiers Interface Includes
	require_once "$HOME/ModulesInterfaces/Tier3ProtectionLayer/Tier3ProtectionLayerModulesInterfaces.php";
	require_once "$HOME/ModulesInterfaces/Tier2DataAccessLayer/Tier2DataAccessLayerModulesInterfaces.php";

	// Tiers Includes
	require_once "$HOME/Tier2-DataAccessLayer/ClassDataAccessLayer.php";
	require_once "$HOME/Tier3-ProtectionLayer/ClassProtectionLayer.php";
	
	// Tier 2 Modules
	require_once "$HOME/Modules/Tier2DataAccessLayer/Core/MySqlConnect/ClassMySqlConnect.php";
	
	/**
	 * Tier 3 Methods Exists Test
	 *
	 * This file is designed to test if Tier 3's methods exists.
	 *
	 * @author Travis Napolean Smith
	 * @copyright Copyright (c) 1999 - 2013 One Solution CMS
	 * @copyright PHP - Copyright (c) 2005 - 2013 One Solution CMS
	 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
	 * @version PHP - 2.2.1
	 * @version C++ - Unknown
 	*/
	class Tier3MethodsTest extends UnitTestCase {
		
		/**
		 * Tier3Protection: ProtectionLayer object for Tier 2
		 *
		 * @var object
		 */
		private $Tier3Protection;
		
		/**
		 * Create an instance of Tier3MethodsTest.
		 *
		 * @access public
		*/	
		public function Tier3MethodsTest () {
			$this->Tier3Protection = new ProtectionLayer();
		}
		
		/**
		 * testMethodExists
		 * Tests if all methods exists in ProtectionLayer
		 *
		 * @access public
		*/
		public function testMethodExists() {
			$this->assertNotNull($this->Tier3Protection);
			$this->assertTrue(method_exists($this->Tier3Protection, 'setModules'));
			$this->assertTrue(method_exists($this->Tier3Protection, 'getModules'));
			$this->assertTrue(method_exists($this->Tier3Protection, 'setDatabaseAll'));
			$this->assertTrue(method_exists($this->Tier3Protection, 'ConnectAll'));
			$this->assertTrue(method_exists($this->Tier3Protection, 'Connect'));
			$this->assertTrue(method_exists($this->Tier3Protection, 'DisconnectAll'));
			$this->assertTrue(method_exists($this->Tier3Protection, 'Disconnect'));
			$this->assertTrue(method_exists($this->Tier3Protection, 'buildDatabase'));
			$this->assertTrue(method_exists($this->Tier3Protection, 'createDatabaseTable'));
			$this->assertTrue(method_exists($this->Tier3Protection, 'checkPass'));
			$this->assertTrue(method_exists($this->Tier3Protection, 'pass'));
		}
	}
?>