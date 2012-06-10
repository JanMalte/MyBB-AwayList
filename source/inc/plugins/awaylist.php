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
     * @subpackage  Plugin
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
    AwayList::upgradeTo165();

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

// @codeCoverageIgnoreEnd
/** * *******************************************************************
 * 
 * PLUGIN CODE
 * 
 * ******************************************************************** */
// @codeCoverageIgnoreStart
// add plugin hooks
$plugins->add_hook('index_start', 'awaylistShowListOnIndexHook');
$plugins->add_hook('global_start', 'awaylistLoadLanguageHook');
$plugins->add_hook('awaylist_showList', 'awaylistShowListHook');
$plugins->add_hook('admin_users_do_delete', 'awaylistDeleteUserHook');

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
 * @global MyLanguage $lang
 * @global string $awaylist 
 */
function awaylistShowListOnIndexHook()
{
    global $mybb, $lang, $awaylist;

    // load the language
    $lang->load('awaylist', false, true);

    $awaylist = '';
    if ($mybb->settings['showAwayListOnlyForMembers'] == '1'
        && $mybb->user['uid'] != 0) {
        if ($mybb->settings['showAwayList'] == '1'
            && $mybb->settings['showAwayListOnIndex'] == '1') {
            $awaylist = AwayList::getContent();
        }
    }
}

/**
 * show awaylist on own page
 * 
 * @global MyBB $mybb
 * @global MyLanguage $lang
 * @global type $theme
 * @global type $templates
 * @global type $headerinclude
 * @global type $header
 * @global type $footer 
 */
function awaylistShowListHook()
{
    global $mybb, $lang, $theme, $templates;

    // variables used in the templates
    global $headerinclude, $header, $footer;

    // load language
    $lang->load('awaylist', false, true);

    // check if the user has the permission to view the list
    if ($mybb->settings['showAwayListOnlyForMembers'] == '1'
        && $mybb->user['uid'] == 0) {
        error_no_permission();
    }

    // get the main content to display
    $content = AwayList::getContent();

    if ($content !== false) {
        // load the template and fill the placeholders
        eval("\$showList = \"" . $templates->get("show_awaylist") . "\";");
        output_page($showList);
    }
}

/**
 * delete the items of the user which is being deleted
 * 
 * @global type $db
 * @global MyBB $mybb 
 */
function awaylistDeleteUserHook()
{
    global $db, $mybb;

    $uid = intval($mybb->input['uid']);
    $db->delete_query('awaylist', 'uid=\'' . $uid . '\'');
}

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
            require_once MYBB_ROOT . "inc/class_language.php";
            $lang = new MyLanguage;
            $lang->set_path(MYBB_ROOT . "inc/languages");
        }

        // load the translation
        $lang->load("awaylist", false, true);

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
     * Upgrade an old database table to the new format.<br />
     * This will be removed in the future someday
     * 
     * @deprecated since version 1.6.8
     * @global DB_MySQL $db 
     * @return void 
     */
    public static function upgradeTo165()
    {
        global $db;

        // rename table of previous versions
        if ($db->table_exists('liste') && !$db->table_exists('awaylist')) {
            $renameTableQuery = 'RENAME TABLE ' . $db->table_prefix . 'liste '
                . ' TO ' . $db->table_prefix . 'awaylist ;';
            $db->write_query($renameTableQuery);
        }

        // update field names of previous versions
        if ($db->table_exists('awaylist')) {
            if ($db->field_exists('ankunft', 'awaylist')) {
                $db->rename_column(
                    'awaylist', 'ankunft', 'arrival', 'int(11) default NULL'
                );
            }
            if ($db->field_exists('abflug', 'awaylist')) {
                $db->rename_column(
                    'awaylist', 'abflug', 'departure', 'int(11) default NULL'
                );
            }
            if ($db->field_exists('ort', 'awaylist')) {
                $db->rename_column(
                    'awaylist', 'ort', 'place', 'varchar(255) NOT NULL'
                );
            }
            if ($db->field_exists('telefon', 'awaylist')) {
                $db->rename_column(
                    'awaylist', 'telefon', 'phone', 'varchar(255) NOT NULL'
                );
            }
            if ($db->field_exists('data_id', 'awaylist')) {
                $db->drop_column('awaylist', 'id');
                $db->rename_column(
                    'awaylist', 'data_id', 'id',
                    'bigint(20) NOT NULL auto_increment'
                );
            }
        }
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
     * @global MyBB $mybb 
     * @return void 
     */
    public static function installSettings()
    {
        global $db, $mybb;
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

    /**
     * get the html code to display
     * 
     * @global MyBB $mybb
     * @return string the html content 
     */
    public static function getContent()
    {
        global $mybb;

        // load translation
        $lang = self::loadLanguage();

        $message = null;
        $content = null;
        if ($mybb->settings['showAwayList'] != '1') {
            $content = '<div class="error low_warning"><p><em>'
                . $lang->followingErrors
                . '</em></p>';
            $content .= '<p><ul>';
            $content .= '<li>' . $lang->errorNoDisplay . '</li>';
            $content .= '</ul></p></div>';
        } else {

            // get/set the limit
            $cookieArray = unserialize(
                $_COOKIE[$mybb->settings['cookieprefix'] . 'awaylist']
            );
            $limit = $cookieArray['displayLimit'];
            if ($mybb->input['action'] == "setAwlLimit") {
                $limit = $cookieArray['displayLimit'] = $mybb->input['limit'];
                my_setcookie('awaylist', serialize($cookieArray), 3600, true);
            }

            // decide what to do
            switch ($mybb->input['action']) {
                case 'editAwlItem':
                    $message = '';
                    if ($mybb->input['step2'] == 'true'
                        && self::editItem($message, $validateErrors) == true
                    ) {
                        $message = '<p class="validation_success">'
                            . $lang->editItemSuccessful
                            . '</p>';
                        $content = self::showFullTable(null, $limit);
                    } else {
                        add_breadcrumb($lang->editItem);
                        $content = self::showEditItemForm($validateErrors);
                    }
                    break;
                case 'deleteAwlItem':
                    if ($mybb->input['step2'] == 'true'
                        && self::deleteItem($mybb->input['id']) == true
                    ) {
                        $message = '<p class="validation_success">'
                            . $lang->deleteItemSuccessful
                            . '</p>';
                        $content = self::showFullTable(null, $limit);
                    } else {
                        add_breadcrumb($lang->deleteItem);
                        $content = self::showDeleteConfirmDialog();
                    }
                    break;
                case 'addAwlItem':
                    $message = '';
                    if ($mybb->input['step2'] == 'true'
                        && self::insertNewItem($message, $validateErrors) == true
                    ) {
                        $message = '<p class="validation_success">'
                            . $lang->addItemSuccessful
                            . '</p>';
                        $content = self::showFullTable(null, $limit);
                    } else {
                        add_breadcrumb($lang->newItem);
                        $content = self::showNewItemForm($validateErrors);
                    }
                    break;
                case 'setAwlTimestamp':
                    $timestamp = mktime(
                        0, 0, 0, $mybb->input['time_monat'],
                        $mybb->input['time_tag'], $mybb->input['time_jahr']
                    );
                    $content = self::showFullTable($timestamp, $limit);
                    break;
                default:
                    $content = self::showFullTable(null, $limit);
                    break;
            }
        }

        if ($content !== false) {
            $content = $message . $content . '<br />';
        }
        return $content;
    }

    /**
     * show the table with all items
     * 
     * @global DB_MySQL $db
     * @global MyBB $mybb
     * @global mixed $templates
     * @global mixed $theme
     * @param integer $timestamp
     * @param integer $limit
     * @param integer $startLimit
     * @return string 
     */
    public static function showFullTable($timestamp = null, $limit = 20,
        $startLimit = 0)
    {
        global $db, $mybb, $templates, $theme;

        // load translation
        $lang = self::loadLanguage();

        // limit of displayed items
        $limit = max(array(1, $limit));

        // build the select query; add timestamp if given
        $timeStampNotice = '';
        if ($timestamp != null) {
            $whereCondition = $timestamp . ' BETWEEN arrival AND departure';
            $timeStampNotice = '<tr><td class="tcat" colspan="9"><strong>'
                . $lang->personsCurrentlyThere . date(" d.m.Y ", $timestamp)
                . $lang->in . ' ' . $mybb->settings["awayListCountry"]
                . '</strong></td></tr>';
        } else {
            $timestamp = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
            $whereCondition = 'departure >= ' . $timestamp;
        }
        $options = array(
            'order_by' => 'arrival',
            'limit_start' => $startLimit,
            'limit' => $limit
        );
        $queryItems = $db->simple_select(
            'awaylist', '*', $whereCondition, $options
        );

        $countUsers = 0;
        $countUsers = $db->num_rows($queryItems);

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
        while ($item = $db->fetch_array($queryItems)) {
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
                    . '?action=editAwlItem&id=' . $item['id'] . '">'
                    . '<img src="' . $mybb->settings['bburl']
                    . '/images/awaylist/pencil.png" border="0">'
                    . '</a>' . PHP_EOL
                    . '<a class="icon" href="' . $mybb->settings["bburl"]
                    . '/' . THIS_SCRIPT . '?action=deleteAwlItem&id='
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
     * shows the insert form for a new item
     * 
     * @global MyBB $mybb
     * @param array $validateErrors
     * @return string the html content 
     */
    public static function showNewItemForm($validateErrors = null)
    {
        global $mybb;

        $item = array(
            'arrival_tag' => $mybb->input['arrival_tag'],
            'arrival_monat' => $mybb->input['arrival_monat'],
            'arrival_jahr' => $mybb->input['arrival_jahr'],
            'departure_tag' => $mybb->input['departure_tag'],
            'departure_monat' => $mybb->input['departure_monat'],
            'departure_jahr' => $mybb->input['departure_jahr'],
            'airline' => $mybb->input['airline'],
            'place' => $mybb->input['place'],
            'hotel' => $mybb->input['hotel'],
            'phone' => $mybb->input['phone'],
        );

        $content = self::getItemForm($item, 'addAwlItem', $validateErrors);
        return $content;
    }

    /**
     * show the edit form
     * 
     * @global DB_MySQL $db
     * @global MyBB $mybb
     * @global mixed $templates
     * @param array $validateErrors
     * @return string the html content 
     */
    public static function showEditItemForm($validateErrors = null)
    {
        global $db, $mybb, $templates;

        // load translation
        $lang = self::loadLanguage();

        $query = $db->simple_select(
            "awaylist", '*', "id = '" . $mybb->input['id'] . "'"
        );
        $item = $db->fetch_array($query);

        $errors = array();
        if ($item['uid'] != $mybb->user['uid'] && !self::isUserInGroup(4)) {
            $errors[] = $lang->errorNoPermission;
        }
        if ($mybb->input['id'] == '') {
            $errors[] = $lang->errorNoItemSelected;
        }

        $content = '';

        // if any error occurred
        if (!empty($errors)) {
            $showList = '';
            add_breadcrumb($lang->editItem);
            $content .= '<div class="error low_warning"><p><em>'
                . $lang->followingErrors
                . '</em></p>';
            $content .= '<p><ul>';
            foreach ($errors as $error) {
                $content .= '<li>' . $error . '</li>';
            }
            $content .= '</ul></p>';
            $content .= '<a href="javascript:history.back()">'
                . $lang->back
                . '</a></div>';
            eval("\$showList = \"" . $templates->get("show_awaylist") . "\";");
            output_page($showList);
            $content = false;
        } else {
            $item['arrival_tag'] = date('d', $item['arrival']);
            $item['arrival_monat'] = date('m', $item['arrival']);
            $item['arrival_jahr'] = date('Y', $item['arrival']);
            $item['departure_tag'] = date('d', $item['departure']);
            $item['departure_monat'] = date('m', $item['departure']);
            $item['departure_jahr'] = date('Y', $item['departure']);
            foreach ($mybb->input as $key => $value) {
                if (array_key_exists($key, $item)) {
                    $item[$key] = $value;
                }
            }
            $content = self::getItemForm($item, 'editAwlItem', $validateErrors);
        }
        return $content;
    }

    /**
     * show delete confirm dialog
     * 
     * @global DB_MySQL $db
     * @global MyBB $mybb
     * @global mixed $templates
     * @return string the html message 
     */
    public static function showDeleteConfirmDialog()
    {
        global $db, $mybb, $templates;

        // load translation
        $lang = self::loadLanguage();

        $query = $db->simple_select(
            "awaylist", '*', "id = '" . $mybb->input['id'] . "'"
        );
        $item = $db->fetch_array($query);

        $errors = array();
        if ($item['uid'] != $mybb->user['uid'] && !self::isUserInGroup(4)) {
            $errors[] = $lang->errorNoPermission;
        }
        if ($mybb->input['id'] == '') {
            $errors[] = $lang->errorNoItemSelected;
        }

        // if any error occurred
        if (!empty($errors)) {
            $showList = '';
            add_breadcrumb($lang->deleteItem);
            $content .= '<div class="error low_warning"><p><em>'
                . $lang->followingErrors
                . '</em></p>';
            $content .= '<p><ul>';
            foreach ($errors as $error) {
                $content .= '<li>' . $error . '</li>';
            }
            $content .= '</ul></p>';
            $content .= '<a href="javascript:history.back()">'
                . $lang->back
                . '</a></div>';
            eval("\$showList .= \"" . $templates->get("show_awaylist") . "\";");
            output_page($showList);
            $content = false;
        } else {
            $content = '<form action="' . $mybb->settings["bburl"] . '/'
                . THIS_SCRIPT . '" method="post">'
                . '<input type="hidden" name="action" value="deleteAwlItem" />'
                . '<input type="hidden" name="step2" value="true" />'
                . ' <input type="hidden" name="id" value="' . $item['id'] . '" />'
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
     * insert the new item
     * 
     * @global MyBB $mybb
     * @global DB_MySQL $db
     * @param string $message 
     * @param array $validateErrors 
     * @return boolean if successful 
     */
    public static function insertNewItem(&$message = '', &$validateErrors = null)
    {
        global $db, $mybb;

        $errors = array();
        if (self::validateItem($errors) == true) {
            $arrival = mktime(
                0, 0, 0, $mybb->input['arrival_monat'],
                $mybb->input['arrival_tag'], $mybb->input['arrival_jahr']
            );
            $departure = mktime(
                0, 0, 0, $mybb->input['departure_monat'],
                $mybb->input['departure_tag'], $mybb->input['departure_jahr']
            );
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
            $validateErrors = $errors;
            $message = self::getHtmlErrorMessage($errors);
            return false;
        }
        return false;
    }

    /**
     * update the item
     * 
     * @global MyBB $mybb
     * @global DB_MySQL $db
     * @param string $message 
     * @param array $validateErrors 
     * @return boolean if successful
     */
    public static function editItem(&$message = '', &$validateErrors = null)
    {
        global $db, $mybb;

        $errors = array();
        if (self::validateItem($errors, $mybb->input['id']) == true) {
            $arrival = mktime(
                0, 0, 0, $mybb->input['arrival_monat'],
                $mybb->input['arrival_tag'], $mybb->input['arrival_jahr']
            );
            $departure = mktime(
                0, 0, 0, $mybb->input['departure_monat'],
                $mybb->input['departure_tag'], $mybb->input['departure_jahr']
            );
            $insertData = array(
                'arrival' => $db->escape_string($arrival),
                'departure' => $db->escape_string($departure),
                'airline' => $db->escape_string($mybb->input['airline']),
                'place' => $db->escape_string($mybb->input['place']),
                'hotel' => $db->escape_string($mybb->input['hotel']),
                'phone' => $db->escape_string($mybb->input['phone']),
            );
            $db->update_query(
                'awaylist', $insertData, "id = '{$mybb->input['id']}'"
            );
            return true;
        } else {
            $message = self::getHtmlErrorMessage($errors);
            $validateErrors = $errors;
            return false;
        }
        return false;
    }

    /**
     * validate an item
     * 
     * @global MyBB $mybb
     * @global DB_MySQL $db
     * @param array $errors array which will contain all errors
     * @param integer $editItemId
     * @return boolean true if the item values are valid 
     */
    public static function validateItem(&$errors, $editItemId = null)
    {
        global $mybb, $db;

        if (!is_array($errors)) {
            $errors = array();
        }

        // load translation
        $lang = self::loadLanguage();

        if (empty($mybb->input['airline'])) {
            $errors['airline'] = $lang->errorAirlineMissing;
        }
        if (empty($mybb->input['place'])) {
            $errors['place'] = $lang->errorMissingPlace;
        }
        if (empty($mybb->input['hotel'])) {
            $errors['hotel'] = $lang->errorMissingHotel;
        }
        if (!preg_match("/^[0-9[:space:]]*$/", $mybb->input['phone'])) {
            $errors['phone'] = $lang->errorInvalidPhoneNumber;
        }
        $arrival = mktime(
            0, 0, 0, $mybb->input['arrival_monat'], $mybb->input['arrival_tag'],
            $mybb->input['arrival_jahr']
        );
        $departure = mktime(
            0, 0, 0, $mybb->input['departure_monat'],
            $mybb->input['departure_tag'], $mybb->input['departure_jahr']
        );

        $userId = $mybb->user['uid'];
        if ($editItemId != null) {
            $query = $db->simple_select(
                "awaylist", '*', "id = '" . $editItemId . "'"
            );
            $editItem = $db->fetch_array($query);
            $userId = $editItem['uid'];
        }
        $whereCondition = 'uid = ' . $userId
            . ' AND ( ( arrival BETWEEN ' . $arrival
            . ' AND ' . $departure . ' ) '
            . ' OR ( departure  BETWEEN ' . $arrival
            . ' AND ' . $departure . ' ) '
            . ' OR ( arrival >= ' . $arrival
            . ' AND departure <= ' . $departure . ' ) )';
        $query = $db->simple_select("awaylist", "*", $whereCondition);
        $countTrips = null;
        while ($result = $db->fetch_array($query)) {
            if ($result['id'] != $editItemId) {
                $existingJourney = ' (' . date('d.m.Y', $result['arrival'])
                    . ' bis ' . date('d.m.Y', $result['departure']) . ')';
                $errors['arrival' . $countTrips] = $lang->errorAlreadyAway . $existingJourney;
                $countTrips++;
            }
        }

        if ($editItemId == null) {
            if ($arrival < time()) {
                $errors['arrival'] = $lang->errorArrivalNotInFuture;
            }
        }
        if ($departure < time()) {
            $errors['depature'] = $lang->errorDepartureNotInFuture;
        }
        if ($departure <= $arrival) {
            $errors['depature'] = $lang->errorArrivalNotBeforeDeparture;
        }

        // if any error occurred
        if (count($errors) > 0) {
            return false;
        }
        return true;
    }

    /**
     * delete the item
     * 
     * @global DB_MySQL $db
     * @global MyBB $mybb
     * @global mixed $templates
     * @global mixed $header
     * @global mixed $headerinclude
     * @global mixed $footer
     * @param integer $itemId
     * @return boolean 
     */
    public static function deleteItem($itemId)
    {
        global $db, $mybb, $templates;

        // variables used in the template
        global $header, $headerinclude, $footer;

        // load translation
        $lang = self::loadLanguage();

        $itemId = (int) $itemId;

        $query = $db->simple_select(
            "awaylist", '*', "id = '" . $itemId . "'"
        );
        $item = $db->fetch_array($query);

        $errors = array();
        if (( $item['uid'] != $mybb->user['uid'] )
            && (!self::isUserInGroup(4) )
        ) {
            $errors[] = $lang->errorNoPermission;
        }
        if ($itemId == '' || empty($item)) {
            $errors[] = $lang->errorNoItemSelected;
        }

        // if any error occurred
        if (!empty($errors)) {
            $showList = '';

            add_breadcrumb($lang->deleteItem);
            $content .= '<div class="error low_warning"><p><em>'
                . $lang->followingErrors
                . '</em></p>';
            $content .= '<p><ul>';
            foreach ($errors as $error) {
                $content .= '<li>' . $error . '</li>';
            }
            $content .= '</ul></p>';
            $content .= '<a href="javascript:history.back()">'
                . $lang->back
                . '</a></div>';
            eval("\$showList = \"" . $templates->get("show_awaylist") . "\";");
            output_page($showList);
            exit;
        }

        $db->delete_query("awaylist", "id='{$itemId}'");
        return true;
    }

    /**
     * get the HTML code for the error messages
     * 
     * @param array $errors
     * @return string 
     */
    public static function getHtmlErrorMessage($errors)
    {
        // load translation
        $lang = self::loadLanguage();

        // add error container
        $content = '<div class="error low_warning"><p><em>'
            . $lang->followingErrors . '</em></p>'
            . '<p><ul>';

        // add every error message
        foreach ($errors as $error) {
            $content .= '<li>' . $error . '</li>';
        }

        // finish error container
        $content .= '</ul></p></div>';

        // return html code
        return $content;
    }

    /**
     * get the html for the item form
     * 
     * @global MyBB $mybb 
     * @param array $item 
     * @param string $action 
     * @param array $validateErrors 
     * @return string 
     */
    public static function getItemForm($item, $action = 'addAwlItem',
        $validateErrors = null)
    {
        global $mybb;

        // load translation
        $lang = self::loadLanguage();

        $content = '<style>.error input {border-color: #B94A48;color: #B94A48;}'
            . '.error td {background-color: #F2DEDE!important;}</style>'
            . '<form action="' . $mybb->settings["bburl"] . '/' . THIS_SCRIPT
            . '" method="post">'
            . '<input type="hidden" name="action" value="' . $action . '" />'
            . '<input type="hidden" name="id" value="' . $item['id'] . '" />'
            . '<input type="hidden" name="step2" value="true" />'
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
                "departure_tag", $mybb->input['departure_tag']
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
            . 'size="40" maxlength="20" /></td></tr>';
        if (isset($validateErrors['place'])) {
            $content .= '<tr class="error">';
        } else {
            $content .= '<tr>';
        }
        $content .= '<td class="trow2"><b>' . $lang->place . ':</b>*</td>'
            . '<td class="trow2"><input placeholder="' . $lang->place . '" '
            . 'value="' . $item['place'] . '" type="text" name="place" '
            . 'size="40" maxlength="20" /></td></tr>';
        if (isset($validateErrors['hotel'])) {
            $content .= '<tr class="error">';
        } else {
            $content .= '<tr>';
        }
        $content .= '<td class="trow1"><b>' . $lang->hotel . ':</b>*</td>'
            . '<td class="trow1"><input placeholder="' . $lang->hotel . '" '
            . 'value="' . $item['hotel'] . '" type="text" name="hotel" '
            . 'size="40" maxlength="20" /></td></tr>';
        if (isset($validateErrors['phone'])) {
            $content .= '<tr class="error">';
        } else {
            $content .= '<tr>';
        }
        $content .= '<td class="trow2"><b>' . $lang->phoneAt . ' '
            . $mybb->settings["awayListCountry"] . ':</b></td>'
            . '<td class="trow2"><input placeholder="' . $lang->phoneAt . ' '
            . $mybb->settings["awayListCountry"] . '" value="' . $item['phone']
            . '" type="text" name="phone" size="25" maxlength="15" /></td>'
            . '</tr><tr><td class="trow1">* = ' . $lang->requiredFields
            . '</td><td class="trow1"><input type="submit" name="addAwlItem" '
            . 'value="' . $lang->addToList . '"></td></tr></tbody></table>'
            . '</form>';

        return $content;
    }

}