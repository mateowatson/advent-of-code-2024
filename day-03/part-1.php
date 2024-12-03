<?php

// sum of mul function calls
$output = 0;

$file_contents = file_get_contents(__DIR__.'/input.txt');

$found = preg_match_all('/mul\((\d{1,3}),(\d{1,3})\)/', $file_contents, $mul_calls);

foreach($mul_calls[1] as $idx => $num1) {
    $output += $num1 * $mul_calls[2][$idx];
}

var_dump($output);