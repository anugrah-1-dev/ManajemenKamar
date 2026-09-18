<?php
$c = file_get_contents('routes/web.php');
preg_match_all('/name\(\'([^\']+)\'\)/', $c, $m);
$counts = array_count_values($m[1]);
foreach($counts as $name => $count) {
    if($count > 1) echo "$name ($count times)\n";
}
