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
	 * Tier 2 Set Database All Test
	 *
	 * This file is designed to test Tier 2's setDatabaseAll method.
	 *
	 * @author Travis Napolean Smith
	 * @copyright Copyright (c) 1999 - 2013 One Solution CMS
	 * @copyright PHP - Copyright (c) 2005 - 2013 One Solution CMS
	 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
	 * @version PHP - 2.2.1
	 * @version C++ - Unknown
 	*/
	class Tier2SetDatabaseAllTest extends UnitTestCase {
		
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
		 * Create an instance of Tier2SetDatabaseAllTest.
		 *
		 * @access public
		*/	
		public function Tier2SetDatabaseAllTest () {
			// Settings.ini File
			$credentaillogonarray = $GLOBALS['credentaillogonarray'];
			$this->ServerName = $credentaillogonarray[0];
			$this->Username = $credentaillogonarray[1];
			$this->Password = $credentaillogonarray[2];
			$this->DatabaseName = $credentaillogonarray[3];
			
			$this->Tier2Database = new DataAccessLayer();
		}
		
		/**
		 * testSetDatabaseAllAsNull
		 * Tests if setDatabaseAll methods will accept Hostame, User, Password and DatabaseName all as NULL. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllAsNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll(NULL, NULL, NULL, NULL);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSetDatabaseAllHostnameAsNull
		 * Tests if setDatabaseAll methods will accept Hostame as NULL. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllHostnameAsNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll(NULL, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSetDatabaseAllUserAsNull
		 * Tests if setDatabaseAll methods will accept User as NULL. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllUserAsNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, NULL, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSetDatabaseAllPasswordAsNull
		 * Tests if setDatabaseAll methods will accept Password as NULL. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllPasswordAsNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, NULL, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSetDatabaseAllDatabaseNameAsNull
		 * Tests if setDatabaseAll methods will accept DatabaseName as NULL. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllDatabaseNameAsNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, NULL);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSetDatabaseAllHostnameAsArray
		 * Tests if setDatabaseAll methods will accept Hostame as an array. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllHostnameAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll(array(1), $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSetDatabaseAllUserAsArray
		 * Tests if setDatabaseAll methods will accept User as an array. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllUserAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, array(1), $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSetDatabaseAllPasswordAsArray
		 * Tests if setDatabaseAll methods will accept Password as an array. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllPasswordAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, array(1), $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSetDatabaseAllDatabaseNameAsArray
		 * Tests if setDatabaseAll methods will accept DatabaseName as an array. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllDatabaseNameAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, array(1));
			$this->assertFalse($Return);
			
		}
		/**
		 * testSetDatabaseAllDataAsArray
		 * Tests if setDatabaseAll methods will accept all data as an array. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllDataAsArray() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll(array(1), array(1), array(1), array(1));
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSetDatabaseAllHostnameAsObject
		 * Tests if setDatabaseAll methods will accept Hostame as an object. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllHostnameAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($Object, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSetDatabaseAllUserAsObject
		 * Tests if setDatabaseAll methods will accept User as an object. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllUserAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $Object, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSetDatabaseAllPasswordAsObject
		 * Tests if setDatabaseAll methods will accept Password as an object. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllPasswordAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $Object, $this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSetDatabaseAllDatabaseNameAsObject
		 * Tests if setDatabaseAll methods will accept DatabaseName as an object. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllDatabaseNameAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $Object);
			$this->assertFalse($Return);
			
		}
		/**
		 * testSetDatabaseAllDataAsObject
		 * Tests if setDatabaseAll methods will accept all data as an object. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllDataAsObject() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($Object, $Object, $Object, $Object);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSetDatabaseAllCorrectData
		 * Tests if setDatabaseAll methods will accept all data correctly. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllCorrectData() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
	}
?>