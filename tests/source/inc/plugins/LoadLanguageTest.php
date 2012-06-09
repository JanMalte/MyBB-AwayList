<?php
/**
 * load language test
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
 * load language test
 * 
 * @category    MyBB.Plugins
 * @package     AwayList
 * @subpackage  Tests
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */
class LoadLanguageTest extends PHPUnit_Framework_TestCase
{

    /**
     * test loading of language
     * 
     * @return void 
     */
    public function testLoadLanguage()
    {
        $language = AwayList::loadLanguage();
        $this->assertNotEmpty($language);
        $this->assertInstanceOf('MyLanguage', $language);
    }

}