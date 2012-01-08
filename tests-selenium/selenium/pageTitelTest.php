<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

/**
 * Description of newSeleneseTest
 *
 * @author janmalte
 */
class pageTitelTest extends PHPUnit_Extensions_SeleniumTestCase
{

    /**
     *
     * @var Array browser configuration for selenium tests
     */
    public static $browsers = array(
        array(
            'name' => 'Firefox Browser',
            'browser' => '*firefox',
            'host' => 'localhost',
            'port' => 6666,
            'timeout' => 300000,
        )
    );
    
    function setUp()
    {
        #$this->setBrowser("*chrome");
        $this->setBrowserUrl('http://mybb16.local/');
    }

    function testPageTitel()
    {
        $this->open("/");
        $this->assertEquals('MyBB Plugins',$this->getTitle());
    }

}