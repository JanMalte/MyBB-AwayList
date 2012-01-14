<?php

/**
 * @version     liste.php 2012-01-08
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Plugin
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 */
// Disallow direct access to this file for security reasons
if (!defined("IN_MYBB")) {
    die("Direct initialization of this file is not allowed.<br />
        <br />Please make sure IN_MYBB is defined.");
}

// as this is a often used class in plugins
// check if it isn't already defined
if (!class_exists('ShowDates')) {

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
                $day = (string) $i;
                // convert this to a string with two numbers, e.g.: 04 instade of 4
                if ($i < 10) {
                    $day = (string) "0" . $i;
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
                $month = (string) $i;
                // convert this to a string with two numbers, e.g.: 04 instade of 4
                if ($i < 10) {
                    $month = (string) "0" . $i;
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

    }

}

// as this is a often used function in plugins
// check if it isn't already defined
if (!function_exists('isUserInGroup')) {

    /**
     * checks if the user is in one of the allowed usergroups
     * @param string $allowedGroups the allowed usergroups; seperated with ","(COMMA) e.g.: "4,10,2"
     * @return boolean true if user is in one of the allowed usergroups
     */
    function isUserInGroup($allowedGroups = false)
    {
        global $mybb;

        // set to false as default
        $isInGroup = false;

        // explode the allowed usergroups to an array
        $allowedUserGroups = explode(',', $allowedGroups);

        // explode the additional usergroups of the user to an array
        $usergroups = explode(',', $mybb->user['additionalgroups']);

        // Add the primary usergroup of the user the the usergroups
        $usergroups[] = $mybb->user['usergroup'];

        // check if the user is in any of the allowed usergroups
        foreach ($allowedUserGroups as $allowedUserGroup) {
            if (in_array($allowedUserGroup, $usergroups)) {
                $isInGroup = true;
            }
        }
        return $isInGroup;
    }

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
function awaylist_showNewItemForm()
{
    global $mybb, $lang;
    $lang->load("awaylist", false, true);

    $content = '
	<form action="' . $mybb->settings["bburl"] . '/' . THIS_SCRIPT . '" method="post">
            <input type="hidden" name="action" value="addAwlItem" />
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
    $content .= ShowDates::showDaySelect("arrival_tag");
    $content .= ShowDates::showMonthSelect("arrival_monat");
    $content .= ShowDates::showYearSelect("arrival_jahr");
    $content .= '
		  </td>
		</tr>
		<tr>
		  <td class="trow2"><b>' . $lang->departure . ':</b>*</td>
		  <td class="trow2">';
    $content .= ShowDates::showDaySelect("departure_tag");
    $content .= ShowDates::showMonthSelect("departure_monat");
    $content .= ShowDates::showYearSelect("departure_jahr");
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
		  <td class="trow2"><b>' . $lang->phoneAt . ' ' . $mybb->settings["awayListCountry"] . ':</b></td>
		  <td class="trow2"><input type="text" name="phone" size="25" maxlength="15" /></td>
		</tr>
		<tr>
		  <td class="trow1">* = ' . $lang->requiredFields . '</td>
		  <td class="trow1"><input type="submit" name="addAwlItem" value="' . $lang->addToList . '"></td>
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
function awaylist_showEditItemForm()
{
    global $db, $mybb, $lang, $templates;
    $lang->load("awaylist", false, true);

    $query = $db->simple_select("awaylist", '*', "id = '" . $mybb->input['id'] . "'");
    $item = $db->fetch_array($query);

    $errors = array();
    if ($item['uid'] != $mybb->user['uid'] && !isUserInGroup(4)) {
        $errors[] = $lang->errorNoPermission;
    }
    if ($mybb->input['id'] == '') {
        $errors[] = $lang->errorNoItemSelected;
    }

    // if any error occurred
    if (!empty($errors)) {
        $showList = '';
        add_breadcrumb($lang->editItem);
        $content .= '<div class="error low_warning"><p><em>' . $lang->followingErrors . '</em></p>';
        $content .= '<p><ul>';
        foreach ($errors as $error) {
            $content .= '<li>' . $error . '</li>';
        }
        $content .= '</ul></p>';
        $content .= '<a href="javascript:history.back()">' . $lang->back . '</a></div>';
        eval("\$showList = \"" . $templates->get("show_awaylist") . "\";");
        output_page($showList);
        exit;
    }
    $content = '
	<form action="' . $mybb->settings["bburl"] . '/' . THIS_SCRIPT . '" method="post">
            <input type="hidden" name="action" value="editAwlItem" />
            <input type="hidden" name="step2" value="true" />
            <input type="hidden" name="id" value="' . $item['id'] . '" />
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
    $content .= ShowDates::showDaySelect("arrival_tag", date('d', $item['arrival']));
    $content .= ShowDates::showMonthSelect("arrival_monat", date('m', $item['arrival']));
    $content .= ShowDates::showYearSelect("arrival_jahr", date('Y', $item['arrival']));
    $content .= '
		  </td>
		</tr>
		<tr>
		  <td class="trow2"><b>' . $lang->departure . ':</b>*</td>
		  <td class="trow2">';
    $content .= ShowDates::showDaySelect("departure_tag", date('d', $item['departure']));
    $content .= ShowDates::showMonthSelect("departure_monat", date('m', $item['departure']));
    $content .= ShowDates::showYearSelect("departure_jahr", date('Y', $item['departure']));
    $content .= '
		  </td>
		</tr>
		<tr>
		  <td class="trow1"><b>' . $lang->airline . ':</b>*</td>
		  <td class="trow1"><input type="text" name="airline" size="40" maxlength="20" value="' . $item['airline'] . '" /></td>
		</tr>
		<tr>
		  <td class="trow2"><b>' . $lang->place . ':</b>*</td>
		  <td class="trow2"><input type="text" name="place" size="40" maxlength="20" value="' . $item['place'] . '" /></td>
		</tr>
		<tr>
		  <td class="trow1"><b>' . $lang->hotel . ':</b>*</td>
		  <td class="trow1"><input type="text" name="hotel" size="40" maxlength="20" value="' . $item['hotel'] . '" /></td>
		</tr>
		<tr>
		  <td class="trow2"><b>' . $lang->phoneAt . ' ' . $mybb->settings["awayListCountry"] . ':</b></td>
		  <td class="trow2"><input type="text" name="phone" size="25" maxlength="15" value="' . $item['phone'] . '" /></td>
		</tr>
		<tr>
		  <td class="trow1">* = ' . $lang->requiredFields . '</td>
		  <td class="trow1"><input type="submit" name="editAwlItem" value="' . $lang->editItem . '"></td>
		</tr>
            </tbody>
	  </table>
	</form>';
    return $content;
}

/**
 * @return the html message
 */
function awaylist_showDeleteConfirmDialog()
{
    global $db, $mybb, $lang, $templates;
    $lang->load("awaylist", false, true);

    $query = $db->simple_select("awaylist", '*', "id = '" . $mybb->input['id'] . "'");
    $item = $db->fetch_array($query);

    $errors = array();
    if ($item['uid'] != $mybb->user['uid'] && !isUserInGroup(4)) {
        $errors[] = $lang->errorNoPermission;
    }
    if ($mybb->input['id'] == '') {
        $errors[] = $lang->errorNoItemSelected;
    }

    // if any error occurred
    if (!empty($errors)) {
        $showList = '';
        add_breadcrumb($lang->deleteItem);
        $content .= '<div class="error low_warning"><p><em>' . $lang->followingErrors . '</em></p>';
        $content .= '<p><ul>';
        foreach ($errors as $error) {
            $content .= '<li>' . $error . '</li>';
        }
        $content .= '</ul></p>';
        $content .= '<a href="javascript:history.back()">' . $lang->back . '</a></div>';
        eval("\$showList .= \"" . $templates->get("show_awaylist") . "\";");
        output_page($showList);
        exit;
    }
    $content = '
	<form action="' . $mybb->settings["bburl"] . '/' . THIS_SCRIPT . '" method="post">
            <input type="hidden" name="action" value="deleteAwlItem" />
            <input type="hidden" name="step2" value="true" />
            <input type="hidden" name="id" value="' . $item['id'] . '" />
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
    $content .= date('d.m.Y', $item['arrival']);
    $content .= '
		  </td>
		</tr>
		<tr>
		  <td class="trow2"><b>' . $lang->departure . ':</b></td>
		  <td class="trow2">';
    $content .= date('d.m.Y', $item['departure']);
    $content .= '
		  </td>
		</tr>
		<tr>
		  <td class="trow1"><b>' . $lang->airline . ':</b></td>
		  <td class="trow1">' . $item['airline'] . '</td>
		</tr>
		<tr>
		  <td class="trow2"><b>' . $lang->place . ':</b></td>
		  <td class="trow2">' . $item['place'] . '</td>
		</tr>
		<tr>
		  <td class="trow1"><b>' . $lang->hotel . ':</b></td>
		  <td class="trow1">' . $item['hotel'] . '</td>
		</tr>
		<tr>
		  <td class="trow2"><b>' . $lang->phoneAt . ' ' . $mybb->settings["awayListCountry"] . ':</b></td>
		  <td class="trow2">' . $item['phone'] . '</td>
		</tr>
		<tr>
		  <td class="trow1"></td>
		  <td class="trow1"><input type="submit" name="deleteAwlItem" value="' . $lang->deleteItem . '"></td>
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
function awaylist_insertNewItem(&$message = '')
{
    global $db, $mybb;

    $errors = array();
    if (awaylist_validateItem($errors) == true) {
        $arrival = mktime(0, 0, 0, $mybb->input['arrival_monat'], $mybb->input['arrival_tag'], $mybb->input['arrival_jahr']);
        $departure = mktime(0, 0, 0, $mybb->input['departure_monat'], $mybb->input['departure_tag'], $mybb->input['departure_jahr']);
        $insertData = array(
            'id' => '',
            'uid' => $mybb->user['uid'],
            'username' => $mybb->user['username'],
            'arrival' => $db->escape_string($arrival),
            'departure' => $db->escape_string($departure),
            'airline' => $db->escape_string($mybb->input['airline']),
            'place' => $db->escape_string($mybb->input['place']),
            'hotel' => $db->escape_string($mybb->input['hotel']),
            'phone' => $db->escape_string($mybb->input['phone']),
            'id' => '',
            'sort_id' => ''
        );
        $db->insert_query('awaylist', $insertData);
        return true;
    } else {
        $message = awaylist_getHtmlErrorMessage($errors);
        return false;
    }
    return false;
}

/**
 * update the item
 * @return boolean if successful
 */
function awaylist_editItem(&$message = '')
{
    global $db, $mybb;

    $errors = array();
    if (awaylist_validateItem($errors, $mybb->input['id']) == true) {
        $arrival = mktime(0, 0, 0, $mybb->input['arrival_monat'], $mybb->input['arrival_tag'], $mybb->input['arrival_jahr']);
        $departure = mktime(0, 0, 0, $mybb->input['departure_monat'], $mybb->input['departure_tag'], $mybb->input['departure_jahr']);
        $insertData = array(
            'arrival' => $db->escape_string($arrival),
            'departure' => $db->escape_string($departure),
            'airline' => $db->escape_string($mybb->input['airline']),
            'place' => $db->escape_string($mybb->input['place']),
            'hotel' => $db->escape_string($mybb->input['hotel']),
            'phone' => $db->escape_string($mybb->input['phone']),
        );
        $db->update_query('awaylist', $insertData, "id = '{$mybb->input['id']}'");
        return true;
    } else {
        $message = awaylist_getHtmlErrorMessage($errors);
        return false;
    }
    return false;
}

/**
 * delete the item
 * @return boolean if successful
 */
function awaylist_deleteItem()
{
    global $db, $mybb, $lang, $templates;
    $lang->load("awaylist", false, true);

    $query = $db->simple_select("awaylist", '*', "id = '" . $mybb->input['id'] . "'");
    $item = $db->fetch_array($query);

    $errors = array();
    if ($item['uid'] != $mybb->user['uid'] && !isUserInGroup(4)) {
        $errors[] = $lang->errorNoPermission;
    }
    if ($mybb->input['id'] == '') {
        $errors[] = $lang->errorNoItemSelected;
    }

    // if any error occurred
    if (!empty($errors)) {
        $showList = '';
        // variables used in the template
        global $header, $headerinclude, $footer;
        add_breadcrumb($lang->deleteItem);
        $content .= '<div class="error low_warning"><p><em>' . $lang->followingErrors . '</em></p>';
        $content .= '<p><ul>';
        foreach ($errors as $error) {
            $content .= '<li>' . $error . '</li>';
        }
        $content .= '</ul></p>';
        $content .= '<a href="javascript:history.back()">' . $lang->back . '</a></div>';
        eval("\$showList = \"" . $templates->get("show_awaylist") . "\";");
        output_page($showList);
        exit;
    }

    $db->delete_query("awaylist", "id='{$mybb->input['id']}'");
    return true;
}

/**
 *
 * @global MyBB $mybb
 * @global MyLanguage $lang
 * @global DB_MySQL $db
 * @param array $errors array which will contain all errors during validation
 * @param integer $editItemId
 * @return boolean true if the item values are valid 
 */
function awaylist_validateItem(&$errors, $editItemId = null)
{
    global $mybb, $lang, $db;

    $errors = array();
    $lang->load("awaylist", false, true);

    if ($mybb->input['airline'] == "")
        $errors[] = $lang->errorAirlineMissing;
    if ($mybb->input['place'] == "")
        $errors[] = $lang->errorMissingPlace;
    if ($mybb->input['hotel'] == "")
        $errors[] = $lang->errorMissingHotel;
    if (!preg_match("/^[0-9[:space:]]*$/", $mybb->input['phone'])) {
        $errors[] = $lang->errorInvalidPhoneNumber;
    }
    $arrival = mktime(0, 0, 0, $mybb->input['arrival_monat'], $mybb->input['arrival_tag'], $mybb->input['arrival_jahr']);
    $departure = mktime(0, 0, 0, $mybb->input['departure_monat'], $mybb->input['departure_tag'], $mybb->input['departure_jahr']);

    $check = true;
    $whereCondition = "uid = '{$mybb->user['uid']}
        .' AND ( ( arrival BETWEEN '$arrival' AND '$departure' ) '
        .' OR ( departure  BETWEEN '$arrival' AND '$departure' ) '
        .' OR (arrival >= $arrival AND departure <= $departure) )";
    $query = $db->simple_select("awaylist", "*", $whereCondition);
    while ($result = $db->fetch_array($query)) {
        if ($editItemId == null OR $result['id'] != $editItemId) {
            $check = false;
            $existingJourney = ' (' . date('d.m.Y', $result['arrival']);
            $existingJourney .= ' bis ' . date('d.m.Y', $result['departure']) . ')';
            $errors[] = $lang->errorAlreadyAway . $existingJourney;
        }
    }

    if ($editItemId == null) {
        if ($arrival < time())
            $errors[] = $lang->errorArrivalNotInFuture;
    }
    if ($departure < time())
        $errors[] = $lang->errorDepartureNotInFuture;
    if ($departure < $arrival)
        $errors[] = $lang->errorArrivalNotBeforeDeparture;

    // if any error occurred
    if (count($errors) > 0) {
        return false;
    }
    return true;
}

/**
 * delete the items of the user which is being deleted
 */
function awaylist_ListDeleteUserHook()
{
    global $db, $mybb;

    $uid = intval($mybb->input['uid']);
    $db->delete_query("awaylist", "uid='$uid'");
}

/**
 * show the table with all items
 */
function awaylist_showFullTable($timestamp = null, $useTimestamp = false, $limit = 20, $startLimit = 0)
{
    global $db, $mybb, $lang, $templates;
    $lang->load("awaylist", false, true);

    // limit of displayed items
    if ($limit < 1) {
        $limit = 20;
    }

    if ($timestamp == null) {
        $timestamp = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
    }
    $timeStampNotice = '';
    $whereCondition = 'departure >= ' . $timestamp;
    if ($useTimestamp == true) {
        $whereCondition = $timestamp . ' BETWEEN arrival AND departure';
        $timeStampNotice = '<tr><td class="tcat" colspan="9"><strong>' . $lang->personsCurrentlyThere .
            date(" d.m.Y ", $timestamp) . $lang->in . ' ' . $mybb->settings["awayListCountry"] . '</strong></td></tr>';
    }
    $options = array(
        'order_by' => 'arrival',
        'limit_start' => $startLimit,
        'limit' => $limit
    );
    $queryItems = $db->simple_select('awaylist', '*', $whereCondition, $options);

    $countUsers = 0;
    $countUsers = $db->num_rows($queryItems);
    $arrayItems = array();
    while ($item = $db->fetch_array($queryItems)) {
        $arrayItems[$item['id']] = $item;
    }

    $currentUrl = $mybb->settings['bburl'] . '/' . THIS_SCRIPT;
    $selectDateForm = ShowDates::showDaySelect("time_tag", date("d", $timestamp));
    $selectDateForm .= ShowDates::showMonthSelect("time_monat", date("m", $timestamp));
    $selectDateForm .= ShowDates::showYearSelect("time_jahr", date("Y", $timestamp));
    $addItemUrl = $mybb->settings['bburl'] . '/' . THIS_SCRIPT . '?action=addAwlItem';

    foreach ($arrayItems as $item) {
        $count++;
        $userlink = '<a href="' . get_profile_link($item['uid']) . '">' . $item['username'] . '</a>';

        $currentDate = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        if (($item['arrival'] < $currentDate) && ($item['departure'] > $currentDate)) {
            $status = '<img src="' . $mybb->settings['bburl'] . '/images/awaylist/vor_ort.png" border="0">';
        } elseif ($item['departure'] == $currentDate) {
            $status = '<img src="' . $mybb->settings['bburl'] . '/images/awaylist/rueckflug.png" border="0">';
        } elseif ($item['arrival'] == $currentDate) {
            $status = '<img src="' . $mybb->settings['bburl'] . '/images/awaylist/hinflug.png" border="0">';
        } else {
            $status = '<img src="' . $mybb->settings['bburl'] . '/images/awaylist/daheim.png" border="0">';
        }

        $arrival = date("d.m.Y", $item['arrival']);
        $departure = date("d.m.Y", $item['departure']);
        $airline = $item['airline'];
        $place = $item['place'];
        $hotel = $item['hotel'];
        $phone = $item['phone'];
        $actions = '';
        if ((isUserInGroup(4)) OR ($item['uid'] == $mybb->user['uid'])) {
            $actions = '
                <a class="icon" href="' . $mybb->settings["bburl"] . '/' . THIS_SCRIPT . '?action=editAwlItem&id=' . $item['id'] . '">
                    <img src="' . $mybb->settings['bburl'] . '/images/awaylist/pencil.png" border="0">
                </a>
                <a class="icon" href="' . $mybb->settings["bburl"] . '/' . THIS_SCRIPT . '?action=deleteAwlItem&id=' . $item['id'] . '">
                    <img src="' . $mybb->settings['bburl'] . '/images/awaylist/no.png" border="0">
                </a>';
        }

        eval("\$tableItems .= \"" . $templates->get("show_awaylist_table_bit") . "\";");
    }

    eval("\$content .= \"" . $templates->get("show_awaylist_table") . "\";");

    return $content;
}

/** * *******************************************************************
 *
 * main functions for displaying
 *
 */
function awaylist_showListOnIndex()
{
    global $db, $mybb, $lang, $templates, $awaylist;

    // load the language
    $lang->load("awaylist", false, true);

    $awaylist = '';
    if ($mybb->settings['showAwayListOnlyForMembers'] == '1' && $mybb->user['uid'] != 0) {
        if ($mybb->settings['showAwayList'] == '1' && $mybb->settings['showAwayListOnIndex'] == '1') {
            $awaylist = awaylist_getContent();
        }
    }
}

function awaylist_showList()
{
    global $db, $mybb, $lang, $theme, $templates;

    // variables used in the templates
    global $headerinclude, $header, $footer;

    // load language
    $lang->load("awaylist", false, true);

    // check if the user has the permission to view the list
    if ($mybb->settings['showAwayListOnlyForMembers'] == '1' && $mybb->user['uid'] == 0) {
        error_no_permission();
    }

    // get the main content to display
    $content = awaylist_getContent();

    // load the template and fill the placeholders
    eval("\$showList = \"" . $templates->get("show_awaylist") . "\";");
    output_page($showList);
}

function awaylist_getContent()
{
    global $db, $mybb, $lang;
    $lang->load("awaylist", false, true);

    if ($mybb->settings['showAwayListOnlyForMembers'] == '1'
        && THIS_SCRIPT == 'awaylist.php'
        && $mybb->user['uid'] == 0) {
        error_no_permission();
    }

    $message = null;
    $content = null;

    if ($mybb->settings['showAwayList'] == '1') {

        // get/set the limit
        $cookieArray = unserialize($_COOKIE[$mybb->settings['cookieprefix'] . 'awaylist']);
        $limit = $cookieArray['displayLimit'];
        if ($mybb->input['action'] == "setAwlLimit") {
            $cookieArray = unserialize($_COOKIE[$mybb->settings['cookieprefix'] . 'awaylist']);
            $limit = $cookieArray['displayLimit'] = $mybb->input['limit'];
            $time = 60 * 60 * 24 * 2;
            my_setcookie('awaylist', serialize($cookieArray), $time, true);
        }

        // decide what to do
        if ($mybb->input['action'] == 'editAwlItem') {
            add_breadcrumb("{$mybb->settings["awayListTitle"]}", THIS_SCRIPT);
            $message = '';
            if ($mybb->input['step2'] == 'true' && awaylist_editItem($message) == true) {
                $message = '<p class="validation_success">' . $lang->editItemSuccessful . '</p>';
                $content = awaylist_showFullTable(null, false, $limit);
            } else {
                add_breadcrumb($lang->editItem);
                $content = awaylist_showEditItemForm();
            }
        } elseif ($mybb->input['action'] == 'deleteAwlItem') {
            add_breadcrumb("{$mybb->settings["awayListTitle"]}", THIS_SCRIPT);
            if ($mybb->input['step2'] == 'true' && awaylist_deleteItem() == true) {
                $message = '<p class="validation_success">' . $lang->deleteItemSuccessful . '</p>';
                $content = awaylist_showFullTable(null, false, $limit);
            } else {
                add_breadcrumb($lang->deleteItem);
                $content = awaylist_showDeleteConfirmDialog();
            }
        } elseif ($mybb->input['action'] == 'addAwlItem') {
            add_breadcrumb("{$mybb->settings["awayListTitle"]}", THIS_SCRIPT);
            $message = '';
            if ($mybb->input['step2'] == 'true' && awaylist_insertNewItem($message) == true) {
                $message = '<p class="validation_success">' . $lang->addItemSuccessful . '</p>';
                $content = awaylist_showFullTable(null, false, $limit);
            } else {
                add_breadcrumb($lang->newItem);
                $content = awaylist_showNewItemForm();
            }
        } elseif ($mybb->input['action'] == "setAwlTimestamp") {
            add_breadcrumb("{$mybb->settings["awayListTitle"]}");
            $timestamp = mktime(0, 0, 0, $mybb->input['time_monat'], $mybb->input['time_tag'], $mybb->input['time_jahr']);
            $content = awaylist_showFullTable($timestamp, true, $limit);
        } else {
            $content = awaylist_showFullTable(null, false, $limit);
        }
    } else {
        $content = '<div class="error low_warning"><p><em>' . $lang->followingErrors . '</em></p>';
        $content .= '<p><ul>';
        $content .= '<li>' . $lang->errorNoDisplay . '</li>';
        $content .= '</ul></p></div>';
    }

    return $message . $content . '<br />';
}

function awaylist_getHtmlErrorMessage($errors)
{
    global $lang;

    $lang->load("awaylist", false, true);

    $content = '<div class="error low_warning"><p><em>' . $lang->followingErrors . '</em></p>';
    $content .= '<p><ul>';
    foreach ($errors as $error) {
        $content .= '<li>' . $error . '</li>';
    }
    $content .= '</ul></p></div>';

    return $content;
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
$plugins->add_hook("index_start", "awaylist_showListOnIndex");
$plugins->add_hook("awaylist_showList", "awaylist_showList");
$plugins->add_hook("admin_users_do_delete", "awaylist_ListDeleteUserHook");

function awaylist_info()
{
    return array(
        "name" => "Awaylist",
        "description" => "It provides a list where members can subscribe when they are at a special place",
        "website" => "http://www.malte-gerth.de/mybb.html",
        "author" => "Jan Malte Gerth",
        "authorsite" => "http://www.malte-gerth.de/",
        "version" => "1.6.6",
        "compatibility" => "16*",
        "gid" => '6a8fbbc82f4aa01fd9ba4a599e80c5c7'
    );
}

function awaylist_is_installed()
{
    global $db, $mybb;

    if (array_key_exists('keep_list', $mybb->settings)) {
        if ($mybb->settings['keep_list'] == 'no') {
            if ($db->field_exists('id', "awaylist")) {
                return true;
            }
        } else {
            $query = $db->simple_select('templates', '*', 'title = \'show_awaylist\'');
            if ($db->num_rows($query)) {
                return true;
            }
        }
    }

    return false;
}

function awaylist_install()
{
    global $db, $mybb;
    require_once MYBB_ROOT . "/inc/adminfunctions_templates.php";

    /*
     * add plugin templates
     */
    $tplShowAwayListe = array(
        "tid" => "NULL",
        "title" => "show_awaylist",
        "template" => "<html>
	<head>
		<title>{\$mybb->settings[awayListTitle]}</title>
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
    $db->insert_query("templates", $tplShowAwayListe);

    $tplShowAwayListTable = array(
        "tid" => "NULL",
        "title" => "show_awaylist_table",
        "template" => $db->escape_string(
            '<table border="0" cellspacing="1" cellpadding="4" class="tborder">
    <thead>
        <tr>
            <td class="thead" colspan="9">
                <form action="{$currentUrl}" method="post" style="vertical-align:center; text-align:left; float:left; width:50%;">
                    <input type="hidden" name="action" value="setAwlLimit" />
                    <strong>{$lang->showOnly} <input type="text" name="limit" value="{$limit}" /> {$lang->entries}</strong>
                    <input type="submit" name="setAwlLimit" value="{$lang->show}" style="display:inline;"/>
                </form>
                <form action="{$currentUrl}" method="post" style="vertical-align:center; text-align:right; float:left; width:50%;">
                    <input type="hidden" name="action" value="setAwlTimestamp" />
                    <strong>{$lang->whoIsAt} {$selectDateForm} {$lang->in} {$mybb->settings[\'awayListCountry\']}?</strong>
                    <input type="submit" name="setAwlTimestamp" value="{$lang->show}" />
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
                            <img src="{$mybb->settings[\'bburl\']}/images/awaylist/viewmag+.png" border="0" valign="center"> {$lang->addToList}
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
        <td class="tcat" width="15%" align="center"><strong>{$lang->phoneAt} {$mybb->settings[\'awayListCountry\']}</strong></td>
        <td class="tcat" width="2%" align="center"><strong>{$lang->action}</strong></td>
    </tr>
    {$tableItems}
    <tr>
        <td class="tcat" colspan="9">
            <span style="vertical-align:center; text-align:left; float:right;">
                <img src="{$mybb->settings[\'bburl\']}/images/awaylist/pencil.png" border="0"> = {$lang->edit}
                <img src="{$mybb->settings[\'bburl\']}/images/awaylist/no.png" border="0"> = {$lang->delete}
            </span>
        </td>
    </tr>
</tbody>
</table>'
        ),
        "sid" => "-1",
    );
    $db->insert_query("templates", $tplShowAwayListTable);

    $tplTableBit = array(
        "tid" => "NULL",
        "title" => "show_awaylist_table_bit",
        "template" => $db->escape_string(
            '<tr>
    <td class="trow1">{$userlink}</td>
    <td class="trow1">{$status}</td>
    <td class="trow1" style="white-space: nowrap;">{$arrival}</td>
    <td class="trow1" style="white-space: nowrap;">{$departure}</td>
    <td class="trow1">{$airline}</td>
    <td class="trow1">{$place}</td>
    <td class="trow1">{$hotel}</td>
    <td class="trow1">{$phone}</td>
    <td class="trow1">{$actions}</td>
</tr>'
        ),
        "sid" => "-1",
    );
    $db->insert_query("templates", $tplTableBit);

    // TODO remove legacy methode in the future
    upgradeTo165();

    // create our database table
    $dbversion = $db->get_version();
    if ($dbversion > 5) {
        $createTableQuery = "CREATE TABLE IF NOT EXISTS `" . $db->table_prefix . "awaylist` (
            `id` bigint(20) NOT NULL auto_increment,
            `sort_id` bigint(20) default NULL,
            `uid` int(10) unsigned default NULL,
            `username` text character set utf8 collate utf8_unicode_ci,
            `arrival` int(11) default NULL,
            `departure` int(11) default NULL,
            `airline` varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL,
            `place` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
            `hotel` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
            `phone` varchar(255) character set utf8 collate utf8_unicode_ci default NULL,
            PRIMARY KEY  (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
    } else {
        $createTableQuery = "CREATE TABLE IF NOT EXISTS `" . $db->table_prefix . "awaylist` (
            `id` bigint(20) NOT NULL auto_increment,
            `sort_id` bigint(20) default NULL,
            `uid` int(10) unsigned default NULL,
            `username` text,
            `arrival` int(11) default NULL,
            `departure` int(11) default NULL,
            `airline` varchar(100) NOT NULL,
            `place` varchar(255) NOT NULL,
            `hotel` varchar(255) NOT NULL,
            `phone` varchar(255) default NULL,
            PRIMARY KEY  (`id`)
            ) TYPE=MyISAM ;";
    }
    $db->write_query($createTableQuery);

    /*
     * add plugin settings
     */
    $settingsGroup = array(
        "gid" => "NULL",
        "name" => "awaylist",
        "title" => "Awaylist",
        "description" => "Settings for the Awaylist Plugin",
        "disporder" => "1",
        "isdefault" => "no"
    );
    $db->insert_query("settinggroups", $settingsGroup);
    $gid = $db->insert_id();

    $settingsData = array(
        "sid" => "NULL",
        "name" => "showAwayList",
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

    $settingVisible = array(
        "sid" => "NULL",
        "name" => "showAwayListOnlyForMembers",
        "title" => "Liste nur für Mitglieder anzeigen",
        "description" => "Soll die Liste nur für Mitglieder sichtbar sein?",
        "optionscode" => "yesno",
        "value" => "1",
        "disporder" => "30",
        "gid" => intval($gid)
    );
    $db->insert_query("settings", $settingVisible);

    $settingsData = array(
        "sid" => "NULL",
        "name" => "showAwayListOnIndex",
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
        "name" => "awayListCountry",
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
        "name" => "awayListTitle",
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

function awaylist_uninstall()
{
    global $db, $mybb;
    require_once MYBB_ROOT . "/inc/adminfunctions_templates.php";

    if ($mybb->settings['keep_list'] == 'no') {
        $db->drop_table('liste');
    }

    /*
     * remove plugin settings
     */
    $db->delete_query(
        "settings", "name IN(
        'awayListTitle','awayListCountry','showAwayListOnIndex','keep_list',
        'showAwayListOnlyForMembers','showAwayList')"
    );

    $db->delete_query("settinggroups", "name='awaylist'");

    rebuild_settings();

    /*
     * remove plugin templates
     */
    $db->delete_query(
        "templates", "title IN(
        'show_awaylist','show_awaylist_table_bit','show_awaylist_table')"
    );
}

function awaylist_activate()
{
    require_once MYBB_ROOT . "/inc/adminfunctions_templates.php";

    find_replace_templatesets(
        "index", '#{\$header}(\r?)(\n?)#', "{\$header}\r\n{\$awaylist}\r\n"
    );

    find_replace_templatesets(
        "header", '#toplinks_help}</a></li>#', "$0\n<li class=\"awaylist_link\"><a href=\"{\$mybb->settings['bburl']}/awaylist.php\"><img src=\"{\$mybb->settings['bburl']}/images/awaylist/list.png\" border=\"0\" alt=\"\" />Awaylist</a></li>"
    );

    rebuild_settings();
}

function awaylist_deactivate()
{
    require_once MYBB_ROOT . "/inc/adminfunctions_templates.php";

    find_replace_templatesets("index", '#(\r?)(\n?){\$awaylist}(\r?)(\n?)#', "\r\n", 0);

    find_replace_templatesets("header", '#(\n?)<li class="awaylist_link">(.*)</li>#', '', 0);

    rebuild_settings();
}

function upgradeTo165()
{
    global $mybb, $db;

    if ($db->table_exists('liste')) {
        $renameTableQuery = "RENAME TABLE " . $db->table_prefix . "liste TO " . $db->table_prefix . "awaylist ;";
        $db->write_query($renameTableQuery);
    }

    if ($db->field_exists('ankunft', 'awaylist'))
        $db->rename_column('awaylist', 'ankunft', 'arrival', 'int(11) default NULL');
    if ($db->field_exists('abflug', 'awaylist'))
        $db->rename_column('awaylist', 'abflug', 'departure', 'int(11) default NULL');
    if ($db->field_exists('ort', 'awaylist'))
        $db->rename_column('awaylist', 'ort', 'place', 'varchar(255) NOT NULL');
    if ($db->field_exists('telefon', 'awaylist'))
        $db->rename_column('awaylist', 'telefon', 'phone', 'varchar(255) NOT NULL');
    if ($db->field_exists('data_id', 'awaylist')) {
        $db->drop_column('awaylist', 'id');
        $db->rename_column('awaylist', 'data_id', 'id', 'bigint(20) NOT NULL auto_increment');
    }
}