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
	 * Tier 2 Disconnect All Test
	 *
	 * This file is designed to test Tier 2's DisconnectAll method.
	 *
	 * @author Travis Napolean Smith
	 * @copyright Copyright (c) 1999 - 2013 One Solution CMS
	 * @copyright PHP - Copyright (c) 2005 - 2013 One Solution CMS
	 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
	 * @version PHP - 2.2.1
	 * @version C++ - Unknown
 	*/
	class Tier2DisconnectAllTest extends UnitTestCase {
		
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
		 * Create an instance of Tier2DisconnectAllTest.
		 *
		 * @access public
		*/	
		public function Tier2DisconnectAllTest () {
			// Settings.ini File
			$credentaillogonarray = $GLOBALS['credentaillogonarray'];
			$this->ServerName = $credentaillogonarray[0];
			$this->Username = $credentaillogonarray[1];
			$this->Password = $credentaillogonarray[2];
			$this->DatabaseName = $credentaillogonarray[3];
			
			$this->Tier2Database = new DataAccessLayer();
		}
		
		
		/**
		 * testDisconnectAllAllAsNull
		 * Tests if DisconnectAll methods will accept Hostame, User, Password and DatabaseName all as NULL. 
		 *
		 * @access public
		*/
		public function testDisconnectAllAllAsNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll(NULL, NULL, NULL, NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable(NULL);
			$this->assertFalse($Return);
		}
		
		/**
		 * testDisconnectAllHostnameAsNull
		 * Tests if DisconnectAll methods will accept Hostame as NULL. 
		 *
		 * @access public
		*/
		public function testDisconnectAllHostnameAsNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll(NULL, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testDisconnectAllUsernameAsNull
		 * Tests if DisconnectAll methods will accept User as NULL. 
		 *
		 * @access public
		*/
		public function testDisconnectAllUsernameAsNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, NULL, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testDisconnectAllPasswordAsNull
		 * Tests if DisconnectAll methods will accept Password as NULL. 
		 *
		 * @access public
		*/
		public function testDisconnectAllPasswordAsNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, NULL, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testDisconnectAllDatabaseNameAsNull
		 * Tests if DisconnectAll methods will accept DatabaseName as NULL. 
		 *
		 * @access public
		*/
		public function testDisconnectAllDatabaseNameAsNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
		}
		
		/**
		 * testDisconnectAllAllAsArray
		 * Tests if DisconnectAll methods will accept Hostame, User, Password and DatabaseName all as an Array. 
		 *
		 * @access public
		*/
		public function testDisconnectAllAllAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll(array(1), array(1), array(1), array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable(array(1));
			$this->assertFalse($Return);
		}
		
		/**
		 * testDisconnectAllHostnameAsArray
		 * Tests if DisconnectAll methods will accept Hostame as an Array. 
		 *
		 * @access public
		*/
		public function testDisconnectAllHostnameAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll(array(1), $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testDisconnectAllUsernameAsArray
		 * Tests if DisconnectAll methods will accept User as an Array. 
		 *
		 * @access public
		*/
		public function testDisconnectAllUsernameAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, array(1), $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testDisconnectAllPasswordAsArray
		 * Tests if DisconnectAll methods will accept Password as an Array. 
		 *
		 * @access public
		*/
		public function testDisconnectAllPasswordAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, array(1), $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testDisconnectAllDatabaseNameAsArray
		 * Tests if DisconnectAll methods will accept DatabaseName as an Array. 
		 *
		 * @access public
		*/
		public function testDisconnectAllDatabaseNameAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
		}
		
		/**
		 * testDisconnectAllAllAsObject
		 * Tests if DisconnectAll methods will accept Hostame, User, Password and DatabaseName all as an Object. 
		 *
		 * @access public
		*/
		public function testDisconnectAllAllAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($Object, $Object, $Object, $Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable($Object);
			$this->assertFalse($Return);
		}
		
		/**
		 * testDisconnectAllHostnameAsObject
		 * Tests if DisconnectAll methods will accept Hostame as an Object. 
		 *
		 * @access public
		*/
		public function testDisconnectAllHostnameAsObject() {
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
			$Return = $this->Tier2Database->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testDisconnectAllUsernameAsObject
		 * Tests if DisconnectAll methods will accept User as an Object. 
		 *
		 * @access public
		*/
		public function testDisconnectAllUsernameAsObject() {
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
			$Return = $this->Tier2Database->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testDisconnectAllPasswordAsObject
		 * Tests if DisconnectAll methods will accept Password as an Object. 
		 *
		 * @access public
		*/
		public function testDisconnectAllPasswordAsObject() {
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
			$Return = $this->Tier2Database->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testDisconnectAllDatabaseNameAsObject
		 * Tests if DisconnectAll methods will accept DatabaseName as an Object. 
		 *
		 * @access public
		*/
		public function testDisconnectAllDatabaseNameAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
		}
		
		/**
		 * testDisconnectAllDatabaseTableAsArray
		 * Tests if DisconnectAll methods will accept DatabaseTable as an Array. 
		 *
		 * @access public
		*/
		public function testDisconnectAllDatabaseTableAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable(array(1));
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testDisconnectAllDatabaseTableAsObject
		 * Tests if DisconnectAll methods will accept DatabaseTable as an Object. 
		 *
		 * @access public
		*/
		public function testDisconnectAllDatabaseTableAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable($Object);
			$this->assertFalse($Return);
		}
	
		/**
		 * testDisconnectAllCorrectData
		 * Tests if DisconnectAll methods will accept all data correctly. 
		 *
		 * @access public
		*/
		public function testDisconnectAllCorrectData() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->ConnectAll();
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->DisconnectAll();
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
	}
?>