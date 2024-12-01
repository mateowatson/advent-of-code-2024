<?php

// similarity score
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

// $ex_list1 = [3, 4, 2, 1, 3, 3];

// $ex_list2 = [4, 3, 5, 3, 9, 3];

$list2_count_values = array_count_values($list2);

foreach($list1 as $num) {
    if(isset($list2_count_values[$num])) {
        $output += $num * $list2_count_values[$num];
    }
}

var_dump($output);