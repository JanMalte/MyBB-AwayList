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
class AwayList_Item_RepositoryTest extends PHPUnit_Extensions_Database_TestCase
{

    /**
     * @var AwayList_Item_Repository
     */
    protected $object;

    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        global $config;
        $pdo = new PDO(
                'mysql:host=' . $config['database']['hostname'] . ';'
                . 'dbname=' . $config['database']['database'],
                $config['database']['username'],
                $config['database']['password'],
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
        );
        return $this->createDefaultDBConnection($pdo);
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        //return $this->createFlatXMLDataSet(dirname(__FILE__) . '/repositoryTestDataSet.xml');
        return $this->createMySQLXMLDataSet(dirname(__FILE__) . '/repositoryTestMySQLDataSet.xml');
    }

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
        parent::setUp();
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
        $rowObjectOne = $this->object->createRow();
        $this->assertInstanceOf('AwayList_Item', $rowObjectOne);

        $uid = '123456789';
        $rowObjectTwo = $this->object->createRow(array('uid' => $uid));
        $this->assertInstanceOf('AwayList_Item', $rowObjectTwo);
        $this->assertEquals($uid, $rowObjectTwo->getUid());

        $hotel = '213 Test TestString #';
        $rowObjectThree = $this->object->createRow(array('hotel' => $hotel));
        $this->assertInstanceOf('AwayList_Item', $rowObjectThree);
        $this->assertEquals($hotel, $rowObjectThree->getHotel());
    }

    /**
     * @covers AwayList_Item_Repository
     */
    public function testDeleteById()
    {
        $this->assertEquals(
            1, $this->object->deleteById(2), 'No row was deleted'
        );

        $this->assertEmpty(
            $this->object->deleteById(9999), 'A row was deleted, but shouldn\'t'
        );
    }

    /**
     * @covers AwayList_Item_Repository
     */
    public function testDeleteByUserId()
    {
        $this->assertEquals(
            1, $this->object->deleteByUserId(4), 'No row was deleted'
        );

        $this->assertEmpty(
            $this->object->deleteByUserId(9999999),
            'A row was deleted, but shouldn\'t'
        );
    }

    /**
     * @covers AwayList_Item_Repository
     */
    public function testFetchRowById()
    {
        $rowObjectOne = $this->object->fetchRowById(1);
        $this->assertNotEmpty($rowObjectOne, 'No row was selected');

        $rowObjectTwo = $this->object->fetchRowById(2);
        $this->assertNotEmpty($rowObjectTwo, 'No row was selected');

        $rowObjectEmpty = $this->object->fetchRowById(9999999);
        $this->assertEmpty($rowObjectEmpty, 'A row was selected, but shouldn\'t');
    }

    /**
     * @covers AwayList_Item_Repository
     */
    public function testFetchAllByUserId()
    {
        $userId = 4;
        $rowObjects = $this->object->fetchAllByUserId($userId);
        $this->assertNotEmpty($rowObjects, 'No row was selected');
        foreach ($rowObjects as $row) {
            $this->assertEquals(
                $userId, $row->getUid(), 'Uid of row doesn\'t match expected'
            );
        }

        $rowObjectsEmpty = $this->object->fetchAllByUserId(9999999);
        $this->assertEmpty(
            $rowObjectsEmpty, 'A row was selected, but shouldn\'t'
        );
    }

    /**
     * @covers AwayList_Item_Repository::fetchAllByDate
     */
    public function testFetchAllByDate()
    {
        $timestamp = '16563492';
        $dateRows = $this->object->fetchAllByDate($timestamp);
        $this->assertEquals(1, count($dateRows));
        foreach ($dateRows as $row) {
            $this->assertTrue(
                $row->getStart() < $row->getEnd()
            );
            $this->assertTrue(
                $row->getStart() < $timestamp
            );
            $this->assertTrue(
                $timestamp < $row->getEnd()
            );
        }
    }

    /**
     * @covers AwayList_Item_Repository::fetchAllUpcomming
     */
    public function testFetchAllUpcomming()
    {
        $upcommingRows = $this->object->fetchAllUpcomming();
        $this->assertEquals(2, count($upcommingRows));
    }

    /**
     * @covers AwayList_Item_Repository::countAllUpcomming
     */
    public function testCountAllUpcomming()
    {
        $upcommingRowObjects = $this->object->fetchAllUpcomming();
        $this->assertEquals(2, count($upcommingRowObjects));
        $upcommingRows = $this->object->countAllUpcomming();
        $this->assertEquals(2, $upcommingRows);
    }

    /**
     * @covers AwayList_Item_Repository::fetchAll
     */
    public function testFetchAll()
    {
        $allRowObjects = $this->object->fetchAll();
        $this->assertEquals(3, count($allRowObjects));
    }

}
