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
    || define('APPLICATION_PATH', '/srv/www/mybb/mybb16');

// allow mybb access
defined('IN_MYBB') || define('IN_MYBB', 1);

// set application enviroment to testing
defined('UNITTESTING') || define('UNITTESTING', true);

// Ensure the include_path is correct
set_include_path(
    implode(
        PATH_SEPARATOR,
        array(
        realpath(APPLICATION_PATH),
        get_include_path(),
        )
    )
);

// set up global fake enviroment
class FakePluginClass
{

    public function add_hook($name, $function)
    {
        
    }
    
    public function load($name, $mixed, $throwError) {
        
    }

}

global $plugins,$lang;

// set up global fake enviroment
$plugins = new FakePluginClass();
$lang = $plugins;