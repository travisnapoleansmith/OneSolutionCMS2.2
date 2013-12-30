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
	 * Tier 3 Soap Pass Test
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
	class Tier3SoapPassTest extends UnitTestCase {
		
		/**
		 * Tier3Protection: SOAP DataAccessTier object for Tier 3
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
		 * Create an instance of Tier3SoapPassTest.
		 *
		 * @access public
		*/	
		public function Tier3SoapPassTest () {
			// Settings.ini File
			$credentaillogonarray = $GLOBALS['credentaillogonarray'];
			$this->ServerName = $credentaillogonarray[0];
			$this->Username = $credentaillogonarray[1];
			$this->Password = $credentaillogonarray[2];
			$this->DatabaseName = $credentaillogonarray[3];
			
			$this->Tier3Protection = Tier3SetupSoap();
		}
		
		/**
		 * testSoapPassNull
		 * Tests if pass method will accept All Values as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassAllNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass(NULL, NULL, NULL);
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassDatabaseTableNull
		 * Tests if pass method will accept Database Table as NULL with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassDatabaseTableNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass(NULL, 'FUNCTION', 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassFunctionNull
		 * Tests if pass method will accept Function as NULL with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassFunctionNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('DATABASETABLE', NULL, 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassFunctionArgumentsNull
		 * Tests if pass method will accept Function Arguments as NULL with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassFunctionArgumentsNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('DATABASETABLE', 'FUNCTION', NULL);
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassAsArray
		 * Tests if pass method will accept All Values as an Array with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassAllAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass(array(1), array(1), array(1));
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassDatabaseTableAsArray
		 * Tests if pass method will accept Database Table as an Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassDatabaseTableAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass(array(1), 'FUNCTION', 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassFunctionAsArray
		 * Tests if pass method will accept Function as an Array with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassFunctionAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('DATABASETABLE', array(1), 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassFunctionArgumentsAsArray
		 * Tests if pass method will accept Function Arguments as Array with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassFunctionArgumentsAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('DATABASETABLE', 'FUNCTION', array(1));
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassAsObject
		 * Tests if pass method will accept All Values as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassAllAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass($Object, $Object, $Object);
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassDatabaseTableAsObject
		 * Tests if pass method will accept Database Table as an Object with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassDatabaseTableAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass($Object, 'FUNCTION', 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassFunctionAsObject
		 * Tests if pass method will accept Function as an Object with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassFunctionAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('DATABASETABLE', $Object, 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapPassFunctionArgumentsAsObject
		 * Tests if pass method will accept Function Arguments as Object with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassFunctionArgumentsAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('DATABASETABLE', 'FUNCTION', $Object);
			$this->assertFalse($Return);
		}

		
		/**
		 * testSoapPassNotSetAll
		 * Tests if pass method will accept all arguments that are not set with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassNotSetAll() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('DATABASETABLE', 'FUNCTION', 'FUNCTIONARGUMENT');
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapPassNotSetDatabaseTable
		 * Tests if pass method will accept a Database Table Name that has not been set, but all other arguments are valid with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassNotSetDatabaseTable() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('DATABASETABLE', 'getIdnumber', array());
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapPassFunctionArgumentNotAsArray
		 * Tests if pass method will accept a Function Arguments are not an array with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassFunctionArgumentNotAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('DATABASETABLE');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('DATABASETABLE', 'getIdnumber', 'TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('DATABASETABLE');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapPassCorrectDataFunctionArgumentsEmptyArray
		 * Tests if pass method will accept all data correctly with Function Arguments being an empty array with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataFunctionArgumentsEmptyArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getIdnumber', array());
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapPassCorrectDataFunctionArgumentsNonEmptyArray
		 * Tests if pass method will accept all data correctly with Function Arguments being an non-empty array with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataFunctionArgumentsNonEmptyArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setIdnumber', array('id' => 1));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapPassCorrectDataFunctionArgumentsEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an empty array with a int return with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataFunctionArgumentsEmptyArrayWithIntReturn() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setIdnumber', array(array('id' => 1)));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getIdnumber', array('id'));
			$this->assertIdentical($Return, 1);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapPassCorrectDataFunctionArgumentsNonEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an non-empty array with a int return with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataFunctionArgumentsNonEmptyArrayWithIntReturn() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setIdnumber', array(array('id' => 1)));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getIdnumber', array('id'));
			$this->assertIdentical($Return, 1);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassCorrectDataFunctionArgumentsEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an empty array with a string return with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataFunctionArgumentsEmptyArrayWithStringReturn() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setIdnumber', array(array('id' => '1')));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getIdnumber', array('id'));
			$this->assertIdentical($Return, '1');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapPassCorrectDataFunctionArgumentsNonEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an non-empty array with a string return with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataFunctionArgumentsNonEmptyArrayWithStringReturn() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setIdnumber', array(array('id' => '1')));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getIdnumber', array('id'));
			$this->assertIdentical($Return, '1');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassCorrectDataFunctionArgumentsNonEmptyArrayWithArrayReturn
		 * Tests if pass method will accept all data correctly with Function Arguments being an non-empty array with an array return with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataFunctionArgumentsNonEmptyArrayWithArrayReturn() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setIdnumber', array(array('id' => '1', 'id2' => '3')));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getIdnumber', array());
			$this->assertIsA($Return, 'array');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassFunctionArgumentsNonEmptyArray
		 * Tests if pass method will accept all data correctly for a check pass with Function Arguments being an non-empty array with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassFunctionArgumentsNonEmptyArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setDatabasename', array('id' => 1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsEmptyArray
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an empty array. This does run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsEmptyArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			unset($GLOBALS['Tier3DatabaseAllow']['setDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setDatabasename', array('name' => $this->DatabaseName));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getDatabasename', array());
			$this->assertIsA($Return, 'String');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			unset($GLOBALS['Tier3DatabaseDeny']['setDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseDeny']['getDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['getDatabasename'] = 'getDatabasename';
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an empty array with a int return with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsEmptyArrayWithIntReturn() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			unset($GLOBALS['Tier3DatabaseAllow']['setDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setIdnumber', array(array('id' => 1)));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getIdnumber', array('id'));
			$this->assertIdentical($Return, 1);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			unset($GLOBALS['Tier3DatabaseDeny']['setDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseDeny']['getDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['getDatabasename'] = 'getDatabasename';
			
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an non-empty array with a int return. This does run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithIntReturn() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			unset($GLOBALS['Tier3DatabaseAllow']['setDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setDatabasename', array('id' => 1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getDatabasename', array('id' => 1));
			$this->assertIdentical($Return, 1);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			unset($GLOBALS['Tier3DatabaseDeny']['setDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseDeny']['getDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['getDatabasename'] = 'getDatabasename';
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an empty array with a string return. This does run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsEmptyArrayWithStringReturn() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			unset($GLOBALS['Tier3DatabaseAllow']['setDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setDatabasename', array('id' => '1'));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getDatabasename', array());
			$this->assertIdentical($Return, '1');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			unset($GLOBALS['Tier3DatabaseDeny']['setDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseDeny']['getDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['getDatabasename'] = 'getDatabasename';
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an non-empty array with a string return. This does run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithStringReturn() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			unset($GLOBALS['Tier3DatabaseAllow']['setDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setDatabasename', array('id' => '1'));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getDatabasename', array('id' => '1'));
			$this->assertIdentical($Return, '1');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			unset($GLOBALS['Tier3DatabaseDeny']['setDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseDeny']['getDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['getDatabasename'] = 'getDatabasename';
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithArrayReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an non-empty array with an array return. This does run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithArrayReturn() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			unset($GLOBALS['Tier3DatabaseAllow']['setDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setDatabasename', array(array('id' => '1', 'id2' => '3')));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'getDatabasename', array());
			$this->assertIsA($Return, 'array');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			unset($GLOBALS['Tier3DatabaseDeny']['setDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseDeny']['getDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['getDatabasename'] = 'getDatabasename';
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithNonArrayHookArguments
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an non-empty array and non array Hook Arguments with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithNonArrayHookArguments() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			unset($GLOBALS['Tier3DatabaseAllow']['setDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setDatabasename', array(array('id' => '1', 'id2' => '3')), 1);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			unset($GLOBALS['Tier3DatabaseDeny']['setDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseDeny']['getDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['getDatabasename'] = 'getDatabasename';
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithArrayHookArguments
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an non-empty array and array Hook Arguments. This does run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassDatabaseDenyFunctionArgumentsNonEmptyArrayWithArrayHookArguments() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			unset($GLOBALS['Tier3DatabaseAllow']['setDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'setDatabasename', array(array('id' => '1', 'id2' => '3')), array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			unset($GLOBALS['Tier3DatabaseDeny']['setDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseDeny']['getDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['getDatabasename'] = 'getDatabasename';
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsEmptyArray
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an empty array. This does run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsEmptyArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'setDatabasename', array('name' => $this->DatabaseName));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'getDatabasename', array());
			$this->assertIsA($Return, 'String');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an empty array with a int return. This does run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsEmptyArrayWithIntReturn() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
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
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithIntReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an non-empty array with a int return. This does run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithIntReturn() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'setDatabasename', array('id' => 1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'getDatabasename', array('id' => 1));
			$this->assertIdentical($Return, 1);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an empty array with a string return. This does run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsEmptyArrayWithStringReturn() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'setDatabasename', array('id' => '1'));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'getDatabasename', array());
			$this->assertIdentical($Return, '1');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithStringReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Deny Function and Function Arguments being an non-empty array with a string return. This does run Verify for all Modules with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithStringReturn() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'setDatabasename', array('id' => '1'));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'getDatabasename', array('id' => '1'));
			$this->assertIdentical($Return, '1');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithArrayReturn
		 * Tests if pass method will accept all data correctly for a check pass with a Database Allow Function and Function Arguments being an non-empty array with an array return. This does run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithArrayReturn() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'setDatabasename', array(array('id' => '1', 'id2' => '3')));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'getDatabasename', array());
			$this->assertIsA($Return, 'array');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithNonArrayHookArguments
		 * Tests if pass method will accept all data correctly for a check pass with a Database Allow Function and Function Arguments being an non-empty array and non array Hook Arguments with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithNonArrayHookArguments() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'setDatabasename', array(array('id' => '1', 'id2' => '3')), 1);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithArrayHookArguments
		 * Tests if pass method will accept all data correctly for a check pass with a Database Allow Function and Function Arguments being an non-empty array and array Hook Arguments. This does run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassCorrectDataCheckPassDatabaseAllowFunctionArgumentsNonEmptyArrayWithArrayHookArguments() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;

			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'setDatabasename', array(array('id' => '1', 'id2' => '3')), array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
	
		/**
		 * testSoapPassFunctionNameProtectWithHookArgumentAsAnArray
		 * Tests if pass method will accept 'PROTECT' as a function name with an array of Hook Arguments with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassFunctionNameProtectWithHookArgumentAsAnArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array(1), array(1));
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapPassFunctionNameProtectWithoutHookArgument
		 * Tests if pass method will accept 'PROTECT' as a function name without Hook Arguments. This will call checkPass with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassFunctionNameProtectWithoutHookArgument() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = FALSE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array(1));
			$this->assertTrue($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithoutAHookArgumentExecuteKey
		 * Tests if pass method will accept 'PROTECT' as a function name with an array of Hook Arguments without a hook argument 'Execute' key with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithoutAHookArgumentExecuteKey() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
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
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithoutAHookArgumentMethodKey
		 * Tests if pass method will accept 'PROTECT' as a function name with an array of Hook Arguments without a hook argument 'Method' key with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithoutAHookArgumentMethodKey() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
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
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithoutAHookArgumentObjectTypeKey
		 * Tests if pass method will accept 'PROTECT' as a function name with an array of Hook Arguments without a hook argument 'ObjectKey' key with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithoutAHookArgumentObjectTypeKey() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
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
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithoutAHookArgumentObjectTypeNameKey
		 * Tests if pass method will accept 'PROTECT' as a function name with an array of Hook Arguments without a hook argument 'ObjectKeyName' key with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithoutAHookArgumentObjectTypeNameKey() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
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
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithANonExistingModule
		 * Tests if pass method will accept 'PROTECT' as a function name with an correct array of Hook Argument with a non existing module with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithANonExistingModule() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
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
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithAnExistingMethodOnANonObject
		 * Tests if pass method will accept 'PROTECT' as a function name with an correct array of Hook Argument with an existing method on a non object with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithAnExistingMethodOnANonObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
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
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithANonExistingMethod
		 * Tests if pass method will accept 'PROTECT' as a function name with an correct array of Hook Argument with a non existing method with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithANonExistingMethod() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
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
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithNoReturn
		 * Tests if pass method will accept 'PROTECT' as a function name with a correct array of Hook Argument with No Return with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithNoReturn() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
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
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassFunctionNameProtectWithHookArgumentAsNotAnArray
		 * Tests if pass method will accept 'PROTECT' as a function name with a Hook Arguments as not an array with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassFunctionNameProtectWithHookArgumentAsNotAnArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			unset($GLOBALS['Tier3DatabaseAllow']['setDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseAllow']['getDatabasename']);
			$GLOBALS['Tier3DatabaseDeny']['getDatabasename'] = 'getDatabasename';
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			$HookArguments = 'getLogonHistoryTable';
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->pass('TEST', 'PROTECT', array(array('id' => '1', 'id2' => '3')), $HookArguments);
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			unset($GLOBALS['Tier3DatabaseDeny']['setDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['setDatabasename'] = 'setDatabasename';
			
			unset($GLOBALS['Tier3DatabaseDeny']['getDatabasename']);
			$GLOBALS['Tier3DatabaseAllow']['getDatabasename'] = 'getDatabasename';
		}
		
		/**
		 * testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithIntReturn
		 * Tests if pass method will accept 'PROTECT' as a function name with a correct array of Hook Argument with an Integer Return with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithIntReturn() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
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
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithStringReturn
		 * Tests if pass method will accept 'PROTECT' as a function name with a correct array of Hook Argument with a String Return with SOAP.
		 *
		 * @access public
		*/
		public function testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithStringReturn() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
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
			$this->assertIsA($Return, 'stdClass');
		}
		
		/**
		 * testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithArrayReturn
		 * Tests if pass method will accept 'PROTECT' as a function name with a correct array of Hook Argument with an Array Return with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapPassFunctionNameProtectWithHookArgumentAsAnArrayWithCorrectHookArgumentWithArrayReturn() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
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
			$this->assertIsA($Return, 'stdClass');
		}

		/**
		 * testSoapCheckPassNull
		 * Tests if checkPass method will accept All Values as NULL. This does NOT run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapCheckPassAllNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass(NULL, NULL, NULL);
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapCheckPassDatabaseTableNull
		 * Tests if checkPass method will accept Database Table as NULL. This does NOT run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapCheckPassDatabaseTableNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass(NULL, 'FUNCTION', 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapCheckPassFunctionNull
		 * Tests if checkPass method will accept Function as NULL. This does NOT run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapCheckPassFunctionNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('DATABASETABLE', NULL, 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapCheckPassFunctionArgumentsNull
		 * Tests if checkPass method will accept Function Arguments as NULL. This does NOT run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapCheckPassFunctionArgumentsNull() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('DATABASETABLE', 'FUNCTION', NULL);
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapCheckPassAsArray
		 * Tests if checkPass method will accept All Values as an Array. This does NOT run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapCheckPassAllAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass(array(1), array(1), array(1));
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapCheckPassDatabaseTableAsArray
		 * Tests if checkPass method will accept Database Table as an Array. This does NOT run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapCheckPassDatabaseTableAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass(array(1), 'FUNCTION', 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapCheckPassFunctionAsArray
		 * Tests if checkPass method will accept Function as an Array. This does NOT run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapCheckPassFunctionAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('DATABASETABLE', array(1), 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapCheckPassFunctionArgumentsAsArray
		 * Tests if checkPass method will accept Function Arguments as Array.  This does run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapCheckPassFunctionArgumentsAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('DATABASETABLE', 'FUNCTION', array(1));
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapCheckPassAsObject
		 * Tests if checkPass method will accept All Values as an Object. This does NOT run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapCheckPassAllAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass($Object, $Object, $Object);
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapCheckPassDatabaseTableAsObject
		 * Tests if checkPass method will accept Database Table as an Object. This does NOT run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapCheckPassDatabaseTableAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass($Object, 'FUNCTION', 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapCheckPassFunctionAsObject
		 * Tests if checkPass method will accept Function as an Object. This does NOT run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapCheckPassFunctionAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('DATABASETABLE', $Object, 'FUNCTIONARGUMENTS');
			$this->assertFalse($Return);
		}
		
		/**
		 * testSoapCheckPassFunctionArgumentsAsObject
		 * Tests if checkPass method will accept Function Arguments as Object. This does NOT run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapCheckPassFunctionArgumentsAsObject() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Object = new stdClass;
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('DATABASETABLE', 'FUNCTION', $Object);
			$this->assertFalse($Return);
		}

		
		/**
		 * testSoapCheckPassNotSetAll
		 * Tests if checkPass method will accept all arguments that are not set. This does NOT run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapCheckPassNotSetAll() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = TRUE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('DATABASETABLE', 'FUNCTION', 'FUNCTIONARGUMENT');
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapCheckPassNotSetDatabaseTable
		 * Tests if checkPass method will accept a Database Table Name that has not been set, but all other arguments are valid.  This does run Verify for all Modules with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapCheckPassNotSetDatabaseTable() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('DATABASETABLE', 'getIdnumber', array());
			$this->assertFalse($Return);
			
		}
		
		/**
		 * testSoapCheckPassFunctionArgumentNotAsArray
		 * Tests if checkPass method will accept a Function Arguments are not an array. This does NOT run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapCheckPassFunctionArgumentNotAsArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('DATABASETABLE');
			$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('DATABASETABLE', 'getIdnumber', 'TEST');
			$this->assertFalse($Return);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('DATABASETABLE');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapCheckPassCorrectDataFunctionArgumentsEmptyArray
		 * Tests if checkPass method will accept all data correctly with Function Arguments being an empty array. This does run Verify for all Modules with SOAP. 
		 *
		 * @access public
		*/
		public function testSoapCheckPassCorrectDataFunctionArgumentsEmptyArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'getIdnumber', array());
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
		
		/**
		 * testSoapCheckPassCorrectDataFunctionArgumentsNonEmptyArray
		 * Tests if checkPass method will accept all data correctly with Function Arguments being an non-empty array. This does run Verify for all Modules with SOAP.
		 *
		 * @access public
		*/
		public function testSoapCheckPassCorrectDataFunctionArgumentsNonEmptyArray() {
			$this->Tier3Protection = Tier3SetupSoap();
			
			$Return = FALSE;
			$this->assertNotNull($this->Tier3Protection);
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->createDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
			// FIX THIS TESTCASE WHEN ALL MODULES SUPPORT THE NEW WAY
			$Return = TRUE;
			$Return = $this->Tier3Protection->checkPass('TEST', 'setIdnumber', array('id' => 1));
			$this->assertFalse($Return);
			//$this->assertIsA($Return, 'stdClass');
			
			$Return = TRUE;
			$Return = $this->Tier3Protection->destroyDatabaseTable('TEST');
			$this->assertIsA($Return, 'stdClass');
			
		}
	}
?>