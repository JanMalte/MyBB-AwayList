<?php
/**
 * bootstraping for PHPUnit tests
 * 
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Tests
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */
// Define path to application directory
defined('APPLICATION_PATH')
    || define(
        'APPLICATION_PATH', realpath(dirname(__FILE__) . '/../source/')
);

// Define MYBB_ROOT
defined('MYBB_ROOT') || define('MYBB_ROOT', '/srv/www/mybb/mybb16/');

// Allow mybb access
defined('IN_MYBB') || define('IN_MYBB', true);

// Set application enviroment to testing
defined('UNITTESTING') || define('UNITTESTING', true);

/**
 * set up global fake enviroment
 * 
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Tests
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 3 or later 
 */
class FakePluginClass
{

    /**
     * do nothing
     * 
     * @param mixed $name
     * @param mixed $function 
     * @return void 
     */
    public function add_hook($name, $function)
    {
        return;
    }

    /**
     * do nothing
     * 
     * @param mixed $name
     * @param mixed $mixed
     * @param mixed $throwError 
     * @return void
     */
    public function load($name, $mixed, $throwError)
    {
        return;
    }

}

// set up global fake enviroment
$plugins = new FakePluginClass();
$lang = $plugins;