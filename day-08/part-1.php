<?php

$file_contents = file_get_contents(__DIR__.'/sample-input.txt');

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
            abs($antenna2['x'] - $antenna1['x']),
            abs($antenna2['y'] - $antenna1['y'])
        ];
        $antinode1val = get_point($antinode1['x'],$antinode1['y']);

        var_dump('-------',$antinode1,$antinode1val,'======',$antenna1,$antenna2);
    }
}

function get_point($x, $y) {
    global $rows;
    if(isset($rows[$y], $rows[$y][$x]))
        return $rows[$y][$x];
    return null;
}