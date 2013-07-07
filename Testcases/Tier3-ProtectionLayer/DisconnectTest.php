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
	 * Tier 3 Disconnect Test
	 *
	 * This file is designed to test Tier 3's Disconnect method.
	 *
	 * @author Travis Napolean Smith
	 * @copyright Copyright (c) 1999 - 2013 One Solution CMS
	 * @copyright PHP - Copyright (c) 2005 - 2013 One Solution CMS
	 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
	 * @version PHP - 2.2.1
	 * @version C++ - Unknown
 	*/
	class Tier3DisconnectTest extends UnitTestCase {
		
		/**
		 * Tier3Protection: ProtectionLayer object for Tier 3
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
		 * Create an instance of Tier3DisconnectTest.
		 *
		 * @access public
		*/	
		public function Tier3DisconnectTest () {
			// Settings.ini File
			$credentaillogonarray = $GLOBALS['credentaillogonarray'];
			$this->ServerName = $credentaillogonarray[0];
			$this->Username = $credentaillogonarray[1];
			$this->Password = $credentaillogonarray[2];
			$this->DatabaseName = $credentaillogonarray[3];
			
			$this->Tier3Protection = new ProtectionLayer();
		}
		
		
		/**
		 * testDisconnectAllNull
		 * Tests if Disconnect methods will accept Hostame, User, Password and DatabaseName all as NULL. 
		 *
		 * @access public
		*/
		public function testDisconnectAllNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = $this->Tier3Protection->setDatabaseAll(NULL, NULL, NULL, NULL);
			$this->assertFalse($Return);
			
			$Return = $this->Tier3Protection->createDatabaseTable(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect(NULL);
			$this->assertFalse($Return);
			
			$Return = $this->Tier3Protection->createDatabaseTable(NULL);
			$this->assertFalse($Return);
		}
		
		/**
		 * testDisconnectHostnameNull
		 * Tests if Disconnect methods will accept Hostame as NULL. 
		 *
		 * @access public
		*/
		public function testDisconnectHostnameNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = $this->Tier3Protection->setDatabaseAll(NULL, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testDisconnectUserNull
		 * Tests if Disconnect methods will accept User as NULL. 
		 *
		 * @access public
		*/
		public function testDisconnectUserNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, NULL, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testDisconnectPasswordNull
		 * Tests if Disconnect methods will accept Password as NULL. 
		 *
		 * @access public
		*/
		public function testDisconnectPasswordNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, NULL, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testDisconnectDatabaseNameNull
		 * Tests if Disconnect methods will accept DatabaseName as NULL. 
		 *
		 * @access public
		*/
		public function testDisconnectDatabaseNameNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, NULL);
			$this->assertFalse($Return);
			
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testDisconnectDatabaseTableInvalidName
		 * Tests if Disconnect methods will accept Database Table as an invalid name. 
		 *
		 * @access public
		*/
		public function testDisconnectDatabaseTableInvalidName() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, NULL);
			$this->assertFalse($Return);
			
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			try {
				$Return = TRUE;
				$Return = $this->Tier3Protection->Connect('INVALID');
			} catch (Exception $e) {
				$this->pass();
			}
			
			//$this->assertIsA($Return, 'Exception');
			
			try {
				$Return = TRUE;
				$Return = $this->Tier3Protection->Disconnect('INVALID');
			} catch (Exception $e) {
				$this->pass();
			}
			
			//$this->assertIsA($Return, 'Exception');
			
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testDisconnectCorrectData
		 * Tests if Disconnect methods will accept all data correctly. 
		 *
		 * @access public
		*/
		public function testDisconnectCorrectData() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = NULL;
			$Return = $this->Tier3Protection->Connect('TEST');
			
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = NULL;
			$Return = $this->Tier3Protection->Disconnect('TEST');
			
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
	}
?>