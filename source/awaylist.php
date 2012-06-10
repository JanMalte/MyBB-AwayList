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
defined('IN_MYBB') || define('IN_MYBB', 1);

// name of the file
defined('THIS_SCRIPT') || define('THIS_SCRIPT', 'awaylist.php');

// set to "1" if this page should be hidden on the online list; default is "0"
defined('NO_ONLINE') || define('NO_ONLINE', 0);

// define variables before global.php
$lang = null;
$pluginsCache = null;
$plugins = null;

// include the global MyBB context
require_once 'global.php';

// load language for the plugin
$lang->load('awaylist', false, true);

// add breadcrumb item
add_breadcrumb($lang->liste, THIS_SCRIPT);

// get the plugin information
if (!$pluginsCache) {
    $pluginsCache = $cache->read('plugins');
}

// is the plugin active
if (isset($pluginsCache['active']['awaylist'])) {
    // run hook for displaying the awaylist
    $plugins->run_hooks('awaylist_showList');
} else {
    error($lang->errorNotActive, $lang->error);
}