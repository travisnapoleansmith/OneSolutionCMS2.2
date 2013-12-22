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
* @version    2.1.141, 2013-01-14
*************************************************************************************
*/

class SqlInjection extends Tier3ProtectionLayerModulesAbstract implements Tier3ProtectionLayerModules
{

	public function __construct($tablenames, $databaseoptions, $layermodule) {
		$this->LayerModule = &$layermodule;

		$hold = current($tablenames);
		$GLOBALS['ErrorMessage']['SqlInjection'][$hold] = NULL;
		$this->ErrorMessage = &$GLOBALS['ErrorMessage']['SqlInjection'][$hold];
		$this->ErrorMessage = array();

	}

	public function setDatabaseAll ($hostname, $user, $password, $databasename, $databasetable) {

	}

	public function FetchDatabase ($PageID) {

	}

	public function CreateOutput($space){

	}

	public function Verify($function, $functionarguments){
		return TRUE;
	}

	public function getOutput() {

	}
}


?>
