<?php

// sum of mul function calls
$output = 0;

$file_contents = file_get_contents(__DIR__.'/input.txt');

$found = preg_match_all('/(mul\((\d{1,3}),(\d{1,3})\))|((don\'t\(\))|(do\(\)))/', $file_contents, $mul_calls);

$do = true;

foreach($mul_calls[2] as $idx => $num1) {
    if($mul_calls[4][$idx] === "don't()") {
        $do = false;
    }

    if($mul_calls[4][$idx] === "do()") {
        $do = true;
    }
    
    if($num1 !== '' && $mul_calls[3][$idx] !== '' && $do)
        $output += $num1 * $mul_calls[3][$idx];
}

var_dump($output);