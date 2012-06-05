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

define('APPLICATION_PATH', '/srv/www/mybb/mybb16');

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