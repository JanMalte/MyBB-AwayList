<?php
/**
 * AwayList_Item test
 * 
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Tests
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */

/**
 * AwayList_Item test
 * 
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Tests
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */
class AwayList_ItemTest extends PHPUnit_Extensions_Database_TestCase
{

    /**
     * @var AwayList_Item
     */
    protected $object;

    /**
     * @var AwayList_Item_Repository
     */
    protected $repository;

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
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->repository = new AwayList_Item_Repository();
        $rowObject = $this->repository->fetchRowById(2);
        $this->assertNotEmpty($rowObject, 'No row was selected');
        $this->object = $rowObject;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers AwayList_Item
     */
    public function testGetId()
    {
        $this->assertEquals(2, $this->object->getId());
    }

    /**
     * @covers AwayList_Item
     */
    public function testGetUid()
    {
        $this->assertEquals(1, $this->object->getUid());
    }

    /**
     * @covers AwayList_Item
     */
    public function testSetUid()
    {
        $this->object->setUid(25);
        $this->assertEquals(25, $this->object->getUid());
    }

    /**
     * @covers AwayList_Item
     */
    public function testGetUsername()
    {
        $this->assertEquals('Administrator', $this->object->getUsername());
    }

    /**
     * @covers AwayList_Item
     */
    public function testSetUsername()
    {
        $this->object->setUsername('TestUser');
        $this->assertEquals('TestUser', $this->object->getUsername());
    }

    /**
     * @covers AwayList_Item
     */
    public function testGetStart()
    {
        $this->assertEquals('2047483647', $this->object->getStart());
    }

    /**
     * @covers AwayList_Item
     */
    public function testSetStart()
    {
        $this->object->setStart('123456789');
        $this->assertEquals('123456789', $this->object->getStart());
    }

    /**
     * @covers AwayList_Item
     */
    public function testGetEnd()
    {
        $this->assertEquals('2140483647', $this->object->getEnd());
    }

    /**
     * @covers AwayList_Item
     */
    public function testSetEnd()
    {

        $this->object->setStart('456789123');
        $this->assertEquals('456789123', $this->object->getStart());
    }

    /**
     * @covers AwayList_Item
     */
    public function testGetErrors()
    {
        $this->assertEmpty($this->object->getErrors());
    }

    /**
     * @covers AwayList_Item
     */
    public function testHasErrors()
    {
        $this->assertFalse($this->object->hasErrors());
    }

    /**
     * @covers AwayList_Item
     */
    public function test__call()
    {
        $this->assertEquals('Lufthansa', $this->object->getAirline());
        $this->object->setAirline('TUI LastMinute');
        $this->assertEquals('TUI LastMinute', $this->object->getAirline());
        $this->assertEquals('City Hotel', $this->object->getHotel());
    }

    /**
     * @covers AwayList_Item
     * @expectedException AwayList_Item_Exception 
     */
    public function test__callException()
    {
        $this->object->nonExisting();
        $this->object->getNonExisting();
        $this->object->setNonExisting('value');
        $this->object->nonExistingWithValue('TUI LastMinute');
    }

    /**
     * @covers AwayList_Item
     */
    public function test__get()
    {
        $this->assertEquals('2047483647', $this->object->arrival);
        $this->assertEquals('2140483647', $this->object->departure);
        $this->assertEmpty($this->object->sort_id);
    }

    /**
     * @covers AwayList_Item
     * @expectedException AwayList_Item_Exception 
     */
    public function test__getException()
    {
        $this->object->nonExisting;
    }

    /**
     * @covers AwayList_Item
     */
    public function test__set()
    {
        $this->object->airline = 'American Airlines';
        $this->assertEquals('American Airlines', $this->object->airline);
    }

    /**
     * @covers AwayList_Item
     */
    public function test__isset()
    {
        $this->assertTrue(isset($this->object->airline));
        $this->assertFalse(isset($this->object->nonExisting));
    }

    /**
     * @covers AwayList_Item
     */
    public function test__unset()
    {
        unset($this->object->airline);
        $this->assertFalse(isset($this->object->airline));
        unset($this->object->nonExisting);
        $this->assertTrue(isset($this->object->hotel));
    }

    /**
     * @covers AwayList_Item
     */
    public function testToArray()
    {
        $expectedDataArray = array(
            'uid' => 1,
            'username' => 'Administrator',
            'arrival' => 2047483647,
            'departure' => 2140483647,
            'airline' => 'Lufthansa',
            'place' => 'Berlin',
            'hotel' => 'City Hotel',
            'phone' => 123456789,
            'id' => 2,
            'arrival_tag' => 18,
            'arrival_monat' => 11,
            'arrival_jahr' => 2034,
            'departure_tag' => 30,
            'departure_monat' => 10,
            'departure_jahr' => 2037,
        );
        $dataArray = $this->object->toArray();
        $this->assertInternalType('array', $dataArray);
        $this->assertNotEmpty($dataArray);
        $this->assertEquals($expectedDataArray, $dataArray);
    }

    /**
     * @covers AwayList_Item
     */
    public function testToArrayChangedValues()
    {
        $expectedDataArray = array(
            'uid' => 1,
            'username' => 'TestUser',
            'arrival' => 2047483647,
            'departure' => 2140483647,
            'airline' => 'Lufthansa',
            'place' => 'London',
            'hotel' => 'City Hotel',
            'phone' => 987987,
            'id' => 2,
            'arrival_tag' => 18,
            'arrival_monat' => 11,
            'arrival_jahr' => 2034,
            'departure_tag' => 30,
            'departure_monat' => 10,
            'departure_jahr' => 2037,
        );
        $this->object->setUsername('TestUser');
        $this->object->setPlace('London');
        $this->object->phone = 987987;
        $dataArray = $this->object->toArray();
        $this->assertInternalType('array', $dataArray);
        $this->assertNotEmpty($dataArray);
        $this->assertEquals($expectedDataArray, $dataArray);
    }

    /**
     * @covers AwayList_Item
     */
    public function testSaveNew()
    {
        $object = new AwayList_Item();
        $object->setUsername('TestUserNew');
        $itemId = $object->save();
        $this->assertNotEmpty($itemId);
        $savedObject = $this->repository->fetchRowById($itemId);
        $this->assertNotEmpty($savedObject);
        $this->assertNotEmpty($savedObject->getId());
        $this->assertEquals($itemId, $savedObject->getId());
        $this->assertEquals($object->getUsername(), $savedObject->getUsername());
        $this->assertEquals('TestUserNew', $savedObject->getUsername());
    }

    /**
     * @covers AwayList_Item
     */
    public function testSaveUpdate()
    {
        $object = $this->object;
        $object->setUsername('TestUserNew');
        $itemId = $object->save();
        $this->assertNotEmpty($itemId);
        $savedObject = $this->repository->fetchRowById($itemId);
        $this->assertNotEmpty($savedObject);
        $this->assertNotEmpty($savedObject->getId());
        $this->assertEquals($itemId, $savedObject->getId());
        $this->assertEquals($itemId, $object->getId());
        $this->assertEquals($object->getUsername(), $savedObject->getUsername());
        $this->assertEquals('TestUserNew', $savedObject->getUsername());
    }

    /**
     * @covers AwayList_Item
     */
    public function testSetData()
    {
        $data = array(
            'uid' => 1,
            'username' => 'TestUser',
            'airline' => 'Lufthansa',
            'place' => 'London',
            'hotel' => 'City Hotel',
            'phone' => 987987,
            'arrival_tag' => 18,
            'arrival_monat' => 11,
            'arrival_jahr' => 2034,
            'departure_tag' => 30,
            'departure_monat' => 10,
            'departure_jahr' => 2037,
        );
        $expectedDataArray = array(
            'uid' => 1,
            'username' => 'TestUser',
            'airline' => 'Lufthansa',
            'arrival' => 2047417200,
            'departure' => 2140470000,
            'place' => 'London',
            'hotel' => 'City Hotel',
            'phone' => 987987,
            'arrival_tag' => '18',
            'arrival_monat' => '11',
            'arrival_jahr' => '2034',
            'departure_tag' => '30',
            'departure_monat' => '10',
            'departure_jahr' => '2037',
            'id' => 2
        );
        $this->object->setData($data);
        $dataArray = $this->object->toArray();
        $this->assertEquals($expectedDataArray, $dataArray);
        $this->object->setData(
            'Strings are not allowed and shouldn\'t change anything'
        );
        $dataArray = $this->object->toArray();
        $this->assertEquals($expectedDataArray, $dataArray);
    }

    /**
     * @covers AwayList_Item
     */
    public function testIsValid()
    {
        $failData = array('phone' => 'Strings are not allowed');
        $this->assertFalse($this->object->isValid($failData));
        $object = new AwayList_Item();
        $this->assertFalse($object->isValid($failData));
        $this->assertTrue($this->object->hasErrors());
        $successData = array(
            'uid' => 1,
            'username' => 'TestUser',
            'airline' => 'Lufthansa',
            'place' => 'London',
            'hotel' => 'City Hotel',
            'phone' => 987987,
            'arrival_tag' => 18,
            'arrival_monat' => 11,
            'arrival_jahr' => 2034,
            'departure_tag' => 30,
            'departure_monat' => 10,
            'departure_jahr' => 2037,
        );
        $this->assertTrue($this->object->isValid($successData));
    }

}
