<?php
/**
 * @category 
 * @package 
 * @subpackage 
 * @copyright Copyright (c) 2012 METEOS Deutschland (www.meteos.de)
 * @license 
 * @author Malte Gerth <malte.gerth@meteos.de>
 * @link http://www.meteos.de/
 * @since 
 */

define('APPLICATION_PATH', '/srv/www/mybb/mybb16');

// Ensure the include_path is correct
set_include_path(
    implode(
        PATH_SEPARATOR,
        array(
            realpath(APPLICATION_PATH),
            get_include_path(),
        )
    )
);