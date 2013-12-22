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
	 * Tier 3 SOAP Disconnect All Test
	 *
	 * This file is designed to test Tier 3's DisconnectAll method with SOAP.
	 *
	 * @author Travis Napolean Smith
	 * @copyright Copyright (c) 1999 - 2013 One Solution CMS
	 * @copyright PHP - Copyright (c) 2005 - 2013 One Solution CMS
	 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
	 * @version PHP - 2.2.1
	 * @version C++ - Unknown
 	*/
	class Tier3SoapDisconnectAllTest extends UnitTestCase {
		
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
		 * Create an instance of Tier3SoapDisconnectAllTest.
		 *
		 * @access public
		*/	
		public function Tier3SoapDisconnectAllTest () {
			// Settings.ini File
			$credentaillogonarray = $GLOBALS['credentaillogonarray'];
			$this->ServerName = $credentaillogonarray[0];
			$this->Username = $credentaillogonarray[1];
			$this->Password = $credentaillogonarray[2];
			$this->DatabaseName = $credentaillogonarray[3];
			
			$this->Tier3Protection = Tier3SetupSoap();
		}
		
		
		/**
		 * testSoapDisconnectAllAllNull
		 * Tests if DisconnectAll methods will accept Hostame, User, Password and DatabaseName all as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllAllNull() {
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
			$Return = $this->Tier3Protection->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(NULL);
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapDisconnectAllHostnameNull
		 * Tests if DisconnectAll methods will accept Hostame as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllHostnameNull() {
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
			$Return = $this->Tier3Protection->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(NULL);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapDisconnectAllUsernameNull
		 * Tests if DisconnectAll methods will accept User as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllUsernameNull() {
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
			$Return = $this->Tier3Protection->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(NULL);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapDisconnectAllPasswordNull
		 * Tests if DisconnectAll methods will accept Password as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllPasswordNull() {
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
			$Return = $this->Tier3Protection->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(NULL);
			$this->assertFalse($Return);;
			
		}
		
		/**
		 * testSoapDisconnectAllDatabaseNameNull
		 * Tests if DisconnectAll methods will accept DatabaseName as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllDatabaseNameNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(NULL);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapDisconnectAllAllAsArray
		 * Tests if DisconnectAll methods will accept Hostame, User, Password and DatabaseName all as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllAllAsArray() {
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
			$Return = $this->Tier3Protection->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(array(1));
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapDisconnectAllHostnameAsArray
		 * Tests if DisconnectAll methods will accept Hostame as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllHostnameAsArray() {
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
			$Return = $this->Tier3Protection->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(array(1));
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapDisconnectAllUsernameAsArray
		 * Tests if DisconnectAll methods will accept User as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllUsernameAsArray() {
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
			$Return = $this->Tier3Protection->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(array(1));
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapDisconnectAllPasswordAsArray
		 * Tests if DisconnectAll methods will accept Password as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllPasswordAsArray() {
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
			$Return = $this->Tier3Protection->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(array(1));
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapDisconnectAllDatabaseNameAsArray
		 * Tests if DisconnectAll methods will accept DatabaseName as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllDatabaseNameAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(array(1));
			$this->assertFalse($Return);
			
		}

		/**
		 * testSoapDisconnectAllAllAsObject
		 * Tests if DisconnectAll methods will accept Hostame, User, Password and DatabaseName all as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllAllAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($Object, $Object, $Object, $Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable($Object);
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapDisconnectAllHostnameAsObject
		 * Tests if DisconnectAll methods will accept Hostame as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllHostnameAsObject() {
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
			$Return = $this->Tier3Protection->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable($Object);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapDisconnectAllUsernameAsObject
		 * Tests if DisconnectAll methods will accept User as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllUsernameAsObject() {
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
			$Return = $this->Tier3Protection->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable($Object);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapDisconnectAllPasswordAsObject
		 * Tests if DisconnectAll methods will accept Password as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllPasswordAsObject() {
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
			$Return = $this->Tier3Protection->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable($Object);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapDisconnectAllDatabaseNameAsObject
		 * Tests if DisconnectAll methods will accept DatabaseName as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllDatabaseNameAsObject() {
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
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable($Object);
			$this->assertFalse($Return);
			
		}

		/**
		 * testSoapDisconnectAllDatabaseTableNull
		 * Tests if DisconnectAll methods will accept Database Table as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllDatabaseTableNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(NULL);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapDisconnectAllDatabaseTableAsArray
		 * Tests if DisconnectAll methods will accept Database Table as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllDatabaseTableAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable(array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable(array(1));
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapDisconnectAllDatabaseTableAsObject
		 * Tests if DisconnectAll methods will accept Database Table as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllDatabaseTableAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->ConnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->DisconnectAll();
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable($Object);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapDisconnectAllCorrectData
		 * Tests if DisconnectAll methods will accept all data correctly with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllCorrectData() {
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
			$Return = $this->Tier3Protection->ConnectAll();
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->DisconnectAll();
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');		}
		
	}
?>