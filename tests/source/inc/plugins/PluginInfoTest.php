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

    public function setUp()
    {
        parent::setUp();
    }

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

    public function testGid()
    {
        $infoArray = awaylist_info();
        $gid = '6a8fbbc82f4aa01fd9ba4a599e80c5c7';
        $this->assertArrayHasKey('gid', $infoArray);
        $this->assertEquals($gid, $infoArray['gid']);
        $compareArray = array(
            "name" => "Awaylist",
            "description" => "It provides a list where members can subscribe"
            . " when they are at a special place",
            "website" => "http://www.malte-gerth.de/mybb.html",
            "author" => "Jan Malte Gerth",
            "authorsite" => "http://www.malte-gerth.de/",
            "version" => "1.6.8",
            "compatibility" => "16*",
            "gid" => '6a8fbbc82f4aa01fd9ba4a599e80c5c7'
        );
    }
    
    public function testWebsite()
    {
        $infoArray = awaylist_info();
        $expectedValue = 'http://www.malte-gerth.de/mybb.html';
        $this->assertArrayHasKey('website', $infoArray);
        $this->assertEquals($expectedValue, $infoArray['website']);
    }
    
    public function testAuthor()
    {
        $infoArray = awaylist_info();
        $expectedValue = '/.*Malte Gerth.*/';
        $this->assertArrayHasKey('author', $infoArray);
        $this->assertRegExp($expectedValue, $infoArray['author']);
    }
    
    public function testAuthorSite()
    {
        $infoArray = awaylist_info();
        $expectedValue = 'http://www.malte-gerth.de/';
        $this->assertArrayHasKey('authorsite', $infoArray);
        $this->assertEquals($expectedValue, $infoArray['authorsite']);
    }

}