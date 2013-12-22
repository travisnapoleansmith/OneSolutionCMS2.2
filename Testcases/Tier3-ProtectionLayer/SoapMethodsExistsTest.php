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
	
	// Tier 3 Settings
	require_once "$HOME/Configuration/Tier3ProtectionLayerSettings.php";
	
	// All Tier Abstract
	require_once "$HOME/ModulesAbstract/LayerModulesAbstract.php";
	
	// Tiers Modules Abstract
	require_once "$HOME/ModulesAbstract/Tier3ProtectionLayer/Tier3ProtectionLayerModulesAbstract.php";
	
	// Tiers Interface Includes
	require_once "$HOME/ModulesInterfaces/Tier3ProtectionLayer/Tier3ProtectionLayerModulesInterfaces.php";

	// Tiers Includes
	require_once "$HOME/Tier3-ProtectionLayer/ClassProtectionLayer.php";
	require_once "$HOME/Testcases/Tier3-ProtectionLayer/SoapClient.php";
	
	// Tier 2 Modules
	//require_once "$HOME/Modules/Tier2DataAccessLayer/Core/MySqlConnect/ClassMySqlConnect.php";
	
	/**
	 * Tier 3 SOAP Methods Exists Test
	 *
	 * This file is designed to test if Tier 2's methods exists with SOAP.
	 *
	 * @author Travis Napolean Smith
	 * @copyright Copyright (c) 1999 - 2013 One Solution CMS
	 * @copyright PHP - Copyright (c) 2005 - 2013 One Solution CMS
	 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
	 * @version PHP - 2.2.1
	 * @version C++ - Unknown
 	*/
	class Tier3SoapMethodsTest extends UnitTestCase {
		
		/**
		 * Tier3Protection: SOAP ProtectionTier object for Tier 3
		 *
		 * @var object
		 */
		private $Tier3Protection;
		
		/**
		 * Create an instance of Tier3SoapMethodsTest.
		 *
		 * @access public
		*/	
		public function Tier3SoapMethodsTest () {
			$this->Tier3Protection = Tier3SetupSoap();
		}
		
		/**
		 * testSoapMethodExists
		 * Tests if all methods exists in ProtectionLayer with SOAP
		 *
		 * @access public
		*/
		public function testSoapMethodExists() {
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = $this->Tier3Protection->getMethods();
			$this->assertIsA($Return, 'array');
			
			$this->assertTrue(in_array('setModules', $Return));
			$this->assertTrue(in_array('getModules', $Return));
			$this->assertTrue(in_array('setDatabaseAll', $Return));
			$this->assertTrue(in_array('ConnectAll', $Return));
			$this->assertTrue(in_array('Connect', $Return));
			$this->assertTrue(in_array('DisconnectAll', $Return));
			$this->assertTrue(in_array('Disconnect', $Return));
			$this->assertTrue(in_array('buildDatabase', $Return));
			$this->assertTrue(in_array('createDatabaseTable', $Return));
			$this->assertTrue(in_array('checkPass', $Return));
			$this->assertTrue(in_array('pass', $Return));
			$this->assertTrue(in_array('buildModules', $Return));
		}
	}
?>