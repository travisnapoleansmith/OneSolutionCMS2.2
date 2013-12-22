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
	
	// All Tier Abstract
	require_once "$HOME/ModulesAbstract/LayerModulesAbstract.php";
	
	// Tiers Modules Abstract
	require_once "$HOME/ModulesAbstract/Tier2DataAccessLayer/Tier2DataAccessLayerModulesAbstract.php";
	
	// Tiers Interface Includes
	require_once "$HOME/ModulesInterfaces/Tier2DataAccessLayer/Tier2DataAccessLayerModulesInterfaces.php";

	// Tiers Includes
	require_once "$HOME/Tier2-DataAccessLayer/ClassDataAccessLayer.php";
	require_once "$HOME/Testcases/Tier2-DataAccessLayer/SoapClient.php";
	
	// Tier 2 Modules
	require_once "$HOME/Modules/Tier2DataAccessLayer/Core/MySqlConnect/ClassMySqlConnect.php";
	
	/**
	 * Tier 2 SoapDisconnect Test
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
	class Tier2SoapDisconnectTest extends UnitTestCase {
		
		/**
		 * Tier2Database: SOAP DataAccessTier object for Tier 2
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
		 * Create an instance of Tier2SoapDisconnectTest.
		 *
		 * @access public
		*/	
		public function Tier2SoapDisconnectTest () {
			// Settings.ini File
			$credentaillogonarray = $GLOBALS['credentaillogonarray'];
			$this->ServerName = $credentaillogonarray[0];
			$this->Username = $credentaillogonarray[1];
			$this->Password = $credentaillogonarray[2];
			$this->DatabaseName = $credentaillogonarray[3];
			
			$this->Tier2Database = Tier2SetupSoap();
		}
		
		/**
		 * testSoapDisconnectAllNull
		 * Tests if Disconnect methods will accept Hostame, User, Password and DatabaseName all as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllNull() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
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
		 * testSoapDisconnectHostnameNull
		 * Tests if Disconnect methods will accept Hostame as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectHostnameNull() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll(NULL, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapDisconnectUserNull
		 * Tests if Disconnect methods will accept User as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectUserNull() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, NULL, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapDisconnectPasswordNull
		 * Tests if Disconnect methods will accept Password as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectPasswordNull() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, NULL, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapDisconnectDatabaseNameNull
		 * Tests if Disconnect methods will accept DatabaseName as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectDatabaseNameNull() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		
		
		
		/**
		 * testSoapDisconnectAllAsArray
		 * Tests if Disconnect methods will accept Hostame, User, Password and DatabaseName all as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllAsArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
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
		 * testSoapDisconnectHostnameAsArray
		 * Tests if Disconnect methods will accept Hostame as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectHostnameAsArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll(array(1), $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapDisconnectUsernameAsArray
		 * Tests if Disconnect methods will accept User as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectUsernameAsArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, array(1), $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapDisconnectPasswordAsArray
		 * Tests if Disconnect methods will accept Password as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectPasswordAsArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, array(1), $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapDisconnectDatabaseNameAsArray
		 * Tests if Disconnect methods will accept DatabaseName as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectDatabaseNameAsArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		
		
		/**
		 * testSoapDisconnectAllAsObject
		 * Tests if Disconnect methods will accept Hostame, User, Password and DatabaseName all as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectAllAsObject() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
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
		 * testSoapDisconnectHostnameAsObject
		 * Tests if Disconnect methods will accept Hostame as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectHostnameAsObject() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($Object, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapDisconnectUsernameAsObject
		 * Tests if Disconnect methods will accept User as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectUsernameAsObject() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $Object, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapDisconnectPasswordAsObject
		 * Tests if Disconnect methods will accept Password as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectPasswordAsObject() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $Object, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapDisconnectDatabaseNameAsObject
		 * Tests if Disconnect methods will accept DatabaseName as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectDatabaseNameAsObject() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}

		/**
		 * testSoapDisconnectDatabaseTableAsArray
		 * Tests if Disconnect methods will accept Database Table as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectDatabaseTableAsArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'stdClass');
			
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
		 * testSoapDisconnectDatabaseTableAsObject
		 * Tests if Disconnect methods will accept Database Table as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectDatabaseTableAsObject() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable($Object);
			$this->assertFalse($Return);
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect($Object);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable($Object);
			$this->assertFalse($Return);
			
		}

		/**
		 * testSoapDisconnectDatabaseTableInvalidName
		 * Tests if Disconnect methods will accept Database Table as an invalid name with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectDatabaseTableInvalidName() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
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
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapDisconnectCorrectData
		 * Tests if Disconnect methods will accept all data correctly with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapDisconnectCorrectData() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
	}
?>