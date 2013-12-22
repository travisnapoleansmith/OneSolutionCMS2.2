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
	
	// Tier 2 Settings
	require_once "$HOME/Testcases/Configuration/Tier2DataAccessLayerSettings.php";
	
	// Tier 3 Protection Layer Settings
	require_once "$HOME/Configuration/Tier3ProtectionLayerSettings.php";
	
	// All Tier Abstract
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
	 * Tier 2 Disconnect Test
	 *
	 * This file is designed to test Tier 2's Disconnect method.
	 *
	 * @author Travis Napolean Smith
	 * @copyright Copyright (c) 1999 - 2013 One Solution CMS
	 * @copyright PHP - Copyright (c) 2005 - 2013 One Solution CMS
	 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
	 * @version PHP - 2.2.1
	 * @version C++ - Unknown
 	*/
	class Tier2DisconnectTest extends UnitTestCase {
		
		/**
		 * Tier2Database: DataAccessTier object for Tier 2
		 *
		 * @var object
		 */
		private $Tier2Database;
		
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
		 * Create an instance of Tier2DisconnectTest.
		 *
		 * @access public
		*/	
		public function Tier2DisconnectTest () {
			// Settings.ini File
			$credentaillogonarray = $GLOBALS['credentaillogonarray'];
			$this->ServerName = $credentaillogonarray[0];
			$this->Username = $credentaillogonarray[1];
			$this->Password = $credentaillogonarray[2];
			$this->DatabaseName = $credentaillogonarray[3];
			
			$this->Tier2Database = new DataAccessLayer();
		}
		
		
		/**
		 * testDisconnectAllAsNull
		 * Tests if Disconnect methods will accept Hostame, User, Password and DatabaseName all as NULL. 
		 *
		 * @access public
		*/
		public function testDisconnectAllAsNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->setDatabaseAll(NULL, NULL, NULL, NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable(NULL);
			$this->assertFalse($Return);
		}
		
		/**
		 * testDisconnectHostnameAsNull
		 * Tests if Disconnect methods will accept Hostame as NULL. 
		 *
		 * @access public
		*/
		public function testDisconnectHostnameAsNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll(NULL, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
		}
		
		/**
		 * testDisconnectUsernameAsNull
		 * Tests if Disconnect methods will accept User as NULL. 
		 *
		 * @access public
		*/
		public function testDisconnectUsernameAsNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, NULL, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
		}
		
		/**
		 * testDisconnectPasswordAsNull
		 * Tests if Disconnect methods will accept Password as NULL. 
		 *
		 * @access public
		*/
		public function testDisconnectPasswordAsNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, NULL, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testDisconnectDatabaseNameAsNull
		 * Tests if Disconnect methods will accept DatabaseName as NULL. 
		 *
		 * @access public
		*/
		public function testDisconnectDatabaseNameAsNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}

		/**
		 * testDisconnectAllAsArray
		 * Tests if Disconnect methods will accept Hostame, User, Password and DatabaseName all as an Array. 
		 *
		 * @access public
		*/
		public function testDisconnectAllAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->setDatabaseAll(array(1), array(1), array(1), array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable(array(1));
			$this->assertFalse($Return);
		}
		
		/**
		 * testDisconnectHostnameAsArray
		 * Tests if Disconnect methods will accept Hostame as an Array. 
		 *
		 * @access public
		*/
		public function testDisconnectHostnameAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll(array(1), $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
		}
		
		/**
		 * testDisconnectUsernameAsArray
		 * Tests if Disconnect methods will accept User as an Array. 
		 *
		 * @access public
		*/
		public function testDisconnectUsernameAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, array(1), $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
		}
		
		/**
		 * testDisconnectPasswordAsArray
		 * Tests if Disconnect methods will accept Password as an Array. 
		 *
		 * @access public
		*/
		public function testDisconnectPasswordAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, array(1), $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testDisconnectDatabaseNameAsArray
		 * Tests if Disconnect methods will accept DatabaseName as an Array. 
		 *
		 * @access public
		*/
		public function testDisconnectDatabaseNameAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}

		/**
		 * testDisconnectAllAsObject
		 * Tests if Disconnect methods will accept Hostame, User, Password and DatabaseName all as an Object. 
		 *
		 * @access public
		*/
		public function testDisconnectAllAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Object = new stdClass;
			
			$Return = $this->Tier2Database->setDatabaseAll($Object, $Object, $Object, $Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable($Object);
			$this->assertFalse($Return);
		}
		
		/**
		 * testDisconnectHostnameAsObject
		 * Tests if Disconnect methods will accept Hostame as an Object. 
		 *
		 * @access public
		*/
		public function testDisconnectHostnameAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($Object, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
		}
		
		/**
		 * testDisconnectUsernameAsObject
		 * Tests if Disconnect methods will accept User as an Object. 
		 *
		 * @access public
		*/
		public function testDisconnectUsernameAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $Object, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
		}
		
		/**
		 * testDisconnectPasswordAsObject
		 * Tests if Disconnect methods will accept Password as an Object. 
		 *
		 * @access public
		*/
		public function testDisconnectPasswordAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $Object, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testDisconnectDatabaseNameAsObject
		 * Tests if Disconnect methods will accept DatabaseName as an Object. 
		 *
		 * @access public
		*/
		public function testDisconnectDatabaseNameAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testDisconnectDatabaseTableInvalidName
		 * Tests if Disconnect methods will accept Database Table as an invalid name. 
		 *
		 * @access public
		*/
		public function testDisconnectDatabaseTableInvalidName() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			try {
				$Return = TRUE;
				$Return = $this->Tier2Database->Connect('INVALID');
			} catch (Exception $e) {
				$this->pass();
			}
			
			//$this->assertIsA($Return, 'Exception');
			
			try {
				$Return = TRUE;
				$Return = $this->Tier2Database->Disconnect('INVALID');
			} catch (Exception $e) {
				$this->pass();
			}
			
			//$this->assertIsA($Return, 'Exception');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testDisconnectDatabaseTableAsArray
		 * Tests if Disconnect methods will accept Database Table as an array. 
		 *
		 * @access public
		*/
		public function testDisconnectDatabaseTableAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password,  $this->DatabaseName);
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable(array(1));
			$this->assertFalse($Return);
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable(array(1));
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testDisconnectDatabaseTableAsObject
		 * Tests if Disconnect methods will accept Database Table as an object. 
		 *
		 * @access public
		*/
		public function testDisconnectDatabaseTableAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password,  $this->DatabaseName);
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable($Object);
			$this->assertFalse($Return);
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect($Object);
			$this->assertFalse($Return);
			
			$Object = new stdClass;
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable($Object);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testDisconnectCorrectData
		 * Tests if Disconnect methods will accept all data correctly. 
		 *
		 * @access public
		*/
		public function testDisconnectCorrectData() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
	}
?>