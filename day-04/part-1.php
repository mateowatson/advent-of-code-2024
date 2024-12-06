<?php

// number of xmases
$output = 0;

$file_contents = file_get_contents(__DIR__.'/input.txt');

$rows = explode("\n", $file_contents);

foreach($rows as $idx => $row) {
    $cols = str_split($row);
    $rows[$idx] = $cols;
}

$to_rights = [];
$to_right_downs = [];
$to_left_downs = [];
$to_downs = [];

foreach($rows as $y => $row) {
    $to_rights[$y] = [];

    foreach($row as $x => $char) {
        $to_downs[$x][] = $char;
        $to_left_downs[$x + $y][] = $char;
        $to_right_downs[$y - $x][] = $char;
    }
}

$groups = [$to_right_downs, $to_downs, $to_right_downs, $to_left_downs];

foreach($groups as $lines) {
    foreach($lines as $line) {
        $str_line = implode('',$line);
        $str_line_reverse = implode('',array_reverse($line));

        if(stristr($str_line, 'XMAS')) {
            $output++;
        }

        if(stristr($str_line_reverse, 'XMAS')) {
            $output++;
        }
    }
}

var_dump($output);