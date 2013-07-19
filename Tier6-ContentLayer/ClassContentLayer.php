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

/**
 * Class Content Layer
 *
 * Class ContentLayer is designed as the main content container for all One Solution CMS websites. This is where
 * all modules, services and add ons are used to be displayed to the end user.
 *
 * @author Travis Napolean Smith
 * @copyright Copyright (c) 1999 - 2013 One Solution CMS
 * @copyright PHP - Copyright (c) 2005 - 2013 One Solution CMS
 * @copyright C++ - Copyright (c) 1999 - 2005 One Solution CMS
 * @version PHP - 2.1.140
 * @version C++ - Unknown
 */
class ContentLayer extends LayerModulesAbstract
{
	/**
	 * Content Layer Modules
	 *
	 * @var array
	 */
	protected $Modules;

	/**
	 * User settings for what is allowed to be done with the database -  set with Tier6ContentLayerSetting.php
	 * in /Configuration folder
	 *
	 * @var array
	 */
	protected $DatabaseAllow;

	/**
	 * User setting for what is cannot be done with the database - set with Tier6ContentLayerSetting.php
	 * in /Configuration folder
	 *
	 * @var array
	 */
	protected $DatabaseDeny;

	/**
	 * Print Preview array for the current page being displayed
	 *
	 * @var array
	 */
	protected $PrintPreview;

	/**
	 * Current Database Table Name for Content Layer
	 *
	 * @var string
	 */
	protected $DatabaseTableName;

	/**
	 * Current Database Table - Contains all the information retrieved from FetchDatabase
	 *
	 * @var array
	 */
	protected $ContentLayerDatabase;

	/**
	 * Content Layer Version Table Name
	 *
	 * @var string
	 */
	protected $ContentLayerVersionTableName;

	/**
	 * Content Layer Version Table - Contains all the information retrieved from FetchDatabase
	 *
	 * @var array
	 */
	protected $ContentLayerVersionDatabase;

	/**
	 * Content Layer Theme Table Name
	 *
	 * @var string
	 */
	protected $ContentLayerThemeTableName;

	/**
	 * Content Layer Theme Global Layer Table Name
	 *
	 * @var string
	 */
	protected $ContentLayerThemeGlobalLayerTableName;

	/**
	 * Content Layer Theme Name
	 *
	 * @var string
	 */
	protected $ContentLayerThemeName;

	/**
	 * Content Layer Theme Global Layer Table Content
	 *
	 * @var string
	 */
	protected $ContentLayerThemeGlobalLayerContent = array();

	/**
	 * Create an instance of ContentLayer
	 *
	 * @access public
	 */
	public function __construct () {
		$this->Modules = Array();
		$this->DatabaseTable = Array();
		$GLOBALS['ErrorMessage']['ContentLayer'] = array();
		$this->ErrorMessage = &$GLOBALS['ErrorMessage']['ContentLayer'];

		$this->DatabaseAllow = &$GLOBALS['Tier6DatabaseAllow'];
		$this->DatabaseDeny = &$GLOBALS['Tier6DatabaseDeny'];

		$credentaillogonarray = $GLOBALS['credentaillogonarray'];
		$this->LayerModule = new ValidationLayer();
		$this->LayerModule->setPriorLayerModule($this);
		//try {
			$this->createDatabaseTable('ContentLayer');
		//} catch (SoapFault $E) {
			
		//}
		$this->LayerModule->setDatabaseAll ($credentaillogonarray[0], $credentaillogonarray[1], $credentaillogonarray[2], $credentaillogonarray[3], NULL);
		$this->LayerModule->buildModules('ValidationLayerModules', 'ValidationLayerTables', 'ValidationLayerModulesSettings');

		$this->PageID = $_GET['PageID'];

		$this->SessionName['SessionID'] = $_GET['SessionID'];

		$this->Writer = &$GLOBALS['Writer'];
	}

	/**
	 * setVersionTable
	 *
	 * Setter for ContentLayerVersionTableName
	 *
	 * @param string $VersionTableName the name of the content layer's version table.
	 * @access public
	*/
	public function setVersionTable($VersionTableName) {
		$this->ContentLayerVersionTableName = $VersionTableName;
	}

	/**
	 * setThemeTableName
	 *
	 * Setter for ContentLayerThemeTableName
	 *
	 * @param string $TableName the name of the content layer's theme table.
	 * @access public
	*/
	public function setThemeTableName($TableName) {
		$this->ContentLayerThemeTableName = $TableName;
	}

	/**
	 * setThemeGlobalLayerTable
	 *
	 * Setter for ContentLayerThemeGlobalLayerTableName
	 *
	 * @param string $TableName the name of the content layer's theme global layer table.
	 * @access public
	*/
	public function setThemeGlobalLayerTable($TableName) {
		$this->ContentLayerThemeGlobalLayerTableName = $TableName;
	}

	/**
	 * setPrintPreview
	 *
	 * Setter for PrintPreview
	 *
	 * @param bool $PrintPreview set to TRUE or 1 for a page displayed as a printer preview; set to FALSE or 0 for a non printer view page.
	 * @access public
	*/
	public function setPrintPreview($PrintPreview) {
		$this->PrintPreview = $PrintPreview;
	}

	/**
	 * setModules
	 *
	 * Setter for Modules
	 *
	 * @access public
	*/
	public function setModules() {

	}

	public function getModules($key, $key1) {
		return $this->Modules[$key][$key1];
	}

	/**
	 * setDatabaseAll
	 *
	 * Setter for Hostname, User, Password, Database name and Database table
	 *
	 * @param string $Hostname the name of the host needed to connect to database.
	 * @param string $User the user account needed to connect to database.
	 * @param string $Password the user's password needed to connect to database.
	 * @param string $DatabaseName the name of the database needed to connect to database.
	 * @access public
	*/
	//
	public function setDatabaseAll ($Hostname, $User, $Password, $DatabaseName) {
		$this->Hostname = $Hostname;
		$this->User = $User;
		$this->Password = $Password;
		$this->DatabaseName = $DatabaseName;

		$this->LayerModule->setDatabaseAll ($Hostname, $User, $Password, $DatabaseName);

	}

	/**
	 * setDatabaseTableName
	 *
	 * Setter for DatabaseTableName
	 *
	 * @param string $DatabaseTableName the name of the database table to use.
	 * @access public
	*/
	public function setDatabaseTableName ($DatabaseTableName) {
		$this->DatabaseTableName = $DatabaseTableName;
	}

	/**
	 * buildThemeGlobalLayerTable
	 *
	 * Builds ContentLayerThemeGlobalLayerTableName
	 *
	 * @access public
	*/
	public function buildThemeGlobalLayerTable() {
		if ($this->ContentLayerThemeTableName != NULL) {
			$passarray = array();
			$passarray['Enable/Disable'] = 'Enable';

			$this->createDatabaseTable($this->ContentLayerThemeTableName);
			$this->Connect($this->ContentLayerThemeTableName);
			$this->LayerModule->pass ($this->ContentLayerThemeTableName, 'setDatabaseRow', array('idnumber' => $passarray));
			$this->Disconnect($this->ContentLayerThemeTableName);

			$Theme = $this->LayerModule->pass ($this->ContentLayerThemeTableName, 'getMultiRowField', array());
			$this->ContentLayerThemeName = $Theme[0]['ThemeName'];

			$passarray = array();
			$passarray['ThemeName'] = $this->ContentLayerThemeName;

			$this->createDatabaseTable($this->ContentLayerThemeGlobalLayerTableName);
			$this->Connect($this->ContentLayerThemeGlobalLayerTableName);
			$this->LayerModule->pass ($this->ContentLayerThemeGlobalLayerTableName, 'setDatabaseRow', array('idnumber' => $passarray));
			$this->Disconnect($this->ContentLayerThemeGlobalLayerTableName);
			$this->ContentLayerThemeGlobalLayerContent = $this->LayerModule->pass ($this->ContentLayerThemeGlobalLayerTableName, 'getMultiRowField', array());

		}
	}

	/**
	 * ConnectAll
	 *
	 * Connects to all databases
	 *
	 * @access public
	*/
	//
	public function ConnectAll () {
		$this->LayerModule->ConnectAll();
	}

	/**
	 * Connect
	 *
	 * Connect to a database table
	 *
	 * @param string $DatabaseTable the name of the database table to connect to
	 * @access public
	*/
	//
	public function Connect ($DatabaseTable) {
		$this->LayerModule->Connect($DatabaseTable);
	}

	/**
	 * DiscconnectAll
	 *
	 * Disconnects from all databases
	 *
	 * @access public
	*/
	//
	public function DisconnectAll () {
		$this->LayerModule->DisconnectAll();
	}

	/**
	 * Disconnect
	 *
	 * Disconnection from a database table
	 *
	 * @param string $DatabaseTable the name of the database table to disconnect from
	 * @access public
	*/
	//
	public function Disconnect ($DatabaseTable) {
		$this->LayerModule->Disconnect($DatabaseTable);
	}

	/**
	 * buildDatabase
	 *
	 * Build Database!
	 *
	 * @access public
	*/
	public function buildDatabase() {

	}

	/**
	 * createDatabaseTable
	 *
	 * Creates a connection for a database table
	 *
	 * @param string $DatabaseTable the name of the database table to create a connection to
	 * @access public
	*/
	public function createDatabaseTable($DatabaseTable) {
		try {
			$this->LayerModule->createDatabaseTable($DatabaseTable);
		} catch (SoapFault $E) {
			return FALSE;
		}
	}

	protected function checkPass($DatabaseTable, $function, $functionarguments) {
		reset($this->Modules);
		$hold = NULL;

		/*while (current($this->Modules)) {

			$tempobject = current($this->Modules[key($this->Modules)]);
			//$databasetables = $tempobject->getTableNames();
			//$tempobject->FetchDatabase ($this->PageID);
			//$tempobject->CreateOutput($this->Space);
			//$tempobject->getOutput();
			//$hold = $tempobject->Verify($function, $functionarguments);
			next($this->Modules);
		}*/

		$hold2 = $this->LayerModule->pass($DatabaseTable, $function, $functionarguments);
		if ($hold2) {
			return $hold2;
		} else {
			return FALSE;
		}
	}

	public function pass($databasetable, $function, $functionarguments) {
		if (!is_null($functionarguments)) {
			if (is_array($functionarguments)) {
				if (!is_null($function)) {
					if (!is_array($function)) {
						if ($this->DatabaseAllow[$function]) {
							$args = func_num_args();
							if ($args > 3) {
								$hookarguments = func_get_args(4);
								if (is_array($hookarguments)) {
									$hold = $this->LayerModule->pass($databasetable, $function, $functionarguments, $hookargments);
								} else {
									array_push($this->ErrorMessage,'pass: Hook Arguments Must Be An Array!');
								}
							} else {
								$hold = $this->LayerModule->pass($databasetable, $function, $functionarguments);
							}

							if ($hold) {
								return $hold;
							}
						} else if ($this->DatabaseDeny[$function]) {
							$args = func_num_args();
							if ($args > 3) {
								$hookarguments = func_get_args(4);
								if (is_array($hookarguments)) {
									$hold = $this->checkPass($databasetable, $function, $functionarguments, $hookargments);
								} else {
									array_push($this->ErrorMessage,'pass: Hook Arguments Must Be An Array!');
								}
							} else {
								$hold = $this->checkPass($databasetable, $function, $functionarguments);
							}

							if ($hold) {
								return $hold;
							} else {
								return FALSE;
							}
						} else {
							array_push($this->ErrorMessage,'pass: MySqlConnect Member Does Not Exist!');
						}
					} else {
						array_push($this->ErrorMessage,'pass: MySqlConnect Member Cannot Be An Array!');
					}
				} else {
					array_push($this->ErrorMessage,'pass: MySqlConnect Member Cannot Be Null!');
				}
			} else {
				array_push($this->ErrorMessage,'pass: Function Arguments Must Be An Array!');
			}
		} else {
			array_push($this->ErrorMessage,'pass: Function Arguments Cannot Be Null!');
		}
	}

	/**
	 * FetchDatabase
	 *
	 * Fetches a database table based on Page ID as a String or Array
	 *
	 * @param string $PageID the lookupkey for the database table
	 * @param array $PageID the lookupkey for the database table
	 * @access public
	*/

	public function FetchDatabase($PageID) {
		if (!$PageID['PageID']) {
			if ($_GET['PageID']) {
				$PageID['PageID'] = $_GET['PageID'];
			} else {
				$StartID = $this->LayerModuleSetting['ContentLayer']['ContentLayer']['StartID']['SettingAttribute'];
				$PageID['PageID'] = $StartID;
			}
		}

		$this->PageID = $PageID;
		$passarray = array();
		$passarray = $PageID;

		$this->createDatabaseTable($this->DatabaseTableName);
		$this->Connect($this->DatabaseTableName);
		$this->LayerModule->pass ($this->DatabaseTableName, 'setOrderbyname', array('OrderName' => 'ObjectID'));
		$this->LayerModule->pass ($this->DatabaseTableName, 'setOrderbytype', array('OrderType' => 'ASC'));
		$this->LayerModule->pass ($this->DatabaseTableName, 'setDatabaseRow', array('idnumber' => $passarray));
		$this->Disconnect($this->DatabaseTableName);

		$this->ContentLayerDatabase = $this->LayerModule->pass ($this->DatabaseTableName, 'getMultiRowField', array());

		$passarray = array();
		$passarray['PageID'] = $this->PageID['PageID'];
		if ($this->PageID['RevisionID']) {
			$passarray['RevisionID'] = $this->PageID['RevisionID'];
		}
		$passarray['CurrentVersion'] = $this->PageID['CurrentVersion'];

		$this->createDatabaseTable($this->ContentLayerVersionTableName);
		$this->Connect($this->ContentLayerVersionTableName);
		$this->LayerModule->pass ($this->ContentLayerVersionTableName, 'setDatabaseRow', array('idnumber' => $passarray));
		$this->Disconnect($this->ContentLayerVersionTableName);

		$this->ContentLayerVersionDatabase = $this->LayerModule->pass ($this->ContentLayerVersionTableName, 'getMultiRowField', array());

		if (!isset($this->PageID['RevisionID'])) {
			$this->RevisionID = $this->ContentLayerVersionDatabase[0]['RevisionID'];
			$_GET['RevisionID'] = $this->RevisionID;
		}

	}

	/**
	 * CreateOutput
	 *
	 * Creates the output of the Content Layer
	 *
	 * @param string $Space how much space to use for a line indent, can be NULL
	 * @access public
	*/
	public function CreateOutput($Space) {
		if ($this->ContentLayerVersionTableName) {
			if (!empty($this->ContentLayerDatabase[0])) {
				$ContentLayer = &$this->ContentLayerDatabase;
			} else {
				$ContentLayer = &$this->ContentLayerThemeGlobalLayerContent;
			}
			foreach ($ContentLayer as $Key => $ContentLayerDatabase) {
				$PrintPreviewFlag = $ContentLayerDatabase['PrintPreview'];
				if ($this->PrintPreview == FALSE || $PrintPreviewFlag == 'true') {
					$ObjectType = $ContentLayerDatabase['ObjectType'];
					$ObjectTypeName = $ContentLayerDatabase['ObjectTypeName'];
					$ObjectTypeLocation = $this->LayerModuleTable[$ObjectType][$ObjectTypeName]['ObjectTypeLocation'];
					if ($this->LayerModuleTable[$ObjectType][$ObjectTypeName]['ObjectTypeConfiguration'] != NULL) {
						$ObjectTypeConfiguration = $_SERVER['SUBDOMAIN_DOCUMENT_ROOT'];
						$ObjectTypeConfiguration .= '/';
						$ObjectTypeConfiguration .= $this->LayerModuleTable[$ObjectType][$ObjectTypeName]['ObjectTypeConfiguration'];
					}
					$ObjectTypePrintPreview = $this->LayerModuleTable[$ObjectType][$ObjectTypeName]['ObjectTypePrintPreview'];
					$Authenticate = $ContentLayerDatabase['Authenticate'];

					$StartTag = $ContentLayerDatabase['StartTag'];
					$EndTag = $ContentLayerDatabase['EndTag'];
					$StartTagID = $ContentLayerDatabase['StartTagID'];
					$StartTagStyle = $ContentLayerDatabase['StartTagStyle'];
					$StartTagClass = $ContentLayerDatabase['StartTagClass'];

					$ImportFileName = $ContentLayerDatabase['ImportFileName'];
					$ImportFileType = $ContentLayerDatabase['ImportFileType'];

					$ObjectEnableDisable = $this->LayerModuleTable[$ObjectType][$ObjectTypeName]['Enable/Disable'];
					$EnableDisable = $ContentLayerDatabase['Enable/Disable'];

					if ($EnableDisable == 'Enable') {
						if ($Authenticate == 'true') {
							if (!$_COOKIE['LoggedIn']) {
								$AuthenticationPage = $this->LayerModuleSetting['ContentLayer']['ContentLayer']['Authentication']['SettingAttribute'];

								if ($_GET['DestinationPageID']) {
									$DestinationPageID = $_GET['DestinationPageID'];
									setcookie('DestinationPageID', $DestinationPageID, NULL, '/');
								} else {
									$PageID = $this->PageID['PageID'];
									setcookie('DestinationPageID', $PageID, NULL, '/');
								}
								header("Location: $AuthenticationPage");
							} else {
								$this->KeepLoggedIn();

							}
						}

						$UserAccessGroup = $this->ContentLayerVersionDatabase[0]['UserAccessGroup'];
						$CurrentAccessGroup = $_COOKIE[$UserAccessGroup];
						if ($UserAccessGroup == 'Guest' || $UserAccessGroup == ($CurrentAccessGroup == 'Yes')) {
							if ($StartTag) {
								$StartTag = str_replace('<','', $StartTag);
								$StartTag = str_replace('>','', $StartTag);

								$this->Writer->startElement($StartTag);

								if ($StartTagID) {
									$this->Writer->writeAttribute('id', $StartTagID);
								}

								if ($StartTagStyle) {
									$this->Writer->writeAttribute('style', $StartTagStyle);
								}

								if ($StartTagClass) {
									$this->Writer->writeAttribute('class', $StartTagClass);
								}
								$this->Writer->writeRaw("\n");

							}
							
							if ($ObjectEnableDisable == 'Enable') {
								if ($ObjectTypeConfiguration != NULL) {
									if (strstr($ObjectTypeConfiguration, '.html') || strstr($ObjectTypeConfiguration, '.htm')) {
										$file = file_get_contents($ObjectTypeConfiguration);
										$this->Writer->writeRaw($file);
									} else {
										require ("$ObjectTypeConfiguration");
									}
								} else {
									$idnumber = array();
									$idnumber['PageID'] = $this->PageID['PageID'];
									$idnumber['ObjectID'] = 1;
									$idnumber['RevisionID'] = $this->PageID['RevisionID'];
									$idnumber['CurrentVersion'] = $this->PageID['CurrentVersion'];
									$this->Modules[$ObjectType][$ObjectTypeName]->setHttpUserAgent($_SERVER['HTTP_USER_AGENT']);
									$this->Modules[$ObjectType][$ObjectTypeName]->FetchDatabase ($idnumber);
									$this->Modules[$ObjectType][$ObjectTypeName]->CreateOutput('    ');

								}
							}
							if ($ImportFileName != NULL) {
								if ($ImportFileType == 'xml') {
									$this->processXMLFile($ImportFileName);
								}

								if ($ImportFileType == 'html') {
									$this->processHTMLFile($ImportFileName);
								}
							}

							if ($EndTag) {
								$this->Writer->endElement(); // ENDS END TAG
							}

							if ($ObjectType == 'XhtmlHeader') {
								$this->Writer->startElement('body');
							}
						} else {
							if (!$_COOKIE['LoggedIn']) {
								exit;
							} else {
								$DenyRedirectPage = $this->LayerModuleSetting['ContentLayer']['ContentLayer']['DenyRedirect']['SettingAttribute'];
								header("Location: $DenyRedirectPage");
								exit;
							}
						}
					}
				}
			}

			$this->Writer->endElement(); // ENDS BODY
			$this->Writer->endElement(); // ENDS HTML
		} else {
			array_push($this->ErrorMessage,'CreateOutput: Content Layer Version Table Name Cannot Be Null!');
		}
	}

	/**
	 * transverseSimpleXMLAttribute
	 *
	 * Transverses a SimpleXMLElement object
	 *
	 * @param SimpleXMLElement $Attribute the attributes for a SimpleXMLElement object
	 * @access private
	*/
	private function transverseSimpleXMLAttribute (SimpleXMLElement $Attribute) {
		foreach ($Attribute->attributes() as $key => $attributes) {
			$this->Writer->writeAttribute($key, $attributes);
		}
	}

	/**
	 * transverseChildSimpleXMLToOutput
	 *
	 * Transverses a SimpleXMLElement object's child and writes the output to XMLWriter
	 *
	 * @param SimpleXMLElement $Child the child node for a SimpleXMLElement object
	 * @access private
	*/
	private function transverseChildSimpleXMLToOutput(SimpleXMLElement $Child) {
		$hold = $Child->asXML();
		$hold = trim($hold);
		$hold = str_replace("\t", '    ', $hold);
		$RawText = '    ';
		$RawText .= $hold;
		$RawText .= "\n";
		$this->Writer->writeRaw($RawText);
	}

	/**
	 * processXMLFile
	 *
	 * Transverses a XML File and writes the output to XMLWriter
	 *
	 * @param string $XMLFile the file name for an XML File.
	 * @access public
	*/
	public function processXMLFile($XMLFile) {
		if ($XMLFile != NULL) {
			if (file_exists($XMLFile)) {
				libxml_use_internal_errors(true);
				$Xml = simplexml_load_file($XMLFile);
				if ($Xml) {
					foreach($Xml as $child) {
						$this->transverseChildSimpleXMLToOutput($child);
					}
					$this->Writer->writeRaw('  ');
				}
			} else {
				array_push($this->ErrorMessage,'processXMLFile: XMLFile DOES NOT EXIST!');
			}
		} else {
			array_push($this->ErrorMessage,'processXMLFile: XMLFile cannot be NULL!');
		}
	}

	/**
	 * processHTMLFile
	 *
	 * Transverses a HTML File and writes the output to XMLWriter
	 *
	 * @param string $HTMLFile the file name for an HTML File.
	 * @access public
	*/
	public function processHTMLFile($HTMLFile) {
		if ($HTMLFile != NULL) {
			if (file_exists($HTMLFile)) {
				libxml_use_internal_errors(true);
				$Html = simplexml_load_file($HTMLFile);
				if ($Html->body) {
					foreach($Html->body->children() as $child) {
						$this->transverseChildSimpleXMLToOutput($child);
					}
				} else if (!$Html->head) {
					$RootElement = $Html->getName();
					foreach($Html as $child) {
						$this->transverseChildSimpleXMLToOutput($child);
					}
				}
			} else {
				array_push($this->ErrorMessage,'processHTMLFile: HTMLFile DOES NOT EXIST!');
			}
		} else {
			array_push($this->ErrorMessage,'processHTMLFile: HTMLFile cannot be NULL!');
		}
	}

	/**
	 * SessionStart
	 *
	 * Starts a session cookie
	 *
	 * @param string $SessionName the name of the session to start.
	 * @return string the name of the session that was started.
	 * @access public
	*/
	public function SessionStart($SessionName) {
		if ($_COOKIE['SessionID']) {
			$this->SessionDestroy($_COOKIE['SessionID']);
		}
		$sessionname = $SessionName;
		$sessionname .= time();
		setcookie('SessionID', $sessionname, NULL, '/');
		session_name($sessionname);
		session_start();

		return $sessionname;
	}

	/**
	 * SessionDestroy
	 *
	 * Ends a session cookie
	 *
	 * @param string $SessionName the name of the session to end.
	 * @access public
	*/
	public function SessionDestroy($SessionName) {
		if ($SessionName) {
			session_name($SessionName);
			session_start();
			$_SESSION = array();
			if (ini_get('session.use_cookies')) {
				$params = session_get_cookie_params();
				setcookie(session_name(), '', time()-1000,
					$params['path'], $params['domain'],
					$params['secure'], $params['httponly']
				);
			}
			session_destroy();

		}
	}

	public function PostCheck ($PostName, $FilteredInputName, array $Input) {
		if (!is_null($PostName)) {
			if (!is_null($Input)) {
				if ($_POST[$PostName] == 'Null' | $_POST[$PostName] == 'NULL') {
					if (is_null($FilteredInputName)) {
						$Input[$PostName] = NULL;
					} else {
						$_POST[$PostName] = NULL;
						$Input[$FilteredInputName][$PostName] = NULL;
					}

					return $Input;
				}
			} else {
				array_push($this->ErrorMessage,'PostCheck: Input cannot be NULL!');
			}
		} else {
			array_push($this->ErrorMessage,'PostCheck: PostName cannot be NULL!');
		}
	}

	public function MultiPostCheck ($PostName, $StartNumber, $Input) {
		$functionarguments = func_get_args();
		$Seperator = NULL;
		$SecondStartNumber = NULL;
		$PostName2 = NULL;
		$StartNumber2 = NULL;
		$Seperator2 = NULL;
		$SecondStartNumber2 = NULL;
		$PostName3 = NULL;
		if ($functionarguments[3]) {
			$Seperator = $functionarguments[3];
		}
		if ($functionarguments[4]) {
			$SecondStartNumber = $functionarguments[4];
			if (!is_int($SecondStartNumber)) {
				array_push($this->ErrorMessage,'MultiPostCheck: SecondStartNumber must be an integer!');
			}
		}

		if ($functionarguments[5]) {
			$PostName2 = $functionarguments[5];
			if (is_null($PostName2)) {
				array_push($this->ErrorMessage,'MultiPostCheck: PostName2 cannot be NULL!');
			}
		}
		if ($functionarguments[6]) {
			$StartNumber2 = $functionarguments[6];
			if (!is_int($StartNumber2)) {
				array_push($this->ErrorMessage,'MultiPostCheck: StartNumber2 must be an integer!');
			}

			if (is_null($StartNumber2)) {
				array_push($this->ErrorMessage,'MultiPostCheck: StartNumber2 cannot be NULL!');
			}
		}
		if ($functionarguments[7]) {
			$Seperator2 = $functionarguments[7];
			if (is_null($Seperator2)) {
				array_push($this->ErrorMessage,'MultiPostCheck: Seperator2 cannot be NULL!');
			}
		}
		if ($functionarguments[8]) {
			$SecondStartNumber2 = $functionarguments[8];
			if (is_int($SecondStartNumber2)) {
				array_push($this->ErrorMessage,'MultiPostCheck: SecondStartNumber2 must be an integer!');
			}

			if (is_null($SecondStartNumber2)) {
				array_push($this->ErrorMessage,'MultiPostCheck: SecondStartNumber2 cannot be NULL!');
			}
		}
		if ($functionarguments[9]) {
			$PostName3 = $functionarguments[9];
			if (is_null($PostName9)) {
				array_push($this->ErrorMessage,'MultiPostCheck: PostName3 cannot be NULL!');
			}
		}
		
		if (is_int($StartNumber)) {
			if (!is_null($StartNumber)) {
				if (!is_null($PostName)) {
					if (!is_null($Input)) {
						if ($PostName2 == NULL & $StartNumber2 == NULL) {
							if (is_null($Seperator) & is_null($SecondStartNumber)) {
								$i = $StartNumber;
								$temp = $PostName;
								$temp .= $i;

								while (($_POST[$temp])) {
									$hold = $this->PostCheck ($temp, 'FilteredInput', $Input);
									if (!is_null($hold)) {
										$Input = $hold;
									}
									$i++;
									$temp = $PostName;
									$temp .= $i;
								}

								return $Input;
							} else {
								if (is_null($Seperator)) {
									array_push($this->ErrorMessage,'MultiPostCheck: Seperator cannot be NULL!');
								} else {
									if (is_null($SecondStartNumber)) {
										array_push($this->ErrorMessage,'MultiPostCheck: SecondStartNumber cannot be NULL!');
									} else {
										$i = $StartNumber;
										$j = $SecondStartNumber;
										$temp = $PostName;
										$temp .= $i;
										$temp .= $Seperator;
										$temp .= $j;
										while (($_POST[$temp])) {
											while (($_POST[$temp])) {
												$hold = $this->PostCheck ($temp, 'FilteredInput', $Input);
												if (!is_null($hold)) {
													$Input = $hold;
												}
												$j++;
												$temp = $PostName;
												$temp .= $i;
												$temp .= $Seperator;
												$temp .= $j;
											}
											$i++;
											$j = $SecondStartNumber;
											$temp = $PostName;
											$temp .= $i;
											$temp .= $Seperator;
											$temp .= $j;
										}

										return $Input;
									}
								}
							}
						} else {
							if ($StartNumber2 == NULL & $Seperator2 == NULL & is_null($SecondStartNumber2)) {
								if ($PostName2 != NULL) {
									$i = $StartNumber;
									$j = $SecondStartNumber;
									$temp = $PostName;
									$temp .= $i;
									$temp .= $Seperator;
									$temp .= $j;
									$temp .= $PostName2;
									while (array_key_exists($temp, $_POST)) {
										while (array_key_exists($temp, $_POST)) {
											$hold = $this->PostCheck ($temp, 'FilteredInput', $Input);
											if (!is_null($hold)) {
												$Input = $hold;
											}
											$j++;
											$temp = $PostName;
											$temp .= $i;
											$temp .= $Seperator;
											$temp .= $j;
											$temp .= $PostName2;
										}
										$i++;
										$j = $SecondStartNumber;
										$temp = $PostName;
										$temp .= $i;
										$temp .= $Seperator;
										$temp .= $j;
										$temp .= $PostName2;
									}
									return $Input;
								}
							} else {
								if ($PostName2 != NULL & $StartNumber2 != NULL) {
									if ($Seperator != NULL & $SecondStartNumber != NULL & $Seperator2 != NULL & $SecondStartNumber2 != NULL) {
										$i = $StartNumber;
										$j = $SecondStartNumber;
										$k = $StartNumber2;
										$l = $SecondStartNumber2;
										$temp = $PostName;
										$temp .= $i;
										$temp .= $Seperator;
										$temp .= $j;
										$temp .= $PostName2;
										$temp .= $k;
										$temp .= $Seperator2;
										$temp .= $l;
	
										while (($_POST[$temp])) {
											while (($_POST[$temp])) {
												while (($_POST[$temp])) {
													while (($_POST[$temp])) {
														$hold = $this->PostCheck ($temp, 'FilteredInput', $Input);
														if (!is_null($hold)) {
															$Input = $hold;
														}
														$l++;
														$temp = $PostName;
														$temp .= $i;
														$temp .= $Seperator;
														$temp .= $j;
														$temp .= $PostName2;
														$temp .= $k;
														$temp .= $Seperator2;
														$temp .= $l;
													}
													$k++;
													$l = $SecondStartNumber2;
													$temp = $PostName;
													$temp .= $i;
													$temp .= $Seperator;
													$temp .= $j;
													$temp .= $PostName2;
													$temp .= $k;
													$temp .= $Seperator2;
													$temp .= $l;
												}
												$j++;
												$k = $StartNumber2;
												$l = $SecondStartNumber2;
												$temp = $PostName;
												$temp .= $i;
												$temp .= $Seperator;
												$temp .= $j;
												$temp .= $PostName2;
												$temp .= $k;
												$temp .= $Seperator2;
												$temp .= $l;
											}

											$i++;
											$j = $SecondStartNumber;
											$k = $StartNumber2;
											$l = $SecondStartNumber2;
											$temp = $PostName;
											$temp .= $i;
											$temp .= $Seperator;
											$temp .= $j;
											$temp .= $PostName2;
											$temp .= $k;
											$temp .= $Seperator2;
											$temp .= $l;
										}
										return $Input;
									} else {
										if (is_null($Seperator2) & !is_null($SecondStartNumber2)) {
											array_push($this->ErrorMessage,'MultiPostCheck: SecondStartNumber2 is set but Seperator2 cannot be NULL!');
										} else if (!is_null($Seperator2) & is_null($SecondStartNumber2)){
											array_push($this->ErrorMessage,'MultiPostCheck: Seperator2 is set but SecondStartNumber2 cannot be NULL!');
										} else {
											if (is_null($Seperator) & !is_null($SecondStartNumber)) {
												array_push($this->ErrorMessage,'MultiPostCheck: SecondStartNumber is set but Seperator cannot be NULL!');
											} else if (!is_null($Seperator) & is_null($SecondStartNumber)) {
												if (!is_null($PostName3)) {
													$i = $StartNumber;
													$j = $StartNumber2;
													$temp = $PostName;
													$temp .= $i;
													$temp .= $Seperator;
													$temp .= $PostName2;
													$temp .= $j;
													$temp .= $Seperator2;
													$temp .= $PostName3;
													
													while (($_POST[$temp])) {
														while (($_POST[$temp])) {
															$hold = $this->PostCheck ($temp, 'FilteredInput', $Input);
															if (!is_null($hold)) {
																$Input = $hold;
															}
															
															$j++;
															$temp = $PostName;
															$temp .= $i;
															$temp .= $Seperator;
															$temp .= $PostName2;
															$temp .= $j;
															$temp .= $Seperator2;
															$temp .= $PostName3;
														}
														
														$i++;
														$j = $StartNumber2;
														
														$temp = $PostName;
														$temp .= $i;
														$temp .= $Seperator;
														$temp .= $PostName2;
														$temp .= $j;
														$temp .= $Seperator2;
														$temp .= $PostName3;
													}
												} else {
													array_push($this->ErrorMessage,'MultiPostCheck: Seperator is set but SecondStartNumber cannot be NULL!');
												}
											} else if (!is_null($Seperator) & !is_null($SecondStartNumber)){
												$i = $StartNumber;
												$j = $SecondStartNumber;
												$k = $StartNumber2;
												$temp = $PostName;
												$temp .= $i;
												$temp .= $Seperator;
												$temp .= $j;
												$temp .= $PostName2;
												$temp .= $k;

												while (($_POST[$temp])) {
													while (($_POST[$temp])) {
														while (($_POST[$temp])) {
															$hold = $this->PostCheck ($temp, 'FilteredInput', $Input);
															if (!is_null($hold)) {
																$Input = $hold;
															}
															$k++;
															$temp = $PostName;
															$temp .= $i;
															$temp .= $Seperator;
															$temp .= $j;
															$temp .= $PostName2;
															$temp .= $k;
														}
														$j++;
														$k = $StartNumber2;
														$temp = $PostName;
														$temp .= $i;
														$temp .= $Seperator;
														$temp .= $j;
														$temp .= $PostName2;
														$temp .= $k;
													}
													$i++;
													$j = $SecondStartNumber;
													$k = $StartNumber2;
													$temp = $PostName;
													$temp .= $i;
													$temp .= $Seperator;
													$temp .= $j;
													$temp .= $PostName2;
													$temp .= $k;
												}
												return $Input;

											} else if (!is_null($Seperator2) & !is_null($SecondStartNumber2)){
												$i = $StartNumber;
												$j = $StartNumber2;
												$k = $SecondStartNumber2;
												$temp = $PostName;
												$temp .= $i;
												$temp .= $PostName2;
												$temp .= $j;
												$temp .= $Seperator2;
												$temp .= $k;
												while (($_POST[$temp])) {
													while (($_POST[$temp])) {
														while (($_POST[$temp])) {
															$hold = $this->PostCheck ($temp, 'FilteredInput', $Input);
															if (!is_null($hold)) {
																$Input = $hold;
															}
															$k++;
															$temp = $PostName;
															$temp .= $i;
															$temp .= $PostName2;
															$temp .= $j;
															$temp .= $Seperator2;
															$temp .= $k;
														}
														$j++;
														$k = $SecondStartNumber2;
														$temp = $PostName;
														$temp .= $i;
														$temp .= $PostName2;
														$temp .= $j;
														$temp .= $Seperator2;
														$temp .= $k;
													}
													$i++;
													$j = $StartNumber2;
													$k = $SecondStartNumber2;
													$temp = $PostName;
													$temp .= $i;
													$temp .= $PostName2;
													$temp .= $j;
													$temp .= $Seperator2;
													$temp .= $k;
												}
												return $Input;
											} else {
												$i = $StartNumber;
												$j = $StartNumber2;
												$temp = $PostName;
												$temp .= $i;
												$temp .= $PostName2;
												$temp .= $j;
												while (($_POST[$temp])) {
													while (($_POST[$temp])) {
														$hold = $this->PostCheck ($temp, 'FilteredInput', $Input);
														if (!is_null($hold)) {
															$Input = $hold;
														}
														$j++;
														$temp = $PostName;
														$temp .= $i;
														$temp .= $PostName2;
														$temp .= $j;
													}
													$i++;
													$j = $StartNumber2;
													$temp = $PostName;
													$temp .= $i;
													$temp .= $PostName2;
													$temp .= $j;
												}

												return $Input;
											}
										}
									}
								} else {
									array_push($this->ErrorMessage,'MultiPostCheck: StartNumber2 is set but PostName2 cannot be NULL!');
								}
							}
						}
					} else {
						array_push($this->ErrorMessage,'MultiPostCheck: Input cannot be NULL!');
					}
				} else {
					array_push($this->ErrorMessage,'MultiPostCheck: PostName cannot be NULL!');
				}
			} else {
				array_push($this->ErrorMessage,'MultiPostCheck: StartNumber cannot be NULL!');
			}
		} else {
			array_push($this->ErrorMessage,'MultiPostCheck: StartNumber must be an integer!');
		}
	}

	/**
	 * EmptyStringToNullArray
	 *
	 * Sets all "" strings to NULL inside of an array
	 *
	 * @param array $Array the array to transverse to set all "" strings to NULL.
	 * @return array the array that was changed.
	 * @access public
	*/
	public function EmptyStringToNullArray (array $Array) {
		foreach ($Array as $key => $value) {
			if ($value == "") {
				$Array[$key] = NULL;
			} else if (is_array($value)) {
				foreach ($value as $key2 => $value2) {
					if ($value2 == "") {
						$Array[$key][$key2] = NULL;
					}
				}
			}
		}
		return $Array;
	}

	/**
	 * Login
	 *
	 * Logs a user into the system.
	 *
	 * @access public
	*/
	public function Login() {
		$sessionname = $this->SessionStart('UserAuthentication');
		
		$EventData = array();
		$PassArray = array();
		$PassArray['Execute'] = TRUE;
		$PassArray['Method'] = 'createLogonHistoryEvent';
		$PassArray['ObjectType'] = 'LogonMonitor';
		$PassArray['ObjectTypeName'] = 'logonmonitor';
		
		$SpamData = array();
		$SpamData['IPAddress'] = $_SERVER['REMOTE_ADDR'];
		$SpamPassArray = array();
		$SpamPassArray['Execute'] = TRUE;
		$SpamPassArray['Method'] = 'findBannedIPAddress';
		$SpamPassArray['ObjectType'] = 'SpamFilter';
		$SpamPassArray['ObjectTypeName'] = 'spamfilter';
		
		$Return = $this->LayerModule->pass('BannedIPAddress', 'PROTECT', $SpamData, $SpamPassArray);
		
		if ($Return === 'TRUE') {
			$loginidnumber = Array();
			$loginidnumber['PageID'] = $_POST['Login'];
			if ($_GET['PageID']){
				$loginidnumber['PageID'] = $_GET['PageID'];
			}
	
			$DestinationPageID = NULL;
			if ($_GET['DestinationPageID']) {
				$DestinationPageID = $_GET['DestinationPageID'];
			}
	
			$AuthenticationPage = $this->LayerModuleSetting['ContentLayer']['ContentLayer']['Authentication']['SettingAttribute'];
	
			$this->LayerModule->setPageID($loginidnumber['PageID']);
			$hold = $this->LayerModule->pass('FormValidation', 'FORM', $_POST);
			if ($hold['Error']) {
				$_SESSION['POST'] = $hold;
				$EventData['UserName'] = $_POST['UserName'];
				$EventData['IPAddress'] = $_SERVER['REMOTE_ADDR'];
				$EventData['Timestamp'] = $_SERVER['REQUEST_TIME'];
				$EventData['LogonType'] = 'BadCaptcha';
				$this->LayerModule->pass('UserAccountsLogonHistory', 'PROTECT', $EventData, $PassArray);
				
				header("Location: $AuthenticationPage&SessionID=$sessionname");
				
			} else {
				$hold = NULL;
				$hold = $this->LayerModule->pass('UserAccounts', 'AUTHENTICATE', $_POST);
				if ($hold['Error']) {
					$EventData['UserName'] = $_POST['UserName'];
					$EventData['IPAddress'] = $_SERVER['REMOTE_ADDR'];
					$EventData['Timestamp'] = $_SERVER['REQUEST_TIME'];
					$EventData['LogonType'] = 'BadLogonAttempt';
					$this->LayerModule->pass('UserAccountsLogonHistory', 'PROTECT', $EventData, $PassArray);
					
					$_SESSION['POST'] = $hold;
					header("Location: $AuthenticationPage&SessionID=$sessionname");
				} else {
					$passarray = array();
					$passarray['getUserInfo'] = array(array());
					$hold = $this->LayerModule->pass('UserAccounts', 'AUTHENTICATE', $_POST, $passarray);
					$UserInfo = $hold['getUserInfo']['UserAccounts'][0];
					unset($UserInfo['Password']);
					unset($UserInfo['Salt']);
	
					$username = $_POST['UserName'];
					setcookie("UserName", $username, NULL, '/');
					setcookie("LoggedIn", TRUE, time()+3600, '/');
					setcookie('Administrator', $UserInfo['Administrator'], time()+3600, '/');
					setcookie('ContentCreator', $UserInfo['ContentCreator'], time()+3600, '/');
					setcookie('Editor', $UserInfo['Editor'], time()+3600, '/');
					setcookie('User', $UserInfo['User'], time()+3600, '/');
					setcookie('Guest', $UserInfo['Guest'], time()+3600, '/');
					
					$EventData['UserName'] = $username;
					$EventData['IPAddress'] = $_SERVER['REMOTE_ADDR'];
					$EventData['Timestamp'] = $_SERVER['REQUEST_TIME'];
					$EventData['LogonType'] = 'GoodLogonAttempt';
					
					if ($DestinationPageID) {
						$this->LayerModule->pass('UserAccountsLogonHistory', 'PROTECT', $EventData, $PassArray);
						header("Location: index.php?PageID=$DestinationPageID");
						exit;
					} else {
						$this->LayerModule->pass('UserAccountsLogonHistory', 'PROTECT', $EventData, $PassArray);
						header("Location: index.php");
						exit;
					}
				}
			}
		
		} else {
			$EventData['UserName'] = $_POST['UserName'];
			$EventData['IPAddress'] = $_SERVER['REMOTE_ADDR'];
			$EventData['Timestamp'] = $_SERVER['REQUEST_TIME'];
			$EventData['LogonType'] = 'Spam';
			$this->LayerModule->pass('UserAccountsLogonHistory', 'PROTECT', $EventData, $PassArray);
			
			$_SESSION['POST']['Error']['SPAM'] = 'Your IP Address Has Been Banned From The Accessing Site.';
			$_SESSION['POST']['Error']['SPAM'] .= "<br />";
			$_SESSION['POST']['Error']['SPAM'] .= 'If This Is In Error Contact Site Adminstrator!';
			
			$AuthenticationPage = $this->LayerModuleSetting['ContentLayer']['ContentLayer']['Authentication']['SettingAttribute'];
			header("Location: $AuthenticationPage&SessionID=$sessionname");
		}
	}

	/**
	 * KeepLoggedIn
	 *
	 * Keeps a user logged in
	 *
	 * @access public
	*/

	public function KeepLoggedIn() {
		if ($_COOKIE['LoggedIn']) {
			setcookie("LoggedIn", TRUE, time()+3600, '/');
		}
	}

	/**
	 * LogOff
	 *
	 * Logs a user off the system
	 *
	 * @access public
	*/
	public function Logoff() {
		setcookie("UserName", '', time()-1000, '/');
		setcookie("LoggedIn", '', time()-1000, '/');
		setcookie('Administrator', '', time()-1000, '/');
		setcookie('ContentCreator', '', time()-1000, '/');
		setcookie('Editor', '', time()-1000, '/');
		setcookie('User', '', time()-1000, '/');
		setcookie('Guest', '', time()-1000, '/');

		$DestinationPageID = NULL;
		if ($_GET['DestinationPageID']) {
			$DestinationPageID = $_GET['DestinationPageID'];
		}

		if ($DestinationPageID) {
			header("Location: index.php?PageID=$DestinationPageID");
			exit;
		} else {
			$AuthenticationPage = $this->LayerModuleSetting['ContentLayer']['ContentLayer']['Authentication']['SettingAttribute'];
			header("Location: $AuthenticationPage");
			exit;
		}
	}

	/**
	 * Register
	 *
	 * Registers a user account
	 *
	 * @access public
	*/
	public function Register() {
		$sessionname = $this->SessionStart('UserRegistration');

		$loginidnumber = Array();
		$loginidnumber['PageID'] = $_POST['Register'];
		if ($_GET['PageID']){
			$loginidnumber['PageID'] = $_GET['PageID'];
		}

		$RegisterPage = $this->LayerModuleSetting['ContentLayer']['ContentLayer']['Register']['SettingAttribute'];

		$this->LayerModule->setPageID($loginidnumber['PageID']);
		$hold = $this->LayerModule->pass('FormValidation', 'FORM', $_POST);

		if ($hold['Error']) {
			$_SESSION['POST'] = $hold;
			header("Location: $RegisterPage&SessionID=$sessionname");
		} else {
			$hold = NULL;
			$passarray = array();
			$passarray['checkUserName'] = $_POST['UserName'];
			$hold = $this->LayerModule->pass('UserAccounts', 'AUTHENTICATE', $_POST, $passarray);
			if ($hold['checkUserName']) {
				$hold['Error']['UserName'] = 'User Name already exists, please try again!';
				$_SESSION['POST'] = $hold;
				header("Location: $RegisterPage&SessionID=$sessionname");
				exit;
			} else {
				$hold = array();
				$PasswordCreationPage = $this->LayerModuleSetting['ContentLayer']['ContentLayer']['PasswordCreation']['SettingAttribute'];
				$EmailVerificationLocation = $this->LayerModuleSetting['ContentLayer']['ContentLayer']['EmailVerificationLocation']['SettingAttribute'];

				$location = $EmailVerificationLocation;
				$location .= $PasswordCreationPage;

				$passarray = array();
				$passarray['createUserAccount'] = array('UserName' => $_POST['UserName'], 'EmailAddress' => $_POST['Email']);
				$passarray['generateNewUserEmail'] = array('EmailAddress' => $_POST['Email'], 'Location' => $location);
				$hold = $this->LayerModule->pass('UserAccounts', 'AUTHENTICATE', $_POST, $passarray);
				if ($hold['Error']) {
					$_SESSION['POST'] = $hold;
					header("Location: $RegisterPage&SessionID=$sessionname");
					exit;
				} else {
					//$this->SessionDestroy($sessionname);
					$RegisterRedirectPage = $this->LayerModuleSetting['ContentLayer']['ContentLayer']['RegisterRedirect']['SettingAttribute'];
					header("Location: $RegisterRedirectPage");
					exit;
				}
			}

		}
	}

	/**
	 * NewUserChangePassword
	 *
	 * Changes a password when a user creates an account
	 *
	 * @access public
	*/
	public function NewUserChangePassword() {
		$sessionname = $this->SessionStart('PasswordCreation');

		$loginidnumber = Array();
		$loginidnumber['PageID'] = $_POST['PasswordCreation'];
		if ($_GET['PageID']){
			$loginidnumber['PageID'] = $_GET['PageID'];
		}

		$PasswordCreationPage = $this->LayerModuleSetting['ContentLayer']['ContentLayer']['PasswordCreation']['SettingAttribute'];
		$PasswordChangedPage = $this->LayerModuleSetting['ContentLayer']['ContentLayer']['PasswordChanged']['SettingAttribute'];
		$this->LayerModule->setPageID($loginidnumber['PageID']);
		$hold = $this->LayerModule->pass('FormValidation', 'FORM', $_POST);

		if ($hold['Error']) {
			$_SESSION['POST'] = $hold;
			header("Location: $PasswordCreationPage&SessionID=$sessionname");
			exit;
		} else {
			$hold = array();
			$passarray = array();
			$passarray['createNewUserPassword'] = array('UserName' => $_POST['UserName'], 'Password' => $_POST['Password'], 'UserCode' => $_POST['UserCode']);
			$hold = $this->LayerModule->pass('UserAccounts', 'AUTHENTICATE', $_POST, $passarray);
			if ($hold['Error']) {
				$_SESSION['POST'] = $hold;
				header("Location: $PasswordCreationPage&SessionID=$sessionname");
				exit;
			} else {
				$this->SessionDestroy($sessionname);
				header("Location: $PasswordChangedPage");
				exit;
			}
		}
	}

	/**
	 * ChangePassword
	 *
	 * Changes a users password
	 *
	 * @access public
	*/
	public function ChangePassword() {

	}

	/**
	 * ResetPassword
	 *
	 * Resets a users password
	 *
	 * @access public
	*/
	public function ResetPassword() {
		$sessionname = $this->SessionStart('PasswordReset');

		$loginidnumber = Array();
		$loginidnumber['PageID'] = $_POST['PasswordReset'];
		if ($_GET['PageID']){
			$loginidnumber['PageID'] = $_GET['PageID'];
		}

		$EmailVerificationLocation = $this->LayerModuleSetting['ContentLayer']['ContentLayer']['EmailVerificationLocation']['SettingAttribute'];
		$PasswordResetPage = $this->LayerModuleSetting['ContentLayer']['ContentLayer']['PasswordReset']['SettingAttribute'];
		$PasswordResetChangePage = $this->LayerModuleSetting['ContentLayer']['ContentLayer']['PasswordResetChange']['SettingAttribute'];
		$PasswordResetLocationPage = $this->LayerModuleSetting['ContentLayer']['ContentLayer']['PasswordResetLocation']['SettingAttribute'];

		$this->LayerModule->setPageID($loginidnumber['PageID']);
		$hold = $this->LayerModule->pass('FormValidation', 'FORM', $_POST);

		if ($hold['Error']) {
			$_SESSION['POST'] = $hold;
			header("Location: $PasswordResetPage&SessionID=$sessionname");
			exit;
		} else {
			$hold = array();

			$location = $EmailVerificationLocation;
			$location .= $PasswordResetLocationPage;

			$passarray = array();
			$passarray['resetUserPassword'] = array('UserName' => $_POST['UserName'], 'Email' => $_POST['Email'], 'Location' => $location);
			$hold = $this->LayerModule->pass('UserAccounts', 'AUTHENTICATE', $_POST, $passarray);

			if ($hold['Error']) {
				$_SESSION['POST'] = $hold;
				header("Location: $PasswordResetPage&SessionID=$sessionname");
				exit;
			} else {
				$this->SessionDestroy($sessionname);
				header("Location: $PasswordResetChangePage");
				exit;
			}
		}
	}

	/**
	 * ChangeResetPassword
	 *
	 * Changes a users password
	 *
	 * @access public
	*/
	public function ChangeResetPassword() {
		$sessionname = $this->SessionStart('PasswordResetChange');

		$loginidnumber = Array();
		$loginidnumber['PageID'] = $_POST['PasswordResetChange'];
		if ($_GET['PageID']){
			$loginidnumber['PageID'] = $_GET['PageID'];
		}

		$PasswordResetChangePage = $this->LayerModuleSetting['ContentLayer']['ContentLayer']['PasswordResetChangePage']['SettingAttribute'];
		$PasswordResetLocation = $this->LayerModuleSetting['ContentLayer']['ContentLayer']['PasswordResetLocation']['SettingAttribute'];
		$this->LayerModule->setPageID($loginidnumber['PageID']);
		$hold = $this->LayerModule->pass('FormValidation', 'FORM', $_POST);

		if ($hold['Error']) {
			$_SESSION['POST'] = $hold;
			header("Location: $PasswordResetLocation&SessionID=$sessionname");
			exit;
		} else {
			$hold = array();
			$passarray = array();
			$passarray['changeUserPassword'] = array('UserName' => $_POST['UserName'], 'Password' => $_POST['Password'], 'UserCode' => $_POST['UserCode']);
			$hold = $this->LayerModule->pass('UserAccounts', 'AUTHENTICATE', $_POST, $passarray);
			if ($hold['Error']) {
				$_SESSION['POST'] = $hold;
				header("Location: $PasswordResetLocation&SessionID=$sessionname");
				exit;
			} else {
				$this->SessionDestroy($sessionname);
				header("Location: $PasswordResetChangePage");
				exit;
			}
		}

	}

	public function FormSubmitValidate($SessionName, $PageName) {
		$FileLocation = NULL;
		$FileName = NULL;
		$FileDataForm = NULL;
		$ElementName = NULL;
		$AddLookupData = NULL;
		$XMLOptions = NULL;
		$arguments = func_get_args();
		
		if ($arguments[2] != NULL) {
			$FileLocation = $arguments[2];
		}

		if ($arguments[3] != NULL) {
			$FileDataForm = $arguments[3];
		}

		if ($arguments[4] != NULL) {
			$ElementName = $arguments[4];
		}

		if ($arguments[5] != NULL) {
			$AddLookupData = $arguments[5];
		}
		
		if ($arguments[6] != NULL) {
			$XMLOptions = $arguments[6];
		}

		$sessionname = $this->SessionStart($SessionName);
		if ($FileLocation != NULL) {
			$FileName = $FileLocation . $sessionname . '.xml';
		}

		$loginidnumber = Array();
		$loginidnumber['PageID'] = $_POST[$SessionName];
		if ($_GET['PageID']){
			$loginidnumber['PageID'] = $_GET['PageID'];
		}

		$this->LayerModule->setPageID($loginidnumber['PageID']);
		if ($AddLookupData !== NULL) {
			$PassArguments = array();
			$PassArguments[0]['Module'] = 'FormValidation';
			$PassArguments[0]['Name'] = 'formvalidation';
			$PassArguments[0]['POST'] = $_POST;
			$PassArguments[0]['AddLookupData'] = $AddLookupData;
			$hold = $this->LayerModule->pass('FormValidation', 'FORMBYPASS', $PassArguments);
		} else {
			$hold = $this->LayerModule->pass('FormValidation', 'FORM', $_POST);
		}

		if ($hold['FilteredInput']['Priority']) {
			$hold['FilteredInput']['Priority'] *= 10;
		}

		if ($hold['FilteredInput']['Frequency']) {
			$hold['FilteredInput']['Frequency'] = ucfirst($hold['FilteredInput']['Frequency']);
		}

		if ($hold['Error']) {
			if ($FileName != NULL & $FileDataForm != NULL) {
				if ($XMLOptions != NULL) {
					$this->ProcessFormXMLFile($FileName, $FileDataForm, $ElementName, $XMLOptions);
				} else {
					$this->ProcessFormXMLFile($FileName, $FileDataForm, $ElementName);
				}
			}
			$_SESSION['POST'] = $hold;
			header("Location: $PageName&SessionID=$sessionname");
			exit;
		} else {
			if ($hold) {
				return $hold;
			} else {
				return FALSE;
			}
		}
	}

	public function ProcessFormXMLFile($FileName, $FileDataForm, $ElementName) {
		$RootElementName = NULL;
		$Attribute = NULL;
		$Raw = NULL;
		$Skip = NULL;
		$Repeat = NULL;
		$arguments = func_get_args();
		if ($arguments[3] != NULL) {
			$RootElementName = $arguments[3]['RootElementName'];
			$Attribute = $arguments[3]['Attribute'];
			$Raw = $arguments[3]['Raw'];
			$Skip = $arguments[3]['Skip'];
			$Repeat = $arguments[3]['Repeat'];
		}
		$XMLFile = new XmlWriter();
		$XMLFile->openURI($FileName);
		$XMLFile->setIndent(4);
		$XMLFile->startDocument('1.0', 'utf-8');
		if ($RootElementName != NULL) {
			$XMLFile->startElement($RootElementName);
		} else {
			$XMLFile->startElement('Content');
		}
		foreach ($FileDataForm as $Key => $Value) {
			if ($Skip != NULL) {
				if ($Key == $Skip) {
					if (is_array($Value)) {
						foreach ($Value as $SubKey => $SubValue) {
							if (!is_array($SubValue)) {
								$XMLFile->startElement($SubKey);
								$XMLFile->text($SubValue);
								$XMLFile->endElement(); // ENDS KEY
							} else {
								if ($Repeat != NULL & array_key_exists($SubKey, $Repeat)) {
									$RepeatAttribute = $Repeat[$SubKey]['name'];
									$RepeatOptions = $Repeat[$SubKey]['options'];
									if (is_array($SubValue[$RepeatAttribute])) {
										$XMLFile->startElement($SubKey);
										foreach ($SubValue[$RepeatAttribute] as $FinalKey => $FinalValue) {
											$XMLFile->startElement($RepeatAttribute);
											if (is_array($RepeatOptions)) {
												foreach ($RepeatOptions as $OptionsKey => $OptionsValue) {
													$XMLFile->writeAttribute($OptionsKey, $OptionsValue);
												}
											}
											$XMLFile->text($FinalValue);
											$XMLFile->endElement(); // ENDS REPEATATTRIBUTE
										}
										
										$XMLFile->endElement(); // ENDS KEY
									}
								} else {
									$XMLFile->startElement($SubKey);
									$this->RecursiveProcessFormXMLFileElement($SubValue, $XMLFile);
									$XMLFile->endElement(); // ENDS KEY
								}
							} 
						}
					}
					continue; 
				}
			}
			
			if ($ElementName != NULL) {
				$XMLFile->startElement($ElementName);
			} else {
				$XMLFile->startElement($Key);
			}
			if ($Attribute != NULL) {
				$XMLFile->writeAttribute($Attribute, $Key);
			} else {
				$XMLFile->writeAttribute('name', $Key);
			}

			if ($Raw === 'true') {
				if (is_array($Value)) {
					foreach ($Value as $SubKey => $SubValue) {
						if (is_array($SubValue)) {
							foreach ($SubValue as $FinalSubKey => $FinalSubValue) {
								$XMLFile->startElement($SubKey);
								if (is_array($FinalSubValue)) {
									$this->RecursiveProcessFormXMLFileElement($FinalSubValue, $XMLFile);
								} else {
									$XMLFile->text($FinalSubValue);
								}
								
								$XMLFile->endElement(); // ENDS SUBKEY
							}
						} else {
						
						}
					}
				} else {
					$XMLFile->text($Value);
				}
			} else {
				if (is_array($Value)) {
					$this->RecursiveProcessFormXMLFileElement($Value, $XMLFile);
				} else {
					$XMLFile->text($Value);
				}
			}
			$XMLFile->endElement(); // ENDS KEY OR ELEMENTNAME
		}
		$XMLFile->endElement(); // ENDS Content OR ROOTELEMENTNAME;
		$XMLFile->endDocument();
	}
	
	public function RecursiveProcessFormXMLFileElement ($Data, XmlWriter $XMLFile) {
		foreach ($Data as $Element => $Value) {
			if (is_array($Value)) {
				$XMLFile->startElement($Element);
					$this->RecursiveProcessFormXMLFileElement($Value, $XMLFile);
				$XMLFile->endElement(); // ENDS ELEMENT
			} else {
				$XMLFile->startElement($Element);
				$XMLFile->text($Value);
				$XMLFile->endElement(); // ENDS ELEMENT
			}
		}
	}
	
	public function FormSubmit($SessionName, $PageName, $ObjectType, $Function, array $Arguments) {

	}

	public function ModulePass($ModuleType, $ModuleName, $Function, array $Arguments) {
		if ($ModuleType != NULL && $ModuleName != NULL && $Function != NULL) {
			$Args = func_get_args();
			$PassArguments = array();
			$PassArguments[0] = $Arguments;
			if ($Args[4] != NULL) {
				$PassArguments[1] = $Args[4];
			}
			
			$hold = call_user_func_array(array($this->Modules[$ModuleType][$ModuleName], $Function), $PassArguments);
			if ($hold) {
				return $hold;
			}
		}
	}

	public function LayerModulePass($Function, array $Arguments) {
		if ($Function != NULL) {
			$PassArguments = array();
			$PassArguments[0] = $Arguments;
			$hold = call_user_func_array(array($this->LayerModule, $Function), $PassArguments);
			if ($hold) {
				return $hold;
			}
		}
	}

	public function getContentVersionRow(array $PageID, $DatabaseTableName) {
		if ($PageID != NULL & $DatabaseTableName != NULL) {
			$this->createDatabaseTable($DatabaseTableName);
			$this->LayerModule->Connect($DatabaseTableName);
			$this->LayerModule->pass ($DatabaseTableName, 'setDatabaseRow', array('idnumber' => $PageID));
			$this->LayerModule->Disconnect($DatabaseTableName);

			$hold = $this->LayerModule->pass ($DatabaseTableName, 'getMultiRowField', array());
			return $hold;
		} else {
			array_push($this->ErrorMessage,'getContentVersionRow: PageID and Database Table Name cannot be NULL!');
		}
	}

	public function createContentVersion(array $Content, $DatabaseTableName) {
		if ($Content != NULL & $DatabaseTableName != NULL) {
			$this->createDatabaseTable($DatabaseTableName);
			$Keys = array();
			$Keys[0] = 'PageID';
			$Keys[1] = 'RevisionID';
			$Keys[2] = 'CurrentVersion';
			$Keys[3] = 'ContentPageType';
			$Keys[4] = 'ContentPageMenuName';
			$Keys[5] = 'ContentPageMenuTitle';
			$Keys[6] = 'ContentPageMenuObjectID';
			$Keys[7] = 'UserAccessGroup';
			$Keys[8] = 'Owner';
			$Keys[9] = 'Creator';
			$Keys[10] = 'LastChangeUser';
			$Keys[11] = 'CreationDateTime';
			$Keys[12] = 'LastChangeDateTime';
			$Keys[13] = 'PublishDate';
			$Keys[14] = 'UnpublishDate';

			$this->addModuleContent($Keys, $Content, $DatabaseTableName);
		} else {
			array_push($this->ErrorMessage,'createContentVersion: Content Version and Database Table Name cannot be NULL!');
		}
	}

	public function updateContentVersion(array $PageID, $DatabaseTableName) {
		$arguments = func_get_args();
		$Data = $arguments[2];
		if ($PageID != NULL & $DatabaseTableName != NULL) {
			$this->createDatabaseTable($DatabaseTableName);
			if ($Data != NULL) {
				$this->updateModuleContent($PageID, $DatabaseTableName, $Data);
			} else {
				$this->updateModuleContent($PageID, $DatabaseTableName);
			}
		} else {
			array_push($this->ErrorMessage,'updateContentVersion: PageID and Database Table Name cannot be NULL!');
		}
	}

	public function updateContentVersionStatus(array $PageID, $DatabaseTableName) {
		if ($PageID != NULL & $DatabaseTableName != NULL) {
			$this->createDatabaseTable($DatabaseTableName);
			$PassID = array();
			$PassID['PageID'] = $PageID['PageID'];

			if ($PageID['EnableDisable'] == 'Enable') {
				$this->enableModuleContent($PassID, $DatabaseTableName);
			} else if ($PageID['EnableDisable'] == 'Disable') {
				$this->disableModuleContent($PassID, $DatabaseTableName);
			}

			if ($PageID['Status'] == 'Approved') {
				$this->approvedModuleContent($PassID, $DatabaseTableName);
			} else if ($PageID['Status'] == 'Not-Approved') {
				$this->notApprovedModuleContent($PassID, $DatabaseTableName);
			} else if ($PageID['Status'] == 'Pending') {
				$this->pendingModuleContent($PassID, $DatabaseTableName);
			} else if ($PageID['Status'] == 'Spam') {
				$this->spamModuleContent($PassID, $DatabaseTableName);
			}
		} else {
			array_push($this->ErrorMessage,'updateContentVersionStatus: PageID and Database Table Name cannot be NULL!');
		}
	}

	public function deleteContentVersion(array $PageID, $DatabaseTableName) {
		if ($PageID != NULL & $DatabaseTableName != NULL) {
			$this->createDatabaseTable($DatabaseTableName);
			$this->deleteModuleContent($PageID, $DatabaseTableName);
		} else {
			array_push($this->ErrorMessage,'deleteContentVersion: PageID and Database Table Name cannot be NULL!');
		}
	}

	public function createContent(array $Content, $DatabaseTableName) {
		if ($Content != NULL & $DatabaseTableName != NULL) {
			$this->createDatabaseTable($DatabaseTableName);
			$Keys = array();
			$Keys[0] = 'PageID';
			$Keys[1] = 'ObjectID';
			$Keys[2] = 'ObjectType';
			$Keys[3] = 'ObjectTypeName';
			$Keys[4] = 'ContainerObjectID';
			$Keys[5] = 'RevisionID';
			$Keys[6] = 'CurrentVersion';
			$Keys[7] = 'Authenticate';
			$Keys[8] = 'PrintPreview';
			$Keys[9] = 'StartTag';
			$Keys[10] = 'EndTag';
			$Keys[11] = 'StartTagID';
			$Keys[12] = 'StartTagStyle';
			$Keys[13] = 'StartTagClass';
			$Keys[14] = 'ImportFileName';
			$Keys[15] = 'ImportFileType';
			$Keys[16] = 'Enable/Disable';
			$Keys[17] = 'Status';

			$this->addModuleContent($Keys, $Content, $DatabaseTableName);
		} else {
			array_push($this->ErrorMessage,'createContent: Content Version and Database Table Name cannot be NULL!');
		}
	}

	public function updateContent(array $PageID, $DatabaseTableName) {
		if ($PageID != NULL & $DatabaseTableName != NULL) {
			$this->createDatabaseTable($DatabaseTableName);
			$this->updateModuleContent($PageID, $DatabaseTableName);
		} else {
			array_push($this->ErrorMessage,'updateContent: PageID and Database Table Name cannot be NULL!');
		}
	}

	public function updateContentStatus(array $PageID, $DatabaseTableName) {
		if ($PageID != NULL & $DatabaseTableName != NULL) {
			$this->createDatabaseTable($DatabaseTableName);
			$PassID = array();
			$PassID['PageID'] = $PageID['PageID'];

			if ($PageID['EnableDisable'] == 'Enable') {
				$this->enableModuleContent($PassID, $DatabaseTableName);
			} else if ($PageID['EnableDisable'] == 'Disable') {
				$this->disableModuleContent($PassID, $DatabaseTableName);
			}

			if ($PageID['Status'] == 'Approved') {
				$this->approvedModuleContent($PassID, $DatabaseTableName);
			} else if ($PageID['Status'] == 'Not-Approved') {
				$this->notApprovedModuleContent($PassID, $DatabaseTableName);
			} else if ($PageID['Status'] == 'Pending') {
				$this->pendingModuleContent($PassID, $DatabaseTableName);
			} else if ($PageID['Status'] == 'Spam') {
				$this->spamModuleContent($PassID, $DatabaseTableName);
			}
		} else {
			array_push($this->ErrorMessage,'updateContentStatus: PageID and Database Table Name cannot be NULL!');
		}
	}

	public function deleteContent(array $PageID, $DatabaseTableName) {
		if ($PageID != NULL & $DatabaseTableName != NULL) {
			$this->createDatabaseTable($DatabaseTableName);
			$this->deleteModuleContent($PageID, $DatabaseTableName);
		} else {
			array_push($this->ErrorMessage,'deleteContent: PageID and Database Table Name cannot be NULL!');
		}
	}

}

?>