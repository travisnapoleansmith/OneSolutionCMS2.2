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
	
	if ($_SERVER['SUBDOMAIN_DOCUMENT_ROOT'] != NULL) {
		$HOME = $_SERVER['SUBDOMAIN_DOCUMENT_ROOT'];
	} else {
		if ($_SERVER['REAL_DOCUMENT_ROOT'] != NULL) {
			$_SERVER['SUBDOMAIN_DOCUMENT_ROOT'] = $_SERVER['REAL_DOCUMENT_ROOT'];
			$HOME = $_SERVER['SUBDOMAIN_DOCUMENT_ROOT'];
		} else {
			$HOME = NULL;
		}
	}
	
	// Auto run for SimpleTest
	require_once("$HOME/Testcases/SimpleTest/simpletest/autorun.php");
	
	require_once("$HOME/Testcases/settings.php");
	/**
	 * All Tier 3 Protection Layer Test Cases
	 *
	 * This file is designed to run all test cases for Tier 3 Protection Layer.
	 *
	 * @author Travis Napolean Smith
	 * @copyright Copyright (c) 1999 - 2013 One Solution CMS
	 * @copyright PHP - Copyright (c) 2005 - 2013 One Solution CMS
	 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
	 * @version PHP - 2.2.1
	 * @version C++ - Unknown
 	*/
	class Tier3ProtectionLayerAllTests extends TestSuite {
		
		/**
		 * Current Test Suite Files - Files.ini file to parse
		 *
		 * @var string
		 */
		protected $FILES;
		
		/**
		 * Create an instance of AllTests.
		 *
		 * @access public
		*/	
		public function Tier3ProtectionLayerAllTests() {
			$this->FILES = parse_ini_file(dirname(__FILE__) . '/Files.ini', true);
			
			$this->TestSuite('Tier 3 - Protection Layer - All Tests');
			if ($this->FILES != NULL) {
				foreach ($this->FILES as $Module => $FileName) {
					$File = $FileName['FILE'];
					if ($File != NULL) {
						$this->addFile(dirname(__FILE__) . $File);
					}
				}
			}
		}
	}
?>