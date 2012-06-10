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
include_once APPLICATION_PATH.'/inc/plugins/awaylist.php';

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
class FormDateElementMonthTest extends PHPUnit_Framework_TestCase
{

    /**
     * test the day select field
     * 
     * @expectedException PHPUnit_Framework_Error
     * @return void 
     */
    public function testSelectError()
    {
        FormDateElement::showMonthSelect();
    }

    /**
     * test the day select field
     * 
     * @param string $fieldName name of the select field
     * @return void 
     */
    public function testSelectFieldName($fieldName = 'monthSelectTest')
    {
        // tag matcher configuration
        $matcher = array(
            'tag' => 'select',
            'attributes' => array('name' => $fieldName),
            'children' => array(
                'less_than' => 13,
                'greater_than' => 11,
                'only' => array('tag' => 'option')
            )
        );
        
        // get the select element
        $daySelectElement = FormDateElement::showMonthSelect($fieldName);
        
        // check the assertation
        $this->assertTag($matcher, $daySelectElement);
    }
    
    /**
     * test the day select field
     * 
     * @return void 
     */
    public function testSelectFieldNameTwo() {
        $this->testSelectFieldName('month-select-element');
    }
    
    /**
     * test the day select field
     * 
     * @return void 
     */
    public function testSelectFieldNameThree() {
        $this->testSelectFieldName('month_select_element');
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
        $fieldName = 'monthSelectTest';
        $matcher = array(
            'tag' => 'select',
            'children' => array(
                'less_than' => 13,
                'greater_than' => 11,
                'only' => array('tag' => 'option')
            )
        );
        
        // perform test with one method parameter
        $daySelectElement = FormDateElement::showMonthSelect($fieldName);
        $this->assertTag($matcher, $daySelectElement);


        // perform test with two method parameters
        $daySelectElement = FormDateElement::showMonthSelect(
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
        $fieldName = 'monthSelectTest';
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
            $daySelectElement = FormDateElement::showMonthSelect(
                $fieldName, $selectedValue
            );
        } else {
            $daySelectElement = FormDateElement::showMonthSelect($fieldName);
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
        $selectedMonth = (string) str_pad(date('m'), 2, '0');
        $this->SelectSelectedTesting($selectedMonth);
    }
    
    /**
     * test the day select field
     * 
     * @return void 
     */
    public function testSelectSelectedValue()
    {
        $this->SelectSelectedTesting(1, true);
        $this->SelectSelectedTesting(6, true);
        $this->SelectSelectedTesting(10, true);
        $this->SelectSelectedTesting(12, true);
    }

}