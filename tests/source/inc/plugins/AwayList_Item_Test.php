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
     * AwayList_Item object
     * 
     * @var AwayList_Item
     */
    protected $_object;

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
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();

        // create the repository
        $this->_repository = new AwayList_Item_Repository();

        // fetch row with id 2 as default object
        $awayListObject = $this->_repository->fetchRowById(2);
        $this->assertNotEmpty($awayListObject, 'No row was selected');
        $this->_object = $awayListObject;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * Basic test for getId()
     * 
     * @covers AwayList_Item
     */
    public function testGetId()
    {
        $this->assertEquals(2, $this->_object->getId());
    }

    /**
     * Basic test for getUid()
     * 
     * @covers AwayList_Item
     */
    public function testGetUid()
    {
        $this->assertEquals(1, $this->_object->getUid());
    }

    /**
     * Basic test for setUid()
     * 
     * @covers AwayList_Item
     */
    public function testSetUid()
    {
        $this->_object->setUid(25);
        $this->assertEquals(25, $this->_object->getUid());

        // strings should be converted to integer
        $this->_object->setUid('35');
        $this->assertEquals(35, $this->_object->getUid());
    }

    /**
     * Basic fail test for setUid()
     * 
     * @covers AwayList_Item
     * @expectedException AwayList_Item_Exception 
     */
    public function testSetUidException()
    {
        $this->_object->setUid('StringsAreNotAllowed');
        $this->assertEquals(1, $this->_object->getUid());
    }

    /**
     * Basic fail test for setUid()
     * 
     * @covers AwayList_Item
     * @expectedException AwayList_Item_Exception 
     */
    public function testSetUidExceptionTwo()
    {
        $this->_object->setUid('String are not allowed');
        $this->assertEquals(1, $this->_object->getUid());
    }

    /**
     * Basic fail test for setUid()
     * 
     * @covers AwayList_Item
     * @expectedException AwayList_Item_Exception 
     */
    public function testSetUidExceptionThree()
    {
        $this->_object->setUid(
            array('ArraysAreNotAllowed', 'arrayKey' => 'Arrays are not allowed')
        );
        $this->assertEquals(1, $this->_object->getUid());
    }

    /**
     * Basic test for getUsername()
     * 
     * @covers AwayList_Item
     */
    public function testGetUsername()
    {
        $this->assertEquals('Administrator', $this->_object->getUsername());
    }

    /**
     * Basic test for setUsername()
     * 
     * @covers AwayList_Item
     */
    public function testSetUsername()
    {
        $this->_object->setUsername('TestUser');
        $this->assertEquals('TestUser', $this->_object->getUsername());
    }

    /**
     * Basic fail test for setUsername()
     * 
     * @covers AwayList_Item
     * @expectedException AwayList_Item_Exception 
     */
    public function testSetUsernameException()
    {
        $this->_object->setUsername(
            array('ArraysAreNotAllowed', 'arrayKey' => 'Arrays are not allowed')
        );
        $this->assertEquals('Administrator', $this->_object->getUsername());
    }

    /**
     * Basic fail test for setUsername()
     * 
     * @covers AwayList_Item
     * @expectedException AwayList_Item_Exception 
     */
    public function testSetUsernameExceptionTwo()
    {
        $this->_object->setUsername(123);
        $this->assertEquals('Administrator', $this->_object->getUsername());
    }

    /**
     * Basic test for getStart()
     * 
     * @covers AwayList_Item
     */
    public function testGetStart()
    {
        $this->assertEquals('2047483647', $this->_object->getStart());
        $this->assertEquals(2047483647, $this->_object->getStart());
    }

    /**
     * Basic test for setStart()
     * 
     * @covers AwayList_Item
     */
    public function testSetStart()
    {
        $this->_object->setStart('123456789');
        $this->assertEquals('123456789', $this->_object->getStart());
        $this->assertEquals(123456789, $this->_object->getStart());
        $this->_object->setStart(456456456);
        $this->assertEquals(456456456, $this->_object->getStart());
    }

    /**
     * Basic fail test for setStart()
     * 
     * @covers AwayList_Item
     * @expectedException AwayList_Item_Exception 
     */
    public function testSetStartException()
    {
        $this->_object->setStart('StringsAreNotAllowed');
        $this->assertEquals(2047483647, $this->_object->getStart());
    }

    /**
     * Basic fail test for setStart()
     * 
     * @covers AwayList_Item
     * @expectedException AwayList_Item_Exception 
     */
    public function testSetStartExceptionTwo()
    {
        $this->_object->setStart('String are not allowed');
        $this->assertEquals(2047483647, $this->_object->getStart());
    }

    /**
     * Basic fail test for setStart()
     * 
     * @covers AwayList_Item
     * @expectedException AwayList_Item_Exception 
     */
    public function testSetStartExceptionThree()
    {
        $this->_object->setStart(
            array('ArraysAreNotAllowed', 'arrayKey' => 'Arrays are not allowed')
        );
        $this->assertEquals(2047483647, $this->_object->getStart());
    }

    /**
     * @covers AwayList_Item
     */
    public function testGetEnd()
    {
        $this->assertEquals('2140483647', $this->_object->getEnd());
    }

    /**
     * @covers AwayList_Item
     */
    public function testSetEnd()
    {

        $this->_object->setEnd('456789123');
        $this->assertEquals('456789123', $this->_object->getEnd());
    }

    /**
     * Basic fail test for setEnd()
     * 
     * @covers AwayList_Item
     * @expectedException AwayList_Item_Exception 
     */
    public function testSetEndException()
    {
        $this->_object->setEnd('StringsAreNotAllowed');
        $this->assertEquals(2047483647, $this->_object->getStart());
    }

    /**
     * Basic fail test for setEnd()
     * 
     * @covers AwayList_Item
     * @expectedException AwayList_Item_Exception 
     */
    public function testSetEndExceptionTwo()
    {
        $this->_object->setEnd('String are not allowed');
        $this->assertEquals(2047483647, $this->_object->getStart());
    }

    /**
     * Basic fail test for setEnd()
     * 
     * @covers AwayList_Item
     * @expectedException AwayList_Item_Exception 
     */
    public function testSetEndExceptionThree()
    {
        $this->_object->setEnd(
            array('ArraysAreNotAllowed', 'arrayKey' => 'Arrays are not allowed')
        );
        $this->assertEquals(2047483647, $this->_object->getStart());
    }

    /**
     * @covers AwayList_Item
     */
    public function testGetErrors()
    {
        $this->assertEmpty($this->_object->getErrors());
    }

    /**
     * @covers AwayList_Item
     */
    public function testHasErrors()
    {
        $this->assertFalse($this->_object->hasErrors());
    }

    /**
     * @covers AwayList_Item
     */
    public function test__call()
    {
        $this->assertEquals('Lufthansa', $this->_object->getAirline());
        $this->_object->setAirline('TUI LastMinute');
        $this->assertEquals('TUI LastMinute', $this->_object->getAirline());
        $this->assertEquals('City Hotel', $this->_object->getHotel());
    }

    /**
     * @covers AwayList_Item
     * @expectedException AwayList_Item_Exception 
     */
    public function test__callExceptionNonExisting()
    {
        $this->_object->nonExisting();
    }

    /**
     * @covers AwayList_Item
     * @expectedException AwayList_Item_Exception 
     */
    public function test__callExceptionNonExistingTwo()
    {
        $this->_object->nonExisting('TUI LastMinute');
    }

    /**
     * @covers AwayList_Item
     * @expectedException AwayList_Item_Exception 
     */
    public function test__callExceptionGet()
    {
        $this->_object->getNonExisting();
    }

    /**
     * @covers AwayList_Item
     * @expectedException AwayList_Item_Exception 
     */
    public function test__callExceptionGetTwo()
    {
        $this->_object->getAirline('Value not allowed');
    }

    /**
     * @covers AwayList_Item
     * @expectedException AwayList_Item_Exception 
     */
    public function test__callExceptionSet()
    {
        $this->_object->setNonExisting('TUI LastMinute');
    }

    /**
     * @covers AwayList_Item
     */
    public function test__get()
    {
        $this->assertEquals('2047483647', $this->_object->arrival);
        $this->assertEquals('2140483647', $this->_object->departure);
        $this->assertEmpty($this->_object->sort_id);
    }

    /**
     * @covers AwayList_Item
     * @expectedException AwayList_Item_Exception 
     */
    public function test__getException()
    {
        $this->_object->nonExisting;
    }

    /**
     * @covers AwayList_Item
     */
    public function test__set()
    {
        $this->_object->airline = 'American Airlines';
        $this->assertEquals('American Airlines', $this->_object->airline);
    }

    /**
     * @covers AwayList_Item
     */
    public function test__isset()
    {
        $this->assertTrue(isset($this->_object->airline));
        $this->assertFalse(isset($this->_object->nonExisting));
    }

    /**
     * @covers AwayList_Item
     */
    public function test__unset()
    {
        unset($this->_object->airline);
        $this->assertFalse(isset($this->_object->airline));
        unset($this->_object->nonExisting);
        $this->assertTrue(isset($this->_object->hotel));
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
            'phone' => '123456789',
            'id' => 2,
            'arrival_tag' => 18,
            'arrival_monat' => 11,
            'arrival_jahr' => 2034,
            'departure_tag' => 30,
            'departure_monat' => 10,
            'departure_jahr' => 2037,
        );
        $dataArray = $this->_object->toArray();
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
            'phone' => '987987',
            'id' => 2,
            'arrival_tag' => 18,
            'arrival_monat' => 11,
            'arrival_jahr' => 2034,
            'departure_tag' => 30,
            'departure_monat' => 10,
            'departure_jahr' => 2037,
        );
        $this->_object->setUsername('TestUser');
        $this->_object->setPlace('London');
        $this->_object->phone = 987987;
        $dataArray = $this->_object->toArray();
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
        $savedObject = $this->_repository->fetchRowById($itemId);
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
        $object = $this->_object;
        $object->setUsername('TestUserNew');
        $itemId = $object->save();
        $this->assertNotEmpty($itemId);
        $savedObject = $this->_repository->fetchRowById($itemId);
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
            'phone' => '987987',
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
            'phone' => '987987',
            'arrival_tag' => '18',
            'arrival_monat' => '11',
            'arrival_jahr' => '2034',
            'departure_tag' => '30',
            'departure_monat' => '10',
            'departure_jahr' => '2037',
            'id' => 2
        );
        $this->_object->setData($data);
        $dataArray = $this->_object->toArray();
        $this->assertEquals($expectedDataArray, $dataArray);
        $this->_object->setData(
            'Strings are not allowed and shouldn\'t change anything'
        );
        $dataArray = $this->_object->toArray();
        $this->assertEquals($expectedDataArray, $dataArray);
    }

    /**
     * Extended test for isValid()
     * 
     * @covers AwayList_Item
     */
    public function testIsValid()
    {
        // update an existing object with invalid data
        $failData = array('phone' => 'Strings are not allowed');
        $this->assertFalse($this->_object->isValid($failData));
        $this->assertTrue($this->_object->hasErrors());

        // create a new object with invalid data
        $object = new AwayList_Item();
        $this->assertFalse($object->isValid($failData));
        $this->assertTrue($object->hasErrors());

        // update an existing object with valid data
        $successData = array(
            'uid' => 1,
            'username' => 'TestUser',
            'airline' => 'Lufthansa',
            'place' => 'London',
            'hotel' => 'City Hotel',
            'phone' => '987987',
            'arrival_tag' => 18,
            'arrival_monat' => 11,
            'arrival_jahr' => 2034,
            'departure_tag' => 30,
            'departure_monat' => 10,
            'departure_jahr' => 2037,
        );
        $this->assertTrue($this->_object->isValid($successData));
        $this->assertFalse($this->_object->hasErrors());

        // create a new object with invalid data
        // data is invalid due to existing journey
        $failDataNew = array(
            'uid' => 1,
            'username' => 'TestUser',
            'airline' => 'Lufthansa',
            'place' => 'London',
            'hotel' => 'City Hotel',
            'phone' => '987987',
            'arrival_tag' => 18,
            'arrival_monat' => 11,
            'arrival_jahr' => 2034,
            'departure_tag' => 30,
            'departure_monat' => 10,
            'departure_jahr' => 2037,
        );
        $object = new AwayList_Item();
        $this->assertFalse($object->isValid($failDataNew));
        $this->assertTrue($object->hasErrors());

        // create a new object with invalid data
        // invalid due to not beeing in the future
        $successDataNew = array(
            'uid' => 1,
            'username' => 'TestUser',
            'airline' => 'Lufthansa',
            'place' => 'London',
            'hotel' => 'City Hotel',
            'phone' => '987987',
            'arrival_tag' => 18,
            'arrival_monat' => 10,
            'arrival_jahr' => 1980,
            'departure_tag' => 30,
            'departure_monat' => 11,
            'departure_jahr' => 1980,
        );
        $object = new AwayList_Item();
        $this->assertFalse($object->isValid($successDataNew));
        $this->assertTrue($object->hasErrors());
        $errors = $object->getErrors();
        $this->assertNotEmpty($errors);

        // create a new object with valid data
        $successDataNew = array(
            'uid' => 1,
            'username' => 'TestUser',
            'airline' => 'Lufthansa',
            'place' => 'London',
            'hotel' => 'City Hotel',
            'phone' => '987987',
            'arrival_tag' => 18,
            'arrival_monat' => 9,
            'arrival_jahr' => 2029,
            'departure_tag' => 30,
            'departure_monat' => 10,
            'departure_jahr' => 2029,
        );
        $object = new AwayList_Item();
        $this->assertTrue($object->isValid($successDataNew));
        $this->assertFalse($object->hasErrors());
    }

    /**
     * Basic test for _loadLanguage()
     * 
     * @covers AwayList_Item
     * @global null $lang 
     */
    public function test_loadLanguage()
    {
        global $lang;
        $lang = null;
        new AwayList_Item();
    }

}
