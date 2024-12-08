<?php

$output = 0;

$file_contents = file_get_contents(__DIR__.'/input.txt');

$room = explode("\n", $file_contents);

$guard_pos = null;

$guard_path = [];

$x_dir = 0;

$y_dir = -1;

$stop = false;

foreach($room as $idx => $col) {
    $room[$idx] = str_split($col);
    if($guard_x_pos = array_search('^', $room[$idx]))
        $guard_pos = [$guard_x_pos, $idx];
}

$guard_path[] = json_encode($guard_pos);


while($stop === false) {

    $guard_pos = get_new_guard_pos();

    if($guard_pos === null) {
        $stop = true;
    } else {
        $guard_path[] = json_encode($guard_pos);
    }
}

var_dump(count(array_unique($guard_path)));

function get_space_val($x, $y) {
    global $room;
    if(isset($room[$y], $room[$y][$x]))
        return $room[$y][$x];
    return null;
}

function get_new_guard_pos() {
    global $guard_pos;
    global $x_dir;
    global $y_dir;

    $new_guard_pos = [$guard_pos[0]+$x_dir, $guard_pos[1]+$y_dir];

    $next_space_val = get_space_val($new_guard_pos[0], $new_guard_pos[1]);

    if($next_space_val === '#') {
        if($y_dir === -1) {
            $y_dir = 0;
            $x_dir = 1;
        } else if($y_dir === 1) {
            $y_dir = 0;
            $x_dir = -1;
        } else if($x_dir === -1) {
            $y_dir = -1;
            $x_dir = 0;
        } else if($x_dir === 1) {
            $y_dir = 1;
            $x_dir = 0;
        }

        return get_new_guard_pos();
    } else if($next_space_val === '.' || $next_space_val === '^') {
        return $new_guard_pos;
    } else {
        return null;
    }
}