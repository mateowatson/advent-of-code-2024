<?php

// sum of middle numbers of correct reports
$output = 0;

$file_contents = file_get_contents(__DIR__.'/sample-input.txt');

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

    if(!$is_correct) {
        foreach($rules as $ri => $rule) {
            $first = array_search($rule[0], $updates[$ui]);
            $second = array_search($rule[1], $updates[$ui]);

            if($first === false || $second === false) continue;

            if($first > $second) {
                $second_num = array_splice($updates[$ui], $second, 1)[0];
                array_splice($updates[$ui], $first, 0, $second_num);
            }
        }

        var_dump(implode(',',$updates[$ui]));
        $output += $updates[$ui][floor(count($update)/2)];
    }
}

var_dump($output);