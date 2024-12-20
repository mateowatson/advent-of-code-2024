<?php
// answer is 1530
$num_loop_causing_obstacles = 0;

$file_contents = file_get_contents(__DIR__.'/input.txt');
$room = explode("\n", $file_contents);
$starting_pos = null;
$guard_pos = null;
$guard_path = null;
$x_dir = null;
$y_dir = null;
$stop = false;

foreach($room as $idx => $col) {
    $room[$idx] = str_split($col);
    if($guard_x_pos = array_search('^', $room[$idx]))
        $starting_pos = [$guard_x_pos, $idx];
}

// $guard_path[] = json_encode($guard_pos);

foreach($room as $r_idx => $row) {
    foreach($row as $c_idx => $col) {
        if($room[$r_idx][$c_idx] !== '.') {
            continue;
        }
        var_dump('----', implode(',',[$c_idx,$r_idx]));

        $room[$r_idx][$c_idx] = '#';
        $guard_pos = $starting_pos;
        $guard_path = [];
        $x_dir = 0;
        $y_dir = -1;
        $stop = false;
        $guard_path[] = implode(',',[...$guard_pos, 'x'.$x_dir.'y'.$y_dir]);
        $count = 0;

        while($stop === false) {
            $guard_pos = get_new_guard_pos();

            $is_looping = false;

            if($guard_pos !== null) {
                $guard_pos_str = implode(',',[...$guard_pos, 'x'.$x_dir.'y'.$y_dir]);
                if($count % 5000 === 0)
                    $is_looping = in_array($guard_pos_str, $guard_path);
            }

            if($guard_pos === null) {
                $stop = true;
            } else if($is_looping) {
                $num_loop_causing_obstacles++;
                $stop = true;
            } else {
                $guard_path[] = $guard_pos_str;
            }

            $count++;
        }

        $room[$r_idx][$c_idx] = '.';
    }
}

var_dump($num_loop_causing_obstacles);

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
    // var_dump($next_space_val);

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
        // return [1,1];
    } else if($next_space_val === '.' || $next_space_val === '^') {
        return $new_guard_pos;
    } else {
        return null;
    }
}