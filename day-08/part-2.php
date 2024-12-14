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

        $antinode1_items = [
            [$antenna1['x'], $antenna1['y']],
            [
                $antenna1['x'] + $antenna1['x'] - $antenna2['x'],
                $antenna1['y'] + $antenna1['y'] - $antenna2['y']
            ]
        ];

        $antinode1_items_stop_search = false;

        $count = 1;

        while($antinode1_items_stop_search === false) {
            $antinode1 = [
                $antinode1_items[$count][0] + $antinode1_items[$count][0] - $antinode1_items[$count-1][0],
                $antinode1_items[$count][1] + $antinode1_items[$count][1] - $antinode1_items[$count-1][1]
            ];

            $antinode1val = get_point($antinode1[0],$antinode1[1]);

            if($antinode1val === null) {
                $antinode1_items_stop_search = true;
            } else {
                $antinode_points[] = implode(',',$antinode1);
                $antinode1_items[] = $antinode1;
            }

            $count++;
        }

        $antinode2_items = [
            [$antenna2['x'], $antenna2['y']],
            [
                $antenna2['x'] + $antenna2['x'] - $antenna1['x'],
                $antenna2['y'] + $antenna2['y'] - $antenna1['y']
            ]
        ];

        $antinode2_items_stop_search = false;

        $count = 1;

        while($antinode2_items_stop_search === false) {
            $antinode2 = [
                $antinode2_items[$count][0] + $antinode2_items[$count][0] - $antinode2_items[$count-1][0],
                $antinode2_items[$count][1] + $antinode2_items[$count][1] - $antinode2_items[$count-1][1]
            ];

            $antinode2val = get_point($antinode2[0],$antinode2[1]);

            if($antinode2val === null) {
                $antinode2_items_stop_search = true;
            } else {
                $antinode_points[] = implode(',',$antinode2);
                $antinode2_items[] = $antinode2;
            }

            $count++;
        }
    }
}

var_dump($antinode_points);
var_dump(count(array_unique($antinode_points)));

function get_point($x, $y) {
    global $rows;
    if(isset($rows[$y], $rows[$y][$x]))
        return $rows[$y][$x];
    return null;
}