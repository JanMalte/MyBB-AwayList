<?php
/**
 * Example Test for Selenium Usage
 * 
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
 * Example Test for Selenium Usage
 * 
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Tests
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */
class PageTitelTest extends PHPUnit_Extensions_SeleniumTestCase
{

    /**
     * Browser configuration for selenium tests
     * 
     * @var array
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
     * Setup for selenium tests
     * 
     * @return void 
     */
    function setUp()
    {
        $this->setBrowserUrl('http://mybb16.local/');
    }

    /**
     * Test the page title
     * 
     * @return void 
     */
    function testPageTitel()
    {
        $this->open("/");
        $this->assertEquals('MyBB Plugins', $this->getTitle());
    }

}