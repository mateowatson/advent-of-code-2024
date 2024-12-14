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
                $antinode1_items[] = $antinode1;
            }

            $count++;
        }

        foreach($antinode1_items as $i => $item) {
            if($i === 0) continue;
            $antinode_points[] = implode(',',$item);
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
                $antinode2_items[] = $antinode2;
            }

            $count++;
        }

        foreach($antinode2_items as $i => $item) {
            if($i === 0) continue;
            $antinode_points[] = implode(',',$item);
        }
            
    }
}

foreach($antinode_points as $pt) {
    $point = explode(',',$pt);
    if($rows[intval($point[1])][intval($point[0])] === '.')
        $rows[intval($point[1])][intval($point[0])] = '#';
}
$string = '';
foreach($rows as $cols) {
    $string .= implode(' ', $cols) . "\n";
}

preg_match_all('/#|\d|[A-Z]|[a-z]/',$string, $matches);
var_dump(count($matches[0]));

function get_point($x, $y) {
    global $rows;
    if(isset($rows[$y], $rows[$y][$x]))
        return $rows[$y][$x];
    return null;
}