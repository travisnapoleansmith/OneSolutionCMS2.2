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
	
	// All Tier Abstract
	require_once "$HOME/ModulesAbstract/LayerModulesAbstract.php";
	
	// Tiers Modules Abstract
	require_once "$HOME/ModulesAbstract/Tier2DataAccessLayer/Tier2DataAccessLayerModulesAbstract.php";
	
	// Tiers Interface Includes
	require_once "$HOME/ModulesInterfaces/Tier2DataAccessLayer/Tier2DataAccessLayerModulesInterfaces.php";

	// Tiers Includes
	require_once "$HOME/Tier2-DataAccessLayer/ClassDataAccessLayer.php";
	
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
		 * testDisconnectAllNull
		 * Tests if Disconnect methods will accept Hostame, User, Password and DatabaseName all as NULL. 
		 *
		 * @access public
		*/
		public function testDisconnectAllNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->setDatabaseAll(NULL, NULL, NULL, NULL);
			$this->assertFalse($Return);
			
			$this->Tier2Database->setDatabaseTable(NULL);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect(NULL);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect(NULL);
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
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->setDatabaseAll(NULL, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$this->Tier2Database->setDatabaseTable($this->DatabaseName);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect($this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect($this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testDisconnectUserNull
		 * Tests if Disconnect methods will accept User as NULL. 
		 *
		 * @access public
		*/
		public function testDisconnectUserNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, NULL, $this->Password, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$this->Tier2Database->setDatabaseTable($this->DatabaseName);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect($this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect($this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testDisconnectPasswordNull
		 * Tests if Disconnect methods will accept Password as NULL. 
		 *
		 * @access public
		*/
		public function testDisconnectPasswordNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, NULL, $this->DatabaseName);
			$this->assertFalse($Return);
			
			$this->Tier2Database->setDatabaseTable($this->DatabaseName);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect($this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect($this->DatabaseName);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testDisconnectDatabaseNameNull
		 * Tests if Disconnect methods will accept DatabaseName as NULL. 
		 *
		 * @access public
		*/
		public function testDisconnectDatabaseNameNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, NULL);
			$this->assertFalse($Return);
			
			$this->Tier2Database->setDatabaseTable($this->DatabaseName);
			
			//$this->expectException('Key Doesn\'t Exist!');
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect($this->DatabaseName);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect($this->DatabaseName);
			$this->assertFalse($Return);
			
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
			
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, NULL);
			$this->assertFalse($Return);
			
			$this->Tier2Database->setDatabaseTable($this->DatabaseName);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Connect('INVALID');
			$this->assertIsA($Return, 'Exception');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->Disconnect('INVALID');
			$this->assertIsA($Return, 'Exception');
			
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
			
			$Return = $this->Tier2Database->setDatabaseAll($this->ServerName, $this->Username, $this->Password, $this->DatabaseName);
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$this->Tier2Database->setDatabaseTable($this->DatabaseName);
			
			$Return = NULL;
			$Return = $this->Tier2Database->Connect($this->DatabaseName);
			
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = NULL;
			$Return = $this->Tier2Database->Disconnect($this->DatabaseName);
			
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
	}
?>