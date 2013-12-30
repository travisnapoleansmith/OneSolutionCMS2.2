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
	
	$HOME = $_SERVER['SUBDOMAIN_DOCUMENT_ROOT'];
	
	/* Auto run for SimpleTest
	*/
	require_once("$HOME/Testcases/SimpleTest/simpletest/autorun.php");
	
	// Tier 2 Settings
	require_once "$HOME/Testcases/Configuration/Tier2DataAccessLayerSettings.php";
	
	// Tier 3 Protection Layer Settings
	require_once "$HOME/Configuration/Tier3ProtectionLayerSettings.php";
	
	// All Tier Abstract
	require_once "$HOME/ModulesAbstract/GlobalTierAbstract.php";
	require_once "$HOME/ModulesAbstract/LayerModulesAbstract.php";
	
	// Tiers Modules Abstract
	require_once "$HOME/ModulesAbstract/Tier2DataAccessLayer/Tier2DataAccessLayerModulesAbstract.php";
	require_once "$HOME/ModulesAbstract/Tier3ProtectionLayer/Tier3ProtectionLayerModulesAbstract.php";
	
	// Tiers Interface Includes
	require_once "$HOME/ModulesInterfaces/Tier2DataAccessLayer/Tier2DataAccessLayerModulesInterfaces.php";
	require_once "$HOME/ModulesInterfaces/Tier3ProtectionLayer/Tier3ProtectionLayerModulesInterfaces.php";

	// Tiers Includes
	require_once "$HOME/Tier2-DataAccessLayer/ClassDataAccessLayer.php";
	require_once "$HOME/Tier3-ProtectionLayer/ClassProtectionLayer.php";
	
	// Tier 2 Modules
	require_once "$HOME/Modules/Tier2DataAccessLayer/Core/MySqlConnect/ClassMySqlConnect.php";
	
	/**
	 * Tier 3 Connect Test
	 *
	 * This file is designed to test Tier 3's Connect method.
	 *
	 * @author Travis Napolean Smith
	 * @copyright Copyright (c) 1999 - 2013 One Solution CMS
	 * @copyright PHP - Copyright (c) 2005 - 2013 One Solution CMS
	 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
	 * @version PHP - 2.2.1
	 * @version C++ - Unknown
 	*/
	class Tier3ConnectTest extends UnitTestCase {
		
		/**
		 * Tier3Protection: ProtectionLayer object for Tier 2
		 *
		 * @var object
		 */
		 
		private $Tier3Protection;
		
		/**
		 * ServerName: String from Settings.ini file. Listing the Database's Server Name
		 *
		 * @var string
		 */
		private $ServerName;
		
		/**
		 * Username: String from Settings.ini file. Listing the Database's Username
		 *
		 * @var string
		 */
		private $Username;
		
		/**
		 * Password: String from Settings.ini file. Listing the Database's Password
		 *
		 * @var string
		 */
		private $Password;
		
		/**
		 * DatabaseName: String from Settings.ini file. Listing the Database's Database Name
		 *
		 * @var string
		 */
		private $DatabaseName;
		
		/**
		 * Create an instance of Tier3ConnectAllTest.
		 *
		 * @access public
		*/	
		public function Tier3ConnectTest () {
			// Settings.ini File
			$credentaillogonarray = $GLOBALS['credentaillogonarray'];
			$this->ServerName = $credentaillogonarray[0];
			$this->Username = $credentaillogonarray[1];
			$this->Password = $credentaillogonarray[2];
			$this->DatabaseName = $credentaillogonarray[3];
			
			$this->Tier3Protection = new ProtectionLayer();
		}
		
		/**
		 * testConnectAllNull
		 * Tests if Connect methods will accept Hostame, User, Password and DatabaseName all as NULL. 
		 *
		 * @access public
		*/
		public function testConnectAllNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll(NULL, NULL, NULL, NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(NULL);
			$this->assertFalse($Return);
		}
		
		/**
		 * testConnectHostnameNull
		 * Tests if Connect methods will accept Hostame as NULL. 
		 *
		 * @access public
		*/
		public function testConnectHostnameNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll(NULL, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testConnectUserNull
		 * Tests if Connect methods will accept User as NULL. 
		 *
		 * @access public
		*/
		public function testConnectUserNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, NULL, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testConnectPasswordNull
		 * Tests if Connect methods will accept Password as NULL. 
		 *
		 * @access public
		*/
		public function testConnectPasswordNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, NULL, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testConnectDatabaseNameNull
		 * Tests if Connect methods will accept DatabaseName as NULL. 
		 *
		 * @access public
		*/
		public function testConnectDatabaseNameNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testConnectAllAsArray
		 * Tests if Connect methods will accept Hostame, User, Password and DatabaseName all as an Array. 
		 *
		 * @access public
		*/
		public function testConnectAllAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll(array(1), array(1), array(1), array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(array(1));
			$this->assertFalse($Return);
		}
		
		/**
		 * testConnectHostnameAsArray
		 * Tests if Connect methods will accept Hostame as an Array. 
		 *
		 * @access public
		*/
		public function testConnectHostnameAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll(array(1), $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testConnectUsernameAsArray
		 * Tests if Connect methods will accept Username as an Array. 
		 *
		 * @access public
		*/
		public function testConnectUsernameAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, array(1), $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testConnectPasswordAsArray
		 * Tests if Connect methods will accept Password as an Array. 
		 *
		 * @access public
		*/
		public function testConnectPasswordAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, array(1), $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testConnectDatabaseNameAsArray
		 * Tests if Connect methods will accept DatabaseName as an Array. 
		 *
		 * @access public
		*/
		public function testConnectDatabaseNameAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}

		/**
		 * testConnectAllAsObject
		 * Tests if Connect methods will accept Hostame, User, Password and DatabaseName all as an Object. 
		 *
		 * @access public
		*/
		public function testConnectAllAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($Object, $Object, $Object, $Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable($Object);
			$this->assertFalse($Return);
		}
		
		/**
		 * testConnectHostnameAsObject
		 * Tests if Connect methods will accept Hostame as an Object. 
		 *
		 * @access public
		*/
		public function testConnectHostnameAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($Object, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testConnectUsernameAsObject
		 * Tests if Connect methods will accept User as an Object. 
		 *
		 * @access public
		*/
		public function testConnectUsernameAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $Object, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testConnectPasswordAsObject
		 * Tests if Connect methods will accept Password as an Object. 
		 *
		 * @access public
		*/
		public function testConnectPasswordAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $Object, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testConnectDatabaseNameAsObject
		 * Tests if Connect methods will accept DatabaseName as an Object. 
		 *
		 * @access public
		*/
		public function testConnectDatabaseNameAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testConnectDatabaseTableInvalidName
		 * Tests if Connect methods will accept Database Table as an invalid name. 
		 *
		 * @access public
		*/
		public function testConnectDatabaseTableInvalidName() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			try {
				$Return = TRUE;
				$Return = $this->Tier3Protection->Connect('INVALID');
			} catch (Exception $e) {
				$this->pass();
			}
			//$this->assertIsA($Return, 'Exception');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}

		/**
		 * testConnectDatabaseTableNull
		 * Tests if Connect methods will accept Database Table as NULL. 
		 *
		 * @access public
		*/
		public function testConnectDatabaseTableNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}

		/**
		 * testConnectDatabaseTableAsArray
		 * Tests if Connect methods will accept DatabaseName as an Array. 
		 *
		 * @access public
		*/
		public function testConnectDatabaseTableAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testConnectDatabaseTableAsObject
		 * Tests if Connect methods will accept DatabaseName as an Object. 
		 *
		 * @access public
		*/
		public function testConnectDatabaseTableAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testConnectCorrectData
		 * Tests if Connect methods will accept all data correctly. 
		 *
		 * @access public
		*/
		public function testConnectCorrectData() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
	}
?>