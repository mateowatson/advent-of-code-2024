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
    $the_rule = null;
    
    foreach($rules as $ri => $rule) {
        $first = array_search($rule[0], $updates[$ui]);
        $second = array_search($rule[1], $updates[$ui]);

        if($first === false || $second === false) continue;

        if($first > $second) {
            $is_correct = false;
            $the_rule = $rule;
        }
    }

    if(!$is_correct) {
        usort($updates[$ui], function($num1, $num2) use ($the_rule) {
            if(!in_array($num1, $the_rule) || !in_array($num2, $the_rule)) {
                return 0;
            }
            return $the_rule[0] === $num1 ? -1 : 1;
        });
        $output += $updates[$ui][floor(count($update)/2)];
    }
}

var_dump($output); // 4136 too low