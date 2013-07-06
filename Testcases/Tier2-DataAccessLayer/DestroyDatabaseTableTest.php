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
	
	// Tier 2 Modules
	require_once "$HOME/Modules/Tier2DataAccessLayer/Core/MySqlConnect/ClassMySqlConnect.php";
	
	/**
	 * Tier 2 Destroy Database Table Test
	 *
	 * This file is designed to test Tier 2's destroyDatabaseTable method.
	 *
	 * @author Travis Napolean Smith
	 * @copyright Copyright (c) 1999 - 2013 One Solution CMS
	 * @copyright PHP - Copyright (c) 2005 - 2013 One Solution CMS
	 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
	 * @version PHP - 2.2.1
	 * @version C++ - Unknown
 	*/
	class Tier2DestroyDatabaseTableTest extends UnitTestCase {
		
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
		 * Create an instance of Tier2SetDestroyDatabaseTableTest.
		 *
		 * @access public
		*/	
		public function Tier2DestroyDatabaseTableTest () {
			// Settings.ini File
			$credentaillogonarray = $GLOBALS['credentaillogonarray'];
			$this->ServerName = $credentaillogonarray[0];
			$this->Username = $credentaillogonarray[1];
			$this->Password = $credentaillogonarray[2];
			$this->DatabaseName = $credentaillogonarray[3];
			
			$this->Tier2Database = new DataAccessLayer();
		}
		
		/**
		 * testDestroyDatabaseTableNull
		 * Tests if destroyDatabaseTable methods will accept Database Table Name as NULL. 
		 *
		 * @access public
		*/
		public function testDestroyDatabaseTableNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->destroyDatabaseTable(NULL);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testDestroyDatabaseTableArray
		 * Tests if destroyDatabaseTable methods will accept Database Table Name as an Array. 
		 *
		 * @access public
		*/
		public function testDestroyDatabaseTableArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Array = array('TEST', 'TEST2');
			$Return = $this->Tier2Database->destroyDatabaseTable($Array);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testDestroyDatabaseTableRepeatTable
		 * Tests if destroyDatabaseTable methods will accept a tablename that has been destroyed. 
		 *
		 * @access public
		*/
		public function testDestroyDatabaseTableRepeatTable() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->createDatabaseTable('REPEATTABLE');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->destroyDatabaseTable('REPEATTABLE');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$this->expectException();
			$Return = $this->Tier2Database->destroyDatabaseTable('REPEATTABLE');
			//$this->assertIsA($Return, 'Exception');
			
		}
		
		/**
		 * testDestroyDatabaseTableCorrectData
		 * Tests if destroyDatabaseTable methods will accept all data correctly. 
		 *
		 * @access public
		*/
		public function testDestroyDatabaseTableCorrectData() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
	}
?>