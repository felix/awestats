<?php

/**
 * Copyright (c) 2009 Jon Combe (jawstats.com)
 * Copyright (c) 2013 Thomas Pierson <thomas@mezcalito.fr>
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

header('Content-Type: text/html; charset="utf-8"', true);

// javascript caching
$gc_sJavascriptVersion = "200901251254";
$g_aCurrentTranslation = array();

ValidateConfig();

// select configuraton and translations
$g_sConfig = GetConfig();
$g_aConfig = $aConfig[$g_sConfig];
$sLanguageCode = SetTranslation();

// get date range and valid log file
$g_dtStatsMonth = ValidateDate($year, $month);
$g_aLogFiles = GetLogList($g_sConfig, $g_aConfig["statspath"], $g_aConfig["statsname"]);
$g_iThisLog = -1;
for ($iIndex = 0; $iIndex < count($g_aLogFiles); $iIndex++) {
  if (($g_dtStatsMonth == $g_aLogFiles[$iIndex][0]) && ($g_aLogFiles[$iIndex][1] == true)) {
    $g_iThisLog = $iIndex;
    break;
  }
}
if ($g_iThisLog < 0) {
  if (count($g_aLogFiles) > 0) {
    $g_iThisLog = 0;
  } else {
    Error("NoLogsFound");
  }
}

// validate current view
if (ValidateView($view) == true) {
  $sCurrentView = $view;
} else {
  $sCurrentView = CONFIG_DEFAULT_VIEW;
}

// create class
$clsAWStats = new clsAWStats($g_sConfig,
  $g_aConfig["statspath"],
  $g_aConfig["statsname"],
  date("Y", $g_aLogFiles[$g_iThisLog][0]),
  date("n", $g_aLogFiles[$g_iThisLog][0]));
if ($clsAWStats->bLoaded != true) {
  Error("CannotOpenLog");
}

// days in month
if (($clsAWStats->iYear == date("Y")) && ($clsAWStats->iMonth == date("n"))) {
  $iDaysInMonth = abs(date("s", $clsAWStats->dtLastUpdate));
  $iDaysInMonth += (abs(date("i", $clsAWStats->dtLastUpdate)) * 60);
  $iDaysInMonth += (abs(date("H", $clsAWStats->dtLastUpdate)) * 60 * 60);
  $iDaysInMonth = abs(date("j", $clsAWStats->dtLastUpdate) - 1) + ($iDaysInMonth / (60 * 60 * 24));
} else {
  $iDaysInMonth = date("d", mktime (0, 0, 0, date("n", $clsAWStats->dtLastUpdate), 0, date("Y", $clsAWStats->dtLastUpdate)));
}

// start of the month
$dtStartOfMonth = mktime(0, 0, 0, $clsAWStats->iMonth, 1, $clsAWStats->iYear);
$iDailyVisitAvg = ($clsAWStats->iTotalVisits / $iDaysInMonth);
$iDailyUniqueAvg = ($clsAWStats->iTotalUnique / $iDaysInMonth);

?>


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta name="author" content="Mezcalito">
        <meta name="Description" content="Awestats">
        <meta name="robots" content="no-cache">

        <title><?php echo CONFIG_DEFAULT_TITLE; ?> - <?php echo str_replace("[SITE]", GetSiteName(), str_replace("[MONTH]", Lang(date("F", $g_aLogFiles[$g_iThisLog][0])), str_replace("[YEAR]", date("Y", $g_aLogFiles[$g_iThisLog][0]), Lang("Statistics for [SITE] in [MONTH] [YEAR]")))) ?></title>
        <link href="/assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="/assets/style.css" type="text/css" />
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="/assets/js/jquery.tablesorter.js"></script>
        <script src="/assets/js/jquery.tablesorter.extensions.js"></script>
        <script src="/assets/js/raphael-min.js"></script>
        <script src="/assets/js/g.raphael-min.js"></script>
        <script src="/assets/js/g.bar-min.js"></script>
        <script src="/assets/js/g.line-min.js"></script>
        <script src="/assets/js/g.pie-min.js"></script>
        <script src="/assets/js/g.dot-min.js"></script>
        <script src="/assets/js/constants.js?<?php echo $gc_sJavascriptVersion ?>"></script>
        <script src="/assets/js/jawstats.js?<?php echo $gc_sJavascriptVersion ?>"></script>
        
        <script>
        var g_sConfig = "<?php echo $g_sConfig ?>";
        var g_iYear = <?php echo date("Y", $g_aLogFiles[$g_iThisLog][0]) ?>;
        var g_iMonth = <?php echo date("n", $g_aLogFiles[$g_iThisLog][0]) ?>;
        var g_sCurrentView = "<?php echo $sCurrentView ?>";
        var g_dtLastUpdate = <?php echo $clsAWStats->dtLastUpdate ?>;
        var g_iFadeSpeed = <?php echo $g_aConfig["fadespeed"] ?>;
        var g_bUseStaticXML = <?php echo BooleanToText($g_aConfig["staticxml"]) ?>;
        var g_sLanguage = "<?php echo $sLanguageCode ?>";
        var sThemeDir = "<?php echo $g_aConfig["theme"] ?>";
        </script>
          
        <?php
        if ($sLanguageCode != "en-gb") {
          echo "  <script type=\"text/javascript\" src=\"languages/" . $sLanguageCode . ".js\"></script>\n";
        }
        ?>
          
          <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    </head>

    <body>
        <div id="page-container" class="container">

            <div id="header" class="navbar navbar-fixed-top navbar-inverse">
                <div class="navbar-inner">
                    <div class="container">
                        <a class="brand" href="/index.php"><?php echo CONFIG_DEFAULT_TITLE; ?></a>
                        <ul class="nav pull-right">
                            <?php if ((CONFIG_CHANGE_SITE == true) && (count($GLOBALS["aConfig"]) >= 2)) {?>
                                <li class="dropdown">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Sites <b class="caret"></b></a>

                                    <ul class="dropdown-menu">
                                      <?php echo ToolChangeSite();?>
                                    </ul>
                                </li>
                            <?}?>
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">Année - <?php echo date("Y", $g_aLogFiles[$g_iThisLog][0]) ?> <b class="caret"></b></a>

                                <ul class="dropdown-menu">
                                  <?php echo ToolChangeYear();?>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">Mois - <?php echo date("m", $g_aLogFiles[$g_iThisLog][0]) ?> <b class="caret"></b></a>

                                <ul class="dropdown-menu">
                                  <?php echo ToolChangeMonth();?>
                                </ul>
                            </li>
                            <li>
                                <a href="/index.php?action=logout">
                                    <i class="icon-off icon-white"></i>
                                </a>
                            </li>
                        </ul>


                    </div>
                </div>
            </div>
            <div id="page" class="row">

                <div class="span12">

                <?php

    //            echo ToolUpdateSite();
    //            echo ToolChangeLanguage();

                ?>
                    <?php echo DrawHeader($g_aLogFiles[$g_iThisLog][0]) ?>
                </div>
            </div>
      <div id="summary" class="row">
          <div class="span12">
              <p class="lead">
                  <?php
                    $sTemp = Lang("Last updated [DAYNAME], [DATE] [MONTH] [YEAR] at [TIME] [ELAPSEDTIME]. A total of [TOTALVISITORS] visitors ([UNIQUEVISITORS] unique) this month, an average of [DAILYAVERAGE] per day ([DAILYUNIQUE] unique).");
                    $sTemp = str_replace("[DAYNAME]", "<strong>" . Lang(date("l", $clsAWStats->dtLastUpdate)), $sTemp);
                    $sTemp = str_replace("[YEAR]", date("Y", $clsAWStats->dtLastUpdate) . "</strong>", $sTemp);
                    $sTemp = str_replace("[DATE]", Lang(date("j", $clsAWStats->dtLastUpdate)), $sTemp);
                    $sTemp = str_replace("[MONTH]", Lang(date("F", $clsAWStats->dtLastUpdate)), $sTemp);
                    $sTemp = str_replace("[TIME]", "<strong>" . date("H:i", $clsAWStats->dtLastUpdate) . "</strong>", $sTemp);
                    $sTemp = str_replace("[ELAPSEDTIME]", ElapsedTime(time() - $clsAWStats->dtLastUpdate), $sTemp);
                    $sTemp = str_replace("[TOTALVISITORS]", "<strong>" . number_format($clsAWStats->iTotalVisits) . "</strong>", $sTemp);
                    $sTemp = str_replace("[UNIQUEVISITORS]", number_format($clsAWStats->iTotalUnique), $sTemp);
                    $sTemp = str_replace("[DAILYAVERAGE]", "<strong>" . number_format($iDailyVisitAvg, 1) . "</strong>", $sTemp);
                    $sTemp = str_replace("[DAILYUNIQUE]", number_format($iDailyUniqueAvg, 1), $sTemp);
                    echo $sTemp;
                    ?>
              </p>
        </div>
      </div>
      <div id="menu" class="row">
          <div class="span12">
            <ul class="nav nav-pills">
              <li id="tabthismonth"><a href="#" onclick="ChangeTab(this, 'thismonth.all')"><?php echo Lang("This Month"); ?></a></li>
              <li id="taballmonths"><a href="#"  onclick="ChangeTab(this, 'allmonths.all')"><?php echo Lang("All Months"); ?></a></li>
              <li id="tabtime"><a href="#"  onclick="ChangeTab(this, 'time')"><?php echo Lang("Hours"); ?></a></li>
              <li id="tabbrowser"><a href="#"  onclick="ChangeTab(this, 'browser.family')"><?php echo Lang("Browsers"); ?></a></li>
              <li id="tabcountry"><a href="#"  onclick="ChangeTab(this, 'country.all')"><?php echo Lang("Countries"); ?></a></li>
              <li id="tabfiletypes"><a href="#"  onclick="ChangeTab(this, 'filetypes')"><?php echo Lang("Filetypes"); ?></a></li>
              <li id="tabos"><a href="#"  onclick="ChangeTab(this, 'os.family')"><?php echo Lang("Operating Systems"); ?></a></li>
              <li id="tabpages"><a href="#"  onclick="ChangeTab(this, 'pages.topPages')"><?php echo Lang("Pages"); ?></a></li>
              <li id="tabpagerefs"><a href="#"  onclick="ChangeTab(this, 'pagerefs.se')"><?php echo Lang("Referrers"); ?></a></li>
              <li id="tabrobots"><a href="#"  onclick="ChangeTab(this, 'robots')"><?php echo Lang("Spiders"); ?></a></li>
              <li id="tabsearches"><a href="#"  onclick="ChangeTab(this, 'searches.keywords')"><?php echo Lang("Searches"); ?></a></li>
              <li id="tabsession"><a href="#"  onclick="ChangeTab(this, 'session')"><?php echo Lang("Sessions"); ?></a></li>
              <li id="tabstatus"><a href="#"  onclick="ChangeTab(this, 'status')"><?php echo Lang("Status"); ?></a></li>
            </ul>
        </div>
      </div>
      
        <div class="row">
          <div id="content" class="span_12">
            &nbsp;
          </div>
        </div>
            
    </div>
    <div id="footer" class="footer">
            <?php echo DrawFooter(); ?>
            <span id="version">&nbsp;</span>
    </div>
</body>

</html>

<?php

// output booleans for javascript
function BooleanToText($bValue) {
  if ($bValue == true) {
    return "true";
  } else {
    return "false";
  }
}

// error display
function Error($sReason, $sExtra="") {
  // echo "ERROR!<br />" . $sReason;
  switch ($sReason) {
  case "BadConfig":
    $sProblem     = str_replace("[FILENAME]", "\"config.php\"", Lang("There is an error in [FILENAME]"));
    $sResolution  = "<p>" . str_replace("[VARIABLE]", ("<i>" . $sExtra . "</i>"), Lang("The variable [VARIABLE] is missing or invalid.")) . "</p>";
    break;
  case "BadConfigNoSites":
    $sProblem     = str_replace("[FILENAME]", "\"config.php\"", Lang("There is an error in [FILENAME]"));
    $sResolution  = "<p>" . Lang("No individual AWStats configurations have been defined.") . "</p>";
    break;
  case "CannotLoadClass":
    $sProblem     = str_replace("[FILENAME]", "\"clsAWStats.php\"", Lang("Cannot find required file [FILENAME]"));
    $sResolution  = "<p>" . Lang("At least one file required by JAWStats has been deleted, renamed or corrupted.") . "</p>";
    break;
  case "CannotLoadConfig":
    $sProblem     = str_replace("[FILENAME]", "\"config.php\"", Lang("Cannot find required file [FILENAME]"));
    $sResolution = "<p>" . str_replace("[CONFIGDIST]", "<i>config.dist.php</i>", str_replace("[CONFIG]", "<i>config.php</i>", Lang("JAWStats cannot find it's configuration file, [CONFIG]. Did you successfully copy and rename the [CONFIGDIST] file?"))) . "</p>";
    break;
  case "CannotLoadLanguage":
    $sProblem     = str_replace("[FILENAME]", "\"languages/translations.php\"", Lang("Cannot find required file [FILENAME]"));
    $sResolution  = "<p>" . Lang("At least one file required by JAWStats has been deleted, renamed or corrupted.") . "</p>";
    break;
  case "CannotOpenLog":
    $sStatsPath = $GLOBALS["aConfig"][$GLOBALS["g_sConfig"]]["statspath"];
    $sProblem     = Lang("JAWStats could not open an AWStats log file");
    $sResolution  = "<p>" . Lang("Is the specified AWStats log file directory correct? Does it have a trailing slash?") . "<br />" .
      str_replace("[VARIABLE]", "<strong>\"statspath\"</strong>", str_replace("[CONFIG]", "<i>config.php</i>", Lang("The problem may be the variable [VARIABLE] in your [CONFIG] file."))) . "</p>" .
      "<p>" . str_replace("[FOLDER]", "<strong>" . $sStatsPath . "</strong>\n", str_replace("[FILE]", "<strong>awstats" . date("Yn") . "." . $GLOBALS["g_sConfig"] . ".txt</strong>", Lang("The data file being looked for is [FILE] in folder [FOLDER]")));
    if (substr($sStatsPath, -1) != "/") {
      $sResolution  .= "<br />" . str_replace("[FOLDER]", "<strong>" . $sStatsPath . "</strong>", Lang("Try changing the folder to [FOLDER]"));
    }
    $sResolution  .= "</p>";
    break;
  case "NoLogsFound":
    $sStatsPath = $GLOBALS["aConfig"][$GLOBALS["g_sConfig"]]["statspath"];
    $sProblem     = Lang("No AWStats Log Files Found");
    $sResolution  = "<p>JAWStats cannot find any AWStats log files in the specified directory: <strong>" . $sStatsPath . "</strong><br />" .
      "Is this the correct folder? Is your config name, <i>" . $GLOBALS["g_sConfig"] . "</i>, correct?</p>\n";
    break;
  case "Unknown":
    $sProblem     = "";
    $sResolution  = "<p>" . $sExtra . "</p>\n";
    break;
  }
  echo "<html>\n" .
    "<head>\n" .
    "<title>JAWStats</title>\n" .
    "<style type=\"text/css\">\n" .
    "html, body { background: #33332d; border: 0; color: #eee; font-family: arial, helvetica, sans-serif; font-size: 15px; margin: 20px; padding: 0; }\n" .
    "a { color: #9fb4cc; text-decoration: none; }\n" .
    "a:hover { color: #fff; text-decoration: underline; }\n" .
    "h1 { border-bottom: 1px solid #cccc9f; color: #eee; font-size: 22px; font-weight: normal; } \n" .
    "h1 span { color: #cccc9f !important; font-size: 16px; } \n" .
    "p { margin: 20px 30px; }\n" .
    "</style>\n" .
    "</head>\n<body>\n" .
    "<h1><span>" . Lang("An error has occured") . ":</span><br />" . $sProblem . "</h1>\n" . $sResolution .
    "<p>" . str_replace("[LINKSTART]", "<a href=\"http://www.jawstats.com/documentation\" target=\"_blank\">", str_replace("[LINKEND]", "</a>", Lang("Please refer to the [LINKSTART]installation instructions[LINKEND] for more information."))) . "</p>\n" .
    "</body>\n</html>";
  exit;
}

// error handler
function ErrorHandler ($errno, $errstr, $errfile, $errline, $errcontext) {
  if (strpos($errfile, "index.php") != false) {
    switch ($errline) {
    case 39:
      Error("CannotLoadClass");
      break;
    case 40:
      Error("CannotLoadLanguage");
      break;
    case 41:
      Error("CannotLoadConfig");
      break;
    default:
      //Error("Unknown", ("Line #" . $errline . "<br />" . $errstr));
    }
  }
}

// translator
function Lang($sString) {
  if (isset($GLOBALS["g_aCurrentTranslation"][$sString]) == true) {
    return $GLOBALS["g_aCurrentTranslation"][$sString];
  } else {
    return $sString;
  }
}

?>
