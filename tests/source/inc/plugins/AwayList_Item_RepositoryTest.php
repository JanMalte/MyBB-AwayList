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
     * Repository for AwayList_Item
     * 
     * @var AwayList_Item_Repository
     */
    protected $_repository;

    /**
     * Returns the test database connection.
     *
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
     * Returns the test dataset.
     *
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
        $this->_repository = new AwayList_Item_Repository();
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
     * Test the creation of a new AwayList_Item_Repository row
     * 
     * @covers AwayList_Item_Repository
     */
    public function testCreateRow()
    {
        $rowObjectOne = $this->_repository->createRow();
        $this->assertInstanceOf('AwayList_Item', $rowObjectOne);

        $uid = '123456789';
        $rowObjectTwo = $this->_repository->createRow(array('uid' => $uid));
        $this->assertInstanceOf('AwayList_Item', $rowObjectTwo);
        $this->assertEquals($uid, $rowObjectTwo->getUid());

        $hotel = '213 Test TestString #';
        $rowObjectThree = $this->_repository->createRow(array('hotel' => $hotel));
        $this->assertInstanceOf('AwayList_Item', $rowObjectThree);
        $this->assertEquals($hotel, $rowObjectThree->getHotel());
    }

    /**
     * Test the deleteById() function
     * 
     * @covers AwayList_Item_Repository
     */
    public function testDeleteById()
    {
        $this->assertEquals(
            1, $this->_repository->deleteById(2), 'No row was deleted'
        );

        $this->assertEmpty(
            $this->_repository->deleteById(9999), 'A row was deleted, but shouldn\'t'
        );
    }

    /**
     * Test the deleteByUserId() function
     * 
     * @covers AwayList_Item_Repository
     */
    public function testDeleteByUserId()
    {
        $this->assertEquals(
            1, $this->_repository->deleteByUserId(4), 'No row was deleted'
        );

        $this->assertEmpty(
            $this->_repository->deleteByUserId(9999999),
            'A row was deleted, but shouldn\'t'
        );
    }

    /**
     * Test the fetchRowById() function
     * 
     * @covers AwayList_Item_Repository
     */
    public function testFetchRowById()
    {
        $rowObjectOne = $this->_repository->fetchRowById(1);
        $this->assertNotEmpty($rowObjectOne, 'No row was selected');

        $rowObjectTwo = $this->_repository->fetchRowById(2);
        $this->assertNotEmpty($rowObjectTwo, 'No row was selected');

        $rowObjectEmpty = $this->_repository->fetchRowById(9999999);
        $this->assertEmpty($rowObjectEmpty, 'A row was selected, but shouldn\'t');
    }

    /**
     * Test the fetchAllByUserId() function
     * 
     * @covers AwayList_Item_Repository
     */
    public function testFetchAllByUserId()
    {
        $userId = 1;
        $rowObjects = $this->_repository->fetchAllByUserId($userId);
        $this->assertNotEmpty($rowObjects, 'No row was selected');
        $this->assertEquals(1, count($rowObjects));
        foreach ($rowObjects as $row) {
            $this->assertEquals(
                $userId, $row->getUid(), 'Uid of row doesn\'t match expected'
            );
        }

        $rowObjectsEmpty = $this->_repository->fetchAllByUserId(9999999);
        $this->assertEmpty(
            $rowObjectsEmpty, 'A row was selected, but shouldn\'t'
        );
    }

    /**
     * Test the fetchAllByUserId() function with past records included
     * 
     * @covers AwayList_Item_Repository
     */
    public function testFetchAllByUserIdIncludePast()
    {
        $userId = 1;
        $rowObjects = $this->_repository->fetchAllByUserId(
            $userId, array('includePast' => true)
        );
        $this->assertNotEmpty($rowObjects, 'No row was selected');
        $this->assertEquals(2, count($rowObjects));
        foreach ($rowObjects as $row) {
            $this->assertEquals(
                $userId, $row->getUid(), 'Uid of row doesn\'t match expected'
            );
        }
    }

    /**
     * Test the fetchAllByUserId() function with past records included
     * and a given timestamp
     * 
     * @covers AwayList_Item_Repository
     */
    public function testFetchAllByUserIdIncludePastWithTimestamp()
    {
        $userId = 1;
        $rowObjects = $this->_repository->fetchAllByUserId(
            $userId, array('includePast' => true, 'timestamp' => (time() - 7257600))
        );
        $this->assertNotEmpty($rowObjects, 'No row was selected');
        $this->assertEquals(2, count($rowObjects));
        foreach ($rowObjects as $row) {
            $this->assertEquals(
                $userId, $row->getUid(), 'Uid of row doesn\'t match expected'
            );
        }
    }

    /**
     * Test the fetchAllByDate() function
     * 
     * @covers AwayList_Item_Repository::fetchAllByDate
     */
    public function testFetchAllByDate()
    {
        $timestamp = '16563492';
        $dateRows = $this->_repository->fetchAllByDate($timestamp);
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
     * Test the fetchAllUpcomming() function
     * 
     * @covers AwayList_Item_Repository::fetchAllUpcomming
     */
    public function testFetchAllUpcomming()
    {
        $upcommingRows = $this->_repository->fetchAllUpcomming();
        $this->assertEquals(2, count($upcommingRows));
    }

    /**
     * Test the countAllUpcomming() function
     * 
     * @covers AwayList_Item_Repository::countAllUpcomming
     */
    public function testCountAllUpcomming()
    {
        $upcommingRowObjects = $this->_repository->fetchAllUpcomming();
        $this->assertEquals(2, count($upcommingRowObjects));
        $upcommingRows = $this->_repository->countAllUpcomming();
        $this->assertEquals(2, $upcommingRows);
    }

    /**
     * Test the fetchAll() function
     * 
     * @covers AwayList_Item_Repository::fetchAll
     */
    public function testFetchAll()
    {
        $allRowObjects = $this->_repository->fetchAll();
        $this->assertEquals(3, count($allRowObjects));
    }

}
