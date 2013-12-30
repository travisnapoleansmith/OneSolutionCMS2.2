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
	
	// All Tier Abstract
	require_once "$HOME/ModulesAbstract/GlobalTierAbstract.php";
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
	 * Tier 2 SOAP Set Database All Test
	 *
	 * This file is designed to test Tier 2's setDatabaseAll method with SOAP.
	 *
	 * @author Travis Napolean Smith
	 * @copyright Copyright (c) 1999 - 2013 One Solution CMS
	 * @copyright PHP - Copyright (c) 2005 - 2013 One Solution CMS
	 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
	 * @version PHP - 2.2.1
	 * @version C++ - Unknown
 	*/
	class Tier2SoapSetDatabaseAllTest extends UnitTestCase {
		
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
		 * Create an instance of Tier2SoapSetDatabaseAllTest.
		 *
		 * @access public
		*/	
		public function Tier2SoapSetDatabaseAllTest () {
			// Settings.ini File
			$credentaillogonarray = $GLOBALS['credentaillogonarray'];
			$this->ServerName = $credentaillogonarray[0];
			$this->Username = $credentaillogonarray[1];
			$this->Password = $credentaillogonarray[2];
			$this->DatabaseName = $credentaillogonarray[3];
			
			$this->Tier2Database = Tier2SetupSoap();
		}
		
		/**
		 * testSoapSetDatabaseAllNull
		 * Tests if setDatabaseAll methods will accept Hostame, User, Password and DatabaseName all as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllNull() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll(NULL, NULL, NULL, NULL);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllHostnameNull
		 * Tests if setDatabaseAll methods will accept Hostame as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllHostnameNull() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll(NULL, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllUserNull
		 * Tests if setDatabaseAll methods will accept User as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllUserNull() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, NULL, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllPasswordNull
		 * Tests if setDatabaseAll methods will accept Password as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllPasswordNull() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, NULL, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllDatabaseNameNull
		 * Tests if setDatabaseAll methods will accept DatabaseName as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllDatabaseNameNull() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, NULL);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllAsArray
		 * Tests if setDatabaseAll methods will accept Hostame, User, Password and DatabaseName all as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllAsArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll(array(1), array(1), array(1), array(1));
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllHostnameAsArray
		 * Tests if setDatabaseAll methods will accept Hostame as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllHostnameAsArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll(array(1), $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllUsernameAsArray
		 * Tests if setDatabaseAll methods will accept User as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllUsernameAsArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, array(1), $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllPasswordAsArray
		 * Tests if setDatabaseAll methods will accept Password as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllPasswordAsArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, array(1), $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllDatabaseNameAsArray
		 * Tests if setDatabaseAll methods will accept DatabaseName as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllDatabaseNameAsArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, array(1));
			$this->assertFalse($Return);
			
		}

		/**
		 * testSoapSetDatabaseAllAsObject
		 * Tests if setDatabaseAll methods will accept Hostame, User, Password and DatabaseName all as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllAsObject() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($Object, $Object, $Object, $Object);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllHostnameAsObject
		 * Tests if setDatabaseAll methods will accept Hostame as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllHostnameAsObject() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($Object, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllUsernameAsObject
		 * Tests if setDatabaseAll methods will accept User as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllUsernameAsObject() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $Object, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllPasswordAsObject
		 * Tests if setDatabaseAll methods will accept Password as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllPasswordAsObject() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $Object, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllDatabaseNameAsObject
		 * Tests if setDatabaseAll methods will accept DatabaseName as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllDatabaseNameAsObject() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $Object);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapSetDatabaseAllCorrectData
		 * Tests if setDatabaseAll methods will accept all data correctly with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapSetDatabaseAllCorrectData() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'stdClass');
			
		}
	}
?>