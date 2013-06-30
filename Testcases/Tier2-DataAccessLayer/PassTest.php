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
	 * Tier 2 Pass Test
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
	class Tier2PassTest extends UnitTestCase {
		
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
		 * Create an instance of Tier2PassTest.
		 *
		 * @access public
		*/	
		public function Tier2PassTest () {
			// Settings.ini File
			$credentaillogonarray = $GLOBALS['credentaillogonarray'];
			$this->ServerName = $credentaillogonarray[0];
			$this->Username = $credentaillogonarray[1];
			$this->Password = $credentaillogonarray[2];
			$this->DatabaseName = $credentaillogonarray[3];
			
			$this->Tier2Database = new DataAccessLayer();
		}
		
		/**
		 * testPassNull
		 * Tests if pass method will accept All Values as NULL. 
		 *
		 * @access public
		*/
		public function testPassAllNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->pass(NULL, NULL, NULL);
			$this->assertFalse($Return);
		}
		
		/**
		 * testPassDatabaseTableNull
		 * Tests if pass method will accept Database Table as NULL. 
		 *
		 * @access public
		*/
		public function testPassDatabaseTableNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->pass(NULL, 'FUNCTION', 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testPassFunctionNull
		 * Tests if pass method will accept Function as NULL. 
		 *
		 * @access public
		*/
		public function testPassFunctionNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->pass('DATABASETABLE', NULL, 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testPassFunctionArgumentsNull
		 * Tests if pass method will accept Function Arguments as NULL. 
		 *
		 * @access public
		*/
		public function testPassFunctionArgumentsNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->pass('DATABASETABLE', 'FUNCTION', NULL);
			$this->assertFalse($Return);
		}
		
		// CONTINUE HERE
		/**
		 * testPassNotSetAll
		 * Tests if pass method will accept all arguments that are not set. 
		 *
		 * @access public
		*/
		public function testPassNotSetAll() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->pass('DATABASETABLE', 'FUNCTION', 'FUNCTIONARGUMENT');
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testPassNotSetDatabaseTable
		 * Tests if pass method will accept a Database Table Name that has not been set, but all other arguments are valid. 
		 *
		 * @access public
		*/
		public function testPassNotSetDatabaseTable() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->pass('DATABASETABLE', 'getIdnumber', array());
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testPassFunctionArgumentNotAsArray
		 * Tests if pass method will accept a Function Arguments are not an array. 
		 *
		 * @access public
		*/
		public function testPassFunctionArgumentNotAsArray() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->createDatabaseTable('DATABASETABLE');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->pass('DATABASETABLE', 'getIdnumber', 'TEST');
			
			$this->assertFalse($Return);
			
			$Return = $this->Tier2Database->destroyDatabaseTable('DATABASETABLE');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testPassCorrectDataFunctionArgumentsEmptyArray
		 * Tests if pass method will accept all data correctly with Function Arguments being an empty array. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataFunctionArgumentsEmptyArray() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = $this->Tier2Database->pass('TEST', 'getIdnumber', array());
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testPassCorrectDataFunctionArgumentsNonEmptyArray
		 * Tests if pass method will accept all data correctly with Function Arguments being an non-empty array. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataFunctionArgumentsNonEmptyArray() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = $this->Tier2Database->pass('TEST', 'setIdnumber', array('id' => 1));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testPassCorrectDataFunctionArgumentsEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an empty array with a int return. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataFunctionArgumentsEmptyArrayWithIntReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = $this->Tier2Database->pass('TEST', 'setIdnumber', array('id' => 1));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->pass('TEST', 'getIdnumber', array());
			$this->assertIdentical($Return, 1);
			
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testPassCorrectDataFunctionArgumentsNonEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an non-empty array with a int return. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataFunctionArgumentsNonEmptyArrayWithIntReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = $this->Tier2Database->pass('TEST', 'setIdnumber', array('id' => 1));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->pass('TEST', 'getIdnumber', array('id' => 1));
			$this->assertIdentical($Return, 1);
			
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
		}
		
		/**
		 * testPassCorrectDataFunctionArgumentsEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an empty array with a string return. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataFunctionArgumentsEmptyArrayWithStringReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = $this->Tier2Database->pass('TEST', 'setIdnumber', array('id' => '1'));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->pass('TEST', 'getIdnumber', array());
			$this->assertIdentical($Return, '1');
			
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testPassCorrectDataFunctionArgumentsNonEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an non-empty array with a string return. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataFunctionArgumentsNonEmptyArrayWithStringReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = $this->Tier2Database->pass('TEST', 'setIdnumber', array('id' => '1'));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->pass('TEST', 'getIdnumber', array('id' => '1'));
			$this->assertIdentical($Return, '1');
			
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
		}
		
		/**
		 * testPassCorrectDataFunctionArgumentsNonEmptyArrayWithArrayReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an non-empty array with an array return. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataFunctionArgumentsNonEmptyArrayWithArrayReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = $this->Tier2Database->pass('TEST', 'setIdnumber', array(array('id' => '1', 'id2' => '3')));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->pass('TEST', 'getIdnumber', array());
			$this->assertIsA($Return, 'array');
			
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
		}
		
		
		/**
		 * testPassCorrectDataCheckPassFunctionArgumentsEmptyArray
		 * Tests if pass method will accept all data correctly for a check pass with Function Arguments being an empty array. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassFunctionArgumentsEmptyArray() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->pass('TEST', 'getDatabasename', array());
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		// LEFT OFF HERE
		/**
		 * testPassCorrectDataCheckPassFunctionArgumentsNonEmptyArray
		 * Tests if pass method will accept all data correctly for a check pass with Function Arguments being an non-empty array. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassFunctionArgumentsNonEmptyArray() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->pass('TEST', 'setDatabasename', array('id' => 1));
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}

		/**
		 * testPassCorrectDataCheckPassFunctionArgumentsEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly for a check pass with Function Arguments being an empty array with a int return. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassFunctionArgumentsEmptyArrayWithIntReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->pass('TEST', 'setDatabasename', array('id' => 1));
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->pass('TEST', 'getDatabasename', array());
			$this->assertIdentical($Return, 1);
			
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testPassCorrectDataCheckPassFunctionArgumentsNonEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly for a check pass with Function Arguments being an non-empty array with a int return. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassFunctionArgumentsNonEmptyArrayWithIntReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->pass('TEST', 'setDatabasename', array('id' => 1));
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->pass('TEST', 'getDatabasename', array('id' => 1));
			$this->assertIdentical($Return, 1);
			
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
		}
		
		/**
		 * testPassCorrectDataCheckPassFunctionArgumentsEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly for a check pass with Function Arguments being an empty array with a string return. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassFunctionArgumentsEmptyArrayWithStringReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->pass('TEST', 'setDatabasename', array('id' => '1'));
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->pass('TEST', 'getDatabasename', array());
			$this->assertIdentical($Return, '1');
			
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
		}
		
		/**
		 * testPassCorrectDataCheckPassFunctionArgumentsNonEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly for a check pass with Function Arguments being an non-empty array with a string return. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassFunctionArgumentsNonEmptyArrayWithStringReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->pass('TEST', 'setDatabasename', array('id' => '1'));
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->pass('TEST', 'getDatabasename', array('id' => '1'));
			$this->assertIdentical($Return, '1');
			
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
		}
		
		/**
		 * testPassCorrectDataCheckPassFunctionArgumentsNonEmptyArrayWithArrayReturn
		 * Tests if pass method will accept all data correctly for a check pass with Function Arguments being an non-empty array with an array return. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassFunctionArgumentsNonEmptyArrayWithArrayReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->pass('TEST', 'setDatabasename', array(array('id' => '1', 'id2' => '3')));
			$this->assertIsA($Return, 'DataAccessLayer');
			
			$Return = $this->Tier2Database->pass('TEST', 'getDatabasename', array());
			$this->assertIsA($Return, 'array');
			
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'DataAccessLayer');
		}
	}
?>