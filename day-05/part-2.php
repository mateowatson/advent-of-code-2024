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

$updates = array_map(function($update) {
    return array_map(function($n) {
        return (int)$n;
    }, $update);
}, $updates);

$rules = array_map(function($rule) {
    return array_map(function($n) {
        return (int)$n;
    }, $rule);
}, $rules);

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
        usort($updates[$ui], function($a, $b) use ($rules) {
            $rule_arr = array_values(array_filter(
                $rules,
                fn($r) => in_array($a, $r) && in_array($b, $r)
            ));

            if(!count($rule_arr[0])) {
                return 0;
            }

            return $a === $rule_arr[0][0] ? -1 : 1;
        });
        
        $output += $updates[$ui][floor(count($update)/2)];
    }
}

var_dump($output); // 4136 too low