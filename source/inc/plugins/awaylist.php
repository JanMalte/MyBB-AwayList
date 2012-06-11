<?php
/**
 * AwayList plugin for MyBB
 * 
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Plugin
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 3 or later
 * @filesource
 */
// Disallow direct access to this file for security reasons
if (!defined('IN_MYBB')) {
    die('Direct initialization of this file is not allowed.<br />
        <br />Please make sure IN_MYBB is defined.');
}

/** * *******************************************************************
 * 
 * HELPER FUNCTIONS
 * 
 * ******************************************************************** */
// as this is a often used class in plugins
// check if it isn't already defined
if (!class_exists('FormDateElement')) {

    /**
     * Collection of usefull functions for using dates and timestamps
     * @category    MyBB.Plugins
     * @package     AwayList
     * @subpackage  Plugin_Helper
     * @author      Malte Gerth <http://www.malte-gerth.de>
     * @copyright   Copyright (C) Malte Gerth. All rights reserved.
     * @license     GNU General Public License version 3 or later
     */
    class FormDateElement
    {

        /**
         * show a SELECT element for days in a HTML form
         * 
         * @param string $fieldName Name of the field
         * @param string|integer $selectedDay OPTIONAL Set to the value of the
         * day which should be selected
         * @return string HTML code of the SELECT element
         */
        public static function showDaySelect($fieldName, $selectedDay = null)
        {
            // if the selected day isn't given set it to the actual day
            if ($selectedDay == null) $selectedDay = date("d");

            // set the start HTML of the select form
            $htmlSelectForm = '<select name="' . $fieldName . '">';
            // do this 31 times, one for every day
            for ($i = 01; $i <= 31; $i++) {
                $day = (string) $i;
                // convert this to a string with two numbers,
                // e.g.: 04 instade of 4
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
                $htmlSelectForm .= '<option ' . $selected
                    . 'value="' . $day . '">' . $day;
            }
            // close the select form
            $htmlSelectForm .= "</select>";
            // returns the HTML of the select form
            return $htmlSelectForm;
        }

        /**
         * show a SELECT element for months in a HTML form
         * 
         * @param string $fieldName Name of the field
         * @param string|integer $selectedMonth OPTIONAL Set to the value of the
         * month which should be selected
         * @return string HTML code of the SELECT element
         */
        public static function showMonthSelect($fieldName, $selectedMonth = null)
        {
            // if the selected month isn't given set it to the actual month
            if ($selectedMonth == null) $selectedMonth = date("m");

            // set the start HTML of the select form
            $htmlSelectForm = '<select name="' . $fieldName . '">';
            // do this 12 times, one for every month
            for ($i = 01; $i <= 12; $i++) {
                $month = (string) $i;
                // convert this to a string with two numbers,
                // e.g.: 04 instade of 4
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
                $htmlSelectForm .= '<option ' . $selected
                    . 'value="' . $month . '">' . $month;
            }
            // close the select form
            $htmlSelectForm .= "</select>";
            // returns the HTML of the select form
            return $htmlSelectForm;
        }

        /**
         * show a SELECT element for years in a HTML form
         * 
         * @param string $fieldName Name of the field
         * @param string|integer $selectedYear OPTIONAL Set to the value of
         * the year which should be selected
         * @param integer $offset OPTIONAL Offset for the list of years;
         * negative values are allowed
         * @param integer $countItems OPTIONAL Number of items which should
         * be shown
         * @return string HTML code of the SELECT element
         */
        public static function showYearSelect($fieldName, $selectedYear = null,
            $offset = -1, $countItems = 10)
        {
            // if the selected year isn't given set it to the actual year
            if ($selectedYear == null) {
                $selectedYear = date("Y");
            }

            // if $countItems is less then one, set it to one as we need at least
            // one option in our select element
            if ($countItems < 1) {
                $countItems = 1;
            }

            // add the offset to the current year
            $startYear = date("Y") + $offset;
            // set the end year to $countItems later then the current year
            $endYear = $startYear + $countItems;

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
                $htmlSelectForm .= '<option ' . $selected
                    . 'value="' . $year . '">' . $year;
            }
            // close the select form
            $htmlSelectForm .= "</select>";
            // returns the HTML of the select form
            return $htmlSelectForm;
        }

    }

}

/** * *******************************************************************
 * 
 * PLUGIN INSTALL/UNINSTALL ROUTINES
 * 
 * ******************************************************************** */
// Skip the following line for code coverage, as global functions aren't covered
// @codeCoverageIgnoreStart
/**
 * return the information about the plugin as an array
 * 
 * @return array 
 */
function awaylist_info()
{
    return array(
        'name' => 'Awaylist',
        'description' => 'It provides a list where members can subscribe'
        . ' when they are at a special place',
        'website' => 'http://www.malte-gerth.de/mybb.html',
        'author' => 'Jan Malte Gerth',
        'authorsite' => 'http://www.malte-gerth.de/',
        'version' => '1.6.8',
        'compatibility' => '16*',
        'gid' => '6a8fbbc82f4aa01fd9ba4a599e80c5c7'
    );
}

/**
 * Called on the plugin management page to establish if a plugin is already
 * installed or not.<br />
 * This should return TRUE if the plugin is installed (by checking tables,
 * fields etc) or FALSE if the plugin is not installed.
 * 
 * @global type $db
 * @global MyBB $mybb
 * @return boolean 
 */
function awaylist_is_installed()
{
    global $db, $mybb;

    if (array_key_exists('keep_list', $mybb->settings)) {
        if ($mybb->settings['keep_list'] == 'no') {
            if ($db->field_exists('id', 'awaylist')) {
                return true;
            }
        } else {
            $query = $db->simple_select(
                'templates', '*', 'title = \'show_awaylist\''
            );
            if ($db->num_rows($query)) {
                return true;
            }
        }
    }

    return false;
}

/**
 * Called whenever a plugin is installed by clicking the "Install" button in the
 * plugin manager.<br />
 * If no install routine exists, the install button is not shown and it assumed
 * any work will be performed in the _activate() routine.
 * 
 * @global type $db
 * @return void 
 */
function awaylist_install()
{
    global $db;
    require_once MYBB_ROOT . '/inc/adminfunctions_templates.php';

    AwayList::installTemplates();

    // TODO remove legacy methode in the future
    $awayListRepository = new AwayList_Item_Repository();
    $awayListRepository->upgradeTo165();

    // create our database table
    $dbversion = $db->get_version();
    if ($dbversion > 5) {
        $createTableQuery = 'CREATE TABLE IF NOT EXISTS '
            . '`' . $db->table_prefix . 'awaylist` (
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
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;';
    } else {
        $createTableQuery = 'CREATE TABLE IF NOT EXISTS '
            . '`' . $db->table_prefix . 'awaylist` (
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
            ) TYPE=MyISAM ;';
    }
    $db->write_query($createTableQuery);

    AwayList::installSettings();
}

/**
 * Called whenever a plugin is to be uninstalled. This should remove ALL traces
 * of the plugin from the installation (tables etc). If it does not exist,
 * uninstall button is not shown.
 * 
 * @global type $db
 * @global MyBB $mybb 
 * @return void 
 */
function awaylist_uninstall()
{
    global $db, $mybb;
    require_once MYBB_ROOT . '/inc/adminfunctions_templates.php';

    if ($mybb->settings['keep_list'] == 'no') {
        $db->drop_table('liste');
        $db->drop_table('awaylist');
    }

    /*
     * remove plugin settings
     */
    $db->delete_query(
        'settings',
        "name IN(
            'awayListTitle','awayListCountry','showAwayListOnIndex','keep_list',
            'showAwayListOnlyForMembers','showAwayList'
        )"
    );

    $db->delete_query("settinggroups", "name='awaylist'");

    rebuild_settings();

    /*
     * remove plugin templates
     */
    $db->delete_query(
        'templates',
        "title IN(
            'show_awaylist','show_awaylist_table_bit','show_awaylist_table'
        )"
    );
}

/**
 * Called whenever a plugin is activated via the Admin CP. This should
 * essentially make a plugin "visible" by adding templates/template changes,
 * language changes etc.
 * 
 * @return void 
 */
function awaylist_activate()
{
    require_once MYBB_ROOT . '/inc/adminfunctions_templates.php';

    find_replace_templatesets(
        'index', '#{\$header}(\r?)(\n?)#', "{\$header}\r\n{\$awaylist}\r\n"
    );

    find_replace_templatesets(
        'header', '#toplinks_help}</a></li>#',
        "$0\n<li class=\"awaylist_link\">"
        . "<a href=\"{\$mybb->settings['bburl']}/awaylist.php\">"
        . "<img src=\"{\$mybb->settings['bburl']}/images/awaylist/list.png\""
        . "border=\"0\" alt=\"\" />{\$lang->liste}</a></li>"
    );

    rebuild_settings();
}

/**
 * Called whenever a plugin is deactivated. This should essentially "hide" the
 * plugin from view by removing templates/template changes etc. It should not,
 * however, remove any information such as tables, fields etc - that should be
 * handled by an _uninstall routine. When a plugin is uninstalled, this routine
 * will also be called before _uninstall() if the plugin is active.
 * 
 * @return void  
 */
function awaylist_deactivate()
{
    require_once MYBB_ROOT . '/inc/adminfunctions_templates.php';

    find_replace_templatesets(
        'index', '#(\r?)(\n?){\$awaylist}(\r?)(\n?)#', "\r\n", 0
    );

    find_replace_templatesets(
        'header', '#(\n?)<li class="awaylist_link">(.*)</li>#', '', 0
    );

    rebuild_settings();
}

// End of skipped lines for code coverage
// @codeCoverageIgnoreEnd

/** * *******************************************************************
 * 
 * PLUGIN CODE
 * 
 * ******************************************************************** */
// Skip the following line for code coverage, as global functions aren't covered
// @codeCoverageIgnoreStart
// add plugin hooks
$plugins->add_hook('global_start', 'awaylistLoadLanguageHook');
$plugins->add_hook('index_start', 'awaylistShowListOnIndexHook');
$plugins->add_hook('awaylist_showList', 'awaylistShowListHook');
$plugins->add_hook('admin_user_users_delete_commit', 'awaylistDeleteUserHook');

/**
 * load the plugin translations on global context
 * 
 * @global MyLanguage $lang 
 */
function awaylistLoadLanguageHook()
{
    global $lang;

    // load the translation
    $lang->load('awaylist');
}

/**
 * show awaylist on index
 * 
 * @global MyBB $mybb
 * @global string $awaylist 
 */
function awaylistShowListOnIndexHook()
{
    global $mybb, $awaylist;

    $awaylist = '';
    if ($mybb->settings['showAwayListOnlyForMembers'] == '1'
        && $mybb->user['uid'] != 0) {
        if ($mybb->settings['showAwayList'] == '1'
            && $mybb->settings['showAwayListOnIndex'] == '1') {
            $awaylist = AwayList::showAwayList() . '<br />';
        }
    }
}

/**
 * show awaylist on own page
 * 
 * @global MyBB $mybb
 * @global MyLanguage $lang
 * @global type $templates
 * @global type $theme
 * @global type $headerinclude
 * @global type $header
 * @global type $footer 
 */
function awaylistShowListHook()
{
    global $mybb, $lang, $templates;

    // variables used in the templates
    global $theme, $headerinclude, $header, $footer;

    // load language
    $lang->load('awaylist', false, true);

    // check if the user has the permission to view the list
    if ($mybb->settings['showAwayListOnlyForMembers'] == '1'
        && $mybb->user['uid'] == 0) {
        error_no_permission();
    }

    // add breadcrumb element depending on action
    switch ($mybb->input['action']) {
        case 'editAwlItem':
            add_breadcrumb($lang->editItem);
            break;
        case 'addAwlItem':
            add_breadcrumb($lang->addItem);
            break;
        case 'deleteAwlItem':
            add_breadcrumb($lang->deleteItem);
            break;
    }

    // get the main content to display
    $content = AwayList::showAwayList();

    // load the template and fill the placeholders
    eval("\$showList = \"" . $templates->get("show_awaylist") . "\";");
    output_page($showList);
}

/**
 * delete the items of the user which is being deleted
 * 
 * @global array $user 
 */
function awaylistDeleteUserHook()
{
    global $user;

    $userId = intval($user['uid']);
    $awayListRepository = new AwayList_Item_Repository();
    $awayListRepository->deleteByUserId($userId);
}

// End of skipped lines for code coverage
// @codeCoverageIgnoreEnd

/**
 * all needed functions for awaylist
 * 
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Plugin
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */
class AwayList
{

    /**
     * translation object
     * 
     * @var MyLanguage 
     */
    protected static $_TRANSLATION;

    /**
     * load the translation
     * 
     * @global MyLanguage $lang
     * @return MyLanguage 
     */
    public static function loadLanguage()
    {
        global $lang;

        // get the translation object
        if (empty($lang) || !$lang instanceof MyLanguage) {
            // Language initialisation
            require_once MYBB_ROOT . 'inc/class_language.php';
            $lang = new MyLanguage;
            $lang->set_path(MYBB_ROOT . 'inc/languages');
            $lang->set_language('english');
        }

        // load the translation
        @$lang->load('awaylist', false, true);

        // register the object in the class
        self::$_TRANSLATION = $lang;

        // return the object for method chaining
        return self::$_TRANSLATION;
    }

    /**
     * checks if the user is in one of the allowed usergroups
     * 
     * @global MyBB $mybb
     * @param string $allowedGroups the allowed usergroups;
     * seperated with ","(COMMA) e.g.: "4,10,2"
     * @return boolean true if user is in one of the allowed usergroups
     */
    public static function isUserInGroup($allowedGroups = false)
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

    /**
     * install the templates
     * 
     * @global DB_MySQL $db
     * @return void 
     */
    public static function installTemplates()
    {
        global $db;
        require_once MYBB_ROOT . '/inc/adminfunctions_templates.php';

        /*
         * add plugin templates
         */
        $tplShowAwayListe = array(
            'tid' => 'NULL',
            'title' => 'show_awaylist',
            'template' => '<html>
	<head>
		<title>{\$mybb->settings[awayListTitle]}</title>
		<base href=\'{\$mybb->settings[bburl]}/\'>
		{\$headerinclude}
	</head>
	<body>
		{\$header}
		{\$content}
		{\$footer}
	</body>
</html>',
            'sid' => '-1',
        );
        $db->insert_query('templates', $tplShowAwayListe);

        $tplShowAwayListTable = array(
            'tid' => 'NULL',
            'title' => 'show_awaylist_table',
            'template' => $db->escape_string(
                '<table border="0" cellspacing="1" cellpadding="4" class="tborder">
    <thead>
        <tr>
            <td class="thead" colspan="9">
                <form action="{$currentUrl}" method="post" '
                . 'style="vertical-align:center; text-align:left; float:left; width:50%;">
                    <input type="hidden" name="action" value="setAwlLimit" />
                    <strong>{$lang->showOnly} <input type="text" name="limit" '
                . 'value="{$limit}" /> {$lang->entries}</strong>
                    <input type="submit" name="setAwlLimit" '
                . 'value="{$lang->show}" style="display:inline;"/>
                </form>
                <form action="{$currentUrl}" method="post" '
                . 'style="vertical-align:center; text-align:right; float:left; width:50%;">
                    <input type="hidden" name="action" value="setAwlTimestamp" />
                    <strong>{$lang->whoIsAt} {$selectDateForm} {$lang->in} '
                . '{$mybb->settings[\'awayListCountry\']}?</strong>
                    <input type="submit" name="setAwlTimestamp" '
                . 'value="{$lang->show}" />
                </form>
            </td>
        </tr>
    </thead>
</table>
<table border="0" cellspacing="1" cellpadding="4" class="tborder">
    <thead>
        <tr>
            <td class="thead" colspan="9">
                <div class="expcolimage"><img '
                . 'src="{$mybb->settings[\'bburl\']}/{$theme[\'imgdir\']}/collapse.gif" '
                . 'id="liste_1_img" class="expander" alt="[-]" /></div>
                <span style="vertical-align:center; text-align:right; float:left;">
                    <strong>
                        <a href="{$addItemUrl}" style="vertical-align: top;">
                            <img '
                . 'src="{$mybb->settings[\'bburl\']}/images/awaylist/viewmag+.png" '
                . 'border="0" valign="center"> {$lang->addToList}
                        </a>
                    </strong>
                </span>
            </td>
        </tr>
    </thead>
    <tbody style="" id="liste_1_e">
    {$timeStampNotice}
    <tr>
        <td class="tcat" width="15%" align="center">'
                . '<strong>{$lang->name}</strong></td>
        <td class="tcat" width="5%" align="center">'
                . '<strong>{$lang->status}</strong></td>
        <td class="tcat" width="5%" align="center">'
                . '<strong>{$lang->arrival}</strong></td>
        <td class="tcat" width="5%" align="center">'
                . '<strong>{$lang->departure}</strong></td>
        <td class="tcat" width="15%" align="center">'
                . '<strong>{$lang->airline}</strong></td>
        <td class="tcat" width="15%" align="center">'
                . '<strong>{$lang->place}</strong></td>
        <td class="tcat" width="15%" align="center">'
                . '<strong>{$lang->hotel}</strong></td>
        <td class="tcat" width="15%" align="center">'
                . '<strong>{$lang->phoneAt} {$mybb->settings[\'awayListCountry\']}'
                . '</strong></td>
        <td class="tcat" width="2%" align="center">'
                . '<strong>{$lang->action}</strong></td>
    </tr>
    {$tableItems}
    <tr>
        <td class="tcat" colspan="9">
            <span style="vertical-align:center; text-align:left; float:right;">
                <img '
                . 'src="{$mybb->settings[\'bburl\']}/images/awaylist/pencil.png" '
                . 'border="0"> = {$lang->edit}
                <img '
                . 'src="{$mybb->settings[\'bburl\']}/images/awaylist/no.png" '
                . 'border="0"> = {$lang->delete}
            </span>
        </td>
    </tr>
</tbody>
</table>'
            ),
            'sid' => '-1',
        );
        $db->insert_query('templates', $tplShowAwayListTable);

        $tplTableBit = array(
            'tid' => 'NULL',
            'title' => 'show_awaylist_table_bit',
            'template' => $db->escape_string(
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
            'sid' => '-1',
        );
        $db->insert_query('templates', $tplTableBit);
    }

    /**
     * install the plugin settings
     * 
     * @global DB_MySQL $db
     * @return void 
     */
    public static function installSettings()
    {
        global $db;
        require_once MYBB_ROOT . '/inc/adminfunctions_templates.php';

        /*
         * add plugin settings
         */
        $settingsGroup = array(
            'gid' => 'NULL',
            'name' => 'awaylist',
            'title' => 'Awaylist',
            'description' => 'Settings for the Awaylist Plugin',
            'disporder' => '1',
            'isdefault' => 'no'
        );
        $db->insert_query('settinggroups', $settingsGroup);
        $gid = $db->insert_id();

        $settingsData = array(
            'sid' => 'NULL',
            'name' => 'showAwayList',
            'title' => 'Anzeige der Liste',
            'description' => 'Soll die Liste angezeigt werden?',
            'optionscode' => 'yesno',
            'value' => '1',
            'disporder' => '10',
            'gid' => intval($gid)
        );
        $db->insert_query('settings', $settingsData);

        $settingsData = array(
            'sid' => 'NULL',
            'name' => 'keep_list',
            'title' => 'Informationen behalten',
            'description' => 'Sollen die gespeicherten Informationen der '
            . 'Aufenthalte beim Deaktivieren des Plugins erhalten bleiben?',
            'optionscode' => 'yesno',
            'value' => '1',
            'disporder' => '20',
            'gid' => intval($gid)
        );
        $db->insert_query('settings', $settingsData);

        $settingVisible = array(
            'sid' => 'NULL',
            'name' => 'showAwayListOnlyForMembers',
            'title' => 'Liste nur für Mitglieder anzeigen',
            'description' => 'Soll die Liste nur für Mitglieder sichtbar sein?',
            'optionscode' => 'yesno',
            'value' => '1',
            'disporder' => '30',
            'gid' => intval($gid)
        );
        $db->insert_query('settings', $settingVisible);

        $settingsData = array(
            'sid' => 'NULL',
            'name' => 'showAwayListOnIndex',
            'title' => 'Auf der Startseite anzeigen',
            'description' => 'Soll die Liste auf der Startseite angezeigt werden?',
            'optionscode' => 'yesno',
            'value' => '0',
            'disporder' => '40',
            'gid' => intval($gid)
        );
        $db->insert_query('settings', $settingsData);

        $settingsData = array(
            'sid' => 'NULL',
            'name' => 'awayListCountry',
            'title' => 'Name des Landes',
            'description' => 'Für welches Land gilt die Tabelle?',
            'optionscode' => 'text',
            'value' => 'Thailand',
            'disporder' => '50',
            'gid' => intval($gid)
        );
        $db->insert_query('settings', $settingsData);

        $settingsData = array(
            'sid' => 'NULL',
            'name' => 'awayListTitle',
            'title' => 'Titel des Plugins',
            'description' => 'Welcher Titel soll angezeigt werden?',
            'optionscode' => 'text',
            'value' => 'Wer ist wann in Thailand',
            'disporder' => '60',
            'gid' => intval($gid)
        );
        $db->insert_query('settings', $settingsData);

        rebuild_settings();
    }

    public static function showAwayList()
    {
        global $mybb;

        // start with empty content
        $awayListContent = null;

        // load translation
        $lang = self::loadLanguage();

        if ($mybb->settings['showAwayList'] != '1') {
            // show an error message if the list shoul not be displayed
            $errors = array($lang->errorNoDisplay);
            $awayListContent = inline_error($errors, $lang->followingErrors);
        } else {

            // get/set the limit
            $cookieArray = unserialize(
                $_COOKIE[$mybb->settings['cookieprefix'] . 'awaylist']
            );
            $limit = (int) $cookieArray['displayLimit'];
            if (empty($limit) || $limit < 1) {
                $limit = 5;
            }
            if ($mybb->input['action'] == "setAwlLimit") {
                $limit = $cookieArray['displayLimit'] = (int) $mybb->input['limit'];
                my_setcookie('awaylist', serialize($cookieArray));
            }

            /**
             * Add a pagination 
             */
            $awayListRepository = new AwayList_Item_Repository();
            $totalCount = $awayListRepository->countAllUpcomming();
            // get the current page for the pagination
            $page = 1;
            if (isset($mybb->input['awlPage'])
                && !empty($mybb->input['awlPage'])
            ) {
                $page = $mybb->input['awlPage'];
            }
            // build the pagination links
            $pagination = multipage(
                $totalCount, $limit, $page,
                $mybb->settings['bburl'] . '/' . THIS_SCRIPT . '?awlPage={page}'
            );
            // calculate the offset for the select statements
            $offset = $limit * ($page - 1);

            // get the content
            $awayListContent = self::getContent($limit, $offset);

            // add the pagination to the content
            $awayListContent .= $pagination;
        }
        return $awayListContent;
    }

    /**
     * get the html code to display
     * 
     * @global MyBB $mybb
     * @return string the html content 
     */
    public static function getContent($limit, $offset)
    {
        global $mybb;

        // start with empty content
        $content = null;

        // load translation
        $lang = self::loadLanguage();

        $awayListRepository = new AwayList_Item_Repository();
        $awayListItem = $awayListRepository->createRow();
        if (isset($mybb->input['awlItemId']) && !empty($mybb->input['awlItemId'])) {
            $awayListItem = $awayListRepository->fetchRowById($mybb->input['awlItemId']);
        }

        // decide what to do
        switch ($mybb->input['action']) {
            /**
             * edit an away list item 
             */
            case 'editAwlItem':

                // if the form is submitted and valid
                if ($mybb->input['performAction'] == 'true'
                    && $awayListItem->isValid($mybb->input) == true
                ) {
                    // set data for the item
                    $awayListItem->setData($mybb->input);
                    // update the username information
                    if ($awayListItem->getUid() == $mybb->user['uid']) {
                        $awayListItem->setUsername($mybb->user['username']);
                    }
                    // save the item
                    $awayListItem->save();
                    // show a message
                    $content = '<p class="validation_success">'
                        . $lang->editItemSuccessful
                        . '</p>';
                    // show the table
                    $content .= self::showFullTable(null, $limit, $offset);
                    break;
                }

                // build the default values for the item
                $item = $awayListItem->toArray();
                if ($mybb->input['performAction'] == 'true') {
                    $item = $mybb->input;
                }

                // display errors
                $errors = $awayListItem->getErrors();
                if (!empty($errors)) {
                    $content = inline_error($errors);
                }

                // show item form
                $actionUrl = $_SERVER['REQUEST_URI'];
                $content .= self::getItemForm($item, $actionUrl, $errors);

                break;

            /**
             * add a new away list item 
             */
            case 'addAwlItem':

                // if the form is submitted and valid
                if ($mybb->input['performAction'] == 'true'
                    && $awayListItem->isValid($mybb->input) == true
                ) {
                    // set data for the item
                    $awayListItem->setData($mybb->input);

                    // add some general information
                    $awayListItem->setUid($mybb->user['uid']);
                    $awayListItem->setUsername($mybb->user['username']);

                    // save the item
                    $awayListItem->save();
                    // show a message
                    $content = '<p class="validation_success">'
                        . $lang->addItemSuccessful
                        . '</p>';
                    // show the table
                    $content .= self::showFullTable(null, $limit, $offset);
                    break;
                }

                // display errors
                $errors = $awayListItem->getErrors();
                if (!empty($errors)) {
                    $content = inline_error($errors);
                }

                // build the default values for the item
                $item = $mybb->input;

                // show item form
                $actionUrl = $_SERVER['REQUEST_URI'];
                $content .= self::getItemForm($item, $actionUrl, $errors);

                break;

            /**
             * delete a away list item 
             */
            case 'deleteAwlItem':
                if ($mybb->input['performAction'] == 'true') {

                    // delete item
                    self::deleteItem(
                        $mybb->input['awlItemId'], $mybb->user['uid']
                    );

                    // add a message 
                    $content = '<p class="validation_success">'
                        . $lang->deleteItemSuccessful
                        . '</p>';

                    // show the table
                    $content .= self::showFullTable(null, $limit, $offset);

                    break;
                }

                // show the confirm dialog
                $content = self::showDeleteConfirmDialog($awayListItem->toArray());

                break;

            /**
             * set the timstamp filter
             * @todo refactor; save timestamp in cookie and add reset filter button
             */
            case 'setAwlTimestamp':
                $timestamp = mktime(
                    0, 0, 0, $mybb->input['time_monat'],
                    $mybb->input['time_tag'], $mybb->input['time_jahr']
                );
                $content = self::showFullTable($timestamp, $limit, $offset);
                break;

            /**
             * show the full table
             */
            default:
                $content = self::showFullTable(null, $limit, $offset);
                break;
        }

        return $content;
    }

    /**
     * show the table with all items
     * 
     * @todo refactor
     * @global MyBB $mybb
     * @global mixed $templates
     * @global mixed $theme
     * @param integer $timestamp
     * @param integer $limit
     * @param integer $startLimit
     * @return string 
     */
    public static function showFullTable($timestamp, $limit, $startLimit = 0)
    {
        global $mybb, $templates, $theme;

        // load translation
        $lang = self::loadLanguage();

        // limit of displayed items
        $limit = max(array(1, $limit));

        // build the select query; add timestamp if given
        $timeStampNotice = '';
        $options = array(
            'order_by' => 'arrival',
            'limit_start' => $startLimit,
            'limit' => $limit
        );

        $awayListRepository = new AwayList_Item_Repository();
        $awayListItems = array();
        if ($timestamp != null) {
            $awayListItems = $awayListRepository->fetchAllByDate(
                $timestamp, $options
            );
            $timeStampNotice = '<tr><td class="tcat" colspan="9"><strong>'
                . $lang->personsCurrentlyThere . date(" d.m.Y ", $timestamp)
                . $lang->in . ' ' . $mybb->settings["awayListCountry"]
                . '</strong></td></tr>';
        } else {
            $timestamp = time();
            $awayListItems = $awayListRepository->fetchAllUpcomming($options);
        }

        $countUsers = 0;
        $countUsers = count($awayListItems);

        $currentUrl = $mybb->settings['bburl'] . '/' . THIS_SCRIPT;

        $selectDateForm = FormDateElement::showDaySelect(
                'time_tag', date("d", $timestamp)
        );
        $selectDateForm .= FormDateElement::showMonthSelect(
                'time_monat', date("m", $timestamp)
        );
        $selectDateForm .= FormDateElement::showYearSelect(
                'time_jahr', date("Y", $timestamp)
        );
        $addItemUrl = $mybb->settings['bburl'] . '/'
            . THIS_SCRIPT . '?action=addAwlItem';

        // add all items
        $currentDate = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        foreach ($awayListItems as $awayListItem) {
            $item = $awayListItem->toArray();
            $count++;
            $userlink = '<a href="' . get_profile_link($item['uid']) . '">'
                . $item['username']
                . '</a>';

            if (($item['arrival'] < $currentDate)
                && ($item['departure'] > $currentDate)
            ) {
                $status = '<img src="' . $mybb->settings['bburl']
                    . '/images/awaylist/vor_ort.png" border="0">';
            } elseif ($item['departure'] == $currentDate) {
                $status = '<img src="' . $mybb->settings['bburl']
                    . '/images/awaylist/rueckflug.png" border="0">';
            } elseif ($item['arrival'] == $currentDate) {
                $status = '<img src="' . $mybb->settings['bburl']
                    . '/images/awaylist/hinflug.png" border="0">';
            } else {
                $status = '<img src="' . $mybb->settings['bburl']
                    . '/images/awaylist/daheim.png" border="0">';
            }

            $arrival = date("d.m.Y", $item['arrival']);
            $departure = date("d.m.Y", $item['departure']);
            $airline = $item['airline'];
            $place = $item['place'];
            $hotel = $item['hotel'];
            $phone = $item['phone'];
            $actions = '';
            if (self::isUserInGroup(4)
                OR ($item['uid'] == $mybb->user['uid'])
            ) {
                $actions = '<a class="icon"'
                    . 'href="' . $mybb->settings["bburl"] . '/' . THIS_SCRIPT
                    . '?action=editAwlItem&awlItemId=' . $item['id'] . '">'
                    . '<img src="' . $mybb->settings['bburl']
                    . '/images/awaylist/pencil.png" border="0">'
                    . '</a>' . PHP_EOL
                    . '<a class="icon" href="' . $mybb->settings["bburl"]
                    . '/' . THIS_SCRIPT . '?action=deleteAwlItem&awlItemId='
                    . $item['id'] . '">'
                    . '<img src="' . $mybb->settings['bburl']
                    . '/images/awaylist/no.png" border="0">'
                    . '</a>';
            }

            eval(
                "\$tableItems .= \"" .
                $templates->get("show_awaylist_table_bit") . "\";"
            );
        }

        $content = null;
        eval(
            "\$content .= \"" . $templates->get("show_awaylist_table") . "\";"
        );

        return $content;
    }

    /**
     * show delete confirm dialog
     * 
     * @global MyBB $mybb
     * @return string the html message 
     */
    public static function showDeleteConfirmDialog($item)
    {
        global $mybb;

        // load translation
        $lang = self::loadLanguage();

        // check for errors
        $errors = array();
        if ($item['uid'] != $mybb->user['uid'] && !self::isUserInGroup(4)) {
            $errors[] = $lang->errorNoPermission;
        }
        if (empty($item['id'])) {
            $errors[] = $lang->errorNoItemSelected;
        }

        // if any error occurred
        if (!empty($errors)) {
            $content = inline_error($errors, $lang->followingErrors);
        } else {
            $content = '<form action="' . $mybb->settings["bburl"] . '/'
                . THIS_SCRIPT . '" method="post">'
                . '<input type="hidden" name="action" value="deleteAwlItem" />'
                . '<input type="hidden" name="performAction" value="true" />'
                . '<input type="hidden" name="awlItemId" value="' . $item['id'] . '" />'
                . '<table border="0" cellspacing="1" cellpadding="4" class="tborder">'
                . ' <thead>'
                . '   <tr>'
                . '     <td class="thead" colspan="2">'
                . '       <div>'
                . '         <strong>' . $lang->deleteItem . '</strong><br />'
                . '         <div class="smalltext"></div>'
                . '       </div>'
                . '     </td>'
                . '   </tr>'
                . ' </thead>'
                . ' <tbody style="" id="cat_1_e">'
                . '   <tr>'
                . '     <td class="trow1"><b>' . $lang->arrival . ':</b></td>'
                . '     <td class="trow1">';
            $content .= date('d.m.Y', $item['arrival']);
            $content .= '</td></tr><tr>';
            $content .= '<td class="trow2"><b>' . $lang->departure . ':</b></td>
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
		  <td class="trow2"><b>' . $lang->phoneAt . ' '
                . $mybb->settings["awayListCountry"] . ':</b></td>
		  <td class="trow2">' . $item['phone'] . '</td>
		</tr>
		<tr>
		  <td class="trow1"></td>
		  <td class="trow1"><input type="submit" name="deleteAwlItem"'
                . ' value="' . $lang->deleteItem . '"></td>
		</tr>
            </tbody>
	  </table>
	</form>';
        }
        return $content;
    }

    /**
     * delete the item
     * 
     * @param integer $itemId id of item which should be deleted
     * @param integer $userId id of the current user
     * @return boolean 
     */
    public static function deleteItem($itemId, $userId)
    {

        // load translation
        $lang = self::loadLanguage();

        // get the away list item
        $awayListRepository = new AwayList_Item_Repository();
        $awayListItem = $awayListRepository->fetchRowById($itemId);

        // check for errors
        $errors = false;
        if ($awayListItem->getUid() != $userId && !self::isUserInGroup(4)) {
            $errors = true;
            error($lang->errorNoPermission, $lang->followingErrors);
        }
        if (empty($itemId)) {
            $errors = true;
            error($lang->errorNoItemSelected, $lang->followingErrors);
        }

        // show error page or return true on success
        if ($errors != true) {
            $awayListRepository->deleteById($itemId);
            return true;
        }
    }

    /**
     * get the html for the item form
     * 
     * @global MyBB $mybb 
     * @param array $item 
     * @param string $action 
     * @param string $actionUrl 
     * @param array $validateErrors 
     * @return string 
     */
    public static function getItemForm($item, $actionUrl = null,
        $validateErrors = null)
    {
        global $mybb;

        // load translation
        $lang = self::loadLanguage();

        // get the action url for the form
        if (empty($actionUrl)) {
            $actionUrl = $mybb->settings["bburl"] . '/' . THIS_SCRIPT;
        }

        $content = '<style>.error input {border-color: #B94A48;color: #B94A48;}'
            . '.error td {background-color: #F2DEDE!important;}</style>'
            . '<form action="' . $actionUrl . '" method="post">'
            . '<input type="hidden" name="awlItemId" value="' . $item['id'] . '" />'
            . '<input type="hidden" name="performAction" value="true" />'
            . '<table border="0" cellspacing="1" cellpadding="4" class="tborder">'
            . '<thead>'
            . '<tr>'
            . '<td class="thead" colspan="2">'
            . '<div><strong>' . $lang->addToList . '</strong><br />'
            . '<div class="smalltext"></div></div>'
            . '</td>'
            . '</tr>'
            . '</thead>'
            . '<tbody style="" id="cat_1_e">';
        if (isset($validateErrors['arrival'])) {
            $content .= '<tr class="error">';
        } else {
            $content .= '<tr>';
        }
        $content .= '<td class="trow1"><b>' . $lang->arrival . ':</b>*</td>'
            . '<td class="trow1">';
        $arrivalDay = $item['arrival_tag'];
        if (empty($arrivalDay)) {
            $arrivalDay = str_pad((date('d') + 1), 2, 0, STR_PAD_LEFT);
        }
        $content .= FormDateElement::showDaySelect("arrival_tag", $arrivalDay);
        $content .= FormDateElement::showMonthSelect(
                "arrival_monat", $item['arrival_monat']
        );
        $content .= FormDateElement::showYearSelect(
                "arrival_jahr", $item['arrival_jahr']
        );
        $content .= '</td></tr>';
        if (isset($validateErrors['depature'])) {
            $content .= '<tr class="error">';
        } else {
            $content .= '<tr>';
        }
        $content .= '<td class="trow2"><b>' . $lang->departure . ':</b>*</td>'
            . '<td class="trow2">';
        $content .= FormDateElement::showDaySelect(
                "departure_tag", $item['departure_tag']
        );
        $depatureMonth = $item['departure_monat'];
        if (empty($depatureMonth)) {
            $depatureMonth = str_pad((date('m') + 1), 2, 0, STR_PAD_LEFT);
        }
        $content .= FormDateElement::showMonthSelect(
                "departure_monat", $depatureMonth
        );
        $content .= FormDateElement::showYearSelect(
                "departure_jahr", $item['departure_jahr']
        );
        $content .= '</td></tr>';
        if (isset($validateErrors['airline'])) {
            $content .= '<tr class="error">';
        } else {
            $content .= '<tr>';
        }
        $content .= '<td class="trow1"><b>' . $lang->airline . ':</b>*</td>'
            . '<td class="trow1"><input placeholder="' . $lang->airline . '"'
            . ' value="' . $item['airline'] . '" type="text" name="airline" '
            . 'size="40" maxlength="200" /></td></tr>';
        if (isset($validateErrors['place'])) {
            $content .= '<tr class="error">';
        } else {
            $content .= '<tr>';
        }
        $content .= '<td class="trow2"><b>' . $lang->place . ':</b>*</td>'
            . '<td class="trow2"><input placeholder="' . $lang->place . '" '
            . 'value="' . $item['place'] . '" type="text" name="place" '
            . 'size="40" maxlength="200" /></td></tr>';
        if (isset($validateErrors['hotel'])) {
            $content .= '<tr class="error">';
        } else {
            $content .= '<tr>';
        }
        $content .= '<td class="trow1"><b>' . $lang->hotel . ':</b>*</td>'
            . '<td class="trow1"><input placeholder="' . $lang->hotel . '" '
            . 'value="' . $item['hotel'] . '" type="text" name="hotel" '
            . 'size="40" maxlength="200" /></td></tr>';
        if (isset($validateErrors['phone'])) {
            $content .= '<tr class="error">';
        } else {
            $content .= '<tr>';
        }
        $content .= '<td class="trow2"><b>' . $lang->phoneAt . ' '
            . $mybb->settings["awayListCountry"] . ':</b></td>'
            . '<td class="trow2"><input placeholder="' . $lang->phoneAt . ' '
            . $mybb->settings["awayListCountry"] . '" value="' . $item['phone']
            . '" type="text" name="phone" size="25" maxlength="200" /></td>'
            . '</tr><tr><td class="trow1">* = ' . $lang->requiredFields
            . '</td><td class="trow1"><input type="submit" name="addAwlItem" '
            . 'value="' . $lang->addToList . '"></td></tr></tbody></table>'
            . '</form>';

        return $content;
    }

}

/**
 * Repository of AwayList items
 * 
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Plugin_Model_Repository
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */
class AwayList_Item_Repository
{

    /**
     * access to the global $db
     * 
     * @var DB_MySQL|DB_MySQLi|DB_PgSQL|DB_SQLite
     */
    protected $_database;

    /**
     * access to the global $mybb
     * 
     * @var MyBB 
     */
    protected $_mybb;

    /**
     * get the repository
     */
    public function __construct()
    {
        $this->_initMybb();
        $this->_initDatabase();
    }

    /**
     * get the global MyBB object
     * 
     * @global MyBB
     * @return void 
     */
    protected function _initMybb()
    {
        global $mybb;

        if (!empty($mybb)) {
            $this->_mybb = &$mybb;
        }
    }

    /**
     * get the global database object
     * 
     * @global DB_MySQL|DB_MySQLi|DB_PgSQL|DB_SQLite $db 
     * @return void 
     */
    protected function _initDatabase()
    {
        global $db;

        if (!empty($db)) {
            $this->_database = &$db;
        }
    }

    /**
     * Upgrade an old database table
     * 
     * This will be removed someday
     * 
     * @deprecated since version 1.6.8
     * @return void 
     */
    public function upgradeTo165()
    {
        // make shortcut
        $database = $this->_database;

        // rename table of previous versions
        if ($database->table_exists('liste') && !$database->table_exists('awaylist')) {
            $renameTableQuery = 'RENAME TABLE ' . $database->table_prefix . 'liste '
                . ' TO ' . $database->table_prefix . 'awaylist ;';
            $database->write_query($renameTableQuery);
        }

        // update field names of previous versions
        if ($database->table_exists('awaylist')) {
            if ($database->field_exists('ankunft', 'awaylist')) {
                $database->rename_column(
                    'awaylist', 'ankunft', 'arrival', 'int(11) default NULL'
                );
            }
            if ($database->field_exists('abflug', 'awaylist')) {
                $database->rename_column(
                    'awaylist', 'abflug', 'departure', 'int(11) default NULL'
                );
            }
            if ($database->field_exists('ort', 'awaylist')) {
                $database->rename_column(
                    'awaylist', 'ort', 'place', 'varchar(255) NOT NULL'
                );
            }
            if ($database->field_exists('telefon', 'awaylist')) {
                $database->rename_column(
                    'awaylist', 'telefon', 'phone', 'varchar(255) NOT NULL'
                );
            }
            if ($database->field_exists('data_id', 'awaylist')) {
                $database->drop_column('awaylist', 'id');
                $database->rename_column(
                    'awaylist', 'data_id', 'id',
                    'bigint(20) NOT NULL auto_increment'
                );
            }
        }
    }

    /**
     * Fetches a new blank row (not from the database).
     *
     * @param  array $data OPTIONAL data to populate in the new row.
     * @return AwayList_Item
     */
    public function createRow(array $data = array())
    {
        $item = new AwayList_Item();
        if (!empty($data)) {
            $item->setData($data);
        }
        return $item;
    }

    /**
     * delete a single row by id
     * 
     * @param string $whereCondition where condition for delete query
     * @return integer count of affected rows
     */
    public function delete($whereCondition)
    {
        // get affected rows
        $queryItems = $this->_database->simple_select(
            'awaylist', '*', (string) $whereCondition
        );
        $affectedRows = $this->_database->num_rows($queryItems);
        // perform delete query
        $this->_database->delete_query('awaylist', (string) $whereCondition);
        // return count of affected rows
        return $affectedRows;
    }

    /**
     * delete a single row by id
     * 
     * @param integer $id id of the row to delete
     * @return integer count of affected rows
     */
    public function deleteById($id)
    {
        // build condition
        $whereCondition = 'id=\'' . (int) $id . '\'';

        return $this->delete($whereCondition);
    }

    /**
     * delete all rows of a user
     * 
     * @param integer $userId id of the user
     * @return integer count of affected rows
     */
    public function deleteByUserId($userId)
    {
        // build condition
        $whereCondition = 'uid=\'' . (int) $userId . '\'';

        return $this->delete($whereCondition);
    }

    /**
     * fetch a single row by id
     * 
     * @param integer $id id of the row to fetch
     * @return AwayList_Item row with the given id
     */
    public function fetchRowById($id)
    {
        $query = $this->_database->simple_select(
            "awaylist", '*', "id = '" . (int) $id . "'"
        );
        $itemRow = $this->_database->fetch_array($query);
        $item = new AwayList_Item();
        $item->setData($itemRow, $id);
        return $item;
    }

    public function fetchAllByUserId($userId, $options = array())
    {
        // select items of the given user
        $whereCondition = ' ( uid = ' . (int) $userId . ' ) ';

        // skip items from the past
        if (isset($options['includePast']) && $options['includePast'] == false) {
            $whereCondition .= ' AND ( departure >= ' . (int) $timestamp . ' ) ';
        }

        return $this->fetchAll($whereCondition, $options);
    }

    public function fetchAllByDate($timestamp, $options = array())
    {
        // select items where arrival and depature is between the given timestamp
        $whereCondition = ' ( ' . $timestamp . ' BETWEEN arrival AND departure ) ';

        // skip items from the past
        if (!isset($options['includePast']) || $options['includePast'] != true) {
            $whereCondition .= ' AND ( departure >= ' . (int) $timestamp . ' ) ';
        }

        return $this->fetchAll($whereCondition, $options);
    }

    public function fetchAllUpcomming($options = array())
    {
        // skip items from the past
        $whereCondition = ' ( departure >= ' . time() . ' ) ';

        return $this->fetchAll($whereCondition, $options);
    }

    public function countAllUpcomming($options = array())
    {
        // skip items from the past
        $whereCondition = ' ( departure >= ' . time() . ' ) ';

        // perform the query
        $queryItems = $this->_database->simple_select(
            'awaylist', '*', $whereCondition, $options
        );

        return $this->_database->num_rows($queryItems);
    }

    public function fetchAll($whereCondition = null, $options = array())
    {
        $items = array();

        // general query options
        if (!isset($options['order_by'])) {
            $options['order_by'] = 'arrival';
        }

        // prevent empty where condition
        if (empty($whereCondition)) {
            $whereCondition = ' 1=1 ';
        }

        // perform the query
        $queryItems = $this->_database->simple_select(
            'awaylist', '*', $whereCondition, $options
        );
        while ($itemData = $this->_database->fetch_array($queryItems)) {
            $item = new AwayList_Item();
            $item->setData($itemData, $itemData['id']);
            $items[] = $item;
        }

        return $items;
    }

}

/**
 * Item of the awaylist. Representing a record in the database
 * 
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Plugin_Model
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */
class AwayList_Item
{

    /**
     * id of the item
     * 
     * @var integer 
     */
    protected $_id = null;

    /**
     * user id of the user who created the item
     * 
     * @var integer 
     */
    protected $_uid;

    /**
     * username of the user who created the item
     * 
     * @var string 
     */
    protected $_username;

    /**
     * unix timestamp of the start date
     * 
     * @var integer 
     */
    protected $_start;

    /**
     * unix timestamp of the end date
     * 
     * @var integer 
     */
    protected $_end;

    /**
     * array containing the data for the custom fields
     * 
     * @var array 
     */
    protected $_customFieldsData;

    /**
     * array containing the configuration of the custom fields
     * 
     * @var array 
     */
    protected $_customFieldsConfig = array();

    /**
     * array containing the errors which occured during processing
     * 
     * @var array 
     */
    protected $_errors = array();

    /**
     * access to the global $db
     * 
     * @var DB_MySQL|DB_MySQLi|DB_PgSQL|DB_SQLite
     */
    protected $_database;

    /**
     * access to the global $mybb
     * 
     * @var MyBB 
     */
    protected $_mybb;

    /**
     * translation object
     * 
     * @var MyLanguage 
     */
    protected $_translation;

    public function getId()
    {
        return $this->_id;
    }

    public function getUid()
    {
        return $this->_uid;
    }

    public function setUid($uid)
    {
        $this->_uid = $uid;
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function setUsername($username)
    {
        $this->_username = $username;
    }

    public function getStart()
    {
        return $this->_start;
    }

    public function setStart($start)
    {
        $this->_start = $start;
    }

    public function getEnd()
    {
        return $this->_end;
    }

    public function setEnd($end)
    {
        $this->_end = $end;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function hasErrors()
    {
        if (!empty($this->_errors)) {
            return true;
        }
        return false;
    }

    /**
     * create a new AwayList item.<br />
     * if $id is given the object from the database is loaded
     * 
     * @param integer $id 
     */
    public function __construct($id = null)
    {
        $this->_initMybb();
        $this->_initDatabase();

        // load translation
        $this->_loadLanguage();

        // TODO remove when custom fields are implemented
        $this->_customFieldsConfig = array(
            array(
                'id' => 1,
                'label' => 'Airline',
                'name' => 'airline',
                'tableField' => 'airline'
            ),
            array(
                'id' => 2,
                'label' => 'Place',
                'name' => 'place',
                'tableField' => 'place'
            ),
            array(
                'id' => 3,
                'label' => 'Hotel',
                'name' => 'hotel',
                'tableField' => 'hotel'
            ),
            array(
                'id' => 4,
                'label' => 'Phone',
                'name' => 'phone',
                'tableField' => 'phone'
            ),
        );

        // load the object from the database if $id is given
        if ($id != null) {
            $this->loadItem($id);
        }
    }

    /**
     * Enable retreival and setting of field values if getter-function or 
     * setter-function does not exist
     *
     * @param string $method
     * @param array $args
     * @return mixed
     * @throws Zend_Db_Table_Row_Exception 
     */
    public function __call($method, array $arguments)
    {
        $matches = array();
        if (preg_match('/^get(\w+)$/', $method, $matches)) {
            $field = $matches[1];
            $field{0} = strtolower($field{0});
            if (isset($this->$field)) {
                return $this->$field;
            }
        } elseif (preg_match('/^set(\w+)$/', $method, $matches)) {
            $field = $matches[1];
            $field{0} = strtolower($field{0});
            if (isset($this->$field)) {
                return $field = $arguments[0];
            }
        } else {
            throw new Exception("Unrecognized method '$method()'");
        }
    }

    public function __get($name)
    {
        // FIXME remove legacy code as soon as possible
        if ($name == 'arrival') {
            $name = 'start';
        }
        if ($name == 'departure') {
            $name = 'end';
        }
        if ($name == 'sort_id') {
            return;
        }

        $getterFunction = 'get' . strtoupper(substr($name, 0, 1))
            . substr($name, 1);
        if (method_exists($this, $getterFunction)) {
            return call_user_method($getterFunction, $this);
        } else {
            foreach ($this->_customFieldsConfig as $customField) {
                if ($customField['name'] == $name) {
                    $fieldId = $customField['id'];
                    return $this->_customFieldsData[$fieldId];
                }
            }
        }
        throw new Exception("Unrecognized property '$name'");
    }

    public function __set($name, $value)
    {
        // FIXME remove legacy code as soon as possible
        if ($name == 'arrival') {
            $name = 'start';
        }
        if ($name == 'departure') {
            $name = 'end';
        }
        if ($name == 'sort_id') {
            return;
        }

        $setterFunction = 'set' . strtoupper(substr($name, 0, 1))
            . substr($name, 1);
        if (method_exists($this, $setterFunction)) {
            return call_user_method($setterFunction, $this, $value);
        } else {
            foreach ($this->_customFieldsConfig as $customField) {
                if ($customField['name'] == $name) {
                    $fieldId = $customField['id'];
                    return $this->_customFieldsData[$fieldId] = $value;
                }
            }
        }
        return false;
        throw new Exception("Can't set value! Unrecognized property '$name'");
    }

    public function __isset($name)
    {
        foreach ($this->_customFieldsConfig as $customField) {
            if ($customField['name'] == $name) {
                $fieldId = $customField['id'];
                return isset($this->_customFieldsData[$fieldId]);
            }
        }
        return false;
    }

    public function __unset($name)
    {
        foreach ($this->_customFieldsConfig as $customField) {
            if ($customField['name'] == $name) {
                $fieldId = $customField['id'];
                unset($this->_customFieldsData[$fieldId]);
                return;
            }
        }
        return false;
    }

    /**
     * convert the row object to an array
     * 
     * @return array array containing every property and its values 
     */
    public function toArray()
    {
        $data = $this->_prepareData();
        $data['id'] = $this->_id;
        $data['arrival_tag'] = date('d', $data['arrival']);
        $data['arrival_monat'] = date('m', $data['arrival']);
        $data['arrival_jahr'] = date('Y', $data['arrival']);
        $data['departure_tag'] = date('d', $data['departure']);
        $data['departure_monat'] = date('m', $data['departure']);
        $data['departure_jahr'] = date('Y', $data['departure']);
        return $data;
    }

    /**
     * get the global MyBB object
     * 
     * @global MyBB
     * @return void 
     */
    protected function _initMybb()
    {
        global $mybb;

        if (!empty($mybb)) {
            $this->_mybb = &$mybb;
        }
    }

    /**
     * get the global database object
     * 
     * @global DB_MySQL|DB_MySQLi|DB_PgSQL|DB_SQLite $db 
     * @return void 
     */
    protected function _initDatabase()
    {
        global $db;

        if (!empty($db)) {
            $this->_database = &$db;
        }
    }

    /**
     * load the translation
     * 
     * @global MyLanguage $lang
     * @return MyLanguage 
     */
    protected function _loadLanguage()
    {
        global $lang;

        // get the translation object
        if (empty($lang) || !$lang instanceof MyLanguage) {
            // Language initialisation
            require_once MYBB_ROOT . 'inc/class_language.php';
            $lang = new MyLanguage;
            $lang->set_path(MYBB_ROOT . 'inc/languages');
            $lang->set_language('english');
        }

        // load the translation
        @$lang->load('awaylist', false, true);

        // register the object in the class
        $this->_translation = $lang;

        // return the object for method chaining
        return $this->_translation;
    }

    /**
     * Saves the properties to the database.
     *
     * This performs an intelligent insert/update, and reloads the
     * properties with fresh data from the table on success.
     *
     * @return integer the id of the inserted row
     */
    public function save()
    {
        /**
         * If the id is empty,
         * this is an INSERT of a new row.
         * Otherwise it is an UPDATE.
         */
        if (empty($this->_id)) {
            return $this->_doInsert();
        } else {
            return $this->_doUpdate();
        }
    }

    /**
     * associative array of the object properties
     * 
     * @return array 
     */
    protected function _prepareData()
    {
        $data = array(
            'uid' => $this->_uid,
            'username' => $this->_username,
            'arrival' => $this->_start,
            'departure' => $this->_end,
            'airline' => $this->airline,
            'place' => $this->place,
            'hotel' => $this->hotel,
            'phone' => $this->phone,
        );

        return $data;
    }

    /**
     * perform the actual insert query.<br />
     * return the id of the inserted row
     * 
     * @return integer 
     */
    protected function _doInsert()
    {
        $data = $this->_prepareData();

        $this->_id = $this->_database->insert_query('awaylist', $data);

        return $this->_id;
    }

    /**
     * perform the actual update query.<br />
     * return the id of the updated row
     * 
     * @return integer 
     */
    protected function _doUpdate()
    {
        $data = $this->_prepareData();

        $this->_database->update_query('awaylist', $data, 'id=' . $this->id);

        return $this->_id;
    }

    public function setData($data, $id = null)
    {
        // calculate timestamo from seperated fields
        $arrival = null;
        if (array_key_exists('arrival_monat', $data)
            && array_key_exists('arrival_tag', $data)
            && array_key_exists('arrival_jahr', $data)
        ) {
            $arrival = mktime(
                0, 0, 0, $data['arrival_monat'], $data['arrival_tag'],
                $data['arrival_jahr']
            );
        }
        $departure = null;
        if (array_key_exists('departure_monat', $data)
            && array_key_exists('departure_tag', $data)
            && array_key_exists('departure_jahr', $data)
        ) {
            $departure = mktime(
                0, 0, 0, $data['departure_monat'], $data['departure_tag'],
                $data['departure_jahr']
            );
        }
        if (empty($data['arrival']) && !empty($arrival)) {
            $data['arrival'] = $arrival;
        }
        if (empty($data['departure']) && !empty($departure)) {
            $data['departure'] = $departure;
        }

        foreach ($data as $field => $value) {
            $this->$field = $value;
        }

        if (!empty($id)) {
            $this->_id = $id;
        }

        return $this;
    }

    public function isValid($data)
    {
        $valid = true;

        if (!is_array($errors)) {
            $errors = (array) $errors;
        }

        // shortcuts
        $lang = $this->_translation;

        if (empty($data['airline'])) {
            $errors['airline'] = $lang->errorAirlineMissing;
        }
        if (empty($data['place'])) {
            $errors['place'] = $lang->errorMissingPlace;
        }
        if (empty($data['hotel'])) {
            $errors['hotel'] = $lang->errorMissingHotel;
        }
        if (!preg_match("/^[0-9[:space:]]*$/", $data['phone'])) {
            $errors['phone'] = $lang->errorInvalidPhoneNumber;
        }
        $arrival = mktime(
            0, 0, 0, $data['arrival_monat'], $data['arrival_tag'],
            $data['arrival_jahr']
        );
        $departure = mktime(
            0, 0, 0, $data['departure_monat'], $data['departure_tag'],
            $data['departure_jahr']
        );

        // check for overlapping journeys
        $countTrips = null;
        $uid = $data['uid'];
        if (!empty($this->_uid)) {
            $uid = $this->_uid;
        }
        $whereCondition = 'uid = ' . $uid
            . ' AND ( ( arrival BETWEEN ' . $arrival
            . ' AND ' . $departure . ' ) '
            . ' OR ( departure  BETWEEN ' . $arrival
            . ' AND ' . $departure . ' ) '
            . ' OR ( arrival >= ' . $arrival
            . ' AND departure <= ' . $departure . ' ) )';
        if (!empty($this->_id)) {
            $whereCondition .= ' AND id !=' . $this->_id;
        }
        $query = $this->_database->simple_select(
            'awaylist', '*', $whereCondition
        );
        while ($result = $this->_database->fetch_array($query)) {
            $existingJourney = ' (' . date('d.m.Y', $result['arrival'])
                . ' bis ' . date('d.m.Y', $result['departure']) . ')';
            $errors['arrival' . $countTrips] = $lang->errorAlreadyAway . $existingJourney;
            $countTrips++;
        }

        // new items must be in the future
        if ($this->_id == null) {
            if ($arrival < time()) {
                $errors['arrival'] = $lang->errorArrivalNotInFuture;
            }
            if ($departure < time()) {
                $errors['depature'] = $lang->errorDepartureNotInFuture;
            }
        }
        if ($departure <= $arrival) {
            $errors['depature'] = $lang->errorArrivalNotBeforeDeparture;
        }

        // if any error occurred
        if (count($errors) > 0) {
            $valid = false;
        }

        $this->_errors = $errors;
        return $valid;
    }

}