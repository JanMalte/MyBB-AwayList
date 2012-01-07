<?php

/**
 * @version     liste.php 2012-01-07
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Plugin
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// Disallow direct access to this file for security reasons
if (!defined("IN_MYBB")) {
    die("Direct initialization of this file is not allowed.<br />
        <br />Please make sure IN_MYBB is defined.");
}

/**
 * Collection of usefull functions for using dates and timestamps
 */
class ShowDates
{

    /**
     * show a SELECT element for days in a HTML form
     * @param string $fieldName Name of the field
     * @param string|integer $selectedDay (Optional) Set to the value of the day which should be selected
     * @return string HTML code of the SELECT element
     */
    public static function showDaySelect($fieldName, $selectedDay = null)
    {
        // if the selected day isn't given set it to the actual day
        if ($selectedDay == null)
            $selectedDay = date("d");

        // set the start HTML of the select form
        $htmlSelectForm = '<select name="' . $fieldName . '">';
        // do this 31 times, one for every day
        for ($i = 01; $i <= 31; $i++) {
            // convert this to a string with two numbers, e.g.: 04 instade of 4
            if ($i < 10) {
                $day = (string) "0" . $i;
            } else {
                $day = (string) $i;
            }
            // if the actual day is the same as the given day
            // set this day as selected
            $selected = '';
            if ($i == $selectedDay) {
                $selected .= 'selected="selected" ';
            }
            // add the option the the HTML select form
            $htmlSelectForm .= '<option ' . $selected . 'value="' . $day . '">' . $day;
        }
        // close the select form
        $htmlSelectForm .= "</select>";
        // returns the HTML of the select form
        return $htmlSelectForm;
    }

    /**
     * show a SELECT element for months in a HTML form
     * @param string $fieldName Name of the field
     * @param string|integer $selectedMonth (Optional) Set to the value of the month which should be selected
     * @return string HTML code of the SELECT element
     */
    public static function showMonthSelect($fieldName, $selectedMonth = null)
    {
        // if the selected month isn't given set it to the actual month
        if ($selectedMonth == null)
            $selectedMonth = date("m");

        // set the start HTML of the select form
        $htmlSelectForm = '<select name="' . $fieldName . '">';
        // do this 12 times, one for every month
        for ($i = 01; $i <= 12; $i++) {
            // convert this to a string with two numbers, e.g.: 04 instade of 4
            if ($i < 10) {
                $month = (string) "0" . $i;
            } else {
                $month = (string) $i;
            }
            // if the actual month is the same as the given month
            // set this month as selected
            $selected = '';
            if ($i == $selectedMonth) {
                $selected .= 'selected="selected" ';
            }
            // add the option the the HTML select form
            $htmlSelectForm .= '<option ' . $selected . 'value="' . $month . '">' . $month;
        }
        // close the select form
        $htmlSelectForm .= "</select>";
        // returns the HTML of the select form
        return $htmlSelectForm;
    }

    /**
     * show a SELECT element for years in a HTML form
     * @param string $fieldName Name of the field
     * @param string|integer $selectedYear (Optional) Set to the value of the year which should be selected
     * @param integer $offset (Optional) Offset for the list of years; negative values are allowed
     * @param integer $countItems (Optional) Number of items which should be shown
     * @return string HTML code of the SELECT element
     */
    public static function showYearSelect($fieldName, $selectedYear = null, $offset = -1, $countItems = 10)
    {
        // if the selected year isn't given set it to the actual year
        if ($selectedYear == null)
            $selectedYear = date("Y");

        // add the offset to the current year
        $startYear = date("Y") + $offset;
        // set the end year to $countItems later then the current year
        $endYear = date("Y") + $countItems;

        // set the start HTML of the select form
        $htmlSelectForm = '<select name="' . $fieldName . '">';
        // do this $countItems times
        for ($year = $startYear; $year <= $endYear; $year++) {
            // if the actual year is the same as the given year
            // set this year as selected
            $selected = '';
            if ($year == $selectedYear) {
                $selected .= 'selected="selected" ';
            }
            // add the option the the HTML select form
            $htmlSelectForm .= '<option ' . $selected . 'value="' . $year . '">' . $year;
        }
        // close the select form
        $htmlSelectForm .= "</select>";
        // returns the HTML of the select form
        return $htmlSelectForm;
    }

    /**
     *
     * @param integer $firstTimestamp The timestamp which should be higher then the second one
     * @param integer $secondTimestamp (Optional) The timestamp which should be compared to the first one
     * @return boolean true if the first value is higher then the second one
     */
    public static function checkFutureDate($firstTimestamp, $secondTimestamp = null)
    {
        // if the second date isn't set, set it to the current unix timestamp
        if ($secondTimestamp == null)
            $secondTimestamp = time();

        // check if the first date is after the second
        if ($firstTimestamp >= $secondTimestamp) {
            return true;
        }
        return false;
    }

}

/**
 * checks if the user is in one of the allowed usergroups
 * @param string $allowedUserGroups the allowed usergroups; seperated with ","(COMMA) e.g.: "4,10,2"
 * @return boolean true if user is in one of the allowed usergroups
 */
function isUserInGroup($allowedUserGroups = false)
{
    global $mybb;
    $allowedUserGroupsArray = $usergroups = array();

    // set the acces right to false as default
    $access = false;
    
    // explode the allowed usergroups to an array
    $allowedUserGroupsArray = explode(',', $allowedUserGroups);
    
    // explode the additional usergroups of the user to an array
    $usergroups = explode(',', $mybb->user['additionalgroups']);
    
    // Add the primary usergroup of the user the the usergroups
    $usergroups[] = $mybb->user['usergroup'];

    foreach ($allowedUserGroupsArray as $allowedUserGroup) {
        if(in_array($allowedUserGroup, $usergroups)) {
            $access = true;
        }
    }
    return $access;
}

/** * *******************************************************************
 *
 * main functions for this plugin
 *
 */

/**
 * shows the insert form for a new item
 * @return the html content
 */
function showNewItemForm()
{
    global $mybb, $lang;
    $lang->load("liste", false, true);

    $content = '
	<form action="' . $mybb->settings["bburl"] . '/' . THIS_SCRIPT . '" method="post">
            <input type="hidden" name="action" value="addItem" />
            <input type="hidden" name="step2" value="true" />
            <table border="0" cellspacing="1" cellpadding="4" class="tborder">
                <thead>
                    <tr>
                        <td class="thead" colspan="2">
                            <div><strong>' . $lang->addToList . '</strong><br /><div class="smalltext"></div></div>
                        </td>
                    </tr>
                </thead>
                <tbody style="" id="cat_1_e">
                    <tr>
                        <td class="trow1"><b>' . $lang->arrival . ':</b>*</td>
                        <td class="trow1">';
    $content .= ShowDates::showDaySelect("ankunft_tag");
    $content .= ShowDates::showMonthSelect("ankunft_monat");
    $content .= ShowDates::showYearSelect("ankunft_jahr");
    $content .= '
		  </td>
		</tr>
		<tr>
		  <td class="trow2"><b>' . $lang->departure . ':</b>*</td>
		  <td class="trow2">';
    $content .= ShowDates::showDaySelect("abflug_tag");
    $content .= ShowDates::showMonthSelect("abflug_monat");
    $content .= ShowDates::showYearSelect("abflug_jahr");
    $content .= '
		  </td>
		</tr>
		<tr>
		  <td class="trow1"><b>' . $lang->airline . ':</b>*</td>
		  <td class="trow1"><input type="text" name="airline" size="40" maxlength="20" /></td>
		</tr>
		<tr>
		  <td class="trow2"><b>' . $lang->place . ':</b>*</td>
		  <td class="trow2"><input type="text" name="place" size="40" maxlength="20" /></td>
		</tr>
		<tr>
		  <td class="trow1"><b>' . $lang->hotel . ':</b>*</td>
		  <td class="trow1"><input type="text" name="hotel" size="40" maxlength="20" /></td>
		</tr>
		<tr>
		  <td class="trow2"><b>' . $lang->phoneAt . ' ' . $mybb->settings["list_country"] . ':</b></td>
		  <td class="trow2"><input type="text" name="phone" size="25" maxlength="15" /></td>
		</tr>
		<tr>
		  <td class="trow1">* = ' . $lang->requiredFields . '</td>
		  <td class="trow1"><input type="submit" name="addItem" value="' . $lang->addToList . '"></td>
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
function showEditItemForm()
{
    global $db, $mybb, $lang, $templates;
    $lang->load("liste", false, true);

    $query = $db->simple_select("liste", '*', "data_id = '" . $mybb->input['data_id'] . "'");
    $item = $db->fetch_array($query);

    if ($item['uid'] != $mybb->user['uid'] && !isUserInGroup(4)) {
        $errors[] = $lang->errorNoPermission;
    }
    if ($mybb->input['data_id'] == '') {
        $errors[] = $lang->errorNoItemSelected;
    }

    // if any error occurred
    if (isset($errors)) {
        $showList = '';
        add_breadcrumb($lang->editItem);
        $content .= '<div class="error low_warning"><p><em>' . $lang->followingErrors . '</em></p>';
        $content .= '<p><ul>';
        foreach ($errors as $error) {
            $content .= '<li>' . $error . '</li>';
        }
        $content .= '</ul></p>';
        $content .= '<a href="javascript:history.back()">' . $lang->back . '</a></div>';
        eval("\$showList = \"" . $templates->get("show_liste") . "\";");
        output_page($showList);
        exit;
    }
    $content = '
	<form action="' . $mybb->settings["bburl"] . '/' . THIS_SCRIPT . '" method="post">
            <input type="hidden" name="action" value="editItem" />
            <input type="hidden" name="step2" value="true" />
            <input type="hidden" name="data_id" value="' . $item['data_id'] . '" />
            <table border="0" cellspacing="1" cellpadding="4" class="tborder">
                <thead>
                    <tr>
                        <td class="thead" colspan="2">
                            <div><strong>' . $lang->editItem . '</strong><br /><div class="smalltext"></div></div>
                        </td>
                    </tr>
                </thead>
                <tbody style="" id="cat_1_e">
                    <tr>
                        <td class="trow1"><b>' . $lang->arrival . ':</b>*</td>
                        <td class="trow1">';
    $content .= ShowDates::showDaySelect("ankunft_tag", date('d', $item['ankunft']));
    $content .= ShowDates::showMonthSelect("ankunft_monat", date('m', $item['ankunft']));
    $content .= ShowDates::showYearSelect("ankunft_jahr", date('Y', $item['ankunft']));
    $content .= '
		  </td>
		</tr>
		<tr>
		  <td class="trow2"><b>' . $lang->departure . ':</b>*</td>
		  <td class="trow2">';
    $content .= ShowDates::showDaySelect("abflug_tag", date('d', $item['abflug']));
    $content .= ShowDates::showMonthSelect("abflug_monat", date('m', $item['abflug']));
    $content .= ShowDates::showYearSelect("abflug_jahr", date('Y', $item['abflug']));
    $content .= '
		  </td>
		</tr>
		<tr>
		  <td class="trow1"><b>' . $lang->airline . ':</b>*</td>
		  <td class="trow1"><input type="text" name="airline" size="40" maxlength="20" value="' . $item['airline'] . '" /></td>
		</tr>
		<tr>
		  <td class="trow2"><b>' . $lang->place . ':</b>*</td>
		  <td class="trow2"><input type="text" name="place" size="40" maxlength="20" value="' . $item['ort'] . '" /></td>
		</tr>
		<tr>
		  <td class="trow1"><b>' . $lang->hotel . ':</b>*</td>
		  <td class="trow1"><input type="text" name="hotel" size="40" maxlength="20" value="' . $item['hotel'] . '" /></td>
		</tr>
		<tr>
		  <td class="trow2"><b>' . $lang->phoneAt . ' ' . $mybb->settings["list_country"] . ':</b></td>
		  <td class="trow2"><input type="text" name="phone" size="25" maxlength="15" value="' . $item['telefon'] . '" /></td>
		</tr>
		<tr>
		  <td class="trow1">* = ' . $lang->requiredFields . '</td>
		  <td class="trow1"><input type="submit" name="editItem" value="' . $lang->editItem . '"></td>
		</tr>
            </tbody>
	  </table>
	</form>';
    return $content;
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

    if ($item['uid'] != $mybb->user['uid'] && !isUserInGroup(4)) {
        $errors[] = $lang->errorNoPermission;
    }
    if ($mybb->input['data_id'] == '') {
        $errors[] = $lang->errorNoItemSelected;
    }

    // if any error occurred
    if (isset($errors)) {
        $showList = '';
        add_breadcrumb($lang->deleteItem);
        $content .= '<div class="error low_warning"><p><em>' . $lang->followingErrors . '</em></p>';
        $content .= '<p><ul>';
        foreach ($errors as $error) {
            $content .= '<li>' . $error . '</li>';
        }
        $content .= '</ul></p>';
        $content .= '<a href="javascript:history.back()">' . $lang->back . '</a></div>';
        eval("\$showList .= \"" . $templates->get("show_liste") . "\";");
        output_page($showList);
        exit;
    }
    $content = '
	<form action="' . $mybb->settings["bburl"] . '/' . THIS_SCRIPT . '" method="post">
            <input type="hidden" name="action" value="deleteItem" />
            <input type="hidden" name="step2" value="true" />
            <input type="hidden" name="data_id" value="' . $item['data_id'] . '" />
            <table border="0" cellspacing="1" cellpadding="4" class="tborder">
                <thead>
                    <tr>
                        <td class="thead" colspan="2">
                            <div><strong>' . $lang->deleteItem . '</strong><br /><div class="smalltext"></div></div>
                        </td>
                    </tr>
                </thead>
                <tbody style="" id="cat_1_e">
                    <tr>
                        <td class="trow1"><b>' . $lang->arrival . ':</b></td>
                        <td class="trow1">';
    $content .= date('d.m.Y', $item['ankunft']);
    $content .= '
		  </td>
		</tr>
		<tr>
		  <td class="trow2"><b>' . $lang->departure . ':</b></td>
		  <td class="trow2">';
    $content .= date('d.m.Y', $item['abflug']);
    $content .= '
		  </td>
		</tr>
		<tr>
		  <td class="trow1"><b>' . $lang->airline . ':</b></td>
		  <td class="trow1">' . $item['airline'] . '</td>
		</tr>
		<tr>
		  <td class="trow2"><b>' . $lang->place . ':</b></td>
		  <td class="trow2">' . $item['ort'] . '</td>
		</tr>
		<tr>
		  <td class="trow1"><b>' . $lang->hotel . ':</b></td>
		  <td class="trow1">' . $item['hotel'] . '</td>
		</tr>
		<tr>
		  <td class="trow2"><b>' . $lang->phoneAt . ' ' . $mybb->settings["list_country"] . ':</b></td>
		  <td class="trow2">' . $item['telefon'] . '</td>
		</tr>
		<tr>
		  <td class="trow1"></td>
		  <td class="trow1"><input type="submit" name="deleteItem" value="' . $lang->deleteItem . '"></td>
		</tr>
            </tbody>
	  </table>
	</form>';
    return $content;
}

/**
 * insert the new item
 * @return boolean if successful
 */
function insertNewItem()
{
    global $db, $mybb, $lang, $templates;
    $lang->load("liste", false, true);

    if ($mybb->input['airline'] == "")
        $errors[] = $lang->errorAirlineMissing;
    if ($mybb->input['place'] == "")
        $errors[] = $lang->errorMissingPlace;
    if ($mybb->input['hotel'] == "")
        $errors[] = $lang->errorMissingHotel;
    if (preg_match("/^[0-9[:space:]]*$/", $mybb->input['phone'], $number)) {
        unset($number);
    } else {
        $errors[] = $lang->errorInvalidPhoneNumber;
    }
    $arrival = mktime(0, 0, 0, $mybb->input['ankunft_monat'], $mybb->input['ankunft_tag'], $mybb->input['ankunft_jahr']);
    $departure = mktime(0, 0, 0, $mybb->input['abflug_monat'], $mybb->input['abflug_tag'], $mybb->input['abflug_jahr']);

    $check = true;
    $query = $db->simple_select("liste", "*", "uid = '{$mybb->user['uid']}' AND ( ( ankunft BETWEEN '$arrival' AND '$departure' ) OR ( abflug  BETWEEN '$arrival' AND '$departure' ) OR (ankunft >= $arrival AND abflug <= $departure) )");
    while ($db->fetch_array($query)) {
        $check = false;
    }
    if ($check == false)
        $errors[] = $lang->errorAlreadyAway;

    if (!ShowDates::checkFutureDate($arrival))
        $errors[] = $lang->errorArrivalNotInFuture;
    if (!ShowDates::checkFutureDate($departure))
        $errors[] = $lang->errorDepartureNotInFuture;
    if (!ShowDates::checkFutureDate($departure, $arrival))
        $errors[] = $lang->errorArrivalNotBeforeDeparture;

    // if any error occurred
    if (isset($errors)) {
        $showList = '';
        add_breadcrumb($lang->newItem);
        $content .= '<div class="error low_warning"><p><em>' . $lang->followingErrors . '</em></p>';
        $content .= '<p><ul>';
        foreach ($errors as $error) {
            $content .= '<li>' . $error . '</li>';
        }
        $content .= '</ul></p>';
        $content .= '<a href="javascript:history.back()">' . $lang->back . '</a></div>';
        eval("\$showList = \"" . $templates->get("show_liste") . "\";");
        output_page($showList);
        exit;
    }

    $insertData = array(
        'id' => '',
        'uid' => $mybb->user['uid'],
        'username' => $mybb->user['username'],
        'ankunft' => $db->escape_string($arrival),
        'abflug' => $db->escape_string($departure),
        'airline' => $db->escape_string($mybb->input['airline']),
        'ort' => $db->escape_string($mybb->input['place']),
        'hotel' => $db->escape_string($mybb->input['hotel']),
        'telefon' => $db->escape_string($mybb->input['phone']),
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
    global $db, $mybb, $lang, $templates;
    $lang->load("liste", false, true);

    if ($mybb->input['airline'] == "")
        $errors[] = $lang->errorAirlineMissing;
    if ($mybb->input['place'] == "")
        $errors[] = $lang->errorMissingPlace;
    if ($mybb->input['hotel'] == "")
        $errors[] = $lang->errorMissingHotel;
    if (preg_match("/^[0-9[:space:]]*$/", $mybb->input['phone'], $number)) {
        unset($number);
    } else {
        $errors[] = $lang->errorInvalidPhoneNumber;
    }
    $arrival = mktime(0, 0, 0, $mybb->input['ankunft_monat'], $mybb->input['ankunft_tag'], $mybb->input['ankunft_jahr']);
    $departure = mktime(0, 0, 0, $mybb->input['abflug_monat'], $mybb->input['abflug_tag'], $mybb->input['abflug_jahr']);

    $check = true;
    $query = $db->simple_select("liste", "*", "uid = '{$mybb->user['uid']}' AND ( ( ankunft BETWEEN '$arrival' AND '$departure' ) OR ( abflug  BETWEEN '$arrival' AND '$departure' ) OR (ankunft >= $arrival AND abflug <= $departure) )");
    while ($result = $db->fetch_array($query)) {
        if ($result['data_id'] != $mybb->input['data_id'])
            $check = false;
    }
    if ($check == false)
        $errors[] = $lang->errorAlreadyAway;

    #if (!ShowDates::checkFutureDate($arrival))
    #    $errors[] = $lang->errorArrivalNotInFuture;
    if (!ShowDates::checkFutureDate($departure))
        $errors[] = $lang->errorDepartureNotInFuture;
    if (!ShowDates::checkFutureDate($departure, $arrival))
        $errors[] = $lang->errorArrivalNotBeforeDeparture;

    // if any error occurred
    if (isset($errors)) {
        $showList = '';
        add_breadcrumb($lang->editItem);
        $content .= '<div class="error low_warning"><p><em>' . $lang->followingErrors . '</em></p>';
        $content .= '<p><ul>';
        foreach ($errors as $error) {
            $content .= '<li>' . $error . '</li>';
        }
        $content .= '</ul></p>';
        $content .= '<a href="javascript:history.back()">' . $lang->back . '</a></div>';
        eval("\$showList = \"" . $templates->get("show_liste") . "\";");
        output_page($showList);
        exit;
    }

    $insertData = array(
        'ankunft' => $db->escape_string($arrival),
        'abflug' => $db->escape_string($departure),
        'airline' => $db->escape_string($mybb->input['airline']),
        'ort' => $db->escape_string($mybb->input['place']),
        'hotel' => $db->escape_string($mybb->input['hotel']),
        'telefon' => $db->escape_string($mybb->input['phone']),
    );
    $db->update_query('liste', $insertData, "data_id = '{$mybb->input['data_id']}'");

    return true;
}

/**
 * delete the item
 * @return boolean if successful
 */
function deleteItem()
{
    global $db, $mybb, $lang, $templates;
    $lang->load("liste", false, true);

    $query = $db->simple_select("liste", '*', "data_id = '" . $mybb->input['data_id'] . "'");
    $item = $db->fetch_array($query);

    if ($item['uid'] != $mybb->user['uid'] && !isUserInGroup(4)) {
        $errors[] = $lang->errorNoPermission;
    }
    if ($mybb->input['data_id'] == '') {
        $errors[] = $lang->errorNoItemSelected;
    }

    // if any error occurred
    if (isset($errors)) {
        $showList = '';
        add_breadcrumb($lang->deleteItem);
        $content .= '<div class="error low_warning"><p><em>' . $lang->followingErrors . '</em></p>';
        $content .= '<p><ul>';
        foreach ($errors as $error) {
            $content .= '<li>' . $error . '</li>';
        }
        $content .= '</ul></p>';
        $content .= '<a href="javascript:history.back()">' . $lang->back . '</a></div>';
        eval("\$showList = \"" . $templates->get("show_liste") . "\";");
        output_page($showList);
        exit;
    }

    $db->delete_query("liste", "data_id='{$mybb->input['data_id']}'");
    return true;
}

/**
 * delete the items of the user which is being deleted
 */
function ListDeleteUserHook()
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
    global $db, $mybb, $lang, $templates;
    $lang->load("liste", false, true);

    // limit of displayed items
    if ($limit < 1) {
        $limit = 20;
    }

    if ($timestamp == null) {
        $timestamp = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
    }

    if ($useTimestamp == true) {
        $queryItems = $db->simple_select('liste', '*', $timestamp . ' BETWEEN ankunft AND abflug', array('order_by' => 'ankunft', 'limit_start' => $startLimit, 'limit' => $limit)
        );
        $timeStampNotice = '<tr><td class="tcat" colspan="9"><strong>' . $lang->personsCurrentlyThere .
            date(" d.m.Y ", $timestamp) . $lang->in . ' ' . $mybb->settings["list_country"] . '</strong></td></tr>';
    } else {
        $queryItems = $db->simple_select('liste', '*', 'abflug > ' . $timestamp, array('order_by' => 'ankunft', 'limit_start' => $startLimit, 'limit' => $limit)
        );
        $timeStampNotice = '';
    }

    $countUsers = $db->num_rows($queryItems);
    $arrayItems = array();
    while ($item = $db->fetch_array($queryItems)) {
        $arrayItems[$item['data_id']] = $item;
    }

    $currentUrl = $mybb->settings['bburl'] . '/' . THIS_SCRIPT;
    $selectDateForm = ShowDates::showDaySelect("time_tag", date("d", $timestamp));
    $selectDateForm .= ShowDates::showMonthSelect("time_monat", date("m", $timestamp));
    $selectDateForm .= ShowDates::showYearSelect("time_jahr", date("Y", $timestamp));
    $addItemUrl = $mybb->settings['bburl'] . '/show_list.php?action=addItem';

    foreach ($arrayItems as $item) {
        $count++;
        $userlink = '<a href="' . get_profile_link($item['uid']) . '">' . $item['username'] . '</a>';

        $currentDate = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        if (($item['ankunft'] < $currentDate) && ($item['abflug'] > $currentDate)) {
            $status = '<img src="' . $mybb->settings['bburl'] . '/images/liste/vor_ort.png" border="0">';
        } elseif ($item['abflug'] == $currentDate) {
            $status = '<img src="' . $mybb->settings['bburl'] . '/images/liste/rueckflug.png" border="0">';
        } elseif ($item['ankunft'] == $currentDate) {
            $status = '<img src="' . $mybb->settings['bburl'] . '/images/liste/hinflug.png" border="0">';
        } else {
            $status = '<img src="' . $mybb->settings['bburl'] . '/images/liste/daheim.png" border="0">';
        }

        $arrival = date("d.m.Y", $item['ankunft']);
        $departure = date("d.m.Y", $item['abflug']);
        $airline = $item['airline'];
        $place = $item['ort'];
        $hotel = $item['hotel'];
        $phone = $item['telefon'];
        if ((isUserInGroup(4)) OR ($item['uid'] == $mybb->user['uid'])) {
            $actions = '
                <a class="icon" href="' . $mybb->settings["bburl"] . '/' . THIS_SCRIPT . '?action=editItem&data_id=' . $item['data_id'] . '">
                    <img src="' . $mybb->settings['bburl'] . '/images/liste/pencil.png" border="0">
                </a>
                <a class="icon" href="' . $mybb->settings["bburl"] . '/' . THIS_SCRIPT . '?action=deleteItem&data_id=' . $item['data_id'] . '">
                    <img src="' . $mybb->settings['bburl'] . '/images/liste/no.png" border="0">
                </a>';
        } else {
            $actions = '';
        }

        eval("\$tableItems .= \"" . $templates->get("show_list_table_bit") . "\";");
    }

    eval("\$content .= \"" . $templates->get("show_list_table") . "\";");

    return $content;
}

/** * *******************************************************************
 *
 * main functions for displaying
 *
 */
function showListOnIndex()
{
    global $db, $mybb, $lang, $templates, $liste;
    $lang->load("liste", false, true);

    $liste = '';
    if ($mybb->user['uid'] != 0) {
        if ($mybb->settings['show_list_on_index'] == '1') {
            $liste = getContent();
        }
    }
}

function showList()
{
    global $db, $mybb, $lang, $theme, $templates, $headerinclude, $header, $footer;
    $lang->load("liste", false, true);
    $showList = '';

    if ($mybb->settings['showListOnlyForMembers'] == '1' && $mybb->user['uid'] == 0) {
        error_no_permission();
    }

    $content = getContent();

    eval("\$showList = \"" . $templates->get("show_liste") . "\";");
    output_page($showList);
}

function getContent()
{
    global $db, $mybb, $lang;
    $lang->load("liste", false, true);

    if ($mybb->settings['showListOnlyForMembers'] == '1' && $mybb->user['uid'] == 0) {
        error_no_permission();
    }

    if ($mybb->settings['show_list'] == '1') {

        // get/set the limit
        if ($mybb->input['action'] == "setLimit") {
            $cookieArray = unserialize($_COOKIE['mybbliste']);
            $limit = $cookieArray['displayLimit'] = $mybb->input['limit'];
            $time = 60 * 60 * 24 * 2;
            my_setcookie('mybb[liste]', serialize($cookieArray), $time, true);
        } else {
            $cookieArray = unserialize($_COOKIE['mybb[liste]']);
            $limit = $cookieArray['displayLimit'];
        }

        // decide what to do
        if ($mybb->input['action'] == 'editItem') {
            add_breadcrumb("{$mybb->settings["list_title"]}", THIS_SCRIPT);
            if ($mybb->input['step2'] == 'true' && editItem() == true) {
                $message = '<p class="validation_success">' . $lang->editItemSuccessful . '</p>';
                $content = showFullTable(null, false, $limit);
            } else {
                add_breadcrumb($lang->editItem);
                $content = showEditItemForm();
            }
        } elseif ($mybb->input['action'] == 'deleteItem') {
            add_breadcrumb("{$mybb->settings["list_title"]}", THIS_SCRIPT);
            if ($mybb->input['step2'] == 'true' && deleteItem() == true) {
                $message = '<p class="validation_success">' . $lang->deleteItemSuccessful . '</p>';
                $content = showFullTable(null, false, $limit);
            } else {
                add_breadcrumb($lang->deleteItem);
                $content = showDeleteConfirmDialog();
            }
        } elseif ($mybb->input['action'] == 'addItem') {
            add_breadcrumb("{$mybb->settings["list_title"]}", THIS_SCRIPT);
            if ($mybb->input['step2'] == 'true' && insertNewItem() == true) {
                $message = '<p class="validation_success">' . $lang->addItemSuccessful . '</p>';
                $content = showFullTable(null, false, $limit);
            } else {
                add_breadcrumb($lang->newItem);
                $content = showNewItemForm();
            }
        } elseif ($mybb->input['action'] == "setTimestamp") {
            add_breadcrumb("{$mybb->settings["list_title"]}");
            $timestamp = mktime(0, 0, 0, $mybb->input['time_monat'], $mybb->input['time_tag'], $mybb->input['time_jahr']);
            $content = showFullTable($timestamp, true, $limit);
        } else {
            add_breadcrumb("{$mybb->settings["list_title"]}");
            $content = showFullTable(null, false, $limit);
        }
    } else {
        $content = '<div class="error low_warning"><p><em>' . $lang->followingErrors . '</em></p>';
        $content .= '<p><ul>';
        $content .= '<li>' . $lang->errorNoDisplay . '</li>';
        $content .= '</ul></p></div>';
    }

    return $message . $content . '<br />';
}

/** * *******************************************************************
 * ADDITIONAL PLUGIN INSTALL/UNINSTALL ROUTINES
 *
 * _install():
 *   Called whenever a plugin is installed by clicking the "Install" button in the plugin manager.
 *   If no install routine exists, the install button is not shown and it assumed any work will be
 *   performed in the _activate() routine.
 *
 * function hello_install()
 * {
 * }
 *
 * _is_installed():
 *   Called on the plugin management page to establish if a plugin is already installed or not.
 *   This should return TRUE if the plugin is installed (by checking tables, fields etc) or FALSE
 *   if the plugin is not installed.
 *
 * function hello_is_installed()
 * {
 *      global $db;
 *      if($db->table_exists("hello_world"))
 *      {
 *          return true;
 *      }
 *      return false;
 * }
 *
 * _uninstall():
 *    Called whenever a plugin is to be uninstalled. This should remove ALL traces of the plugin
 *    from the installation (tables etc). If it does not exist, uninstall button is not shown.
 *
 * function hello_uninstall()
 * {
 * }
 *
 * _activate():
 *    Called whenever a plugin is activated via the Admin CP. This should essentially make a plugin
 *    "visible" by adding templates/template changes, language changes etc.
 *
 * function hello_activate()
 * {
 * }
 *
 * _deactivate():
 *    Called whenever a plugin is deactivated. This should essentially "hide" the plugin from view
 *    by removing templates/template changes etc. It should not, however, remove any information
 *    such as tables, fields etc - that should be handled by an _uninstall routine. When a plugin is
 *    uninstalled, this routine will also be called before _uninstall() if the plugin is active.
 *
 * function hello_deactivate()
 * {
 * }
 */
$plugins->add_hook("index_start", "showListOnIndex");
$plugins->add_hook("admin_users_do_delete", "ListDeleteUserHook");

function liste_info()
{
    return array(
        "name" => "Aufenthaltsliste",
        "description" => "Zeigt wann wer in einem bestimmten Land ist",
        "website" => "http://www.malte-gerth.de/mybb.html",
        "author" => "Jan Malte Gerth",
        "authorsite" => "http://www.malte-gerth.de/",
        "version" => "1.6.3",
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
		{\$content}
		{\$footer}
	</body>
</html>",
        "sid" => "-1",
    );
    $db->insert_query("templates", $templateShowListe);

    $templateShowListTable = array(
        "tid" => "NULL",
        "title" => "show_list_table",
        "template" => $db->escape_string('<table border="0" cellspacing="1" cellpadding="4" class="tborder">
    <thead>
        <tr>
            <td class="thead" colspan="9">
                <form action="{$currentUrl}" method="post" style="vertical-align:center; text-align:left; float:left; width:50%;">
                    <input type="hidden" name="action" value="setLimit" />
                    <strong>{$lang->showOnly} <input type="text" name="limit" value="{$limit}" /> {$lang->entries}</strong>
                    <input type="submit" name="setLimit" value="{$lang->show}" style="display:inline;"/>
                </form>
                <form action="{$currentUrl}" method="post" style="vertical-align:center; text-align:right; float:left; width:50%;">
                    <input type="hidden" name="action" value="setTimestamp" />
                    <strong>{$lang->whoIsAt} {$selectDateForm} {$lang->in} {$mybb->settings[\'list_country\']}?</strong>
                    <input type="submit" name="setTimestamp" value="{$lang->show}" />
                </form>
            </td>
        </tr>
    </thead>
</table>
<table border="0" cellspacing="1" cellpadding="4" class="tborder">
    <thead>
        <tr>
            <td class="thead" colspan="9">
                <div class="expcolimage"><img src="{$mybb->settings[\'bburl\']}/{$theme[\'imgdir\']}/collapse.gif" id="liste_1_img" class="expander" alt="[-]" /></div>
                <span style="vertical-align:center; text-align:right; float:left;">
                    <strong>
                        <a href="{$addItemUrl}" style="vertical-align: top;">
                            <img src="{$mybb->settings[\'bburl\']}/images/liste/viewmag+.png" border="0" valign="center"> {$lang->addToList}
                        </a>
                    </strong>
                </span>
            </td>
        </tr>
    </thead>
    <tbody style="" id="liste_1_e">
    {$timeStampNotice}
    <tr>
        <td class="tcat" width="15%" align="center"><strong>{$lang->name}</strong></td>
        <td class="tcat" width="5%" align="center"><strong>{$lang->status}</strong></td>
        <td class="tcat" width="5%" align="center"><strong>{$lang->arrival}</strong></td>
        <td class="tcat" width="5%" align="center"><strong>{$lang->departure}</strong></td>
        <td class="tcat" width="15%" align="center"><strong>{$lang->airline}</strong></td>
        <td class="tcat" width="15%" align="center"><strong>{$lang->place}</strong></td>
        <td class="tcat" width="15%" align="center"><strong>{$lang->hotel}</strong></td>
        <td class="tcat" width="15%" align="center"><strong>{$lang->phoneAt} {$mybb->settings[\'list_country\']}</strong></td>
        <td class="tcat" width="2%" align="center"><strong>{$lang->action}</strong></td>
    </tr>
    {$tableItems}
    <tr>
        <td class="tcat" colspan="9">
            <span style="vertical-align:center; text-align:left; float:right;">
                <img src="{$mybb->settings[\'bburl\']}/images/liste/pencil.png" border="0"> = {$lang->edit}
                <img src="{$mybb->settings[\'bburl\']}/images/liste/no.png" border="0"> = {$lang->delete}
            </span>
        </td>
    </tr>
</tbody>
</table>'),
        "sid" => "-1",
    );
    $db->insert_query("templates", $templateShowListTable);

    $templateShowListTableBit = array(
        "tid" => "NULL",
        "title" => "show_list_table_bit",
        "template" => $db->escape_string('<tr>
    <td class="trow1">{$userlink}</td>
    <td class="trow1">{$status}</td>
    <td class="trow1" style="white-space: nowrap;">{$arrival}</td>
    <td class="trow1" style="white-space: nowrap;">{$departure}</td>
    <td class="trow1">{$airline}</td>
    <td class="trow1">{$place}</td>
    <td class="trow1">{$hotel}</td>
    <td class="trow1">{$phone}</td>
    <td class="trow1">{$actions}</td>
</tr>'),
        "sid" => "-1",
    );
    $db->insert_query("templates", $templateShowListTableBit);

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
    $settingsGroup = array(
        "gid" => "NULL",
        "name" => "liste",
        "title" => "Aufenthaltsliste",
        "description" => "Aufenthaltsliste, wer ist wann wo in Thailand",
        "disporder" => "1",
        "isdefault" => "no"
    );
    $db->insert_query("settinggroups", $settingsGroup);
    $gid = $db->insert_id();

    $settingsData = array(
        "sid" => "NULL",
        "name" => "show_list",
        "title" => "Anzeige der Liste",
        "description" => "Soll die Liste angezeigt werden?",
        "optionscode" => "yesno",
        "value" => "1",
        "disporder" => "10",
        "gid" => intval($gid)
    );
    $db->insert_query("settings", $settingsData);

    $settingsData = array(
        "sid" => "NULL",
        "name" => "keep_list",
        "title" => "Informationen behalten",
        "description" => "Sollen die gespeicherten Informationen der Aufenthalte
            beim Deaktivieren des Plugins erhalten bleiben?",
        "optionscode" => "yesno",
        "value" => "1",
        "disporder" => "20",
        "gid" => intval($gid)
    );
    $db->insert_query("settings", $settingsData);

    $settingOnlyVisibleForMembers = array(
        "sid" => "NULL",
        "name" => "showListOnlyForMembers",
        "title" => "Liste nur für Mitglieder anzeigen",
        "description" => "Soll die Liste nur für Mitglieder sichtbar sein?",
        "optionscode" => "yesno",
        "value" => "1",
        "disporder" => "30",
        "gid" => intval($gid)
    );
    $db->insert_query("settings", $settingOnlyVisibleForMembers);

    $settingsData = array(
        "sid" => "NULL",
        "name" => "show_list_on_index",
        "title" => "Auf der Startseite anzeigen",
        "description" => "Soll die Liste auf der Startseite angezeigt werden?",
        "optionscode" => "yesno",
        "value" => "0",
        "disporder" => "40",
        "gid" => intval($gid)
    );
    $db->insert_query("settings", $settingsData);

    $settingsData = array(
        "sid" => "NULL",
        "name" => "list_country",
        "title" => "Name des Landes",
        "description" => "Für welches Land gilt die Tabelle?",
        "optionscode" => "text",
        "value" => "Thailand",
        "disporder" => "50",
        "gid" => intval($gid)
    );
    $db->insert_query("settings", $settingsData);

    $settingsData = array(
        "sid" => "NULL",
        "name" => "list_title",
        "title" => "Titel des Plugins",
        "description" => "Welcher Titel soll angezeigt werden?",
        "optionscode" => "text",
        "value" => "Wer ist wann in Thailand",
        "disporder" => "60",
        "gid" => intval($gid)
    );
    $db->insert_query("settings", $settingsData);

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
    $db->delete_query("settings", "name IN(
        'list_title','list_country','show_list_on_index','keep_list','show_list'
        )");
    $db->delete_query("settinggroups", "name='liste'");

    rebuild_settings();

    /*
     * remove plugin templates
     */
    $db->delete_query("templates", "title IN(
        'show_liste','show_liste_bit','show_list_table_bit','show_list_table'
        )");
}

function liste_activate()
{
    require_once MYBB_ROOT . "/inc/adminfunctions_templates.php";

    find_replace_templatesets("index", '#{\$header}(\r?)(\n?)#', "{\$header}\r\n{\$liste}\r\n");

    find_replace_templatesets("header", '#toplinks_help}</a></li>#', "$0\n<li class=\"list_link\"><a href=\"{\$mybb->settings['bburl']}/show_list.php\">
            <img src=\"{\$mybb->settings[bburl]}/images/liste/list.png\" border=\"0\" alt=\"\" />Aufenthaltsliste</a></li>");

    rebuild_settings();
}

function liste_deactivate()
{
    require_once MYBB_ROOT . "/inc/adminfunctions_templates.php";

    find_replace_templatesets("index", '#(\r?)(\n?){\$liste}(\r?)(\n?)#', "\r\n", 0);

    find_replace_templatesets("header", '#(\n?)<li class="list_link">(.*)</li>#', '', 0);

    rebuild_settings();
}
