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

abstract class Tier6ContentLayerModulesAbstract extends LayerModulesAbstract
{
	protected $Writer;
	protected $GlobalWriter;
	protected $FileName;
	protected $NoAttributes;

	protected $RevisionID;
	protected $CurrentVersion;

	protected $StartTag;
	protected $EndTag;
	protected $StartTagID;
	protected $StartTagStyle;
	protected $StartTagClass;

	protected $PrintPreview;
	protected $EnableDisable;
	protected $Status;
	protected $HttpUserAgent;
	protected $HttpAccept;
	
	protected $HttpOutput; // URL OUTPUT CAN BE: HTML, HTML5, HTML4Trans, HTML4Frame, HTML4Strict, XML, XHTML
	protected $HttpScreen; // URL SCREEN TYPE CAN BE: Print, Touch, Mobile, Full
	protected $HttpOutputDefault; // DEFAULT VALUE FOR HttpOutput 
	protected $HttpOutputAutoDetect; // IF TRUE WILL SHOW THE HIGHEST CAPABLE HttpOutput AVAILABLE FOR THE BROWSER

	protected $ContentTableName;
	protected $ContentObjectName;
	protected $VersionRowMethodName;

	public function getEmpty() {
		return $this->Empty;
	}

	public function getRevisionID() {
		return $this->RevisionID;
	}

	public function getCurrentVersion() {
		return $this->CurrentVersion;
	}

	public function getStartTag() {
		return $this->StartTag;
	}

	public function getEndTag() {
		return $this->EndTag;
	}

	public function getStartTagID() {
		return $this->StartTagID;
	}

	public function getStartTagStyle() {
		return $this->StartTagStyle;
	}

	public function getStartTagClass() {
		return $this->StartTagClass;
	}

	public function getPrintPreview() {
		return $this->PrintPreview;
	}

	public function getEnableDisable() {
		return $this->EnableDisable;
	}

	public function getStatus() {
		return $this->Status;
	}

	public function setHttpUserAgent ($HttpUserAgent) {
		$this->HttpUserAgent = $HttpUserAgent;
	}

	public function getHttpUserAgent() {
		return $this->HttpUserAgent;
	}

	public function getStripTagsContent($Content) {
		if (is_array($Content)) {
			reset($Content);
			while (current($Content)) {
				$Content[key($Content)] = $this->getStripTagsContent(current($Content));
				next($Content);
			}
			return $Content;
		} else {
			return $this->StripTagsContent($Content);
		}
	}

	public function getTag(array $Content) {
		return $this->SearchContentForTag($Content['Tag'], $Content['Content']);
	}

	public function removeTag(array $Content) {
		return $this->SearchReplaceTag($Content['Tag'], $Content['Content']);
	}

	public function addWordSpace(array $Content) {
		return $this->SearchReplaceWordSpace($Content['Content']);
	}
	/*protected function CreateWordWrap($wordwrapstring) {
		if (stristr($wordwrapstring, '<a href')) {
			// Strip AHef Tags for wordwrap then put them back in
			$firstpos = strpos($wordwrapstring, '<a href');
			$lastpos = strpos($wordwrapstring, '</a>');
			$lastpos = $lastpos + 3;

			// Split a string into an array - character by character
			$newwordwrapstring = Array();
			$j = 0;
			$end = strlen($wordwrapstring);
			while ($j <= $end) {
				array_push ($newwordwrapstring, $wordwrapstring[$j]);
				$j++;
			}

			$j = $firstpos;
			while ($j <= $lastpos) {
				$endstring .= $newwordwrapstring[$j];
				$j++;
			}

			$returnstring = $endstring;
			$returnstring = str_replace (' ', '<SPACE>', $returnstring);
			$wordwrapstring = str_replace ($endstring, $returnstring, $wordwrapstring);
			// END STRIP AHREF TAG FOR WORDWRAP

			$wordwrapstring = wordwrap($wordwrapstring, 100, "\n$this->Space$this->Space");
			$wordwrapstring = str_replace ($returnstring, $endstring, $wordwrapstring);

		} else {
			$wordwrapstring = wordwrap($wordwrapstring, 100, "\n$this->Space$this->Space");
		}
		return $wordwrapstring;
	}
	*/

	protected function CreateWordWrap($WordWrapString) {
		$args = func_get_args();
		if ($args[1]) {
			$WordSpacing = $args[1];
		} else {
			$WordSpacing = "\t";
		}
		if (stristr($WordWrapString, '<a href')) {
			// Strip AHef Tags for wordwrap then put them back in
			$FirstPos = strpos($WordWrapString, '<a href');
			$LastPos = strpos($WordWrapString, '</a>');
			$LastPos = $LastPos + 3;

			// Split a string into an array - character by character
			$NewWordWrapString = Array();
			$j = 0;
			$End = strlen($WordWrapString);
			while ($j <= $End) {
				array_push ($NewWordWrapString, $WordWrapString[$j]);
				$j++;
			}

			$j = $FirstPos;
			while ($j <= $LastPos) {
				$EndString .= $NewWordWrapString[$j];
				$j++;
			}

			$ReturnString = $EndString;
			$ReturnString = str_replace (' ', '<SPACE>', $ReturnString);
			$WordWrapString = str_replace ($EndString, $ReturnString, $WordWrapString);

			// End STRIP AHREF TAG FOR WORDWRAP
			$WordWrapString = wordwrap($WordWrapString, 85, "\n$WordSpacing");
			$WordWrapString = str_replace ($ReturnString, $EndString, $WordWrapString);

		} else {
			$WordWrapString = wordwrap($WordWrapString, 85, "\n$WordSpacing");
		}

		return $WordWrapString;
	}

	protected function StripTagsContent($Content) {
		if (!is_array($Content)) {
			if (!is_null($Content)) {
				$Pattern = "/(<(.*?)>(.*?)<\/(.*?)>)/";
				$StrippedContent = preg_split($Pattern, $Content);
				$StrippedContent = implode($StrippedContent);
				$StrippedContent = strip_tags($StrippedContent);

				return $StrippedContent;
			} else {
				array_push($this->ErrorMessage,'StripTagsContent: Content cannot be NULL!');
			}
		} else {
			array_push($this->ErrorMessage,'StripTagsContent: Content cannot be an array!');
		}
	}

	protected function SearchContentForTag($Tag, $Content) {
		if (!is_array($Content) && !is_array($Tag)) {
			if (!is_null($Content) && !is_null($Tag)) {
				$Pattern = "/(<$Tag(.*?)>(.*?)<\/$Tag>)/";
				preg_match_all($Pattern, $Content, $SearchContent);
				return $SearchContent;
			} else {
				array_push($this->ErrorMessage,'SearchContentForTag: Tag and Content cannot be NULL!');
			}
		} else {
			array_push($this->ErrorMessage,'SearchContentForTag: Tag and Content cannot be an array!');
		}
	}

	protected function SearchReplaceTag ($Tag, $Content) {
		if (!is_array($Content)) {
			if (!is_null($Content) && !is_null($Tag)) {
				if (is_array($Tag)) {
					reset($Tag);
					while (current($Tag)) {
						$tag = current($Tag);
						$Pattern = "/(<$tag(.*?)>)/";
						$Content = preg_replace($Pattern, '', $Content);
						$Pattern = "/(<\/$tag>)/";
						$Content = preg_replace($Pattern, '', $Content);
						next($Tag);
					}
					return $Content;
				} else {
					$Pattern = "/(<$Tag(.*?)>)/";
					$Content = preg_replace($Pattern, '', $Content);
					$Pattern = "/(<\/$Tag>)/";
					$Content = preg_replace($Pattern, '', $Content);
					return $Content;
				}
			} else {
					array_push($this->ErrorMessage,'SearchReplaceTag: Tag and Content cannot be NULL!');
			}
		} else {
			array_push($this->ErrorMessage,'SearchReplaceTag: Content cannot be an array!');
		}
	}

	protected function SearchReplaceWordSpace($Content) {
		if (!is_array($Content)) {
			if (!is_null($Content)) {
				$Pattern = "/(?<!\ )[A-Z]|[0-9]+/";
				$Content = preg_replace($Pattern, ' $0', $Content);
				$Content = trim($Content);
				return $Content;
			} else {
				array_push($this->ErrorMessage,'SearchReplaceWordSpace: Content cannot be NULL!');
			}
		} else {
			array_push($this->ErrorMessage,'SearchReplaceWordSpace: Content cannot be an array!');
		}
	}

	protected function CheckUserString() {
		if (strstr($this->HttpUserAgent, 'MSIE 6.0')) {
			if ($this->AllowScriptAccess == 'true') {
				$this->AllowScriptAccess = 'always';
			}
			return TRUE;
		}

		if (strstr($this->HttpUserAgent,'MSIE 7.0')) {
			if ($this->AllowScriptAccess == 'true') {
				$this->AllowScriptAccess = 'always';
			}
			return TRUE;
		}

		if (strstr($this->HttpUserAgent,'MSIE 8.0')) {
			if ($this->AllowScriptAccess == 'true') {
				$this->AllowScriptAccess = 'always';
			}
			return TRUE;
		}
	}

	protected function ProcessArray($array, $arrayname, $tablesname, $j, $key, $databasetable) {
		if (is_array($array)) {
			$i = 1;
			$k = 0;
			$name = $arrayname;
			$name .= $i;
			$hold = $databasetable[$tablesname][$j][$name];
			while (array_key_exists($name, $databasetable[$tablesname][$j])) {
				array_push($array[$key], $hold);

				$k++;
				$i++;
				$name = $arrayname;
				$name .= $i;
				$hold = $databasetable[$tablesname][$j][$name];
			}
			return $array;
		} else {
			return NULL;
		}
	}

	protected function OutputArrayElement($array, $tag) {
		$i = 0;
		while (array_key_exists($i, $array)) {
			if ($array[$i] != NULL) {
				$this->OutputSingleElement($array[$i], $tag);
			}
			$i++;
		}
	}

	protected function OutputSingleElement($text, $tag) {
		$this->Writer->startElement($tag);
		$this->Writer->text($text);
		$this->Writer->endElement();
	}

	protected function OutputSingleElementRaw($text, $tag) {
		$this->Writer->startElement($tag);
		$this->Writer->writeRaw($text);
		$this->Writer->writeRaw("\n   ");
		$this->Writer->endElement();
	}

	protected function ProcessArrayStandardAttribute($startingvariablename) {
		$variablehold = $startingvariablename . 'AccessKey';
		if ($this->$variablehold) {
			if (current($this->$variablehold)) {
				$this->Writer->writeAttribute('accesskey', current($this->$variablehold));
			}
		}
		$variablehold = $startingvariablename . 'Class';
		if ($this->$variablehold) {
			if (current($this->$variablehold)) {
				$this->Writer->writeAttribute('class', current($this->$variablehold));
			}
		}
		$variablehold = $startingvariablename . 'Dir';
		if ($this->$variablehold) {
			if (current($this->$variablehold)) {
				$this->Writer->writeAttribute('dir', current($this->$variablehold));
			}
		}
		$variablehold = $startingvariablename . 'ID';
		if ($this->$variablehold) {
			if (current($this->$variablehold)) {
				$this->Writer->writeAttribute('id', current($this->$variablehold));
			}
		}
		$variablehold = $startingvariablename . 'Lang';
		if ($this->$variablehold) {
			if (current($this->$variablehold)) {
				$this->Writer->writeAttribute('lang', current($this->$variablehold));
			}
		}
		$variablehold = $startingvariablename . 'Style';
		if ($this->$variablehold) {
			if (current($this->$variablehold)) {
				$this->Writer->writeAttribute('style', current($this->$variablehold));
			}
		}
		$variablehold = $startingvariablename . 'TabIndex';
		if ($this->$variablehold) {
			if (current($this->$variablehold)) {
				$this->Writer->writeAttribute('tabindex', current($this->$variablehold));
			}
		}
		$variablehold = $startingvariablename . 'Title';
		if ($this->$variablehold) {
			if (current($this->$variablehold)) {
				$this->Writer->writeAttribute('title', current($this->$variablehold));
			}
		}
		$variablehold = $startingvariablename . 'XMLLang';
		if ($this->$variablehold) {
			if (current($this->$variablehold)) {
				$this->Writer->writeAttribute('xml:lang', current($this->$variablehold));
			}
		}
	}

	protected function ProcessStandardAttribute($startingvariablename) {
		$variablehold = $startingvariablename . 'AccessKey';
		if ($this->$variablehold) {
			$this->Writer->writeAttribute('accesskey', $this->$variablehold);
		}
		$variablehold = $startingvariablename . 'Class';
		if ($this->$variablehold) {
			$this->Writer->writeAttribute('class', $this->$variablehold);
		}
		$variablehold = $startingvariablename . 'Dir';
		if ($this->$variablehold) {
			$this->Writer->writeAttribute('dir', $this->$variablehold);
		}
		$variablehold = $startingvariablename . 'ID';
		if ($this->$variablehold) {
			$this->Writer->writeAttribute('id', $this->$variablehold);
		}
		$variablehold = $startingvariablename . 'Lang';
		if ($this->$variablehold) {
			$this->Writer->writeAttribute('lang', $this->$variablehold);
		}
		$variablehold = $startingvariablename . 'Style';
		if ($this->$variablehold) {
			$this->Writer->writeAttribute('style', $this->$variablehold);
		}
		$variablehold = $startingvariablename . 'TabIndex';
		if ($this->$variablehold) {
			$this->Writer->writeAttribute('tabindex', $this->$variablehold);
		}
		$variablehold = $startingvariablename . 'Title';
		if ($this->$variablehold) {
			$this->Writer->writeAttribute('title', $this->$variablehold);
		}
		$variablehold = $startingvariablename . 'XMLLang';
		if ($this->$variablehold) {
			$this->Writer->writeAttribute('xml:lang', $this->$variablehold);
		}
	}

	public function CreateOutput($space) {
		$arguments = func_get_args();
		$NoPrintPreview = $arguments[1];

		if ($NoPrintPreview) {
			$PrintPreview = TRUE;
		} else if ($this->PrintPreview){
			$PrintPreview = $this->PrintPreview;
		} else {
			$PrintPreview = TRUE;
		}

		try {
			if (is_null($this->ContentTableName)) {
				throw new Exception('<i>CreateOutput</i>: Content Table Name is not set.  It MUST NOT be NULL!');
			}
		} catch (Exception $e) {
			print '<b>FATAL ERROR: </b>';
			print $e->getMessage();
			print "\n";
			exit();
		}

		while (current($this->{$this->ContentTableName})) {
			$i = 0;
			while ($this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]) {
				$this->PageID = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['PageID'];
				$this->ObjectID = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['ObjectID'];

				$this->ContainerObjectType = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['ContainerObjectType'];
	   			$this->ContainerObjectTypeName = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['ContainerObjectTypeName'];
				$this->ContainerObjectID = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['ContainerObjectID'];
				$this->ContainerObjectPrintPreview = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['ContainerObjectPrintPreview'];
	   			$this->Empty = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['Empty'];

				$this->StartTag = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['StartTag'];
				$this->EndTag = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['EndTag'];
				$this->StartTagID = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['StartTagID'];
				$this->StartTagStyle = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['StartTagStyle'];
				$this->StartTagClass = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['StartTagClass'];

				$this->Heading = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['Heading'];
				$this->HeadingStartTag = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['HeadingStartTag'];
				$this->HeadingEndTag = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['HeadingEndTag'];
				$this->HeadingStartTagID = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['HeadingStartTagID'];
				$this->HeadingStartTagClass = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['HeadingStartTagClass'];
				$this->HeadingStartTagStyle = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['HeadingStartTagStyle'];

				$this->Content = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['Content'];
				$this->ContentStartTag = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['ContentStartTag'];
				$this->ContentEndTag = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['ContentEndTag'];
				$this->ContentStartTagID = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['ContentStartTagID'];
				$this->ContentStartTagClass = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['ContentStartTagClass'];
				$this->ContentStartTagStyle = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['ContentStartTagStyle'];

				$this->ContentPTagID = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['ContentPTagID'];
				$this->ContentPTagClass = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['ContentPTagClass'];
				$this->ContentPTagStyle = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['ContentPTagStyle'];

				$this->EnableDisable = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['Enable/Disable'];
				$this->Status = $this->{$this->ContentTableName}[key($this->{$this->ContentTableName})][$i]['Status'];

				$this->buildObjectType();
				$i++;

			}
			next($this->{$this->ContentTableName});
			if (current($this->{$this->ContentTableName})) {
				$this->Writer->writeRaw("\n");
			}

		}
		if ($this->FileName) {
			$this->Writer->flush();
		}
	}

	protected function buildObjectType() {
		if ($this->ContainerObjectType && $this->EnableDisable == 'Enable' && $this->Status == 'Approved') {
			$temp = $this->ObjectID;
			$temp++;
			if ($this->ContainerObjectType) {
				try {
					if (is_null($this->ContentObjectName)) {
						throw new Exception('<i>buildObjectType</i>: Content Object Name is not set.  It MUST NOT be NULL!');
					}
				} catch (Exception $e) {
					print '<b>FATAL ERROR: </b>';
					print $e->getMessage();
					print "\n";
					exit();
				}

				$containertype = $this->ContainerObjectType;

				if ($containertype == $this->ContentObjectName) {
					if ($this->ContainerObjectID) {
						if ($this->ContainerObjectPrintPreview == 'true' | ($this->ContainerObjectPrintPreview == 'false' && !$this->PrintPreview)) {
							$this->buildOutput($this->Space);
						}
					}
				} else if ($containertype == 'XhtmlMenu') {
					if (($this->PrintPreview & $this->ContainerObjectPrintPreview) | !$this->PrintPreview) {
						$filename = 'Configuration/Tier6-ContentLayer/' . $this->ContainerObjectTypeName .'.php';
						require($filename);
						$hold = bottompanel1();
						$this->Writer->writeRaw($hold);
						$this->Writer->writeRaw("\n");
					}
				} else {
					if (!is_null($this->ContainerObjectID) | $this->ContainerObjectID == 0) {
						if ($this->ContainerObjectPrintPreview == 'true' | ($this->ContainerObjectPrintPreview == 'false' && !$this->PrintPreview)) {
							$this->buildObject($this->PageID, $this->ContainerObjectID, $this->ContainerObjectType, $this->ContainerObjectTypeName, TRUE);
						}
					}
				}
			}

			if ($this->Insert) {
				reset($this->Insert);
				while (current($this->Insert)) {
					$this->Writer->startElement('p');
					$this->Writer->writeAttribute('style', 'position: relative; left: 20px;');
						$this->Writer->startElement('span');
						$this->Writer->writeAttribute('style', 'color: #FFCC00;');
						$this->Writer->text(key($this->Insert));
						$this->Writer->writeRaw(":\n\t<br /> \n\t  ");
						$this->Writer->endElement();
					$this->Writer->writeRaw(current($this->Insert));
					$this->Writer->writeRaw("\n\t");
					$this->Writer->endElement();
					next ($this->Insert);
				}
				$this->Writer->writeRaw("   ");
				$this->Writer->endElement();

			}

			$temp++;
		}
	}

	protected function buildOutput ($Space) {
		$this->Space = $Space;
		if ($this->EnableDisable == 'Enable' & $this->Status == 'Approved' & (($this->PrintPreview & $this->ContainerObjectPrintPreview == 'true') | !$this->PrintPreview)) {
			if ($this->StartTag){
				$this->StartTag = str_replace('<','', $this->StartTag);
				$this->StartTag = str_replace('>','', $this->StartTag);
				$this->Writer->writeRaw("\n");
				$this->Writer->startElement($this->StartTag);
					$this->ProcessStandardAttribute('StartTag');
			}

			if ($this->HeadingStartTag){
				$this->HeadingStartTag = str_replace('<','', $this->HeadingStartTag);
				$this->HeadingStartTag = str_replace('>','', $this->HeadingStartTag);
				$this->Writer->startElement($this->HeadingStartTag);
					$this->ProcessStandardAttribute('HeadingStartTag');
					$this->Writer->writeRaw($this->Heading);
			}

			if ($this->HeadingEndTag) {
				$this->Writer->endElement();
			}

			if ($this->ContentStartTag == '<p>'){
				if (strstr($this->Content, "<ul")) {
					if (!$this->HeadingStartTag) {
						$this->Writer->writeRaw("\n");
					}
					$this->ContentStartTag = str_replace('<','', $this->ContentStartTag);
					$this->ContentStartTag = str_replace('>','', $this->ContentStartTag);
	
					$this->Writer->writeRaw(" ");
					
					if (strpos($this->Content, "\n\n")) {
						$Content = explode("\n\n", $this->Content);
					} else {
						$Content = explode("\n\r", $this->Content);
					}
					if (is_array($Content)) {
						foreach ($Content as $Key => $Value) {
							if (strpos($Value, "<ul")) {
								$Value = str_replace('<ul','<ul*<ul', $Value);
								$Content[$Key] = explode("<ul*", $Value);
							}
						}
						
						$this->Content = array();
						
						foreach ($Content as $Key => $Value) {
							if (is_array($Value)) {
								foreach ($Value as $SubKey => $SubValue) {
									$this->Content[] = $SubValue;
								}
							} else {
								$this->Content[] = $Value;
							}
						}
						
						foreach ($this->Content as $Key => $Value) {
							if (strpos($Value, "<ul") === FALSE) {
								$this->Writer->startElement($this->ContentStartTag);
								$this->ProcessStandardAttribute('ContentStartTag');
							}
							$Value = trim($Value);
							$Content = $this->CreateWordWrap($Value, "\t  ");
							$this->Writer->writeRaw("\n\t  ");
							$this->Writer->writeRaw($Content);
							$this->Writer->writeRaw("\n\t");
							
							if (strpos($Value, "<ul") === FALSE) {
								if ($this->ContentEndTag) {
									$this->Writer->writeRaw("      ");
									$this->Writer->endElement();
								}
							}
						}
					}
				} else {
					if (!$this->HeadingStartTag) {
						$this->Writer->writeRaw("\n");
					}
					$this->ContentStartTag = str_replace('<','', $this->ContentStartTag);
					$this->ContentStartTag = str_replace('>','', $this->ContentStartTag);
	
					$this->Writer->writeRaw(" ");
					if ($this->Content) {
						$this->Writer->startElement($this->ContentStartTag);
							$this->ProcessStandardAttribute('ContentStartTag');
							$this->Content = trim($this->Content);
							if (strpos($this->Content, "\n\r") | strpos($this->Content, "\n\n") ) {
								if (strpos($this->Content, "\n\n")) {
									$this->Content = explode("\n\n", $this->Content);
								} else {
									$this->Content = explode("\n\r", $this->Content);
								}
								$i = 0;
								$count = count($this->Content);
								$count--;
								while (current($this->Content)) {
									$this->Content[key($this->Content)] = trim(current($this->Content));
									$this->Content[key($this->Content)] = $this->CreateWordWrap(current($this->Content), "\t  ");
									$this->Writer->writeRaw("\n\t  ");
									$this->Writer->writeRaw(current($this->Content));
									$this->Writer->writeRaw("\n\t");
									$this->Writer->endElement();
	
									next($this->Content);
									if (current($this->Content)) {
										$this->ContentEndTag = NULL;
										$this->Writer->writeRaw("  ");
										$this->Writer->startElement('p');
										$this->ProcessStandardAttribute('ContentPTag');
									}
									$i++;
								}
							} else {
								$this->Content = $this->CreateWordWrap($this->Content, "\t  ");
								$this->Content .= "\n  ";
								$this->Writer->writeRaw("\n\t  ");
								$this->Writer->writeRaw($this->Content);
							}
	
							if ($this->ContentEndTag) {
								$this->Writer->writeRaw("      ");
								$this->Writer->endElement();
							}
					}
				}
				
			} else if ($this->ContentStartTag){
				$this->ContentStartTag = str_replace('<','', $this->ContentStartTag);
				$this->ContentStartTag = str_replace('>','', $this->ContentStartTag);
				if ($this->Content) {
					$this->Writer->startElement($this->ContentStartTag);
						$this->ProcessStandardAttribute('ContentStartTag');

						$this->Content = trim($this->Content);
						if (strpos($this->Content, "\n\r")) {
							$this->Content = explode("\n\r", $this->Content);
							while (current($this->Content)) {
								$this->Writer->startElement('p');
									$this->ProcessStandardAttribute('ContentPTag');
									$this->Writer->writeRaw("\n    ");
									$this->Writer->writeRaw(current($this->Content));
									$this->Writer->writeRaw("\n  ");
								$this->Writer->endElement();
								next($this->Content);
							}
						} else if (strpos($this->Content, "\n\n")) {
							$this->Content = explode("\n\n", $this->Content);
							while (current($this->Content)) {
								$this->Writer->startElement('p');
									$this->ProcessStandardAttribute('ContentPTag');
									$this->Writer->writeRaw("\n    ");
									$this->Writer->writeRaw(current($this->Content));
									$this->Writer->writeRaw("\n  ");
								$this->Writer->endElement();
								next($this->Content);
							}
						} else {
							$this->Writer->startElement('p');
							$this->ProcessStandardAttribute('ContentPTag');
							$this->Writer->writeRaw("\n    ");
							$this->Writer->writeRaw($this->Content);
							$this->Writer->writeRaw("\n  ");
							$this->Writer->endElement();
						}

						if ($this->ContentEndTag) {
							$this->Writer->writeRaw("      ");
							$this->Writer->endElement();
						}
				}
			} else {
				if ($this->Content != NULL) {
					$Content = '<CONTENT>' . $this->Content . '</CONTENT>';

					libxml_use_internal_errors(true);
					$Html = simplexml_load_string($Content);
					foreach ($Html as $Child) {
						$hold = $Child->asXML();
						$hold = trim($hold);
						$Element = $Child->getName();

						if ($Child->children()) {
							$Output = $Child->asXML();
							$this->Writer->writeRaw($Output);
						} else {
							$this->Writer->startElement($Element);
							foreach ($Child->attributes() as $Name => $Attribute) {
								$this->Writer->writeAttribute($Name, $Attribute);
							}
							(string)$Text = (string)$Child[0];
							if ($Text != NULL) {
								if ($Element == 'script') {
									$this->Writer->writeRaw($Text);
								} else {
									$this->Writer->text($Text);
									$ChildrenOutput = $Child->children()->asXML();
								}
							}
							$this->Writer->endElement();
						}

					}
				}
			}
		}
	}

	protected function buildObject($PageID, $ObjectID, $ContainerObjectType, $ContainerObjectTypeName, $print) {
		$modulesidnumber = Array();
		$modulesidnumber['PageID'] = $PageID;

		if ($this->CurrentVersion) {
			$modulesidnumber['CurrentVersion'] = $this->CurrentVersion;

		} else {
			if (isset($this->VersionRowMethodName)) {
				$temp = $this->{$this->VersionRowMethodName}($modulesidnumber);
				$temp = array_reverse($temp);
				$modulesidnumber['RevisionID'] = $temp[0]['RevisionID'];
			}
		}

		$modulesidnumber['ObjectID'] = $ObjectID;
		$modulesidnumber['PrintPreview'] = $this->PrintPreview;

		$ContentLayerTableArray = Array();
		$ContentLayerTableArray['ObjectType'] = $ContainerObjectType;
		$ContentLayerTableArray['ObjectTypeName'] = $ContainerObjectTypeName;

		$this->LayerModule->setDatabaseAll ($this->Hostname, $this->User, $this->Password, $this->DatabaseName);
		$this->LayerModule->setDatabaseTable ($this->ContentLayerTablesName);
		$this->LayerModule->Connect($this->ContentLayerTablesName);

		$this->LayerModule->pass ($this->ContentLayerTablesName, 'setDatabaseRow', array('idnumber' => $ContentLayerTableArray));
		$this->LayerModule->Disconnect($this->ContentLayerTablesName);

		$hold = 'DatabaseTable';
		$i = 1;
		$databasetablename = Array();
		$hold .= $i;

		while ($this->LayerModule->pass ($this->ContentLayerTablesName, 'getRowField', array('rowfield' => $hold))) {
			array_push($databasetablename, $this->LayerModule->pass ($this->ContentLayerTablesName, 'getRowField', array('rowfield' => $hold)));
			$i++;
			$hold = 'DatabaseTable';
			$hold .= $i;
		}

		$modulesdatabase = Array();
		while (current($databasetablename)) {
			$modulesdatabase[current($databasetablename)] = current($databasetablename);
			next($databasetablename);
		}
		$temp = &$GLOBALS['Tier6Databases'];
		$module = &$temp->getModules($ContainerObjectType, $ContainerObjectTypeName);
		reset($databasetablename);

		$module->setDatabaseAll ($this->Hostname, $this->User, $this->Password, $this->DatabaseName, current($databasetablename));
		$module->setHttpUserAgent($this->HttpUserAgent);
		$module->FetchDatabase($modulesidnumber);
		$module->CreateOutput('    ');

		if ($print == TRUE) {
			if ($module->getOutput()) {
				$this->Writer->writeRaw("\t");
				$this->Writer->writeRaw($module->getOutput());
				$this->Writer->writeRaw("\n");
			}
		} else {
			return $module;
		}
	}

}
?>
