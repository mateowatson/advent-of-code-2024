<?php

$output = 0;

$file_contents = file_get_contents(__DIR__.'/input.txt');

$lines = explode("\n", $file_contents);

$list1 = [];

$list2 = [];

foreach($lines as $line) {
    $nums = explode('   ', $line);
    $list1[] = (int)$nums[0];
    $list2[] = (int)$nums[1];
}

sort($list1);

sort($list2);

foreach($list1 as $idx => $num) {
    $output += abs($num - $list2[$idx]);
}

var_dump($output);