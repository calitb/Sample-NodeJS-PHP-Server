<?php


define("HTML_FILE", 'TestResults.html');
define('XML_FILE', '.TestResults.xml');
define('PHPUNIT_CONFIG_FILE', './phpunit-internal.xml');

shell_exec('rm -f '.HTML_FILE);
shell_exec('rm -f '.XML_FILE);
shell_exec('./phpunit --configuration '.PHPUNIT_CONFIG_FILE.' .');

$output = xmlToHTML(XML_FILE);
file_put_contents(HTML_FILE, $output);
die($output);



function xmlToHTML($filename) {

  $xml = simplexml_load_file(XML_FILE);
  $RESULTS = @json_decode(@json_encode($xml ),1);

  $output = '';
  $suiteGlobal = $RESULTS['testsuite'];
  $attributes = $suiteGlobal['@attributes'];
  $testsuites = $suiteGlobal['testsuite'];

  // print globals
  // $output.="<h2>Totales</h2>";
  // $output.= json_encode($attributes);

  // print each file
  foreach ($testsuites as $testsuite) {
    $attributes = $testsuite['@attributes'];
    $testcases = $testsuite['testcase'];

    $name = $attributes['name'];
    $tests = $attributes['tests'];
    $assertions = $attributes['assertions'];
    $time = $attributes['time'];
    $errors = $attributes['errors'];
    $failures = $attributes['failures'];
    $skipped = $attributes['skipped'];
    $output.="<h2>$name (tests: $tests, assertions = $assertions, errors = $errors, failures = $failures, skipped = $skipped, time = $time)</h2>";

    foreach ($testcases as $testcase) {
      $attributes = $testcase['@attributes'];
      $failure = $testcase['failure'] ?? null;

      $name = fromCamelCase($attributes['name']);
      $line = $attributes['line'];
      $assertions = $attributes['assertions'];
      $time = $attributes['time'];

      if ($failure) {
        $output.="<h4 class=\"failure\">❌ $name (line: $line, assertions = $assertions, time = $time)</h4>";
        $output.= "<pre>$failure</pre>";
      }
      else {
        $cssClass = $failure ? "failure" : "ok";
        $output.="<h4 class=\"ok\">✓ $name (line: $line, assertions = $assertions, time = $time)</h4>";
      }
    }
  }

  return "<html><head><style>h4 { margin-left: 30px;} pre {margin-left: 100px;} .ok { color: grey; } .failure { color: red; } </style></head><body>$output</body></html>";
}

function fromCamelCase($camelCaseString) {
  $camelCaseString = str_replace('test', '', $camelCaseString);
  $re = '/(?<=[a-z])(?=[A-Z])/x';
  $a = preg_split($re, $camelCaseString);
  return join($a, " " );
}

?>