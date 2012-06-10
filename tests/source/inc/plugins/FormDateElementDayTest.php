<?php
/**
 * form date element test
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
 * form date element test
 * 
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Tests
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */
class FormDateElementDayTest extends PHPUnit_Framework_TestCase
{

    /**
     * test the day select field
     * 
     * @expectedException PHPUnit_Framework_Error
     * @return void 
     */
    public function testSelectError()
    {
        FormDateElement::showDaySelect();
    }

    /**
     * test the day select field
     * 
     * @param string $fieldName name of the select field
     * @return void 
     */
    public function testSelectFieldName($fieldName = 'daySelectTest')
    {
        // tag matcher configuration
        $matcher = array(
            'tag' => 'select',
            'attributes' => array('name' => $fieldName),
            'children' => array(
                'less_than' => 32,
                'greater_than' => 30,
                'only' => array('tag' => 'option')
            )
        );
        
        // get the select element
        $daySelectElement = FormDateElement::showDaySelect($fieldName);
        
        // check the assertation
        $this->assertTag($matcher, $daySelectElement);
    }
    
    /**
     * test the day select field
     * 
     * @return void 
     */
    public function testSelectFieldNameTwo() {
        $this->testSelectFieldName('day-select-element');
    }
    
    /**
     * test the day select field
     * 
     * @return void 
     */
    public function testSelectFieldNameThree() {
        $this->testSelectFieldName('day_select_element');
    }

    /**
     * test the day select field
     * 
     * @return void 
     */
    public function testSelectTag()
    {
        // test case setup
        $day = date('d');
        $selectedDay = $day;
        $fieldName = 'daySelectTest';
        $matcher = array(
            'tag' => 'select',
            'children' => array(
                'less_than' => 32,
                'greater_than' => 30,
                'only' => array('tag' => 'option')
            )
        );
        
        // perform test with one method parameter
        $daySelectElement = FormDateElement::showDaySelect($fieldName);
        $this->assertTag($matcher, $daySelectElement);


        // perform test with two method parameters
        $daySelectElement = FormDateElement::showDaySelect(
                $fieldName, $selectedDay
        );
        $this->assertTag($matcher, $daySelectElement);
    }

    /**
     * test the day select field
     * 
     * @param integer $selectedValue the option value which should be selected
     * @param boolean $useSelectedValueParameter OPTIONAL true if the selected
     * value should be used for calling the function
     * @return void 
     */
    protected function SelectSelectedTesting($selectedValue, $useSelectedValueParameter = false)
    {
        // test case setup
        $fieldName = 'daySelectTest';
        $matcher = array(
            'tag' => 'option',
            'attributes' => array(
                'selected' => 'selected',
                'value' => $selectedValue
            ),
        );

        // perform test
        $daySelectElement = '';
        if ($useSelectedValueParameter == true) {
            $daySelectElement = FormDateElement::showDaySelect(
                $fieldName, $selectedValue
            );
        } else {
            $daySelectElement = FormDateElement::showDaySelect($fieldName);
        }
        $this->assertTag($matcher, $daySelectElement);
    }
    
    /**
     * test the day select field
     * 
     * @return void 
     */
    public function testSelectSelectedDefault()
    {
        $selectedDay = (string) str_pad(date('d'), 2, '0');
        $this->SelectSelectedTesting($selectedDay);
    }
    
    /**
     * test the day select field
     * 
     * @return void 
     */
    public function testSelectSelectedValue()
    {
        $this->SelectSelectedTesting(1, true);
        $this->SelectSelectedTesting(20, true);
        $this->SelectSelectedTesting(31, true);
    }

}