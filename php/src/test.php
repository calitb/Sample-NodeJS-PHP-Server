<?php

$output = shell_exec('./phpunit --configuration ./phpunit-internal.xml  .');
$results = file_get_contents('./.TestResults.html');

?>

<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
</head>
<body>

<table style="width:100%;">
  <tr style="width:50%">
    <th>Results</th>
    <th>Summary</th> 
  </tr>
  <tr style="width:50%">
    <td><?php echo "<pre>$output</pre>"; ?></td>
    <td><?php echo $results;?></td> 
  </tr>
</table>

</body>
</html>