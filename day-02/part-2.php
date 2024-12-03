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
    if(num_unsafe_levels($report) === 0) {
        $output++;
    } else {
        $at_least_one_safe = false;
        for($idx = 0; $idx < count($report); $idx++) {
            $report2 = [...$report];
            array_splice($report2, $idx, 1);
            if(num_unsafe_levels($report2) === 0) {
                $at_least_one_safe = true;
                break;
            }
        }
        if($at_least_one_safe) {
            $output++;
        }
    }
}

function num_unsafe_levels($report) {
    $num_not_safe = 0;
    $is_increasing = $report[0] < $report[1];

    for($idx = 1; $idx < count($report); $idx++) {
        $num = $report[$idx];
        $prev_num = $report[$idx - 1];
        $is_num_increasing = $prev_num < $num;
        $diff = abs($prev_num - $num);

        if($is_num_increasing === $is_increasing && ($diff > 0 && $diff < 4)) {
        } else {
            $num_not_safe++;
        }
    }

    return $num_not_safe;
}

var_dump($output);