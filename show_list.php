<?php

/**
 * @version     show_list.php 2012-01-06
 * @package     MyBB.Plugins
 * @subpackage  AwayList
 * @author      Malte Gerth <http://www.malte-gerth.de>
 * @copyright   Copyright (C) Malte Gerth. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
define("IN_MYBB", 1);
define('THIS_SCRIPT', 'show_list.php');
// set to "1" if this page should be hidden on the online list
// default is "0"
define("NO_ONLINE", 0);

require("./global.php");

if (!$pluginsCache) {
    $pluginsCache = $cache->read("plugins");
}

if (array_key_exists('liste', $pluginsCache['active']) &&
    $pluginsCache['active']['liste'] == 'liste') {
    // show the page only if the user is logged in
    if ($mybb->user['uid'] == 0) {
        $errors[] = "Sie sind nicht angemeldet.
            Um die Liste zu betrachten ist dies jedoch notwendig.";

        $content = '<center><img src="' . $mybb->settings['bburl'] .
            '/images/liste/file_broken.png" border="0">
<p class="active">Folgende Fehler sind aufgetreten:</p>
<ul style="list-style-image:url(' . $mybb->settings['bburl'] .
            '/images/liste/messagebox_warning.png); align:center;
                list-style-position:outside;">';

        // add every error to the displayed list
        foreach ($errors as $error) {
            $content .= '<li style="align:center;">' . $error . '</li>';
        }
        $content .= '</ul><br />
<a href="javascript:history.back()">Zurück <img src="' .
            $mybb->settings['bburl'] . '/images/liste/undo.png" border="0"></a>
</center>';

        eval("\$showListe .= \"" . $templates->get("show_liste") . "\";");
        output_page($showListe);
        exit;
    } else {
        plugin_show_list();
    }
} else {
    eval("\$content = \"" . $templates->get("headerinclude") . "\";");
    eval("\$content .= \"" . $templates->get("header") . "\";");

    add_breadcrumb("Aufenthaltsliste");

    $content .= '<meta http-equiv="refresh" content="10; URL=' . 
    $mybb->settings['bburl'] . '">
<center><img src="' . $mybb->settings['bburl'] . 
        '/images/liste/file_broken.png" border="0">
<p class="active">Folgende Fehler sind aufgetreten:</p>
<ul style="list-style-image:url(' . $mybb->settings['bburl'] .
        '/images/liste/messagebox_warning.png); align:center;
            list-style-position:outside;">';
    $content .= '<li style="align:center;">Das Plugin wurde nicht aktiviert.
        Sie werden in 10 Sekunden auf die Startseite geführt</li>';
    $content .= '</ul><br />
<a href="javascript:history.back()">Zurück <img src="' .
        $mybb->settings['bburl'] . '/images/liste/undo.png" border="0"></a>
</center>';

    eval("\$content .= \"" . $templates->get("footer") . "\";");

    output_page($content);
}