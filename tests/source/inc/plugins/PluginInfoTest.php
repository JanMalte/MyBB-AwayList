<?php
/**
 * test some static plugin functions
 * 
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Tests
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */
// set up global fake enviroment
$plugins = new FakePluginClass();
include_once 'inc/plugins/awaylist.php';

/**
 * test some static plugin functions
 * 
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Tests
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 3 or later
 * @covers AwayList
 */
class PluginInfoTest extends PHPUnit_Framework_TestCase
{

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * test the structure of the info array returned by awaylist_info()
     */
    public function testInfoArrayStructure()
    {
        $infoArray = awaylist_info();
        $this->assertNotEmpty($infoArray, 'Plugin Info array is empty');
        $this->assertArrayHasKey('name', $infoArray);
        $this->assertArrayHasKey('description', $infoArray);
        $this->assertArrayHasKey('website', $infoArray);
        $this->assertArrayHasKey('author', $infoArray);
        $this->assertArrayHasKey('authorsite', $infoArray);
        $this->assertArrayHasKey('version', $infoArray);
        $this->assertArrayHasKey('compatibility', $infoArray);
        $this->assertArrayHasKey('gid', $infoArray);
    }

    /**
     * test if the GID returned by awaylist_info() is correct
     */
    public function testGid()
    {
        $infoArray = awaylist_info();
        $gid = '6a8fbbc82f4aa01fd9ba4a599e80c5c7';
        $this->assertArrayHasKey('gid', $infoArray);
        $this->assertEquals($gid, $infoArray['gid']);
    }

    /**
     * test if the website returned by awaylist_info() is correct
     */
    public function testWebsite()
    {
        $infoArray = awaylist_info();
        $expectedValue = 'http://www.malte-gerth.de/mybb.html';
        $this->assertArrayHasKey('website', $infoArray);
        $this->assertEquals($expectedValue, $infoArray['website']);
    }

    /**
     * test if the author returned by awaylist_info() contains 'Malte Gerth'
     */
    public function testAuthor()
    {
        $infoArray = awaylist_info();
        $expectedValue = '/.*Malte Gerth.*/';
        $this->assertArrayHasKey('author', $infoArray);
        $this->assertRegExp($expectedValue, $infoArray['author']);
    }

    /**
     * test if the author site returned by awaylist_info() is correct
     */
    public function testAuthorSite()
    {
        $infoArray = awaylist_info();
        $expectedValue = 'http://www.malte-gerth.de/';
        $this->assertArrayHasKey('authorsite', $infoArray);
        $this->assertEquals($expectedValue, $infoArray['authorsite']);
    }

    /**
     * test the values of the info array returned by awaylist_info() are correct
     */
    public function testInfoArrayBasicValues()
    {
        $infoArray = awaylist_info();
        $this->assertNotEmpty($infoArray, 'Plugin Info array is empty');
        $this->assertNotEmpty($infoArray['name']);
        $this->assertNotEmpty($infoArray['version']);
        $this->assertRegExp('/[0-9]+\.[0-9]+.[0-9]+/i', $infoArray['version']);
        $this->assertNotEmpty($infoArray['compatibility']);
        $this->assertRegExp('/(14([0-9]+|\*)|16([0-9]+|\*)|\*)/i', $infoArray['compatibility']);
    }

}