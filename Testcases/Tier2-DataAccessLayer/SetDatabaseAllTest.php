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
		 * Create an instance of Tier2SetDatabaseAllTest.
		 *
		 * @access public
		*/	
		public function Tier2SetDatabaseAllTest () {
			$this->Tier2Database = new DataAccessLayer();
		}
		
		/**
		 * testSetDatabaseAllNull
		 * Tests if setDatabaseAll methods will accept Hostame, User, Password and DatabaseName all as NULL. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllNull() {
			$Return = NULL;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->setDatabaseAll(NULL, NULL, NULL, NULL);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSetDatabaseAllHostnameNull
		 * Tests if setDatabaseAll methods will accept Hostame as NULL. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllHostnameNull() {
			$Return = NULL;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->setDatabaseAll(NULL, 'TEST', 'TEST', 'TEST');
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSetDatabaseAllUserNull
		 * Tests if setDatabaseAll methods will accept User as NULL. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllUserNull() {
			$Return = NULL;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->setDatabaseAll('TEST', NULL, 'TEST', 'TEST');
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSetDatabaseAllPasswordNull
		 * Tests if setDatabaseAll methods will accept Password as NULL. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllPasswordNull() {
			$Return = NULL;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->setDatabaseAll('TEST', 'TEST', NULL, 'TEST');
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSetDatabaseAllDatabaseNameNull
		 * Tests if setDatabaseAll methods will accept DatabaseName as NULL. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllDatabaseNameNull() {
			$Return = NULL;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->setDatabaseAll('TEST', 'TEST', 'TEST', NULL);
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSetDatabaseAllDatabaseNameNull
		 * Tests if setDatabaseAll methods will accept all data correctly. 
		 *
		 * @access public
		*/
		public function testSetDatabaseAllCorrectData() {
			$Return = NULL;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->setDatabaseAll('TEST', 'TEST', 'TEST', 'TEST');
			$this->assertFalse($Return);
			
		}
	}
?>