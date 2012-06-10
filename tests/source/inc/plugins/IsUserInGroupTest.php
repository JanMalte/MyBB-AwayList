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
require_once APPLICATION_PATH.'/inc/plugins/awaylist.php';

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
class IsUserInGroupTest extends PHPUnit_Framework_TestCase
{

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     * 
     * @global type $mybb 
     */
    public function setUp()
    {
        global $mybb;

        // set up global enviroment
        $mybb = new stdClass();
        $mybb->user['additionalgroups'] = '1,2,3';
        $mybb->user['usergroup'] = 4;
        parent::setUp();
    }

    /**
     * check AwayList::isUserInGroup() method
     * 
     * @covers AwayList::isUserInGroup
     */
    public function testEmpty()
    {
        // perform tests
        $this->assertFalse(
            AwayList::isUserInGroup(),
            'test isUserInGroup() with empty parameter'
        );
    }

    /**
     * check AwayList::isUserInGroup() method
     * 
     * @covers AwayList::isUserInGroup
     */
    public function testFalse()
    {
        // perform tests
        $this->assertFalse(AwayList::isUserInGroup(10));
        $this->assertFalse(AwayList::isUserInGroup('10'));
        $this->assertFalse(AwayList::isUserInGroup('10,20,30'));
        $this->assertFalse(AwayList::isUserInGroup(PHP_INT_MAX));
    }

    /**
     * check AwayList::isUserInGroup() method
     * 
     * @covers AwayList::isUserInGroup
     * @expectedException PHPUnit_Framework_Error
     */
    public function testError()
    {
        // perform tests with error
        AwayList::isUserInGroup(10, 20, 30);
        AwayList::isUserInGroup(array(10));
        AwayList::isUserInGroup(array(10, 20));
        $array = array('10' => 10, '20' => 20);
        AwayList::isUserInGroup($array);
        $array = array('test' => 10, 'testTest' => 20);
        AwayList::isUserInGroup($array);
        $array = array('test' => '10', 'testTest' => '20');
        AwayList::isUserInGroup($array);
        $array = array('test' => 'testing', 'testTest' => 'testingTesting');
        AwayList::isUserInGroup($array);
    }

    /**
     * check AwayList::isUserInGroup() method
     * 
     * @covers AwayList::isUserInGroup
     */
    public function testTrue()
    {
        // perform tests additional usergroups
        $this->assertTrue(AwayList::isUserInGroup(1));
        $this->assertTrue(AwayList::isUserInGroup('1'));
        $this->assertTrue(AwayList::isUserInGroup('1,2'));
        $this->assertTrue(AwayList::isUserInGroup('2,1'));

        // perform tests usergroup
        $this->assertTrue(AwayList::isUserInGroup(4));
        $this->assertTrue(AwayList::isUserInGroup('4'));
        $this->assertTrue(AwayList::isUserInGroup('1,4'));
        $this->assertTrue(AwayList::isUserInGroup('4,1'));

        // perform tests additional usergroups with one fail
        $this->assertTrue(AwayList::isUserInGroup('100,2'));
        $this->assertTrue(AwayList::isUserInGroup('2,100'));

        // perform tests usergroup with one fail
        $this->assertTrue(AwayList::isUserInGroup('100,4'));
        $this->assertTrue(AwayList::isUserInGroup('4,100'));

        // perform tests additional usergroups with one fail not numeric
        $this->assertTrue(AwayList::isUserInGroup('testing,2'));
        $this->assertTrue(AwayList::isUserInGroup('2,testing'));

        // perform tests usergroup with one fail not numeric
        $this->assertTrue(AwayList::isUserInGroup('testing,4'));
        $this->assertTrue(AwayList::isUserInGroup('4,testing'));
    }

}