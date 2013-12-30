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
	 * Tier 2 Soap Pass Test
	 *
	 * This file is designed to test Tier 2's pass method.
	 *
	 * @author Travis Napolean Smith
	 * @copyright Copyright (c) 1999 - 2013 One Solution CMS
	 * @copyright PHP - Copyright (c) 2005 - 2013 One Solution CMS
	 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
	 * @version PHP - 2.2.1
	 * @version C++ - Unknown
 	*/
	class Tier2SoapPassTest extends UnitTestCase {
		
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
		 * Create an instance of Tier2SoapPassTest.
		 *
		 * @access public
		*/	
		public function Tier2SoapPassTest () {
			// Settings.ini File
			$credentaillogonarray = $GLOBALS['credentaillogonarray'];
			$this->ServerName = $credentaillogonarray[0];
			$this->Username = $credentaillogonarray[1];
			$this->Password = $credentaillogonarray[2];
			$this->DatabaseName = $credentaillogonarray[3];
			
			$this->Tier2Database = Tier2SetupSoap();
		}
		
		/**
		 * testSoapPassNull
		 * Tests if pass method will accept All Values as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassAllNull() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass(NULL, NULL, NULL);
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassDatabaseTableNull
		 * Tests if pass method will accept Database Table as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassDatabaseTableNull() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass(NULL, 'FUNCTION', 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassFunctionNull
		 * Tests if pass method will accept Function as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassFunctionNull() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('DATABASETABLE', NULL, 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassFunctionArgumentsNull
		 * Tests if pass method will accept Function Arguments as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassFunctionArgumentsNull() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('DATABASETABLE', 'FUNCTION', NULL);
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassNotSetAll
		 * Tests if pass method will accept all arguments that are not set with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassNotSetAll() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('DATABASETABLE', 'FUNCTION', 'FUNCTIONARGUMENT');
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapPassNotSetDatabaseTable
		 * Tests if pass method will accept a Database Table Name that has not been set, but all other arguments are valid with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassNotSetDatabaseTable() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('DATABASETABLE', 'getIdnumber', array());
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapPassFunctionArgumentNotAsArray
		 * Tests if pass method will accept a Function Arguments are not an array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassFunctionArgumentNotAsArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('DATABASETABLE');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('DATABASETABLE', 'getIdnumber', 'TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('DATABASETABLE');
			$this->assertIsA($Return, 'stdClass');
			
		}

		/**
		 * testSoapPassAsArray
		 * Tests if pass method will accept All Values as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassAllAsArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass(array(1), array(1), array(1));
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassDatabaseTableAsArray
		 * Tests if pass method will accept Database Table as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassDatabaseTableAsArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass(array(1), 'FUNCTION', 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassFunctionAsArray
		 * Tests if pass method will accept Function as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassFunctionAsArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('DATABASETABLE', array(1), 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassFunctionArgumentsAsArray
		 * Tests if pass method will accept Function Arguments as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassFunctionArgumentsAsArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('DATABASETABLE', 'FUNCTION', array(1));
			$this->assertFalse($Return);
		}

		/**
		 * testSoapPassAsObject
		 * Tests if pass method will accept All Values as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassAllAsObject() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass($Object, $Object, $Object);
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassDatabaseTableAsObject
		 * Tests if pass method will accept Database Table as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassDatabaseTableAsObject() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass($Object, 'FUNCTION', 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassFunctionAsObject
		 * Tests if pass method will accept Function as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassFunctionAsObject() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('DATABASETABLE', $Object, 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassFunctionArgumentsAsObject
		 * Tests if pass method will accept Function Arguments as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassFunctionArgumentsAsObject() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('DATABASETABLE', 'FUNCTION', $Object);
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassCorrectDataFunctionArgumentsEmptyArray
		 * Tests if pass method will accept all data correctly with Function Arguments being an empty array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataFunctionArgumentsEmptyArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'getIdnumber', array());
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapPassCorrectDataFunctionArgumentsNonEmptyArray
		 * Tests if pass method will accept all data correctly with Function Arguments being an non-empty array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataFunctionArgumentsNonEmptyArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'setIdnumber', array('id' => 1));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapPassCorrectDataFunctionArgumentsEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an empty array with a int return with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataFunctionArgumentsEmptyArrayWithIntReturn() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'setIdnumber', array(array('id' => 1)));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'getIdnumber', array('id'));
			$this->assertIdentical($Return, 1);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapPassCorrectDataFunctionArgumentsNonEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an non-empty array with a int return with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataFunctionArgumentsNonEmptyArrayWithIntReturn() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'setIdnumber', array(array('id' => 1)));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'getIdnumber', array('id'));
			$this->assertIdentical($Return, 1);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassCorrectDataFunctionArgumentsEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an empty array with a string return with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataFunctionArgumentsEmptyArrayWithStringReturn() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'setIdnumber', array(array('id' => '1')));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'getIdnumber', array('id'));
			$this->assertIdentical($Return, '1');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapPassCorrectDataFunctionArgumentsNonEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an non-empty array with a string return with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataFunctionArgumentsNonEmptyArrayWithStringReturn() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'setIdnumber', array(array('id' => '1')));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'getIdnumber', array('id'));
			$this->assertIdentical($Return, '1');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassCorrectDataFunctionArgumentsNonEmptyArrayWithArrayReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an non-empty array with an array return with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataFunctionArgumentsNonEmptyArrayWithArrayReturn() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'setIdnumber', array(array('id' => '1', 'id2' => '3')));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'getIdnumber', array());
			$this->assertIsA($Return, 'array');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		
		/**
		 * testSoapPassCorrectDataCheckPassFunctionArgumentsEmptyArray
		 * Tests if pass method will accept all data correctly for a check pass with Function Arguments being an empty array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassFunctionArgumentsEmptyArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'setDatabasename', array('name' => $this->DatabaseName));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'getDatabasename', array());
			$this->assertIsA($Return, 'String');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}

		/**
		 * testSoapPassCorrectDataCheckPassFunctionArgumentsNonEmptyArray
		 * Tests if pass method will accept all data correctly for a check pass with Function Arguments being an non-empty array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassFunctionArgumentsNonEmptyArray() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'setDatabasename', array('id' => 1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}

		/**
		 * testSoapPassCorrectDataCheckPassFunctionArgumentsEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly for a check pass with Function Arguments being an empty array with a int return with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassFunctionArgumentsEmptyArrayWithIntReturn() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'setDatabasename', array('id' => 1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'getDatabasename', array());
			$this->assertIdentical($Return, 1);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassFunctionArgumentsNonEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly for a check pass with Function Arguments being an non-empty array with a int return with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassFunctionArgumentsNonEmptyArrayWithIntReturn() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'setDatabasename', array('id' => 1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'getDatabasename', array());
			$this->assertIdentical($Return, 1);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassFunctionArgumentsEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly for a check pass with Function Arguments being an empty array with a string return with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassFunctionArgumentsEmptyArrayWithStringReturn() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'setDatabasename', array('id' => '1'));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'getDatabasename', array());
			$this->assertIdentical($Return, '1');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassFunctionArgumentsNonEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly for a check pass with Function Arguments being an non-empty array with a string return with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassFunctionArgumentsNonEmptyArrayWithStringReturn() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'setDatabasename', array('id' => '1'));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'getDatabasename', array());
			$this->assertIdentical($Return, '1');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassFunctionArgumentsNonEmptyArrayWithArrayReturn
		 * Tests if pass method will accept all data correctly for a check pass with Function Arguments being an non-empty array with an array return with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassFunctionArgumentsNonEmptyArrayWithArrayReturn() {
			$this->Tier2Database = Tier2SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier2Database);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'setDatabasename', array(array('id' => '1', 'id2' => '3')));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier2Database->pass('TEST', 'getDatabasename', array());
			$this->assertIsA($Return, 'array');
			
			$Return = TRUE;
			$Return = $this->Tier2Database->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
	}
?>