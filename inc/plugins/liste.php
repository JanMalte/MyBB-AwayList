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

class ShowDates {
/**
 * shows the days and select the given day
 * @param $P_name the name of the select
 * @param $P_day the selected day
 * @return the HTML of the select part of the form
 */
public static function show_days($P_name, $P_day = false)
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
public static function show_months($P_name, $P_month = false)
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
public static function show_years($P_name, $P_year = false)
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
public static function check_future_date_old_old($P_date_day, $P_date_month, $P_date_year, $P_former_date_day=false, $P_former_date_month=false, $P_former_date_year=false)
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
public static function check_future_date($P_first_date, $P_second_date=false)
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
    global $db;
    
    return $db->escape_string($string);
}

/* * ********************************************************************
 *
 * main functions for this plugin
 *
 */

/**
 * shows the insert form for a new item
 * @return the html content
 */
function showNewDataForm()
{
    global $db, $mybb, $lang, $templates;
    $lang->load("liste", false, true);

    $content = '
	<form action="'.$mybb->settings["bburl"].'/'.THIS_SCRIPT.'" method="post">
            <input type="hidden" name="action" value="addItem" />
            <input type="hidden" name="step2" value="true" />
            <table border="0" cellspacing="1" cellpadding="4" class="tborder">
                <thead>
                    <tr>
                        <td class="thead" colspan="2">
                            <div><strong>'.$lang->addToList.'</strong><br /><div class="smalltext"></div></div>
                        </td>
                    </tr>
                </thead>
                <tbody style="" id="cat_1_e">
                    <tr>
                        <td class="trow1"><b>'.$lang->arrival.':</b>*</td>
                        <td class="trow1">';
    // Ankunft (Hinflug)
    $content .= ShowDates::show_days("ankunft_tag");
    $content .= ShowDates::show_months("ankunft_monat");
    $content .= ShowDates::show_years("ankunft_jahr");
    $content .= '
		  </td>
		</tr>
		<tr>
		  <td class="trow2"><b>'.$lang->departure.':</b>*</td>
		  <td class="trow2">';
    // Abflug (Rückflug)
    $content .= ShowDates::show_days("abflug_tag");
    $content .= ShowDates::show_months("abflug_monat");
    $content .= ShowDates::show_years("abflug_jahr");
    $content .= '
		  </td>
		</tr>
		<tr>
		  <td class="trow1"><b>'.$lang->airline.':</b>*</td>
		  <td class="trow1"><input type="text" name="airline" size="40" maxlength="20" /></td>
		</tr>
		<tr>
		  <td class="trow2"><b>'.$lang->place.':</b>*</td>
		  <td class="trow2"><input type="text" name="place" size="40" maxlength="20" /></td>
		</tr>
		<tr>
		  <td class="trow1"><b>'.$lang->hotel.':</b>*</td>
		  <td class="trow1"><input type="text" name="hotel" size="40" maxlength="20" /></td>
		</tr>
		<tr>
		  <td class="trow2"><b>'.$lang->phoneAt.' '.$mybb->settings["list_country"].':</b></td>
		  <td class="trow2"><input type="text" name="phone" size="25" maxlength="15" /></td>
		</tr>
		<tr>
		  <td class="trow1">* = '.$lang->requiredFields.'</td>
		  <td class="trow1"><input type="submit" name="addItem" value="'.$lang->addToList.'"></td>
		</tr>
            </tbody>
	  </table>
	</form>';
    return $content;
}

/**
 * show the edit form
 * @return the html content
 */
function showEditDataForm()
{
    global $db, $mybb, $lang, $templates;
    $lang->load("liste", false, true);

    $query = $db->simple_select("liste", '*', "data_id = '" . $mybb->input['data_id'] . "'");
    $item = $db->fetch_array($query);

    
    if ($item['uid'] != $mybb->user['uid'] && !check_user(4)) {
        $errors[] = "Sie haben nicht die nötigen Rechte diesen Eintrag zu bearbeiten";
    }
    if ($mybb->input['data_id'] == '') {
        $errors[] = "Es wurde kein Datensatz zum Bearbeiten ausgewählt.";
    }
    
    // if any error occurred
    if (isset($errors)) {
        add_breadcrumb($lang->editItem);
        $content .= '<div class="error low_warning"><p><em>' . $lang->followingErrors . '</em></p>';
        $content .= '<p><ul>';
        foreach ($errors as $error) {
            $content .= '<li>' . $error . '</li>';
        }
        $content .= '</ul></p>';
        $content .= '<a href="javascript:history.back()">' . $lang->back . '</a></div>';
        eval("\$showListe .= \"" . $templates->get("show_liste") . "\";"); // Hier wird das erstellte Template geladen
        output_page($showListe);
        exit;
    }
    $content = '
	<form action="'.$mybb->settings["bburl"].'/'.THIS_SCRIPT.'" method="post">
            <input type="hidden" name="action" value="editItem" />
            <input type="hidden" name="step2" value="true" />
            <input type="hidden" name="data_id" value="'.$item['data_id'].'" />
            <table border="0" cellspacing="1" cellpadding="4" class="tborder">
                <thead>
                    <tr>
                        <td class="thead" colspan="2">
                            <div><strong>'.$lang->editItem.'</strong><br /><div class="smalltext"></div></div>
                        </td>
                    </tr>
                </thead>
                <tbody style="" id="cat_1_e">
                    <tr>
                        <td class="trow1"><b>'.$lang->arrival.':</b>*</td>
                        <td class="trow1">';
    // Ankunft (Hinflug)
    $content .= ShowDates::show_days("ankunft_tag",date('d',$item['ankunft']));
    $content .= ShowDates::show_months("ankunft_monat",date('m',$item['ankunft']));
    $content .= ShowDates::show_years("ankunft_jahr",date('Y',$item['ankunft']));
    $content .= '
		  </td>
		</tr>
		<tr>
		  <td class="trow2"><b>'.$lang->departure.':</b>*</td>
		  <td class="trow2">';
    // Abflug (Rückflug)
    $content .= ShowDates::show_days("abflug_tag",date('d',$item['abflug']));
    $content .= ShowDates::show_months("abflug_monat",date('m',$item['abflug']));
    $content .= ShowDates::show_years("abflug_jahr",date('Y',$item['abflug']));
    $content .= '
		  </td>
		</tr>
		<tr>
		  <td class="trow1"><b>'.$lang->airline.':</b>*</td>
		  <td class="trow1"><input type="text" name="airline" size="40" maxlength="20" value="'.$item['airline'].'" /></td>
		</tr>
		<tr>
		  <td class="trow2"><b>'.$lang->place.':</b>*</td>
		  <td class="trow2"><input type="text" name="place" size="40" maxlength="20" value="'.$item['ort'].'" /></td>
		</tr>
		<tr>
		  <td class="trow1"><b>'.$lang->hotel.':</b>*</td>
		  <td class="trow1"><input type="text" name="hotel" size="40" maxlength="20" value="'.$item['hotel'].'" /></td>
		</tr>
		<tr>
		  <td class="trow2"><b>'.$lang->phoneAt.' '.$mybb->settings["list_country"].':</b></td>
		  <td class="trow2"><input type="text" name="phone" size="25" maxlength="15" value="'.$item['telefon'].'" /></td>
		</tr>
		<tr>
		  <td class="trow1">* = '.$lang->requiredFields.'</td>
		  <td class="trow1"><input type="submit" name="editItem" value="'.$lang->editItem.'"></td>
		</tr>
            </tbody>
	  </table>
	</form>';
    return $content;
}

/**
 * insert the new item
 */
function insertNewData()
{
    global $db, $mybb, $lang, $theme, $templates, $headerinclude, $header, $footer;
    $lang->load("liste", false, true);

    // TODO add language support
    if ($mybb->input['airline'] == "")
        $errors[] = "Bitte geben Sie eine Airline ein.";
    if ($mybb->input['place'] == "")
        $errors[] = "Bitte geben Sie einen Urlaubsort ein.";
    if ($mybb->input['hotel'] == "")
        $errors[] = "Bitte geben Sie einen Hotelnamen ein.";
    if (preg_match("/^[0-9[:space:]]*$/", $mybb->input['phone'], $number)) {
        unset($number);
    } else {
        $errors[] = 'Bitte geben Sie im Feld "Telefonnummer" nur Zahlen ein. Die Angabe der Telefonnummer ist freiwillig.';
    }
    $arrival = mktime(0, 0, 0, $mybb->input['ankunft_monat'], $mybb->input['ankunft_tag'], $mybb->input['ankunft_jahr']);
    $departure = mktime(0, 0, 0, $mybb->input['abflug_monat'], $mybb->input['abflug_tag'], $mybb->input['abflug_jahr']);
    
    $check = true;
    $query = $db->simple_select("liste", "*", "uid = '{$mybb->user['uid']}' AND ( ( ankunft BETWEEN '$arrival' AND '$departure' ) OR ( abflug  BETWEEN '$arrival' AND '$departure' ) OR (ankunft >= $arrival AND abflug <= $departure) )");
    while ($result = $db->fetch_array($query)) {
        $check = false;
    }
    if ($check == false)
        $errors[] = "Sie sind zu diesem Zeitpunkt schon unterwegs";

    if (!ShowDates::check_future_date($arrival))
        $errors[] = "Das Ankunftsdatum liegt nicht in der Zukunft.";
    if (!ShowDates::check_future_date($departure))
        $errors[] = "Das Abflugsdatum liegt nicht in der Zukunft.";
    if (!ShowDates::check_future_date($departure, $arrival))
        $errors[] = "Das Abflugsdatum liegt vor dem Ankunftsdatum";

    // if any error occurred
    if (isset($errors)) {
        add_breadcrumb("Neuer Eintrag");
        $content .= '<div class="error low_warning"><p><em>' . $lang->followingErrors . '</em></p>';
        $content .= '<p><ul>';
        foreach ($errors as $error) {
            $content .= '<li>' . $error . '</li>';
        }
        $content .= '</ul></p>';
        $content .= '<a href="javascript:history.back()">' . $lang->back . '</a></div>';
        eval("\$showListe .= \"" . $templates->get("show_liste") . "\";"); // Hier wird das erstellte Template geladen
        output_page($showListe);
        exit;
    }
    
    $insertData = array(
        'id' => '',
        'uid' => $mybb->user['uid'],
        'username' => $mybb->user['username'],
        'ankunft' => escape_string($arrival),
        'abflug' => escape_string($departure),
        'airline' => escape_string($mybb->input['airline']),
        'ort' => escape_string($mybb->input['place']),
        'hotel' => escape_string($mybb->input['hotel']),
        'telefon' => escape_string($mybb->input['phone']),
        'data_id' => '',
        'sort_id' => ''
    );
    $db->insert_query('liste', $insertData);

    return true;
}

/**
 * update the item
 * @return boolean if successful
 */
function editItem()
{
    global $db, $mybb, $lang, $theme, $templates, $headerinclude, $header, $footer;


    // TODO add language support
    if ($mybb->input['airline'] == "")
        $errors[] = "Bitte geben Sie eine Airline ein.";
    if ($mybb->input['place'] == "")
        $errors[] = "Bitte geben Sie einen Urlaubsort ein.";
    if ($mybb->input['hotel'] == "")
        $errors[] = "Bitte geben Sie einen Hotelnamen ein.";
    if (preg_match("/^[0-9[:space:]]*$/", $mybb->input['phone'], $number)) {
        unset($number);
    } else {
        $errors[] = 'Bitte geben Sie im Feld "Telefonnummer" nur Zahlen ein. Die Angabe der Telefonnummer ist freiwillig.';
    }
    $arrival = mktime(0, 0, 0, $mybb->input['ankunft_monat'], $mybb->input['ankunft_tag'], $mybb->input['ankunft_jahr']);
    $departure = mktime(0, 0, 0, $mybb->input['abflug_monat'], $mybb->input['abflug_tag'], $mybb->input['abflug_jahr']);
    
    $check = true;
    $query = $db->simple_select("liste", "*", "uid = '{$mybb->user['uid']}' AND ( ( ankunft BETWEEN '$arrival' AND '$departure' ) OR ( abflug  BETWEEN '$arrival' AND '$departure' ) OR (ankunft >= $arrival AND abflug <= $departure) )");
    while ($result = $db->fetch_array($query)) {
        if($result['data_id']!=$mybb->input['data_id'])
            $check = false;
    }
    if ($check == false)
        $errors[] = "Sie sind zu diesem Zeitpunkt schon unterwegs";

    #if (!ShowDates::check_future_date($arrival))
    #    $errors[] = "Das Ankunftsdatum liegt nicht in der Zukunft.";
    if (!ShowDates::check_future_date($departure))
        $errors[] = "Das Abflugsdatum liegt nicht in der Zukunft.";
    if (!ShowDates::check_future_date($departure, $arrival))
        $errors[] = "Das Abflugsdatum liegt vor dem Ankunftsdatum";

    // if any error occurred
    if (isset($errors)) {
        add_breadcrumb("Neuer Eintrag");
        $content .= '<div class="error low_warning"><p><em>' . $lang->followingErrors . '</em></p>';
        $content .= '<p><ul>';
        foreach ($errors as $error) {
            $content .= '<li>' . $error . '</li>';
        }
        $content .= '</ul></p>';
        $content .= '<a href="javascript:history.back()">' . $lang->back . '</a></div>';
        eval("\$showListe .= \"" . $templates->get("show_liste") . "\";"); // Hier wird das erstellte Template geladen
        output_page($showListe);
        exit;
    }
    
    $insertData = array(
        'ankunft' => escape_string($arrival),
        'abflug' => escape_string($departure),
        'airline' => escape_string($mybb->input['airline']),
        'ort' => escape_string($mybb->input['place']),
        'hotel' => escape_string($mybb->input['hotel']),
        'telefon' => escape_string($mybb->input['phone']),
    );
    $db->update_query('liste', $insertData, "data_id = '{$mybb->input['data_id']}'");

    return true;
}

/**
 * @return the html message
 */
function showDeleteConfirmDialog()
{
    global $db, $mybb, $lang, $templates;
    $lang->load("liste", false, true);

    $query = $db->simple_select("liste", '*', "data_id = '" . $mybb->input['data_id'] . "'");
    $item = $db->fetch_array($query);
    
    if ($item['uid'] != $mybb->user['uid'] && !check_user(4)) {
        $errors[] = "Sie haben nicht die nötigen Rechte diesen Eintrag zu bearbeiten";
    }
    if ($mybb->input['data_id'] == '') {
        $errors[] = "Es wurde kein Datensatz zum Löschen ausgewählt.";
    }
    
    // if any error occurred
    if (isset($errors)) {
        add_breadcrumb($lang->deleteItem);
        $content .= '<div class="error low_warning"><p><em>' . $lang->followingErrors . '</em></p>';
        $content .= '<p><ul>';
        foreach ($errors as $error) {
            $content .= '<li>' . $error . '</li>';
        }
        $content .= '</ul></p>';
        $content .= '<a href="javascript:history.back()">' . $lang->back . '</a></div>';
        eval("\$showListe .= \"" . $templates->get("show_liste") . "\";"); // Hier wird das erstellte Template geladen
        output_page($showListe);
        exit;
    }
    $content = '
	<form action="'.$mybb->settings["bburl"].'/'.THIS_SCRIPT.'" method="post">
            <input type="hidden" name="action" value="deleteItem" />
            <input type="hidden" name="step2" value="true" />
            <input type="hidden" name="data_id" value="'.$item['data_id'].'" />
            <table border="0" cellspacing="1" cellpadding="4" class="tborder">
                <thead>
                    <tr>
                        <td class="thead" colspan="2">
                            <div><strong>'.$lang->deleteItem.'</strong><br /><div class="smalltext"></div></div>
                        </td>
                    </tr>
                </thead>
                <tbody style="" id="cat_1_e">
                    <tr>
                        <td class="trow1"><b>'.$lang->arrival.':</b></td>
                        <td class="trow1">';
    // Ankunft (Hinflug)
    $content .= date('d.m.Y',$item['ankunft']);
    $content .= '
		  </td>
		</tr>
		<tr>
		  <td class="trow2"><b>'.$lang->departure.':</b></td>
		  <td class="trow2">';
    // Abflug (Rückflug)
    $content .= date('d.m.Y',$item['abflug']);
    $content .= '
		  </td>
		</tr>
		<tr>
		  <td class="trow1"><b>'.$lang->airline.':</b></td>
		  <td class="trow1">'.$item['airline'].'</td>
		</tr>
		<tr>
		  <td class="trow2"><b>'.$lang->place.':</b></td>
		  <td class="trow2">'.$item['ort'].'</td>
		</tr>
		<tr>
		  <td class="trow1"><b>'.$lang->hotel.':</b></td>
		  <td class="trow1">'.$item['hotel'].'</td>
		</tr>
		<tr>
		  <td class="trow2"><b>'.$lang->phoneAt.' '.$mybb->settings["list_country"].':</b></td>
		  <td class="trow2">'.$item['telefon'].'</td>
		</tr>
		<tr>
		  <td class="trow1"></td>
		  <td class="trow1"><input type="submit" name="deleteItem" value="'.$lang->deleteItem.'"></td>
		</tr>
            </tbody>
	  </table>
	</form>';
    return $content;
}

/**
 * delete the item
 * @return boolean if successful
 */
function deleteData()
{
    global $db, $mybb, $lang, $theme, $templates, $headerinclude, $header, $footer;
    $lang->load("liste", false, true);

    $query = $db->simple_select("liste", '*', "data_id = '" . $mybb->input['data_id'] . "'");
    $item = $db->fetch_array($query);
    
    if ($item['uid'] != $mybb->user['uid'] && !check_user(4)) {
        $errors[] = "Sie haben nicht die nötigen Rechte diesen Eintrag zu bearbeiten";
    }
    if ($mybb->input['data_id'] == '') {
        $errors[] = "Es wurde kein Datensatz zum Löschen ausgewählt.";
    }
    
    // if any error occurred
    if (isset($errors)) {
        add_breadcrumb($lang->deleteItem);
        $content .= '<div class="error low_warning"><p><em>' . $lang->followingErrors . '</em></p>';
        $content .= '<p><ul>';
        foreach ($errors as $error) {
            $content .= '<li>' . $error . '</li>';
        }
        $content .= '</ul></p>';
        $content .= '<a href="javascript:history.back()">' . $lang->back . '</a></div>';
        eval("\$showListe .= \"" . $templates->get("show_liste") . "\";"); // Hier wird das erstellte Template geladen
        output_page($showListe);
        exit;
    }

    $db->delete_query("liste", "data_id='{$mybb->input['data_id']}'");
    return true;
}

/**
 * delete the items of the user which is being deleted
 */
function plugin_list_delete_user()
{
    global $db, $mybb;

    $uid = intval($mybb->input['uid']);
    $db->delete_query("liste", "uid='$uid'");
}

/**
 * show the table with all items
 */
function showFullTable($timestamp = null, $useTimestamp = false, $limit = 20, $startLimit = 0)
{
    global $db, $mybb, $lang, $theme, $templates, $headerinclude, $header, $footer;
    $lang->load("liste", false, true);

    // limit of displayed items
    if ($limit < 1) {
        $limit = 20;
    }

    if ($timestamp == null) {
        $timestamp = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
    }

    $queryItems = $db->simple_select('liste', '*', '', array('order_by' => 'ankunft'));
    $countTotalUsers =$db->num_rows($queryItems);
    if ($countTotalUsers == 0) {
        $countTotalUsers = 'keine';
    } elseif ($countTotalUsers == 1) {
        $countTotalUsers = 'eine';
    }
    
    if($useTimestamp == true) {
        $queryItems = $db->simple_select('liste', '*', $timestamp.' BETWEEN ankunft AND abflug', array('order_by' => 'ankunft', 'limit_start' => $startLimit, 'limit' => $limit));
        $timeStampNotice = '<tr><td class="tcat" colspan="9"><strong>'.$lang->personsCurrentlyThere.
            date(" d.m.Y ", $timestamp).$lang->in.' '.$mybb->settings["list_country"].'</strong></td></tr>';
    } else {
        $queryItems = $db->simple_select('liste', '*', 'abflug > '.$timestamp, array('order_by' => 'ankunft', 'limit_start' => $startLimit, 'limit' => $limit));
        $timeStampNotice = '';
    }
    $countUsers =$db->num_rows($queryItems);
    $arrayItems = array();
    while ($item = $db->fetch_array($queryItems)) {
        $arrayItems[$item['data_id']] = $item;
    }

    // TODO move to a list_bit template
    $content = '
<table border="0" cellspacing="1" cellpadding="4" class="tborder">
    <thead>
        <tr>
            <td class="thead" colspan="9">
                <form action="'.THIS_SCRIPT.'" method="post" style="vertical-align:center; text-align:left; float:left; width:35%;">
                    <strong>
                            <input type="hidden" name="action" value="setLimit" />
                            '.$lang->showOnly.' <input type="text" name="limit" value="'.$limit.'" /> '.$lang->entries.'
                            <input type="submit" name="setLimit" value="'.$lang->show.'" style="display:inline;"/>
                    </strong>
                </form>
                <span style="vertical-align:center; text-align:center; float:left; width:30%;">
                    <strong>Es sind zur Zeit '.$countTotalUsers.' Benutzer eingetragen</strong>
                </span>
                <form action="'.THIS_SCRIPT.'" method="post" style="vertical-align:center; text-align:right; float:left; width:35%;">
                    <strong>'.$lang->whoIsAt.'
                            <input type="hidden" name="action" value="setTimestamp" />';
$content .= ShowDates::show_days("time_tag", date("d", $timestamp));
$content .= ShowDates::show_months("time_monat", date("m", $timestamp));
$content .= ShowDates::show_years("time_jahr", date("Y", $timestamp));
$content .= <<<INHALT
                            {$lang->in} {$mybb->settings["list_country"]}? <input type="submit" name="setTimestamp" value="Anzeigen" />
                    </strong>
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
                        <a href="{$mybb->settings["bburl"]}/show_list.php?action=addItem" style="vertical-align: top;">
                                <img src="{$mybb->settings['bburl']}/images/liste/viewmag+.png" border="0" valign="center"> {$lang->addToList}
                        </a>
                    </strong>
                </span>
            </td>
        </tr>
    </thead>
    <tbody style="" id="liste_1_e">
INHALT;
    
    $content .= $timeStampNotice.'<tr>
            <td class="tcat" width="15%"align="center"><strong>'.$lang->name.'</strong></td>
            <td class="tcat" width="5%" align="center"><strong>'.$lang->status.'</strong></td>
            <td class="tcat" width="5%" align="center"><strong>'.$lang->arrival.'</strong></td>
            <td class="tcat" width="5%" align="center"><strong>'.$lang->departure.'</strong></td>
            <td class="tcat" width="15%" align="center"><strong>'.$lang->airline.'</strong></td>
            <td class="tcat" width="15%" align="center"><strong>'.$lang->place.'</strong></td>
            <td class="tcat" width="15%" align="center"><strong>'.$lang->hotel.'</strong></td>
            <td class="tcat" width="15%" align="center"><strong>'.$lang->phoneAt.' '.$mybb->settings["list_country"].'</strong></td>
            <td class="tcat" width="2%" align="center"><strong>'.$lang->action.'</strong></td>
        </tr>';

    foreach($arrayItems as $item) {
        $count++;
        $content .= '<tr>';
        $content .= '<td class="trow1"><a href="'.get_profile_link($item['uid']).'">'.$item['username'].'</a></td>';

        $jetzt = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        if (($item['ankunft'] < $jetzt) && ($item['abflug'] > $jetzt)) {
            $content .= "<td class=\"trow1\"><img src=\"{$mybb->settings['bburl']}/images/liste/vor_ort.png\" border=\"0\"></td>\n";
        } elseif ($item['abflug'] == $jetzt) {
            $content .= "<td class=\"trow1\"><img src=\"{$mybb->settings['bburl']}/images/liste/rueckflug.png\" border=\"0\"></td>\n";
        } elseif ($item['ankunft'] == $jetzt) {
            $content .= "<td class=\"trow1\"><img src=\"{$mybb->settings['bburl']}/images/liste/hinflug.png\" border=\"0\"></td>\n";
        } else {
            $content .= "<td class=\"trow1\"><img src=\"{$mybb->settings['bburl']}/images/liste/daheim.png\" border=\"0\"></td>\n";
        }
        
        $content .= "<td class=\"trow2\" style=\"white-space: nowrap;\">" . date("d.m.Y", $item['ankunft']) . "</td>\n";
        $content .= '<td class="trow1" style="white-space: nowrap;">' . date("d.m.Y", $item['abflug']) . '</td>';
        $content .= '<td class="trow2">'.$item['airline'].'</td>';
        $content .= '<td class="trow1">'.$item['ort'].'</td>';
        $content .= '<td class="trow2">'.$item['hotel'].'</td>';
        $content .= '<td class="trow1">'.$item['telefon'].'</td>';
        if ((check_user(4)) OR ($item['uid'] == $mybb->user['uid'])) {
            $content .= '<td class="trow2">
                <a class="icon" href="'.$mybb->settings["bburl"].'/'.THIS_SCRIPT.'?action=edit&data_id='.$item['data_id'].'">
                    <img src="'.$mybb->settings['bburl'].'/images/liste/pencil.png" border="0">
                </a>
                <a class="icon" href="'.$mybb->settings["bburl"].'/'.THIS_SCRIPT.'?action=deleteItem&data_id='.$item['data_id'].'">
                    <img src="'.$mybb->settings['bburl'].'/images/liste/no.png" border="0">
                </a></td>';
        } else {
            $content .= '<td class="trow2"></td>';
        }
        $content .= '</tr>';
    }
            
    $content .= '<tr><td class="tcat" colspan="9">';
    $content .= '<span style="vertical-align:center; text-align:left; float:right;">
        <img src="'.$mybb->settings['bburl'].'/images/liste/pencil.png" border="0"> = '.$lang->edit.' 
        <img src="'.$mybb->settings['bburl'].'/images/liste/no.png" border="0"> = '.$lang->delete.'
        </span></td></tr></tbody></table>';
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
    global $db, $mybb, $lang, $theme, $templates, $headerinclude, $header, $footer;
    $lang->load("liste", false, true);
    
    if ($mybb->settings['showListOnlyForMembers']=='1' && $mybb->user['uid'] == 0) {
        error_no_permission();
    }
    
    if ($mybb->settings['show_list'] == '1') {
        
        // get/set the limit
        if ($mybb->input['action'] == "setLimit") {
            $cookieArray= unserialize($_COOKIE['mybbliste']);
            $limit = $cookieArray['displayLimit'] = $mybb->input['limit'];
            $time = 60 * 60 * 24 * 2;
            my_setcookie('mybb[liste]', serialize($cookieArray), $time, true);
        } else {
            $cookieArray= unserialize($_COOKIE['mybb[liste]']);
            $limit = $cookieArray['displayLimit'];
        }

        // decide what to do
        if ($mybb->input['action'] == 'editItem' && editItem()==true) {
            add_breadcrumb("{$mybb->settings["list_title"]}");
            $message = '<p class="validation_success">'.$lang->editItemSuccessful.'</p>';
            $content = showFullTable(null,false,$limit);
            
        } elseif ($mybb->input['action'] == 'edit') {
            add_breadcrumb("{$mybb->settings["list_title"]}",THIS_SCRIPT);
            add_breadcrumb($lang->editItem);
            $content = showEditDataForm();
            
        } elseif ($mybb->input['action'] == 'deleteItem') {
            add_breadcrumb("{$mybb->settings["list_title"]}",THIS_SCRIPT);
            if($mybb->input['step2']=='true' && deleteData()==true) {
                $message = '<p class="validation_success">'.$lang->deleteItemSuccessful.'</p>';
                $content = showFullTable(null,false,$limit);
            } else {
                add_breadcrumb($lang->deleteItem);
                $content = showDeleteConfirmDialog();
            }
            
        } elseif ($mybb->input['action'] == 'addItem') {
            add_breadcrumb("{$mybb->settings["list_title"]}",THIS_SCRIPT);
            if($mybb->input['step2']=='true' && insertNewData()==true) {
                $message = '<p class="validation_success">'.$lang->addItemSuccessful.'</p>';
                $content = showFullTable(null,false,$limit);
            } else {
                add_breadcrumb($lang->newItem);
                $content = showNewDataForm();
            }
            
        }  elseif ($mybb->input['action'] == "setTimestamp") {
            add_breadcrumb("{$mybb->settings["list_title"]}");
            $timestamp = mktime(0, 0, 0, $mybb->input['time_monat'], $mybb->input['time_tag'], $mybb->input['time_jahr']);
            $content = showFullTable($timestamp,true,$limit);
            
        } else {
            add_breadcrumb("{$mybb->settings["list_title"]}");
            $content = showFullTable(null,false,$limit);
        }
        
    } else {
        $content = '<div class="error low_warning"><p><em>' . $lang->followingErrors . '</em></p>';
        $content .= '<p><ul>';
        $content .= '<li>' . $lang->errorNoDisplay . '</li>';
        $content .= '</ul></p></div>';
    }
        
    eval("\$showList .= \"" . $templates->get("show_liste") . "\";");
    output_page($showList);
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
        "version" => "1.6.1",
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
