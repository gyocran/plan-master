<?php
session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg7.php" ?>
<?php include "ewmysql7.php" ?>
<?php include "phpfn7.php" ?>
<?php include "academic_yearinfo.php" ?>
<?php include "usersinfo.php" ?>
<?php include "userfn7.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Create page object
$academic_year_list = new cacademic_year_list();
$Page =& $academic_year_list;

// Page init
$academic_year_list->Page_Init();

// Page main
$academic_year_list->Page_Main();
?>
<?php include "header.php" ?>
<?php if ($academic_year->Export == "") { ?>
<script type="text/javascript">
<!--

// Create page object
var academic_year_list = new ew_Page("academic_year_list");

// page properties
academic_year_list.PageID = "list"; // page ID
academic_year_list.FormID = "facademic_yearlist"; // form ID
var EW_PAGE_ID = academic_year_list.PageID; // for backward compatibility

// extend page with Form_CustomValidate function
academic_year_list.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EW_CLIENT_VALIDATE) { ?>
academic_year_list.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
academic_year_list.ValidateRequired = false; // no JavaScript validation
<?php } ?>

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<?php if ($academic_year->Export == "") { ?>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$academic_year_list->lTotalRecs = $academic_year->SelectRecordCount();
	} else {
		if ($rs = $academic_year_list->LoadRecordset())
			$academic_year_list->lTotalRecs = $rs->RecordCount();
	}
	$academic_year_list->lStartRec = 1;
	if ($academic_year_list->lDisplayRecs <= 0 || ($academic_year->Export <> "" && $academic_year->ExportAll)) // Display all records
		$academic_year_list->lDisplayRecs = $academic_year_list->lTotalRecs;
	if (!($academic_year->Export <> "" && $academic_year->ExportAll))
		$academic_year_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$rs = $academic_year_list->LoadRecordset($academic_year_list->lStartRec-1, $academic_year_list->lDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $academic_year->TableCaption() ?>
<?php if ($academic_year->Export == "" && $academic_year->CurrentAction == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $academic_year_list->ExportPrintUrl ?>"><img src="images/print.gif" alt="<?php echo ew_HtmlEncode($Language->Phrase("PrinterFriendly")) ?>" title="<?php echo ew_HtmlEncode($Language->Phrase("PrinterFriendly")) ?>" width="16" height="16" border="0"></a>
&nbsp;&nbsp;<a href="<?php echo $academic_year_list->ExportExcelUrl ?>"><img src='images/exportxls.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("ExportToExcel")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("ExportToExcel")) ?>' width='16' height='16' border='0'></a>
&nbsp;&nbsp;<a href="<?php echo $academic_year_list->ExportCsvUrl ?>"><img src='images/exportcsv.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("ExportToCsv")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("ExportToCsv")) ?>' width='16' height='16' border='0'></a>
<?php } ?>
</span></p>
<?php if ($Security->CanSearch()) { ?>
<?php if ($academic_year->Export == "" && $academic_year->CurrentAction == "") { ?>
<a href="javascript:ew_ToggleSearchPanel(academic_year_list);" style="text-decoration: none;"><img id="academic_year_list_SearchImage" src="images/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="academic_year_list_SearchPanel">
<form name="facademic_yearlistsrch" id="facademic_yearlistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<input type="hidden" id="t" name="t" value="academic_year">
<table class="ewBasicSearch">
	<tr>
		<td><span class="phpmaker">
			<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($academic_year->getSessionBasicSearchKeyword()) ?>">
			<input type="Submit" name="Submit" id="Submit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
			<a href="<?php echo $academic_year_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
		</span></td>
	</tr>
	<tr>
	<td><span class="phpmaker"><label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value=""<?php if ($academic_year->getSessionBasicSearchType() == "") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($academic_year->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($academic_year->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label></span></td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
<?php
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
$academic_year_list->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<form name="facademic_yearlist" id="facademic_yearlist" class="ewForm" action="" method="post">
<div id="gmp_academic_year" class="ewGridMiddlePanel">
<?php if ($academic_year_list->lTotalRecs > 0) { ?>
<table cellspacing="0" rowhighlightclass="ewTableHighlightRow" rowselectclass="ewTableSelectRow" roweditclass="ewTableEditRow" class="ewTable ewTableSeparate">
<?php echo $academic_year->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$academic_year_list->RenderListOptions();

// Render list options (header, left)
$academic_year_list->ListOptions->Render("header", "left");
?>
<?php if ($academic_year->app_year->Visible) { // app_year ?>
	<?php if ($academic_year->SortUrl($academic_year->app_year) == "") { ?>
		<td><?php echo $academic_year->app_year->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $academic_year->SortUrl($academic_year->app_year) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $academic_year->app_year->FldCaption() ?></td><td style="width: 10px;"><?php if ($academic_year->app_year->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($academic_year->app_year->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($academic_year->active->Visible) { // active ?>
	<?php if ($academic_year->SortUrl($academic_year->active) == "") { ?>
		<td><?php echo $academic_year->active->FldCaption() ?></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $academic_year->SortUrl($academic_year->active) ?>',1);">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $academic_year->active->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($academic_year->active->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($academic_year->active->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$academic_year_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<?php
if ($academic_year->ExportAll && $academic_year->Export <> "") {
	$academic_year_list->lStopRec = $academic_year_list->lTotalRecs;
} else {
	$academic_year_list->lStopRec = $academic_year_list->lStartRec + $academic_year_list->lDisplayRecs - 1; // Set the last record to display
}
$academic_year_list->lRecCount = $academic_year_list->lStartRec - 1;
if ($rs && !$rs->EOF) {
	$rs->MoveFirst();
	if (!$bSelectLimit && $academic_year_list->lStartRec > 1)
		$rs->Move($academic_year_list->lStartRec - 1);
}

// Initialize aggregate
$academic_year->RowType = EW_ROWTYPE_AGGREGATEINIT;
$academic_year_list->RenderRow();
$academic_year_list->lRowCnt = 0;
while (($academic_year->CurrentAction == "gridadd" || !$rs->EOF) &&
	$academic_year_list->lRecCount < $academic_year_list->lStopRec) {
	$academic_year_list->lRecCount++;
	if (intval($academic_year_list->lRecCount) >= intval($academic_year_list->lStartRec)) {
		$academic_year_list->lRowCnt++;

	// Init row class and style
	$academic_year->CssClass = "";
	$academic_year->CssStyle = "";
	$academic_year->RowAttrs = array('onmouseover'=>'ew_MouseOver(event, this);', 'onmouseout'=>'ew_MouseOut(event, this);', 'onclick'=>'ew_Click(event, this);');
	if ($academic_year->CurrentAction == "gridadd") {
		$academic_year_list->LoadDefaultValues(); // Load default values
	} else {
		$academic_year_list->LoadRowValues($rs); // Load row values
	}
	$academic_year->RowType = EW_ROWTYPE_VIEW; // Render view

	// Render row
	$academic_year_list->RenderRow();

	// Render list options
	$academic_year_list->RenderListOptions();
?>
	<tr<?php echo $academic_year->RowAttributes() ?>>
<?php

// Render list options (body, left)
$academic_year_list->ListOptions->Render("body", "left");
?>
	<?php if ($academic_year->app_year->Visible) { // app_year ?>
		<td<?php echo $academic_year->app_year->CellAttributes() ?>>
<div<?php echo $academic_year->app_year->ViewAttributes() ?>><?php echo $academic_year->app_year->ListViewValue() ?></div>
</td>
	<?php } ?>
	<?php if ($academic_year->active->Visible) { // active ?>
		<td<?php echo $academic_year->active->CellAttributes() ?>>
<div<?php echo $academic_year->active->ViewAttributes() ?>><?php echo $academic_year->active->ListViewValue() ?></div>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$academic_year_list->ListOptions->Render("body", "right");
?>
	</tr>
<?php
	}
	if ($academic_year->CurrentAction <> "gridadd")
		$rs->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($rs)
	$rs->Close();
?>
<?php if ($academic_year->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($academic_year->CurrentAction <> "gridadd" && $academic_year->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($academic_year_list->Pager)) $academic_year_list->Pager = new cPrevNextPager($academic_year_list->lStartRec, $academic_year_list->lDisplayRecs, $academic_year_list->lTotalRecs) ?>
<?php if ($academic_year_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($academic_year_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $academic_year_list->PageUrl() ?>start=<?php echo $academic_year_list->Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($academic_year_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $academic_year_list->PageUrl() ?>start=<?php echo $academic_year_list->Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $academic_year_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($academic_year_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $academic_year_list->PageUrl() ?>start=<?php echo $academic_year_list->Pager->NextButton->Start ?>"><img src="images/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($academic_year_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $academic_year_list->PageUrl() ?>start=<?php echo $academic_year_list->Pager->LastButton->Start ?>"><img src="images/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $academic_year_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $academic_year_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $academic_year_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $academic_year_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($academic_year_list->sSrchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoPermission") ?></span>
	<?php } ?>
<?php } ?>
		</td>
	</tr>
</table>
</form>
<?php } ?>
<?php //if ($academic_year_list->lTotalRecs > 0) { ?>
<span class="phpmaker">
<?php if ($Security->CanAdd()) { ?>
<a href="<?php echo $academic_year_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
</span>
<?php //} ?>
</div>
<?php } ?>
</td></tr></table>
<?php if ($academic_year->Export == "" && $academic_year->CurrentAction == "") { ?>
<?php } ?>
<?php if ($academic_year->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "footer.php" ?>
<?php
$academic_year_list->Page_Terminate();
?>
<?php

//
// Page class
//
class cacademic_year_list {

	// Page ID
	var $PageID = 'list';

	// Table name
	var $TableName = 'academic_year';

	// Page object name
	var $PageObjName = 'academic_year_list';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		global $academic_year;
		if ($academic_year->UseTokenInUrl) $PageUrl .= "t=" . $academic_year->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Append
			$_SESSION[EW_SESSION_MESSAGE] .= "<br>" . $v;
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = $v;
		}
	}

	// Show message
	function ShowMessage() {
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage);
		if ($sMessage <> "") { // Message in Session, display
			echo "<p><span class=\"ewMessage\">" . $sMessage . "</span></p>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm, $academic_year;
		if ($academic_year->UseTokenInUrl) {
			if ($objForm)
				return ($academic_year->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($academic_year->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function cacademic_year_list() {
		global $conn, $Language;

		// Language object
		$Language = new cLanguage();

		// Table object (academic_year)
		$GLOBALS["academic_year"] = new cacademic_year();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->AddUrl = $GLOBALS["academic_year"]->AddUrl();
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "academic_yeardelete.php";
		$this->MultiUpdateUrl = "academic_yearupdate.php";

		// Table object (users)
		$GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'academic_year', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new cTimer();

		// Open connection
		$conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		global $academic_year;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->TableName);
		$Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$academic_year->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$academic_year->Export = $_POST["exporttype"];
		} else {
			$academic_year->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $academic_year->Export; // Get export parameter, used in header
		$gsExportFile = $academic_year->TableVar; // Get export file, used in header
		if ($academic_year->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($academic_year->Export == "csv") {
			header('Content-Type: application/csv');
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.csv');
		}

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		$this->Page_Redirecting($url);
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	// Class variables
	var $ListOptions; // List options
	var $lDisplayRecs = 20;
	var $lStartRec;
	var $lStopRec;
	var $lTotalRecs = 0;
	var $lRecRange = 10;
	var $sSrchWhere = ""; // Search WHERE clause
	var $lRecCnt = 0; // Record count
	var $lEditRowCnt;
	var $lRowCnt;
	var $lRowIndex; // Row index
	var $lRecPerRow = 0;
	var $lColCnt = 0;
	var $sDbMasterFilter = ""; // Master filter
	var $sDbDetailFilter = ""; // Detail filter
	var $bMasterRecordExists;	
	var $sMultiSelectKey;
	var $RestoreSearch;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError, $Security, $academic_year;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Set up list options
			$this->SetupListOptions();

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$academic_year->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($academic_year->getRecordsPerPage() <> "") {
			$this->lDisplayRecs = $academic_year->getRecordsPerPage(); // Restore from Session
		} else {
			$this->lDisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build search criteria
		if ($sSrchAdvanced <> "")
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "(" . $this->sSrchWhere . ") AND (" . $sSrchAdvanced . ")" : $sSrchAdvanced;
		if ($sSrchBasic <> "")
			$this->sSrchWhere = ($this->sSrchWhere <> "") ? "(" . $this->sSrchWhere . ") AND (" . $sSrchBasic. ")" : $sSrchBasic;

		// Call Recordset_Searching event
		$academic_year->Recordset_Searching($this->sSrchWhere);

		// Save search criteria
		if ($this->sSrchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$academic_year->setSearchWhere($this->sSrchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->lStartRec = 1; // Reset start record counter
				$academic_year->setStartRecordNumber($this->lStartRec);
			}
		} else {
			$this->sSrchWhere = $academic_year->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		if ($this->sDbDetailFilter <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (" . $this->sDbDetailFilter . ")" : $this->sDbDetailFilter;
		if ($this->sSrchWhere <> "")
			$sFilter = ($sFilter <> "") ? "(" . $sFilter . ") AND (". $this->sSrchWhere . ")" : $this->sSrchWhere;

		// Set up filter in session
		$academic_year->setSessionWhere($sFilter);
		$academic_year->CurrentFilter = "";

		// Export data only
		if (in_array($academic_year->Export, array("html","word","excel","xml","csv","email"))) {
			$this->ExportData();
			if ($academic_year->Export <> "email")
				$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		global $academic_year;
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $academic_year->active, $Keyword);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $Keyword) {
		$sFldExpression = ($Fld->FldVirtualExpression <> "") ? $Fld->FldVirtualExpression : $Fld->FldExpression;
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($lFldDataType == EW_DATATYPE_NUMBER) {
			$sWrk = $sFldExpression . " = " . ew_QuotedValue($Keyword, $lFldDataType);
		} else {
			$sWrk = $sFldExpression . " LIKE " . ew_QuotedValue("%" . $Keyword . "%", $lFldDataType);
		}
		if ($Where <> "") $Where .= " OR ";
		$Where .= $sWrk;
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere() {
		global $Security, $academic_year;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = $academic_year->BasicSearchKeyword;
		$sSearchType = $academic_year->BasicSearchType;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "") {
				while (strpos($sSearch, "  ") !== FALSE)
					$sSearch = str_replace("  ", " ", $sSearch);
				$arKeyword = explode(" ", trim($sSearch));
				foreach ($arKeyword as $sKeyword) {
					if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
					$sSearchStr .= "(" . $this->BasicSearchSQL($sKeyword) . ")";
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($sSearch);
			}
		}
		if ($sSearchKeyword <> "") {
			$academic_year->setSessionBasicSearchKeyword($sSearchKeyword);
			$academic_year->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
	}

	// Clear all search parameters
	function ResetSearchParms() {
		global $academic_year;

		// Clear search WHERE clause
		$this->sSrchWhere = "";
		$academic_year->setSearchWhere($this->sSrchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		global $academic_year;
		$academic_year->setSessionBasicSearchKeyword("");
		$academic_year->setSessionBasicSearchType("");
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		global $academic_year;
		$bRestore = TRUE;
		if (@$_GET[EW_TABLE_BASIC_SEARCH] <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$academic_year->BasicSearchKeyword = $academic_year->getSessionBasicSearchKeyword();
			$academic_year->BasicSearchType = $academic_year->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {
		global $academic_year;

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$academic_year->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$academic_year->CurrentOrderType = @$_GET["ordertype"];
			$academic_year->UpdateSort($academic_year->app_year); // app_year
			$academic_year->UpdateSort($academic_year->active); // active
			$academic_year->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		global $academic_year;
		$sOrderBy = $academic_year->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($academic_year->SqlOrderBy() <> "") {
				$sOrderBy = $academic_year->SqlOrderBy();
				$academic_year->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {
		global $academic_year;

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$academic_year->setSessionOrderBy($sOrderBy);
				$academic_year->app_year->setSort("");
				$academic_year->active->setSort("");
			}

			// Reset start position
			$this->lStartRec = 1;
			$academic_year->setStartRecordNumber($this->lStartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $academic_year;

		// "view"
		$this->ListOptions->Add("view");
		$item =& $this->ListOptions->Items["view"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = FALSE;

		// "edit"
		$this->ListOptions->Add("edit");
		$item =& $this->ListOptions->Items["edit"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = FALSE;

		// "copy"
		$this->ListOptions->Add("copy");
		$item =& $this->ListOptions->Items["copy"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = FALSE;

		// "delete"
		$this->ListOptions->Add("delete");
		$item =& $this->ListOptions->Items["delete"];
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = FALSE;

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		if ($academic_year->Export <> "" ||
			$academic_year->CurrentAction == "gridadd" ||
			$academic_year->CurrentAction == "gridedit")
			$this->ListOptions->HideAllOptions();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $academic_year;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt =& $this->ListOptions->Items["view"];
		if ($Security->CanView() && $oListOpt->Visible)
			$oListOpt->Body = "<a href=\"" . $this->ViewUrl . "\">" . "<img src=\"images/view.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("ViewLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("ViewLink")) . "\" width=\"16\" height=\"16\" border=\"0\">" . "</a>";

		// "edit"
		$oListOpt =& $this->ListOptions->Items["edit"];
		if ($Security->CanEdit() && $oListOpt->Visible) {
			$oListOpt->Body = "<a href=\"" . $this->EditUrl . "\">" . "<img src=\"images/edit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" width=\"16\" height=\"16\" border=\"0\">" . "</a>";
		}

		// "copy"
		$oListOpt =& $this->ListOptions->Items["copy"];
		if ($Security->CanAdd() && $oListOpt->Visible) {
			$oListOpt->Body = "<a href=\"" . $this->CopyUrl . "\">" . "<img src=\"images/copy.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("CopyLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("CopyLink")) . "\" width=\"16\" height=\"16\" border=\"0\">" . "</a>";
		}

		// "delete"
		$oListOpt =& $this->ListOptions->Items["delete"];
		if ($Security->CanDelete() && $oListOpt->Visible)
			$oListOpt->Body = "<a" . "" . " href=\"" . $this->DeleteUrl . "\">" . "<img src=\"images/delete.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("DeleteLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("DeleteLink")) . "\" width=\"16\" height=\"16\" border=\"0\">" . "</a>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language, $academic_year;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		global $academic_year;
		if ($this->lDisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->lStartRec = $_GET[EW_TABLE_START_REC];
				$academic_year->setStartRecordNumber($this->lStartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$this->nPageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($this->nPageNo)) {
					$this->lStartRec = ($this->nPageNo-1)*$this->lDisplayRecs+1;
					if ($this->lStartRec <= 0) {
						$this->lStartRec = 1;
					} elseif ($this->lStartRec >= intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1) {
						$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1;
					}
					$academic_year->setStartRecordNumber($this->lStartRec);
				}
			}
		}
		$this->lStartRec = $academic_year->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->lStartRec) || $this->lStartRec == "") { // Avoid invalid start record counter
			$this->lStartRec = 1; // Reset start record counter
			$academic_year->setStartRecordNumber($this->lStartRec);
		} elseif (intval($this->lStartRec) > intval($this->lTotalRecs)) { // Avoid starting record > total records
			$this->lStartRec = intval(($this->lTotalRecs-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to last page first record
			$academic_year->setStartRecordNumber($this->lStartRec);
		} elseif (($this->lStartRec-1) % $this->lDisplayRecs <> 0) {
			$this->lStartRec = intval(($this->lStartRec-1)/$this->lDisplayRecs)*$this->lDisplayRecs+1; // Point to page boundary
			$academic_year->setStartRecordNumber($this->lStartRec);
		}
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		global $academic_year;
		$academic_year->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$academic_year->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn, $academic_year;

		// Call Recordset Selecting event
		$academic_year->Recordset_Selecting($academic_year->CurrentFilter);

		// Load List page SQL
		$sSql = $academic_year->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $offset, $rowcnt";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$academic_year->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $academic_year;
		$sFilter = $academic_year->KeyFilter();

		// Call Row Selecting event
		$academic_year->Row_Selecting($sFilter);

		// Load SQL based on filter
		$academic_year->CurrentFilter = $sFilter;
		$sSql = $academic_year->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$academic_year->Row_Selected($rs);
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn, $academic_year;
		$academic_year->app_year->setDbValue($rs->fields('app_year'));
		$academic_year->active->setDbValue($rs->fields('active'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language, $academic_year;

		// Initialize URLs
		$this->ViewUrl = $academic_year->ViewUrl();
		$this->EditUrl = $academic_year->EditUrl();
		$this->InlineEditUrl = $academic_year->InlineEditUrl();
		$this->CopyUrl = $academic_year->CopyUrl();
		$this->InlineCopyUrl = $academic_year->InlineCopyUrl();
		$this->DeleteUrl = $academic_year->DeleteUrl();

		// Call Row_Rendering event
		$academic_year->Row_Rendering();

		// Common render codes for all row types
		// app_year

		$academic_year->app_year->CellCssStyle = ""; $academic_year->app_year->CellCssClass = "";
		$academic_year->app_year->CellAttrs = array(); $academic_year->app_year->ViewAttrs = array(); $academic_year->app_year->EditAttrs = array();

		// active
		$academic_year->active->CellCssStyle = ""; $academic_year->active->CellCssClass = "";
		$academic_year->active->CellAttrs = array(); $academic_year->active->ViewAttrs = array(); $academic_year->active->EditAttrs = array();
		if ($academic_year->RowType == EW_ROWTYPE_VIEW) { // View row

			// app_year
			$academic_year->app_year->ViewValue = $academic_year->app_year->CurrentValue;
			$academic_year->app_year->CssStyle = "";
			$academic_year->app_year->CssClass = "";
			$academic_year->app_year->ViewCustomAttributes = "";

			// active
			if (strval($academic_year->active->CurrentValue) <> "") {
				switch ($academic_year->active->CurrentValue) {
					case "ADMISSION":
						$academic_year->active->ViewValue = "ADMISSION";
						break;
					case "GRADE_RECORDING":
						$academic_year->active->ViewValue = "GRADE_RECORDING";
						break;
					case "INACTIVE":
						$academic_year->active->ViewValue = "INACTIVE";
						break;
					default:
						$academic_year->active->ViewValue = $academic_year->active->CurrentValue;
				}
			} else {
				$academic_year->active->ViewValue = NULL;
			}
			$academic_year->active->CssStyle = "";
			$academic_year->active->CssClass = "";
			$academic_year->active->ViewCustomAttributes = "";

			// app_year
			$academic_year->app_year->HrefValue = "";
			$academic_year->app_year->TooltipValue = "";

			// active
			$academic_year->active->HrefValue = "";
			$academic_year->active->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($academic_year->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$academic_year->Row_Rendered();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email format
	function ExportData() {
		global $academic_year;
		$utf8 = FALSE;
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->lTotalRecs = $academic_year->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->lTotalRecs = $rs->RecordCount();
		}
		$this->lStartRec = 1;

		// Export all
		if ($academic_year->ExportAll) {
			$this->lDisplayRecs = $this->lTotalRecs;
			$this->lStopRec = $this->lTotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->lDisplayRecs < 0) {
				$this->lStopRec = $this->lTotalRecs;
			} else {
				$this->lStopRec = $this->lStartRec + $this->lDisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->lStartRec-1, $this->lDisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		if ($academic_year->Export == "xml") {
			$XmlDoc = new cXMLDocument(EW_XML_ENCODING);
			$XmlDoc->AddRoot();
		} else {
			$ExportDoc = new cExportDocument($academic_year, "h");
			$ExportDoc->ExportHeader();
			if ($ExportDoc->Horizontal) { // Horizontal format, write header
				$ExportDoc->BeginExportRow();
				$ExportDoc->ExportCaption($academic_year->app_year);
				$ExportDoc->ExportCaption($academic_year->active);
				$ExportDoc->EndExportRow();
			}
		}

		// Move to first record
		$this->lRecCnt = $this->lStartRec - 1;
		if (!$rs->EOF) {
			$rs->MoveFirst();
			if (!$bSelectLimit && $this->lStartRec > 1)
				$rs->Move($this->lStartRec - 1);
		}
		while (!$rs->EOF && $this->lRecCnt < $this->lStopRec) {
			$this->lRecCnt++;
			if (intval($this->lRecCnt) >= intval($this->lStartRec)) {
				$this->LoadRowValues($rs);

				// Render row
				$academic_year->CssClass = "";
				$academic_year->CssStyle = "";
				$academic_year->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->RenderRow();
				if ($academic_year->Export == "xml") {
					$XmlDoc->AddRow();
					$XmlDoc->AddField('app_year', $academic_year->app_year->ExportValue($academic_year->Export, $academic_year->ExportOriginalValue));
					$XmlDoc->AddField('active', $academic_year->active->ExportValue($academic_year->Export, $academic_year->ExportOriginalValue));
				} else {
					$ExportDoc->BeginExportRow(TRUE); // Allow CSS styles if enabled
					$ExportDoc->ExportField($academic_year->app_year);
					$ExportDoc->ExportField($academic_year->active);
					$ExportDoc->EndExportRow();
				}
			}
			$rs->MoveNext();
		}
		if ($academic_year->Export <> "xml")
			$ExportDoc->ExportFooter();

		// Close recordset
		$rs->Close();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write BOM if utf-8
		if ($utf8 && !in_array($academic_year->Export, array("email", "xml")))
			echo "\xEF\xBB\xBF";

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		if ($academic_year->Export == "xml") {
			header("Content-Type: text/xml");
			echo $XmlDoc->XML();
		} elseif ($academic_year->Export == "email") {
			$this->ExportEmail($ExportDoc->Text);
			$this->Page_Terminate($academic_year->ExportReturnUrl());
		} else {
			echo $ExportDoc->Text;
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	function Message_Showing(&$msg) {

		// Example:
		//$msg = "your new message";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example: 
		//$this->ListOptions->Add("new");
		//$this->ListOptions->Items["new"]->OnLeft = TRUE; // Link on left
		//$this->ListOptions->MoveItem("new", 0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}
}
?>
