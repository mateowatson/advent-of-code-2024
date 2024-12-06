<?php

// number of xmases
$output = 0;

$file_contents = file_get_contents(__DIR__.'/input.txt');

$rows = explode("\n", $file_contents);

foreach($rows as $idx => $row) {
    $cols = str_split($row);
    $rows[$idx] = $cols;
}

foreach($rows as $y => $row) {
    foreach($row as $x => $char) {
        if(
            $char === 'A'
            && ((
                $rows[$y - 1][$x - 1] === 'M'
                && $rows[$y - 1][$x + 1] === 'M'
                && $rows[$y + 1][$x - 1] === 'S'
                && $rows[$y + 1][$x + 1] === 'S'
            )
            || (
                $rows[$y - 1][$x - 1] === 'S'
                && $rows[$y - 1][$x + 1] === 'S'
                && $rows[$y + 1][$x - 1] === 'M'
                && $rows[$y + 1][$x + 1] === 'M'
            )
            || (
                $rows[$y - 1][$x - 1] === 'M'
                && $rows[$y - 1][$x + 1] === 'S'
                && $rows[$y + 1][$x - 1] === 'M'
                && $rows[$y + 1][$x + 1] === 'S'
            )
            || (
                $rows[$y - 1][$x - 1] === 'S'
                && $rows[$y - 1][$x + 1] === 'M'
                && $rows[$y + 1][$x - 1] === 'S'
                && $rows[$y + 1][$x + 1] === 'M'
            ))
        ) {
            $output++;
        }
    }
}

var_dump($output);