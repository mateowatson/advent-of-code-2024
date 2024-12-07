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
        $first = array_search($rule[0], $updates[$ui]);
        $second = array_search($rule[1], $updates[$ui]);

        if($first === false || $second === false) continue;

        if($first > $second) {
            $is_correct = false;
            $first_num = $updates[$ui][$first];
            $second_num = $updates[$ui][$second];
            // remove num that should be second
            array_splice($updates[$ui], $second, 1);
            // put it right after num that should be first
            array_splice($updates[$ui], $first+1, 0, $second_num);
        }
    }

    if(!$is_correct) {
        var_dump(implode(',',$updates[$ui]));
        $output += $updates[$ui][floor(count($updates[$ui])/2)];
    }
}

// $updates = array_values(array_filter($updates, fn($update) => $update !== ''));

// foreach($updates as $ui => $update) {

// }

var_dump($output);

$arr = [97,13,75,29,47];
// remove num that should be first
array_splice($arr, 1, 1);
// put it right before num that should be second
array_splice($arr, 0, 0, 13);

// var_dump($arr);