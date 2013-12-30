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
	
	// Tier 3 Protection Layer Settings
	require_once "$HOME/Configuration/Tier3ProtectionLayerSettings.php";
	
	// All Tier Abstract
	require_once "$HOME/ModulesAbstract/GlobalTierAbstract.php";
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
	 * Tier 3 Pass Test
	 *
	 * This file is designed to test Tier 3's pass method.
	 *
	 * @author Travis Napolean Smith
	 * @copyright Copyright (c) 1999 - 2013 One Solution CMS
	 * @copyright PHP - Copyright (c) 2005 - 2013 One Solution CMS
	 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
	 * @version PHP - 2.2.1
	 * @version C++ - Unknown
 	*/
	class Tier3PassTest extends UnitTestCase {
		
		/**
		 * Tier3Protection: ProtectionLayer object for Tier 3
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
		 * Create an instance of Tier2PassTest.
		 *
		 * @access public
		*/	
		public function Tier3PassTest () {
			// Settings.ini File
			$credentaillogonarray = $GLOBALS['credentaillogonarray'];
			$this->ServerName = $credentaillogonarray[0];
			$this->Username = $credentaillogonarray[1];
			$this->Password = $credentaillogonarray[2];
			$this->DatabaseName = $credentaillogonarray[3];
			
			$this->Tier3Protection = new ProtectionLayer();
			//$this->Tier3Protection->setPriorLayerModule($this);
			$this->Tier3Protection->createDatabaseTable('ContentLayer');
			$this->Tier3Protection->setDatabaseAll ($this->ServerName, $this->Username, $this->Password, $this->DatabaseName, NULL);
			$this->Tier3Protection->buildModules('ProtectionLayerModules', 'ProtectionLayerTables', 'ProtectionLayerModulesSettings');
		}
		
		/**
		 * testPassNull
		 * Tests if pass method will accept All Values as NULL. 
		 *
		 * @access public
		*/
		public function testPassAllNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass(NULL, NULL, NULL);
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
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass(NULL, 'FUNCTION', 'FUNCTIONARGUMENTS');
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
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('DATABASETABLE', NULL, 'FUNCTIONARGUMENTS');
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
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('DATABASETABLE', 'FUNCTION', NULL);
			$this->assertFalse($Return);
		}
		
		/**
		 * testPassAsArray
		 * Tests if pass method will accept All Values as an Array. 
		 *
		 * @access public
		*/
		public function testPassAllAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass(array(1), array(1), array(1));
			$this->assertFalse($Return);
		}
		
		/**
		 * testPassDatabaseTableAsArray
		 * Tests if pass method will accept Database Table as an Array. 
		 *
		 * @access public
		*/
		public function testPassDatabaseTableAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass(array(1), 'FUNCTION', 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testPassFunctionAsArray
		 * Tests if pass method will accept Function as an Array. 
		 *
		 * @access public
		*/
		public function testPassFunctionAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('DATABASETABLE', array(1), 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testPassFunctionArgumentsAsArray
		 * Tests if pass method will accept Function Arguments as Array. 
		 *
		 * @access public
		*/
		public function testPassFunctionArgumentsAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('DATABASETABLE', 'FUNCTION', array(1));
			$this->assertFalse($Return);
		}
		
		/**
		 * testPassAsObject
		 * Tests if pass method will accept All Values as an Object. 
		 *
		 * @access public
		*/
		public function testPassAllAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass($Object, $Object, $Object);
			$this->assertFalse($Return);
		}
		
		/**
		 * testPassDatabaseTableAsObject
		 * Tests if pass method will accept Database Table as an Object. 
		 *
		 * @access public
		*/
		public function testPassDatabaseTableAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass($Object, 'FUNCTION', 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testPassFunctionAsObject
		 * Tests if pass method will accept Function as an Object. 
		 *
		 * @access public
		*/
		public function testPassFunctionAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('DATABASETABLE', $Object, 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testPassFunctionArgumentsAsObject
		 * Tests if pass method will accept Function Arguments as Object. 
		 *
		 * @access public
		*/
		public function testPassFunctionArgumentsAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('DATABASETABLE', 'FUNCTION', $Object);
			$this->assertFalse($Return);
		}

		
		/**
		 * testPassNotSetAll
		 * Tests if pass method will accept all arguments that are not set. 
		 *
		 * @access public
		*/
		public function testPassNotSetAll() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('DATABASETABLE', 'FUNCTION', 'FUNCTIONARGUMENT');
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
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('DATABASETABLE', 'getIdnumber', array());
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
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('DATABASETABLE');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('DATABASETABLE', 'getIdnumber', 'TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('DATABASETABLE');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testPassCorrectDataFunctionArgumentsEmptyArray
		 * Tests if pass method will accept all data correctly with Function Arguments being an empty array. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataFunctionArgumentsEmptyArray() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getIdnumber', array());
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testPassCorrectDataFunctionArgumentsNonEmptyArray
		 * Tests if pass method will accept all data correctly with Function Arguments being an non-empty array. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataFunctionArgumentsNonEmptyArray() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setIdnumber', array('id' => 1));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testPassCorrectDataFunctionArgumentsEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an empty array with a int return. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataFunctionArgumentsEmptyArrayWithIntReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setIdnumber', array(array('id' => 1)));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getIdnumber', array('id'));
			$this->assertIdentical($Return, 1);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testPassCorrectDataFunctionArgumentsNonEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an non-empty array with a int return. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataFunctionArgumentsNonEmptyArrayWithIntReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setIdnumber', array(array('id' => 1)));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getIdnumber', array('id'));
			$this->assertIdentical($Return, 1);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassCorrectDataFunctionArgumentsEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an empty array with a string return. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataFunctionArgumentsEmptyArrayWithStringReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setIdnumber', array(array('id' => '1')));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getIdnumber', array('id'));
			$this->assertIdentical($Return, '1');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testPassCorrectDataFunctionArgumentsNonEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an non-empty array with a string return. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataFunctionArgumentsNonEmptyArrayWithStringReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setIdnumber', array(array('id' => '1')));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getIdnumber', array('id'));
			$this->assertIdentical($Return, '1');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassCorrectDataFunctionArgumentsNonEmptyArrayWithArrayReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an non-empty array with an array return. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataFunctionArgumentsNonEmptyArrayWithArrayReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setIdnumber', array(array('id' => '1', 'id2' => '3')));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getIdnumber', array());
			$this->assertIsA($Return, 'array');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassCorrectDataCheckPassFunctionArgumentsNonEmptyArray
		 * Tests if pass method will accept all data correctly for a check pass with Function Arguments being an non-empty array. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassFunctionArgumentsNonEmptyArray() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setDatabasename', array('id' => 1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsEmptyArray
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an empty array. This does run Verify for all Modules.
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsEmptyArray() {
			unset($GLOBALS['Tier3DatabaseAllow']['setDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setDatabasename', array('name' => $this->DatabaseName));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getDatabasename', array());
			$this->assertIsA($Return, 'String');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			unset($GLOBALS['Tier3DatabaseDeny']['setDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseDeny']['getDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['getDatabasename'] = 'getDatabasename';
		}
		
		/**
		 * testPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an empty array with a int return. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsEmptyArrayWithIntReturn() {
			unset($GLOBALS['Tier3DatabaseAllow']['setDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setIdnumber', array(array('id' => 1)));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getIdnumber', array('id'));
			$this->assertIdentical($Return, 1);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			unset($GLOBALS['Tier3DatabaseDeny']['setDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseDeny']['getDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['getDatabasename'] = 'getDatabasename';
			
		}
		
		/**
		 * testPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an non-empty array with a int return. This does run Verify for all Modules.
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithIntReturn() {
			unset($GLOBALS['Tier3DatabaseAllow']['setDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setDatabasename', array('id' => 1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getDatabasename', array('id' => 1));
			$this->assertIdentical($Return, 1);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			unset($GLOBALS['Tier3DatabaseDeny']['setDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseDeny']['getDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['getDatabasename'] = 'getDatabasename';
		}
		
		/**
		 * testPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an empty array with a string return. This does run Verify for all Modules.
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsEmptyArrayWithStringReturn() {
			unset($GLOBALS['Tier3DatabaseAllow']['setDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setDatabasename', array('id' => '1'));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getDatabasename', array());
			$this->assertIdentical($Return, '1');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			unset($GLOBALS['Tier3DatabaseDeny']['setDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseDeny']['getDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['getDatabasename'] = 'getDatabasename';
		}
		
		/**
		 * testPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an non-empty array with a string return. This does run Verify for all Modules. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithStringReturn() {
			unset($GLOBALS['Tier3DatabaseAllow']['setDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setDatabasename', array('id' => '1'));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getDatabasename', array('id' => '1'));
			$this->assertIdentical($Return, '1');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			unset($GLOBALS['Tier3DatabaseDeny']['setDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseDeny']['getDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['getDatabasename'] = 'getDatabasename';
		}
		
		/**
		 * testPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithArrayReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an non-empty array with an array return. This does run Verify for all Modules.
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithArrayReturn() {
			unset($GLOBALS['Tier3DatabaseAllow']['setDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setDatabasename', array(array('id' => '1', 'id2' => '3')));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getDatabasename', array());
			$this->assertIsA($Return, 'array');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			unset($GLOBALS['Tier3DatabaseDeny']['setDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseDeny']['getDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['getDatabasename'] = 'getDatabasename';
		}
		
		/**
		 * testPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithNonArrayHookArguments
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an non-empty array and non array Hook Arguments. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithNonArrayHookArguments() {
			unset($GLOBALS['Tier3DatabaseAllow']['setDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setDatabasename', array(array('id' => '1', 'id2' => '3')), 1);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			unset($GLOBALS['Tier3DatabaseDeny']['setDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseDeny']['getDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['getDatabasename'] = 'getDatabasename';
		}
		
		/**
		 * testPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithArrayHookArguments
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an non-empty array and array Hook Arguments. This does run Verify for all Modules.
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithArrayHookArguments() {
			unset($GLOBALS['Tier3DatabaseAllow']['setDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setDatabasename', array(array('id' => '1', 'id2' => '3')), array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			unset($GLOBALS['Tier3DatabaseDeny']['setDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseDeny']['getDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['getDatabasename'] = 'getDatabasename';
		}
		
		/**
		 * testPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsEmptyArray
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an empty array. This does run Verify for all Modules. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsEmptyArray() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'setDatabasename', array('name' => $this->DatabaseName));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'getDatabasename', array());
			$this->assertIsA($Return, 'String');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an empty array with a int return. This does run Verify for all Modules.
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsEmptyArrayWithIntReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'setIdnumber', array(array('id' => 1)));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'getIdnumber', array('id'));
			$this->assertIdentical($Return, 1);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an non-empty array with a int return. This does run Verify for all Modules.
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithIntReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'setDatabasename', array('id' => 1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'getDatabasename', array('id' => 1));
			$this->assertIdentical($Return, 1);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an empty array with a string return. This does run Verify for all Modules.
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsEmptyArrayWithStringReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'setDatabasename', array('id' => '1'));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'getDatabasename', array());
			$this->assertIdentical($Return, '1');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an non-empty array with a string return. This does run Verify for all Modules. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithStringReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'setDatabasename', array('id' => '1'));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'getDatabasename', array('id' => '1'));
			$this->assertIdentical($Return, '1');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithArrayReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Allow Function and Function Arguments being an non-empty array with an array return. This does run Verify for all Modules.
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithArrayReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'setDatabasename', array(array('id' => '1', 'id2' => '3')));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'getDatabasename', array());
			$this->assertIsA($Return, 'array');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithNonArrayHookArguments
		 * Tests if pass method will accept all data correctly for a check pass with a Database Allow Function and Function Arguments being an non-empty array and non array Hook Arguments. 
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithNonArrayHookArguments() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'setDatabasename', array(array('id' => '1', 'id2' => '3')), 1);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithArrayHookArguments
		 * Tests if pass method will accept all data correctly for a check pass with a Database Allow Function and Function Arguments being an non-empty array and array Hook Arguments. This does run Verify for all Modules.
		 *
		 * @access public
		*/
		public function testPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithArrayHookArguments() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;

			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'setDatabasename', array(array('id' => '1', 'id2' => '3')), array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
	
		/**
		 * testPassFunctionNameProtectWithHookArgumentAsAnArray
		 * Tests if pass method will accept 'PROTECT' as a function name with an array of Hook Arguments. 
		 *
		 * @access public
		*/
		public function testPassFunctionNameProtectWithHookArgumentAsAnArray() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array(1), array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testPassFunctionNameProtectWithoutHookArgument
		 * Tests if pass method will accept 'PROTECT' as a function name without Hook Arguments. This will call checkPass. 
		 *
		 * @access public
		*/
		public function testPassFunctionNameProtectWithoutHookArgument() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = FALSE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array(1));
			$this->assertTrue($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassFunctionNameProtectWithHookArgumentAsAnArrayWithoutAHookArgumentExecuteKey
		 * Tests if pass method will accept 'PROTECT' as a function name with an array of Hook Arguments without a hook argument 'Execute' key.
		 *
		 * @access public
		*/
		public function testPassFunctionNameProtectWithHookArgumentAsAnArrayWithoutAHookArgumentExecuteKey() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$HookArguments = array();
			//$HookArguments['Execute'] = TRUE;
			$HookArguments['Method'] = 'getLogonHistoryTable';
			$HookArguments['ObjectType'] = 'LogonMonitor';
			$HookArguments['ObjectTypeName'] = 'logonmonitor';
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array(1), $HookArguments);
			$this->assertFalse($Return);;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassFunctionNameProtectWithHookArgumentAsAnArrayWithoutAHookArgumentMethodKey
		 * Tests if pass method will accept 'PROTECT' as a function name with an array of Hook Arguments without a hook argument 'Method' key.
		 *
		 * @access public
		*/
		public function testPassFunctionNameProtectWithHookArgumentAsAnArrayWithoutAHookArgumentMethodKey() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$HookArguments = array();
			$HookArguments['Execute'] = TRUE;
			//$HookArguments['Method'] = 'getLogonHistoryTable';
			$HookArguments['ObjectType'] = 'LogonMonitor';
			$HookArguments['ObjectTypeName'] = 'logonmonitor';
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array(array('id' => '1', 'id2' => '3')), $HookArguments);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassFunctionNameProtectWithHookArgumentAsAnArrayWithoutAHookArgumentObjectTypeKey
		 * Tests if pass method will accept 'PROTECT' as a function name with an array of Hook Arguments without a hook argument 'ObjectKey' key.
		 *
		 * @access public
		*/
		public function testPassFunctionNameProtectWithHookArgumentAsAnArrayWithoutAHookArgumentObjectTypeKey() {
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$HookArguments = array();
			$HookArguments['Execute'] = TRUE;
			$HookArguments['Method'] = 'getLogonHistoryTable';
			//$HookArguments['ObjectType'] = 'LogonMonitor';
			$HookArguments['ObjectTypeName'] = 'logonmonitor';
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array(array('id' => '1', 'id2' => '3')), $HookArguments);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassFunctionNameProtectWithHookArgumentAsAnArrayWithoutAHookArgumentObjectTypeNameKey
		 * Tests if pass method will accept 'PROTECT' as a function name with an array of Hook Arguments without a hook argument 'ObjectKeyName' key.
		 *
		 * @access public
		*/
		public function testPassFunctionNameProtectWithHookArgumentAsAnArrayWithoutAHookArgumentObjectTypeNameKey() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$HookArguments = array();
			$HookArguments['Execute'] = TRUE;
			$HookArguments['Method'] = 'getLogonHistoryTable';
			$HookArguments['ObjectType'] = 'LogonMonitor';
			//$HookArguments['ObjectTypeName'] = 'logonmonitor';
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array(array('id' => '1', 'id2' => '3')), $HookArguments);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithANonExistingModule
		 * Tests if pass method will accept 'PROTECT' as a function name with an correct array of Hook Argument with a non existing module.
		 *
		 * @access public
		*/
		public function testPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithANonExistingModule() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$HookArguments = array();
			$HookArguments['Execute'] = TRUE;
			$HookArguments['Method'] = 'TEST';
			$HookArguments['ObjectType'] = 'TEST';
			$HookArguments['ObjectTypeName'] = 'TEST';
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array(array('id' => '1', 'id2' => '3')), $HookArguments);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithAnExistingMethodOnANonObject
		 * Tests if pass method will accept 'PROTECT' as a function name with an correct array of Hook Argument with an existing method on a non object.
		 *
		 * @access public
		*/
		public function testPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithAnExistingMethodOnANonObject() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$ModuleName = 'LogonMonitorTEST';
			$ObjectName = 'logonmonitortest';
			$ModuleObject = 'TEST';
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->setModules($ModuleName, $ObjectName, $ModuleObject);
			$this->assertFalse($Return);
			
			$HookArguments = array();
			$HookArguments['Execute'] = TRUE;
			$HookArguments['Method'] = 'TEST';
			$HookArguments['ObjectType'] = $ModuleName;
			$HookArguments['ObjectTypeName'] = $ObjectName;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array(array('id' => '1', 'id2' => '3')), $HookArguments);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithANonExistingMethod
		 * Tests if pass method will accept 'PROTECT' as a function name with an correct array of Hook Argument with a non existing method.
		 *
		 * @access public
		*/
		public function testPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithANonExistingMethod() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$HookArguments = array();
			$HookArguments['Execute'] = TRUE;
			$HookArguments['Method'] = 'getLogonHistoryTable';
			$HookArguments['ObjectType'] = 'LogonMonitorNonObject';
			$HookArguments['ObjectTypeName'] = 'logonmonitornonobject';
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array(array('id' => '1', 'id2' => '3')), $HookArguments);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithNoReturn
		 * Tests if pass method will accept 'PROTECT' as a function name with a correct array of Hook Argument with No Return.
		 *
		 * @access public
		*/
		public function testPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithNoReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$HookArguments = array();
			$HookArguments['Execute'] = TRUE;
			$HookArguments['Method'] = 'getLogonHistoryTable';
			$HookArguments['ObjectType'] = 'LogonMonitor';
			$HookArguments['ObjectTypeName'] = 'logonmonitor';
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array(array('id' => '1', 'id2' => '3')), $HookArguments);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassFunctionNameProtectWithHookArgumentAsNotAnArray
		 * Tests if pass method will accept 'PROTECT' as a function name with a Hook Arguments as not an array. 
		 *
		 * @access public
		*/
		public function testPassFunctionNameProtectWithHookArgumentAsNotAnArray() {
			unset($GLOBALS['Tier3DatabaseAllow']['setDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$HookArguments = 'getLogonHistoryTable';
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array(array('id' => '1', 'id2' => '3')), $HookArguments);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			unset($GLOBALS['Tier3DatabaseDeny']['setDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseDeny']['getDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['getDatabasename'] = 'getDatabasename';
		}
		
		/**
		 * testPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithIntReturn
		 * Tests if pass method will accept 'PROTECT' as a function name with a correct array of Hook Argument with an Integer Return.
		 *
		 * @access public
		*/
		public function testPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithIntReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$HookArguments = array();
			$HookArguments['Execute'] = TRUE;
			$HookArguments['Method'] = 'setLogonHistoryTable';
			$HookArguments['ObjectType'] = 'LogonMonitor';
			$HookArguments['ObjectTypeName'] = 'logonmonitor';
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array('Table' => 1), $HookArguments);
			$this->assertFalse($Return);
			
			$HookArguments = array();
			$HookArguments['Execute'] = TRUE;
			$HookArguments['Method'] = 'getLogonHistoryTable';
			$HookArguments['ObjectType'] = 'LogonMonitor';
			$HookArguments['ObjectTypeName'] = 'logonmonitor';
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array(array('id' => '1', 'id2' => '3')), $HookArguments);
			$this->assertIdentical($Return, 1);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithStringReturn
		 * Tests if pass method will accept 'PROTECT' as a function name with a correct array of Hook Argument with a String Return.
		 *
		 * @access public
		*/
		public function testPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithStringReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$HookArguments = array();
			$HookArguments['Execute'] = TRUE;
			$HookArguments['Method'] = 'setLogonHistoryTable';
			$HookArguments['ObjectType'] = 'LogonMonitor';
			$HookArguments['ObjectTypeName'] = 'logonmonitor';
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array('Table' => '1'), $HookArguments);
			$this->assertFalse($Return);
			
			$HookArguments = array();
			$HookArguments['Execute'] = TRUE;
			$HookArguments['Method'] = 'getLogonHistoryTable';
			$HookArguments['ObjectType'] = 'LogonMonitor';
			$HookArguments['ObjectTypeName'] = 'logonmonitor';
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array('id' => '1', 'id2' => '3'), $HookArguments);
			$this->assertIdentical($Return, '1');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}
		
		/**
		 * testPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithArrayReturn
		 * Tests if pass method will accept 'PROTECT' as a function name with a correct array of Hook Argument with an Array Return. 
		 *
		 * @access public
		*/
		public function testPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithArrayReturn() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$HookArguments = array();
			$HookArguments['Execute'] = TRUE;
			$HookArguments['Method'] = 'setLogonHistoryTable';
			$HookArguments['ObjectType'] = 'LogonMonitor';
			$HookArguments['ObjectTypeName'] = 'logonmonitor';
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array(array('id' => '1', 'id2' => '3')), $HookArguments);
			$this->assertFalse($Return);
			
			$HookArguments = array();
			$HookArguments['Execute'] = TRUE;
			$HookArguments['Method'] = 'getLogonHistoryTable';
			$HookArguments['ObjectType'] = 'LogonMonitor';
			$HookArguments['ObjectTypeName'] = 'logonmonitor';
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array(array('id' => '1', 'id2' => '3')), $HookArguments);
			$this->assertIsA($Return, 'array');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
		}

		/**
		 * testCheckPassNull
		 * Tests if checkPass method will accept All Values as NULL. This does NOT run Verify for all Modules.
		 *
		 * @access public
		*/
		public function testCheckPassAllNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass(NULL, NULL, NULL);
			$this->assertFalse($Return);
		}
		
		/**
		 * testCheckPassDatabaseTableNull
		 * Tests if checkPass method will accept Database Table as NULL. This does NOT run Verify for all Modules.
		 *
		 * @access public
		*/
		public function testCheckPassDatabaseTableNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass(NULL, 'FUNCTION', 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testCheckPassFunctionNull
		 * Tests if checkPass method will accept Function as NULL. This does NOT run Verify for all Modules. 
		 *
		 * @access public
		*/
		public function testCheckPassFunctionNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('DATABASETABLE', NULL, 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testCheckPassFunctionArgumentsNull
		 * Tests if checkPass method will accept Function Arguments as NULL. This does NOT run Verify for all Modules. 
		 *
		 * @access public
		*/
		public function testCheckPassFunctionArgumentsNull() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('DATABASETABLE', 'FUNCTION', NULL);
			$this->assertFalse($Return);
		}
		
		/**
		 * testCheckPassAsArray
		 * Tests if checkPass method will accept All Values as an Array. This does NOT run Verify for all Modules. 
		 *
		 * @access public
		*/
		public function testCheckPassAllAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass(array(1), array(1), array(1));
			$this->assertFalse($Return);
		}
		
		/**
		 * testCheckPassDatabaseTableAsArray
		 * Tests if checkPass method will accept Database Table as an Array. This does NOT run Verify for all Modules. 
		 *
		 * @access public
		*/
		public function testCheckPassDatabaseTableAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass(array(1), 'FUNCTION', 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testCheckPassFunctionAsArray
		 * Tests if checkPass method will accept Function as an Array. This does NOT run Verify for all Modules. 
		 *
		 * @access public
		*/
		public function testCheckPassFunctionAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('DATABASETABLE', array(1), 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testCheckPassFunctionArgumentsAsArray
		 * Tests if checkPass method will accept Function Arguments as Array.  This does run Verify for all Modules.
		 *
		 * @access public
		*/
		public function testCheckPassFunctionArgumentsAsArray() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('DATABASETABLE', 'FUNCTION', array(1));
			$this->assertFalse($Return);
		}
		
		/**
		 * testCheckPassAsObject
		 * Tests if checkPass method will accept All Values as an Object. This does NOT run Verify for all Modules. 
		 *
		 * @access public
		*/
		public function testCheckPassAllAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass($Object, $Object, $Object);
			$this->assertFalse($Return);
		}
		
		/**
		 * testCheckPassDatabaseTableAsObject
		 * Tests if checkPass method will accept Database Table as an Object. This does NOT run Verify for all Modules.
		 *
		 * @access public
		*/
		public function testCheckPassDatabaseTableAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass($Object, 'FUNCTION', 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testCheckPassFunctionAsObject
		 * Tests if checkPass method will accept Function as an Object. This does NOT run Verify for all Modules.
		 *
		 * @access public
		*/
		public function testCheckPassFunctionAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('DATABASETABLE', $Object, 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testCheckPassFunctionArgumentsAsObject
		 * Tests if checkPass method will accept Function Arguments as Object. This does NOT run Verify for all Modules.
		 *
		 * @access public
		*/
		public function testCheckPassFunctionArgumentsAsObject() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('DATABASETABLE', 'FUNCTION', $Object);
			$this->assertFalse($Return);
		}

		
		/**
		 * testCheckPassNotSetAll
		 * Tests if checkPass method will accept all arguments that are not set. This does NOT run Verify for all Modules.
		 *
		 * @access public
		*/
		public function testCheckPassNotSetAll() {
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('DATABASETABLE', 'FUNCTION', 'FUNCTIONARGUMENT');
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testCheckPassNotSetDatabaseTable
		 * Tests if checkPass method will accept a Database Table Name that has not been set, but all other arguments are valid.  This does run Verify for all Modules. 
		 *
		 * @access public
		*/
		public function testCheckPassNotSetDatabaseTable() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('DATABASETABLE', 'getIdnumber', array());
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testCheckPassFunctionArgumentNotAsArray
		 * Tests if checkPass method will accept a Function Arguments are not an array. This does NOT run Verify for all Modules.
		 *
		 * @access public
		*/
		public function testCheckPassFunctionArgumentNotAsArray() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('DATABASETABLE');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('DATABASETABLE', 'getIdnumber', 'TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('DATABASETABLE');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testCheckPassCorrectDataFunctionArgumentsEmptyArray
		 * Tests if checkPass method will accept all data correctly with Function Arguments being an empty array. This does run Verify for all Modules. 
		 *
		 * @access public
		*/
		public function testCheckPassCorrectDataFunctionArgumentsEmptyArray() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'getIdnumber', array());
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
		
		/**
		 * testCheckPassCorrectDataFunctionArgumentsNonEmptyArray
		 * Tests if checkPass method will accept all data correctly with Function Arguments being an non-empty array. This does run Verify for all Modules.
		 *
		 * @access public
		*/
		public function testCheckPassCorrectDataFunctionArgumentsNonEmptyArray() {
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'setIdnumber', array('id' => 1));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'ProtectionLayer');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'ProtectionLayer');
			
		}
	}
?>