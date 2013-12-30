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
	
	// Tier 3 Settings
	require_once "$HOME/Configuration/Tier3ProtectionLayerSettings.php";
	
	// All Tier Abstract
	require_once "$HOME/ModulesAbstract/GlobalTierAbstract.php";
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
	 * Tier 3 SoapDisconnect Test
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
	class Tier3SoapDisconnectTest extends UnitTestCase {
		
		/**
		 * Tier3Protection: SOAP DataAccessTier object for Tier 3
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
		 * Create an instance of Tier3SoapDisconnectTest.
		 *
		 * @access public
		*/	
		public function Tier3SoapDisconnectTest () {
			// Settings.ini File
			$credentaillogonarray = $GLOBALS['credentaillogonarray'];
			$this->ServerName = $credentaillogonarray[0];
			$this->Username = $credentaillogonarray[1];
			$this->Password = $credentaillogonarray[2];
			$this->DatabaseName = $credentaillogonarray[3];
			
			$this->Tier3Protection = Tier3SetupSoap();
		}
		
		/**
		 * testSoapDisconnectAllNull
		 * Tests if Disconnect methods will accept Hostame, User, Password and DatabaseName all as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
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
			$Return = $this->Tier3Protection->Disconnect(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable(NULL);
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapDisconnectHostnameNull
		 * Tests if Disconnect methods will accept Hostame as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectHostnameNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll(NULL, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(NULL);
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapDisconnectUsernameNull
		 * Tests if Disconnect methods will accept Username as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectUsernameNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, NULL, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(NULL);
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapDisconnectPasswordNull
		 * Tests if Disconnect methods will accept Password as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectPasswordNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, NULL, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(NULL);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapDisconnectDatabaseNameNull
		 * Tests if Disconnect methods will accept DatabaseName as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectDatabaseNameNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable(NULL);
			$this->assertFalse($Return);
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(NULL);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapDisconnectAllAsArray
		 * Tests if Disconnect methods will accept Hostame, User, Password and DatabaseName all as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
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
			$Return = $this->Tier3Protection->Disconnect(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable(array(1));
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapDisconnectHostnameAsArray
		 * Tests if Disconnect methods will accept Hostame as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectHostnameAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll(array(1), $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(array(1));
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapDisconnectUsernameAsArray
		 * Tests if Disconnect methods will accept User as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectUsernameAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, array(1), $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(array(1));
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapDisconnectPasswordAsArray
		 * Tests if Disconnect methods will accept Password as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectPasswordAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, array(1), $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(array(1));
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapDisconnectDatabaseNameAsArray
		 * Tests if Disconnect methods will accept DatabaseName as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectDatabaseNameAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable(array(1));
			$this->assertFalse($Return);
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(array(1));
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapDisconnectAllAsObject
		 * Tests if Disconnect methods will accept Hostame, User, Password and DatabaseName all as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
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
			$Return = $this->Tier3Protection->Disconnect($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable($Object);
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapDisconnectHostnameAsObject
		 * Tests if Disconnect methods will accept Hostame as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectHostnameAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($Object, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable($Object);
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapDisconnectUsernameAsObject
		 * Tests if Disconnect methods will accept User as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectUsernameAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $Object, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable($Object);
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapDisconnectPasswordAsObject
		 * Tests if Disconnect methods will accept Password as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectPasswordAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $Object, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable($Object);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapDisconnectDatabaseNameAsObject
		 * Tests if Disconnect methods will accept DatabaseName as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectDatabaseNameAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable($Object);
			$this->assertFalse($Return);
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable($Object);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapDisconnectDatabaseTableInvalidName
		 * Tests if Disconnect methods will accept Database Table as an invalid name with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectDatabaseTableInvalidName() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
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
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapDisconnectDatabaseTableNull
		 * Tests if Disconnect methods will accept Database Table as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectDatabaseTableNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapDisconnectDatabaseTableAsArray
		 * Tests if Disconnect methods will accept Database Table as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectDatabaseTableAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		
		/**
		 * testSoapDisconnectDatabaseTableAsObject
		 * Tests if Disconnect methods will accept Database Table as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectDatabaseTableAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapDisconnectCorrectData
		 * Tests if Disconnect methods will accept all data correctly with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectCorrectData() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Connect('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->Disconnect('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
	}
?>