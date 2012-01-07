<?php

/**
 * @version     show_list.php 2012-01-07
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Plugin
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
define("IN_MYBB", 1);
define('THIS_SCRIPT', 'show_list.php');
// set to "1" if this page should be hidden on the online list
// default is "0"
define("NO_ONLINE", 0);

// include the global MyBB context
require("./global.php");
// TODO check if this can be replaced by the hook system
require_once("./inc/plugins/liste.php");

// load language for the plugin
$lang->load("liste", false, true);

// redirect to the index if the plugin isn't installed
if (!liste_is_installed()) {
    header('Location: ' . $mybb->settings['bburl'], true, 307);
    die();
}

if (!$pluginsCache) {
    $pluginsCache = $cache->read("plugins");
}

if (array_key_exists('liste', $pluginsCache['active']) &&
    $pluginsCache['active']['liste'] == 'liste') {

    if ($mybb->settings['showListOnlyForMembers'] == '1' && $mybb->user['uid'] == 0) {
        error_no_permission();
    } else {
        showList();
    }
} else {

    add_breadcrumb($lang->liste);

    $content .= '<div class="error low_warning"><p><em>' . $lang->followingErrors . '</em></p>';
    $content .= '<p><ul>';
    $content .= '<li>' . $lang->errorNotActive . '</li>';
    $content .= '</ul></p>';
    $content .= '<a href="javascript:history.back()">' . $lang->back . '</a></div>';

    eval("\$showList = \"" . $templates->get("show_liste") . "\";");
    output_page($showList);
}