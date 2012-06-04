<?php
/**
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Tests
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */
// include selenium test case
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

/**
 * default test
 * 
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Tests
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */
class pageTitelTest extends PHPUnit_Extensions_SeleniumTestCase
{

    /**
     * browser configuration for selenium tests
     * 
     * @var Array
     */
    public static $browsers = array(
        array(
            'name' => 'Firefox Browser',
            'browser' => '*opera',
            'host' => 'localhost',
            'port' => 6666,
            'timeout' => 300000,
        )
    );

    /**
     * setup for selenium tests
     * 
     * @return void 
     */
    function setUp()
    {
        $this->setBrowserUrl('http://mybb16.local/');
    }

    /**
     * test the page title
     * 
     * @return void 
     */
    function testPageTitel()
    {
        $this->open("/");
        $this->assertEquals('MyBB Plugins', $this->getTitle());
    }

}