<?php

/**
 * @version     TestSeleneseSuite.php 2012-01-07
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  UnitTests
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Selenium Test Suite using Selenium HTML files
 */
class SeleneseTests extends PHPUnit_Extensions_SeleniumTestCase
{

    /**
     *
     * @var Array browser configuration for selenium tests
     */
    public static $browsers = array(
        array(
            'name' => 'Firefox Browser',
            'browser' => '*firefox',
            'host' => 'localhost',
            'port' => 6666,
            'timeout' => 300000,
        )
    );

    /**
     * set the base url
     */
    protected function setUp()
    {
        $this->setBrowserUrl('http://mybb16.local/');
    }

    /**
     *
     * @var String directory containing the selenese HTML files
     */
    public static $seleneseDirectory = 'tests-selenium/selenese';

}