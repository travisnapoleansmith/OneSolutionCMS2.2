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
	 * Tier 3 SOAP Set Database All Test
	 *
	 * This file is designed to test Tier 3's setDatabaseAll method with SOAP.
	 *
	 * @author Travis Napolean Smith
	 * @copyright Copyright (c) 1999 - 2013 One Solution CMS
	 * @copyright PHP - Copyright (c) 2005 - 2013 One Solution CMS
	 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
	 * @version PHP - 2.2.1
	 * @version C++ - Unknown
 	*/
	class Tier3SoapSetDatabaseAllTest extends UnitTestCase {
		
		/**
		 * Tier2Database: SOAP ProtectionTier object for Tier 3
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
		 * Create an instance of Tier3SoapSetDatabaseAllTest.
		 *
		 * @access public
		*/	
		public function Tier3SoapSetDatabaseAllTest () {
			// Settings.ini File
			$credentaillogonarray = $GLOBALS['credentaillogonarray'];
			$this->ServerName = $credentaillogonarray[0];
			$this->Username = $credentaillogonarray[1];
			$this->Password = $credentaillogonarray[2];
			$this->DatabaseName = $credentaillogonarray[3];
			
			$this->Tier3Protection = Tier3SetupSoap();
		}
		
		/**
		 * testSoapSetDatabaseAllNull
		 * Tests if setDatabaseAll methods will accept Hostame, User, Password and DatabaseName all as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll(NULL, NULL, NULL, NULL);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllHostnameNull
		 * Tests if setDatabaseAll methods will accept Hostame as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllHostnameNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll(NULL, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllUserNull
		 * Tests if setDatabaseAll methods will accept User as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllUserNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, NULL, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllPasswordNull
		 * Tests if setDatabaseAll methods will accept Password as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllPasswordNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, NULL, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllDatabaseNameNull
		 * Tests if setDatabaseAll methods will accept DatabaseName as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllDatabaseNameNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, NULL);
			$this->assertFalse($Return);
			
		}

		/**
		 * testSoapSetDatabaseAllAsArray
		 * Tests if setDatabaseAll methods will accept Hostame, User, Password and DatabaseName all as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll(array(1), array(1), array(1), array(1));
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllHostnameAsArray
		 * Tests if setDatabaseAll methods will accept Hostame as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllHostnameAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll(array(1), $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllUsernameAsArray
		 * Tests if setDatabaseAll methods will accept Username as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllUsernameAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, array(1), $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllPasswordAsArray
		 * Tests if setDatabaseAll methods will accept Password as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllPasswordAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, array(1), $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllDatabaseNameAsArray
		 * Tests if setDatabaseAll methods will accept DatabaseName as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllDatabaseNameAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, array(1));
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllAsObject
		 * Tests if setDatabaseAll methods will accept Hostame, User, Password and DatabaseName all as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass();
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($Object, $Object, $Object, $Object);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllHostnameAsObject
		 * Tests if setDatabaseAll methods will accept Hostame as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllHostnameAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass();
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($Object, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllUsernameAsObject
		 * Tests if setDatabaseAll methods will accept Username as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllUsernameAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass();
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $Object, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllPasswordAsObject
		 * Tests if setDatabaseAll methods will accept Password as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllPasswordAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass();
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $Object, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllDatabaseNameAsObject
		 * Tests if setDatabaseAll methods will accept DatabaseName as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllDatabaseNameAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass();
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $Object);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllCorrectData
		 * Tests if setDatabaseAll methods will accept all data correctly with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllCorrectData() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'stdClass');
			
		}
	}
?>