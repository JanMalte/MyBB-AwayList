<?php

/**
 * @version     show_list.php 2012-01-06
 * @package     MyBB.Plugins
 * @subpackage  AwayList
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
if (!defined("IN_MYBB")) {
    die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

// functions for the date forms
/**
 * shows the days and select the given day
 * @param $P_name the name of the select
 * @param $P_day the selected day
 * @return the HTML of the select part of the form
 */
function show_days($P_name, $P_day = false)
{
    // if the selected day isn't given set it to the actual day
    if ($P_day == false)
        $P_day = date("d");
    // set the start HTML of the select form
    $html_select_form = "<select name=\"{$P_name}\">";
    // do this 31 times, one for every day
    for ($i = 01; $i <= 31; $i++) {
        // if the actual day is the same as the given day
        // set this day as selected
        if ($i == $P_day) {
            // convert this to a string with two numbers, e.g.: 04 instade of 4
            if ($i < 10) {
                $day = (string) "0" . $i;
            } else {
                $day = (string) $i;
            }
            // add the option the the HTML select form
            $html_select_form .= "<option selected value=\"{$day}\">{$day}";
        } else {
            // convert this to a string with two numbers, e.g.: 04 instade of 4
            if ($i < 10) {
                $day = (string) "0" . $i;
            } else {
                $day = (string) $i;
            }
            // add the option the the HTML select form
            $html_select_form .= "<option value=\"{$day}\">{$day}";
        }
    }
    // close the select form
    $html_select_form .= "</select>";
    // returns the HTML of the select form
    return $html_select_form;
}

/**
 * shows the months and select the given month
 * @param $P_name the name of the select
 * @param $P_month the selected month
 * @return the HTML of the select part of the form
 */
function show_months($P_name, $P_month = false)
{
    // if the selected month isn't given set it to the actual month
    if ($P_month == false)
        $P_month = date("m");
    // set the start HTML of the select form
    $html_select_form = "<select name=\"{$P_name}\">";
    // do this 12 times, one for every month
    for ($i = 01; $i <= 12; $i++) {
        // if the actual month is the same as the given month
        // set this month as selected
        if ($i == $P_month) {
            // convert this to a string with two numbers, e.g.: 04 instade of 4
            if ($i < 10) {
                $month = (string) "0" . $i;
            } else {
                $month = (string) $i;
            }
            // add the option the the HTML select form
            $html_select_form .= "<option selected value=\"{$month}\">{$month}";
        } else {
            // convert this to a string with two numbers, e.g.: 04 instade of 4
            if ($i < 10) {
                $month = (string) "0" . $i;
            } else {
                $month = (string) $i;
            }
            // add the option the the HTML select form
            $html_select_form .= "<option value=\"{$month}\">{$month}";
        }
    }
    // close the select form
    $html_select_form .= "</select>";
    // returns the HTML of the select form
    return $html_select_form;
}

/**
 * shows the years and select the given year
 * @param $P_name the name of the select
 * @param $P_year the selected year
 * @return the select part of the form
 */
function show_years($P_name, $P_year = false)
{
    // if the selected year isn't given set it to the actual year
    if ($P_year == false)
        $P_year = date("Y");
    // set the start HTML of the select form
    $html_select_form = "<select name=\"{$P_name}\">";
    // do this 20 times, for the next 20 years
    for ($i = date("Y"); $i <= date("Y") + 20; $i++) {
        // if the actual year is the same as the given year
        // set this year as selected
        if ($i == $P_year) {
            // convert this to a string
            $year = (string) $i;
            // add the option the the HTML select form
            $html_select_form .= "<option selected value=\"{$year}\">{$year}";
        } else {
            // convert this to a string
            $year = (string) $i;
            // add the option the the HTML select form
            $html_select_form .= "<option value=\"{$year}\">{$year}";
        }
    }
    // close the select form
    $html_select_form .= "</select>";
    // returns the HTML of the select form
    return $html_select_form;
}

// check the dates
/**
 * checks if the given date is in the future
 * OLD version, is still used, but should be replaced with the new one
 * @param $PARAM_date the date in the following format (dd.mm.yyyy)
 * @param $PARAM_former_date the date after which the date can be given in the following format (dd.mm.yyyy)
 * @return boolean if date is in the future
 */
function check_future_date_old_old($P_date_day, $P_date_month, $P_date_year, $P_former_date_day=false, $P_former_date_month=false, $P_former_date_year=false)
{
    if ($PARAM_former_date_day == false)
        $PARAM_former_date_day = date("d");
    if ($PARAM_former_date_month == false)
        $PARAM_former_date_month = date("m");
    if ($PARAM_former_date_year == false)
        $PARAM_former_date_year = date("y");
    $date = mktime(0, 0, 0, $PARAM_date_month, $PARAM_date_day, $PARAM_date_year);
    $former_date = mktime(0, 0, 0, $PARAM_former_date_month, $PARAM_former_date_day, $PARAM_former_date_year);
    if ($date >= $former_date) {
        return true;
    } else {
        return false;
    }
}

/**
 * checks if the given date is in the future
 * @param $P_first_date the date as a unixtimestamp
 * @param $P_second_date the date, after which the date can be given, as a unixtimestamp
 * @return boolean if date is in the future
 */
function check_future_date($P_first_date, $P_second_date=false)
{
    // if the second date isn't set, set it to the actual unixtimestamp
    if ($P_second_date == false)
        $P_second_date = time();
    // check if the first date is after the second
    if ($P_first_date >= $P_second_date) {
        return true;
    } else {
        return false;
    }
}

// check the user rights
/**
 * checks if the user is in one of the allowed usergroups
 * @param $P_allowed the allowed usergroups; seperated with ","(COMMA) e.g.: "4,10,2"
 * @return boolean true if user is in one of the allowed usergroups
 */
function check_user($P_allowed = false)
{
    // $mybb exist in the global content
    global $mybb;
    // set the acces right to false as standard
    $access = false;
    // explode the allowed usergroups to an array
    $allowed_usergroups = explode(',', $P_allowed);
    // get the usergroups of the user
    $additional_usergroups = $mybb->user['additionalgroups'];
    // explode the additional usergroups of the user to an array
    $usergroups = explode(',', $additional_usergroups);
    // Add the primary usergroup of the user the the usergroups
    $usergroups[] = $mybb->user['usergroup'];

    // is the user logged in
    if ($mybb->user['uid'] != '0') {
        // check if the usergroups are in an array
        if (is_array($usergroups)) {
            // do this for every usergroup
            foreach ($usergroups as $usergroup) {
                // check if the allowed usergroups are in an array
                if (is_array($allowed_usergroups)) {
                    // do this for every allowed usergroup
                    foreach ($allowed_usergroups as $allowed_usergroup) {
                        // if the usergroup is an allowed usergroup
                        if ($usergroup == $allowed_usergroup) {
                            $access = true;
                        }
                    }
                }
            }
        }
    }
    return $access;
}

// escape of mysql inserts
/**
 * Escape a string according to the MySQL escape format.
 *
 * @param string The string to be escaped.
 * @return string The escaped string.
 */
function escape_string($string)
{
    if (function_exists("mysql_real_escape_string")) {
        $string = mysql_real_escape_string($string);
    } else {
        $string = addslashes($string);
    }
    return $string;
}

/* * ********************************************************************
 *
 * main functions for this plugin
 *
 */

/**
 * shows the insert form for a new date
 * @return the html content
 */
function show_form_new_data()
{
    // get and set the global content
    global $db, $mybb, $templates;

    // get the information of the plugin
    $info = liste_info();

    // check the userrights
    if ($mybb->user['uid'] == 0)
        $errors[] = "Sie sind nicht angemeldet. Bitt melden Sie sich an bevor Sie sich in die Liste eintragen.";

    // if any error occurred
    if (isset($errors)) {
        $content = '		<center>
			<img src="' . $mybb->settings['bburl'] . '/images/liste/file_broken.png" border="0">
			<p class="active">
				Folgende Fehler sind aufgetreten:
			</p>
			<ul style="list-style-image:url(' . $mybb->settings['bburl'] . '/images/liste/messagebox_warning.png); align:center; list-style-position:outside;">';
        // add every error to the displayed list
        foreach ($errors as $error) {
            $content .= '			<li style="align:center;">' . $error . '</li>';
        }
        $content .= '			</ul><br />
			<a href="javascript:history.back()">
				<img src="' . $mybb->settings['bburl'] . '/images/liste/undo.png" border="0">
			</a>
		</center>
	<!-- end: show_list -->';
        // render the output
        eval("\$show_liste .= \"" . $templates->get("show_liste") . "\";"); // Hier wird das erstellte Template geladen
        // output the page
        output_page($show_liste);
        exit;
    }

    $content = <<<INHALT
	<form action="{$mybb->settings["bburl"]}/show_list.php" method="post">
		<input type="hidden" name="action" value="insert_new_data" />
		<table border="0" cellspacing="1" cellpadding="4" class="tborder">
			<thead>
				<tr>
					<td class="thead" colspan="2">
						<div><strong>In die Liste eintragen</strong><br /><div class="smalltext"></div></div>
					</td>
				</tr>
			</thead>
			<tbody style="" id="cat_1_e">
				<td class="tcat"><b>Ankunft:</b>*</td>
				<td class="tcat">
INHALT
    ;
    // Ankunft (Hinflug)
    $content .= show_days("ankunft_tag");
    $content .= show_months("ankunft_monat");
    $content .= show_years("ankunft_jahr");
    $content .= '
		  </td>
		</tr>
		<tr>
		  <td class="tcat"><b>Abflug:</b>*</td>
		  <td class="tcat">';
    // Abflug (Rückflug)
    $content .= show_days("abflug_tag");
    $content .= show_months("abflug_monat");
    $content .= show_years("abflug_jahr");
    $content .= <<<INHALT
		  </td>
		</tr>
		<tr>
		  <td class="tcat"><b>Airline:</b>*</td>
		  <td class="tcat"><input type="text" name="airline" size="40" maxlength="20" /></td>
		</tr>
		<tr>
		  <td class="tcat"><b>Urlaubsort:</b>*</td>
		  <td class="tcat"><input type="text" name="ort" size="40" maxlength="20" /></td>
		</tr>
		<tr>
		  <td class="tcat"><b>Hotel:</b>*</td>
		  <td class="tcat"><input type="text" name="hotel" size="40" maxlength="20" /></td>
		</tr>
		<tr>
		  <td class="trow2"><b>Telefon:</b></td>
		  <td class="trow2"><input type="text" name="telefon" size="25" maxlength="15" /></td>
		</tr>
		<tr>
		  <td class="tcat" colspan="2">* = Pflichtfelder</td>
		</tr>
		<tr>
		  <td class="trow1" colspan="2"><input type="submit" value="Daten in die Liste eintragen"></td>
		</tr>

			<tr>
                <td class="tcat" colspan="1"><span><strong>Aufenthaltsliste (Version {$info['version']}) by <i><a href="http://www.malte-gerth.de/mybb.html" target="_blank">Jan Malte Gerth</a></i></strong></span></td>
                <td class="tcat" colspan="1"></td>
            </tr>
		</tbody>
	  </table>
	</form>
INHALT
    ;
    return $content;
}

/**
 * shows the editing form for the existing date
 * @return the html content
 */
function show_form_edit_data()
{
    // get and set the global content
    global $db, $mybb, $templates;

    // get the data of the insert
    $result = $db->simple_select("liste", '*', "data_id = '" . $_GET['data_id'] . "'");
    $insertdata = $db->fetch_array($result);

    // get the information of the plugin
    $info = liste_info();

    // check the userrights
    if ($mybb->user['uid'] == 0)
        $errors[] = "Sie sind nicht angemeldet. Bitt melden Sie sich an bevor Sie Einträge ändern.";
    if ($insertdata['uid'] != $mybb->user['uid']) {
        if ((!check_user(4))) {
            $errors[] = "Sie haben nicht die nötigen Rechte diesen Eintrag zu bearbeiten";
        }
    }
    if ($_GET['data_id'] == '')
        $errors[] = "Es wurde kein Datensatz zum Bearbeiten ausgewählt.";

    // if any error occurred
    if (isset($errors)) {
        $content = '		<center>
			<img src="' . $mybb->settings['bburl'] . '/images/liste/file_broken.png" border="0">
			<p class="active">
				Folgende Fehler sind aufgetreten:
			</p>
			<ul style="list-style-image:url(' . $mybb->settings['bburl'] . '/images/liste/messagebox_warning.png); align:center; list-style-position:outside;">';
        // add every error to the displayed list
        foreach ($errors as $error) {
            $content .= '			<li style="align:center;">' . $error . '</li>';
        }
        $content .= '			</ul><br />
			<a href="javascript:history.back()">
				<img src="' . $mybb->settings['bburl'] . '/images/liste/undo.png" border="0">
			</a>
		</center>
	<!-- end: show_list -->';
        // render the output
        eval("\$show_liste .= \"" . $templates->get("show_liste") . "\";"); // Hier wird das erstellte Template geladen
        // output the page
        output_page($show_liste);
        exit;
    }
    $content = <<<INHALT
<form action="{$mybb->settings["bburl"]}/show_list.php" method="post">
	<input type="hidden" name="action" value="edit_data" />
	<input type="hidden" name="data_id" value="{$insertdata['data_id']}" />
	<table border="0" cellspacing="1" cellpadding="4" class="tborder">
		<thead>
			<tr>
				<td class="thead" colspan="2">
					<div><strong>Eintrag editieren</strong><br /><div class="smalltext"></div></div>
				</td>
			</tr>
		</thead>
		<tbody style="" id="cat_1_e">
			<tr>
			<td class="tcat"><b>Ankunft:</b>*</td>
			<td class="tcat">
INHALT
    ;
    // Ankunft (Hinflug)
    $content .= show_days("ankunft_tag", date("d", $insertdata['ankunft']));
    $content .= show_months("ankunft_monat", date("m", $insertdata['ankunft']));
    $content .= show_years("ankunft_jahr", date("Y", $insertdata['ankunft']));
    $content .= '
			</td>
			</tr>
			<tr>
			<td class="tcat"><b>Abflug:</b>*</td>
			<td class="tcat">';
    // Abflug (Rückflug)
    $content .= show_days("abflug_tag", date("d", $insertdata['abflug']));
    $content .= show_months("abflug_monat", date("m", $insertdata['abflug']));
    $content .= show_years("abflug_jahr", date("Y", $insertdata['abflug']));
    $content .= <<<INHALT
			</td>
			</tr>
			<tr>
			<td class="tcat"><b>Airline:</b>*</td>
			<td class="tcat"><input type="text" name="airline" value="{$insertdata['airline']}" size="40" maxlenght="2" /></td>
			</tr>
			<tr>
			<td class="tcat"><b>Urlaubsort:</b>*</td>
			<td class="tcat"><input type="text" name="ort" value="{$insertdata['ort']}" size="40" maxlength="20" /></td>
			</tr>
			<tr>
			<td class="tcat"><b>Hotel:</b>*</td>
			<td class="tcat"><input type="text" name="hotel" value="{$insertdata['hotel']}" size="40" maxlength="20" /></td>
			</tr>
			<tr>
			<td class="trow2"><b>Telefon:</b></td>
			<td class="trow2"><input type="text" name="telefon" value="{$insertdata['telefon']}" size="25" maxlength="15" /></td>
			</tr>
			<tr>
			<td class="tcat" colspan="2">* = Pflichtfelder</td>
			</tr>
			<tr>
			<td class="trow1" colspan="2"><input type="submit" value="Eintrag editieren"></td>
			</tr>
			<tr>
                <td class="tcat" colspan="1"><span><strong>Aufenthaltsliste (Version {$info['version']}) by <i><a href="http://www.malte-gerth.de/mybb.html" target="_blank">Jan Malte Gerth</a></i></strong></span></td>
                <td class="tcat" colspan="1"></td>
            </tr>
		</tbody>
	</table>
</form>
INHALT
    ;
    return $content;
}

/**
 * insert the new date
 * @return boolean if successful
 */
function insert_new_data()
{
    // get and set the global content
    global $db, $mybb, $theme, $templates, $headerinclude, $header, $footer;

    // get the information of the plugin
    $info = liste_info();

    // check the userrights
    if ($mybb->user['uid'] == 0)
        $errors[] = "Sie sind nicht angemeldet. Bitt melden Sie sich an bevor Sie sich in die Liste eintragen.";

    // get any other errors
    if ($_POST['airline'] == "")
        $errors[] = "Bitte geben Sie eine Airline ein.";
    if ($_POST['ort'] == "")
        $errors[] = "Bitte geben Sie einen Urlaubsort ein.";
    if ($_POST['hotel'] == "")
        $errosr[] = "Bitte geben Sie einen Hotelnamen ein.";
    if (preg_match("/^[0-9[:space:]]*$/", $_POST['telefon'], $number)) {
        unset($number);
    } else {
        $errors[] = 'Bitte geben Sie im Feld "Telefonnummer" nur Zahlen ein. Die Angabe der Telefonnummer ist freiwillig.';
    }
    // Ankunft (Hinflug)
    $ankunft = mktime(0, 0, 0, $_POST['ankunft_monat'], $_POST['ankunft_tag'], $_POST['ankunft_jahr']);
    // Abflug (Rückflug)
    $abflug = mktime(0, 0, 0, $_POST['abflug_monat'], $_POST['abflug_tag'], $_POST['abflug_jahr']);
    $check = true;
    // Plausibilitätsprüfung
    $query = $db->simple_select("liste", "*", "uid = '{$mybb->user['uid']}' AND ( ( ankunft BETWEEN '$ankunft' AND '$abflug' ) OR ( abflug  BETWEEN '$ankunft' AND '$abflug' ) OR (ankunft >= $ankunft AND abflug <= $abflug) )");
    while ($result = $db->fetch_array($query)) {
        $check = false;
    }
    if ($check == false)
        $errors[] = "Sie sind zu diesem Zeitpunkt schon unterwegs";
    // Ankunft (Hinflug)
    if (!check_future_date($ankunft))
        $errors[] = "Das Ankunftsdatum liegt nicht in der Zukunft.";
    // Abflug (Rückflug)
    if (!check_future_date($abflug))
        $errors[] = "Das Abflugsdatum liegt nicht in der Zukunft.";
    if (!check_future_date($abflug, $ankunft))
        $errors[] = "Das Abflugsdatum liegt vor dem Ankunftsdatum";

    // if any error occurred
    if (isset($errors)) {
        $content = '		<center>
			<img src="' . $mybb->settings['bburl'] . '/images/liste/file_broken.png" border="0">
			<p class="active">
				Folgende Fehler sind aufgetreten:
			</p>
			<ul style="list-style-image:url(' . $mybb->settings['bburl'] . '/images/liste/messagebox_warning.png); align:center; list-style-position:outside;">';
        // add every error to the displayed list
        foreach ($errors as $error) {
            $content .= '			<li style="align:center;">' . $error . '</li>';
        }
        $content .= '			</ul><br />
			<a href="javascript:history.back()">
				<img src="' . $mybb->settings['bburl'] . '/images/liste/undo.png" border="0">
			</a>
		</center>
	<!-- end: show_list -->';
        // render the output
        eval("\$show_liste .= \"" . $templates->get("show_liste") . "\";"); // Hier wird das erstellte Template geladen
        // output the page
        output_page($show_liste);
        exit;
    }

    // if no errors occurred we can insert the new data
    foreach ($_POST as $data => $value) {
        $$data = escape_string($value);
    }
    // Ankunft (Hinflug)
    // Abflug (Rückflug)
    $insertData = array(
        'id' => '',
        'uid' => $mybb->user['uid'],
        'username' => $mybb->user['username'],
        'ankunft' => $ankunft,
        'abflug' => $abflug,
        'airline' => $airline,
        'ort' => $ort,
        'hotel' => $hotel,
        'telefon' => $telefon,
        'data_id' => '',
        'sort_id' => ''
    );
    $db->insert_query('liste', $insertData);
    // set a message which should be displayed
    $message = '<div class="bottommenu">
					<img src="' . $mybb->settings['bburl'] . '/images/liste/button_ok.png" border="0"><strong>Daten wurden erfolgreich eingetragen</strong><br />
					<b>Hinweis:</b> Der Eintrag wird 1 Tag nach Ihrem Abflug automatisch aus der Liste entfernt.
				</div>';
    return $message;
}

/**
 * update the date
 * @return boolean if successful
 */
function edit_data()
{
    // get and set the global content
    global $db, $mybb, $theme, $templates, $headerinclude, $header, $footer;

    // get the information of the plugin
    $info = liste_info();

    // escape the posted data
    foreach ($_POST as $data => $value) {
        $$data = escape_string($value);
    }

    // check the userrights
    if ($mybb->user['uid'] == 0)
        $errors[] = "Sie sind nicht angemeldet. Bitt melden Sie sich an bevor Sie Einträge ändern.";

    $query_user = $db->simple_select("liste", "*", "data_id='{$data_id}'");
    $old_data = $db->fetch_array($query_user);

    if ($old_data['uid'] != $mybb->user['uid']) {
        if (!check_user(4)) {
            $errors[] = "Dieser Datensatz gehört nicht zu dir. Du darfst ihn nicht editieren";
        }
    }

    // get any other errors
    if ($_POST['data_id'] == "")
        $errors[] = "Es wurde kein Datensatz gewählt.";
    if ($_POST['airline'] == "")
        $errors[] = "Bitte geben Sie eine Airline ein.";
    if ($_POST['ort'] == "")
        $errors[] = "Bitte geben Sie einen Urlaubsort ein.";
    if ($_POST['hotel'] == "")
        $errosr[] = "Bitte geben Sie einen Hotelnamen ein.";
    if (preg_match("/^[0-9[:space:]]*$/", $_POST['telefon'], $number)) {
        unset($number);
    } else {
        $errors[] = 'Bitte geben Sie im Feld "Telefonnummer" nur Zahlen ein. Die Angabe der Telefonnummer ist freiwillig.';
    }
    // Plausibilitätsprüfung
    // Ankunft (Hinflug)
    $ankunft = mktime(0, 0, 0, $_POST['ankunft_monat'], $_POST['ankunft_tag'], $_POST['ankunft_jahr']);
    // Abflug (Rückflug)
    $abflug = mktime(0, 0, 0, $_POST['abflug_monat'], $_POST['abflug_tag'], $_POST['abflug_jahr']);
    // Ankunft (Hinflug)
    if ($old_data['ankunft'] != $ankunft) {
        if (!check_future_date($ankunft))
            $errors[] = "Das Ankunftsdatum liegt nicht in der Zukunft.";
    }
    // Abflug (Rückflug)
    if ($old_data['abflug'] != $abflug) {
        if (!check_future_date($abflug))
            $errors[] = "Das Abflugsdatum liegt nicht in der Zukunft.";
        if (!check_future_date($abflug, $ankunft))
            $errors[] = "Das Abflugsdatum liegt vor dem Ankunftsdatum";
    }

    // if any error occurred
    if (isset($errors)) {
        $content = '		<center>
			<img src="' . $mybb->settings['bburl'] . '/images/liste/file_broken.png" border="0">
			<p class="active">
				Folgende Fehler sind aufgetreten:
			</p>
			<ul style="list-style-image:url(' . $mybb->settings['bburl'] . '/images/liste/messagebox_warning.png); align:center; list-style-position:outside;">';
        // add every error to the displayed list
        foreach ($errors as $error) {
            $content .= '			<li style="align:center;">' . $error . '</li>';
        }
        $content .= '			</ul><br />
			<a href="javascript:history.back()">
				<img src="' . $mybb->settings['bburl'] . '/images/liste/undo.png" border="0">
			</a>
		</center>
	<!-- end: show_list -->';
        // render the output
        eval("\$show_liste .= \"" . $templates->get("show_liste") . "\";"); // Hier wird das erstellte Template geladen
        // output the page
        output_page($show_liste);
        exit;
    }
    foreach ($_POST as $data => $value) {
        $$data = escape_string($value);
    }
    // Ankunft (Hinflug)
    // Abflug (Rückflug)

    $insertData = array(
        'ankunft' => $ankunft,
        'abflug' => $abflug,
        'airline' => $airline,
        'ort' => $ort,
        'hotel' => $hotel,
        'telefon' => $telefon
    );
    $db->update_query('liste', $insertData, "data_id = '{$data_id}'");

    // set a message which should be displayed
    $message = '<div class="bottommenu"><img src="' . $mybb->settings['bburl'] . '/images/liste/button_ok.png" border="0"><strong>Daten wurden erfolgreich geändert</strong></div>';
    return $message;
}

/**
 * shows which insert should be deleted
 * @return the html message
 */
function delete_data_notification()
{
    // get and set the global content
    global $db, $mybb, $theme, $templates, $headerinclude, $header, $footer;

    // get the information of the plugin
    $info = liste_info();

    // escape the posted data
    foreach ($_GET as $data => $value) {
        $$data = escape_string($value);
    }

    // check the userrights
    if ($mybb->user['uid'] == 0)
        $errors[] = "Sie sind nicht angemeldet. Bitt melden Sie sich an bevor Sie Einträge löschen.";
    $query_data = $db->simple_select("liste", "*", "data_id='{$data_id}'");
    $insert_data = $db->fetch_array($query_data);

    if ($insert_data['uid'] != $mybb->user['uid']) {
        if (!check_user(4)) {
            $errors[] = "Dieser Datensatz gehört nicht zu Ihnen. Sie dürfen ihn nicht löschen";
        }
    }

    // get any other errors
    if ($_GET['data_id'] == "")
        $errors[] = "Es wurde kein Datensatz gewählt.";

    // if any error occurred
    if (isset($errors)) {
        $content = '		<center>
			<img src="' . $mybb->settings['bburl'] . '/images/liste/file_broken.png" border="0">
			<p class="active">
				Folgende Fehler sind aufgetreten:
			</p>
			<ul style="list-style-image:url(' . $mybb->settings['bburl'] . '/images/liste/messagebox_warning.png); align:center; list-style-position:outside;">';
        // add every error to the displayed list
        foreach ($errors as $error) {
            $content .= '			<li style="align:center;">' . $error . '</li>';
        }
        $content .= '			</ul><br />
			<a href="javascript:history.back()">
				<img src="' . $mybb->settings['bburl'] . '/images/liste/undo.png" border="0">
			</a>
		</center>
	<!-- end: show_list -->';
        // render the output
        eval("\$show_liste .= \"" . $templates->get("show_liste") . "\";"); // Hier wird das erstellte Template geladen
        // output the page
        output_page($show_liste);
        exit;
    }

    $content = <<<INHALT
<form action="{$mybb->settings["list_path"]}" method="post">
	<input type="hidden" name="action" value="delete" />
	<input type="hidden" name="data_id" value="{$insert_data['data_id']}" />
	<input type="hidden" name="uid" value="{$insert_data['uid']}" />
	<table border="0" cellspacing="1" cellpadding="4" class="tborder">
		<thead>
			<tr>
				<td class="thead" colspan="6">
					<div><strong>Soll dieser Eintrag gelöscht werden?</strong><br /><div class="smalltext"></div></div>
				</td>
			</tr>
		</thead>
		<tbody style="" id="cat_1_e">
			<tr>
				<td class="tcat" width="5%" align="center"><strong>Ankunft</strong></td>
				<td class="tcat" width="5%" align="center"><strong>Abflug</strong></td>
				<td class="tcat" width="15%" align="center"><strong>Airline</strong></td>
				<td class="tcat" width="15%" align="center"><strong>Urlaubsort</strong></td>
				<td class="tcat" width="15%" align="center"><strong>Hotel</strong></td>
				<td class="tcat" width="15%" align="center"><strong>Telefon</strong></td>
			</tr>
	<!-- start: liste -->
			<tr>
INHALT
    ;
    // Ankunft (Hinflug)
    $content .= "<td class=\"trow1\">" . date("d.m.Y", $insert_data['ankunft']) . "</td>\n";
    // Abflug (Rückflug)
    $content .= "<td class=\"trow1\">" . date("d.m.Y", $insert_data['abflug']) . "</td>\n";
    $content .= <<<INHALT
				<td class="trow1">{$insert_data['airline']}</td>
				<td class="trow1">{$insert_data['ort']}</td>
				<td class="trow1">{$insert_data['hotel']}</td>
				<td class="trow1">{$insert_data['telefon']}</td>
			</tr>
			<tr>
				<td class="trow2" colspan="6"><input type="submit" value="Löschen bestätigen"></td>
			</tr>
			<tr>
                <td class="tcat" colspan="5"><span><strong>Aufenthaltsliste (Version {$info['version']}) by <i><a href="http://www.malte-gerth.de/mybb.html" target="_blank">Jan Malte Gerth</a></i></strong></span></td>
                <td class="tcat" colspan="4"></td>
            </tr>
		</tbody>
	</table>
</form>
INHALT
    ;
    return $content;
}

/**
 * update the date
 * @return boolean if successful
 */
function delete_data()
{
    // get and set the global content
    global $db, $mybb, $theme, $templates, $headerinclude, $header, $footer;

    // get the information of the plugin
    $info = liste_info();

    // escape the posted data
    foreach ($_POST as $data => $value) {
        $$data = escape_string($value);
    }

    // check the userrights
    if ($mybb->user['uid'] == 0)
        $errors[] = "Sie sind nicht angemeldet. Bitt melden Sie sich an bevor Sie Einträge löschen.";
    $query_data = $db->simple_select("liste", "*", "data_id='{$data_id}'");
    $insert_data = $db->fetch_array($query_data);

    if ($_POST['uid'] != $mybb->user['uid']) {
        if (!check_user(4)) {
            $errors[] = "Dieser Datensatz gehört nicht zu Ihnen. Sie dürfen ihn nicht löschen";
        }
    }

    // get any other errors
    if ($_POST['data_id'] == "")
        $errors[] = "Es wurde kein Datensatz gewählt.";

    // if any error occurred
    if (isset($errors)) {
        $content = '		<center>
			<img src="' . $mybb->settings['bburl'] . '/images/liste/file_broken.png" border="0">
			<p class="active">
				Folgende Fehler sind aufgetreten:
			</p>
			<ul style="list-style-image:url(' . $mybb->settings['bburl'] . '/images/liste/messagebox_warning.png); align:center; list-style-position:outside;">';
        // add every error to the displayed list
        foreach ($errors as $error) {
            $content .= '			<li style="align:center;">' . $error . '</li>';
        }
        $content .= '			</ul><br />
			<a href="javascript:history.back()">
				<img src="' . $mybb->settings['bburl'] . '/images/liste/undo.png" border="0">
			</a>
		</center>';
        // render the output
        eval("\$show_liste .= \"" . $templates->get("show_liste") . "\";"); // Hier wird das erstellte Template geladen
        // output the page
        output_page($show_liste);
        exit;
    }

    $db->delete_query("liste", "data_id='{$data_id}'");
    // set a message which should be displayed
    $message = '<div class="bottommenu"><img src="' . $mybb->settings['bburl'] . '/images/liste/button_ok.png" border="0"><strong>Daten wurden erfolgreich gelöscht.</strong></div>';
    return $message;
}

/**
 * delete the datas of the user which is being deleted
 * @return boolean if successful
 */
function plugin_list_delete_user()
{
    global $url;
    global $db, $mybb, $theme, $templates, $headerinclude, $header, $footer;

    $uid = intval($mybb->input['uid']);
    $db->delete_query("liste", "uid='$uid'");
}

/**
 * shows the existing dates
 * @return the html output
 */
function show_dates($message = '', $action = false, $limit = 20, $moment = 0, $offset = 0)
{
    // get and set the global content
    global $db, $mybb, $theme, $templates, $headerinclude, $header, $footer;

    // Das Anzeigelimit einstellen
    if ($limit < 1) {
        $limit = 5;
    }

    // get the information of the plugin
    $info = liste_info();

    if ($moment == 0) {
        $moment = time();
    }

    // Clean the table; delete journeys in the past
    // Ankunft (Hinflug)
    $get_delete_query = $db->simple_select("liste", '*', '', array('order_by' => 'ankunft'));
    if ($get_delete_query) {
        $users = array();
        $yesterday = mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
        while ($result = $db->fetch_array($get_delete_query)) {
            // Zähle die verschiedenen Benutzer in der Liste
            if ((!in_array($result['uid'], $users)) AND ($result['uid'] != '')) {
                $users[] = $result['uid'];
                $count_users++;
            }
            // Abflug (Rückflug)
            if ($result['abflug'] <= $yesterday) {
                $db->delete_query("liste", "data_id='{$result['data_id']}'");
            }
        }
        if ($count_users == 0)
            $count_users = 'keine';
    }

    $content = <<<INHALT
<table border="0" cellspacing="1" cellpadding="4" class="tborder">
	<thead>
		<tr>
			<td class="thead" colspan="9">
				<span style="vertical-align:center; text-align:left; float:left; width:760px;">
					<form action="{$mybb->settings["list_path"]}" method="post" style="display:inline;">
						<strong>
							<input type="hidden" name="action" value="custom" />
							Zeige nur <input type="text" name="limit" value="{$limit}" /> Einträge
							<input type="submit" name="show_limit" value="Anzeigen" style="display:inline;"/>
						</strong>
					</form>
					<span style="margin-left:50px; width:280px;">
					<!--<span style="text-align:center;">-->
						<strong>Es sind zur Zeit {$count_users} Benutzer eingetragen</strong>
					</span>
				</span>
				<form action="{$mybb->settings["list_path"]}" method="post" style="">
					<span style="vertical-align:center; text-align:left; float:right; width:450px;">
						<strong>Wer ist am
							<input type="hidden" name="action" value="at_this_moment" />
INHALT
    ;
    $content .= show_days("time_tag", date("d", $moment));
    $content .= show_months("time_monat", date("m", $moment));
    $content .= show_years("time_jahr", date("Y", $moment));
    $content .=
        <<<INHALT
							in {$mybb->settings["list_country"]}? <input type="submit" name="show_limit" value="Anzeigen" />
						</strong>
					</span>
				</form>
			</td>
		</tr>
	</thead>
</table>
<table border="0" cellspacing="1" cellpadding="4" class="tborder">
	<thead>
		<tr>
			<td class="thead" colspan="9">
				<div class="expcolimage"><img src="{$mybb->settings['bburl']}/{$theme['imgdir']}/collapse.gif" id="liste_1_img" class="expander" alt="[-]" /></div>
				<span style="vertical-align:center; text-align:right; float:left;">
					<strong>
						<a href="{$mybb->settings["bburl"]}/show_list.php?action=new_data" style="vertical-align: top;">
							<img src="{$mybb->settings['bburl']}/images/liste/viewmag+.png" border="0" valign="center"> In die Liste eintragen
						</a>
					</strong>
				</span>
			</td>
		</tr>
	</thead>
	<tbody style="" id="liste_1_e">
INHALT
    ;
    if ($action == "moment") {
        $content .= <<<INHALT
		<tr>
			<td class="tcat" colspan="9"><strong>Folgende Personen sind am
INHALT
        ;
        $content .= date("d.m.Y", $moment);
        $content .= <<<INHALT
				in {$mybb->settings["list_country"]}
			</strong></td>
		</tr>
INHALT
        ;
    }
    $content .= <<<INHALT
		<tr>
			<td class="tcat" width="15%"align="center"><strong>Name</strong></td>
			<td class="tcat" width="5%" align="center"><strong>Status</strong></td>
			<td class="tcat" width="5%" align="center"><strong>Ankunft</strong></td>
			<td class="tcat" width="5%" align="center"><strong>Abflug</strong></td>
			<td class="tcat" width="15%" align="center"><strong>Airline</strong></td>
			<td class="tcat" width="15%" align="center"><strong>Urlaubsort</strong></td>
			<td class="tcat" width="15%" align="center"><strong>Hotel</strong></td>
			<td class="tcat" width="15%" align="center"><strong>Telefon in {$mybb->settings["list_country"]}</strong></td>
			<td class="tcat" width="2%" align="center"><strong>Aktion</strong></td>
		</tr>
<!-- start: liste -->
INHALT
    ;

    // Ankunft (Hinflug)
    $start_select = $offset * $limit;
    $offset++;
    $query = $db->simple_select("liste", "*", "", array('order_by' => 'ankunft', 'limit_start' => $start_select, 'limit' => $limit));
    if ($action == "moment") {
        // Ankunft (Hinflug)
        $query = $db->simple_select("liste", "*", "{$moment} BETWEEN ankunft AND abflug", array('order_by' => 'ankunft', 'limit_start' => $start_select, 'limit' => $limit));
    }
    if ($query) {
        $x = $db->num_rows($query);
        if ($x != 0) {
            while ($result = $db->fetch_array($query)) {
                $results++;
                $content .= "<tr>\n";
                $content .= "<td class=\"trow1\" style=\"white-space: nowrap;\"><a href=\"{$mybb->settings["bburl"]}/private.php?action=send&uid={$result['uid']}\"><img src=\"{$mybb->settings['bburl']}/{$theme['imgdir']}/new_pm.gif\" border=\"0\">{$result['username']}</a></td>\n";

                // Status
                // Ankunft (Hinflug)
                // Abflug (Rückflug)
                $jetzt = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
                if (($result['ankunft'] < $jetzt) && ($result['abflug'] > $jetzt)) {
                    $content .= "<td class=\"trow1\"><img src=\"{$mybb->settings['bburl']}/images/liste/vor_ort.png\" border=\"0\"></td>\n";
                } elseif ($result['abflug'] == $jetzt) {
                    $content .= "<td class=\"trow1\"><img src=\"{$mybb->settings['bburl']}/images/liste/rueckflug.png\" border=\"0\"></td>\n";
                } elseif ($result['ankunft'] == $jetzt) {
                    $content .= "<td class=\"trow1\"><img src=\"{$mybb->settings['bburl']}/images/liste/hinflug.png\" border=\"0\"></td>\n";
                } else {
                    $content .= "<td class=\"trow1\"><img src=\"{$mybb->settings['bburl']}/images/liste/daheim.png\" border=\"0\"></td>\n";
                }
                // Ankunft (Hinflug)
                $content .= "<td class=\"trow2\" style=\"white-space: nowrap;\">" . date("d.m.Y", $result['ankunft']) . "</td>\n";
                // Abflug (Rückflug)
                $content .= "<td class=\"trow1\" style=\"white-space: nowrap;\">" . date("d.m.Y", $result['abflug']) . "</td>\n";
                $content .= "<td class=\"trow2\">{$result['airline']}</td>\n";
                $content .= "<td class=\"trow1\">{$result['ort']}</td>\n";
                $content .= "<td class=\"trow2\">{$result['hotel']}</td>\n";
                $content .= "<td class=\"trow1\">{$result['telefon']}</td>\n";
                if ((check_user(4)) OR ($result['uid'] == $mybb->user['uid']) OR ($mybb->user['uid'] == '1499')) {
                    $content .= "	<td class=\"trow2\" style=\"white-space: nowrap;\">
		<a href={$mybb->settings["bburl"]}/show_list.php?action=edit&data_id={$result['data_id']}>
			<img src=\"{$mybb->settings['bburl']}/images/liste/pencil.png\" border=\"0\" style=\"margin:0px 0px 0px 0px;\">
		</a>
		<a href={$mybb->settings["bburl"]}/show_list.php?action=delete&data_id={$result['data_id']}>
			<img src=\"{$mybb->settings['bburl']}/images/liste/no.png\" border=\"0\" border=\"0\" style=\"margin:0px 0px 0px 10px;\">
		</a>
	</td>\n";
                } else {
                    $content .= "<td class=\"trow2\"></td>\n";
                }
                $content .= "</tr>\n";
            }
        }
    }
    $content .= <<<INHALT
			<tr>
				<td class="tcat" colspan="9">
INHALT
    ;/**
     * Diese Funktion konnte noch nicht implementiert werden
     */
    /*
      if($results == $limit)
      {
      $previous = $offset - 1;
      if($previous >= 0)
      {
      $content .= '<a href="'.$mybb->settings["bburl"].'/show_list.php?offset='.$previous.'">Vorherige Seite</a>';
      }
      $content .= '<a href="'.$mybb->settings["bburl"].'/show_list.php?offset='.$offset.'">Nächste Seite</a>';
      }
      else
      {
      $previous = $offset - 1;
      if($previous >= 0)
      {
      $content .= '<a href="'.$mybb->settings["bburl"].'/show_list.php?offset='.$previous.'">Vorherige Seite</a>';
      }
      }
     */
    $content .= <<<INHALT
					<span style="vertical-align:center; text-align:left; float:right;">
						<img src="{$mybb->settings['bburl']}/images/liste/pencil.png" border="0"> = Ändern <img src="{$mybb->settings['bburl']}/images/liste/no.png" border="0" style="margin:0px 0px 0px 10px;"> = Löschen
					</span>
				</td>
			</tr>
			<tr>
				<td class="tcat" colspan="5"><span><strong>Aufenthaltsliste (Version {$info['version']}) by <i><a href="http://www.malte-gerth.de/mybb.html" target="_blank">Jan Malte Gerth</a></i></strong></span></td>
				<td class="tcat" colspan="4"></td>
			</tr>
		</tbody>
	</table>
	<!-- end: show_list -->
INHALT
    ;
    return $content;
}

/* * ********************************************************************
 *
 * main functions for displaying
 *
 */

function plugin_show_list_index()
{
    global $db, $mybb, $templates, $headerinclude, $header, $footer, $index, $liste;
    // show only if user is logged in
    if ($mybb->user['uid'] != 0) {

        if ($mybb->settings['show_list_on_index'] == 'yes') {
            if ($mybb->settings['show_list'] == 'yes') {
                // get the limitation
                if ($_COOKIE['liste']) {
                    $limit = $_COOKIE['liste'];
                } else {
                    $limit = 5;
                }

                // decide what to do
                if ($_POST['action'] == 'edit_data') {
                    $message = edit_data();
                    $content = show_dates($message, 'default', $limit);
                } elseif ($_GET['action'] == 'edit') {
                    $content = show_form_edit_data();
                } elseif ($_GET['action'] == 'delete') {
                    $message = delete_data();
                    $content = show_dates($message, 'default', $limit);
                } elseif ($_GET['action'] == 'new_data') {
                    $content = show_form_new_data();
                } elseif ($_POST['action'] == 'insert_new_data') {
                    $message = insert_new_data();
                    $content = show_dates($message, 'default', $limit);
                } else {
                    $content = show_dates($message, 'default', $limit);
                }
                eval("\$liste .= \"" . $templates->get("show_liste_bit") . "\";"); // Hier wird das erstellte Template geladen
            }
        }
    }
}

function plugin_show_list()
{
    global $db, $mybb, $theme, $templates, $headerinclude, $header, $footer;
    if ($mybb->settings['show_list'] == 'yes') {
        // get the limitation
        if ($_COOKIE['liste']) {
            $limit = $_COOKIE['liste'];
        } else {
            $limit = 20;
        }

        // decide what to do
        if ($_POST['action'] == 'edit_data') {
            add_breadcrumb($mybb->settings["list_title"]);
            $message = edit_data();
            $content = show_dates($message, 'default', $limit);
        } elseif ($_GET['action'] == 'edit') {
            add_breadcrumb("{$mybb->settings["list_title"]} - Eintrag bearbeiten");
            $content = show_form_edit_data();
        } elseif ($_POST['action'] == 'delete') {
            add_breadcrumb("{$mybb->settings["list_title"]} - Eintrag gelöscht");
            $message = delete_data();
            $content = show_dates($message, 'default', $limit);
        } elseif ($_GET['action'] == 'delete') {
            add_breadcrumb("{$mybb->settings["list_title"]} - Eintrag löschen");
            $content = delete_data_notification();
        } elseif ($_GET['action'] == 'new_data') {
            add_breadcrumb("{$mybb->settings["list_title"]} - Neuer Eintrag");
            $content = show_form_new_data();
        } elseif ($_POST['action'] == 'insert_new_data') {
            add_breadcrumb("{$mybb->settings["list_title"]} - Eintrag eingetragen");
            $message = insert_new_data();
            $content = show_dates($message, 'default', $limit);
        } elseif ($_POST['action'] == "custom") {
            $limit = $_POST['limit'];
            $time = 60 * 60 * 24 * 2;
            my_setcookie("liste", $limit, $time, true);
            add_breadcrumb("{$mybb->settings["list_title"]}");
            $content = show_dates($message, "custom", $limit);
        } elseif ($_POST['action'] == "at_this_moment") {
            add_breadcrumb("{$mybb->settings["list_title"]}");
            $moment = mktime(0, 0, 0, $_POST['time_monat'], $_POST['time_tag'], $_POST['time_jahr']);
            $content = show_dates($message, "moment", $limit, $moment);
        } elseif ($_GET['offset']) {
            add_breadcrumb("{$mybb->settings["list_title"]}");
            $moment = time();
            $content = show_dates($message, "moment", $limit, $moment, $_GET['offset']);
        } else {
            add_breadcrumb("{$mybb->settings["list_title"]}");
            $content = show_dates($message, 'default', $limit);
        }
        eval("\$show_liste .= \"" . $templates->get("show_liste") . "\";"); // Hier wird das erstellte Template geladen
        output_page($show_liste);
    } else {
        add_breadcrumb("{$mybb->settings["list_title"]}");
        $message = '<h2 style="color:red;">Die Anzeige wurde deaktiviert.</h2>';
        $content = '';
        eval("\$show_liste .= \"" . $templates->get("show_liste") . "\";"); // Hier wird das erstellte Template geladen
        output_page($show_liste);
    }
}

/* * ********************************************************************
 *
 * un/install functions of the plugin
 *
 */
$plugins->add_hook("index_start", "plugin_show_list_index");
$plugins->add_hook("liste_start", "plugin_show_list");
$plugins->add_hook("admin_users_do_delete", "plugin_list_delete_user");

function liste_info()
{
    return array(
        "name" => "Aufenthaltsliste",
        "description" => "Zeigt wann wer in einem bestimmten Land ist",
        "website" => "http://www.malte-gerth.de/mybb.html",
        "author" => "Jan Malte Gerth",
        "authorsite" => "http://www.malte-gerth.de/",
        "version" => "1.6.0",
        "compatibility" => "16*",
    );
}

function liste_is_installed()
{
    global $db, $mybb;

    if (array_key_exists('keep_list', $mybb->settings)) {
        if ($mybb->settings['keep_list'] == 'no') {
            if ($db->field_exists('id', "liste")) {
                return true;
            }
        } else {
            $query = $db->simple_select('templates', '*', 'title = \'show_liste\'');
            if ($db->num_rows($query)) {
                return true;
            }
        }
    }

    return false;
}

function liste_install()
{
    global $db, $mybb;
    require_once MYBB_ROOT . "/inc/adminfunctions_templates.php";

    /*
     * add plugin templates
     */
    $templateShowListe = array(
        "tid" => "NULL",
        "title" => "show_liste",
        "template" => "<html>
	<head>
		<title>{\$mybb->settings[list_title]}</title>
		<base href=\"{\$mybb->settings[bburl]}/\">
		{\$headerinclude}
	</head>
	<body>
		{\$header}
		{\$message}<br />
		{\$content}
		{\$footer}
	</body>
</html>",
        "sid" => "-1",
    );
    $db->insert_query("templates", $templateShowListe);

    $templateShowListeBit = array(
        "tid" => "NULL",
        "title" => "show_liste_bit",
        "template" => "{\$message}<br />\n{\$content}<br />\n",
        "sid" => "-1",
    );
    $db->insert_query("templates", $templateShowListeBit);

    $dbversion = $db->get_version();
    if ($dbversion > 5) {
        $createTableQuery = "CREATE TABLE IF NOT EXISTS `" . $db->table_prefix . "liste` (
                    `id` int(10) unsigned NOT NULL,
                    `uid` int(10) unsigned default NULL,
                    `username` text character set utf8 collate utf8_unicode_ci,
                    `ankunft` int(11) default NULL,
                    `abflug` int(11) default NULL,
                    `airline` varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL,
                    `ort` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
                    `hotel` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
                    `telefon` varchar(255) character set utf8 collate utf8_unicode_ci default NULL,
                    `data_id` bigint(20) NOT NULL auto_increment,
                    `sort_id` bigint(20) default NULL,
                    PRIMARY KEY  (`data_id`)
                    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
    } else {
        $createTableQuery = "CREATE TABLE IF NOT EXISTS `" . $db->table_prefix . "liste` (
                    `id` int(10) unsigned NOT NULL,
                    `uid` int(10) unsigned default NULL,
                    `username` text,
                    `ankunft` int(11) default NULL,
                    `abflug` int(11) default NULL,
                    `airline` varchar(100) NOT NULL,
                    `ort` varchar(255) NOT NULL,
                    `hotel` varchar(255) NOT NULL,
                    `telefon` varchar(255) default NULL,
                    `data_id` bigint(20) NOT NULL auto_increment,
                    `sort_id` bigint(20) default NULL,
                    PRIMARY KEY  (`data_id`)
                    ) TYPE=MyISAM ;";
    }
    $db->write_query($createTableQuery);
    
    /*
     * add plugin settings
     */
    $list_group = array(
        "gid" => "NULL",
        "name" => "liste",
        "title" => "Aufenthaltsliste",
        "description" => "Aufenthaltsliste, wer ist wann wo in Thailand",
        "disporder" => "1",
        "isdefault" => "no"
    );
    $db->insert_query("settinggroups", $list_group);
    $gid = $db->insert_id();

    $list_1 = array(
        "sid" => "NULL",
        "name" => "show_list",
        "title" => "Anzeige der Liste",
        "description" => "Soll die Liste angezeigt werden?",
        "optionscode" => "yesno",
        "value" => "yes",
        "disporder" => "10",
        "gid" => intval($gid)
    );
    $db->insert_query("settings", $list_1);
    
    $list_2 = array(
        "sid" => "NULL",
        "name" => "keep_list",
        "title" => "Informationen behalten",
        "description" => "Sollen die gespeicherten Informationen der Aufenthalte beim Deaktivieren des Plugins erhalten bleiben?",
        "optionscode" => "yesno",
        "value" => "yes",
        "disporder" => "20",
        "gid" => intval($gid)
    );
    $db->insert_query("settings", $list_2);
    
    $settingOnlyVisibleForMembers = array(
        "sid" => "NULL",
        "name" => "showListOnlyForMembers",
        "title" => "Liste nur für Mitglieder anzeigen",
        "description" => "Soll die Liste nur für Mitglieder sichtbar sein?",
        "optionscode" => "yesno",
        "value" => "yes",
        "disporder" => "30",
        "gid" => intval($gid)
    );
    $db->insert_query("settings", $settingOnlyVisibleForMembers);
    
    $list_3 = array(
        "sid" => "NULL",
        "name" => "show_list_on_index",
        "title" => "Auf der Startseite anzeigen",
        "description" => "Soll die Liste auf der Startseite angezeigt werden?",
        "optionscode" => "yesno",
        "value" => "no",
        "disporder" => "40",
        "gid" => intval($gid)
    );
    $db->insert_query("settings", $list_3);
    
    $list_4 = array(
        "sid" => "NULL",
        "name" => "list_country",
        "title" => "Name des Landes",
        "description" => "Für welches Land gilt die Tabelle?",
        "optionscode" => "text",
        "value" => "Thailand",
        "disporder" => "50",
        "gid" => intval($gid)
    );
    $db->insert_query("settings", $list_4);
    
    $list_5 = array(
        "sid" => "NULL",
        "name" => "list_title",
        "title" => "Titel des Plugins",
        "description" => "Welcher Titel soll angezeigt werden?",
        "optionscode" => "text",
        "value" => "Wer ist wann in Thailand",
        "disporder" => "60",
        "gid" => intval($gid)
    );
    $db->insert_query("settings", $list_5);
    
    rebuild_settings();
}

function liste_uninstall()
{
    global $db, $mybb;
    require_once MYBB_ROOT . "/inc/adminfunctions_templates.php";

    if ($mybb->settings['keep_list'] == 'no') {
        $db->drop_table('liste');
    }
    
    /*
     * remove plugin settings
     */
    $db->delete_query("settings", "name IN('list_title','list_country','show_list_on_index','keep_list','show_list');");
    $db->delete_query("settinggroups", "name='liste'");
    
    rebuild_settings();
    
    /*
     * remove plugin templates
     */
    $db->delete_query("templates", "title IN('show_liste','show_liste_bit')");
}

function liste_activate()
{
    global $db, $mybb;
    require_once MYBB_ROOT . "/inc/adminfunctions_templates.php";

    find_replace_templatesets("index", '#{\$header}(\r?)(\n?)#', "{\$header}\r\n{\$liste}\r\n");

    find_replace_templatesets("header", '#toplinks_help}</a></li>#', "$0\n<li class=\"list_link\"><a href=\"{\$mybb->settings['bburl']}/show_list.php\"><img src=\"{\$mybb->settings[bburl]}/images/liste/list.png\" border=\"0\" alt=\"\" />Aufenthaltsliste</a></li>");
}

function liste_deactivate()
{
    global $db, $mybb;
    require_once MYBB_ROOT . "/inc/adminfunctions_templates.php";

    find_replace_templatesets("index", '#(\r?)(\n?){\$liste}(\r?)(\n?)#', "\r\n", 0);

    find_replace_templatesets("header", '#(\n?)<li class="list_link">(.*)</li>#', '', 0);
}
