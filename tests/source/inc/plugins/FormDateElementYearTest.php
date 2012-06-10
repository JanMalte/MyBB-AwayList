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
include_once APPLICATION_PATH . '/inc/plugins/awaylist.php';

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
class FormDateElementYearTest extends PHPUnit_Framework_TestCase
{

    /**
     * test the day select field
     * 
     * @expectedException PHPUnit_Framework_Error
     * @return void 
     */
    public function testSelectError()
    {
        FormDateElement::showYearSelect();
    }

    /**
     * test the day select field
     * 
     * @param string $fieldName name of the select field
     * @return void 
     */
    public function testSelectFieldName($fieldName = 'yearSelectTest')
    {
        // tag matcher configuration
        $matcher = array(
            'tag' => 'select',
            'attributes' => array('name' => $fieldName),
            'children' => array(
                'less_than' => 7,
                'greater_than' => 5,
                'only' => array('tag' => 'option')
            )
        );

        // get the select element
        $daySelectElement = FormDateElement::showYearSelect(
                $fieldName, null, -5, 5
        );

        // check the assertation
        $this->assertTag($matcher, $daySelectElement);
        
        // get the select element
        $daySelectElement = FormDateElement::showYearSelect(
                $fieldName, null, -200, 5
        );

        // check the assertation
        $this->assertTag($matcher, $daySelectElement);
    }
    
    /**
     * test the day select field
     * 
     * @return void 
     */
    public function testNegativeCountParam()
    {
        // tag matcher configuration
        $fieldName = 'yearSelectTest';
        $matcher = array(
            'tag' => 'select',
            'attributes' => array('name' => $fieldName),
            'children' => array(
                'less_than' => 3,
                'greater_than' => 1,
                'only' => array('tag' => 'option')
            )
        );

        // get the select element
        $selectElement = FormDateElement::showYearSelect(
                $fieldName, null, -5, -100
        );

        // check the assertation
        $this->assertTag($matcher, $selectElement);
    }

    /**
     * test the day select field
     * 
     * @return void 
     */
    public function testSelectFieldNameTwo()
    {
        $this->testSelectFieldName('year-select-element');
    }

    /**
     * test the day select field
     * 
     * @return void 
     */
    public function testSelectFieldNameThree()
    {
        $this->testSelectFieldName('year_select_element');
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
        $fieldName = 'yearSelectTest';
        $matcher = array(
            'tag' => 'select',
            'children' => array(
                'only' => array('tag' => 'option')
            )
        );

        // perform test with one method parameter
        $daySelectElement = FormDateElement::showYearSelect($fieldName);
        $this->assertTag($matcher, $daySelectElement);


        // perform test with two method parameters
        $daySelectElement = FormDateElement::showYearSelect(
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
    protected function SelectSelectedTesting($selectedValue,
        $useSelectedValueParameter = false)
    {
        // test case setup
        $fieldName = 'yearSelectTest';
        $matcher = array(
            'tag' => 'option',
            'attributes' => array(
                'selected' => 'selected',
                'value' => $selectedValue
            ),
        );

        // perform test
        $selectElement = '';
        if ($useSelectedValueParameter == true) {
            $selectElement = FormDateElement::showYearSelect(
                    $fieldName, $selectedValue
            );
        } else {
            $selectElement = FormDateElement::showYearSelect($fieldName);
        }
        $this->assertTag(
            $matcher, $selectElement,
            'The select element does not contain the selected value "' .
            $selectedValue . '" as selected'
        );
    }

    /**
     * test the day select field
     * 
     * @return void 
     */
    public function testSelectSelectedDefault()
    {
        $selectedYear = date('Y');
        $this->SelectSelectedTesting($selectedYear);
    }

    /**
     * test the day select field
     * 
     * @return void 
     */
    public function testSelectSelectedValue()
    {
        $selectedYear = date('Y') + 1;
        $this->SelectSelectedTesting($selectedYear, true);
    }

}