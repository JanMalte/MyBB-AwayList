<?php
/**
 * AwayList plugin for MyBB
 * 
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Plugin
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @filesource
 */
// allow mybb access
define('IN_MYBB', 1);

// name of the file
define('THIS_SCRIPT', 'awaylist.php');

// set to "1" if this page should be hidden on the online list; default is "0"
define('NO_ONLINE', 0);

// define variables before global.php
$lang = null;
$pluginsCache = null;
$mybb = null;
$plugins = null;
$templates = null;
$showList = null;

// include the global MyBB context
require_once 'global.php';

// load language for the plugin
$lang->load('awaylist', false, true);

// get the plugin information
if (!$pluginsCache) {
    $pluginsCache = $cache->read('plugins');
}

// is the plugin active
if (isset($pluginsCache['active']['awaylist'])) {

    // show no permission error if the list should only be displayed to members
    if ($mybb->settings['showAwayListOnlyForMembers'] == '1'
        && $mybb->user['uid'] == 0
    ) {
        // show error page
        error_no_permission();
    } else {

        // only show list if set in plugin settings
        if ($mybb->settings['showAwayList'] == '1') {

            // add breadcrumb item
            add_breadcrumb($lang->liste, THIS_SCRIPT);

            // run hook for displaying the awaylist
            $plugins->run_hooks('awaylist_showList');
        }
    }
} else {
    // add breadcrumb item
    add_breadcrumb($lang->liste, THIS_SCRIPT);

    // generate content
    $content .= '<div class="error low_warning">
        <p><em>' . $lang->followingErrors . '</em></p>';
    $content .= '<p><ul>';
    $content .= '<li>' . $lang->errorNotActive . '</li>';
    $content .= '</ul></p>';
    $content .= '<a href="javascript:history.back()">' . $lang->back . '</a>
        </div>';

    // get the template and replace all placeholders
    eval("\$showList = \"" . $templates->get("show_awaylist") . "\";");
    
    // output the page
    output_page($showList);
}