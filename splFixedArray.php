<?php
$size = 100000;
$format = 'Time spent of %s(%d) is : %f seconds.</br>';

$spl_arr = new splFixedArray($size);
for ($i = 0; $i < $size; $i++) {
    $spl_arr[$i] = $i;
}

$php_arr = array();
for ($i = 0; $i < $size; $i++) {
    $php_arr[$i] = $i;
}

$start_time = microtime(true);
foreach($spl_arr as $value){}
$end_time = microtime(true);
printf($format, "splFixedArray", $size, $end_time-$start_time);
$start_time = microtime(true);
foreach($php_arr as $value){}
$end_time = microtime(true);
printf($format, "phpArray", $size, $end_time-$start_time);
