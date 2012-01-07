<?php

/**
 * Test class using bare selenese test Cases
 *
 * @package SeleniumTests
 * @subpackage SeleneseTests
 */

class SeleneseTests extends PHPUnit_Extensions_SeleniumTestCase
{

	public static $browsers = array(
	array(
		'name'    => 'Opera Browser',
		'browser' => '*opera',
		'host'    => 'localhost',
		'port'    => 6666,
		'timeout' => 300000,
	));

	#protected $captureScreenshotOnFailure = TRUE;
    #protected $screenshotPath = '/srv/www/contao/system/modules/veloticker/build/logs/selenium/screenshots';
    #protected $screenshotUrl = 'http://contao.local/system/modules/veloticker/build/logs/selenium/screenshots';
	
	protected function setUp()
	{
		$this->setBrowserUrl('http://mybb16.local/');
	}

	public static $seleneseDirectory = 'tests-selenium/selenium/selenese';
}
?>