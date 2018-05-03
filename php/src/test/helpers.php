<?php

function xmlToHTML($filename) {

  $xml = simplexml_load_file(dirname(__FILE__)."/$filename");
  $RESULTS = @json_decode(@json_encode($xml ),1);

  $output = '';
  $suiteGlobal = $RESULTS['testsuite'];
  $attributes = $suiteGlobal['@attributes'];
  $testsuites = $suiteGlobal['testsuite'];

  // print globals
  // $output.="<h2>Totales</h2>";
  // $output.= json_encode($attributes);

  // print each file
  
  $testsuites = isset($testsuites['@attributes']) ? [$testsuites] : $testsuites;
  foreach ($testsuites as $testsuite) {
    $output.=processTestsuite($testsuite);
  }

  return "<html><head><style>h4 { margin-top: 0; margin-bottom: 0; margin-left: 30px;} pre {margin-left: 100px;} .ok { color: grey; } .failure { color: red; } </style></head><body>$output</body></html>";
}

function processTestsuite($testsuite) {
  $output = '';
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

  $testcases = isset($testcases['@attributes']) ? [$testcases] : $testcases;
  foreach ($testcases as $testcase) {
    $attributes = $testcase['@attributes'];
    $failure = $testcase['failure'] ?? null;
    $error = $testcase['error'] ?? null;

    $name = fromCamelCase($attributes['name']);
    $line = $attributes['line'];
    $assertions = $attributes['assertions'];
    $time = $attributes['time'];

    if ($failure) {
      $output.="<h4 class=\"failure\">❌ $name (line: $line, assertions = $assertions, time = $time)</h4>";
      $output.= "<pre>$failure</pre>";
    }
    else if ($error) {
      $output.="<h4 class=\"failure\">❌❌❌ $name (line: $line, assertions = $assertions, time = $time)</h4>";
      $output.= "<pre>$error</pre>";
    }
    else {
      $cssClass = $failure ? "failure" : "ok";
      $output.="<h4 class=\"ok\">✓ $name (line: $line, assertions = $assertions, time = $time)</h4>";
    }
  }

  return $output;
}

function fromCamelCase($camelCaseString) {
  $camelCaseString = str_replace('test', '', $camelCaseString);
  $re = '/(?<=[a-z])(?=[A-Z])/x';
  $a = preg_split($re, $camelCaseString);
  return join($a, " " );
}

function basic_curl($url) {
  $ch = curl_init($url);
  curl_setopt ($ch, CURLOPT_FRESH_CONNECT, true);
  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
  $res = curl_exec($ch);
  curl_close($ch);

  return $res;
}

function assertResponseVSConfig($testobj, $config_name, $input, $data) {
  $config_path = dirname(__FILE__)."/../services/$config_name/config.json";
  $config = json_decode(file_get_contents($config_path), true);

  if (isset($config[C_PARAMS_OUTPUT])) {
      foreach ($config[C_PARAMS_OUTPUT] as $param_output) {
          $testobj->assertArrayHasKey($param_output, $data);
          $testobj->assertEquals($data[$param_output], $input[$param_output]);
      }
  }
  if (isset($config[C_ADDITIONAL_KEYS])) {
      foreach ($config[C_ADDITIONAL_KEYS] as $response_additional_key) {
          $testobj->assertArrayHasKey($response_additional_key,$data);
      }
  }

  $objects = $config[C_SPLITS] ?? $config[C_JSON];
  foreach ($objects as $obj) {
      if (!isset($obj[C_IGNORE])) {
        $testobj->assertArrayHasKey($obj[C_FIELD],$data);
        $type = $obj[C_TYPE] ?? null;
        $value = $data[$obj[C_FIELD]];
        if ($type) {
          if ($type == C_TYPE_MONEY) {
            $testobj->assertRegexp("/[-]?[0-9]+\\.[0-9]{2}/", $value);
          }
          else if ($type == C_TYPE_DATETIME) {
            // 16/04/2018 06:13 PM
            $testobj->assertEquals(strlen($value), 19);
          }
          else if ($type == C_TYPE_DATE) {
            // 16/04/2018
            $testobj->assertEquals(strlen($value), 10);
          }
        }
      }
  }
}

?>
