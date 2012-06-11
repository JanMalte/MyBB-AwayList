<?php
/**
 * AwayList_Item_Repository test
 * 
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Tests
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */

/**
 * AwayList_Item_Repository test
 * 
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Tests
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */
class AwayList_Item_RepositoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var AwayList_Item_Repository
     */
    protected $object;

    /**
     * This method is called before the first test of this test class is run.
     *
     * @since Method available since Release 3.4.0
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new AwayList_Item_Repository();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers AwayList_Item_Repository
     */
    public function testUpgradeTo165()
    {
        $this->assertEmpty($this->object->upgradeTo165());
    }

    /**
     * @covers AwayList_Item_Repository
     */
    public function testCreateRow()
    {
        $rowObject = $this->object->createRow();
        $this->assertInstanceOf('AwayList_Item', $rowObject);
        unset($rowObject);
        $uid = '123456789';
        $rowObject = $this->object->createRow(array('uid' => $uid));
        $this->assertInstanceOf('AwayList_Item', $rowObject);
        $this->assertEquals($uid, $rowObject->getUid());
        unset($rowObject);
        $hotel = '213 Test TestString #';
        $rowObject = $this->object->createRow(array('hotel' => $hotel));
        $this->assertInstanceOf('AwayList_Item', $rowObject);
        $this->assertEquals($hotel, $rowObject->getHotel());
    }

    /**
     * @covers AwayList_Item_Repository
     */
    public function testDeleteById()
    {
        // TODO import test data
        // $this->assertNotEmpty($this->object->deleteById(13),'No row was deleted');
        $this->assertEmpty($this->object->deleteById(9999),
            'A row was deleted, but shouldn\'t');
    }

    /**
     * @covers AwayList_Item_Repository
     */
    public function testDeleteByUserId()
    {
        // TODO import test data
        // $this->assertNotEmpty($this->object->deleteById(13),'No row was deleted');
        $this->assertEmpty($this->object->deleteByUserId(9999999),
            'A row was deleted, but shouldn\'t');
    }

    /**
     * @covers AwayList_Item_Repository
     */
    public function testFetchRowById()
    {
        // TODO import test data
        // $rowObject = $this->object->fetchRowById(13);
        // $this->assertNotEmpty($rowObject,'No row was selected');
        $rowObject = $this->object->fetchRowById(9999999);
        $this->assertEmpty($rowObject, 'A row was selected, but shouldn\'t');
    }

    /**
     * @covers AwayList_Item_Repository
     */
    public function testFetchAllByUserId()
    {
        // TODO import test data
        // $userId = 5;
        // $rowObjects = $this->object->fetchAllByUserId($userId);
        // $this->assertEquals($userId, $rowObjects[1]->getUid());
        // $this->assertNotEmpty($rowObjects,'No row was selected');
        $rowObjects = $this->object->fetchAllByUserId(9999999);
        $this->assertEmpty($rowObjects, 'A row was selected, but shouldn\'t');
    }

    /**
     * @covers AwayList_Item_Repository::fetchAllByDate
     * @todo   Implement testFetchAllByDate().
     */
    public function testFetchAllByDate()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers AwayList_Item_Repository::fetchAllUpcomming
     * @todo   Implement testFetchAllUpcomming().
     */
    public function testFetchAllUpcomming()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers AwayList_Item_Repository::countAllUpcomming
     * @todo   Implement testCountAllUpcomming().
     */
    public function testCountAllUpcomming()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers AwayList_Item_Repository::fetchAll
     * @todo   Implement testFetchAll().
     */
    public function testFetchAll()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

}
