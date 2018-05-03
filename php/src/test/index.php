<?php

require_once 'helpers.php';

define("HTML_FILE", 'outputs/TestResults.html');
define('XML_FILE', 'outputs/TestResults.xml');
define('PHPUNIT_CONFIG_FILE', './phpunit-internal.xml');

shell_exec('rm -f '.HTML_FILE);
shell_exec('rm -f '.XML_FILE);
$res = shell_exec('./phpunit --configuration '.PHPUNIT_CONFIG_FILE.' ../.');

$output = xmlToHTML(XML_FILE);
file_put_contents(HTML_FILE, $output);
die($output);

?>