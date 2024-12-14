<?php

$file_contents = file_get_contents(__DIR__.'/input.txt');

$rows = explode("\n", $file_contents);

foreach($rows as $idx => $cols) {
    $rows[$idx] = str_split($cols);
}

$antinode_points = [];

$antennas = [];

foreach($rows as $ri => $cols) {
    foreach($cols as $ci => $col) {
        if($col !== '.') {
            $antennas[] = [
                'char' => $col,
                'x' => $ci,
                'y' => $ri,
            ];
        }
    }
}

foreach($antennas as $ai1 => $antenna1) {
    foreach($antennas as $ai2 => $antenna2) {
        if($ai2 <= $ai1) continue; 
        if($antenna1['char'] !== $antenna2['char']) continue;

        $antinode1 = [
            $antenna1['x'] + $antenna1['x'] - $antenna2['x'],
            $antenna1['y'] + $antenna1['y'] - $antenna2['y']
        ];

        $antinode2 = [
            $antenna2['x'] + $antenna2['x'] - $antenna1['x'],
            $antenna2['y'] + $antenna2['y'] - $antenna1['y']
        ];

        $antinode1val = get_point($antinode1[0],$antinode1[1]);

        $antinode2val = get_point($antinode2[0],$antinode2[1]);

        if($antinode1val !== null) {
            $antinode_points[] = implode(',',$antinode1);
        }

        if($antinode2val !== null) {
            $antinode_points[] = implode(',',$antinode2);
        }
    }
}

var_dump(count(array_unique($antinode_points)));

function get_point($x, $y) {
    global $rows;
    if(isset($rows[$y], $rows[$y][$x]))
        return $rows[$y][$x];
    return null;
}