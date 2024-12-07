<?php

// sum of middle numbers of correct reports
$output = 0;

$file_contents = file_get_contents(__DIR__.'/input.txt');

$rows = explode("\n", $file_contents);

$rules = array_reduce($rows, function($array, $row) {
    if(stristr($row, '|')) {
        $array[] = explode('|', $row);
    }

    return $array;
}, []);

$updates = array_reduce($rows, function($array, $row) {
    if(stristr($row, ',')) {
        $array[] = explode(',', $row);
    }

    return $array;
}, []);

foreach($updates as $ui => $update) {
    $is_correct = true;
    
    foreach($rules as $ri => $rule) {
        $first = array_search($rule[0], $update);
        $second = array_search($rule[1], $update);

        if($first === false || $second === false) continue;

        if($first > $second) {
            $is_correct = false;
        }
    }

    if($is_correct) {
        $output += $update[floor(count($update)/2)];
    }
}

var_dump($output);