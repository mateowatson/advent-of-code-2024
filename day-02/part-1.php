<?php

// number of safe reports
$output = 0;

$file_contents = file_get_contents(__DIR__.'/input.txt');

$lines = explode("\n", $file_contents);

$reports = [];

foreach($lines as $line) {
    $nums = explode(' ', $line);
    $reports[] = array_map('intval',$nums);
}

foreach($reports as $report) {
    $is_safe = true;
    $is_increasing = $report[0] < $report[1];

    for($idx = 1; $idx < count($report); $idx++) {
        $num = $report[$idx];
        $prev_num = $report[$idx - 1];
        $is_num_increasing = $prev_num < $num;
        $diff = abs($prev_num - $num);

        if($is_num_increasing === $is_increasing && ($diff > 0 && $diff < 4)) {
        } else {
            $is_safe = false;
            break;
        }
        
    }

    if($is_safe)
        $output++;
}

var_dump($output);