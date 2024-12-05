<?php

// number of xmases
$output = 0;

$file_contents = file_get_contents(__DIR__.'/sample-input.txt');

$rows = explode("\n", $file_contents);

foreach($rows as $idx => $row) {
    $cols = str_split($row);
    $rows[$idx] = $cols;
}

// $dirs = ['left', 'right', 'up', 'down', 'upleft', 'upright', 'downleft', 'downright'];
$dirs = [
    'left' => [-1, 0],
    'right' => [1, 0],
    'up' => [0, -1],
    'down' => [0, 1],
    'upleft' => [-1, -1],
    'upright' => [1, -1],
    'downleft' => [-1, 1],
    'downright' => [1, 1]
];

// var_dump(find_xmases(count($rows[0]) - 2, 0, $dirs['downleft']));
$all_cars = '';

foreach($dirs as $dir) {
    // $start_x = $dir[0] ? 
}

function find_xmases($x, $y, $dir) {
    global $rows;

    $stacks = [];

    foreach($rows as $ri => $row) {
        $stack = '';

        foreach($row as $ci => $col) {
            // $next_letter = $rows[$ci+($y*$dir[1])][$ci+($x*$dir[0])];
            $next_letter = $rows[$y+($ci*$dir[1])][$x+($ci*$dir[0])];
            if($next_letter) {
                $stack .= $next_letter;
            } else {
                break;
            }
        }

        $stacks[] = $stack;
    }

    return $stacks;
}

var_dump($rows);